<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ContractExtract extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contract_extracts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'extract_type',          // نوع المستخرج: original, copy
        'applicant_nin',         // رقم التعريف الوطني
        'applicant_lastname',    // اللقب
        'applicant_firstname',   // الاسم
        'applicant_father',      // اسم الأب
        'applicant_email',       // البريد الإلكتروني
        'applicant_phone',       // رقم الهاتف
        'volume_number',         // رقم المجلد
        'publication_number',    // رقم النشر
        'publication_date',      // تاريخ النشر
        'status',                // الحالة: قيد المعالجة، مقبول، مرفوض
        'processed_at',          // تاريخ المعالجة
        'processed_by',          // معالج بواسطة (user_id)
        'rejection_reason',      // سبب الرفض
        'notes',                 // ملاحظات
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'publication_date' => 'date',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // حقول حساسة إذا موجودة
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_name',
        'status_label',
        'type_label',
    ];

    // ═══════════════════════════════════════════════════════════
    // Relationships
    // ═══════════════════════════════════════════════════════════

    /**
     * Get the user who processed this extract.
     */
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // ═══════════════════════════════════════════════════════════
    // Accessors & Mutators
    // ═══════════════════════════════════════════════════════════

    /**
     * Get the applicant's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->applicant_firstname} {$this->applicant_lastname}");
    }

    /**
     * Get the status label in Arabic.
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        switch($this->status) {
            case 'قيد المعالجة':
                return '⏳ قيد المعالجة';
            case 'مقبول':
                return '✅ مقبول';
            case 'مرفوض':
                return '❌ مرفوض';
            case 'pending':
                return '⏳ قيد الانتظار';
            case 'approved':
                return '✅ موافق';
            case 'rejected':
                return '❌ مرفوض';
            default:
                return $this->status ?? '-';
        }
    }

    /**
     * Get the extract type label in Arabic.
     *
     * @return string
     */
    public function getTypeLabelAttribute()
    {
        switch($this->extract_type) {
            case 'original':
                return '📄 نسخة أصلية';
            case 'copy':
                return '📑 نسخة طبق الأصل';
            case 'certified_copy':
                return '📋 نسخة مصادق عليها';
            default:
                return $this->extract_type ?? '-';
        }
    }

    /**
     * Get formatted publication date.
     *
     * @return string
     */
    public function getFormattedPublicationDateAttribute()
    {
        return $this->publication_date 
            ? $this->publication_date->format('Y/m/d') 
            : '-';
    }

    /**
     * Get days since request.
     *
     * @return int
     */
    public function getDaysSinceRequestAttribute()
    {
        return $this->created_at->diffInDays(now());
    }

    // ═══════════════════════════════════════════════════════════
    // Scopes
    // ═══════════════════════════════════════════════════════════

    /**
     * Scope a query to only include pending extracts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'قيد المعالجة')
                    ->orWhere('status', 'pending');
    }

    /**
     * Scope a query to only include approved extracts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'مقبول')
                    ->orWhere('status', 'approved');
    }

    /**
     * Scope a query to only include rejected extracts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'مرفوض')
                    ->orWhere('status', 'rejected');
    }

    /**
     * Scope a query to filter by extract type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('extract_type', $type);
    }

    /**
     * Scope a query to search by applicant name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('applicant_firstname', 'like', "%{$search}%")
              ->orWhere('applicant_lastname', 'like', "%{$search}%")
              ->orWhere('applicant_nin', 'like', "%{$search}%")
              ->orWhere('volume_number', 'like', "%{$search}%")
              ->orWhere('publication_number', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to filter by volume number.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $volumeNumber
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByVolume($query, $volumeNumber)
    {
        return $query->where('volume_number', $volumeNumber);
    }

    /**
     * Scope a query to filter by publication number.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $publicationNumber
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPublication($query, $publicationNumber)
    {
        return $query->where('publication_number', $publicationNumber);
    }

    /**
     * Scope a query to get recent extracts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope a query to get old unprocessed extracts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOldUnprocessed($query, $days = 30)
    {
        return $query->pending()
                    ->where('created_at', '<=', now()->subDays($days));
    }

    // ═══════════════════════════════════════════════════════════
    // Methods
    // ═══════════════════════════════════════════════════════════

    /**
     * Mark the extract as approved.
     *
     * @param  int|null  $userId
     * @return bool
     */
    public function approve($userId = null)
    {
        return $this->update([
            'status' => 'مقبول',
            'processed_at' => now(),
            'processed_by' => $userId ?? auth()->id(),
            'rejection_reason' => null,
        ]);
    }

    /**
     * Mark the extract as rejected.
     *
     * @param  string|null  $reason
     * @param  int|null  $userId
     * @return bool
     */
    public function reject($reason = null, $userId = null)
    {
        return $this->update([
            'status' => 'مرفوض',
            'processed_at' => now(),
            'processed_by' => $userId ?? auth()->id(),
            'rejection_reason' => $reason,
        ]);
    }

    /**
     * Check if extract is pending.
     *
     * @return bool
     */
    public function isPending()
    {
        return in_array($this->status, ['قيد المعالجة', 'pending']);
    }

    /**
     * Check if extract is approved.
     *
     * @return bool
     */
    public function isApproved()
    {
        return in_array($this->status, ['مقبول', 'approved']);
    }

    /**
     * Check if extract is rejected.
     *
     * @return bool
     */
    public function isRejected()
    {
        return in_array($this->status, ['مرفوض', 'rejected']);
    }

    /**
     * Get status color for UI.
     *
     * @return string
     */
    public function getStatusColor()
    {
        switch($this->status) {
            case 'قيد المعالجة':
            case 'pending':
                return '#ffc107';
            case 'مقبول':
            case 'approved':
                return '#28a745';
            case 'مرفوض':
            case 'rejected':
                return '#dc3545';
            default:
                return '#6c757d';
        }
    }

    /**
     * Get status badge HTML.
     *
     * @return string
     */
    public function getStatusBadge()
    {
        $color = $this->getStatusColor();
        $label = $this->status_label;
        
        return "<span style='background: {$color}20; color: {$color}; padding: 0.4rem 1rem; border-radius: 20px; font-weight: 600;'>{$label}</span>";
    }

    // ═══════════════════════════════════════════════════════════
    // Boot Method
    // ═══════════════════════════════════════════════════════════

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Set default status on creation
        static::creating(function ($extract) {
            if (empty($extract->status)) {
                $extract->status = 'قيد المعالجة';
            }
        });

        // Log status changes
        static::updating(function ($extract) {
            if ($extract->isDirty('status')) {
                // يمكن إضافة logging هنا
                // Log::info('Extract status changed', [
                //     'extract_id' => $extract->id,
                //     'old_status' => $extract->getOriginal('status'),
                //     'new_status' => $extract->status,
                // ]);
            }
        });
    }
}