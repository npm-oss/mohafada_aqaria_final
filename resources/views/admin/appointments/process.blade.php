@extends('admin.layout')

@section('title', 'معالجة الموعد #' . $appointment->id)

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap');
    
    * { font-family: 'Cairo', sans-serif; }

    .page-header {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 15px 40px rgba(255, 193, 7, 0.4);
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
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
        animation: rotate 25s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .page-header h1 {
        font-size: 2.3rem;
        font-weight: 900;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin: 0 0 0.7rem 0;
        position: relative;
        z-index: 2;
    }

    .page-header p {
        opacity: 0.95;
        font-size: 1.15rem;
        position: relative;
        z-index: 2;
    }

    .process-container {
        max-width: 850px;
        margin: 0 auto;
    }

    .info-card {
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

    .appointment-summary {
        background: linear-gradient(135deg, #f8f6f1, #fff);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 3px solid #e0e0e0;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 2px solid rgba(0,0,0,0.05);
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-label {
        color: #7f8c8d;
        font-weight: 600;
        font-size: 1rem;
    }

    .summary-value {
        color: #2d2d2d;
        font-weight: 700;
        font-size: 1.05rem;
    }

    .decision-section {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        animation: fadeInUp 0.6s ease 0.2s backwards;
    }

    .section-title {
        font-size: 1.7rem;
        font-weight: 900;
        color: #1a5632;
        margin-bottom: 2.5rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding-bottom: 1.2rem;
        border-bottom: 3px solid #f0f0f0;
    }

    .decision-buttons {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 2.5rem;
    }

    .decision-card {
        border: 4px solid;
        border-radius: 18px;
        padding: 2.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .decision-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.6s ease;
    }

    .decision-card:hover::before {
        left: 100%;
    }

    .decision-card.confirm {
        border-color: #28a745;
        background: rgba(40, 167, 69, 0.05);
    }

    .decision-card.confirm:hover {
        background: rgba(40, 167, 69, 0.12);
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(40, 167, 69, 0.3);
    }

    .decision-card.cancel {
        border-color: #dc3545;
        background: rgba(220, 53, 69, 0.05);
    }

    .decision-card.cancel:hover {
        background: rgba(220, 53, 69, 0.12);
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(220, 53, 69, 0.3);
    }

    .decision-card.selected {
        transform: scale(1.05);
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    }

    .decision-card input[type="radio"] {
        display: none;
    }

    .decision-icon {
        font-size: 4.5rem;
        margin-bottom: 1.5rem;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .decision-card.confirm .decision-icon {
        color: #28a745;
    }

    .decision-card.cancel .decision-icon {
        color: #dc3545;
    }

    .decision-title {
        font-size: 1.4rem;
        font-weight: 900;
        margin-bottom: 0.7rem;
    }

    .decision-card.confirm .decision-title {
        color: #28a745;
    }

    .decision-card.cancel .decision-title {
        color: #dc3545;
    }

    .decision-desc {
        color: #7f8c8d;
        font-size: 1rem;
        font-weight: 600;
    }

    .email-preview {
        background: linear-gradient(135deg, #f8f6f1, #fff);
        border: 3px solid #c9a063;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2.5rem;
        display: none;
        animation: slideDown 0.5s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .email-preview.active {
        display: block;
    }

    .email-preview h4 {
        color: #1a5632;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        font-size: 1.3rem;
    }

    .email-content {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        border-right: 5px solid #c9a063;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .email-subject {
        font-weight: 700;
        color: #2d2d2d;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e0e0e0;
        font-size: 1.15rem;
    }

    .email-body {
        color: #5d4037;
        line-height: 2;
        font-size: 1.05rem;
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-label {
        display: block;
        font-weight: 700;
        color: #1a5632;
        margin-bottom: 0.8rem;
        font-size: 1.1rem;
    }

    .form-control {
        width: 100%;
        padding: 1.2rem;
        border: 3px solid #e0e0e0;
        border-radius: 12px;
        font-family: 'Cairo', sans-serif;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        resize: vertical;
    }

    .form-control:focus {
        outline: none;
        border-color: #1a5632;
        box-shadow: 0 0 0 5px rgba(26, 86, 50, 0.1);
        transform: translateY(-2px);
    }

    .submit-btn {
        width: 100%;
        padding: 1.4rem;
        border: none;
        border-radius: 15px;
        font-size: 1.3rem;
        font-weight: 900;
        cursor: pointer;
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.7rem;
        position: relative;
        overflow: hidden;
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .submit-btn:hover::before {
        width: 400px;
        height: 400px;
    }

    .submit-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .submit-btn.confirm-btn {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .submit-btn.confirm-btn:hover:not(:disabled) {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(40, 167, 69, 0.5);
    }

    .submit-btn.cancel-btn {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .submit-btn.cancel-btn:hover:not(:disabled) {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(220, 53, 69, 0.5);
    }

    .back-link {
        display: inline-block;
        margin-top: 1.5rem;
        color: #1a5632;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        justify-content: center;
    }

    .back-link:hover {
        transform: translateX(-8px);
        color: #c9a063;
    }

    @media (max-width: 768px) {
        .decision-buttons {
            grid-template-columns: 1fr;
        }
        
        .page-header h1 {
            font-size: 1.8rem;
        }
    }
</style>

<div class="page-header">
    <h1>
        <span>⚙️</span>
        <span>معالجة الموعد</span>
    </h1>
    <p>اتخذ القرار المناسب وسيتم إرسال إيميل تلقائي للعميل</p>
</div>

<div class="process-container">
    
    <!-- ملخص الموعد -->
    <div class="info-card">
        <h3 class="section-title">📋 معلومات الموعد</h3>
        <div class="appointment-summary">
            <div class="summary-row">
                <span class="summary-label">🆔 رقم الموعد:</span>
                <span class="summary-value">#{{ $appointment->id }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">👤 اسم العميل:</span>
                <span class="summary-value">{{ $appointment->firstname }} {{ $appointment->lastname }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">📧 البريد الإلكتروني:</span>
                <span class="summary-value">{{ $appointment->email }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">📱 رقم الهاتف:</span>
                <span class="summary-value" dir="ltr">{{ $appointment->display_phone }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">📅 التاريخ:</span>
                <span class="summary-value">{{ $appointment->booking_date->format('Y/m/d') }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">🔖 نوع الخدمة:</span>
                <span class="summary-value">{{ $appointment->service_type }}</span>
            </div>
        </div>
    </div>

    <!-- نموذج القرار -->
    <div class="decision-section">
        <h3 class="section-title">✅❌ اتخاذ القرار</h3>
        
        <form method="POST" action="{{ route('admin.appointments.updateStatus', $appointment->id) }}" id="processForm">
            @csrf
            
            <div class="decision-buttons">
                <div class="decision-card confirm" onclick="selectDecision('confirmed', this)">
                    <input type="radio" name="decision" value="confirmed" id="confirm">
                    <div class="decision-icon">✅</div>
                    <div class="decision-title">تأكيد الموعد</div>
                    <div class="decision-desc">سيتم إرسال إيميل تأكيد تلقائي للعميل</div>
                </div>

                <div class="decision-card cancel" onclick="selectDecision('cancelled', this)">
                    <input type="radio" name="decision" value="cancelled" id="cancel">
                    <div class="decision-icon">❌</div>
                    <div class="decision-title">إلغاء الموعد</div>
                    <div class="decision-desc">سيتم إرسال إيميل إلغاء تلقائي للعميل</div>
                </div>
            </div>

            <!-- معاينة الإيميل -->
            <div class="email-preview" id="emailPreview">
                <h4>📧 معاينة الإيميل الذي سيتم إرساله</h4>
                <div class="email-content">
                    <div class="email-subject" id="emailSubject"></div>
                    <div class="email-body" id="emailBody"></div>
                </div>
            </div>

            <!-- ملاحظات اختيارية -->
            <div class="form-group">
                <label class="form-label">📝 ملاحظات إضافية (اختياري)</label>
                <textarea name="admin_notes" class="form-control" rows="5" placeholder="أضف أي ملاحظات تريد إرسالها للعميل..."></textarea>
                <input type="hidden" name="confirmation_message" id="confirmation_message">
            </div>

            <button type="submit" class="submit-btn" id="submitBtn" disabled>
                <span>📨</span>
                <span>إرسال القرار والإيميل</span>
            </button>
        </form>

        <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="back-link">
            <span>←</span>
            <span>العودة لتفاصيل الموعد</span>
        </a>
    </div>

</div>
<script>
let selectedDecision = '';

function selectDecision(decision, element) {

    selectedDecision = decision;

    document.querySelectorAll('.decision-card').forEach(card => {
        card.classList.remove('selected');
    });

    element.classList.add('selected');

    document.getElementById(decision === 'confirmed' ? 'confirm' : 'cancel').checked = true;

    const preview = document.getElementById('emailPreview');
    const subject = document.getElementById('emailSubject');
    const body = document.getElementById('emailBody');
    const submitBtn = document.getElementById('submitBtn');
    const hiddenInput = document.getElementById('confirmation_message');

    preview.classList.add('active');
    submitBtn.disabled = false;

    if (decision === 'confirmed') {

        subject.textContent = 'تم تأكيد موعدك';

        body.innerHTML = `
            مرحباً مرحباً {{ $appointment->firstname }} {{ $appointment->lastname }}<br>
            تم تأكيد موعدك بتاريخ {{ $appointment->booking_date->format('Y/m/d') }}<br>
            نوع الخدمة: {{ $appointment->service_type }}
        `;

        hiddenInput.value = body.innerText;

        submitBtn.className = 'submit-btn confirm-btn';
        submitBtn.innerHTML = '<span>✅</span><span>تأكيد وإرسال الإيميل</span>';

    } else {

        subject.textContent = 'تم إلغاء موعدك';

        body.innerHTML = `
            مرحباً مرحباً {{ $appointment->firstname }} {{ $appointment->lastname }}<br>
            تم إلغاء موعدك بتاريخ {{ $appointment->booking_date->format('Y/m/d') }}
        `;

        hiddenInput.value = body.innerText;

        submitBtn.className = 'submit-btn cancel-btn';
        submitBtn.innerHTML = '<span>❌</span><span>إلغاء وإرسال الإيميل</span>';
    }
}

// تأكيد قبل الإرسال
document.getElementById('processForm').addEventListener('submit', function(e) {
    if (!confirm('هل أنت متأكد من هذا القرار؟ سيتم إرسال إيميل تلقائي للعميل.')) {
        e.preventDefault();
    }
});
</script>

@endsection
