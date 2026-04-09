<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('negative_certificate_searches', function (Blueprint $table) {
            $table->id();
            
            // معلومات المالك
            $table->string('owner_lastname')->collation('utf8mb4_unicode_ci'); // اللقب
            $table->string('owner_firstname')->collation('utf8mb4_unicode_ci'); // الاسم
            $table->string('owner_father')->nullable()->collation('utf8mb4_unicode_ci'); // اسم الأب
            
            // معلومات الميلاد
            $table->date('birth_date')->nullable(); // تاريخ الميلاد
            $table->string('birth_place')->nullable()->collation('utf8mb4_unicode_ci'); // مكان الميلاد
            
            // معلومات العقار
            $table->decimal('area', 15, 2)->nullable(); // المساحة
            $table->string('location')->nullable()->collation('utf8mb4_unicode_ci'); // الموقع
            $table->string('municipality')->nullable()->collation('utf8mb4_unicode_ci'); // البلدية
            $table->string('plot_number')->nullable(); // رقم القطعة
            $table->string('group_number')->nullable(); // رقم المجمع
            $table->string('section')->nullable()->collation('utf8mb4_unicode_ci'); // القسم
            
            // معلومات النشر
            $table->date('publication_date')->nullable(); // تاريخ النشر
            $table->string('publication_number')->nullable(); // رقم النشر
            $table->string('volume')->nullable(); // المجلد
            
            // معلومات إضافية
            $table->string('title')->nullable()->collation('utf8mb4_unicode_ci'); // التسمية
            $table->text('description')->nullable()->collation('utf8mb4_unicode_ci'); // الوصف
            
            $table->timestamps();
            
            // إضافة فهارس للبحث السريع
            $table->index(['owner_lastname', 'owner_firstname', 'owner_father']);
            $table->index('plot_number');
            $table->index('publication_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('negative_certificate_searches');
    }
};
