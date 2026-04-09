<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('land_registers', function (Blueprint $table) {
            $table->id();
            
            // بيانات الطالب
            $table->string('national_id', 18);
            $table->string('last_name');
            $table->string('first_name');
            $table->string('father_name');
            $table->date('birth_date');
            $table->string('phone');
            $table->string('email');
            $table->string('wilaya');
            $table->string('commune');
            $table->string('applicant_type');
            $table->string('property_group')->nullable(); 
            // نوع المسح
            $table->enum('survey_status', ['ممسوح', 'غير ممسوح'])->nullable();
            
            // بيانات العقار الممسوح
            $table->string('surveyed_commune')->nullable();
            $table->string('section')->nullable();
            $table->string('parcel_number')->nullable();
            $table->decimal('surveyed_area', 10, 2)->nullable();
            
            // بيانات العقار الغير ممسوح
            $table->string('non_surveyed_commune')->nullable();
            $table->string('subdivision')->nullable();
            $table->decimal('non_surveyed_area', 10, 2)->nullable();
             $table->string('non_surveyed_section')->nullable();
    $table->string('non_surveyed_parcel_number')->nullable();
            
            // بيانات عامة للعقار
            $table->string('property_type');
            $table->string('request_type')->default('طلب جديد');
            
            // بيانات إضافية (للتوافق مع الكود القديم)
            $table->string('property_number')->nullable();
            $table->string('property_name')->nullable();
            $table->string('property_address')->nullable();
            $table->string('register_number')->nullable();
            
            // الحالة والملاحظات
            $table->enum('status', ['pending', 'processing', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->json('documents')->nullable();
            $table->json('processing_data')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('land_registers');
    }
};