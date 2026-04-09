@extends('admin.layout')

@section('content')
<style>
    .extract-container {
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

    .page-requests {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 5px 25px rgba(26, 86, 50, 0.1);
    }

    .card-title {
        font-size: 2rem;
        color: #1a5632;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #c49b63;
        font-weight: 700;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
    }

    table thead {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
    }

    table thead th {
        padding: 1rem;
        text-align: right;
        font-weight: 600;
        font-size: 1rem;
    }

    table tbody tr {
        border-bottom: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    table tbody tr:hover {
        background: rgba(26, 86, 50, 0.05);
        transform: translateX(-5px);
    }

    table tbody td {
        padding: 1rem;
        text-align: right;
        color: #333;
    }

    .top-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .btn-process,
    .btn-approve,
    .btn-reject,
    .btn-delete {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .btn-process {
        background: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
        border: 2px solid #17a2b8;
    }

    .btn-process:hover {
        background: #17a2b8;
        color: white;
    }

    .btn-approve {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 2px solid #28a745;
    }

    .btn-approve:hover {
        background: #28a745;
        color: white;
    }

    .btn-reject {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 2px solid #dc3545;
    }

    .btn-reject:hover {
        background: #dc3545;
        color: white;
    }

    .btn-delete {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 2px solid #6c757d;
    }

    .btn-delete:hover {
        background: #6c757d;
        color: white;
    }

    .filter-section {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 0.6rem 1.2rem;
        border: 2px solid #e0e0e0;
        background: white;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: #1a5632;
        color: white;
        border-color: #1a5632;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-box {
        background: white;
        padding: 1.5rem;
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

    .status-badge {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-badge.pending {
        background: rgba(255, 193, 7, 0.1);
        color: #ff9800;
        border: 2px solid rgba(255, 193, 7, 0.3);
    }

    .status-badge.processing {
        background: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
        border: 2px solid rgba(23, 162, 184, 0.3);
    }

    .status-badge.approved {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 2px solid rgba(40, 167, 69, 0.3);
    }

    .status-badge.rejected {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 2px solid rgba(220, 53, 69, 0.3);
    }

    .type-badge {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        display: inline-block;
        border: 2px solid;
    }

    .type-badge.new {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.15), rgba(40, 167, 69, 0.05));
        color: #28a745;
        border-color: rgba(40, 167, 69, 0.3);
    }

    .type-badge.reprint {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.15), rgba(23, 162, 184, 0.05));
        color: #17a2b8;
        border-color: rgba(23, 162, 184, 0.3);
    }

    @media (max-width: 768px) {
        table {
            font-size: 0.85rem;
        }

        .top-actions {
            flex-direction: column;
        }

        .btn-process,
        .btn-approve,
        .btn-reject,
        .btn-delete {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="extract-container">
    <div class="page-requests">
        <div class="card-title">📄 قائمة طلبات الشهادات السلبية</div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat-box">
                <div class="number">{{ \App\Models\NegativeCertificate::count() }}</div>
                <div class="label">إجمالي الطلبات</div>
            </div>
            <div class="stat-box">
                <div class="number">{{ \App\Models\NegativeCertificate::where('status', 'pending')->count() }}</div>
                <div class="label">قيد الانتظار</div>
            </div>
            <div class="stat-box">
                <div class="number">{{ \App\Models\NegativeCertificate::where('status', 'approved')->count() }}</div>
                <div class="label">موافق عليها</div>
            </div>
            <div class="stat-box">
                <div class="number">{{ \App\Models\NegativeCertificate::where('status', 'rejected')->count() }}</div>
                <div class="label">مرفوضة</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-section">
            <button class="filter-btn active" onclick="filterByStatus('all')">الكل</button>
            <button class="filter-btn" onclick="filterByStatus('pending')">قيد الانتظار</button>
            <button class="filter-btn" onclick="filterByStatus('processing')">قيد المعالجة</button>
            <button class="filter-btn" onclick="filterByStatus('approved')">موافق عليها</button>
            <button class="filter-btn" onclick="filterByStatus('rejected')">مرفوضة</button>
        </div>

        <!-- Table -->
         <table>
            <thead>
                 <tr>
                    <th>الاسم الكامل</th>
                    <th>البريد الإلكتروني</th>
                    <th>نوع الطلب</th>
                    <th>الحالة</th>
                    <th>التاريخ</th>
                    <th>إجراءات</th>
                 </tr>
            </thead>
            <tbody>
                @forelse($certificates as $certificate)
                 <tr>
                    <td>{{ $certificate->owner_firstname }} {{ $certificate->owner_lastname }}</td>
                    <td>{{ $certificate->email }}</td>
                    <td>
                        @if($certificate->type == 'new')
                            <span class="type-badge new">
                                🆕 جديدة
                            </span>
                        @elseif($certificate->type == 'reprint')
                            <span class="type-badge reprint">
                                🔄 إعادة استخراج
                            </span>
                        @else
                            <span class="type-badge" style="background: linear-gradient(135deg, rgba(108, 117, 125, 0.15), rgba(108, 117, 125, 0.05)); color: #6c757d; border-color: rgba(108, 117, 125, 0.3);">
                                {{ $certificate->type }}
                            </span>
                        @endif
                    </td>
                    <td>
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
                    </td>
                    <td>{{ $certificate->created_at->format('Y/m/d') }}</td>
                    <td class="top-actions">
                        <a href="{{ route('admin.certificates.show', $certificate->id) }}" class="btn-process">
                            👁️ عرض
                        </a>

                        @if($certificate->status === 'pending')
                        <form action="{{ route('admin.certificates.approve', $certificate->id) }}" method="POST" style="display:inline" onsubmit="return confirm('هل أنت متأكد من الموافقة على هذا الطلب؟')">
                            @csrf
                            <button type="submit" class="btn-approve">✅ موافقة</button>
                        </form>

                        <form action="{{ route('admin.certificates.reject', $certificate->id) }}" method="POST" style="display:inline" onsubmit="return confirm('هل أنت متأكد من رفض هذا الطلب؟')">
                            @csrf
                            <button type="submit" class="btn-reject">❌ رفض</button>
                        </form>
                        @endif

                        <!-- زر الحذف (يظهر دائماً) -->
                        <form action="{{ route('admin.certificates.destroy', $certificate->id) }}" method="POST" style="display:inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟ لا يمكن التراجع.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">🗑️ حذف</button>
                        </form>
                    </td>
                 </tr>
                @empty
                 <tr>
                    <td colspan="6" style="text-align:center; font-weight:bold; color:#c9a24d; padding: 3rem;">
                        📭 لا توجد طلبات حالياً
                    </td>
                 </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if(method_exists($certificates, 'hasPages') && $certificates->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $certificates->links() }}
        </div>
        @endif
    </div>
</div>

<script>
// Filter by status
function filterByStatus(status) {
    // Update active button
    event.target.classList.add('active');
    // Redirect with filter
    if (status === 'all') {
        window.location.href = "{{ route('admin.certificates.index') }}";
    } else {
        window.location.href = "{{ route('admin.certificates.index') }}?status=" + status;
    }
}
</script>
@endsection