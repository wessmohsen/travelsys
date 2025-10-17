<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            if (!Schema::hasColumn('drivers', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('drivers', 'alternative_phone')) {
                $table->string('alternative_phone')->nullable();
            }
            if (!Schema::hasColumn('drivers', 'address')) {
                $table->text('address')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn(['phone', 'alternative_phone', 'address']);
        });
    }
};
