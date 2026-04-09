@extends('admin.layout')

@section('content')
<style>
    .page-details {
        animation: fadeInUp 0.5s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .extract-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 25px rgba(26, 86, 50, 0.1);
    }

    .extract-card h4 {
        font-size: 1.5rem;
        color: #1a5632;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #c49b63;
        font-weight: 700;
    }

    .extract-card .row {
        display: flex;
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
        align-items: center;
    }

    .extract-card .row:last-child {
        border-bottom: none;
    }

    .extract-card .row label {
        font-weight: 600;
        color: #1a5632;
        min-width: 180px;
        font-size: 1rem;
    }

    .extract-card .row span {
        color: #333;
        font-size: 1rem;
    }

    .top-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-process,
    .btn-approve,
    .btn-reject,
    .btn-back {
        padding: 1rem 2rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-process {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }

    .btn-process:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(23, 162, 184, 0.3);
    }

    .btn-approve {
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
    }

    .btn-approve:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
    }

    .btn-reject {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .btn-reject:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
    }

    .btn-back {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
    }

    .btn-back:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
    }

    .status-badge {
        display: inline-block;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
    }

    .status-badge.pending {
        background: rgba(255, 193, 7, 0.1);
        color: #ff9800;
        border: 2px solid #ff9800;
    }

    .status-badge.processing {
        background: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
        border: 2px solid #17a2b8;
    }

    .status-badge.approved {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 2px solid #28a745;
    }

    .status-badge.rejected {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 2px solid #dc3545;
    }

    .info-header {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        text-align: center;
    }

    .info-header h2 {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .info-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    @media (max-width: 768px) {
        .extract-card .row {
            flex-direction: column;
            align-items: flex-start;
        }

        .extract-card .row label {
            min-width: auto;
            margin-bottom: 0.5rem;
        }

        .top-actions {
            flex-direction: column;
        }

        .btn-process,
        .btn-approve,
        .btn-reject,
        .btn-back {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="page-details">
    <!-- Page Header -->
    <div class="info-header">
        <h2>📄 تفاصيل الشهادة السلبية</h2>
        <p>رقم الطلب: {{ $certificate->request_number ?? '-' }}</p>
        <p>
            <span class="status-badge {{ $certificate->status }}">
                @if($certificate->status == 'pending')
                    ⏳ قيد الانتظار
                @elseif($certificate->status == 'processing')
                    🔄 قيد المعالجة
                @elseif($certificate->status == 'approved')
                    ✅ موافق عليها
                @elseif($certificate->status == 'rejected')
                    ❌ مرفوضة
                @else
                    {{ $certificate->status }}
                @endif
            </span>
        </p>
    </div>

    {{-- معلومات صاحب الملكية --}}
    <div class="extract-card">
        <h4>📌 معلومات صاحب الملكية</h4>
        <div class="row"><label>اللقب:</label> <span>{{ $certificate->owner_lastname }}</span></div>
        <div class="row"><label>الاسم:</label> <span>{{ $certificate->owner_firstname }}</span></div>
        <div class="row"><label>اسم الأب:</label> <span>{{ $certificate->owner_father ?? '-' }}</span></div>
        <div class="row"><label>تاريخ الميلاد:</label> <span>{{ $certificate->owner_birthdate ?? '-' }}</span></div>
        <div class="row"><label>مكان الميلاد:</label> <span>{{ $certificate->owner_birthplace ?? '-' }}</span></div>
    </div>

    {{-- معلومات مقدم الطلب --}}
    <div class="extract-card">
        <h4>👤 معلومات مقدم الطلب</h4>
        <div class="row"><label>اللقب:</label> <span>{{ $certificate->applicant_lastname }}</span></div>
        <div class="row"><label>الاسم:</label> <span>{{ $certificate->applicant_firstname }}</span></div>
        <div class="row"><label>اسم الأب:</label> <span>{{ $certificate->applicant_father ?? '-' }}</span></div>
        <div class="row"><label>البريد الإلكتروني:</label> <span>{{ $certificate->email }}</span></div>
        <div class="row"><label>رقم الهاتف:</label> <span>{{ $certificate->phone }}</span></div>
    </div>

    {{-- معلومات إضافية --}}
    <div class="extract-card">
        <h4>ℹ️ معلومات إضافية</h4>
        <div class="row"><label>تاريخ الطلب:</label> <span>{{ $certificate->created_at->format('Y/m/d H:i') }}</span></div>
        @if($certificate->notes)
        <div class="row"><label>ملاحظات:</label> <span>{{ $certificate->notes }}</span></div>
        @endif
    </div>

    {{-- أزرار الإجراءات --}}
    <div class="extract-card top-actions">
        <a href="{{ route('admin.certificates.process', $certificate->id) }}" class="btn-process">
            ⚙️ معالجة
        </a>

        @if($certificate->status == 'pending' || $certificate->status == 'processing')
        <form action="{{ route('admin.certificates.approve', $certificate->id) }}" method="POST" style="display:inline" onsubmit="return confirm('هل أنت متأكد من الموافقة على هذا الطلب؟')">
            @csrf
            <button type="submit" class="btn-approve">
                ✅ موافقة
            </button>
        </form>

        <form action="{{ route('admin.certificates.reject', $certificate->id) }}" method="POST" style="display:inline" onsubmit="return confirm('هل أنت متأكد من رفض هذا الطلب؟')">
            @csrf
            <button type="submit" class="btn-reject">
                ❌ رفض
            </button>
        </form>
        @endif

        <a href="{{ route('admin.certificates.index') }}" class="btn-back">
            ← رجوع
        </a>
    </div>
</div>
@endsection