<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('hotels', function (Blueprint $table) {
            if (!Schema::hasColumn('hotels', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active');
            }
            if (!Schema::hasColumn('hotels', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('hotels', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('hotels', 'address')) {
                $table->text('address')->nullable();
            }
            if (!Schema::hasColumn('hotels', 'location_url')) {
                $table->string('location_url')->nullable();
            }
            if (!Schema::hasColumn('hotels', 'location_ordering')) {
                $table->integer('location_ordering')->default(0);
            }
            if (!Schema::hasColumn('hotels', 'website')) {
                $table->string('website')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'description',
                'phone',
                'address',
                'location_url',
                'location_ordering',
                'website'
            ]);
        });
    }
};
