<?php

use Carbon\Carbon;

require 'vendor/autoload.php';

Carbon::setTestNow('2027-01-01');

$c = Carbon::parse('2027-03-15');
echo 'dayOfWeekIso: '.$c->dayOfWeekIso.PHP_EOL;
echo 'format N: '.$c->format('N').PHP_EOL;
echo 'format l: '.$c->format('l').PHP_EOL;
echo 'isSaturday: '.($c->isSaturday() ? 'yes' : 'no').PHP_EOL;
echo 'isSunday: '.($c->isSunday() ? 'yes' : 'no').PHP_EOL;
echo PHP_EOL;

// Also test empty string
$c2 = Carbon::parse('');
echo 'Empty string parse:'.PHP_EOL;
echo 'dayOfWeekIso: '.$c2->dayOfWeekIso.PHP_EOL;
echo 'format l: '.$c2->format('l').PHP_EOL;
