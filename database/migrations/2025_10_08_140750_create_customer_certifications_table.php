<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('customer_certifications', function (Blueprint $table) {
            $table->id();

            // polymorphic: certifiable_id + certifiable_type
            $table->morphs('certifiable');

            $table->foreignId('certification_id')->constrained('certifications')->cascadeOnDelete();
            $table->integer('dives_count')->default(0); // عدد الغطسات
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('customer_certifications');
    }
};
