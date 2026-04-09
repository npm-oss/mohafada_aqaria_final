<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsRequest extends Model
{
    use HasFactory;

    // لو اسم الجدول مختلف عن convention
       protected $table = 'documents_requests';

    protected $fillable = [ // 👈 هذا يسمح بحفظ جميع الحقول
  'applicant_type',
  'owner_type',
        'type', 
        'request_type',
            'status',           // personal / corporate
        'card_type',
        'applicant_nin',
        'applicant_lastname',
        'applicant_firstname',
        'applicant_father',
        'applicant_phone',
        'applicant_email',
       
        'owner_nin',
        'owner_lastname',
        'owner_firstname',
        'owner_father',
        'owner_birthdate',
        'owner_birthplace',
       
        'property_status',
    'section',
    'municipality',
    'plan_number',
    'parcel_number',
    'municipality_ns',
    'subdivision_number',
    'parcel_number_ns',
    ];

    // لو حابة تعملي casting للتواريخ
    protected $casts = [
        'owner_birthdate' => 'date',
    ];
}
