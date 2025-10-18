<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\ProgramFamily;

$families = ProgramFamily::orderBy('trip_program_id')->orderBy('ordering')->get(['id','trip_program_id','ordering']);

foreach ($families as $family) {
    echo "ID: {$family->id} | Program: {$family->trip_program_id} | Ordering: {$family->ordering}" . PHP_EOL;
}
