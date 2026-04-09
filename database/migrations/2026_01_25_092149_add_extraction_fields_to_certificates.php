<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('negative_certificates', function (Blueprint $table) {
            // نوع الشهادة
            if (!Schema::hasColumn('negative_certificates', 'certificate_type')) {
                $table->enum('certificate_type', ['negative', 'positive'])->nullable();
            }
            
            // بيانات المواطن
            if (!Schema::hasColumn('negative_certificates', 'citizen_name')) {
                $table->string('citizen_name')->nullable();
            }
            
            if (!Schema::hasColumn('negative_certificates', 'birth_info')) {
                $table->string('birth_info')->nullable();
            }
            
            if (!Schema::hasColumn('negative_certificates', 'father_name')) {
                $table->string('father_name')->nullable();
            }
            
            if (!Schema::hasColumn('negative_certificates', 'mother_name')) {
                $table->string('mother_name')->nullable();
            }
            
            if (!Schema::hasColumn('negative_certificates', 'address')) {
                $table->text('address')->nullable();
            }
            
            if (!Schema::hasColumn('negative_certificates', 'receipt_number')) {
                $table->string('receipt_number', 50)->nullable();
            }
            
            if (!Schema::hasColumn('negative_certificates', 'delivery_date')) {
                $table->date('delivery_date')->nullable();
            }
            
            if (!Schema::hasColumn('negative_certificates', 'properties_data')) {
                $table->json('properties_data')->nullable();
            }
            
            if (!Schema::hasColumn('negative_certificates', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('negative_certificates', function (Blueprint $table) {
            $table->dropColumn([
                'certificate_type',
                'citizen_name',
                'birth_info',
                'father_name',
                'mother_name',
                'address',
                'receipt_number',
                'delivery_date',
                'properties_data',
                'notes',
            ]);
        });
    }
};