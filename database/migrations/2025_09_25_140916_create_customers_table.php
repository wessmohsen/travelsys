<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            // ✅ بيانات أساسية
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();

            // ✅ بيانات الجواز
            $table->string('passport_number')->nullable();
            $table->string('passport_nationality')->nullable();
            $table->date('passport_valid_until')->nullable();

            // ✅ لغات ووجبات وبيانات الغوص
            $table->text('languages')->nullable();
            $table->date('dive_center_checkin')->nullable();
            $table->date('dive_center_checkout')->nullable();
            $table->date('next_flight_date')->nullable();
            $table->boolean('vegetarian')->default(false);

            // ✅ العنوان
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('country')->nullable();
            $table->text('additional_info')->nullable();

            // ✅ الحقول الجديدة
            $table->enum('customer_type', ['individual', 'family'])->default('individual');
            $table->foreignId('hotel_id')->nullable()->constrained('hotels')->onDelete('set null');
            $table->string('room_number')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
