@extends('admin.layout')

@section('title', 'الرد على الرسالة')

@section('content')
<style>
    .reply-page {
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

    .reply-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 5px 25px rgba(26, 86, 50, 0.1);
    }

    .card-title {
        font-size: 1.5rem;
        color: #1a5632;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #c49b63;
        font-weight: 700;
    }

    .info-row {
        display: grid;
        grid-template-columns: 150px 1fr;
        padding: 0.8rem 0;
        border-bottom: 1px solid #f0f0f0;
        gap: 1rem;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 700;
        color: #1a5632;
    }

    .info-value {
        color: #333;
    }

    .message-preview {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        margin-top: 1rem;
        line-height: 1.8;
        color: #555;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        color: #1a5632;
        margin-bottom: 0.8rem;
        font-size: 1rem;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #1a5632;
        box-shadow: 0 0 0 3px rgba(26, 86, 50, 0.1);
    }

    .form-group textarea {
        min-height: 200px;
        resize: vertical;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
        flex: 1;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(26, 86, 50, 0.3);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6b7280, #9ca3af);
        color: white;
    }

    .btn-secondary:hover {
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

    .error-text {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: block;
    }

    .char-counter {
        text-align: left;
        font-size: 0.85rem;
        color: #999;
        margin-top: 0.5rem;
    }

    .template-selector {
        margin-bottom: 1rem;
    }

    .template-btn {
        padding: 0.6rem 1.2rem;
        background: #f0f0f0;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.9rem;
        cursor: pointer;
        margin-left: 0.5rem;
        transition: all 0.3s ease;
    }

    .template-btn:hover {
        background: #e0e0e0;
        border-color: #1a5632;
    }

    @media (max-width: 968px) {
        .reply-container {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .info-row {
            grid-template-columns: 1fr;
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

@if($errors->any())
<div class="alert alert-danger">
    <div>
        <strong>⚠ يوجد أخطاء في النموذج:</strong>
        <ul style="margin: 0.5rem 0 0 1.5rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="reply-page">

    <div class="reply-container">

        <!-- Original Message -->
        <div class="card">
            <h3 class="card-title">📩 الرسالة الأصلية</h3>

            <div class="info-row">
                <div class="info-label">من:</div>
                <div class="info-value">{{ $message->name }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">البريد:</div>
                <div class="info-value">
                    <a href="mailto:{{ $message->email }}" style="color: #17a2b8; text-decoration: none;">
                        {{ $message->email }}
                    </a>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">الموضوع:</div>
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

            <div class="info-row">
                <div class="info-label">التاريخ:</div>
                <div class="info-value">
                    {{ $message->created_at->format('Y/m/d H:i') }}
                </div>
            </div>

            <div style="margin-top: 1.5rem;">
                <strong style="color: #1a5632; display: block; margin-bottom: 0.8rem;">💬 محتوى الرسالة:</strong>
                <div class="message-preview">{{ $message->message }}</div>
            </div>

        </div>

        <!-- Reply Form -->
        <div class="card">
            <h3 class="card-title">↩️ كتابة الرد</h3>

            <form action="{{ route('admin.messages.reply.send', $message->id) }}" method="POST">
                @csrf

                <!-- Email To -->
                <div class="form-group">
                    <label>إلى: (البريد الإلكتروني)</label>
                    <input type="email" name="to_email" value="{{ old('to_email', $message->email) }}" required readonly style="background: #f0f0f0;">
                </div>

                <!-- Subject -->
                <div class="form-group">
                    <label>عنوان الرد:</label>
                    <input type="text" name="subject" value="{{ old('subject', 'رد على: ' . $message->subject) }}" required>
                    @error('subject')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Reply Templates -->
                <div class="template-selector">
                    <label style="font-weight: 700; color: #1a5632; display: block; margin-bottom: 0.5rem;">
                        📝 قوالب جاهزة (اختياري):
                    </label>
                    <button type="button" class="template-btn" onclick="insertTemplate('thanks')">شكراً</button>
                    <button type="button" class="template-btn" onclick="insertTemplate('received')">تم الاستلام</button>
                    <button type="button" class="template-btn" onclick="insertTemplate('processing')">قيد المعالجة</button>
                    <button type="button" class="template-btn" onclick="insertTemplate('completed')">تم الإنجاز</button>
                </div>

                <!-- Reply Content -->
                <div class="form-group">
                    <label>محتوى الرد: *</label>
                    <textarea name="reply_message" id="replyContent" required>{{ old('reply_message') }}</textarea>
                    <div class="char-counter">
                        <span id="charCount">0</span> حرف
                    </div>
                    @error('reply_message')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        📤 إرسال الرد
                    </button>
                    <a href="{{ route('admin.messages.show', $message->id) }}" class="btn btn-secondary">
                        ← إلغاء
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>

<script>
// Character counter
const replyContent = document.getElementById('replyContent');
const charCount = document.getElementById('charCount');

replyContent.addEventListener('input', function() {
    charCount.textContent = this.value.length;
});

// Update on load
charCount.textContent = replyContent.value.length;

// Reply templates
const templates = {
    thanks: `السلام عليكم ورحمة الله وبركاته,

شكراً لتواصلكم معنا. نحن نقدر وقتكم واهتمامكم.

سيتم الرد على استفساركم في أقرب وقت ممكن.

مع أطيب التحيات,
المحافظة العقارية`,

    received: `السلام عليكم ورحمة الله وبركاته,

تم استلام رسالتكم بنجاح.

رقم المرجع: #${document.querySelector('[name="to_email"]').value}

سيتم التواصل معكم قريباً.

مع أطيب التحيات,
المحافظة العقارية`,

    processing: `السلام عليكم ورحمة الله وبركاته,

نود إعلامكم بأن طلبكم قيد المعالجة حالياً.

سيتم إنجاز المعاملة في أقرب وقت ممكن.

مع أطيب التحيات,
المحافظة العقارية`,

    completed: `السلام عليكم ورحمة الله وبركاته,

يسرنا إعلامكم بأنه تم إنجاز طلبكم بنجاح.

شكراً لثقتكم بخدماتنا.

مع أطيب التحيات,
المحافظة العقارية`
};

function insertTemplate(templateName) {
    if (templates[templateName]) {
        replyContent.value = templates[templateName];
        charCount.textContent = replyContent.value.length;
        replyContent.focus();
    }
}

// Confirm before leaving if content exists
let formSubmitted = false;

document.querySelector('form').addEventListener('submit', function() {
    formSubmitted = true;
});

window.addEventListener('beforeunload', function(e) {
    if (!formSubmitted && replyContent.value.trim().length > 0) {
        e.preventDefault();
        e.returnValue = '';
    }
});
</script>
@endsection