<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('customer_files', function (Blueprint $table) {
            $table->id();

            // polymorphic: fileable_id + fileable_type (Customer أو SubCustomer)
            $table->morphs('fileable');

            $table->string('file_path');    // المسار داخل storage/app/public مثلاً
            $table->string('file_type')->nullable(); // image/pdf/...
            $table->string('original_name')->nullable(); // الاسم الأصلي للملف
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('customer_files');
    }
};
