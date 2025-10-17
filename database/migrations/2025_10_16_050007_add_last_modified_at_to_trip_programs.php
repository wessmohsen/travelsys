<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trip_programs', function (Blueprint $table) {
            if (!Schema::hasColumn('trip_programs', 'last_modified_at')) {
                $table->timestamp('last_modified_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('trip_programs', function (Blueprint $table) {
            $table->dropColumn('last_modified_at');
        });
    }
};
