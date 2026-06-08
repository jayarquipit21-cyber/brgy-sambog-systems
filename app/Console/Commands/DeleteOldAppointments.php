<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldAppointments extends Command
{
    protected $signature = 'appointments:cleanup';

    protected $description = 'Delete appointment records with actions done that are older than 2 days';

    public function handle(): int
    {
        $threshold = Carbon::now()->subDays(2);
        $statuses = ['approved', 'completed', 'cancelled'];

        $query = Appointment::whereIn('status', $statuses)
            ->where('updated_at', '<=', $threshold);

        $count = $query->count();
        if ($count === 0) {
            $this->info('No old appointment records to delete.');

            return 0;
        }

        $query->delete();

        $this->info("Deleted {$count} old appointment record(s).");

        return 0;
    }
}
