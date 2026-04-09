@extends('admin.layout')

@section('title', 'إدارة المشرفين')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
        padding: 2.5rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(26,86,50,0.3);
        position: relative;
        overflow: hidden;
    }
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }
    @keyframes rotate { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
    .page-header-content {
        position: relative; z-index: 2;
        display: flex; justify-content: space-between; align-items: center;
    }
    .page-title { font-size: 2rem; font-weight: 800; display: flex; align-items: center; gap: 1rem; }
    .btn-add {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        color: white;
        padding: 1rem 2rem;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 700;
        border: 2px solid rgba(255,255,255,0.3);
        transition: all 0.3s ease;
        display: inline-flex; align-items: center; gap: 0.5rem;
    }
    .btn-add:hover { background: white; color: #1a5632; transform: translateY(-3px); }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: white; padding: 1.5rem; border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        text-align: center; transition: all 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-icon { font-size: 2.5rem; margin-bottom: 0.5rem; display: block; }
    .stat-number { font-size: 2rem; font-weight: 800; color: #1a5632; }
    .stat-label { color: #6b7280; font-weight: 600; }

    .alert-success {
        background: rgba(40,167,69,0.1); border: 2px solid rgba(40,167,69,0.3);
        color: #28a745; padding: 1rem 1.5rem; border-radius: 12px;
        margin-bottom: 1.5rem; font-weight: 600;
        display: flex; align-items: center; gap: 0.8rem;
    }

    .table-container {
        background: white; border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08); overflow: hidden;
    }
    .managers-table { width: 100%; border-collapse: collapse; }
    .managers-table thead { background: linear-gradient(135deg, #1a5632, #2d7a4f); color: white; }
    .managers-table thead th { padding: 1.5rem; text-align: center; font-weight: 700; font-size: 1rem; }
    .managers-table tbody tr { border-bottom: 1px solid #f0f0f0; transition: all 0.3s ease; }
    .managers-table tbody tr:hover { background: rgba(26,86,50,0.03); }
    .managers-table tbody td { padding: 1.2rem 1.5rem; text-align: center; color: #333; vertical-align: middle; }

    .admin-badge {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 700;
    }
    .badge-super { background: rgba(26,86,50,0.1); color: #1a5632; border: 2px solid rgba(26,86,50,0.3); }
    .badge-admin { background: rgba(23,162,184,0.1); color: #17a2b8; border: 2px solid rgba(23,162,184,0.3); }

    .perms-list { display: flex; flex-wrap: wrap; gap: 0.4rem; justify-content: center; }
    .perm-tag {
        background: rgba(196,155,99,0.15); color: #8b6f47;
        padding: 0.3rem 0.8rem; border-radius: 20px;
        font-size: 0.8rem; font-weight: 600; border: 1px solid rgba(196,155,99,0.3);
    }
    .perm-all {
        background: rgba(26,86,50,0.1); color: #1a5632;
        padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700;
    }

    .action-btn {
        display: inline-flex; align-items: center; gap: 0.3rem;
        padding: 0.6rem 1rem; border-radius: 8px;
        font-size: 0.85rem; font-weight: 700;
        transition: all 0.3s ease; border: none;
        cursor: pointer; font-family: inherit; text-decoration: none;
        margin: 0 0.2rem;
    }
    .btn-edit   { background: rgba(255,193,7,0.1);  color: #ffc107; border: 2px solid rgba(255,193,7,0.3); }
    .btn-edit:hover  { background: #ffc107; color: white; }
    .btn-delete { background: rgba(220,53,69,0.1);  color: #dc3545; border: 2px solid rgba(220,53,69,0.3); }
    .btn-delete:hover { background: #dc3545; color: white; }

    .empty-state { text-align: center; padding: 4rem; color: #6b7280; }
    .empty-state .icon { font-size: 4rem; opacity: 0.3; margin-bottom: 1rem; }
    .empty-state p { font-size: 1.2rem; font-weight: 600; }
</style>

<div class="page-header">
    <div class="page-header-content">
        <h1 class="page-title">
            <span>👨‍💼</span>
            <span>إدارة المشرفين</span>
        </h1>
        <a href="{{ route('admin.managers.create') }}" class="btn-add">
            <span>➕</span>
            <span>إضافة مشرف جديد</span>
        </a>
    </div>
</div>

{{-- إحصائيات --}}
<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-icon">👥</span>
        <div class="stat-number">{{ $admins->count() }}</div>
        <div class="stat-label">إجمالي المشرفين</div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">🔑</span>
        <div class="stat-number">{{ $admins->filter(fn($a) => $a->isSuperAdmin())->count() }}</div>
        <div class="stat-label">مدراء عامون</div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">🛡️</span>
        <div class="stat-number">{{ $admins->filter(fn($a) => !$a->isSuperAdmin())->count() }}</div>
        <div class="stat-label">مشرفون</div>
    </div>
</div>

@if(session('success'))
<div class="alert-success">✅ {{ session('success') }}</div>
@endif

<div class="table-container">
    @if($admins->count() > 0)
    <table class="managers-table">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>النوع</th>
                <th>الصلاحيات</th>
                <th>تاريخ الإنشاء</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr>
                <td><strong>#{{ $admin->id }}</strong></td>
                <td><strong>{{ $admin->name }}</strong></td>
                <td>{{ $admin->email }}</td>
                <td>
                    @if($admin->isSuperAdmin())
                        <span class="admin-badge badge-super">🔑 مدير عام</span>
                    @else
                        <span class="admin-badge badge-admin">🛡️ مشرف</span>
                    @endif
                </td>
                <td>
                    @if($admin->isSuperAdmin())
                        <span class="perm-all">🌟 كل الصلاحيات</span>
                    @elseif(!empty($admin->permissions))
                       @php
    $labels = [
        'certificates'   => '📄 الشهادات',
        'appointments'   => '📅 المواعيد',
        'land_registers' => '📖 الدفتر',
        'cards'          => '🪪 البطاقات العقارية',
        'documents'      => '📑 المستخرجات',
        'messages'       => '📩 الرسائل',
        'users'          => '👥 المستخدمين',
        'settings'       => '⚙️ الإعدادات',
    ];
@endphp
                        <div class="perms-list">
                            @foreach($admin->permissions as $perm)
                                <span class="perm-tag">{{ $labels[$perm] ?? $perm }}</span>
                            @endforeach
                        </div>
                    @else
                        <span style="color:#aaa;">بدون صلاحيات</span>
                    @endif
                </td>
                <td>{{ $admin->created_at ? $admin->created_at->format('d/m/Y') : '—' }}</td>
                <td>
                    <a href="{{ route('admin.managers.edit', $admin->id) }}" class="action-btn btn-edit">
                        ✏️ تعديل
                    </a>
                    @if(!$admin->isSuperAdmin())
                    <form method="POST" action="{{ route('admin.managers.destroy', $admin->id) }}"
                          style="display:inline;"
                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المشرف؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn btn-delete">🗑️ حذف</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <div class="icon">👥</div>
        <p>لا يوجد مشرفون حالياً</p>
    </div>
    @endif
</div>

@endsection