@extends('admin.layout')

@section('title', 'عرض المستخدم')

@section('content')
<style>
    .user-show-page {
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
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(26, 86, 50, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        font-size: 1rem;
        opacity: 0.9;
    }

    .back-btn {
        position: relative;
        z-index: 2;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        padding: 1rem 2rem;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 700;
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-btn:hover {
        background: white;
        color: #1a5632;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 2rem;
    }

    .user-avatar-section {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        text-align: center;
        height: fit-content;
        position: sticky;
        top: 2rem;
    }

    .user-avatar {
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, #c49b63, #8b6f47);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        margin: 0 auto 1.5rem;
        border: 5px solid #f0f0f0;
        box-shadow: 0 10px 30px rgba(196, 155, 99, 0.3);
        transition: all 0.5s ease;
    }

    .user-avatar:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 15px 40px rgba(196, 155, 99, 0.5);
    }

    .user-status {
        display: inline-block;
        padding: 0.7rem 1.5rem;
        border-radius: 25px;
        font-weight: 700;
        font-size: 1rem;
        margin-top: 1rem;
    }

    .status-admin {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.15), rgba(220, 53, 69, 0.05));
        color: #dc3545;
        border: 2px solid rgba(220, 53, 69, 0.3);
    }

    .status-user {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.15), rgba(23, 162, 184, 0.05));
        color: #17a2b8;
        border: 2px solid rgba(23, 162, 184, 0.3);
    }

    .info-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a5632;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #c49b63;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-row {
        display: grid;
        grid-template-columns: 180px 1fr;
        padding: 1.2rem 0;
        border-bottom: 1px solid #f0f0f0;
        gap: 1rem;
        align-items: center;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 700;
        color: #1a5632;
        font-size: 1rem;
    }

    .info-value {
        color: #333;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .email-link {
        color: #17a2b8;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .email-link:hover {
        color: #138496;
        transform: translateX(-5px);
    }

    .actions-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .action-btn {
        width: 100%;
        padding: 1.2rem;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .btn-edit {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: white;
    }

    .btn-edit:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(255, 193, 7, 0.4);
    }

    .btn-delete {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .btn-delete:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(220, 53, 69, 0.4);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .stat-item {
        text-align: center;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 15px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-5px);
        border-color: #1a5632;
    }

    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 600;
    }

    .verified-badge {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.15), rgba(40, 167, 69, 0.05));
        color: #28a745;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 700;
        border: 2px solid rgba(40, 167, 69, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .unverified-badge {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.15), rgba(220, 53, 69, 0.05));
        color: #dc3545;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 700;
        border: 2px solid rgba(220, 53, 69, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        animation: slideDown 0.5s ease;
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

    @media (max-width: 968px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .user-avatar-section {
            position: static;
        }

        .info-row {
            grid-template-columns: 1fr;
        }

        .info-label {
            margin-bottom: 0.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="user-show-page">

    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">👤 عرض المستخدم</h1>
            <p class="page-subtitle">معلومات تفصيلية عن المستخدم</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="back-btn">
            <span>←</span>
            <span>رجوع للقائمة</span>
        </a>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert alert-success">
        <span style="font-size: 1.5rem;">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Content Grid -->
    <div class="content-grid">

        <!-- Avatar Section -->
        <div class="user-avatar-section">
            <div class="user-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h2 style="font-size: 1.8rem; font-weight: 800; color: #1a5632; margin-bottom: 0.5rem;">
                {{ $user->name }}
            </h2>
            <p style="color: #6b7280; margin-bottom: 1rem;">
                {{ $user->email }}
            </p>
            <div class="user-status {{ $user->is_admin == 1 ? 'status-admin' : 'status-user' }}">
                @if($user->is_admin == 1)
                    👨‍💼 مدير النظام
                @else
                    👤 مستخدم عادي
                @endif
            </div>

            <!-- Quick Stats -->
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon">🆔</div>
                    <div class="stat-label">رقم المستخدم</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: #1a5632; margin-top: 0.5rem;">
                        #{{ $user->id }}
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">📅</div>
                    <div class="stat-label">عضو منذ</div>
                    <div style="font-size: 1rem; font-weight: 700; color: #1a5632; margin-top: 0.5rem;">
                        {{ $user->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <div>

            <!-- Basic Info -->
            <div class="info-card">
                <h3 class="card-title">
                    <span>ℹ️</span>
                    <span>المعلومات الأساسية</span>
                </h3>

                <div class="info-row">
                    <div class="info-label">الاسم الكامل:</div>
                    <div class="info-value">{{ $user->name }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">البريد الإلكتروني:</div>
                    <div class="info-value">
                        <a href="mailto:{{ $user->email }}" class="email-link">
                            <span>✉️</span>
                            <span>{{ $user->email }}</span>
                        </a>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">حالة التحقق:</div>
                    <div class="info-value">
                        @if($user->email_verified_at)
                            <span class="verified-badge">
                                <span>✓</span>
                                <span>تم التحقق</span>
                            </span>
                        @else
                            <span class="unverified-badge">
                                <span>⚠</span>
                                <span>لم يتم التحقق</span>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">الصلاحيات:</div>
                    <div class="info-value">
                        @if($user->is_admin == 1)
                            <span style="color: #dc3545; font-weight: 800;">👨‍💼 مدير</span>
                        @else
                            <span style="color: #17a2b8; font-weight: 800;">👤 مستخدم</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Account Info -->
            <div class="info-card">
                <h3 class="card-title">
                    <span>🕐</span>
                    <span>معلومات الحساب</span>
                </h3>

                <div class="info-row">
                    <div class="info-label">تاريخ الإنشاء:</div>
                    <div class="info-value">
                        📅 {{ $user->created_at->format('Y/m/d H:i') }}
                        <small style="color: #999; display: block; margin-top: 0.3rem;">
                            ({{ $user->created_at->diffForHumans() }})
                        </small>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">آخر تحديث:</div>
                    <div class="info-value">
                        📅 {{ $user->updated_at->format('Y/m/d H:i') }}
                        <small style="color: #999; display: block; margin-top: 0.3rem;">
                            ({{ $user->updated_at->diffForHumans() }})
                        </small>
                    </div>
                </div>

                @if($user->email_verified_at)
                <div class="info-row">
                    <div class="info-label">تاريخ التحقق:</div>
                    <div class="info-value">
                        📅 {{ \Carbon\Carbon::parse($user->email_verified_at)->format('Y/m/d H:i') }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="actions-card">
                <h3 class="card-title">
                    <span>⚙️</span>
                    <span>الإجراءات</span>
                </h3>

                <a href="{{ route('admin.users.edit', $user->id) }}" class="action-btn btn-edit">
                    <span>✏️</span>
                    <span>تعديل المستخدم</span>
                </a>

                <form action="{{ route('admin.users.destroy', $user->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('⚠️ هل أنت متأكد من حذف هذا المستخدم؟')"
                      style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn btn-delete">
                        <span>🗑️</span>
                        <span>حذف المستخدم</span>
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection