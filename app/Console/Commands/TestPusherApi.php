<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class TestPusherApi extends Command
{
    protected $signature = 'pusher:test';
    protected $description = 'Test raw Pusher API on public channel';

    public function handle()
    {
        $pusher = new Pusher(
            config('broadcasting.connections.reverb.key'),
            config('broadcasting.connections.reverb.secret'),
            config('broadcasting.connections.reverb.app_id'),
            [
                'host' => config('broadcasting.connections.reverb.options.host'),
                'port' => config('broadcasting.connections.reverb.options.port'),
                'scheme' => config('broadcasting.connections.reverb.options.scheme'),
                'useTLS' => config('broadcasting.connections.reverb.options.useTLS'),
            ]
        );

        try {
            $response = $pusher->trigger('private-App.Models.User.1', '.Illuminate\Notifications\Events\BroadcastNotificationCreated', ['message' => 'Hello Private']);
            $this->info("Pusher private trigger response: " . print_r($response, true));
        } catch (\Exception $e) {
            $this->error("Pusher Exception: " . $e->getMessage());
        }
    }
}
