<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('program_families', function (Blueprint $table) {
            $table->id();

            // Parent program
            $table->foreignId('trip_program_id')
                ->constrained('trip_programs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // Optional linked customer (nullOnDelete behavior)
            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('customers')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            // Unregistered group name / company code (e.g., MASTER / ETS)
            $table->string('group_name')->nullable();

            // Counts
            $table->unsignedInteger('adults')->default(0);
            $table->unsignedInteger('children')->default(0);
            $table->unsignedInteger('infants')->default(0);

            // Hotel (optional, nullOnDelete)
            $table->foreignId('hotel_id')
                ->nullable()
                ->constrained('hotels')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('room_number')->nullable();
            $table->time('pickup_time')->nullable();

            // Activity / Size / Nationality etc.
            $table->string('activity')->nullable();     // SNK / DP / INTRO …
            $table->string('size')->nullable();
            $table->string('nationality')->nullable();

            // Info columns
            $table->string('boat_master')->nullable();
            $table->string('guide_name')->nullable();
            $table->string('transfer_name')->nullable();
            $table->string('transfer_phone')->nullable();

            // Collections (multi-currency)
            $table->decimal('collect_egp', 10, 2)->nullable();
            $table->decimal('collect_usd', 10, 2)->nullable();
            $table->decimal('collect_eur', 10, 2)->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_families');
    }
};
