<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

  protected $fillable = [
    'user_id',
    // أي حقول موجودة...
    
    // الحقول الجديدة ⭐
    'certificate_type',
    'citizen_name',
    'birth_info',
    'father_name',
    'mother_name',
    'address',
    'request_number',
    'receipt_number',
    'delivery_date',
    'properties_data',
    'notes',
    'status',



];
protected $casts = [
    'delivery_date' => 'date',
    'properties_data' => 'array',  // مهم! تحويل JSON لـ array
];
}