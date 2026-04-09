<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, boolean, number, json, file
            $table->string('group')->default('general'); // general, contact, email, etc.
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            // General
            ['key' => 'site_name', 'value' => 'المحافظة العقارية - أولاد جلال', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'نظام متكامل لإدارة الأراضي والملكيات العقارية', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_keywords', 'value' => 'محافظة عقارية, أولاد جلال, شهادة سلبية', 'type' => 'text', 'group' => 'general'],
            
            // Contact
            ['key' => 'contact_email', 'value' => 'info@conservation.dz', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+213 XXX XXX XXX', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'أولاد جلال، الجزائر', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'working_hours', 'value' => 'من السبت إلى الخميس: 8:00 صباحاً - 4:00 مساءً', 'type' => 'text', 'group' => 'contact'],
            
            // Social Media
            ['key' => 'social_facebook', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_whatsapp', 'value' => '', 'type' => 'text', 'group' => 'social'],
            
            // System
            ['key' => 'site_active', 'value' => '1', 'type' => 'boolean', 'group' => 'system'],
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'system'],
            ['key' => 'primary_color', 'value' => '#1a5632', 'type' => 'text', 'group' => 'system'],
            ['key' => 'secondary_color', 'value' => '#c9a063', 'type' => 'text', 'group' => 'system'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};