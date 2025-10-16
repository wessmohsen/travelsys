<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('trip_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained('trips')->cascadeOnDelete();
            $table->date('date');
            $table->foreignId('company_id')->constrained('agencies')->cascadeOnDelete();
            $table->foreignId('guide_id')->constrained('guides')->cascadeOnDelete();
            $table->foreignId('boat_id')->constrained('boats')->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->integer('total_adults')->default(0);
            $table->integer('total_children')->default(0);
            $table->integer('total_infants')->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->enum('status', ['draft', 'confirmed', 'done'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('trip_programs');
    }
};
