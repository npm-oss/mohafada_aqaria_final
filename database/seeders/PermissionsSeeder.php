<?php
// database/seeders/PermissionsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'الشهادات السلبية',      'key' => 'certificates',   'route' => 'admin.certificates.index',  'icon' => '📋', 'order' => 1],
            ['name' => 'المواعيد',              'key' => 'appointments',   'route' => 'admin.appointments.index',  'icon' => '📅', 'order' => 2],
            ['name' => 'الدفتر العقاري',        'key' => 'land_registers', 'route' => 'admin.land.registers.index','icon' => '📖', 'order' => 3],
            ['name' => 'الوثائق والمستخرجات',   'key' => 'documents',      'route' => 'admin.documents.index',     'icon' => '📄', 'order' => 4],
            ['name' => 'الرسائل',              'key' => 'messages',       'route' => 'admin.messages.index',      'icon' => '✉️', 'order' => 5],
            ['name' => 'المستخدمين',            'key' => 'users',          'route' => 'admin.users.index',         'icon' => '👥', 'order' => 6],
            ['name' => 'الإعدادات',            'key' => 'settings',       'route' => 'admin.settings',            'icon' => '⚙️', 'order' => 7],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['key' => $permission['key']],
                array_merge($permission, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}