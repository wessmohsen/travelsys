<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sub_customers', function (Blueprint $table) {
            $table->id();

            // ارتباط بالكاستومر الرئيسي
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();

            // التصنيف داخل العائلة
            $table->enum('relation_type', ['adult', 'child', 'infant']); // بالغ/طفل/رضيع
            $table->string('responsible_name')->nullable(); // اسم المسئول عن الطفل/الرضيع

            // البيانات الشخصية
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('nationality')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // بيانات جواز السفر
            $table->string('passport_number')->nullable();
            $table->string('passport_nationality')->nullable();
            $table->date('passport_valid_until')->nullable();

            // بيانات الغوص والإقامة
            $table->text('languages')->nullable();
            $table->date('dive_center_checkin')->nullable();
            $table->date('dive_center_checkout')->nullable();
            $table->date('next_flight_date')->nullable();
            $table->boolean('vegetarian')->default(false);

            // ربط الفندق + رقم الغرفة
            $table->foreignId('hotel_id')->nullable()->constrained('hotels')->nullOnDelete();
            $table->string('room_number')->nullable();

            // العنوان
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('country')->nullable();

            // ملاحظات
            $table->text('additional_info')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('sub_customers');
    }
};
