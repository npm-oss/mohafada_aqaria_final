@extends('admin.layout')

@section('title', 'عرض الرسالة')

@section('content')
<style>
    .message-details {
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

    .message-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 5px 25px rgba(26, 86, 50, 0.1);
        margin-bottom: 2rem;
    }

    .message-header {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        text-align: center;
    }

    .message-header h2 {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .message-header .status-badge {
        display: inline-block;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        margin-top: 0.5rem;
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid white;
    }

    .info-row {
        display: grid;
        grid-template-columns: 200px 1fr;
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
        gap: 1rem;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 700;
        color: #1a5632;
        font-size: 1rem;
    }

    .info-value {
        color: #333;
        font-size: 1rem;
    }

    .message-content {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        line-height: 1.8;
        color: #333;
        font-size: 1.1rem;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .section-title {
        font-size: 1.5rem;
        color: #1a5632;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #c49b63;
        font-weight: 700;
    }

    .actions-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 5px 25px rgba(26, 86, 50, 0.1);
    }

    .action-btn {
        padding: 1rem 2rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .btn-reply {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }

    .btn-reply:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(23, 162, 184, 0.3);
    }

    .btn-mark-read {
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
    }

    .btn-mark-read:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
    }

    .btn-mark-unread {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: white;
    }

    .btn-mark-unread:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3);
    }

    .btn-delete {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .btn-delete:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
    }

    .btn-back {
        background: linear-gradient(135deg, #6b7280, #9ca3af);
        color: white;
    }

    .btn-back:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 2px solid #28a745;
    }

    .alert-danger {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 2px solid #dc3545;
    }

    .two-column-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    @media (max-width: 968px) {
        .two-column-layout {
            grid-template-columns: 1fr;
        }

        .info-row {
            grid-template-columns: 1fr;
        }

        .info-label {
            margin-bottom: 0.5rem;
        }
    }
</style>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert alert-success">
    ✓ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    ⚠ {{ session('error') }}
</div>
@endif

<div class="message-details">

    <div class="two-column-layout">
        
        <!-- Main Content -->
        <div>
            
            <!-- Message Header -->
            <div class="message-header">
                <h2>📩 {{ $message->subject }}</h2>
                <span class="status-badge">
                    @if($message->status == 'new')
                        🆕 جديدة
                    @elseif($message->status == 'read')
                        👁️ مقروءة
                    @elseif($message->status == 'replied')
                        ✅ تم الرد
                    @elseif($message->status == 'closed')
                        🔒 مغلقة
                    @else
                        {{ $message->status }}
                    @endif
                </span>
            </div>

            <!-- Sender Info -->
            <div class="message-card">
                <h3 class="section-title">👤 معلومات المرسل</h3>
                
                <div class="info-row">
                    <div class="info-label">الاسم:</div>
                    <div class="info-value">{{ $message->name }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">البريد الإلكتروني:</div>
                    <div class="info-value">
                        <a href="mailto:{{ $message->email }}" style="color: #17a2b8; text-decoration: none;">
                            {{ $message->email }}
                        </a>
                    </div>
                </div>

                @if($message->phone)
                <div class="info-row">
                    <div class="info-label">رقم الهاتف:</div>
                    <div class="info-value">
                        <a href="tel:{{ $message->phone }}" style="color: #17a2b8; text-decoration: none;">
                            {{ $message->phone }}
                        </a>
                    </div>
                </div>
                @endif

                <div class="info-row">
                    <div class="info-label">تاريخ الإرسال:</div>
                    <div class="info-value">
                        📅 {{ $message->created_at->format('Y/m/d H:i') }}
                        <small style="color: #999; margin-right: 10px;">
                            ({{ $message->created_at->diffForHumans() }})
                        </small>
                    </div>
                </div>

                @if($message->read_at)
                <div class="info-row">
                    <div class="info-label">تاريخ القراءة:</div>
                    <div class="info-value">
                        📅 {{ \Carbon\Carbon::parse($message->read_at)->format('Y/m/d H:i') }}
                    </div>
                </div>
                @endif

                @if($message->replied_at)
                <div class="info-row">
                    <div class="info-label">تاريخ الرد:</div>
                    <div class="info-value">
                        📅 {{ \Carbon\Carbon::parse($message->replied_at)->format('Y/m/d H:i') }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Message Content -->
            <div class="message-card">
                <h3 class="section-title">💬 محتوى الرسالة</h3>
                <div class="message-content">{{ $message->message }}</div>
            </div>

            @if($message->reply_content)
            <!-- Reply Content -->
            <div class="message-card">
                <h3 class="section-title">↩️ الرد المرسل</h3>
                <div class="message-content">{{ $message->reply_content }}</div>
            </div>
            @endif

        </div>

        <!-- Actions Sidebar -->
        <div>
            <div class="actions-card">
                <h3 class="section-title">⚙️ الإجراءات</h3>

                <!-- Reply -->
                @if($message->status != 'replied' && $message->status != 'closed')
                <a href="{{ route('admin.messages.reply', $message->id) }}" class="action-btn btn-reply">
                    ↩️ الرد على الرسالة
                </a>
                @endif

                <!-- Mark as Read -->
                @if($message->status == 'new')
                <form action="{{ route('admin.messages.mark-read', $message->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="action-btn btn-mark-read">
                        ✅ تعليم كمقروءة
                    </button>
                </form>
                @endif

                <!-- Mark as Unread -->
                @if($message->status == 'read')
                <form action="{{ route('admin.messages.mark-unread', $message->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="action-btn btn-mark-unread">
                        📭 تعليم كغير مقروءة
                    </button>
                </form>
                @endif

                <!-- Close -->
                @if($message->status != 'closed')
                <form action="{{ route('admin.messages.close', $message->id) }}" method="POST" 
                      onsubmit="return confirm('هل أنت متأكد من إغلاق هذه الرسالة؟')" style="margin: 0;">
                    @csrf
                    <button type="submit" class="action-btn btn-mark-unread">
                        🔒 إغلاق الرسالة
                    </button>
                </form>
                @endif

                <!-- Reopen -->
                @if($message->status == 'closed')
                <form action="{{ route('admin.messages.reopen', $message->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="action-btn btn-mark-read">
                        🔓 إعادة فتح الرسالة
                    </button>
                </form>
                @endif

                <!-- Back -->
                <a href="{{ route('admin.messages.index') }}" class="action-btn btn-back">
                    ← رجوع للقائمة
                </a>

                <!-- Delete -->
                <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" 
                      onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn btn-delete">
                        🗑️ حذف الرسالة
                    </button>
                </form>

            </div>

            <!-- Message Info Card -->
            <div class="message-card" style="margin-top: 2rem;">
                <h3 class="section-title">ℹ️ معلومات إضافية</h3>
                
                <div class="info-row">
                    <div class="info-label">رقم الرسالة:</div>
                    <div class="info-value">#{{ $message->id }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">نوع الموضوع:</div>
                    <div class="info-value">
                        @if($message->subject == 'inquiry')
                            ❓ استفسار
                        @elseif($message->subject == 'complaint')
                            📢 شكوى
                        @elseif($message->subject == 'suggestion')
                            💡 اقتراح
                        @elseif($message->subject == 'other')
                            📝 أخرى
                        @else
                            {{ $message->subject }}
                        @endif
                    </div>
                </div>

                @if($message->ip_address)
                <div class="info-row">
                    <div class="info-label">عنوان IP:</div>
                    <div class="info-value">{{ $message->ip_address }}</div>
                </div>
                @endif

                @if($message->user_agent)
                <div class="info-row">
                    <div class="info-label">المتصفح:</div>
                    <div class="info-value" style="font-size: 0.85rem; color: #666;">
                        {{ $message->user_agent }}
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>

</div>
@endsection