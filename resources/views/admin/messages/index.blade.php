<!-- resources/views/admin/messages/index.blade.php -->

@extends('admin.layout')

@section('content')
<style>
    .messages-container {
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
        background: white;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 5px 25px rgba(26, 86, 50, 0.1);
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-header h2 {
        font-size: 2rem;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .filter-section {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
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
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .stat-box .label {
        color: var(--text-light);
        font-size: 0.9rem;
    }

    .messages-grid {
        display: grid;
        gap: 1.5rem;
    }

    .message-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 3px 15px rgba(26, 86, 50, 0.1);
        transition: all 0.3s ease;
        border-right: 5px solid transparent;
    }

    .message-card:hover {
        transform: translateX(-5px);
        box-shadow: 0 8px 25px rgba(26, 86, 50, 0.15);
    }

    .message-card.new {
        border-right-color: #ff9800;
        background: rgba(255, 193, 7, 0.02);
    }

    .message-card.read {
        border-right-color: #17a2b8;
    }

    .message-card.replied {
        border-right-color: #28a745;
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        gap: 1rem;
    }

    .message-sender {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .sender-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .sender-info h4 {
        margin: 0;
        color: var(--text-dark);
        font-size: 1.1rem;
    }

    .sender-info p {
        margin: 0;
        color: var(--text-light);
        font-size: 0.85rem;
    }

    .message-status {
        display: inline-block;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .message-status.new {
        background: rgba(255, 193, 7, 0.1);
        color: #ff9800;
    }

    .message-status.read {
        background: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
    }

    .message-status.replied {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .message-subject {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 0.8rem;
    }

    .message-preview {
        color: var(--text-light);
        margin-bottom: 1rem;
        line-height: 1.6;
    }

    .message-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid var(--bg-light);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .message-date {
        color: var(--text-light);
        font-size: 0.85rem;
    }

    .message-actions {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .action-btn.view {
        background: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
    }

    .action-btn.view:hover {
        background: #17a2b8;
        color: white;
    }

    .action-btn.reply {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .action-btn.reply:hover {
        background: #28a745;
        color: white;
    }

    .action-btn.delete {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .action-btn.delete:hover {
        background: #dc3545;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 3px 15px rgba(26, 86, 50, 0.1);
    }

    .empty-state .icon {
        font-size: 5rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .subject-icon {
        font-size: 1.2rem;
        margin-left: 0.5rem;
    }

    @media (max-width: 768px) {
        .message-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .message-meta {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="messages-container">

    <!-- Page Header -->
    <div class="page-header">
        <h2>
            <span>📩</span>
            <span>الرسائل</span>
        </h2>
        <div class="filter-section">
            <button class="filter-btn active" onclick="filterByStatus('all')">الكل</button>
            <button class="filter-btn" onclick="filterByStatus('new')">جديدة</button>
            <button class="filter-btn" onclick="filterByStatus('read')">مقروءة</button>
            <button class="filter-btn" onclick="filterByStatus('replied')">تم الرد</button>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-box">
            <div class="number">{{ isset($messages) ? $messages->total() : 0 }}</div>
            <div class="label">إجمالي الرسائل</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ isset($messages) ? $messages->where('status', 'new')->count() : 0 }}</div>
            <div class="label">رسائل جديدة</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ isset($messages) ? $messages->where('status', 'read')->count() : 0 }}</div>
            <div class="label">مقروءة</div>
        </div>
        <div class="stat-box">
            <div class="number">{{ isset($messages) ? $messages->where('status', 'replied')->count() : 0 }}</div>
            <div class="label">تم الرد عليها</div>
        </div>
    </div>

    <!-- Messages Grid -->
    <div class="messages-grid">
        @forelse($messages ?? [] as $message)
        <div class="message-card {{ $message->status ?? 'new' }}">
            
            <!-- Message Header -->
            <div class="message-header">
                <div class="message-sender">
                    <div class="sender-avatar">
                        {{ substr($message->name ?? 'M', 0, 1) }}
                    </div>
                    <div class="sender-info">
                        <h4>{{ $message->name ?? 'مواطن' }}</h4>
                        <p>{{ $message->email ?? '-' }} • {{ $message->phone ?? '-' }}</p>
                    </div>
                </div>
                <span class="message-status {{ $message->status ?? 'new' }}">
                    @if(($message->status ?? 'new') == 'new')
                        🆕 جديدة
                    @elseif($message->status == 'read')
                        👁️ مقروءة
                    @elseif($message->status == 'replied')
                        ✅ تم الرد
                    @else
                        {{ $message->status }}
                    @endif
                </span>
            </div>

            <!-- Message Subject -->
            <div class="message-subject">
                <span class="subject-icon">
                    @if(isset($message->subject))
                        @if($message->subject == 'inquiry')
                            💬
                        @elseif($message->subject == 'complaint')
                            ⚠️
                        @elseif($message->subject == 'suggestion')
                            💡
                        @elseif($message->subject == 'support')
                            🛟
                        @else
                            📧
                        @endif
                    @else
                        📧
                    @endif
                </span>
                {{ $message->subject_text ?? 'رسالة عامة' }}
            </div>

            <!-- Message Preview -->
            <div class="message-preview">
                {{ Str::limit($message->message ?? 'لا يوجد محتوى', 150) }}
            </div>

            <!-- Message Meta -->
            <div class="message-meta">
                <span class="message-date">
                    📅 {{ $message->created_at ? $message->created_at->diffForHumans() : '-' }}
                </span>
                <div class="message-actions">
                    <a href="{{ route('admin.messages.show', $message->id) }}" class="action-btn view">
                        <span>👁️</span>
                        <span>عرض</span>
                    </a>
                    @if($message->status != 'replied')
                    <a href="{{ route('admin.messages.reply', $message->id) }}" class="action-btn reply">
                        <span>↩️</span>
                        <span>رد</span>
                    </a>
                    @endif
                    <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete">
                            <span>🗑️</span>
                            <span>حذف</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @empty
        <div class="empty-state">
            <div class="icon">📭</div>
            <h3>لا توجد رسائل حالياً</h3>
            <p>لم يتم استلام أي رسائل من المواطنين بعد</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($messages) && $messages->hasPages())
    <div style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $messages->links() }}
    </div>
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
        window.location.href = "{{ route('admin.messages.index') }}";
    } else {
        window.location.href = "{{ route('admin.messages.index') }}?status=" + status;
    }
}
</script>
@endsection