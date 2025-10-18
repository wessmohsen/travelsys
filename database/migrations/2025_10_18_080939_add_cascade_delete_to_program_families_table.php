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
            // Drop the existing foreign key if it exists
            $table->dropForeign(['trip_program_id']);

            // Add the foreign key with cascade delete
            $table->foreign('trip_program_id')
                  ->references('id')
                  ->on('trip_programs')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_families', function (Blueprint $table) {
            // Drop the cascade delete foreign key
            $table->dropForeign(['trip_program_id']);

            // Add back the foreign key without cascade delete
            $table->foreign('trip_program_id')
                  ->references('id')
                  ->on('trip_programs');
        });
    }
};
