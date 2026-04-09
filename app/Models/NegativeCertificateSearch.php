<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegativeCertificateSearch extends Model
{
    use HasFactory;

    protected $table = 'negative_certificate_searches';

    protected $fillable = [
        'owner_lastname',      // اللقب
        'owner_firstname',     // الاسم
        'owner_father',        // اسم الأب
        'birth_date',          // تاريخ الميلاد
        'birth_place',         // مكان الميلاد
        'area',                // المساحة
        'location',            // الموقع
        'municipality',        // البلدية
        'plot_number',         // رقم القطعة
        'group_number',        // رقم المجمع
        'section',             // القسم
        'publication_date',    // تاريخ النشر
        'publication_number',  // رقم النشر
        'volume',              // المجلد
        'title',               // التسمية
        'description',         // الوصف
    ];

    protected $casts = [
        'birth_date' => 'date',
        'publication_date' => 'date',
        'area' => 'decimal:2',
    ];

    // Scope للبحث بالاسم
    public function scopeSearchByName($query, $lastname, $firstname, $father = null)
    {
        return $query->where('owner_lastname', 'like', '%' . $lastname . '%')
                     ->where('owner_firstname', 'like', '%' . $firstname . '%')
                     ->when($father, function($q) use ($father) {
                         return $q->where('owner_father', 'like', '%' . $father . '%');
                     });
    }

    // Scope للبحث برقم القطعة
    public function scopeSearchByPlot($query, $plotNumber)
    {
        return $query->where('plot_number', $plotNumber);
    }

    // Accessor لاسم المالك الكامل
    public function getFullNameAttribute()
    {
        return "{$this->owner_firstname} {$this->owner_lastname}";
    }
}
