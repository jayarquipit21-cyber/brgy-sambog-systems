<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Pusher\Pusher;
use Pusher\PusherException;

class TestPusherApi extends Command
{
    protected $signature = 'pusher:test';
    protected $description = 'Test raw Pusher API with verbose logging';

    public function handle()
    {
        $options = [
            'host' => config('broadcasting.connections.reverb.options.host'),
            'port' => (int) config('broadcasting.connections.reverb.options.port'),
            'scheme' => config('broadcasting.connections.reverb.options.scheme'),
            'useTLS' => config('broadcasting.connections.reverb.options.useTLS'),
            'curl_options' => [
                CURLOPT_TIMEOUT => 5,
                CURLOPT_CONNECTTIMEOUT => 5,
            ],
        ];

        $this->info("Connecting to Reverb at: {$options['scheme']}://{$options['host']}:{$options['port']}");

        $pusher = new Pusher(
            config('broadcasting.connections.reverb.key'),
            config('broadcasting.connections.reverb.secret'),
            config('broadcasting.connections.reverb.app_id'),
            $options
        );

        $pusher->setLogger(new class implements \Psr\Log\LoggerInterface {
            public function log($level, $message, array $context = []): void { echo "[PUSHER] $message\n"; }
            public function emergency($m, array $c = []): void { $this->log('emergency', $m, $c); }
            public function alert($m, array $c = []): void { $this->log('alert', $m, $c); }
            public function critical($m, array $c = []): void { $this->log('critical', $m, $c); }
            public function error($m, array $c = []): void { $this->log('error', $m, $c); }
            public function warning($m, array $c = []): void { $this->log('warning', $m, $c); }
            public function notice($m, array $c = []): void { $this->log('notice', $m, $c); }
            public function info($m, array $c = []): void { $this->log('info', $m, $c); }
            public function debug($m, array $c = []): void { $this->log('debug', $m, $c); }
        });

        try {
            $this->info("Triggering event on private-App.Models.User.1...");
            $response = $pusher->trigger(
                'private-App.Models.User.1',
                'test_event',
                ['message' => 'Hello Private Event']
            );
            $this->info("Response: " . json_encode($response));
        } catch (PusherException $e) {
            $this->error("PusherException: " . $e->getMessage());
        } catch (\Exception $e) {
            $this->error("Exception: " . $e->getMessage());
            $this->error("Trace: " . $e->getTraceAsString());
        }
    }
}
