<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandRegister extends Model
{
    use HasFactory;

    protected $fillable = [
        'national_id', 'last_name', 'first_name', 'father_name', 'full_name',
        'birth_date', 'phone', 'email', 'wilaya', 'commune', 'applicant_type',
        'property_number', 'register_number', 'property_name', 'property_type',
        'property_address', 'department', 'survey_status',
        'surveyed_commune', 'section', 'parcel_number', 'surveyed_area',
        'non_surveyed_commune', 'subdivision', 'non_surveyed_area',
        'non_surveyed_section', 'non_surveyed_parcel_number', // ← أضيفي هذه الحقول
        'property_group', // ← إذا كنت تحتاجينه
        'request_reason', // ← إذا كنت تحتاجينه
        'request_type', 'status', 'documents', 'admin_notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'surveyed_area' => 'decimal:2',
        'non_surveyed_area' => 'decimal:2',
    ];
}