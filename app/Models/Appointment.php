<?php

// app/Models/Appointment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname', 
        'email',
        'phone',
        'user_id',
        'booking_date',
        'service_type',
        'notes',
        'status',
        'confirmation_message',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    // ✅ العلاقة مع المستخدم (إذا كان مسجلاً)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ دالة للاسم الكامل
    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    // ✅ دالة للحصول على الإيميل (من المستخدم أو من الحقل المباشر)
    public function getDisplayEmailAttribute()
    {
        return $this->user ? $this->user->email : $this->email;
    }

    // ✅ دالة للحصول على الهاتف
    public function getDisplayPhoneAttribute()
    {
        return $this->user ? $this->user->phone : $this->phone;
    }
}