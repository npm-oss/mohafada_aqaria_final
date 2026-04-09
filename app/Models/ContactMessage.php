<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contact_messages';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'ip_address',
        'user_agent',
        'replied_at',
        'reply_message',
        'admin_notes',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $appends = [
        'subject_text',
        'status_text',
        'status_color',
        'subject_icon',
        'status_icon',
    ];

    // ==================== Relationships ====================

    /**
     * المستخدم الذي أرسل الرسالة (إذا كان مسجل)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * المسؤول الذي رد على الرسالة
     */
    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    // ==================== Accessors ====================

    /**
     * الحصول على نص الموضوع بالعربية
     */
    public function getSubjectTextAttribute()
    {
        $subjects = [
            'inquiry' => 'استفسار',
            'complaint' => 'شكوى',
            'suggestion' => 'اقتراح',
            'support' => 'دعم فني',
            'other' => 'أخرى',
        ];
        
        return $subjects[$this->subject] ?? $this->subject;
    }

    /**
     * الحصول على نص الحالة بالعربية
     */
    public function getStatusTextAttribute()
    {
        $statuses = [
            'new' => 'جديدة',
            'read' => 'مقروءة',
            'replied' => 'تم الرد',
            'closed' => 'مغلقة',
        ];
        
        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * الحصول على لون الحالة
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'new' => 'warning',
            'read' => 'info',
            'replied' => 'success',
            'closed' => 'secondary',
        ];
        
        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * الحصول على أيقونة الموضوع
     */
    public function getSubjectIconAttribute()
    {
        $icons = [
            'inquiry' => '💬',
            'complaint' => '⚠️',
            'suggestion' => '💡',
            'support' => '🛟',
            'other' => '📧',
        ];
        
        return $icons[$this->subject] ?? '📧';
    }

    /**
     * الحصول على أيقونة الحالة
     */
    public function getStatusIconAttribute()
    {
        $icons = [
            'new' => '🆕',
            'read' => '👁️',
            'replied' => '✅',
            'closed' => '🔒',
        ];
        
        return $icons[$this->status] ?? '📋';
    }

    /**
     * الحصول على أول حرف من الاسم (للـ Avatar)
     */
    public function getInitialAttribute()
    {
        return strtoupper(substr($this->name, 0, 1));
    }

    /**
     * الحصول على ملخص الرسالة
     */
    public function getMessagePreviewAttribute()
    {
        return \Str::limit($this->message, 150);
    }

    // ==================== Methods ====================

    /**
     * وضع علامة كـ مقروءة
     */
    public function markAsRead()
    {
        if ($this->status === 'new') {
            $this->update(['status' => 'read']);
        }
        
        return $this;
    }

    /**
     * وضع علامة كـ غير مقروءة
     */
    public function markAsUnread()
    {
        $this->update(['status' => 'new']);
        return $this;
    }

    /**
     * وضع علامة كـ تم الرد
     */
    public function markAsReplied($replyMessage = null)
    {
        $this->update([
            'status' => 'replied',
            'reply_message' => $replyMessage ?? $this->reply_message,
            'replied_at' => now(),
        ]);
        
        return $this;
    }

    /**
     * إغلاق الرسالة
     */
    public function close()
    {
        $this->update(['status' => 'closed']);
        return $this;
    }

    /**
     * إعادة فتح الرسالة
     */
    public function reopen()
    {
        $this->update(['status' => 'read']);
        return $this;
    }

    /**
     * التحقق من إمكانية الرد
     */
    public function canReply()
    {
        return !in_array($this->status, ['replied', 'closed']);
    }

    // ==================== Scopes ====================

    /**
     * Scope للرسائل الجديدة
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope للرسائل المقروءة
     */
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    /**
     * Scope للرسائل التي تم الرد عليها
     */
    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    /**
     * Scope للرسائل المغلقة
     */
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    /**
     * Scope للبحث في الرسائل
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('message', 'like', "%{$search}%");
        });
    }

    // ==================== Static Methods ====================

    /**
     * الحصول على عدد الرسائل الجديدة
     */
    public static function getNewCount()
    {
        return static::where('status', 'new')->count();
    }

    /**
     * الحصول على إحصائيات الرسائل
     */
    public static function getStatistics()
    {
        return [
            'total' => static::count(),
            'new' => static::where('status', 'new')->count(),
            'read' => static::where('status', 'read')->count(),
            'replied' => static::where('status', 'replied')->count(),
            'closed' => static::where('status', 'closed')->count(),
            'today' => static::whereDate('created_at', today())->count(),
            'this_week' => static::whereBetween('created_at', [
                now()->startOfWeek(), 
                now()->endOfWeek()
            ])->count(),
            'this_month' => static::whereMonth('created_at', now()->month)->count(),
        ];
    }

    // ==================== Events ====================

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        // تسجيل IP Address تلقائياً عند الإنشاء
        static::creating(function ($message) {
            if (!$message->ip_address) {
                $message->ip_address = request()->ip();
            }
            
            if (!$message->user_agent) {
                $message->user_agent = request()->userAgent();
            }
            
            if (!$message->status) {
                $message->status = 'new';
            }
        });
    }
}
