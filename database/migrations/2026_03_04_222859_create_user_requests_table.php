<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('type'); // نوع الطلب (شهادة سلبية، بطاقة عقارية، ...)
            $table->string('status')->default('pending'); // حالة الطلب
            $table->json('data')->nullable(); // بيانات الطلب كاملة
            $table->timestamps();
            
            // المفتاح الخارجي
            $table->foreign('user_id')->references('id')->on('real_estate_clients')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_requests');
    }
};