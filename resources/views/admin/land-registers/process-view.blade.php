@extends('admin.layout')

@section('title', 'معالجة الطلب #' . $register->id)

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap');
    
    * {
        font-family: 'Cairo', sans-serif;
    }

    .process-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .page-header {
        background: linear-gradient(135deg, #1a5632 0%, #0d3d20 50%, #1a5632 100%);
        padding: 2.5rem;
        border-radius: 20px;
        margin-bottom: 2.5rem;
        color: white;
        box-shadow: 0 10px 40px rgba(26, 86, 50, 0.3);
        text-align: center;
        position: relative;
        overflow: hidden;
        animation: slideInDown 0.6s ease;
    }

    @keyframes slideInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .page-header h1 {
        font-size: 2rem;
        margin-bottom: 0.8rem;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        font-weight: 900;
    }

    .page-header p {
        font-size: 1.1rem;
        opacity: 0.95;
        position: relative;
        z-index: 1;
    }

    .analysis-grid {
        display: grid;
        grid-template-columns: 1fr;
        max-width: 500px;
        margin: 0 auto 2.5rem;
    }

    .analysis-card {
        background: white;
        padding: 2.5rem;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        text-align: center;
        transition: all 0.4s ease;
        border: 3px solid #1a5632;
    }

    .analysis-icon {
        font-size: 4rem;
        margin-bottom: 1.2rem;
    }

    .analysis-number {
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: 1rem;
        color: #1a5632;
    }

    .analysis-label {
        font-size: 1.3rem;
        font-weight: 700;
        color: #666;
    }

    .documents-review {
        background: white;
        padding: 2.5rem;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        margin-bottom: 2.5rem;
    }

    .section-title {
        font-size: 1.7rem;
        color: #1a5632;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #f0f2f5;
        font-weight: 900;
    }

    .documents-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .document-card {
        background: linear-gradient(135deg, #f8f6f1 0%, #ffffff 100%);
        padding: 2rem;
        border-radius: 16px;
        border: 2px solid #e0e0e0;
        transition: all 0.4s ease;
    }

    .doc-icon {
        font-size: 3.5rem;
        text-align: center;
        margin-bottom: 1.2rem;
    }

    .doc-name {
        font-size: 1rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
        min-height: 45px;
        display: flex;
        align-items: center;
        text-align: center;
        justify-content: center;
    }

    .doc-meta {
        font-size: 0.85rem;
        color: #666;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .doc-actions {
        display: flex;
        gap: 0.7rem;
    }

    .btn-view {
        flex: 1;
        padding: 0.9rem;
        background: linear-gradient(135deg, #1a5632, #2d7a4d);
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        text-decoration: none;
    }

    .decision-options {
        background: white;
        padding: 2.5rem;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        margin-bottom: 2.5rem;
    }

    .options-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .option-card {
        padding: 2.5rem;
        border-radius: 16px;
        border: 4px solid;
        cursor: pointer;
        transition: all 0.4s ease;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .option-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    }

    .option-card.selected {
        transform: translateY(-10px) scale(1.05);
        box-shadow: 0 25px 60px rgba(0,0,0,0.25);
    }

    .option-card.accept {
        border-color: #28a745;
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
    }

    .option-card.reject {
        border-color: #dc3545;
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    }

    .option-card.incomplete {
        border-color: #ffc107;
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    }

    .option-icon {
        font-size: 4.5rem;
        margin-bottom: 1.5rem;
    }

    .option-title {
        font-size: 1.6rem;
        font-weight: 900;
        margin-bottom: 1rem;
    }

    .option-accept .option-title { color: #155724; }
    .option-reject .option-title { color: #721c24; }
    .option-incomplete .option-title { color: #856404; }

    .option-description {
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 1.5rem;
        color: #555;
        font-weight: 600;
    }

    .option-benefits {
        text-align: right;
        margin-top: 1.5rem;
        padding-right: 1.5rem;
        list-style: none;
    }

    .option-benefits li {
        margin-bottom: 0.8rem;
        font-size: 0.95rem;
        position: relative;
        padding-right: 2rem;
        font-weight: 600;
    }

    .option-benefits li::before {
        content: '✓';
        position: absolute;
        right: 0;
        font-weight: 900;
        font-size: 1.3rem;
    }

    .option-accept .option-benefits li::before { color: #28a745; }
    .option-reject .option-benefits li::before { color: #dc3545; }
    .option-incomplete .option-benefits li::before { color: #ffc107; }

    .processing-form {
        background: white;
        padding: 2.5rem;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        margin-top: 2rem;
        border: 3px solid #1a5632;
    }

    .form-title {
        font-size: 1.6rem;
        color: #1a5632;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #f0f2f5;
        font-weight: 900;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.8rem;
        font-weight: 700;
        color: #2c3e50;
        font-size: 1.05rem;
    }

    .form-control {
        width: 100%;
        padding: 1rem 1.3rem;
        border: 2px solid #ddd;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: inherit;
        font-weight: 600;
    }

    .form-control:focus {
        outline: none;
        border-color: #1a5632;
        box-shadow: 0 0 0 4px rgba(26, 86, 50, 0.1);
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .default-message-box {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        padding: 1.8rem;
        border-radius: 12px;
        border: 2px solid #28a745;
        margin-bottom: 1.5rem;
    }

    .default-message-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #155724;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .default-message-content {
        background: white;
        padding: 1.5rem;
        border-radius: 10px;
        font-size: 0.95rem;
        line-height: 1.8;
        color: #333;
        font-weight: 600;
        white-space: pre-line;
        border-right: 4px solid #28a745;
    }

    .missing-docs-section {
        background: linear-gradient(135deg, #fff9e6, #fff3cd);
        padding: 2rem;
        border-radius: 14px;
        margin-top: 1.5rem;
        border: 3px solid #ffc107;
    }

    .missing-docs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.2rem;
        margin-top: 1.5rem;
    }

    .doc-checkbox {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.2rem;
        background: white;
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .doc-checkbox:hover {
        border-color: #ffc107;
        background: #fffdf6;
    }

    .doc-checkbox input[type="checkbox"] {
        width: 22px;
        height: 22px;
        cursor: pointer;
        accent-color: #ffc107;
    }

    .doc-checkbox label {
        flex: 1;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 700;
        color: #333;
    }

    .text-danger {
        color: #dc3545;
        font-weight: 600;
        margin-top: 0.8rem;
        display: block;
    }

    .text-muted {
        color: #6c757d;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: block;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
        margin-top: 2.5rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 1.2rem 3rem;
        border: none;
        border-radius: 14px;
        font-size: 1.1rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        font-family: inherit;
        text-decoration: none;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.25);
    }

    .btn-back {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
    }

    .btn-accept {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .btn-reject {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: white;
    }

    .alert {
        padding: 1.5rem 2rem;
        border-radius: 14px;
        margin-bottom: 2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 1.2rem;
        font-size: 1rem;
    }

    .alert-info {
        background: linear-gradient(135deg, #d1ecf1, #bee5eb);
        border-left: 5px solid #17a2b8;
        color: #0c5460;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        border-left: 5px solid #28a745;
        color: #155724;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        border-left: 5px solid #ffc107;
        color: #856404;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        border-left: 5px solid #dc3545;
        color: #721c24;
    }

    @media (max-width: 968px) {
        .options-grid,
        .documents-grid,
        .missing-docs-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="process-container">
    <div class="page-header">
        <h1>
            <span>🤖</span>
            <span>معالجة الطلب #{{ $register->id }}</span>
        </h1>
        <p>اختر القرار المناسب ثم أكمل المعالجة</p>
    </div>

    @php
        $documentsArray = [];
        if (!empty($register->documents)) {
            $decoded = json_decode($register->documents, true);
            if (is_array($decoded)) {
                $documentsArray = $decoded;
            }
        }
        $documentsCount = count($documentsArray);
    @endphp

    <div class="analysis-grid">
        <div class="analysis-card">
            <div class="analysis-icon">📎</div>
            <div class="analysis-number">{{ $documentsCount }}</div>
            <div class="analysis-label">وثائق مرفوعة</div>
        </div>
    </div>

    <div class="documents-review">
        <h2 class="section-title">
            <span>📋</span>
            <span>الوثائق المرفوعة ({{ $documentsCount }})</span>
        </h2>

        @if($documentsCount > 0)
            <div class="documents-grid">
                @foreach($documentsArray as $index => $doc)
                    @php
                        $filePath = is_array($doc) ? ($doc['path'] ?? '') : $doc;
                        $fileName = is_array($doc) ? ($doc['original_name'] ?? 'وثيقة ' . ($index + 1)) : 'وثيقة ' . ($index + 1);
                        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        
                        if ($extension == 'pdf') {
                            $icon = '📑';
                        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                            $icon = '🖼️';
                        } else {
                            $icon = '📄';
                        }
                        
                        $fileSize = is_array($doc) ? ($doc['size'] ?? 0) : 0;
                    @endphp

                    <div class="document-card">
                        <div class="doc-icon">{{ $icon }}</div>
                        <div class="doc-name">{{ $fileName }}</div>
                        <div class="doc-meta">
                            @if($fileSize > 0)
                                <span>📦 الحجم: {{ number_format($fileSize / 1024, 2) }} KB</span>
                            @endif
                            <span>📌 النوع: {{ strtoupper($extension) }}</span>
                            <span>🔢 رقم: {{ $index + 1 }}</span>
                        </div>
                        <div class="doc-actions">
                            <a href="{{ route('document.view', ['path' => $filePath]) }}" 
                               target="_blank" 
                               class="btn-view">
                                👁️ عرض
                            </a>
                            <a href="{{ route('document.view', ['path' => $filePath]) }}?download=1" 
                               class="btn-view" 
                               style="background: linear-gradient(135deg, #c9a063, #b8944f);">
                                ⬇️ تحميل
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning">
                <span style="font-size: 2rem;">📭</span>
                <div>
                    <strong>تنبيه:</strong> لم يتم رفع أي وثائق من قبل المواطن
                </div>
            </div>
        @endif
    </div>

    <div class="decision-options">
        <h2 class="section-title">
            <span>⚖️</span>
            <span>اختر القرار المناسب</span>
        </h2>

        <div class="alert alert-info">
            <span style="font-size: 2rem;">ℹ️</span>
            <div>
                <strong>تعليمات:</strong> اختر أحد الخيارات الثلاثة أدناه، ثم أكمل البيانات المطلوبة للمعالجة
            </div>
        </div>

        <div class="options-grid">
            <div class="option-card accept option-accept" onclick="selectOption('accept')" id="option-accept">
                <div class="option-icon">✅</div>
                <div class="option-title">قبول الطلب</div>
                <div class="option-description">
                    قبول الطلب واعتماد جميع الوثائق المرفوعة. سيتم إنشاء الدفتر العقاري وإرسال إشعار للمواطن.
                </div>
                <ul class="option-benefits">
                    <li>إنشاء دفتر عقاري جديد</li>
                    <li>إرسال إشعار بالقبول</li>
                    <li>تحديث حالة الطلب</li>
                    <li>إصدار رقم التسجيل النهائي</li>
                </ul>
            </div>

            <div class="option-card reject option-reject" onclick="selectOption('reject')" id="option-reject">
                <div class="option-icon">❌</div>
                <div class="option-title">رفض الطلب</div>
                <div class="option-description">
                    رفض الطلب نهائياً مع إرسال أسباب الرفض للمواطن. يمكن للمواطن التقديم مرة أخرى لاحقاً.
                </div>
                <ul class="option-benefits">
                    <li>إرسال أسباب الرفض مفصلة</li>
                    <li>إغلاق الطلب نهائياً</li>
                    <li>إعلام المواطن بالقرار</li>
                    <li>إمكانية التقديم مرة أخرى</li>
                </ul>
            </div>

            <div class="option-card incomplete option-incomplete" onclick="selectOption('incomplete')" id="option-incomplete">
                <div class="option-icon">⚠️</div>
                <div class="option-title">طلب استكمال الوثائق</div>
                <div class="option-description">
                    الطلب غير مكتمل. تحديد الوثائق الناقصة وإرسال طلب استكمال للمواطن مع مهلة محددة.
                </div>
                <ul class="option-benefits">
                    <li>تحديد الوثائق الناقصة</li>
                    <li>إرسال طلب استكمال</li>
                    <li>إعطاء مهلة محددة</li>
                    <li>إبقاء الطلب مفتوحاً</li>
                </ul>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.land.registers.process', $register->id) }}" id="processingForm">
        @csrf
        <input type="hidden" name="decision" id="decisionInput" value="">
        
        <div class="processing-form" id="acceptForm" style="display: none;">
            <h3 class="form-title">
                <span>✅</span>
                <span>تفاصيل قبول الطلب</span>
            </h3>
            
            <div class="default-message-box">
                <div class="default-message-title">
                    <span>📧</span>
                    <span>الرسالة الافتراضية التي سيتم إرسالها:</span>
                </div>
                <div class="default-message-content">السيد(ة) {{ $register->last_name }} {{ $register->first_name }}،

نتشرف بإبلاغكم بأنه تم قبول طلبكم رقم #{{ $register->id }} لإنشاء دفتر عقاري جديد.

✅ تم اعتماد جميع الوثائق المرفوعة
✅ سيتم إنشاء الدفتر العقاري خلال الأيام القادمة
✅ سيتم إشعاركم عند اكتمال الإجراءات

شكراً لثقتكم بخدماتنا.

مع خالص التحيات،
المحافظة العقارية</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="accept_notes">ملاحظات إضافية (اختياري):</label>
                <textarea class="form-control" id="accept_notes" name="accept_notes" 
                          placeholder="أدخل أي ملاحظات إضافية تريد إضافتها للرسالة..."></textarea>
                <small class="text-muted">سيتم إضافة هذه الملاحظات إلى نهاية الرسالة</small>
            </div>
        </div>

        <div class="processing-form" id="rejectForm" style="display: none;">
            <h3 class="form-title">
                <span>❌</span>
                <span>أسباب رفض الطلب</span>
            </h3>
            
            <div class="form-group">
                <label class="form-label" for="rejection_reason">سبب الرفض (مطلوب):</label>
                <textarea class="form-control" id="rejection_reason" name="rejection_reason" 
                          placeholder="أدخل سبب رفض الطلب بشكل مفصل وواضح..."></textarea>
                <small class="text-muted">سيتم إرسال هذا السبب للمواطن</small>
            </div>

            <div class="form-group">
                <label class="form-label" for="rejection_details">تفاصيل إضافية (اختياري):</label>
                <textarea class="form-control" id="rejection_details" name="rejection_details" 
                          placeholder="أدخل أي تفاصيل إضافية أو إرشادات للمواطن..."></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="allow_resubmission">السماح بإعادة التقديم:</label>
                <select class="form-control" id="allow_resubmission" name="allow_resubmission">
                    <option value="1">نعم، يمكن التقديم مرة أخرى</option>
                    <option value="0">لا، الرفض نهائي</option>
                </select>
            </div>
        </div>

        <div class="processing-form" id="incompleteForm" style="display: none;">
            <h3 class="form-title">
                <span>⚠️</span>
                <span>طلب استكمال الوثائق</span>
            </h3>
            
            <div class="missing-docs-section">
                <label class="form-label">
                    <strong>الوثائق الناقصة المطلوبة (اختر واحدة على الأقل):</strong>
                </label>
                <div class="missing-docs-grid">
                    <div class="doc-checkbox">
                        <input type="checkbox" name="missing_docs[]" value="عقد إثبات الملكية" id="doc_0">
                        <label for="doc_0">عقد إثبات الملكية</label>
                    </div>
                    
                    <div class="doc-checkbox">
                        <input type="checkbox" name="missing_docs[]" value="شهادة الميلاد" id="doc_1">
                        <label for="doc_1">شهادة الميلاد</label>
                    </div>
                    
                    <div class="doc-checkbox">
                        <input type="checkbox" name="missing_docs[]" value="نسخة من بطاقة التعريف الوطنية" id="doc_2">
                        <label for="doc_2">نسخة من بطاقة التعريف الوطنية</label>
                    </div>
                    
                    <div class="doc-checkbox">
                        <input type="checkbox" name="missing_docs[]" value="مقتطف من القسم (CC12)" id="doc_3">
                        <label for="doc_3">مقتطف من القسم (CC12)</label>
                    </div>
                </div>
                <small class="text-danger" id="missing-docs-error" style="display: none;">
                    ⚠️ يرجى اختيار وثيقة واحدة على الأقل
                </small>
            </div>

            <div class="form-group">
                <label class="form-label" for="completion_deadline">
                    <strong>المهلة الممنوحة:</strong>
                </label>
                <select class="form-control" id="completion_deadline" name="completion_deadline">
                    <option value="">-- اختر المهلة --</option>
                    <option value="3">٣ أيام</option>
                    <option value="7" selected>أسبوع (٧ أيام)</option>
                    <option value="14">أسبوعين (١٤ يوم)</option>
                    <option value="30">شهر (٣٠ يوم)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="completion_notes">
                    <strong>تعليمات الاستكمال:</strong>
                </label>
                <textarea class="form-control" id="completion_notes" name="completion_notes" 
                          rows="5" placeholder="أدخل تعليمات واضحة حول كيفية استكمال الوثائق الناقصة..."></textarea>
                <small class="text-muted">سيتم إرسال هذه التعليمات للمواطن مع قائمة الوثائق الناقصة</small>
            </div>
        </div>

        <div class="action-buttons" id="actionButtons" style="display: none;">
            <a href="{{ route('admin.land.registers.show', $register->id) }}" class="btn btn-back">
                <span>←</span>
                <span>رجوع</span>
            </a>
            
            <button type="submit" class="btn" id="submitButton">
                <span id="submitIcon">✅</span>
                <span id="submitText">تأكيد المعالجة</span>
            </button>
        </div>
    </form>
</div>

<script>
let selectedOption = null;

function selectOption(option) {
    if (selectedOption) {
        document.getElementById(`option-${selectedOption}`).classList.remove('selected');
        document.getElementById(`${selectedOption}Form`).style.display = 'none';
    }

    selectedOption = option;
    document.getElementById(`option-${option}`).classList.add('selected');
    document.getElementById(`${option}Form`).style.display = 'block';
    document.getElementById('decisionInput').value = option;
    
    updateSubmitButton(option);
    document.getElementById('actionButtons').style.display = 'flex';
    
    setTimeout(() => {
        document.getElementById(`${option}Form`).scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 300);
}

function updateSubmitButton(option) {
    const submitButton = document.getElementById('submitButton');
    const submitIcon = document.getElementById('submitIcon');
    const submitText = document.getElementById('submitText');
    
    switch(option) {
        case 'accept':
            submitButton.className = 'btn btn-accept';
            submitIcon.textContent = '✅';
            submitText.textContent = 'تأكيد القبول وإرسال الإشعار';
            break;
        case 'reject':
            submitButton.className = 'btn btn-reject';
            submitIcon.textContent = '❌';
            submitText.textContent = 'تأكيد الرفض وإرسال الإشعار';
            break;
        case 'incomplete':
            submitButton.className = 'btn btn-warning';
            submitIcon.textContent = '⚠️';
            submitText.textContent = 'تأكيد طلب الاستكمال وإرسال الإشعار';
            break;
    }
}

document.getElementById('processingForm').addEventListener('submit', function(e) {
    const decision = document.getElementById('decisionInput').value;
    
    if (!decision) {
        e.preventDefault();
        alert('⚠️ يرجى اختيار قرار المعالجة أولاً');
        return false;
    }
    
    if (decision === 'reject') {
        const reason = document.getElementById('rejection_reason').value.trim();
        if (!reason || reason.length < 10) {
            e.preventDefault();
            alert('⚠️ يرجى إدخال سبب الرفض (10 أحرف على الأقل)');
            document.getElementById('rejection_reason').focus();
            return false;
        }
    }
    
    if (decision === 'incomplete') {
        const checkedDocs = document.querySelectorAll('input[name="missing_docs[]"]:checked');
        if (checkedDocs.length === 0) {
            e.preventDefault();
            alert('⚠️ يرجى اختيار وثيقة واحدة على الأقل ناقصة');
            return false;
        }
        
        const deadline = document.getElementById('completion_deadline').value;
        if (!deadline) {
            e.preventDefault();
            alert('⚠️ يرجى اختيار المهلة الممنوحة');
            document.getElementById('completion_deadline').focus();
            return false;
        }
        
        const notes = document.getElementById('completion_notes').value.trim();
        if (!notes || notes.length < 10) {
            e.preventDefault();
            alert('⚠️ يرجى إدخال تعليمات الاستكمال (10 أحرف على الأقل)');
            document.getElementById('completion_notes').focus();
            return false;
        }
    }
    
    const confirmMessages = {
        'accept': '✅ هل أنت متأكد من قبول الطلب؟\n\nسيتم:\n• إنشاء دفتر عقاري جديد\n• إرسال إشعار للمواطن\n• تحديث حالة الطلب',
        'reject': '❌ هل أنت متأكد من رفض الطلب؟\n\nسيتم:\n• إرسال أسباب الرفض للمواطن\n• إغلاق الطلب\n• إعلام المواطن بالقرار',
        'incomplete': '⚠️ هل أنت متأكد من إرسال طلب استكمال الوثائق؟\n\nسيتم:\n• إرسال قائمة الوثائق الناقصة\n• إرسال تعليمات الاستكمال\n• إبقاء الطلب مفتوحاً'
    };
    
    if (!confirm(confirmMessages[decision])) {
        e.preventDefault();
        return false;
    }
    
    const submitBtn = document.getElementById('submitButton');
    submitBtn.innerHTML = '<span>⏳</span><span>جاري المعالجة...</span>';
    submitBtn.disabled = true;
});
</script>

@endsection