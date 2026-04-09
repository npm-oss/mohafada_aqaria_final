@extends('admin.layout')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap');
    
    * { font-family: 'Cairo', sans-serif; }

    .page-header {
        background: linear-gradient(135deg, #1a5632 0%, #2d7a4f 100%);
        color: white;
        padding: 2.5rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 15px 40px rgba(26, 86, 50, 0.3);
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
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .page-header h1 {
        font-size: 2.2rem;
        font-weight: 900;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 0;
        position: relative;
        z-index: 2;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #1a5632, #c9a063);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .stat-card h3 {
        font-size: 3rem;
        font-weight: 900;
        color: #1a5632;
        margin-bottom: 0.5rem;
    }

    .stat-card p {
        color: #7f8c8d;
        font-weight: 600;
        font-size: 1rem;
    }

    .table-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.95rem;
    }

    .table th {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        padding: 1.3rem 1rem;
        text-align: center;
        font-weight: 700;
        color: white;
        font-size: 0.95rem;
        white-space: nowrap;
    }

    .table th:first-child { border-radius: 0 12px 0 0; }
    .table th:last-child { border-radius: 12px 0 0 0; }

    .table td {
        padding: 1.3rem 1rem;
        text-align: center;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: rgba(26, 86, 50, 0.05);
        transform: scale(1.01);
    }

    /* معلومات المستخدم */
    .user-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.4rem;
    }

    .user-name {
        font-weight: 700;
        color: #2d2d2d;
        font-size: 1.05rem;
    }

    .user-badge {
        font-size: 0.75rem;
        padding: 0.2rem 0.6rem;
        border-radius: 12px;
        font-weight: 600;
    }

    .user-badge.registered {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .user-badge.guest {
        background: rgba(255, 193, 7, 0.15);
        color: #f59e0b;
    }

    /* معلومات الاتصال */
    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
        text-align: center;
    }

    .contact-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        font-size: 0.9rem;
        color: #5a5a5a;
    }

    .contact-icon {
        font-size: 1.1rem;
    }

    /* التاريخ */
    .date-cell {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
        align-items: center;
    }

    .date-main {
        font-weight: 700;
        color: #2d2d2d;
        font-size: 1rem;
    }

    .date-day {
        font-size: 0.8rem;
        color: #7f8c8d;
        background: rgba(26, 86, 50, 0.08);
        padding: 0.2rem 0.6rem;
        border-radius: 10px;
    }

    /* نوع الخدمة */
    .service-type {
        background: linear-gradient(135deg, rgba(26, 86, 50, 0.1), rgba(201, 160, 99, 0.1));
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        color: #1a5632;
        font-weight: 700;
        border: 2px solid rgba(26, 86, 50, 0.2);
        white-space: nowrap;
    }

    /* الحالة */
    .status-badge {
        display: inline-block;
        padding: 0.6rem 1.3rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-badge.pending {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 193, 7, 0.1));
        color: #f59e0b;
        border: 2px solid rgba(255, 193, 7, 0.3);
    }

    .status-badge.confirmed {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.2), rgba(40, 167, 69, 0.1));
        color: #28a745;
        border: 2px solid rgba(40, 167, 69, 0.3);
    }

    .status-badge.cancelled {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.2), rgba(220, 53, 69, 0.1));
        color: #dc3545;
        border: 2px solid rgba(220, 53, 69, 0.3);
    }

    .status-badge.completed {
        background: linear-gradient(135deg, rgba(111, 66, 193, 0.2), rgba(111, 66, 193, 0.1));
        color: #6f42c1;
        border: 2px solid rgba(111, 66, 193, 0.3);
    }

    /* الأزرار */
    .actions-cell {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 700;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        border: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-view {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }

    .btn-view:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(23, 162, 184, 0.4);
    }

    .btn-confirm {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .btn-confirm:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
    }

    .btn-cancel {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .btn-cancel:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
    }

    .btn-complete {
        background: linear-gradient(135deg, #6f42c1, #5a32a3);
        color: white;
    }

    .btn-complete:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(111, 66, 193, 0.4);
    }

    .alert {
        padding: 1.2rem 1.8rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideIn 0.5s ease;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(50px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 3px solid #28a745;
    }

    .empty-state {
        padding: 4rem;
        text-align: center;
        color: #7f8c8d;
    }

    .empty-icon {
        font-size: 5rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-text {
        font-size: 1.2rem;
        font-weight: 600;
    }

    .pagination {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .pagination .page-link {
        padding: 0.7rem 1.2rem;
        border-radius: 10px;
        color: #1a5632;
        text-decoration: none;
        border: 2px solid #dee2e6;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background: rgba(26, 86, 50, 0.1);
        border-color: #1a5632;
        transform: translateY(-2px);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
        border-color: #1a5632;
    }

    @media (max-width: 1200px) {
        .table-wrapper {
            overflow-x: scroll;
        }
        
        .table {
            min-width: 1200px;
        }
    }
</style>

<div class="page-header">
    <h1>
        <span>📅</span>
        <span>إدارة المواعيد</span>
    </h1>
</div>

@if(session('success'))
<div class="alert alert-success">
    <span style="font-size: 2rem;">✅</span>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ \App\Models\Appointment::count() }}</h3>
        <p>📊 إجمالي المواعيد</p>
    </div>
    <div class="stat-card">
        <h3>{{ \App\Models\Appointment::where('status', 'pending')->count() }}</h3>
        <p>⏳ قيد الانتظار</p>
    </div>
    <div class="stat-card">
        <h3>{{ \App\Models\Appointment::where('status', 'confirmed')->count() }}</h3>
        <p>✅ مؤكدة</p>
    </div>
    <div class="stat-card">
        <h3>{{ \App\Models\Appointment::where('status', 'completed')->count() }}</h3>
        <p>✓ مكتملة</p>
    </div>
</div>

<div class="table-card">
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>👤 المستخدم</th>
                    <th>📧 البريد</th>
                    <th>📱 الهاتف</th>
                    <th>📅 التاريخ</th>
                    <th>🔖 الخدمة</th>
                    <th>📌 الحالة</th>
                    <th>🕐 الحجز</th>
                    <th>⚙️ الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                <tr>
                    <td><strong>#{{ $appointment->id }}</strong></td>
                    
                    <td>
                        <div class="user-info">
                            <span class="user-name">{{ $appointment->full_name }}</span>
                            @if($appointment->user)
                                <span class="user-badge registered">✓ مسجل</span>
                            @else
                                <span class="user-badge guest">👤 زائر</span>
                            @endif
                        </div>
                    </td>
                    
                    <td>
                        <div class="contact-info">
                            <div class="contact-item">
                                <span class="contact-icon">📧</span>
                                <span>{{ $appointment->email }}</span>
                            </div>
                        </div>
                    </td>
                    
                    <td>
                        <div class="contact-info">
                            <div class="contact-item">
                                <span class="contact-icon">📱</span>
                                <span dir="ltr">{{ $appointment->display_phone }}</span>
                            </div>
                        </div>
                    </td>
                    
                    <td>
                        <div class="date-cell">
                            <span class="date-main">{{ $appointment->booking_date->format('Y/m/d') }}</span>
                            <span class="date-day">{{ $appointment->booking_date->translatedFormat('l') }}</span>
                        </div>
                    </td>
                    
                    <td>
                        <span class="service-type">{{ $appointment->service_type }}</span>
                    </td>
                    
                    <td>
                        <span class="status-badge {{ $appointment->status }}">
                            @if($appointment->status == 'pending')
                                ⏳ قيد الانتظار
                            @elseif($appointment->status == 'confirmed')
                                ✅ مؤكد
                            @elseif($appointment->status == 'cancelled')
                                ❌ ملغي
                            @else
                                ✓ مكتمل
                            @endif
                        </span>
                    </td>
                    
                    <td>
                        <div class="date-cell">
                            <span class="date-main">{{ $appointment->created_at->format('Y/m/d') }}</span>
                            <span class="date-day">{{ $appointment->created_at->format('H:i') }}</span>
                        </div>
                    </td>
                    
                    <td>
                        <div class="actions-cell">
                            <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="btn btn-view">
                                👁️ عرض
                            </a>
                            
                            @if($appointment->status == 'pending')
                            <form method="POST" action="{{ route('admin.appointments.confirm', $appointment->id) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-confirm">✓ تأكيد</button>
                            </form>
                            
                            <form method="POST" action="{{ route('admin.appointments.cancel', $appointment->id) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-cancel" onclick="return confirm('هل أنت متأكد من إلغاء هذا الموعد؟')">✗ إلغاء</button>
                            </form>
                            @endif

                            @if($appointment->status == 'confirmed')
                            <form method="POST" action="{{ route('admin.appointments.complete', $appointment->id) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-complete">✓ إتمام</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <div class="empty-text">لا توجد مواعيد حالياً</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($appointments->hasPages())
    <div class="pagination">
        {{ $appointments->links() }}
    </div>
    @endif
</div>

@endsection