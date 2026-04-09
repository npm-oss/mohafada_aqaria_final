@extends('admin.layout')

@section('title', 'مستخرجات العقود')

@section('content')
<style>
    .extracts-container {
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

    .page-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 5px 25px rgba(26, 86, 50, 0.1);
        margin-bottom: 2rem;
    }

    .card-title {
        font-size: 1.8rem;
        color: #1a5632;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #c49b63;
        font-weight: 700;
    }

    /* Stats Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-box {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 3px 15px rgba(26, 86, 50, 0.1);
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(26, 86, 50, 0.15);
    }

    .stat-box .number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a5632;
        margin-bottom: 0.5rem;
    }

    .stat-box .label {
        color: #666;
        font-size: 0.9rem;
    }

    /* Search Form */
    .search-form {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 1rem;
        margin-bottom: 0;
    }

    .search-input {
        padding: 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #1a5632;
        box-shadow: 0 0 0 3px rgba(26, 86, 50, 0.1);
    }

    .search-btn {
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .search-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(26, 86, 50, 0.3);
    }

    /* Alert */
    .alert {
        padding: 1.2rem 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.8rem;
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

    /* Table */
    .table-wrapper {
        overflow-x: auto;
    }

    .extracts-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 900px;
    }

    .extracts-table thead {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
    }

    .extracts-table thead th {
        padding: 1.2rem 1rem;
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .extracts-table thead th:first-child {
        border-radius: 10px 0 0 0;
    }

    .extracts-table thead th:last-child {
        border-radius: 0 10px 0 0;
    }

    .extracts-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .extracts-table tbody tr:hover {
        background: rgba(26, 86, 50, 0.03);
        box-shadow: 0 3px 10px rgba(26, 86, 50, 0.1);
    }

    .extracts-table tbody td {
        padding: 1.2rem 1rem;
        text-align: center;
        color: #333;
        vertical-align: middle;
    }

    /* Type Badge */
    .type-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
        white-space: nowrap;
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

    /* Status Select */
    .status-select {
        padding: 0.6rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        min-width: 150px;
    }

    .status-select:focus {
        outline: none;
        border-color: #1a5632;
    }

    .status-select option {
        padding: 0.5rem;
    }

    /* Action Buttons */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        margin: 0.2rem;
        white-space: nowrap;
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
        margin: 0;
    }

    /* Pagination */
    .pagination-container {
        padding: 2rem 0 0;
        display: flex;
        justify-content: center;
    }

    /* Badge Styles */
    .info-badge {
        background: #f0f0f0;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        display: inline-block;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .search-form {
            grid-template-columns: 1fr;
        }

        .stats-row {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 1.8rem;
        }

        .page-subtitle {
            font-size: 0.95rem;
        }

        .extracts-table {
            font-size: 0.85rem;
        }

        .extracts-table thead th,
        .extracts-table tbody td {
            padding: 0.8rem 0.5rem;
        }

        .action-btn {
            padding: 0.5rem 0.8rem;
            font-size: 0.8rem;
        }

        .status-select {
            font-size: 0.85rem;
            min-width: 130px;
        }
    }
</style>

<div class="extracts-container">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">📋 مستخرجات العقود</h1>
            <p class="page-subtitle">إدارة ومعالجة طلبات مستخرجات العقود</p>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-box">
            <div class="number">{{ \App\Models\ContractExtract::count() }}</div>
            <div class="label">إجمالي الطلبات</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ \App\Models\ContractExtract::where('status', 'قيد المعالجة')->count() }}</div>
            <div class="label">قيد المعالجة</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ \App\Models\ContractExtract::where('status', 'مقبول')->count() }}</div>
            <div class="label">مقبولة</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ \App\Models\ContractExtract::where('status', 'مرفوض')->count() }}</div>
            <div class="label">مرفوضة</div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert alert-success">
        <span style="font-size: 1.5rem;">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Search Form -->
    <div class="page-card">
        <form method="GET" action="{{ route('admin.document_searches.index') }}" class="search-form">
            <input 
                type="text" 
                name="volume_number" 
                class="search-input"
                placeholder="🔍 رقم المجلد..."
                value="{{ request('volume_number') }}">

            <input 
                type="text" 
                name="publication_number" 
                class="search-input"
                placeholder="🔍 رقم النشر..."
                value="{{ request('publication_number') }}">

            <button type="submit" class="search-btn">
                <span>🔍</span>
                <span>بحث</span>
            </button>
        </form>
    </div>

    <!-- Extracts Table -->
    <div class="page-card">
        @if($extracts->count() > 0)
        <div class="table-wrapper">
            <table class="extracts-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>نوع العقد</th>
                        <th>المقدم</th>
                        <th>رقم المجلد</th>
                        <th>رقم النشر</th>
                        <th>التاريخ</th>
                        <th>الحالة</th>
                        <th style="width: 120px;">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($extracts as $extract)
                    <tr>
                        <td><strong style="color: #1a5632; font-size: 1.1rem;">#{{ $extract->id }}</strong></td>
                        <td>
                            @php
                                $typeClass = '';
                                $typeLabel = '';
                                $typeIcon = '';
                                
                                switch($extract->extract_type) {
                                    case 'seizure':
                                        $typeClass = 'seizure';
                                        $typeLabel = 'حجز';
                                        $typeIcon = '🔒';
                                        break;
                                    case 'sale':
                                        $typeClass = 'sale';
                                        $typeLabel = 'عقد بيع';
                                        $typeIcon = '💰';
                                        break;
                                    case 'gift':
                                        $typeClass = 'gift';
                                        $typeLabel = 'عقد هبة';
                                        $typeIcon = '🎁';
                                        break;
                                    case 'mortgage':
                                        $typeClass = 'mortgage';
                                        $typeLabel = 'رهن أو امتياز';
                                        $typeIcon = '🏦';
                                        break;
                                    case 'cancellation':
                                        $typeClass = 'cancellation';
                                        $typeLabel = 'تشطيب';
                                        $typeIcon = '✂️';
                                        break;
                                    case 'petition':
                                        $typeClass = 'petition';
                                        $typeLabel = 'عريضة';
                                        $typeIcon = '📝';
                                        break;
                                    case 'ownership':
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
                        </td>
                        <td>
                            <strong>{{ $extract->applicant_lastname }} {{ $extract->applicant_firstname }}</strong>
                        </td>
                        <td>
                            <span class="info-badge">
                                {{ $extract->volume_number }}
                            </span>
                        </td>
                        <td>
                            <span class="info-badge">
                                {{ $extract->publication_number }}
                            </span>
                        </td>
                        <td>
                            <small style="color: #666;">
                                {{ $extract->created_at->format('Y/m/d') }}
                            </small>
                        </td>
                        <td>
                            <!-- تم إزالة @method('PATCH') لحل مشكلة MethodNotAllowedHttpException -->
                            <form action="{{ route('admin.extracts.updateStatus', $extract->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                <select name="status" class="status-select" onchange="if(confirm('هل أنت متأكد من تغيير الحالة؟')) this.form.submit()">
                                    <option value="قيد المعالجة" {{ $extract->status == 'قيد المعالجة' ? 'selected' : '' }}>
                                        ⏳ قيد المعالجة
                                    </option>
                                    <option value="مقبول" {{ $extract->status == 'مقبول' ? 'selected' : '' }}>
                                        ✅ مقبول
                                    </option>
                                    <option value="مرفوض" {{ $extract->status == 'مرفوض' ? 'selected' : '' }}>
                                        ❌ مرفوض
                                    </option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.extracts.show', $extract->id) }}" class="action-btn btn-view">
                                <span>👁️</span>
                                <span>عرض</span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($extracts->hasPages())
        <div class="pagination-container">
            {{ $extracts->appends(request()->query())->links() }}
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-state-icon">📭</div>
            <div class="empty-state-text">
                @if(request('volume_number') || request('publication_number'))
                    لا توجد نتائج للبحث
                @else
                    لا توجد طلبات مستخرجات حالياً
                @endif
            </div>
        </div>
        @endif
    </div>

</div>
@endsection