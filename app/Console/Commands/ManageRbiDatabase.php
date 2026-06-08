<?php

namespace App\Console\Commands;

use App\Models\Household;
use App\Models\Resident;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Shuchkin\SimpleXLSX;

class ManageRbiDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Supports:
     *  - rbi:manage import {file}            Import CSV file into households/residents
     *  - rbi:manage truncate {--all}         Truncate residents and optionally households
     *  - rbi:manage delete --table=... --where=...  Delete rows from specific table using where clause (simple)
     *  - rbi:manage stats                    Show database statistics (JSON)
     *  - rbi:manage export {file}            Export residents/households to CSV
     *  - rbi:manage search --query=...       Search residents by name, purok, or household_no
     *  - rbi:manage cache-clear              Clear all application caches
     *
     * @var string
     */
    protected $signature = 'rbi:manage
                            {action : import|truncate|delete|stats|export|search|cache-clear}
                            {file? : Path to CSV file for import/export}
                            {--all : When truncating, remove households as well}
                            {--table= : Table name for delete}
                            {--where= : Simple where clause for delete, e.g. "purok_no=3"}
                            {--query= : Search query for search action}
                            {--format=text : Output format: text or json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage RBI data: import CSV, truncate tables, delete rows, view stats, export, or search';

    public function handle()
    {
        $action = $this->argument('action');

        return match ($action) {
            'import' => $this->handleImport(),
            'truncate' => $this->handleTruncate(),
            'delete' => $this->handleDelete(),
            'stats' => $this->handleStats(),
            'export' => $this->handleExport(),
            'search' => $this->handleSearch(),
            'cache-clear' => $this->handleCacheClear(),
            default => $this->handleUnknown($action),
        };
    }

    protected function handleImport()
    {
        $file = $this->argument('file');
        if (! $file) {
            $this->error('Please provide a path to a CSV or XLSX file.');

            return 1;
        }

        if (! file_exists($file)) {
            $this->error("File not found: {$file}");

            return 1;
        }

        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if ($ext === 'xlsx' || $ext === 'xls') {
            return $this->importFromXlsx($file);
        }

        if ($ext === 'csv' || $ext === 'txt') {
            return $this->importFromCsv($file);
        }

        $this->error("Unsupported file type: .{$ext}. Use .csv or .xlsx");

        return 1;
    }

    /**
     * Import from a CSV file.
     */
    protected function importFromCsv(string $file): int
    {
        $this->info('Importing CSV: '.$file);

        $handle = fopen($file, 'r');
        if (! $handle) {
            $this->error('Unable to open file.');

            return 1;
        }

        $header = fgetcsv($handle);
        if (! $header) {
            $this->error('Empty or invalid CSV file.');
            fclose($handle);

            return 1;
        }

        $columns = array_map(fn ($h) => Str::lower(trim($h ?? '')), $header);

        $rows = [];
        while (($row = fgetcsv($handle)) !== false) {
            $rows[] = $row;
        }
        fclose($handle);

        return $this->processImportRows($columns, $rows);
    }

    /**
     * Import from an XLSX file.
     */
    protected function importFromXlsx(string $file): int
    {
        $this->info('Importing XLSX: '.$file);

        $xlsx = SimpleXLSX::parse($file);
        if (! $xlsx) {
            $this->error('Failed to parse XLSX: '.SimpleXLSX::parseError());

            return 1;
        }

        // List available sheets so the user can choose
        $sheetNames = $xlsx->sheetNames();
        if (count($sheetNames) > 1) {
            $this->info('Available sheets:');
            foreach ($sheetNames as $index => $name) {
                $this->line("  [{$index}] {$name}");
            }
            $sheetIndex = $this->ask('Which sheet to import? (number, or "all" for all sheets)', '0');
        } else {
            $sheetIndex = '0';
        }

        $sheetsToImport = [];
        if (strtolower($sheetIndex) === 'all') {
            $sheetsToImport = array_keys($sheetNames);
        } else {
            $sheetsToImport = [(int) $sheetIndex];
        }

        $totalResult = ['rows' => 0, 'residents' => 0, 'households' => 0, 'skipped' => 0];

        foreach ($sheetsToImport as $si) {
            if (! isset($sheetNames[$si])) {
                $this->warn("Sheet index {$si} does not exist, skipping.");

                continue;
            }

            $this->info("Processing sheet: {$sheetNames[$si]}");
            $allRows = $xlsx->rows($si);

            if (empty($allRows)) {
                $this->warn("Sheet '{$sheetNames[$si]}' is empty, skipping.");

                continue;
            }

            // First row is the header
            $header = array_shift($allRows);
            $columns = array_map(fn ($h) => Str::lower(trim((string) ($h ?? ''))), $header);

            $result = $this->processImportRows($columns, $allRows, false);

            // Accumulate totals (processImportRows returns 0 on success)
            // We rely on the output it prints for per-sheet details
        }

        $this->refreshSiteState();

        return 0;
    }

    /**
     * Shared logic to process import rows (from CSV or XLSX).
     *
     * @param  array  $columns  Lowercased header column names
     * @param  array  $rows  Array of row arrays (data only, no header)
     * @param  bool  $refresh  Whether to call refreshSiteState after import
     * @return int 0 on success, 1 on failure
     */
    protected function processImportRows(array $columns, array $rows, bool $refresh = true): int
    {
        $rowCount = 0;
        $householdCount = 0;
        $skippedCount = 0;
        $bar = $this->output->createProgressBar(count($rows));
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $rowCount++;
                $bar->advance();

                // Cast all cell values to strings for consistency
                $row = array_map(fn ($v) => (string) ($v ?? ''), $row);

                // Handle rows with mismatched column count gracefully
                if (count($row) !== count($columns)) {
                    // Pad or trim to match column count
                    if (count($row) < count($columns)) {
                        $row = array_pad($row, count($columns), '');
                    } else {
                        $row = array_slice($row, 0, count($columns));
                    }
                }

                $data = array_combine($columns, $row);

                // Handle household
                $household = null;
                if (! empty($data['household_no'])) {
                    $household = Household::firstOrCreate([
                        'household_no' => $data['household_no'] ?? null,
                    ], [
                        'purok_no' => $data['purok_no'] ?? null,
                        'address' => $data['address'] ?? null,
                    ]);
                    if ($household->wasRecentlyCreated) {
                        $householdCount++;
                    }
                }

                // Handle resident
                if (! empty($data['first_name']) && ! empty($data['last_name'])) {
                    $birthdate = $data['birthdate'] ?? null;
                    $age = null;
                    if ($birthdate) {
                        try {
                            $age = Carbon::parse($birthdate)->age;
                        } catch (\Exception $e) {
                            $age = null;
                        }
                    }

                    Resident::create([
                        'household_id' => $household?->id,
                        'first_name' => $data['first_name'] ?? null,
                        'middle_name' => $data['middle_name'] ?? null,
                        'last_name' => $data['last_name'] ?? null,
                        'extension' => $data['extension'] ?? null,
                        'birthdate' => $birthdate,
                        'age' => $age,
                        'sex' => $data['sex'] ?? null,
                        'civil_status' => $data['civil_status'] ?? null,
                        'citizenship' => $data['citizenship'] ?? null,
                        'mobile_number' => $data['mobile_number'] ?? null,
                        'email_address' => $data['email_address'] ?? null,
                        'relationship_to_head' => $data['relationship_to_head'] ?? null,
                    ]);
                } else {
                    $skippedCount++;
                }
            }

            $bar->finish();
            DB::commit();

            $residentCount = $rowCount - $skippedCount;
            $this->newLine();
            $this->info('Import complete.');
            $this->info("  Rows processed:      {$rowCount}");
            $this->info("  Residents created:   {$residentCount}");
            $this->info("  Households created:  {$householdCount}");
            if ($skippedCount > 0) {
                $this->warn("  Rows skipped:        {$skippedCount}");
            }

            if ($refresh) {
                $this->refreshSiteState();
            }

            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Import failed: '.$e->getMessage());

            return 1;
        }
    }

    protected function handleTruncate()
    {
        $all = $this->option('all');
        $this->warn('This will permanently delete data.');
        if (! $this->confirm('Are you sure you want to continue?')) {
            $this->info('Aborted.');

            return 0;
        }

        DB::beginTransaction();
        try {
            $residentCount = Resident::count();
            Resident::truncate();
            $this->info("Truncated residents table ({$residentCount} records removed).");

            $householdCount = 0;
            if ($all) {
                $householdCount = Household::count();
                Household::truncate();
                $this->info("Truncated households table ({$householdCount} records removed).");
            }

            DB::commit();
            $this->refreshSiteState();

            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Failed to truncate: '.$e->getMessage());

            return 1;
        }
    }

    protected function handleDelete()
    {
        $table = $this->option('table');
        $where = $this->option('where');

        if (! $table || ! $where) {
            $this->error('Please provide --table and --where options, e.g. --table=residents --where="purok_no=3"');

            return 1;
        }

        // Very simple parser: column=value
        if (! str_contains($where, '=')) {
            $this->error('Invalid --where clause. Use column=value');

            return 1;
        }

        [$col, $val] = explode('=', $where, 2);
        $col = trim($col);
        $val = trim($val);

        $this->warn("About to delete rows from {$table} where {$col} = {$val}");
        if (! $this->confirm('Are you sure?')) {
            $this->info('Aborted.');

            return 0;
        }

        try {
            $count = DB::table($table)->where($col, $val)->delete();
            $this->info("Deleted {$count} rows from {$table}.");
            $this->refreshSiteState();

            return 0;
        } catch (\Exception $e) {
            $this->error('Delete failed: '.$e->getMessage());

            return 1;
        }
    }

    /**
     * Show database statistics.
     */
    protected function handleStats()
    {
        $format = $this->option('format');

        $totalResidents = Resident::count();
        $totalHouseholds = Household::count();
        $maleCount = Resident::whereRaw("LOWER(sex) = 'male'")->count();
        $femaleCount = Resident::whereRaw("LOWER(sex) = 'female'")->count();

        // Per-purok breakdown via households
        $purokBreakdown = DB::table('residents')
            ->join('households', 'residents.household_id', '=', 'households.id')
            ->select('households.purok_no', DB::raw('COUNT(residents.id) as resident_count'))
            ->groupBy('households.purok_no')
            ->orderBy('households.purok_no')
            ->get()
            ->mapWithKeys(fn ($row) => [$row->purok_no ?? 'Unknown' => $row->resident_count])
            ->toArray();

        $householdBreakdown = Household::select('purok_no', DB::raw('COUNT(*) as count'))
            ->groupBy('purok_no')
            ->orderBy('purok_no')
            ->get()
            ->mapWithKeys(fn ($row) => [$row->purok_no ?? 'Unknown' => $row->count])
            ->toArray();

        // Age breakdown
        $ageGroups = [
            '0-5 (Infant/Toddler)' => Resident::whereBetween('age', [0, 5])->count(),
            '6-12 (Child)' => Resident::whereBetween('age', [6, 12])->count(),
            '13-17 (Teen)' => Resident::whereBetween('age', [13, 17])->count(),
            '18-30 (Young Adult)' => Resident::whereBetween('age', [18, 30])->count(),
            '31-59 (Adult)' => Resident::whereBetween('age', [31, 59])->count(),
            '60+ (Senior)' => Resident::where('age', '>=', 60)->count(),
            'Unknown' => Resident::whereNull('age')->count(),
        ];

        // Last import timestamp (most recent resident created_at)
        $lastImport = Resident::max('created_at');

        $stats = [
            'total_residents' => $totalResidents,
            'total_households' => $totalHouseholds,
            'male_count' => $maleCount,
            'female_count' => $femaleCount,
            'age_groups' => $ageGroups,
            'residents_by_purok' => $purokBreakdown,
            'households_by_purok' => $householdBreakdown,
            'last_import' => $lastImport,
        ];

        if ($format === 'json') {
            $this->line(json_encode($stats, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return 0;
        }

        // Text format
        $this->info('╔══════════════════════════════════════╗');
        $this->info('║       RBI Database Statistics        ║');
        $this->info('╠══════════════════════════════════════╣');
        $this->info("║  Total Residents:   {$totalResidents}");
        $this->info("║  Total Households:  {$totalHouseholds}");
        $this->info("║  Male:              {$maleCount}");
        $this->info("║  Female:            {$femaleCount}");
        $this->info('║  Last Import:       '.($lastImport ?? 'Never'));
        $this->info('╠══════════════════════════════════════╣');

        $this->info('║  Residents by Purok:');
        foreach ($purokBreakdown as $purok => $count) {
            $this->info("║    Purok {$purok}: {$count}");
        }

        $this->info('║  Age Distribution:');
        foreach ($ageGroups as $group => $count) {
            $this->info("║    {$group}: {$count}");
        }
        $this->info('╚══════════════════════════════════════╝');

        return 0;
    }

    /**
     * Export residents and households to CSV.
     */
    protected function handleExport()
    {
        $file = $this->argument('file');

        // Default to storage/app/exports/ directory
        if (! $file) {
            $dir = storage_path('app/exports');
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $file = $dir.'/rbi_export_'.date('Y-m-d_His').'.csv';
        }

        // Ensure directory exists
        $dir = dirname($file);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $this->info("Exporting to: {$file}");

        $residents = Resident::with('household')->get();

        if ($residents->isEmpty()) {
            $this->warn('No residents to export.');

            return 0;
        }

        $handle = fopen($file, 'w');
        if (! $handle) {
            $this->error("Unable to open file for writing: {$file}");

            return 1;
        }

        // Write header
        $headers = [
            'id', 'household_no', 'purok_no', 'address',
            'first_name', 'middle_name', 'last_name', 'extension',
            'relationship_to_head', 'birthdate', 'age', 'sex',
            'civil_status', 'citizenship', 'mobile_number', 'email_address',
            'occupation', 'income', 'educational_status',
            'registered_national_voter', 'has_philhealth',
        ];
        fputcsv($handle, $headers);

        $bar = $this->output->createProgressBar($residents->count());

        foreach ($residents as $resident) {
            fputcsv($handle, [
                $resident->id,
                $resident->household?->household_no,
                $resident->household?->purok_no,
                $resident->household?->address,
                $resident->first_name,
                $resident->middle_name,
                $resident->last_name,
                $resident->extension,
                $resident->relationship_to_head,
                $resident->birthdate,
                $resident->age,
                $resident->sex,
                $resident->civil_status,
                $resident->citizenship,
                $resident->mobile_number,
                $resident->email_address,
                $resident->occupation,
                $resident->income,
                $resident->educational_status,
                $resident->registered_national_voter,
                $resident->has_philhealth,
            ]);
            $bar->advance();
        }

        $bar->finish();
        fclose($handle);

        $this->newLine();
        $this->info("Exported {$residents->count()} residents to {$file}");

        return 0;
    }

    /**
     * Search residents by name, purok, or household number.
     */
    protected function handleSearch()
    {
        $query = $this->option('query');
        $format = $this->option('format');

        if (! $query) {
            $this->error('Please provide a --query option, e.g. --query="Juan"');

            return 1;
        }

        $results = Resident::with('household')
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'LIKE', "%{$query}%")
                    ->orWhere('last_name', 'LIKE', "%{$query}%")
                    ->orWhere('middle_name', 'LIKE', "%{$query}%")
                    ->orWhereHas('household', function ($hq) use ($query) {
                        $hq->where('household_no', 'LIKE', "%{$query}%")
                            ->orWhere('purok_no', 'LIKE', "%{$query}%");
                    });
            })
            ->limit(50)
            ->get();

        if ($results->isEmpty()) {
            if ($format === 'json') {
                $this->line(json_encode(['results' => [], 'count' => 0]));
            } else {
                $this->warn("No residents found matching: {$query}");
            }

            return 0;
        }

        if ($format === 'json') {
            $data = $results->map(fn ($r) => [
                'id' => $r->id,
                'full_name' => $r->full_name,
                'first_name' => $r->first_name,
                'middle_name' => $r->middle_name,
                'last_name' => $r->last_name,
                'age' => $r->age,
                'sex' => $r->sex,
                'purok_no' => $r->household?->purok_no,
                'household_no' => $r->household?->household_no,
                'address' => $r->household?->address,
            ]);
            $this->line(json_encode(['results' => $data, 'count' => $results->count()], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return 0;
        }

        // Text table format
        $this->info("Found {$results->count()} result(s) for \"{$query}\":\n");

        $tableData = $results->map(fn ($r) => [
            $r->id,
            $r->full_name,
            $r->age ?? '-',
            $r->sex ?? '-',
            $r->household?->purok_no ?? '-',
            $r->household?->household_no ?? '-',
        ])->toArray();

        $this->table(
            ['ID', 'Full Name', 'Age', 'Sex', 'Purok', 'Household #'],
            $tableData
        );

        return 0;
    }

    /**
     * Clear application caches.
     */
    protected function handleCacheClear()
    {
        $this->refreshSiteState();

        return 0;
    }

    /**
     * Handle unknown action.
     */
    protected function handleUnknown($action)
    {
        $this->error("Unknown action: {$action}");
        $this->info('Allowed actions: import, truncate, delete, stats, export, search, cache-clear');

        return 1;
    }

    /**
     * Clear relevant caches and restart queue workers so the site reflects DB changes.
     */
    protected function refreshSiteState()
    {
        try {
            $this->info('Clearing caches and restarting queue workers...');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('config:clear');
            // Restart queue workers so they pick up DB changes
            Artisan::call('queue:restart');
            $this->info('Refresh complete.');
        } catch (\Exception $e) {
            $this->error('Failed to refresh site state: '.$e->getMessage());
        }
    }
}
