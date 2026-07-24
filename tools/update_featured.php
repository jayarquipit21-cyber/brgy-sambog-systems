<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

DB::table('places')->update(['is_featured' => 1]);
echo 'featured_count:'.DB::table('places')->where('is_featured', 1)->count().PHP_EOL;
