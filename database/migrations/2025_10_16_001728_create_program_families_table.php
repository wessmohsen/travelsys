<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('program_families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_program_id')->constrained('trip_programs')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->string('group_name')->nullable();
            $table->integer('adults')->default(0);
            $table->integer('children')->default(0);
            $table->integer('infants')->default(0);
            $table->foreignId('hotel_id')->nullable()->constrained('hotels')->nullOnDelete();
            $table->string('room_number')->nullable();
            $table->time('pickup_time')->nullable();
            $table->string('activity')->nullable();
            $table->string('size')->nullable();
            $table->string('nationality')->nullable();
            $table->string('boat_master')->nullable();
            $table->string('guide_name')->nullable();
            $table->string('transfer_name')->nullable();
            $table->string('transfer_phone')->nullable();
            $table->decimal('collect_egp', 10, 2)->nullable();
            $table->decimal('collect_usd', 10, 2)->nullable();
            $table->decimal('collect_eur', 10, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('program_families');
    }
};
