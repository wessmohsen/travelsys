<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('location_url')->nullable();
            $table->integer('location_ordering')->default(0);
            $table->string('website')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
        });
    }

    public function down()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'description',
                'address',
                'location_url',
                'location_ordering',
                'website',
                'status'
            ]);
        });
    }
};
