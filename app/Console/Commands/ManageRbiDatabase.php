<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use App\Models\Household;
use App\Models\Resident;

class ManageRbiDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Supports:
     *  - rbi:manage import {file}            Import CSV file into households/residents
     *  - rbi:manage truncate {--all}         Truncate residents and optionally households
     *  - rbi:manage delete --table=... --where=...  Delete rows from specific table using where clause (simple)
     *
     * @var string
     */
    protected $signature = 'rbi:manage
                            {action : import|truncate|delete}
                            {file? : Path to CSV file for import}
                            {--all : When truncating, remove households as well}
                            {--table= : Table name for delete}
                            {--where= : Simple where clause for delete, e.g. "purok_no=3"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage RBI data: import CSV, truncate tables, or delete rows';

    public function handle()
    {
        $action = $this->argument('action');

        if ($action === 'import') {
            return $this->handleImport();
        }

        if ($action === 'truncate') {
            return $this->handleTruncate();
        }

        if ($action === 'delete') {
            return $this->handleDelete();
        }

        $this->error('Unknown action. Allowed: import, truncate, delete');
        return 1;
    }

    protected function handleImport()
    {
        $file = $this->argument('file');
        if (! $file) {
            $this->error('Please provide a path to a CSV file.');
            return 1;
        }

        if (! file_exists($file)) {
            $this->error("File not found: {$file}");
            return 1;
        }

        $this->info('Importing CSV: ' . $file);

        $handle = fopen($file, 'r');
        if (! $handle) {
            $this->error('Unable to open file.');
            return 1;
        }

        $header = fgetcsv($handle);
        if (! $header) {
            $this->error('Empty or invalid CSV file.');
            return 1;
        }

        $columns = array_map(fn($h) => Str::lower(trim($h)), $header);

        $rowCount = 0;
        $bar = $this->output->createProgressBar();
        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                $rowCount++;
                $bar->advance();
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
                }

                // Handle resident
                if (! empty($data['first_name']) && ! empty($data['last_name'])) {
                    $birthdate = $data['birthdate'] ?? null;
                    $age = null;
                    if ($birthdate) {
                        try { $age = \Carbon\Carbon::parse($birthdate)->age; } catch (\Exception $e) { $age = null; }
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
                }
            }

            $bar->finish();
            DB::commit();
            fclose($handle);
            $this->info("\nImported {$rowCount} rows.");
            $this->refreshSiteState();
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            $this->error('Import failed: ' . $e->getMessage());
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
            Resident::truncate();
            $this->info('Truncated residents table.');
            if ($all) {
                Household::truncate();
                $this->info('Truncated households table.');
            }
            DB::commit();
            $this->refreshSiteState();
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Failed to truncate: ' . $e->getMessage());
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
            $this->error('Delete failed: ' . $e->getMessage());
            return 1;
        }
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
            $this->error('Failed to refresh site state: ' . $e->getMessage());
        }
    }
}
