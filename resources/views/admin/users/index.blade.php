@extends('admin.layout')

@section('title', 'إدارة المستخدمين')

@section('content')
<style>
    .users-page {
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-header {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
        padding: 2.5rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(26, 86, 50, 0.3);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .page-header-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .add-user-btn {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        padding: 1rem 2rem;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.1rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .add-user-btn:hover {
        background: white;
        color: #1a5632;
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(26, 86, 50, 0.1), transparent);
        border-radius: 0 0 0 100%;
    }

    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(26, 86, 50, 0.2);
    }

    .stat-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1a5632;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #6b7280;
        font-size: 1rem;
        font-weight: 600;
    }

    /* Alert */
    .alert {
        padding: 1.2rem 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideDown 0.5s ease;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.15), rgba(40, 167, 69, 0.05));
        color: #28a745;
        border: 2px solid rgba(40, 167, 69, 0.3);
    }

    /* Table */
    .table-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        animation: fadeIn 0.8s ease 0.3s backwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table thead {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
    }

    .users-table thead th {
        padding: 1.5rem;
        text-align: right;
        font-weight: 700;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
    }

    .users-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .users-table tbody tr:hover {
        background: linear-gradient(90deg, rgba(26, 86, 50, 0.05), transparent);
        transform: translateX(-5px);
    }

    .users-table tbody td {
        padding: 1.5rem;
        color: #333;
        font-size: 1rem;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #c49b63, #8b6f47);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        border: 3px solid #f0f0f0;
        margin-left: 10px;
        vertical-align: middle;
        transition: all 0.3s ease;
    }

    .users-table tbody tr:hover .user-avatar {
        transform: scale(1.15) rotate(5deg);
        box-shadow: 0 5px 15px rgba(196, 155, 99, 0.4);
    }

    .user-name {
        font-weight: 700;
        color: #1a5632;
        font-size: 1.1rem;
    }

    .user-email {
        color: #6b7280;
        font-size: 0.95rem;
    }

    .actions-cell {
        display: flex;
        gap: 0.8rem;
        align-items: center;
    }

    .action-btn {
        padding: 0.7rem 1.2rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-view {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.15), rgba(23, 162, 184, 0.05));
        color: #17a2b8;
        border: 2px solid rgba(23, 162, 184, 0.3);
    }

    .btn-view:hover {
        background: #17a2b8;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(23, 162, 184, 0.3);
    }

    .btn-edit {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(255, 193, 7, 0.05));
        color: #ffc107;
        border: 2px solid rgba(255, 193, 7, 0.3);
    }

    .btn-edit:hover {
        background: #ffc107;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3);
    }

    .btn-delete {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.15), rgba(220, 53, 69, 0.05));
        color: #dc3545;
        border: 2px solid rgba(220, 53, 69, 0.3);
    }

    .btn-delete:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }

    .empty-state-icon {
        font-size: 5rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .empty-state-text {
        font-size: 1.5rem;
        font-weight: 600;
    }

    /* Pagination */
    .pagination-container {
        padding: 2rem;
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 968px) {
        .page-header-content {
            flex-direction: column;
            gap: 1.5rem;
            text-align: center;
        }

        .page-title {
            font-size: 2rem;
        }

        .actions-cell {
            flex-direction: column;
        }

        .action-btn {
            width: 100%;
            justify-content: center;
        }

        .users-table {
            font-size: 0.9rem;
        }

        .users-table thead th,
        .users-table tbody td {
            padding: 1rem;
        }
    }
</style>

<div class="users-page">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <span>👥</span>
                <span>إدارة المستخدمين</span>
            </h1>
            <a href="{{ route('admin.users.create') }}" class="add-user-btn">
                <span>➕</span>
                <span>إضافة مستخدم جديد</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-icon">👥</span>
            <div class="stat-number">{{ $users->total() }}</div>
            <div class="stat-label">إجمالي المستخدمين</div>
        </div>

        <div class="stat-card">
            <span class="stat-icon">👨‍💼</span>
            <div class="stat-number">{{ \App\Models\User::where('is_admin', 1)->count() }}</div>
            <div class="stat-label">المدراء</div>
        </div>

        <div class="stat-card">
            <span class="stat-icon">👤</span>
            <div class="stat-number">{{ \App\Models\User::where('is_admin', 0)->count() }}</div>
            <div class="stat-label">المستخدمين</div>
        </div>

        <div class="stat-card">
            <span class="stat-icon">🆕</span>
            <div class="stat-number">{{ \App\Models\User::whereDate('created_at', today())->count() }}</div>
            <div class="stat-label">مضافين اليوم</div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert alert-success">
        <span style="font-size: 1.5rem;">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Users Table -->
    <div class="table-container">
        @if($users->count() > 0)
        <table class="users-table">
            <thead>
                <tr>
                    <th style="width: 80px;">#</th>
                    <th>المستخدم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الدور</th>
                    <th style="width: 320px; text-align: center;">العمليات</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <strong style="color: #1a5632; font-size: 1.1rem;">{{ $user->id }}</strong>
                    </td>
                    <td>
                        <span class="user-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                        <span class="user-name">{{ $user->name }}</span>
                    </td>
                    <td>
                        <span class="user-email">{{ $user->email }}</span>
                    </td>
                    <td>
                        @if($user->is_admin == 1)
                            <span style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.05)); color: #dc3545; padding: 0.4rem 1rem; border-radius: 20px; font-weight: 700; border: 2px solid rgba(220, 53, 69, 0.3);">
                                👨‍💼 مدير
                            </span>
                        @else
                            <span style="background: linear-gradient(135deg, rgba(108, 117, 125, 0.1), rgba(108, 117, 125, 0.05)); color: #6c757d; padding: 0.4rem 1rem; border-radius: 20px; font-weight: 700; border: 2px solid rgba(108, 117, 125, 0.3);">
                                👤 مستخدم
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="actions-cell">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="action-btn btn-view">
                                <span>👁️</span>
                                <span>عرض</span>
                            </a>

                            <a href="{{ route('admin.users.edit', $user->id) }}" class="action-btn btn-edit">
                                <span>✏️</span>
                                <span>تعديل</span>
                            </a>

                            <form action="{{ route('admin.users.destroy', $user->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('⚠️ هل أنت متأكد من حذف هذا المستخدم؟');"
                                  style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-delete">
                                    <span>🗑️</span>
                                    <span>حذف</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="pagination-container">
            {{ $users->links() }}
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-state-icon">📭</div>
            <div class="empty-state-text">لا يوجد مستخدمين حالياً</div>
        </div>
        @endif
    </div>

</div>
@endsection