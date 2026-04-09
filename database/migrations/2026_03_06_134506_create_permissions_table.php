<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('permissions', function (Blueprint $table) {
        $table->id();
        $table->string('name');        // اسم الصفحة: "الشهادات السلبية"
        $table->string('key')->unique(); // مفتاح: "certificates"
        $table->string('route');       // المسار: "admin.certificates.index"
        $table->string('icon')->nullable(); // أيقونة للقائمة
        $table->integer('order')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
