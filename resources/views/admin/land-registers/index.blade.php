@extends('admin.layout')

@section('title', 'طلبات الدفتر العقاري')

@section('content')

<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        padding: 2.5rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }

    .page-header h1 {
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .filters-card {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
    }

    .filters-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-group label {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.95rem;
    }

    .filter-input {
        padding: 0.9rem 1.2rem;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s;
        font-family: inherit;
    }

    .filter-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26, 86, 50, 0.1);
    }

    .btn-filter {
        padding: 0.9rem 2rem;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: auto;
        font-family: inherit;
    }

    .btn-filter:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-box {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    }

    .stat-box .number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .stat-box .label {
        color: var(--text-light);
        font-size: 0.95rem;
        font-weight: 600;
    }

    .table-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        overflow-x: auto;
    }

    .requests-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1200px;
    }

    .requests-table thead {
        background: var(--bg-light);
    }

    .requests-table th {
        padding: 1.2rem 1rem;
        text-align: center;
        font-weight: 700;
        color: var(--primary);
        border-bottom: 2px solid #e0e0e0;
        font-size: 0.95rem;
    }

    .requests-table td {
        padding: 1.2rem 1rem;
        text-align: center;
        border-bottom: 1px solid #f0f0f0;
        color: var(--text-dark);
    }

    .requests-table tbody tr {
        transition: all 0.3s;
    }

    .requests-table tbody tr:hover {
        background: rgba(26, 86, 50, 0.03);
        transform: scale(1.01);
    }

    .status-badge {
        display: inline-block;
        padding: 0.5rem 1.2rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-badge.pending {
        background: rgba(255, 193, 7, 0.15);
        color: #ff9800;
    }

    .status-badge.processing {
        background: rgba(23, 162, 184, 0.15);
        color: #17a2b8;
    }

    .status-badge.approved {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .status-badge.rejected {
        background: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }

    .request-type-badge {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .request-type-badge.new {
        background: rgba(23, 162, 184, 0.15);
        color: #17a2b8;
    }

    .request-type-badge.copy {
        background: rgba(255, 193, 7, 0.15);
        color: #ff9800;
    }

    .btn-view {
        background: var(--primary);
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .btn-view:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(26, 86, 50, 0.3);
    }

    /* زر الحذف */
    .btn-delete {
        background: #dc3545;
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
    }

    .btn-delete:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 4rem;
        color: var(--text-light);
    }

    .empty-state .icon {
        font-size: 5rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        font-weight: 500;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>

<div class="page-header">
    <h1>
        <span>📖</span>
        <span>إدارة طلبات الدفتر العقاري</span>
    </h1>
    <p>عرض ومتابعة جميع طلبات الدفاتر العقارية المقدمة من المواطنين</p>
</div>

@if(session('success'))
<div class="alert alert-success">
    ✅ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-error">
    ❌ {{ session('error') }}
</div>
@endif

<!-- إحصائيات سريعة -->
<div class="stats-row">
    <div class="stat-box">
        <div class="number">{{ isset($stats['pending']) ? $stats['pending'] : 0 }}</div>
        <div class="label">⏳ قيد الانتظار</div>
    </div>
    <div class="stat-box">
        <div class="number">{{ isset($stats['approved']) ? $stats['approved'] : 0 }}</div>
        <div class="label">✅ مقبول</div>
    </div>
    <div class="stat-box">
        <div class="number">{{ isset($stats['new_requests']) ? $stats['new_requests'] : 0 }}</div>
        <div class="label">📝 طلبات جديدة</div>
    </div>
    <div class="stat-box">
        <div class="number">{{ isset($stats['copy_requests']) ? $stats['copy_requests'] : 0 }}</div>
        <div class="label">📋 نسخ دفاتر</div>
    </div>
    <div class="stat-box">
        <div class="number">{{ isset($stats['total']) ? $stats['total'] : 0 }}</div>
        <div class="label">📊 إجمالي الطلبات</div>
    </div>
</div>

<!-- فلترة البحث -->
<div class="filters-card">
    <form method="GET" action="{{ route('admin.land.registers.index') }}">
        <div class="filters-row">
            <div class="filter-group">
                <label>الحالة</label>
                <select name="status" class="filter-input">
                    <option value="">الكل</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ قيد الانتظار</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>🔄 قيد المعالجة</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ مقبول</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ مرفوض</option>
                </select>
            </div>

            <div class="filter-group">
                <label>نوع الطلب</label>
                <select name="request_type" class="filter-input">
                    <option value="">الكل</option>
                    <option value="طلب جديد" {{ request('request_type') == 'طلب جديد' ? 'selected' : '' }}>📝 طلب جديد</option>
                    <option value="نسخة دفتر" {{ request('request_type') == 'نسخة دفتر' ? 'selected' : '' }}>📋 نسخة دفتر</option>
                </select>
            </div>

            <div class="filter-group">
                <label>البحث برقم الطلب أو رقم الهوية</label>
                <input type="text" name="search" class="filter-input" placeholder="اكتب هنا..." value="{{ request('search') }}">
            </div>

            <div class="filter-group">
                <label style="opacity: 0;">بحث</label>
                <button type="submit" class="btn-filter">
                    🔍 بحث
                </button>
            </div>
        </div>
    </form>
</div>

<!-- جدول الطلبات -->
<div class="table-card">
    <table class="requests-table">
        <thead>
            <tr>
                <th>رقم الطلب</th>
                <th>الاسم الكامل</th>
                <th>رقم الهوية</th>
                <th>نوع الطلب</th>
                <th>الحالة</th>
                <th>التاريخ</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registers as $register)
            <tr>
                <td><strong>#{{ $register->id }}</strong></td>
                <td>
                    @if($register->request_type == 'نسخة دفتر')
                        {{ $register->full_name ?? 'غير متوفر' }}
                    @else
                        {{ $register->last_name }} {{ $register->first_name }}
                    @endif
                </td>
                <td>{{ $register->national_id }}</td>
                <td>
                    <span class="request-type-badge {{ $register->request_type == 'طلب جديد' ? 'new' : 'copy' }}">
                        {{ $register->request_type == 'طلب جديد' ? '📝' : '📋' }}
                        {{ $register->request_type }}
                    </span>
                </td>
                <td>
                    <span class="status-badge {{ $register->status ?? 'pending' }}">
                        @switch($register->status ?? 'pending')
                            @case('pending') ⏳ قيد الانتظار @break
                            @case('processing') 🔄 قيد المعالجة @break
                            @case('approved') ✅ مقبول @break
                            @case('rejected') ❌ مرفوض @break
                            @default ⏳ قيد الانتظار
                        @endswitch
                    </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($register->created_at)->format('Y/m/d') }}</td>
                <td>
                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                        <a href="{{ route('admin.land.registers.show', $register->id) }}" class="btn-view">
                            <span>👁️</span>
                            <span>عرض التفاصيل</span>
                        </a>

                        <form action="{{ route('admin.land.registers.destroy', $register->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                🗑️ حذف
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <div class="icon">📭</div>
                        <p style="font-size: 1.2rem; font-weight: 600; margin-bottom: 0.5rem;">لا توجد طلبات</p>
                        <p>لم يتم تقديم أي طلبات دفتر عقاري حتى الآن</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($registers->hasPages())
    <div style="margin-top: 2rem;">
        {{ $registers->links() }}
    </div>
    @endif
</div>

@endsection