<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Modify the column to ENUM with a valid default value
            $table->enum('customer_type', ['individual', 'family'])
                  ->default('individual')
                  ->nullable(false)
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Revert the column back to a string
            $table->string('customer_type')->nullable()->change();
        });
    }
};
