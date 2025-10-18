#!/usr/bin/env php
<?php

// Quick test to verify ordering field is working

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/bootstrap/app.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ProgramFamily;
use Illuminate\Support\Facades\Schema;

echo "=== ORDERING FIELD TEST ===\n\n";

// Check if column exists
echo "1. Checking if 'ordering' column exists in program_families table...\n";
if (Schema::hasColumn('program_families', 'ordering')) {
    echo "   ✅ Column exists!\n\n";
} else {
    echo "   ❌ Column does NOT exist!\n";
    echo "   Run: php artisan migrate\n\n";
    exit(1);
}

// Check if it's in fillable
echo "2. Checking if 'ordering' is in ProgramFamily fillable...\n";
$family = new ProgramFamily();
if (in_array('ordering', $family->getFillable())) {
    echo "   ✅ Field is fillable!\n\n";
} else {
    echo "   ❌ Field is NOT fillable!\n\n";
    exit(1);
}

// Check if we can create/update with ordering
echo "3. Testing if ordering can be saved...\n";
$testFamily = ProgramFamily::first();
if ($testFamily) {
    $originalOrdering = $testFamily->ordering;
    $testFamily->ordering = 999;
    $testFamily->save();
    $testFamily->refresh();

    if ($testFamily->ordering === 999) {
        echo "   ✅ Ordering can be saved!\n";
        // Restore original value
        $testFamily->ordering = $originalOrdering;
        $testFamily->save();
        echo "   ✅ Restored original value\n\n";
    } else {
        echo "   ❌ Ordering was not saved!\n\n";
        exit(1);
    }
} else {
    echo "   ⚠️  No families found to test (this is okay if database is empty)\n\n";
}

// Check validation rules
echo "4. Checking validation rules in controller...\n";
$controllerFile = __DIR__.'/app/Http/Controllers/TripProgramController.php';
$content = file_get_contents($controllerFile);

if (strpos($content, "'families.*.ordering'") !== false) {
    echo "   ✅ Validation rule exists!\n\n";
} else {
    echo "   ❌ Validation rule is MISSING!\n";
    echo "   This is likely why ordering isn't saving.\n\n";
    exit(1);
}

echo "=== ALL TESTS PASSED! ===\n";
echo "The ordering feature should work correctly now.\n";
echo "\nTo verify:\n";
echo "1. Edit a trip program\n";
echo "2. Drag rows to reorder\n";
echo "3. Save the form\n";
echo "4. Reload the page - families should be in the new order\n";
