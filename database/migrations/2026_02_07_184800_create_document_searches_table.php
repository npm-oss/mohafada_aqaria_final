<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_searches', function (Blueprint $table) {
            $table->id();
            
            // معلومات الوثيقة للبحث
            $table->string('volume_number');
            $table->string('publication_number');
            $table->date('publication_date')->nullable();
            
            // نوع الوثيقة
            $table->string('document_type');
            
            // معلومات الشخص (الخص)
            $table->string('person_nin')->nullable();
            $table->string('person_lastname');
            $table->string('person_firstname');
            $table->string('person_father');
            $table->date('person_birthdate')->nullable();
            $table->string('person_birthplace')->nullable();
            
            // صور الوثيقة
            $table->string('document_front_image')->nullable();
            $table->string('document_back_image')->nullable();
            
            // ملاحظات
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // فهارس للبحث السريع - تسمية يدوية قصيرة
            $table->index('volume_number', 'idx_volume');
            $table->index('publication_number', 'idx_pub');
            $table->index('person_nin', 'idx_nin');
            $table->index('person_lastname', 'idx_lname');
            $table->index('person_firstname', 'idx_fname');
            $table->index('person_father', 'idx_father');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_searches');
    }
};