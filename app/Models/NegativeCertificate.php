<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegativeCertificate extends Model
{
    use HasFactory;

    protected $table = 'negative_certificates';

    protected $fillable = [
        'user_request_id', // 🔗 الربط مع صندوق الطلبات

        'owner_lastname',
        'owner_firstname',
        'owner_father',
        'owner_birthdate',
        'owner_birthplace',

        'applicant_lastname',
        'applicant_firstname',
        'applicant_father',

        'email',
        'phone',

        'type',
        'status',
    ];



    public function getFullNameAttribute()
{
    return trim(
        ($this->owner_firstname ?? '') . ' ' .
        ($this->owner_lastname ?? '') . ' ' .
        ($this->owner_father ?? '')
    );
}

    // العلاقة مع الطلب
    public function userRequest()
    {
        return $this->belongsTo(UserRequest::class);
    }
}
