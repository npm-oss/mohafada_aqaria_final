<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('land_registers', function (Blueprint $table) {
            // التحقق من عدم وجود العمود قبل إضافته
            if (!Schema::hasColumn('land_registers', 'full_name')) {
                $table->string('full_name')->nullable()->after('father_name');
            }
            
            if (!Schema::hasColumn('land_registers', 'register_number')) {
                $table->string('register_number')->nullable()->after('property_number');
            }
            
            if (!Schema::hasColumn('land_registers', 'property_area')) {
                $table->decimal('property_area', 10, 2)->nullable()->after('property_name');
            }
            
            if (!Schema::hasColumn('land_registers', 'property_address')) {
                $table->string('property_address', 500)->nullable()->after('property_area');
            }
        });
    }

    public function down(): void
    {
        Schema::table('land_registers', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'register_number', 'property_area', 'property_address']);
        });
    }
};
