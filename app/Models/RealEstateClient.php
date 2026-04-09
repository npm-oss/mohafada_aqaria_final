<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RealEstateClient extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'real_estate_clients';

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone',
        // 'national_id', // اختياري - علق عليه إذا لم تحتاجه
        // 'birth_date', // ❌ محذوف
        // 'address', // ❌ محذوف
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'birth_date' => 'date', // ❌ محذوف
    ];
    // العلاقة مع طلبات المستخدم
public function requests()
{
    return $this->hasMany(UserRequest::class, 'user_id');
}
}