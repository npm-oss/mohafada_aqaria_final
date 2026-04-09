<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
 'owner_nin','owner_lastname','owner_firstname','owner_father',
 'owner_birthdate','owner_birthplace',
 'property_status','section','municipality','plan_number','parcel_number',
 'municipality_ns','subdivision_number','parcel_number_ns',
 'card_type','card_image','card_image_2'
];

}
