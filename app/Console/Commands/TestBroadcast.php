<?php

namespace App\Console\Commands;

use App\Events\TestPusherEvent;
use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Broadcast;

class TestBroadcast extends Command
{
    protected $signature = 'broadcast:test';

    protected $description = 'Test raw broadcasting';

    public function handle()
    {
        $this->info('Broadcasting raw event to private-App.Models.User.1...');

        Broadcast::event(new BroadcastEvent(
            new TestPusherEvent
        ));

        $this->info('Done!');
    }
}
