<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentSearch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'volume_number',
        'publication_number',
        'publication_date',
        'document_type',
        'person_nin',
        'person_lastname',
        'person_firstname',
        'person_father',
        'person_birthdate',
        'person_birthplace',
        'document_front_image',
        'document_back_image',
        'notes',
    ];

    protected $casts = [
        'publication_date' => 'date',
        'person_birthdate' => 'date',
    ];

    // Scope للبحث برقم المجلد
    public function scopeByVolume($query, $volume)
    {
        return $query->where('volume_number', 'like', '%' . $volume . '%');
    }

    // Scope للبحث برقم النشر
    public function scopeByPublication($query, $publication)
    {
        return $query->where('publication_number', 'like', '%' . $publication . '%');
    }

    // Scope للبحث برقم الهوية
    public function scopeByNin($query, $nin)
    {
        return $query->where('person_nin', 'like', '%' . $nin . '%');
    }

    // Scope للبحث بالاسم
    public function scopeByName($query, $name)
    {
        return $query->where(function($q) use ($name) {
            $q->where('person_lastname', 'like', '%' . $name . '%')
              ->orWhere('person_firstname', 'like', '%' . $name . '%')
              ->orWhere('person_father', 'like', '%' . $name . '%');
        });
    }

    // Scope للبحث بتاريخ الميلاد
    public function scopeByBirthdate($query, $date)
    {
        return $query->whereDate('person_birthdate', $date);
    }

    // Scope للبحث بمكان الميلاد
    public function scopeByBirthplace($query, $place)
    {
        return $query->where('person_birthplace', 'like', '%' . $place . '%');
    }

    // Scope للبحث بنوع الوثيقة
    public function scopeByType($query, $type)
    {
        return $query->where('document_type', $type);
    }

    // Accessor للاسم الكامل
    public function getFullNameAttribute()
    {
        return "{$this->person_lastname} {$this->person_firstname} بن {$this->person_father}";
    }

    // Accessor للصورة الأمامية
    public function getFrontImageUrlAttribute()
    {
        return $this->document_front_image ? asset('storage/' . $this->document_front_image) : null;
    }

    // Accessor للصورة الخلفية
    public function getBackImageUrlAttribute()
    {
        return $this->document_back_image ? asset('storage/' . $this->document_back_image) : null;
    }
}