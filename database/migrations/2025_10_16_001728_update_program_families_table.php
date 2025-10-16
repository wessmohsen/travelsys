<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('program_families', function (Blueprint $table) {
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->nullOnDelete()->after('customer_id');
        });
    }

    public function down(): void {
        Schema::table('program_families', function (Blueprint $table) {
            $table->dropConstrainedForeignId('agency_id');
        });
    }
};
