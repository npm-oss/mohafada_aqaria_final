@extends('admin.layout')

@section('content')
<style>
    .document-requests-container {
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

    .requests-title {
        font-size: 2rem;
        color: #1a5632;
        margin-bottom: 2rem;
        padding: 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 25px rgba(26, 86, 50, 0.1);
        text-align: center;
        font-weight: 700;
    }

    .no-requests {
        background: white;
        padding: 4rem 2rem;
        border-radius: 20px;
        text-align: center;
        font-size: 1.5rem;
        color: #c49b63;
        font-weight: 600;
        box-shadow: 0 5px 25px rgba(26, 86, 50, 0.1);
    }

    .requests-table {
        width: 100%;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 25px rgba(26, 86, 50, 0.1);
        border-collapse: collapse;
    }

    .requests-table thead {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
    }

    .requests-table thead th {
        padding: 1.2rem;
        text-align: right;
        font-weight: 600;
        font-size: 1rem;
    }

    .requests-table tbody tr {
        border-bottom: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .requests-table tbody tr:hover {
        background: rgba(26, 86, 50, 0.05);
        transform: translateX(-5px);
    }

    .requests-table tbody tr:last-child {
        border-bottom: none;
    }

    .requests-table tbody td {
        padding: 1.2rem;
        text-align: right;
        color: #333;
        font-size: 0.95rem;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .badge.approved {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 2px solid #28a745;
    }

    .badge.rejected {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 2px solid #dc3545;
    }

    .badge.pending {
        background: rgba(255, 193, 7, 0.1);
        color: #ff9800;
        border: 2px solid #ff9800;
    }

    /* Actions */
    .actions-cell {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .btn {
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .view-btn {
        background: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
        border: 2px solid #17a2b8;
    }

    .view-btn:hover {
        background: #17a2b8;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
    }

    .approve-btn {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 2px solid #28a745;
    }

    .approve-btn:hover {
        background: #28a745;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .reject-btn {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 2px solid #dc3545;
    }

    .reject-btn:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }

    .delete-btn {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: 2px solid #6c757d;
    }

    .delete-btn:hover {
        background: #6c757d;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }

    /* Stats Row */
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

    /* Filters */
    .filter-section {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 3px 15px rgba(26, 86, 50, 0.1);
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

    /* Responsive */
    @media (max-width: 768px) {
        .requests-table {
            font-size: 0.85rem;
        }

        .actions-cell {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .requests-table thead th,
        .requests-table tbody td {
            padding: 0.8rem;
        }
    }
</style>

<div class="document-requests-container">

    <!-- Page Title -->
    <h2 class="requests-title">📄 قائمة طلبات البطاقات العقارية</h2>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-box">
            <div class="number">{{ $requests->total() }}</div>
            <div class="label">إجمالي الطلبات</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ $requests->where('status', 'pending')->count() }}</div>
            <div class="label">قيد المعالجة</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ $requests->where('status', 'approved')->count() }}</div>
            <div class="label">موافق عليها</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ $requests->where('status', 'rejected')->count() }}</div>
            <div class="label">مرفوضة</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <button class="filter-btn active" onclick="filterByStatus('all')">الكل</button>
        <button class="filter-btn" onclick="filterByStatus('pending')">قيد المعالجة</button>
        <button class="filter-btn" onclick="filterByStatus('approved')">موافق عليها</button>
        <button class="filter-btn" onclick="filterByStatus('rejected')">مرفوضة</button>
    </div>

    @if($requests->isEmpty())
        <div class="no-requests">
            📭 لا توجد أي طلبات حالياً
        </div>
    @else

        <table class="requests-table">
            <thead>
                 <tr>
                    <th>صاحب الطلب</th>
                    <th>الحالة</th>
                    <th>تاريخ الإيداع</th>
                    <th>الإجراءات</th>
                 </tr>
            </thead>

            <tbody>
            @foreach($requests as $req)
                <tr>

                    {{-- صاحب الطلب --}}
                    <td>
                        <strong>
                            {{ $req->applicant_lastname ?? '-' }}
                            {{ $req->applicant_firstname ?? '' }}
                        </strong>
                    </td>

                    {{-- الحالة --}}
                    <td>
                        @if($req->status === 'approved')
                            <span class="badge approved">✅ موافق</span>
                        @elseif($req->status === 'rejected')
                            <span class="badge rejected">❌ مرفوض</span>
                        @else
                            <span class="badge pending">⏳ قيد المعالجة</span>
                        @endif
                    </td>

                    {{-- التاريخ --}}
                    <td>
                        📅 {{ $req->created_at ? $req->created_at->format('d/m/Y') : '-' }}
                    </td>

                    {{-- الإجراءات --}}
                    <td class="actions-cell">
                        <a href="{{ route('admin.documents.show', $req->id) }}" class="btn view-btn">
                            👁️ عرض
                        </a>

                        @if($req->status === 'pending')
                        <form action="{{ route('admin.documents.approve', $req->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من الموافقة على هذا الطلب؟')">
                            @csrf
                            <button type="submit" class="btn approve-btn">
                                ✅ موافقة
                            </button>
                        </form>

                        <form action="{{ route('admin.documents.reject', $req->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من رفض هذا الطلب؟')">
                            @csrf
                            <button type="submit" class="btn reject-btn">
                                ❌ رفض
                            </button>
                        </form>
                        @endif

                        {{-- زر الحذف --}}
                        <form action="{{ route('admin.documents.destroy', $req->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('⚠️ هل أنت متأكد من حذف هذا الطلب نهائياً؟ لا يمكن التراجع.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn delete-btn">
                                🗑️ حذف
                            </button>
                        </form>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        @if($requests->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $requests->links() }}
        </div>
        @endif

    @endif

</div>

<script>
// Filter by status
function filterByStatus(status) {
    // Update active button
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Redirect with filter
    if (status === 'all') {
        window.location.href = "{{ route('admin.documents.index') }}";
    } else {
        window.location.href = "{{ route('admin.documents.index') }}?status=" + status;
    }
}
</script>
@endsection