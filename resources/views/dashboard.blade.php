@extends('admin.layout')

@section('title', 'لوحة التحكم')

@section('content')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #1a5632;
        --primary-dark: #0d3d20;
        --primary-light: #2e7d4a;
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
        --purple: #6f42c1;
        --shadow: rgba(26, 86, 50, 0.1);
    }

    body {
        font-family: 'Cairo', sans-serif;
        background: linear-gradient(135deg, #f8f6f1 0%, #e8e3d9 100%);
    }

    .dashboard-container {
        padding: 2rem;
        min-height: 100vh;
    }

    /* Welcome Header - نفس التصميم السابق */
    .welcome-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        padding: 2.5rem;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(26, 86, 50, 0.3);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        animation: fadeInDown 0.6s ease;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .welcome-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: rotate 15s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .welcome-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .welcome-text h1 {
        color: white;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .welcome-text p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
    }

    .welcome-time {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 1rem 2rem;
        border-radius: 15px;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .welcome-time .date {
        color: white;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .welcome-time .time {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
        margin-top: 0.3rem;
    }

    /* ========== بطاقات الإحصائيات الجديدة ========== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: var(--white);
        border-radius: 30px;
        padding: 2rem;
        box-shadow: 0 15px 35px var(--shadow);
        position: relative;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.8s ease backwards;
        border: 2px solid transparent;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        transform: scaleX(0);
        transition: transform 0.5s ease;
    }

    .stat-card:hover {
        transform: translateY(-15px) scale(1.02);
        box-shadow: 0 30px 60px rgba(26, 86, 50, 0.3);
        border-color: var(--primary-light);
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card::after {
        content: '';
        position: absolute;
        bottom: -20px;
        right: -20px;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(26, 86, 50, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        transition: all 0.5s ease;
    }

    .stat-card:hover::after {
        transform: scale(1.5);
        opacity: 0;
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .stat-icon {
        width: 80px;
        height: 80px;
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        transition: all 0.4s ease;
        position: relative;
        z-index: 2;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(10deg);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    }

    .stat-icon.new {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }

    .stat-icon.processing {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: white;
    }

    .stat-icon.approved {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .stat-icon.users {
        background: linear-gradient(135deg, #6f42c1, #5a32a3);
        color: white;
    }

    .stat-badge {
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        animation: slideInRight 0.5s ease;
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .stat-badge.new {
        background: rgba(23, 162, 184, 0.15);
        color: #17a2b8;
        border: 2px solid #17a2b8;
    }

    .stat-badge.processing {
        background: rgba(255, 193, 7, 0.15);
        color: #ff9800;
        border: 2px solid #ff9800;
    }

    .stat-badge.approved {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
        border: 2px solid #28a745;
    }

    .stat-badge.users {
        background: rgba(111, 66, 193, 0.15);
        color: #6f42c1;
        border: 2px solid #6f42c1;
    }

    .stat-content {
        position: relative;
        z-index: 2;
    }

    .stat-content h3 {
        font-size: 1rem;
        color: var(--text-light);
        margin-bottom: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-number {
        font-size: 3.5rem;
        font-weight: 900;
        color: var(--primary);
        line-height: 1;
        margin-bottom: 1.2rem;
        text-shadow: 3px 3px 6px rgba(0,0,0,0.1);
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-change {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .stat-change.up {
        background: rgba(40, 167, 69, 0.15);
        color: var(--success);
        border: 2px solid rgba(40, 167, 69, 0.3);
    }

    .stat-change.down {
        background: rgba(220, 53, 69, 0.15);
        color: var(--error);
        border: 2px solid rgba(220, 53, 69, 0.3);
    }

    .stat-change:hover {
        transform: translateX(-5px);
        filter: brightness(1.1);
    }

    /* باقي التصميم - جداول وإجراءات سريعة (كما هو) */
    .table-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 5px 25px var(--shadow);
        margin-bottom: 2rem;
        animation: fadeIn 0.8s ease 0.5s backwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--bg-light);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .table-header h2 {
        font-size: 1.8rem;
        color: var(--primary);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .filter-btn {
        padding: 0.6rem 1.2rem;
        border: 2px solid var(--bg-light);
        background: white;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .requests-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .requests-table thead {
        background: var(--bg-light);
    }

    .requests-table th {
        padding: 1.2rem 1rem;
        text-align: center;
        font-weight: 700;
        color: var(--primary);
        font-size: 0.95rem;
        border-bottom: 2px solid rgba(26, 86, 50, 0.1);
    }

    .requests-table th:first-child { border-radius: 10px 0 0 0; }
    .requests-table th:last-child { border-radius: 0 10px 0 0; }

    .requests-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid var(--bg-light);
    }

    .requests-table tbody tr:hover {
        background: rgba(26, 86, 50, 0.03);
        transform: scale(1.01);
        box-shadow: 0 3px 10px var(--shadow);
    }

    .requests-table td {
        padding: 1.2rem 1rem;
        text-align: center;
        color: var(--text-dark);
    }

    .status-badge {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-badge.new { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }
    .status-badge.processing { background: rgba(255, 193, 7, 0.1); color: #ff9800; }
    .status-badge.approved { background: rgba(40, 167, 69, 0.1); color: #28a745; }
    .status-badge.rejected { background: rgba(220, 53, 69, 0.1); color: #dc3545; }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 0 0.2rem;
    }

    .action-btn.view { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }
    .action-btn.view:hover { background: #17a2b8; color: white; }
    .action-btn.edit { background: rgba(40, 167, 69, 0.1); color: #28a745; }
    .action-btn.edit:hover { background: #28a745; color: white; }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-light);
    }

    .empty-state .icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        animation: fadeIn 0.8s ease 0.6s backwards;
    }

    .action-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 5px 25px var(--shadow);
        position: relative;
        overflow: hidden;
    }

    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .action-card:hover::before { opacity: 1; }
    .action-card:hover { transform: translateY(-10px); box-shadow: 0 15px 45px rgba(26, 86, 50, 0.3); }

    .action-card .icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .action-card:hover .icon { transform: scale(1.2); }

    .action-card h3 {
        font-size: 1.2rem;
        font-weight: 700;
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .action-card.blue .icon { color: #17a2b8; }
    .action-card.green .icon { color: #28a745; }
    .action-card.yellow .icon { color: #ffc107; }
    .action-card.purple .icon { color: #6f42c1; }

    .action-card.blue h3 { color: #17a2b8; }
    .action-card.green h3 { color: #28a745; }
    .action-card.yellow h3 { color: #ff9800; }
    .action-card.purple h3 { color: #6f42c1; }

    .action-card:hover .icon,
    .action-card:hover h3 { color: white; }

    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .welcome-content { flex-direction: column; text-align: center; }
    }

    @media (max-width: 768px) {
        .dashboard-container { padding: 1rem; }
        .stats-grid { grid-template-columns: 1fr; }
        .welcome-header { padding: 1.5rem; }
        .welcome-text h1 { font-size: 1.8rem; }
        .table-card { padding: 1rem; overflow-x: auto; }
        .quick-actions { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-container">

    <!-- Welcome Header -->
    <div class="welcome-header">
        <div class="welcome-content">
            <div class="welcome-text">
                <h1>👋 مرحباً بك في لوحة التحكم</h1>
                <p>نظرة سريعة على آخر التحديثات والإحصائيات</p>
            </div>
            <div class="welcome-time">
                <div class="date" id="currentDate"></div>
                <div class="time" id="currentTime"></div>
            </div>
        </div>
    </div>

    <!-- بطاقات الإحصائيات المتطورة -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon new">📄</div>
                <div class="stat-badge new">جديد</div>
            </div>
            <div class="stat-content">
                <h3>طلبات جديدة</h3>
                <div class="stat-number">{{ $newRequests }}</div>
                <span class="stat-change up">
                    <span>↑</span>
                    <span>12% عن الشهر الماضي</span>
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon processing">⏳</div>
                <div class="stat-badge processing">قيد المعالجة</div>
            </div>
            <div class="stat-content">
                <h3>قيد المعالجة</h3>
                <div class="stat-number">{{ $processingRequests }}</div>
                <span class="stat-change up">
                    <span>↑</span>
                    <span>8% عن الشهر الماضي</span>
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon approved">✔️</div>
                <div class="stat-badge approved">مقبولة</div>
            </div>
            <div class="stat-content">
                <h3>طلبات مقبولة</h3>
                <div class="stat-number">{{ $approvedRequests }}</div>
                <span class="stat-change up">
                    <span>↑</span>
                    <span>25% عن الشهر الماضي</span>
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon users">👥</div>
                <div class="stat-badge users">نشط</div>
            </div>
            <div class="stat-content">
                <h3>المستخدمين النشطين</h3>
                <div class="stat-number">{{ $usersCount }}</div>
                <span class="stat-change up">
                    <span>↑</span>
                    <span>15% عن الشهر الماضي</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Latest Requests Table (كما هي) -->
    <div class="table-card">
        <div class="table-header">
            <h2>
                <span>📋</span>
                <span>آخر الطلبات</span>
            </h2>
            <div class="table-filter">
                <button class="filter-btn active">الكل</button>
                <button class="filter-btn">جديدة</button>
                <button class="filter-btn">قيد المعالجة</button>
                <button class="filter-btn">مقبولة</button>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="requests-table">
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>اسم المواطن</th>
                        <th>نوع الطلب</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestRequests as $request)
                    <tr>
                        <td><strong>#{{ $request->id }}</strong></td>
                        <td>{{ $request->user_id }}</td>
                        <td>{{ $request->type }}</td>
                        <td>
                            <span class="status-badge {{ strtolower($request->status) }}">
                                {{ $request->status }}
                            </span>
                        </td>
                        <td>{{ $request->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.requests.show', $request->id) }}" class="action-btn view">
                                <span>👁️</span> <span>عرض</span>
                            </a>
                            <a href="{{ route('admin.requests.edit', $request->id) }}" class="action-btn edit">
                                <span>⚙️</span> <span>معالجة</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="icon">📭</div>
                                <p>لا توجد طلبات حالياً</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions (كما هي) -->
    <div class="quick-actions">
        <a href="{{ route('admin.requests.create') }}" class="action-card blue">
            <div class="icon">➕</div>
            <h3>معالجة طلب جديد</h3>
        </a>
        <a href="{{ route('admin.certificates.index') }}" class="action-card green">
            <div class="icon">📄</div>
            <h3>الشهادات السلبية</h3>
        </a>
        <a href="{{ route('admin.documents.index') }}" class="action-card yellow">
            <div class="icon">📑</div>
            <h3>الوثائق العقارية</h3>
        </a>
        <a href="{{ route('admin.extracts.index') }}" class="action-card yellow">
            <div class="icon">📋</div>
            <h3>مستخرجات العقود</h3>
        </a>
        <a href="{{ route('admin.land.registers.index') }}" class="action-card yellow">
            <div class="icon">🏛️</div>
            <h3>الدفتر العقاري</h3>
        </a>
        <a href="{{ route('admin.messages.index') }}" class="action-card purple">
            <div class="icon">📩</div>
            <h3>الرسائل الجديدة</h3>
        </a>
    </div>
</div>

<script>
    function updateDateTime() {
        const now = new Date();
        const dateStr = now.toLocaleDateString('ar-DZ', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        const timeStr = now.toLocaleTimeString('ar-DZ', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('currentDate').textContent = dateStr;
        document.getElementById('currentTime').textContent = timeStr;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Filter buttons functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            // Add filtering logic here
            const filter = this.textContent.trim();
            console.log('Filter by:', filter);
        });
    });
</script>

@endsection