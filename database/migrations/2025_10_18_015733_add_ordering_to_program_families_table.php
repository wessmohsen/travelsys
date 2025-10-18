<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('program_families', function (Blueprint $table) {
            $table->integer('ordering')->default(0)->after('trip_program_id');
            $table->index('ordering');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_families', function (Blueprint $table) {
            $table->dropIndex(['ordering']);
            $table->dropColumn('ordering');
        });
    }
};
