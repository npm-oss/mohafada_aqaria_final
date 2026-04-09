<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       // database/migrations/xxxx_create_appointments_table.php

Schema::create('appointments', function (Blueprint $table) {
    $table->id();
    
    // ✅ حقول المستخدم المباشرة (للزوار غير المسجلين)
    $table->string('firstname');
    $table->string('lastname');
    $table->string('email');
    $table->string('phone');
    
    // ✅ أو ربط بالمستخدم المسجل (اختياري)
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
    
    $table->date('booking_date');
    $table->string('service_type');
    $table->text('notes')->nullable();
    $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};