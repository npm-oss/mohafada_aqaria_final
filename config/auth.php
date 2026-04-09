<?php

return [

 'defaults' => [
    'guard'     => 'web',       // ← مهم جداً
    'passwords' => 'users',
],

'guards' => [
    'web' => [
        'driver'   => 'session',
        'provider' => 'users',
    ],
    'website' => [              // ← أضفه إذا مش موجود
        'driver'   => 'session',
        'provider' => 'website_users',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model'  => App\Models\User::class,
    ],
    'website_users' => [        // ← أضفه إذا مش موجود
        'driver' => 'eloquent',
        'model'  => App\Models\WebsiteUser::class,
    ],
],
];



