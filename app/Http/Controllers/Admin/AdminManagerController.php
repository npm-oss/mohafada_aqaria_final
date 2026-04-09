<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagerController extends Controller
{
   private array $allPermissions = [
    'certificates'   => '📄 الشهادات السلبية',
    'appointments'   => '📅 المواعيد',
    'land_registers' => '📖 الدفتر العقاري',
    'cards'          => '🪪 البطاقات العقارية',
    'documents'      => '📑 مستخرجات العقود',
    'messages'       => '📩 الرسائل',
    'users'          => '👥 المستخدمين',
    'settings'       => '⚙️ الإعدادات',
];

  public function index()
{
    $admins = User::where('is_admin', 1)->get();
    $users  = $admins; // ← أضيفي هذا السطر
    return view('admin.managers.index', compact('admins', 'users'));
}

    public function create()
    {
        $allPermissions = $this->allPermissions;
        return view('admin.managers.create', compact('allPermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8|confirmed',
            'permissions' => 'nullable|array',
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'is_admin'    => 1,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('admin.managers.index')
            ->with('success', '✅ تم إنشاء المشرف بنجاح');
    }

    public function edit($id)
    {
        $admin          = User::findOrFail($id);
        $allPermissions = $this->allPermissions;
        $adminPerms     = $admin->permissions ?? [];
        return view('admin.managers.edit', compact('admin', 'allPermissions', 'adminPerms'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ]);

        $data = [
            'name'        => $request->name,
            'permissions' => $request->permissions ?? [],
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.managers.index')
            ->with('success', '✅ تم تحديث الصلاحيات بنجاح');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.managers.index')
            ->with('success', '✅ تم حذف المشرف');
    }
}