<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('land_properties', function (Blueprint $table) {
            $table->id();
            $table->string('owner_name'); // الاسم واللقب
            $table->string('father_name'); // اسم الأب
            $table->string('national_id', 16); // رقم بطاقة التعريف الوطني
            $table->date('birth_date'); // تاريخ الميلاد
            $table->string('birth_place'); // مكان الميلاد
            $table->enum('property_type', ['ممسوح', 'غير ممسوح']); // نوع العقار
            $table->string('register_number'); // رقم الدفتر العقاري
            $table->string('section'); // القسم
            $table->string('number'); // الرقم
            $table->text('description')->nullable(); // وصف العقار
            $table->string('location')->nullable(); // الموقع
            $table->decimal('area', 10, 2)->nullable(); // المساحة
            $table->timestamps();
            
            // Indexes للبحث السريع
            $table->index(['section', 'number']);
            $table->index('national_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('land_properties');
    }
};