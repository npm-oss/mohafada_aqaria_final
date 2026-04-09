<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('properties', function (Blueprint $table) {
    $table->id();

    // معلومات المالك
    $table->string('owner_nin');
    $table->string('owner_lastname')->nullable();
    $table->string('owner_firstname');
    $table->string('owner_father')->nullable();
    $table->date('owner_birthdate')->nullable();
    $table->string('owner_birthplace')->nullable();

    // معلومات العقار
    $table->string('property_status'); // surveyed / not_surveyed
    $table->string('section')->nullable();
    $table->string('municipality')->nullable();
    $table->string('plan_number')->nullable();
    $table->string('parcel_number')->nullable();
    $table->string('municipality_ns')->nullable();
    $table->string('subdivision_number')->nullable();
    $table->string('parcel_number_ns')->nullable();

    // نوع البطاقة
    $table->string('card_type'); // personal, alphabetical, urban, rural
  $table->string('card_image')->nullable(); 
   $table->string('card_image_2')->nullable(); 
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
        Schema::dropIfExists('properties');
    }
}
