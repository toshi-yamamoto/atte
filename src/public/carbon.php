<?php
require '../vendor/autoload.php';

use Carbon\Carbon;

$dt = Carbon::now();
// echo $dt->toDateString();
echo $dt->toTimeString();