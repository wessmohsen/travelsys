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
            // Add foreign key columns that don't exist yet
            if (!Schema::hasColumn('program_families', 'transfer_contract_id')) {
                $table->foreignId('transfer_contract_id')->nullable()->constrained('transfer_contracts')->nullOnDelete()->after('guide_name');
            }
            if (!Schema::hasColumn('program_families', 'vehicle_id')) {
                $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete()->after('transfer_contract_id');
            }
            if (!Schema::hasColumn('program_families', 'boat_id')) {
                $table->foreignId('boat_id')->nullable()->constrained('boats')->nullOnDelete()->after('boat_master');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_families', function (Blueprint $table) {
            if (Schema::hasColumn('program_families', 'transfer_contract_id')) {
                $table->dropConstrainedForeignId('transfer_contract_id');
            }
            if (Schema::hasColumn('program_families', 'vehicle_id')) {
                $table->dropConstrainedForeignId('vehicle_id');
            }
            if (Schema::hasColumn('program_families', 'boat_id')) {
                $table->dropConstrainedForeignId('boat_id');
            }
        });
    }
};
