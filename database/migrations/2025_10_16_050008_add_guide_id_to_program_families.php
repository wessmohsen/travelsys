<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('program_families', function (Blueprint $table) {
            if (!Schema::hasColumn('program_families', 'guide_id')) {
                $table->foreignId('guide_id')->nullable()->constrained('guides')->nullOnDelete();
            }
        });
    }

    public function down()
    {
        Schema::table('program_families', function (Blueprint $table) {
            $table->dropForeign(['guide_id']);
            $table->dropColumn('guide_id');
        });
    }
};
