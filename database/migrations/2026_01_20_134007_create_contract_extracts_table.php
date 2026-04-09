<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractExtractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('contract_extracts', function (Blueprint $table) {
        $table->id();

        // نوع المستخرج
        $table->string('extract_type');

        // معلومات مقدم الطلب
        $table->string('applicant_nin')->nullable();
        $table->string('applicant_lastname');
        $table->string('applicant_firstname');
        $table->string('applicant_father');
        $table->string('applicant_email')->nullable();
        $table->string('applicant_phone')->nullable();

        // معلومات الوثيقة
        $table->string('volume_number');
        $table->string('publication_number');
        $table->date('publication_date')->nullable();

        // حالة الطلب
        $table->string('status')->default('قيد المعالجة');

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
        Schema::dropIfExists('contract_extracts');
    }
}