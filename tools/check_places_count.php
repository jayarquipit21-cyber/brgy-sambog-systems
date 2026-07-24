<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

echo DB::table('places')->count().PHP_EOL;
