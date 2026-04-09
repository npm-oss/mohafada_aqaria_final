<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            
            // بيانات المرسل
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20)->nullable();
            
            // محتوى الرسالة
            $table->enum('subject', ['inquiry', 'complaint', 'suggestion', 'support', 'other'])->default('other');
            $table->text('message');
            
            // حالة الرسالة
            $table->enum('status', ['new', 'read', 'replied', 'closed'])->default('new');
            
            // معلومات إضافية
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            
            // الرد
            $table->text('reply_message')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->unsignedBigInteger('replied_by')->nullable();
            
            // ملاحظات الإدارة
            $table->text('admin_notes')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes لتحسين الأداء
            $table->index('email');
            $table->index('status');
            $table->index('subject');
            $table->index('created_at');
            $table->index('replied_at');
            
            // Foreign Keys
            $table->foreign('replied_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};