<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trip_programs', function (Blueprint $table) {
            // First drop foreign key constraints
            $table->dropForeign(['company_id']);
            $table->dropForeign(['guide_id']);
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['agency_id']);

            // Then drop the columns
            $table->dropColumn([
                'company_id',
                'guide_id',
                'vehicle_id',
                'total_adults',
                'total_infants',
                'total_children',
                'agency_id'
            ]);

            // Add organizer_id if it doesn't exist
            if (!Schema::hasColumn('trip_programs', 'organizer_id')) {
                $table->foreignId('organizer_id')->nullable()->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down()
    {
        Schema::table('trip_programs', function (Blueprint $table) {
            // Drop the new column first
            $table->dropForeign(['organizer_id']);
            $table->dropColumn('organizer_id');

            // Recreate the old columns with their foreign keys
            $table->foreignId('company_id')->nullable()->constrained('agencies')->nullOnDelete();
            $table->foreignId('guide_id')->nullable()->constrained('guides')->nullOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
            $table->integer('total_adults')->default(0);
            $table->integer('total_infants')->default(0);
            $table->integer('total_children')->default(0);
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->nullOnDelete();
        });
    }
};
