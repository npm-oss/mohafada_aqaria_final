<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;

    protected $table = 'user_requests'; // ✅ اسم الجدول عندك

    protected $fillable = [
        'user_id',
        'type',
        'status',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(RealEstateClient::class, 'user_id');
    }
}