<?php
// app/Models/WebsiteUser.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class WebsiteUser extends Authenticatable
{
    protected $table = 'website_users';

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}