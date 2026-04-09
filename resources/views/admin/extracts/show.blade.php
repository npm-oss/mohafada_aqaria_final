@extends('admin.layout')

@section('title', 'تفاصيل المستخرج')

@section('content')
<style>
    .extract-details-page {
        max-width: 1000px;
        margin: 3rem auto;
        padding: 0 1rem;
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
        text-align: center;
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
        animation: rotate 15s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .page-header-content {
        position: relative;
        z-index: 2;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        margin-top: 0;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .details-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 5px 25px rgba(26, 86, 50, 0.1);
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.5rem;
        color: #1a5632;
        margin-bottom: 1.5rem;
        margin-top: 0;
        padding-bottom: 1rem;
        border-bottom: 3px solid #c49b63;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        border-color: #1a5632;
        box-shadow: 0 3px 10px rgba(26, 86, 50, 0.1);
    }

    .info-label {
        font-weight: 700;
        color: #1a5632;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .info-value {
        color: #333;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .status-badge {
        display: inline-block;
        padding: 0.6rem 1.5rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 1rem;
    }

    .status-pending {
        background: rgba(255, 193, 7, 0.15);
        color: #ff9800;
        border: 2px solid rgba(255, 193, 7, 0.3);
    }

    .status-approved {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
        border: 2px solid rgba(40, 167, 69, 0.3);
    }

    .status-rejected {
        background: rgba(220, 53, 69, 0.15);
        color: #dc3545;
        border: 2px solid rgba(220, 53, 69, 0.3);
    }

    .type-badge {
        display: inline-block;
        padding: 0.6rem 1.5rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 1rem;
    }

    .type-badge.seizure {
        background: linear-gradient(135deg, rgba(26, 86, 50, 0.15), rgba(26, 86, 50, 0.05));
        color: #1a5632;
        border: 2px solid rgba(26, 86, 50, 0.3);
    }

    .type-badge.sale {
        background: linear-gradient(135deg, rgba(196, 155, 99, 0.15), rgba(196, 155, 99, 0.05));
        color: #8b6f47;
        border: 2px solid rgba(196, 155, 99, 0.3);
    }

    .type-badge.gift {
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.15), rgba(255, 107, 107, 0.05));
        color: #dc3545;
        border: 2px solid rgba(255, 107, 107, 0.3);
    }

    .type-badge.mortgage {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.15), rgba(52, 152, 219, 0.05));
        color: #3498db;
        border: 2px solid rgba(52, 152, 219, 0.3);
    }

    .type-badge.cancellation {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(255, 193, 7, 0.05));
        color: #f39c12;
        border: 2px solid rgba(255, 193, 7, 0.3);
    }

    .type-badge.petition {
        background: linear-gradient(135deg, rgba(155, 89, 182, 0.15), rgba(155, 89, 182, 0.05));
        color: #9b59b6;
        border: 2px solid rgba(155, 89, 182, 0.3);
    }

    .type-badge.ownership {
        background: linear-gradient(135deg, rgba(46, 204, 113, 0.15), rgba(46, 204, 113, 0.05));
        color: #27ae60;
        border: 2px solid rgba(46, 204, 113, 0.3);
    }

    .badge-container {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .badge-section {
        text-align: center;
    }

    .badge-label {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 0.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
    }

    .btn {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(26, 86, 50, 0.3);
    }

    .btn-secondary {
        background: white;
        color: #1a5632;
        border: 2px solid #1a5632;
    }

    .btn-secondary:hover {
        background: #1a5632;
        color: white;
        transform: translateY(-3px);
    }

    .btn-danger {
        background: #dc3545;
        color: white;
        border: 2px solid #dc3545;
    }

    .btn-danger:hover {
        background: #c82333;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.8rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .badge-container {
            flex-direction: column;
            gap: 1.5rem;
        }
    }
</style>

<div class="extract-details-page">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">📋 تفاصيل المستخرج</h1>
            <p class="page-subtitle">رقم الطلب: #{{ $extract->id }}</p>
        </div>
    </div>

    <!-- Contract Type & Status -->
    <div class="details-card">
        <div class="badge-container">
            <div class="badge-section">
                <div class="badge-label">نوع العقد</div>
                @php
                    $typeClass = '';
                    $typeLabel = '';
                    $typeIcon = '';
                    
                    switch($extract->extract_type) {
                        case 'seizure':
                        case 'حجز':
                            $typeClass = 'seizure';
                            $typeLabel = 'حجز';
                            $typeIcon = '🔒';
                            break;
                        case 'sale':
                        case 'عقد بيع':
                            $typeClass = 'sale';
                            $typeLabel = 'عقد بيع';
                            $typeIcon = '💰';
                            break;
                        case 'gift':
                        case 'عقد هبة':
                            $typeClass = 'gift';
                            $typeLabel = 'عقد هبة';
                            $typeIcon = '🎁';
                            break;
                        case 'mortgage':
                        case 'رهن أو امتياز':
                            $typeClass = 'mortgage';
                            $typeLabel = 'رهن أو امتياز';
                            $typeIcon = '🏦';
                            break;
                        case 'cancellation':
                        case 'تشطيب':
                            $typeClass = 'cancellation';
                            $typeLabel = 'تشطيب';
                            $typeIcon = '✂️';
                            break;
                        case 'petition':
                        case 'عريضة':
                            $typeClass = 'petition';
                            $typeLabel = 'عريضة';
                            $typeIcon = '📝';
                            break;
                        case 'ownership':
                        case 'وثيقة ناقلة للملكية':
                            $typeClass = 'ownership';
                            $typeLabel = 'وثيقة ناقلة للملكية';
                            $typeIcon = '📜';
                            break;
                        default:
                            $typeClass = 'seizure';
                            $typeLabel = $extract->extract_type;
                            $typeIcon = '📄';
                    }
                @endphp
                
                <span class="type-badge {{ $typeClass }}">
                    {{ $typeIcon }} {{ $typeLabel }}
                </span>
            </div>
            <div class="badge-section">
                <div class="badge-label">حالة الطلب</div>
                @if($extract->status == 'قيد المعالجة')
                    <span class="status-badge status-pending">⏳ قيد المعالجة</span>
                @elseif($extract->status == 'مقبول')
                    <span class="status-badge status-approved">✅ مقبول</span>
                @else
                    <span class="status-badge status-rejected">❌ مرفوض</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Applicant Information -->
    <div class="details-card">
        <h2 class="section-title">
            <span>👤</span>
            <span>معلومات مقدم الطلب</span>
        </h2>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">اللقب</div>
                <div class="info-value">{{ $extract->applicant_lastname }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">الاسم</div>
                <div class="info-value">{{ $extract->applicant_firstname }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">اسم الأب</div>
                <div class="info-value">{{ $extract->applicant_father }}</div>
            </div>

            @if($extract->applicant_nin)
            <div class="info-item">
                <div class="info-label">رقم التعريف الوطني</div>
                <div class="info-value">{{ $extract->applicant_nin }}</div>
            </div>
            @endif

            @if($extract->applicant_email)
            <div class="info-item">
                <div class="info-label">البريد الإلكتروني</div>
                <div class="info-value">{{ $extract->applicant_email }}</div>
            </div>
            @endif

            @if($extract->applicant_phone)
            <div class="info-item">
                <div class="info-label">رقم الهاتف</div>
                <div class="info-value">{{ $extract->applicant_phone }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Contract Information -->
    <div class="details-card">
        <h2 class="section-title">
            <span>📄</span>
            <span>معلومات العقد</span>
        </h2>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">رقم المجلد</div>
                <div class="info-value">{{ $extract->volume_number }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">رقم النشر</div>
                <div class="info-value">{{ $extract->publication_number }}</div>
            </div>

            @if($extract->publication_date)
            <div class="info-item">
                <div class="info-label">تاريخ النشر</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($extract->publication_date)->format('Y/m/d') }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Request Information -->
    <div class="details-card">
        <h2 class="section-title">
            <span>📊</span>
            <span>معلومات الطلب</span>
        </h2>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">تاريخ التقديم</div>
                <div class="info-value">{{ $extract->created_at->format('Y/m/d H:i') }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">منذ</div>
                <div class="info-value">{{ $extract->created_at->diffForHumans() }}</div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('admin.extracts.index') }}" class="btn btn-secondary">
            <span>←</span>
            <span>رجوع</span>
        </a>

        <!-- زر الحذف -->
        <form action="{{ route('admin.extracts.destroy', $extract->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('⚠️ هل أنت متأكد من حذف هذا المستخرج نهائياً؟ لا يمكن التراجع.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                🗑️ حذف
            </button>
        </form>
    </div>

</div>
@endsection