<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if foreign key exists and drop it
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'program_families'
            AND COLUMN_NAME = 'customer_id'
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (!empty($foreignKeys)) {
            Schema::table('program_families', function (Blueprint $table) {
                $table->dropForeign(['customer_id']);
            });
        }

        // Add a temporary column for JSON data
        Schema::table('program_families', function (Blueprint $table) {
            $table->json('customer_id_json')->nullable()->after('customer_id');
        });

        // Convert existing data to JSON array format in the temporary column
        DB::statement("
            UPDATE program_families
            SET customer_id_json = CASE
                WHEN customer_id IS NOT NULL THEN JSON_ARRAY(customer_id)
                ELSE NULL
            END
        ");

        // Drop the old column and rename the new one
        Schema::table('program_families', function (Blueprint $table) {
            $table->dropColumn('customer_id');
        });

        Schema::table('program_families', function (Blueprint $table) {
            $table->renameColumn('customer_id_json', 'customer_id');
        });
    }    public function down(): void
    {
        // Convert JSON back to integer (take first element)
        DB::statement("
            UPDATE program_families
            SET customer_id = CASE
                WHEN customer_id IS NOT NULL THEN JSON_EXTRACT(customer_id, '$[0]')
                ELSE NULL
            END
        ");

        // Change back to foreignId
        Schema::table('program_families', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable()->change();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }
};
