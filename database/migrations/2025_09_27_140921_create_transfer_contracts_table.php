<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transfer_contracts', function (Blueprint $table) {
            $table->id();

            // ربط بالعناصر
            $table->foreignId('driver_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('vehicle_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('company_name')->nullable();

            // من / إلى
            $table->string('from');
            $table->string('to');

            // تفاصيل التعاقد
            // $table->decimal('price', 10, 2)->default(0);
            $table->enum('contract_type', ['driver', 'company']); // نوع التعاقد
            $table->date('contract_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active'); // حالة التعاقد

            // ملاحظات إضافية
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transfer_contracts');
    }
};
