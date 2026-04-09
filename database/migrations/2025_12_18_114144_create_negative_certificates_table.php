<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    public function up(): void{

    // الجدول راه موجود، ما نعاودوش ننشؤوه


        Schema::create('negative_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('owner_firstname');
            $table->string('owner_lastname');
            $table->string('owner_father')->nullable();
            $table->date('owner_birthdate')->nullable();
            $table->string('owner_birthplace')->nullable();

            $table->string('applicant_firstname');
            $table->string('applicant_lastname');
            $table->string('applicant_father')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->enum('status', ['قيد الانتظار', 'مقبول', 'مرفوض'])->default('قيد الانتظار');
            $table->timestamps();
        });
    
}
    public function down(): void
    {
        Schema::dropIfExists('negative_certificates');
    }
};

