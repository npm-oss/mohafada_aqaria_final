<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandProperty extends Model
{
    use HasFactory;

    protected $table = 'land_properties';

    protected $fillable = [
        'owner_name',
        'father_name',
        'national_id',
        'birth_date',
        'birth_place',
        'property_type',
        'register_number',
        'section',
        'number',
        'description',
        'location',
        'area'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'area' => 'decimal:2'
    ];
}