<?php

use App\Models\User;
use App\Livewire\BookAppointment;
use Livewire\Livewire;

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Create in-memory SQLite db
\Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);

$user = User::factory()->create(['role' => 'resident']);
\Illuminate\Support\Facades\Auth::login($user);

$test = Livewire::test(BookAppointment::class)
    ->set('appointment_date', '2027-03-15')
    ->set('appointment_time', '10:00 AM')
    ->set('purpose', 'Barangay Clearance Request');

// Show component state BEFORE calling book
echo "appointment_date = " . $test->get('appointment_date') . PHP_EOL;
echo "appointment_time = " . $test->get('appointment_time') . PHP_EOL;
echo "purpose = " . $test->get('purpose') . PHP_EOL;

$test->call('book');

echo "Errors: " . print_r($test->errors()->toArray(), true) . PHP_EOL;
