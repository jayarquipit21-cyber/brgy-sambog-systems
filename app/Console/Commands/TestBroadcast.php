<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Broadcast;

class TestBroadcast extends Command
{
    protected $signature = 'broadcast:test';
    protected $description = 'Test raw broadcasting';

    public function handle()
    {
        $this->info('Broadcasting raw event to private-App.Models.User.1...');
        
        Broadcast::event(new \Illuminate\Broadcasting\BroadcastEvent(
            new \App\Events\TestPusherEvent()
        ));

        $this->info('Done!');
    }
}
