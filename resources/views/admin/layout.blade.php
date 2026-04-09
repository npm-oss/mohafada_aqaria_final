<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - المحافظة العقارية</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1a5632;
            --primary-dark: #0d3d20;
            --secondary: #c49b63;
            --accent: #8b6f47;
            --bg-light: #f8f6f1;
            --text-dark: #2d2d2d;
            --text-light: #6b6b6b;
            --white: #ffffff;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --error: #dc3545;
            --shadow: rgba(26, 86, 50, 0.1);
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            box-shadow: 4px 0 30px rgba(0, 0, 0, 0.2);
            position: fixed;
            right: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.1); }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.3); border-radius: 10px; }

        /* Sidebar Header */
        .sidebar-header {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .logo-container { position: relative; z-index: 2; }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .logo-text { color: white; font-size: 1.5rem; font-weight: 700; margin-bottom: 0.3rem; }
        .logo-subtitle { color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; }

        /* Admin Info */
        .admin-info {
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            margin: 1rem;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .admin-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--secondary), var(--accent));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 0.8rem;
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .admin-name { color: white; font-size: 1.1rem; font-weight: 700; text-align: center; margin-bottom: 0.2rem; }
        .admin-role { color: rgba(255, 255, 255, 0.7); font-size: 0.85rem; text-align: center; }

        /* Navigation */
        .nav-menu { padding: 1rem 0; }
        .nav-section { margin-bottom: 1.5rem; }

        .nav-section-title {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 0 1.5rem;
            margin-bottom: 0.8rem;
            letter-spacing: 1px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            margin: 0.3rem 0.8rem;
            border-radius: 12px;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--secondary);
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 0 10px 10px 0;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(-5px);
            color: white;
        }

        .nav-link:hover::before { opacity: 1; }
        .nav-link.active { background: rgba(255, 255, 255, 0.2); color: white; }
        .nav-link.active::before { opacity: 1; }
        .nav-icon { font-size: 1.3rem; width: 24px; text-align: center; }

        /* Logout Button */
        .logout-btn {
            width: calc(100% - 1.6rem);
            margin: 1rem 0.8rem;
            padding: 1rem;
            background: rgba(220, 53, 69, 0.2);
            border: 2px solid rgba(220, 53, 69, 0.3);
            color: #ff6b6b;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
            font-family: inherit;
        }

        .logout-btn:hover {
            background: rgba(220, 53, 69, 0.3);
            border-color: rgba(220, 53, 69, 0.5);
            color: #ff5252;
            transform: translateY(-2px);
        }

        /* Main Content */
        .main-content { flex: 1; margin-right: 280px; min-height: 100vh; transition: all 0.3s ease; }

        /* Top Bar */
        .top-bar {
            background: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 15px var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .page-title { font-size: 1.8rem; font-weight: 700; color: var(--primary); }
        .top-bar-actions { display: flex; gap: 1rem; align-items: center; }

        .notification-btn {
            position: relative;
            width: 45px;
            height: 45px;
            background: var(--bg-light);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-size: 1.3rem;
        }

        .notification-btn:hover { background: var(--primary); color: white; transform: translateY(-2px); }

        .notification-badge {
            position: absolute;
            top: -5px;
            left: -5px;
            background: var(--error);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* Content Area */
        .content-area { padding: 2rem; min-height: calc(100vh - 100px); }

        /* Alert */
        .alert-permission {
            background: rgba(220, 53, 69, 0.1);
            border: 2px solid rgba(220, 53, 69, 0.3);
            color: #dc3545;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin: 1rem 2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-right: 0; }
            .menu-toggle { display: block; }
        }

        .menu-toggle {
            display: none;
            width: 45px;
            height: 45px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .menu-toggle:hover { background: var(--primary-dark); }
    </style>
</head>

<body>

<div class="admin-layout">

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">

        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-icon">🏛️</div>
                <div class="logo-text">
                    {{ setting('site_name', 'المحافظة العقارية') }}
                </div>
                <div class="logo-subtitle">لوحة التحكم</div>
            </div>
        </div>

        <!-- ✅ Admin Info مع نوع المشرف تلقائي -->
        <div class="admin-info">
            <div class="admin-avatar">👤</div>
            <div class="admin-name">{{ auth()->user()->name ?? 'المسؤول الرئيسي' }}</div>
            <div class="admin-role">
                @if(auth()->user()->isSuperAdmin())
                    🔑 مدير النظام
                @else
                    🛡️ مشرف
                @endif
            </div>
        </div>

        <!-- ✅ Navigation Menu مع الصلاحيات -->
        <nav class="nav-menu">

            @php $user = Auth::guard('web')->user(); @endphp

            <div class="nav-section">
                <div class="nav-section-title">القائمة الرئيسية</div>

                <!-- الرئيسية - للجميع دائماً -->
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">🏠</span>
                    <span>الرئيسية</span>
                </a>

              

                <!-- الشهادات السلبية -->
                @if($user->hasPermission('certificates'))
                <a href="{{ route('admin.certificates.index') }}"
                   class="nav-link {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">
                    <span class="nav-icon">📄</span>
                    <span>الشهادات السلبية</span>
                </a>
                @endif

                <!-- البطاقات العقارية -->
             @if($user->hasPermission('cards'))
<a href="{{ route('admin.documents.index') }}"
   class="nav-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
    <span class="nav-icon">🪪</span>
    <span>البطاقات العقارية</span>
</a>
@endif

                <!-- مستخرجات العقود -->
                @if($user->hasPermission('documents'))
                <a href="{{ route('admin.extracts.index') }}"
                   class="nav-link {{ request()->routeIs('admin.extracts.*') ? 'active' : '' }}">
                    <span class="nav-icon">📋</span>
                    <span>مستخرجات العقود</span>
                </a>
                @endif

                <!-- الدفتر العقاري -->
                @if($user->hasPermission('land_registers'))
                <a href="{{ route('admin.land.registers.index') }}"
                   class="nav-link {{ request()->routeIs('admin.land.registers.*') ? 'active' : '' }}">
                    <span class="nav-icon">📖</span>
                    <span>الدفتر العقاري</span>
                </a>
                @endif

                <!-- حجز المواعيد -->
                @if($user->hasPermission('appointments'))
                <a href="{{ route('admin.appointments.index') }}"
                   class="nav-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
                    <span class="nav-icon">📅</span>
                    <span>حجز المواعيد</span>
                </a>
                @endif

                <!-- الرسائل -->
                @if($user->hasPermission('messages'))
                <a href="{{ route('admin.messages.index') }}"
                   class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <span class="nav-icon">📩</span>
                    <span>الرسائل</span>
                </a>
                @endif

            </div>

            <div class="nav-section">
                <div class="nav-section-title">الإعدادات</div>

                <!-- الإعدادات -->
                @if($user->hasPermission('settings'))
                <a href="{{ route('admin.settings') }}"
                   class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <span class="nav-icon">⚙️</span>
                    <span>الإعدادات</span>
                </a>
                @endif

                <!-- ✅ إدارة المشرفين - المدير العام فقط -->
                @if($user->isSuperAdmin())
                <a href="{{ route('admin.managers.index') }}"
                   class="nav-link {{ request()->routeIs('admin.managers.*') ? 'active' : '' }}">
                    <span class="nav-icon">👨‍💼</span>
                    <span>إدارة المشرفين</span>
                </a>
                @endif

            </div>

        </nav>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <span>🚪</span>
                <span>تسجيل الخروج</span>
            </button>
        </form>

    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <!-- Top Bar -->
        <div class="top-bar">
            <button class="menu-toggle" id="menuToggle">☰</button>
            <h1 class="page-title">@yield('title', 'لوحة التحكم')</h1>
            <div class="top-bar-actions">
                <button class="notification-btn" title="الإشعارات">
                    🔔
                    <span class="notification-badge">3</span>
                </button>
                <button class="notification-btn" title="البحث">
                    🔍
                </button>
            </div>
        </div>

        <!-- ✅ رسالة الصلاحيات -->
        @if(session('error'))
        <div class="alert-permission">
            <span>⛔</span>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>

    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }

    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
});
</script>

@stack('scripts')

</body>
</html>