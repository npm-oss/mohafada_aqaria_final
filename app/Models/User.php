<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; 
class User extends Authenticatable
{
  use HasFactory, Notifiable, HasApiTokens; 

    protected $fillable = [
        'name', 'email', 'password', 'is_admin', 'permissions'
    ];

     protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'permissions' => 'array', // ← JSON تلقائي
    ];

    // ─── هل هو مدير عام؟ (is_admin=1 وبدون قيود)
    public function isSuperAdmin(): bool
    {
        return $this->is_admin == 1 && empty($this->permissions);
    }

    // ─── هل عنده صلاحية معينة؟
    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperAdmin()) return true;

        return in_array($permission, $this->permissions ?? []);
    }

    // ─── كل صلاحياته (للقائمة الجانبية)
    public function getPermissions(): array
    {
        if ($this->isSuperAdmin()) {
           return [
    'certificates', 'appointments', 'land_registers',
    'cards', 'documents', 'messages', 'users', 'settings', 'managers'
];
        }

        return $this->permissions ?? [];
    }
}




