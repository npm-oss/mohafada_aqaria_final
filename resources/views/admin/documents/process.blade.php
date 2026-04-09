@extends('admin.layout')

@section('content')

<!-- مكتبات PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<style>
/* استيراد خط عربي احترافي */
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap');

* {
    font-family: 'Cairo', sans-serif;
}

.process-box {
    max-width: 1200px;
    margin: 40px auto;
    padding: 40px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
    border-radius: 25px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    animation: fadeInUp 0.6s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.page-title {
    text-align: center;
    font-size: 32px;
    font-weight: 800;
    background: linear-gradient(135deg, #1a5632, #2d7a4f, #3d9970);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 4px solid #c49b63;
    position: relative;
}

.page-title::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: linear-gradient(90deg, transparent, #c49b63, transparent);
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    font-weight: 700;
    color: #1a5632;
    margin-bottom: 10px;
    font-size: 16px;
}

fieldset {
    border: 3px solid #e8f5e9;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 25px;
    background: linear-gradient(135deg, #f1f8f4 0%, #ffffff 100%);
}

fieldset legend {
    font-weight: 800;
    color: #1a5632;
    padding: 0 15px;
    font-size: 18px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(26, 86, 50, 0.1);
}

fieldset label {
    display: inline-flex;
    align-items: center;
    margin-left: 20px;
    font-weight: 600;
    cursor: pointer;
    padding: 12px 25px;
    border-radius: 12px;
    transition: all 0.3s ease;
    background: white;
    border: 2px solid #e0e0e0;
}

fieldset label:hover {
    background: rgba(26, 86, 50, 0.08);
    border-color: #1a5632;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26, 86, 50, 0.15);
}

fieldset input[type="radio"]:checked + span {
    color: #1a5632;
    font-weight: 700;
}

fieldset input[type="radio"] {
    width: auto;
    margin-left: 10px;
    cursor: pointer;
    transform: scale(1.2);
}

input, select {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    font-size: 15px;
    transition: all 0.3s ease;
    background: white;
    font-weight: 500;
}

input:focus, select:focus {
    outline: none;
    border-color: #1a5632;
    box-shadow: 0 0 0 4px rgba(26, 86, 50, 0.12);
    transform: translateY(-1px);
}

input[readonly] {
    background: #f8f9fa;
    cursor: not-allowed;
    color: #495057;
    font-weight: 600;
}

button {
    background: linear-gradient(135deg, #1a5632 0%, #2d7a4f 50%, #1a5632 100%);
    background-size: 200% 100%;
    color: white;
    padding: 16px 35px;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    font-weight: 800;
    font-size: 17px;
    width: 100%;
    transition: all 0.4s ease;
    margin-top: 15px;
    box-shadow: 0 8px 20px rgba(26, 86, 50, 0.3);
}

button:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 35px rgba(26, 86, 50, 0.4);
    background-position: 100% 0;
}

button:active {
    transform: translateY(-2px);
}

.sub-box {
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    padding: 25px;
    margin-top: 20px;
    border-radius: 15px;
    border: 3px solid #dee2e6;
    transition: all 0.3s ease;
    animation: slideDown 0.4s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.sub-box h4 {
    font-size: 18px;
    font-weight: 800;
    color: #1a5632;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 3px solid #c49b63;
}

.sub-box input {
    margin-bottom: 15px;
}

.hidden {
    display: none !important;
}

/* تحسين صندوق النتائج */
.result-box {
    margin-top: 40px;
    background: linear-gradient(135deg, #e3f2fd 0%, #f0f8ff 100%);
    padding: 35px;
    border-radius: 20px;
    border: 3px solid #2196f3;
    box-shadow: 0 15px 40px rgba(33, 150, 243, 0.2);
    animation: fadeIn 0.6s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.result-box h3 {
    font-size: 22px;
    font-weight: 800;
    color: #1a5632;
    margin: 30px 0 20px 0;
    padding: 15px 20px;
    background: linear-gradient(135deg, #ffffff, #f1f8f4);
    border-radius: 12px;
    border-right: 5px solid #c49b63;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.result-box h3:first-child {
    margin-top: 0;
}

/* شبكة معلومات محسنة */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.info-item {
    background: white;
    padding: 15px;
    border-radius: 12px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

.info-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    border-color: #1a5632;
}

.info-item label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #1a5632;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-item input {
    margin-bottom: 0;
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    background: #f8f9fa;
    border: 2px solid #dee2e6;
}

/* عرض البطاقة - نمط كلاسيكي */
.card-display-section {
    margin-top: 30px;
    padding: 30px;
    background: #ffffff;
    border-radius: 15px;
    border: 2px solid #dee2e6;
}

.card-viewer {
    max-width: 900px;
    margin: 0 auto;
}

.card-front, .card-back {
    margin-bottom: 40px;
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    border: 2px solid #1a5632;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.card-front:last-child, .card-back:last-child {
    margin-bottom: 0;
}

.card-header {
    text-align: center;
    background: linear-gradient(135deg, #1a5632, #2d7a4f);
    color: white;
    padding: 12px 20px;
    border-radius: 8px 8px 0 0;
    margin: -20px -20px 20px -20px;
    font-weight: 800;
    font-size: 18px;
    letter-spacing: 1px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}

.card-image-wrapper {
    background: white;
    padding: 15px;
    border-radius: 8px;
    border: 3px solid #1a5632;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.card-image-wrapper:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 25px rgba(26, 86, 50, 0.3);
}

.card-image-wrapper img {
    width: 100%;
    max-width: 100%;
    height: auto;
    display: block;
    border-radius: 5px;
}

.card-image-wrapper .no-image {
    padding: 80px 20px;
    background: linear-gradient(135deg, #f1f3f5, #e9ecef);
    border: 3px dashed #adb5bd;
    border-radius: 5px;
    color: #6c757d;
    font-weight: 600;
    font-size: 16px;
    text-align: center;
}

.card-image-wrapper .zoom-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(26, 86, 50, 0.85);
    color: white;
    padding: 10px;
    font-weight: 700;
    font-size: 14px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.card-image-wrapper:hover .zoom-overlay {
    transform: translateY(0);
}

/* Modal للعرض بحجم كبير */
.image-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    z-index: 10000;
    animation: fadeIn 0.3s ease;
    overflow: auto;
    padding: 20px;
}

.image-modal.active {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    position: relative;
    max-width: 95%;
    max-height: 95%;
    animation: zoomIn 0.3s ease;
}

@keyframes zoomIn {
    from {
        transform: scale(0.8);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.modal-content img {
    width: 100%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    border: 3px solid #1a5632;
}

.modal-close {
    position: fixed;
    top: 30px;
    right: 30px;
    background: #dc3545;
    color: white;
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    font-size: 28px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
    z-index: 10001;
    font-weight: bold;
}

.modal-close:hover {
    background: #c82333;
    transform: rotate(90deg) scale(1.1);
}

.modal-title {
    position: fixed;
    top: 30px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(26, 86, 50, 0.95);
    color: white;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 700;
    font-size: 18px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    z-index: 10001;
}

/* قسم الطباعة مع أزرار متعددة */
.print-section {
    text-align: center;
    margin-top: 30px;
    padding-top: 25px;
    border-top: 2px dashed #dee2e6;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 15px;
}

.print-btn {
    background: linear-gradient(135deg, #c49b63, #d4af7a);
    color: white;
    padding: 14px 30px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 700;
    font-size: 15px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 5px 15px rgba(196, 155, 99, 0.4);
    width: auto;
    min-width: 200px;
    justify-content: center;
}

.print-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(196, 155, 99, 0.5);
}

.print-btn:active {
    transform: translateY(-1px);
}

.print-btn.pdf {
    background: linear-gradient(135deg, #dc3545, #c82333);
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
}

.print-btn.pdf:hover {
    box-shadow: 0 10px 25px rgba(220, 53, 69, 0.5);
}

.print-btn.direct {
    background: linear-gradient(135deg, #6c757d, #5a6268);
    box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
}

.print-btn.direct:hover {
    box-shadow: 0 10px 25px rgba(108, 117, 125, 0.5);
}

/* Alert Messages */
.alert {
    padding: 18px 25px;
    border-radius: 15px;
    margin-bottom: 25px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 12px;
    animation: slideDown 0.4s ease;
    font-size: 15px;
}

.alert-success {
    background: rgba(40, 167, 69, 0.12);
    color: #28a745;
    border: 3px solid #28a745;
}

.alert-danger {
    background: rgba(220, 53, 69, 0.12);
    color: #dc3545;
    border: 3px solid #dc3545;
}

.alert-warning {
    background: rgba(255, 193, 7, 0.12);
    color: #ff9800;
    border: 3px solid #ff9800;
}

/* Back Button */
.back-btn {
    background: linear-gradient(135deg, #6b7280, #9ca3af);
    color: white;
    padding: 14px 30px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 700;
    font-size: 15px;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 25px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
}

.back-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(108, 117, 125, 0.4);
}

/* Loading Spinner */
.loading {
    display: inline-block;
    width: 22px;
    height: 22px;
    border: 3px solid rgba(255,255,255,.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* أنماط الطباعة - نسخة محسنة للحافة الكاملة */
@media print {
    * {
        margin: 0 !important;
        padding: 0 !important;
        box-sizing: border-box !important;
    }
    
    body * {
        visibility: hidden;
    }
    
    .print-area, .print-area * {
        visibility: visible;
    }
    
    .print-area {
        position: fixed !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        height: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
        background: white !important;
    }
    
    .card-display-section,
    .card-viewer {
        padding: 0 !important;
        margin: 0 !important;
        border: none !important;
        background: white !important;
        width: 100% !important;
        height: 100% !important;
    }
    
    .card-front, .card-back {
        position: fixed !important;
        left: 0 !important;
        top: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        max-width: 100% !important;
        max-height: 100% !important;
        min-height: 100vh !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        background: white !important;
        page-break-after: always !important;
        break-after: page !important;
        overflow: hidden !important;
        display: flex !important;
        flex-direction: column !important;
    }
    
    .card-back {
        page-break-before: always !important;
        break-before: page !important;
        top: 0 !important;
    }
    
    /* إخفاء الهيدر للطباعة الكاملة */
    .card-header {
        display: none !important;
    }
    
    .card-image-wrapper {
        width: 100% !important;
        height: 100% !important;
        max-height: 100vh !important;
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        overflow: hidden !important;
        background: white !important;
        flex: 1 !important;
    }
    
    .card-image-wrapper img {
        width: 100% !important;
        height: 100% !important;
        max-width: 100% !important;
        max-height: 100vh !important;
        object-fit: contain !important;
        object-position: center !important;
        display: block !important;
        image-rendering: -webkit-optimize-contrast !important;
        image-rendering: crisp-edges !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    
    .zoom-overlay, 
    .print-section, 
    .no-image,
    .modal-close,
    .modal-title,
    .result-box h3,
    .info-grid,
    .sub-box,
    .form-group,
    fieldset,
    button,
    .back-btn,
    .alert,
    .card-viewer {
        display: none !important;
        visibility: hidden !important;
    }
    
    @page {
        margin: 0mm !important;
        padding: 0mm !important;
        size: A4 portrait;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }

    .process-box {
        padding: 25px;
        margin: 20px auto;
    }

    fieldset label {
        display: flex;
        margin-left: 0;
        margin-bottom: 15px;
    }

    .page-title {
        font-size: 26px;
    }
    
    .modal-close {
        top: 15px;
        right: 15px;
        width: 45px;
        height: 45px;
    }
    
    .modal-title {
        top: 15px;
        font-size: 14px;
        padding: 10px 20px;
    }
    
    .card-viewer {
        max-width: 100%;
    }
    
    .print-section {
        flex-direction: column;
        align-items: center;
    }
    
    .print-btn {
        width: 100%;
        max-width: 300px;
    }
}

@keyframes fadeOut {
    to {
        opacity: 0;
        transform: translateX(20px);
    }
}
</style>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert alert-success" style="max-width: 1200px; margin: 20px auto;">
    ✓ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger" style="max-width: 1200px; margin: 20px auto;">
    ⚠ {{ session('error') }}
</div>
@endif

<div class="process-box">

    <!-- Back Button -->
    <a href="{{ route('admin.documents.index') }}" class="back-btn">
        ← رجوع للقائمة
    </a>

    <h2 class="page-title">⚙️ معالجة الطلب</h2>

    <form id="processForm">

        <!-- نوع البطاقة -->
        <div class="form-group">
            <label>📋 نوع البطاقة</label>
            <select id="card_type">
                <option value="">-- اختر نوع البطاقة --</option>
                <option value="الريفية">الريفية</option>
                <option value="الحضرية الخاصة">الحضرية الخاصة</option>
                <option value="شخصية">شخصية</option>
                <option value="أبجدية">أبجدية</option>
            </select>
        </div>

        <!-- حالة العقار -->
        <fieldset class="form-group">
            <legend>🏘️ حالة العقار</legend>
            <label>
                <input type="radio" name="property_status" value="ممسوح">
                <span>✅ ممسوح</span>
            </label>
            <label>
                <input type="radio" name="property_status" value="غير ممسوح">
                <span>❌ غير ممسوح</span>
            </label>
        </fieldset>

        <!-- ممسوح -->
        <div id="surveyed_fields" class="sub-box hidden">
            <h4>📍 معلومات العقار الممسوح</h4>
            <input type="text" id="section" placeholder="القطاع">
            <input type="text" id="municipality" placeholder="البلدية">
            <input type="text" id="plan_number" placeholder="رقم المخطط">
            <input type="text" id="parcel_number" placeholder="رقم القطعة">
        </div>

        <!-- غير ممسوح -->
        <div id="not_surveyed_fields" class="sub-box hidden">
            <h4>📍 معلومات العقار غير الممسوح</h4>
            <input type="text" id="municipality_ns" placeholder="البلدية">
            <input type="text" id="subdivision_number" placeholder="رقم التجزئة">
            <input type="text" id="parcel_number_ns" placeholder="رقم القطعة">
        </div>

        <button type="button" id="searchBtn">
            🔍 بحث
        </button>
    </form>

    <!-- النتائج -->
    <div id="resultSection" class="result-box hidden">

        <h3>👤 معلومات صاحب الملكية</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>🆔 رقم التعريف الوطني</label>
                <input id="owner_nin" readonly>
            </div>
            <div class="info-item">
                <label>👨 الاسم</label>
                <input id="owner_firstname" readonly>
            </div>
            <div class="info-item">
                <label>👨‍👦 اللقب</label>
                <input id="owner_lastname" readonly>
            </div>
            <div class="info-item">
                <label>👴 اسم الأب</label>
                <input id="owner_father" readonly>
            </div>
            <div class="info-item">
                <label>📅 تاريخ الميلاد</label>
                <input id="owner_birthdate" readonly>
            </div>
            <div class="info-item">
                <label>📍 مكان الميلاد</label>
                <input id="owner_birthplace" readonly>
            </div>
        </div>

        <h3>🏠 معلومات العقار</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>🏘️ حالة العقار</label>
                <input id="property_status_result" readonly>
            </div>
            <div class="info-item">
                <label>📋 نوع البطاقة</label>
                <input id="card_type_result" readonly>
            </div>
        </div>

        <!-- ممسوح -->
        <div id="surveyed_result" class="hidden">
            <div class="info-grid">
                <div class="info-item">
                    <label>🗺️ القطاع</label>
                    <input id="section_result" readonly>
                </div>
                <div class="info-item">
                    <label>🏙️ البلدية</label>
                    <input id="municipality_result" readonly>
                </div>
                <div class="info-item">
                    <label>📐 رقم المخطط</label>
                    <input id="plan_number_result" readonly>
                </div>
                <div class="info-item">
                    <label>🔢 رقم القطعة</label>
                    <input id="parcel_number_result" readonly>
                </div>
            </div>
        </div>

        <!-- غير ممسوح -->
        <div id="not_surveyed_result" class="hidden">
            <div class="info-grid">
                <div class="info-item">
                    <label>🏙️ البلدية</label>
                    <input id="municipality_ns_result" readonly>
                </div>
                <div class="info-item">
                    <label>🔀 رقم التجزئة</label>
                    <input id="subdivision_number_result" readonly>
                </div>
                <div class="info-item">
                    <label>🔢 رقم القطعة</label>
                    <input id="parcel_number_ns_result" readonly>
                </div>
            </div>
        </div>

        <!-- عرض البطاقة بشكل كلاسيكي -->
        <h3>🎴 بطاقة الملكية</h3>
        <div class="card-display-section print-area">
            <div class="card-viewer">
                
                <!-- الوجه الأول -->
                <div class="card-front">
                    <div class="card-header">
                        📄 الوجه الأول من البطاقة
                    </div>
                    <div class="card-image-wrapper" id="card_wrapper_1">
                        <img id="card_image_1" alt="الوجه الأول" style="display: none;">
                        <div id="no_image_1" class="no-image">⚠️ الوجه الأول غير متاح</div>
                        <div class="zoom-overlay">🔍 اضغط للتكبير والعرض الكامل</div>
                    </div>
                </div>
                
                <!-- الوجه الثاني -->
                <div class="card-back">
                    <div class="card-header">
                        📄 الوجه الثاني من البطاقة
                    </div>
                    <div class="card-image-wrapper" id="card_wrapper_2">
                        <img id="card_image_2" alt="الوجه الثاني" style="display: none;">
                        <div id="no_image_2" class="no-image">⚠️ الوجه الثاني غير متاح</div>
                        <div class="zoom-overlay">🔍 اضغط للتكبير والعرض الكامل</div>
                    </div>
                </div>

            </div>
            
            <!-- قسم الطباعة مع أزرار متعددة -->
            <div class="print-section">
                <button class="print-btn" onclick="printInNewWindow()">
                    🖨️ طباعة في نافذة جديدة
                </button>
                
                <button class="print-btn pdf" onclick="downloadAsPDF()">
                    📄 تحويل إلى PDF
                </button>
                
                <button class="print-btn direct" onclick="printDirect()">
                    🖨️ طباعة عادية
                </button>
            </div>
        </div>

    </div>
</div>

<!-- Modal للعرض بحجم كبير -->
<div id="imageModal" class="image-modal">
    <button class="modal-close" onclick="closeModal()">×</button>
    <div class="modal-title" id="modalTitle">عرض البطاقة</div>
    <div class="modal-content">
        <img id="modalImage" alt="عرض البطاقة">
    </div>
</div>

<script>
const radios = document.querySelectorAll('input[name="property_status"]');
const surveyedFields = document.getElementById('surveyed_fields');
const notSurveyedFields = document.getElementById('not_surveyed_fields');
const surveyedResult = document.getElementById('surveyed_result');
const notSurveyedResult = document.getElementById('not_surveyed_result');
const resultSection = document.getElementById('resultSection');
const searchBtn = document.getElementById('searchBtn');

// تعريف الحقول
const card_type = document.getElementById('card_type');
const section = document.getElementById('section');
const municipality = document.getElementById('municipality');
const plan_number = document.getElementById('plan_number');
const parcel_number = document.getElementById('parcel_number');
const municipality_ns = document.getElementById('municipality_ns');
const subdivision_number = document.getElementById('subdivision_number');
const parcel_number_ns = document.getElementById('parcel_number_ns');

// النتائج
const owner_nin = document.getElementById('owner_nin');
const owner_firstname = document.getElementById('owner_firstname');
const owner_lastname = document.getElementById('owner_lastname');
const owner_father = document.getElementById('owner_father');
const owner_birthdate = document.getElementById('owner_birthdate');
const owner_birthplace = document.getElementById('owner_birthplace');
const property_status_result = document.getElementById('property_status_result');
const card_type_result = document.getElementById('card_type_result');
const section_result = document.getElementById('section_result');
const municipality_result = document.getElementById('municipality_result');
const plan_number_result = document.getElementById('plan_number_result');
const parcel_number_result = document.getElementById('parcel_number_result');
const municipality_ns_result = document.getElementById('municipality_ns_result');
const subdivision_number_result = document.getElementById('subdivision_number_result');
const parcel_number_ns_result = document.getElementById('parcel_number_ns_result');

// عناصر الصور
const card_image_1 = document.getElementById('card_image_1');
const card_image_2 = document.getElementById('card_image_2');
const no_image_1 = document.getElementById('no_image_1');
const no_image_2 = document.getElementById('no_image_2');
const card_wrapper_1 = document.getElementById('card_wrapper_1');
const card_wrapper_2 = document.getElementById('card_wrapper_2');
const imageModal = document.getElementById('imageModal');
const modalImage = document.getElementById('modalImage');
const modalTitle = document.getElementById('modalTitle');

// Show/Hide fields based on property status
radios.forEach(radio => {
    radio.addEventListener('change', () => {
        if (radio.value === 'ممسوح') {
            surveyedFields.classList.remove('hidden');
            notSurveyedFields.classList.add('hidden');
        } else {
            notSurveyedFields.classList.remove('hidden');
            surveyedFields.classList.add('hidden');
        }
    });
});

// دالة عرض الصورة
function showImage(imgElement, noImgElement, imagePath) {
    console.log('Original path:', imagePath);
    
    if (!imagePath || imagePath.trim() === '') {
        imgElement.style.display = 'none';
        noImgElement.style.display = 'block';
        return;
    }
    
    let cleanPath = imagePath.trim().replace(/^\//, '');
    if (!cleanPath.startsWith('images/')) {
        cleanPath = 'images/' + cleanPath;
    }
    const imageUrl = '/' + cleanPath;
    
    console.log('Final URL:', imageUrl);
    
    imgElement.style.display = 'none';
    noImgElement.style.display = 'none';
    imgElement.src = '';
    
    imgElement.src = imageUrl;
    imgElement.style.display = 'block';
    
    imgElement.onerror = function() {
        console.error('Failed to load:', imageUrl);
        this.style.display = 'none';
        noImgElement.style.display = 'block';
        noImgElement.textContent = '⚠️ الصورة غير موجودة';
    };
    
    imgElement.onload = function() {
        console.log('Loaded successfully:', imageUrl);
        noImgElement.style.display = 'none';
    };
}

// فتح Modal
card_wrapper_1.addEventListener('click', function() {
    if (card_image_1.style.display !== 'none' && card_image_1.src) {
        openModal(card_image_1.src, 'الوجه الأول من البطاقة');
    }
});

card_wrapper_2.addEventListener('click', function() {
    if (card_image_2.style.display !== 'none' && card_image_2.src) {
        openModal(card_image_2.src, 'الوجه الثاني من البطاقة');
    }
});

function openModal(imageSrc, title) {
    modalImage.src = imageSrc;
    modalTitle.textContent = title;
    imageModal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    imageModal.classList.remove('active');
    document.body.style.overflow = 'auto';
}

imageModal.addEventListener('click', function(e) {
    if (e.target === imageModal) {
        closeModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && imageModal.classList.contains('active')) {
        closeModal();
    }
});

// ==================== دوال الطباعة ====================

// 1. طباعة مباشرة (الطريقة العادية)
function printDirect() {
    window.print();
}

// 2. طباعة عبر نافذة جديدة (أفضل للتحكم بالهوامش)
function printInNewWindow() {
    const img1Src = card_image_1.src;
    const img2Src = card_image_2.src;
    
    if (!img1Src && !img2Src) {
        showAlert('⚠️ لا توجد صور للطباعة', 'warning');
        return;
    }
    
    const printWindow = window.open('', '_blank', 'width=800,height=600');
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html dir="rtl">
        <head>
            <meta charset="UTF-8">
            <title>بطاقة الملكية - طباعة</title>
            <style>
                * { 
                    margin: 0; 
                    padding: 0; 
                    box-sizing: border-box; 
                }
                
                body { 
                    margin: 0; 
                    padding: 0; 
                    background: white; 
                }
                
                @page {
                    size: A4 portrait;
                    margin: 0mm;
                    padding: 0mm;
                }
                
                .page {
                    width: 210mm;
                    height: 297mm;
                    page-break-after: always;
                    break-after: page;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    overflow: hidden;
                    background: white;
                    position: relative;
                }
                
                .page:last-child {
                    page-break-after: auto;
                    break-after: auto;
                }
                
                .page img {
                    width: 100%;
                    height: 100%;
                    object-fit: contain;
                    display: block;
                }
                
                .no-image {
                    width: 100%;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 24px;
                    color: #666;
                    background: #f5f5f5;
                    font-family: Arial, sans-serif;
                }
                
                @media print {
                    body { 
                        -webkit-print-color-adjust: exact; 
                        print-color-adjust: exact;
                    }
                }
            </style>
        </head>
        <body>
            ${img1Src ? `
            <div class="page">
                <img src="${img1Src}" alt="الوجه الأول" onload="this.style.opacity=1" style="opacity:0;transition:opacity 0.3s">
            </div>
            ` : '<div class="page"><div class="no-image">الوجه الأول غير متوفر</div></div>'}
            
            ${img2Src ? `
            <div class="page">
                <img src="${img2Src}" alt="الوجه الثاني" onload="this.style.opacity=1" style="opacity:0;transition:opacity 0.3s">
            </div>
            ` : '<div class="page"><div class="no-image">الوجه الثاني غير متوفر</div></div>'}
            
            <script>
                window.onload = function() {
                    setTimeout(function() {
                        window.print();
                    }, 500);
                };
            <\/script>
        </body>
        </html>
    `);
    
    printWindow.document.close();
}

// 3. تحويل إلى PDF (للتحكم الكامل بالهوامش)
async function downloadAsPDF() {
    const { jsPDF } = window.jspdf;
    
    const img1Src = card_image_1.src;
    const img2Src = card_image_2.src;
    
    if (!img1Src && !img2Src) {
        showAlert('⚠️ لا توجد صور للتحويل', 'warning');
        return;
    }
    
    try {
        showAlert('⏳ جاري إنشاء PDF...', 'warning');
        
        const pdf = new jsPDF({
            orientation: 'portrait',
            unit: 'mm',
            format: 'a4',
            compress: true
        });
        
        const pageWidth = 210;
        const pageHeight = 297;
        
        // إضافة الصورة الأولى
        if (img1Src) {
            await addImageToPDF(pdf, img1Src, pageWidth, pageHeight);
        }
        
        // إضافة الصورة الثانية
        if (img2Src) {
            pdf.addPage();
            await addImageToPDF(pdf, img2Src, pageWidth, pageHeight);
        }
        
        // حفظ الملف
        const fileName = 'بطاقة_الملكية_' + new Date().toISOString().slice(0,10) + '.pdf';
        pdf.save(fileName);
        
        showAlert('✓ تم إنشاء PDF بنجاح', 'success');
        
    } catch (error) {
        console.error('PDF Error:', error);
        showAlert('❌ خطأ في إنشاء PDF: ' + error.message, 'danger');
    }
}

// دالة مساعدة لإضافة صورة للPDF
function addImageToPDF(pdf, imgSrc, pageWidth, pageHeight) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.crossOrigin = 'Anonymous';
        
        img.onload = function() {
            try {
                const imgWidth = pageWidth;
                const imgHeight = pageHeight;
                
                // حساب الأبعاد مع الحفاظ على النسبة
                const ratio = Math.min(
                    imgWidth / img.width,
                    imgHeight / img.height
                );
                
                const finalWidth = img.width * ratio;
                const finalHeight = img.height * ratio;
                
                const x = (pageWidth - finalWidth) / 2;
                const y = (pageHeight - finalHeight) / 2;
                
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                
                const imgData = canvas.toDataURL('image/jpeg', 1.0);
                
                pdf.addImage(imgData, 'JPEG', x, y, finalWidth, finalHeight);
                
                resolve();
            } catch (err) {
                reject(err);
            }
        };
        
        img.onerror = () => reject(new Error('فشل تحميل الصورة'));
        img.src = imgSrc;
    });
}

// Search button
searchBtn.addEventListener('click', function () {
    const searchedStatus = document.querySelector('input[name="property_status"]:checked')?.value || '';

    if (!card_type.value) {
        showAlert("⚠ اختر نوع البطاقة أولاً", "warning");
        return;
    }

    if (!searchedStatus) {
        showAlert("⚠ اختر حالة العقار أولاً", "warning");
        return;
    }

    searchBtn.innerHTML = '<span class="loading"></span> جاري البحث...';
    searchBtn.disabled = true;

    fetch("{{ route('search.card') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            card_type: card_type.value,
            property_status: searchedStatus,
            section: section.value,
            municipality: municipality.value,
            plan_number: plan_number.value,
            parcel_number: parcel_number.value,
            municipality_ns: municipality_ns.value,
            subdivision_number: subdivision_number.value,
            parcel_number_ns: parcel_number_ns.value
        })
    })
    .then(r => r.json())
    .then(data => {
        console.log('Response data:', data);
        
        searchBtn.innerHTML = '🔍 بحث';
        searchBtn.disabled = false;

        if (!data.success) {
            showAlert("❌ البطاقة غير موجودة", "danger");
            resultSection.classList.add("hidden");
            return;
        }

        const c = data.card;
        console.log('Card image 1:', c.card_image);
        console.log('Card image 2:', c.card_image_2);

        // Fill owner info
        owner_nin.value = c.owner_nin || '-';
        owner_firstname.value = c.owner_firstname || '-';
        owner_lastname.value = c.owner_lastname || '-';
        owner_father.value = c.owner_father || '-';
        owner_birthdate.value = c.owner_birthdate || '-';
        owner_birthplace.value = c.owner_birthplace || '-';

        // Fill property info
        property_status_result.value = c.property_status || '-';
        card_type_result.value = c.card_type || '-';

        // Show appropriate fields
        if (searchedStatus === 'ممسوح') {
            surveyedResult.classList.remove('hidden');
            notSurveyedResult.classList.add('hidden');
            section_result.value = c.section || '-';
            municipality_result.value = c.municipality || '-';
            plan_number_result.value = c.plan_number || '-';
            parcel_number_result.value = c.parcel_number || '-';
        } else {
            surveyedResult.classList.add('hidden');
            notSurveyedResult.classList.remove('hidden');
            municipality_ns_result.value = c.municipality_ns || '-';
            subdivision_number_result.value = c.subdivision_number || '-';
            parcel_number_ns_result.value = c.parcel_number_ns || '-';
        }

        // عرض الصورتين
        const firstImage = c.card_image || '';
        const secondImage = c.card_image_2 || '';
        
        showImage(card_image_1, no_image_1, firstImage);
        showImage(card_image_2, no_image_2, secondImage);

        resultSection.classList.remove("hidden");
        showAlert("✓ تم العثور على البطاقة بنجاح", "success");
        resultSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    })
    .catch(error => {
        searchBtn.innerHTML = '🔍 بحث';
        searchBtn.disabled = false;
        showAlert("⚠ حدث خطأ أثناء البحث: " + error.message, "danger");
        console.error('Error:', error);
    });
});

// Show alert function
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.style.position = 'fixed';
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '9999';
    alertDiv.style.maxWidth = '450px';
    alertDiv.innerHTML = message;
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => alertDiv.remove(), 300);
    }, 4000);
}
</script>

@endsection