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
    Schema::create('agencies', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // اسم الشركة
        $table->string('email')->nullable();
        $table->string('phone')->nullable();
        $table->string('tax_number')->nullable();
        $table->boolean('is_partner')->default(false);

        // Address
        $table->string('street')->nullable();
        $table->string('number')->nullable();
        $table->string('zipcode')->nullable();
        $table->string('city')->nullable();
        $table->string('state')->nullable();
        $table->string('country')->nullable();

        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
