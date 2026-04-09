@extends('admin.layout')

@section('title', 'تفاصيل الموعد #' . $appointment->id)

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
        font-size: 2rem;
        font-weight: 900;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 0;
        position: relative;
        z-index: 2;
    }

    .back-btn {
        background: rgba(255,255,255,0.2);
        color: white;
        padding: 0.9rem 1.8rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        position: relative;
        z-index: 2;
    }

    .back-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: translateX(-5px);
    }

    .details-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 900;
        color: #1a5632;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding-bottom: 1.2rem;
        border-bottom: 3px solid #f0f0f0;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 2rem;
        padding: 2.5rem;
        background: linear-gradient(135deg, #f8f6f1, #fff);
        border-radius: 18px;
        border: 3px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .user-profile:hover {
        border-color: #c9a063;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .user-avatar-large {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3.5rem;
        font-weight: 900;
        border: 5px solid #c9a063;
        box-shadow: 0 10px 30px rgba(26, 86, 50, 0.3);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .user-info-details {
        flex: 1;
    }

    .user-info-details h3 {
        font-size: 1.8rem;
        color: #2d2d2d;
        margin-bottom: 1rem;
        font-weight: 900;
    }

    .user-meta {
        display: flex;
        flex-direction: column;
        gap: 0.7rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 1.05rem;
        color: #5a5a5a;
    }

    .meta-item strong {
        color: #1a5632;
        font-weight: 700;
    }

    .user-status-badge {
        display: inline-block;
        padding: 0.5rem 1.3rem;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 700;
        margin-top: 0.8rem;
    }

    .user-status-badge.registered {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.2), rgba(40, 167, 69, 0.1));
        color: #28a745;
        border: 2px solid rgba(40, 167, 69, 0.3);
    }

    .user-status-badge.guest {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 193, 7, 0.1));
        color: #f59e0b;
        border: 2px solid rgba(255, 193, 7, 0.3);
    }

    .timeline {
        display: flex;
        justify-content: space-between;
        margin: 2.5rem 0;
        position: relative;
        padding: 0 1rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 5%;
        right: 5%;
        height: 4px;
        background: linear-gradient(90deg, #e0e0e0, #c9a063, #e0e0e0);
        transform: translateY(-50%);
        border-radius: 10px;
    }

    .timeline-step {
        background: white;
        padding: 1rem 1.8rem;
        border-radius: 30px;
        border: 3px solid #e0e0e0;
        position: relative;
        z-index: 1;
        font-weight: 700;
        color: #7f8c8d;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .timeline-step.active {
        border-color: #28a745;
        color: #28a745;
        background: rgba(40, 167, 69, 0.1);
        transform: scale(1.05);
    }

    .timeline-step.current {
        border-color: #f59e0b;
        color: #f59e0b;
        background: rgba(255, 193, 7, 0.1);
        animation: pulse-border 2s infinite;
    }

    @keyframes pulse-border {
        0%, 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
        50% { box-shadow: 0 0 0 15px rgba(245, 158, 11, 0); }
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.8rem;
    }

    .detail-item {
        padding: 1.8rem;
        background: linear-gradient(135deg, #f8f6f1, #fff);
        border-radius: 15px;
        border-right: 5px solid #1a5632;
        transition: all 0.3s ease;
    }

    .detail-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        border-right-color: #c9a063;
    }

    .detail-label {
        font-size: 0.95rem;
        color: #7f8c8d;
        margin-bottom: 0.7rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-value {
        font-size: 1.2rem;
        color: #2d2d2d;
        font-weight: 700;
    }

    .status-badge {
        display: inline-block;
        padding: 0.7rem 1.5rem;
        border-radius: 30px;
        font-size: 1.05rem;
        font-weight: 700;
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

    .notes-box {
        background: linear-gradient(135deg, #fff8e1, #ffecb3);
        border: 3px solid #ffc107;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
    }

    .notes-box h3 {
        color: #f57c00;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 1.3rem;
    }

    .notes-content {
        color: #5d4037;
        line-height: 2;
        font-size: 1.1rem;
        background: white;
        padding: 1.5rem;
        border-radius: 10px;
    }

    .actions-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }

    .actions-title {
        font-size: 1.5rem;
        font-weight: 900;
        color: #1a5632;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .action-buttons {
        display: flex;
        gap: 1.2rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 1.1rem 2.2rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        border: none;
        cursor: pointer;
    }

    .btn-confirm {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .btn-confirm:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(40, 167, 69, 0.4);
    }

    .btn-cancel {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .btn-cancel:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(220, 53, 69, 0.4);
    }

    .btn-complete {
        background: linear-gradient(135deg, #6f42c1, #5a32a3);
        color: white;
    }

    .btn-complete:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(111, 66, 193, 0.4);
    }

    .btn-delete {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
    }

    .btn-delete:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(108, 117, 125, 0.4);
    }

    .btn-back {
        background: #f8f6f1;
        color: #1a5632;
        border: 3px solid #1a5632;
    }

    .btn-back:hover {
        background: #1a5632;
        color: white;
    }

    .alert {
        padding: 1.3rem 2rem;
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

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1.5rem;
            text-align: center;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-action {
            width: 100%;
            justify-content: center;
        }

        .user-profile {
            flex-direction: column;
            text-align: center;
        }

        .timeline {
            flex-direction: column;
            gap: 1rem;
            padding: 0;
        }

        .timeline::before {
            display: none;
        }
    }
</style>

<div class="page-header">
    <h1>
        <span>📅</span>
        <span>تفاصيل الموعد #{{ $appointment->id }}</span>
    </h1>
    <a href="{{ route('admin.appointments.index') }}" class="back-btn">
        ← العودة للقائمة
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    <span style="font-size: 2rem;">✅</span>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- معلومات المستخدم -->
<div class="details-card">
    <div class="card-title">
        <span>👤</span>
        <span>معلومات المستخدم</span>
    </div>
    
    <div class="user-profile">
        <div class="user-avatar-large">
            {{ substr($appointment->firstname, 0, 1) }}{{ substr($appointment->lastname, 0, 1) }}
        </div>
        <div class="user-info-details">
            <h3>{{ $appointment->firstname }} {{ $appointment->lastname }}</h3>
            <div class="user-meta">
                <div class="meta-item">
                    <span>📧</span>
                    <span><strong>البريد:</strong> {{ $appointment->email }}</span>
                </div>
                <div class="meta-item">
                    <span>📱</span>
                    <span dir="ltr"><strong>الهاتف:</strong> {{ $appointment->phone }}</span>
                </div>
                @if($appointment->user)
                <div class="meta-item">
                    <span>🆔</span>
                    <span><strong>معرف المستخدم:</strong> #{{ $appointment->user_id }}</span>
                </div>
                @endif
            </div>
            
            @if($appointment->user)
                <span class="user-status-badge registered">✓ مستخدم مسجل</span>
            @else
                <span class="user-status-badge guest">👤 زائر</span>
            @endif
        </div>
    </div>
</div>

<!-- تفاصيل الموعد -->
<div class="details-card">
    <div class="card-title">
        <span>📋</span>
        <span>تفاصيل الموعد</span>
    </div>

    <!-- Timeline -->
    <div class="timeline">
        <div class="timeline-step {{ $appointment->status == 'pending' ? 'current' : ($appointment->status != 'cancelled' ? 'active' : '') }}">
            ⏳ قيد الانتظار
        </div>
        <div class="timeline-step {{ $appointment->status == 'confirmed' ? 'current' : ($appointment->status == 'completed' ? 'active' : '') }}">
            ✅ مؤكد
        </div>
        <div class="timeline-step {{ $appointment->status == 'completed' ? 'current active' : '' }}">
            ✓ مكتمل
        </div>
    </div>
    
    <div class="details-grid">
        <div class="detail-item">
            <div class="detail-label">🆔 رقم الموعد</div>
            <div class="detail-value">#{{ $appointment->id }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">📅 تاريخ الموعد</div>
            <div class="detail-value">
                {{ $appointment->booking_date->format('Y/m/d') }}
                <small style="display: block; color: #7f8c8d; font-size: 0.9rem; margin-top: 0.5rem;">
                    {{ $appointment->booking_date->translatedFormat('l') }}
                </small>
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">🔖 نوع الخدمة</div>
            <div class="detail-value" style="color: #1a5632;">{{ $appointment->service_type }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">📊 الحالة الحالية</div>
            <div class="detail-value">
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
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">🕐 تاريخ الإنشاء</div>
            <div class="detail-value">{{ $appointment->created_at->format('Y/m/d H:i') }}</div>
        </div>

        <div class="detail-item">
            <div class="detail-label">🔄 آخر تحديث</div>
            <div class="detail-value">{{ $appointment->updated_at->format('Y/m/d H:i') }}</div>
        </div>
    </div>

    @if($appointment->notes)
    <div class="notes-box">
        <h3>📝 ملاحظات إضافية</h3>
        <div class="notes-content">
            {{ $appointment->notes }}
        </div>
    </div>
    @endif
</div>

<!-- أزرار الإجراءات -->
<div class="actions-card">
    <div class="actions-title">⚡ الإجراءات المتاحة</div>
    
    <div class="action-buttons">
        @if($appointment->status == 'pending')
        <a href="{{ route('admin.appointments.process', $appointment->id) }}" class="btn-action btn-confirm">
            ⚙️ معالجة الموعد
        </a>
        @endif

        @if($appointment->status != 'cancelled' && $appointment->status != 'completed')
        <form method="POST" action="{{ route('admin.appointments.cancel', $appointment->id) }}" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من إلغاء هذا الموعد؟');">
            @csrf
            <button type="submit" class="btn-action btn-cancel">
                ❌ إلغاء الموعد
            </button>
        </form>
        @endif

        @if($appointment->status == 'confirmed')
        <form method="POST" action="{{ route('admin.appointments.complete', $appointment->id) }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn-action btn-complete">
                ✓ إتمام الموعد
            </button>
        </form>
        @endif

        <form method="POST" action="{{ route('admin.appointments.destroy', $appointment->id) }}" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموعد نهائياً؟');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-action btn-delete">
                🗑️ حذف الموعد
            </button>
        </form>

        <a href="{{ route('admin.appointments.index') }}" class="btn-action btn-back">
            ← العودة للقائمة
        </a>
    </div>
</div>

@endsection