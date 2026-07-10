<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DispatchTestNotification extends Command
{
    protected $signature = 'notify:test {userId?}';
    protected $description = 'Dispatch a test notification to a user';

    public function handle()
    {
        $userId = $this->argument('userId');
        
        $user = $userId ? User::find($userId) : User::first();
        
        if (!$user) {
            $this->error('No user found to notify.');
            return;
        }

        try {
            $this->info("Sending notification to user: {$user->email} (ID: {$user->id})");
            $this->info("Broadcast connection: " . config('broadcasting.default'));
            $this->info("Reverb host: " . config('broadcasting.connections.reverb.options.host'));
            $this->info("Reverb port: " . config('broadcasting.connections.reverb.options.port'));

            $user->notify(new SystemNotification(
                'Test Real-time Notification', 
                'This is a real-time notification sent from the terminal.',
                'bell',
                route('dashboard')
            ));
            
            $this->info("Test notification dispatched to user: {$user->email}");
        } catch (\Exception $e) {
            $this->error("Exception: " . $e->getMessage());
            $this->error("File: " . $e->getFile() . ':' . $e->getLine());
            Log::error('notify:test error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }
}
