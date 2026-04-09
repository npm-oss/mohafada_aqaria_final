<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>طلب إنشاء دفتر عقاري</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1a5632;
            --primary-dark: #0d3d20;
            --secondary: #c49b63;
            --accent: #8b6f47;
            --bg-light: #f8f6f1;
            --text-dark: #2d2d2d;
            --success: #28a745;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            min-height: 100vh;
            padding: 2rem;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 20% 50%, rgba(196, 155, 99, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(139, 111, 71, 0.15) 0%, transparent 50%);
            animation: backgroundPulse 20s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes backgroundPulse {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(50px, 50px) scale(1.1); }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .particle {
            position: fixed;
            width: 10px;
            height: 10px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            pointer-events: none;
            animation: float 15s infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) translateX(100px); opacity: 0; }
        }

        .form-card {
            background: white;
            border-radius: 25px;
            padding: 3.5rem;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
            margin-bottom: 2.5rem;
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
            background-size: 200% 100%;
            animation: gradientMove 3s ease infinite;
        }

        @keyframes gradientMove {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .header {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .header h1 {
            font-family: 'Amiri', serif;
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .header p {
            color: #666;
            font-size: 1.2rem;
        }

        /* ملاحظة تعريفية عن الدفتر العقاري */
        .definition-note {
            background: rgba(196, 155, 99, 0.15);
            border-right: 5px solid var(--secondary);
            padding: 1rem 2rem;
            border-radius: 10px;
            margin: 1.5rem auto 0;
            max-width: 800px;
            font-size: 1.1rem;
            color: var(--text-dark);
            display: inline-block;
            text-align: center;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .definition-note strong {
            color: var(--primary);
            font-weight: 700;
        }

        .alert {
            padding: 1.3rem 2rem;
            border-radius: 12px;
            margin-bottom: 2.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border-left: 5px solid var(--success);
            color: #155724;
            font-weight: 600;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            border-left: 5px solid #dc3545;
            color: #721c24;
            font-weight: 600;
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3.5rem;
            position: relative;
        }

        .progress-steps::before {
            content: '';
            position: absolute;
            top: 28px;
            left: 25%;
            right: 25%;
            height: 4px;
            background: #e0e0e0;
            z-index: 0;
        }

        .step {
            flex: 1;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .step-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #e0e0e0;
            margin: 0 auto 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.4rem;
            color: #999;
            transition: all 0.5s ease;
        }

        .step.active .step-circle {
            background: linear-gradient(135deg, var(--primary), var(--success));
            color: white;
            transform: scale(1.15);
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(26, 86, 50, 0.7); }
            50% { box-shadow: 0 0 0 10px rgba(26, 86, 50, 0); }
        }

        .step-label {
            font-weight: 600;
            color: #999;
            font-size: 1.05rem;
        }

        .step.active .step-label {
            color: var(--primary);
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .section-title {
            font-family: 'Amiri', serif;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 2.5rem;
            padding-bottom: 1.2rem;
            border-bottom: 3px solid var(--primary);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.7rem;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 1.05rem;
        }

        .form-group label .required {
            color: #e74c3c;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.4rem;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1.05rem;
            font-family: 'Tajawal', sans-serif;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(26, 86, 50, 0.12);
            transform: translateY(-2px);
        }

        .radio-group {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            cursor: pointer;
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            background: var(--bg-light);
            transition: all 0.3s ease;
        }

        .radio-option:hover {
            background: rgba(26, 86, 50, 0.08);
            transform: translateY(-2px);
        }

        .radio-option input[type="radio"] {
            width: 22px;
            height: 22px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .radio-option label {
            margin: 0 !important;
            cursor: pointer;
        }

        /* ========== PROPERTY TYPE SELECTOR ========== */
        .property-type-selector {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            border: 2px solid var(--success);
        }

        .property-type-selector h3 {
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .property-type-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .property-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 3px solid transparent;
            text-align: center;
        }

        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .property-card.selected {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(26, 86, 50, 0.05), rgba(40, 167, 69, 0.05));
        }

        .property-card input[type="radio"] {
            display: none;
        }

        .property-card .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .property-card h4 {
            color: var(--primary);
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        /* ========== CONDITIONAL FIELDS ========== */
        .conditional-fields {
            background: #f0f7ff;
            padding: 2rem;
            border-radius: 15px;
            margin-top: 1.5rem;
            border-left: 5px solid #2196f3;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* ========== DOCUMENTS SECTION ========== */
        .documents-list {
            background: linear-gradient(135deg, #fff3e0, #ffe0b2);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            border: 2px solid var(--secondary);
        }

        .documents-list h3 {
            color: var(--primary);
            font-size: 1.7rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .document-item {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .document-item:hover {
            transform: translateX(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .document-item .icon {
            font-size: 2.5rem;
        }

        .document-item .info {
            flex: 1;
        }

        .document-item .title {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary);
            margin-bottom: 0.3rem;
        }

        .document-item .desc {
            font-size: 0.95rem;
            color: #666;
        }

        .upload-section {
            background: var(--bg-light);
            padding: 2.5rem;
            border-radius: 20px;
            margin-top: 2rem;
        }

        .upload-section h3 {
            color: var(--primary);
            font-size: 1.7rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .upload-area {
            border: 4px dashed #ccc;
            border-radius: 20px;
            padding: 4rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .upload-area::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(26, 86, 50, 0.05), transparent);
            transform: rotate(45deg);
            transition: all 0.5s ease;
        }

        .upload-area:hover {
            border-color: var(--primary);
            background: rgba(26, 86, 50, 0.05);
        }

        .upload-area:hover::before {
            left: 100%;
        }

        .upload-area .icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.6;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .file-item {
            background: white;
            padding: 1.3rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            animation: slideInUp 0.3s ease;
        }

        .remove-btn {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border: none;
            padding: 0.6rem 1.3rem;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        }

        .form-actions {
            display: flex;
            gap: 1.5rem;
            justify-content: space-between;
            margin-top: 3.5rem;
        }

        .btn {
            padding: 1.2rem 3rem;
            border: none;
            border-radius: 12px;
            font-size: 1.15rem;
            font-weight: 700;
            font-family: 'Tajawal', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--success));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(26, 86, 50, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-4px);
        }

        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .loading.active {
            display: flex;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .form-card {
                padding: 2rem;
            }
            .header h1 {
                font-size: 2rem;
            }
            .form-actions {
                flex-direction: column;
            }
            .btn {
                width: 100%;
                justify-content: center;
            }
            .property-type-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="particle" style="left: 10%; animation-delay: 0s;"></div>
<div class="particle" style="left: 30%; animation-delay: 2s;"></div>
<div class="particle" style="left: 50%; animation-delay: 4s;"></div>
<div class="particle" style="left: 70%; animation-delay: 6s;"></div>
<div class="particle" style="left: 90%; animation-delay: 8s;"></div>

<div class="loading" id="loading">
    <div class="spinner"></div>
</div>

<div class="container">
    <div class="form-card">
        <div class="header">
            <h1>📝 طلب إنشاء دفتر عقاري</h1>
            <p>املأ البيانات بدقة للحصول على دفتر عقاري رسمي</p>
            <!-- تعريف مبسط للدفتر العقاري -->
            <div class="definition-note">
                <strong>الدفتر العقاري</strong> هو وثيقة رسمية تثبت ملكية العقار وتسجيله لدى مصالح المسح العقاري، ويعد السند القانوني الوحيد للملكية العقارية.
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            ❌ {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <strong>⚠️ يرجى تصحيح الأخطاء التالية:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="progress-steps" id="progressSteps">
            <div class="step active">
                <div class="step-circle">1</div>
                <div class="step-label">بيانات الطالب</div>
            </div>
            <div class="step">
                <div class="step-circle">2</div>
                <div class="step-label">تعيين العقار</div>
            </div>
            <div class="step">
                <div class="step-circle">3</div>
                <div class="step-label">رفع الوثائق</div>
            </div>
        </div>

        <form method="POST" action="{{ route('land.register.store') }}" id="mainForm" enctype="multipart/form-data">
            @csrf

            <!-- المرحلة 1: بيانات الطالب -->
            <div class="form-section active" id="step1">
                <h2 class="section-title">المرحلة الأولى: بيانات الطالب</h2>

                <div class="form-group">
                    <label>رقم التعريف الوطني <span class="required">*</span></label>
                    <input type="text" 
                           name="national_id" 
                           id="national_id"
                           class="form-control" 
                           placeholder="أدخل 18 رقماً (مثال: 123456789012345678)" 
                           value="{{ old('national_id') }}"
                           required>
                    <small style="color: #666; font-size: 0.9rem; display: block; margin-top: 0.5rem;">
                        ⚠️ يجب إدخال 18 رقماً بالضبط
                    </small>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>اللقب <span class="required">*</span></label>
                        <input type="text" name="last_name" class="form-control" 
                               placeholder="أدخل اللقب" 
                               value="{{ old('last_name') }}" required>
                    </div>

                    <div class="form-group">
                        <label>الاسم <span class="required">*</span></label>
                        <input type="text" name="first_name" class="form-control" 
                               placeholder="أدخل الاسم" 
                               value="{{ old('first_name') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>اسم الأب <span class="required">*</span></label>
                        <input type="text" name="father_name" class="form-control" 
                               placeholder="أدخل اسم الأب" 
                               value="{{ old('father_name') }}" required>
                    </div>

                    <div class="form-group">
                        <label>تاريخ الميلاد <span class="required">*</span></label>
                        <input type="date" name="birth_date" class="form-control" 
                               value="{{ old('birth_date') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>رقم الهاتف <span class="required">*</span></label>
                        <input type="tel" name="phone" class="form-control" 
                               placeholder="0XXX XX XX XX" 
                               value="{{ old('phone') }}" required>
                    </div>

                    <div class="form-group">
                        <label>البريد الإلكتروني <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control" 
                               placeholder="example@email.com" 
                               value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>الولاية <span class="required">*</span></label>
                        <select name="wilaya" class="form-control" required>
                            <option value="">اختر الولاية</option>
                            <option value="أدرار">أدرار</option>
                            <option value="الشلف">الشلف</option>
                            <option value="الأغواط">الأغواط</option>
                            <option value="باتنة">باتنة</option>
                            <option value="بسكرة">بسكرة</option>
                            <option value="ورقلة">ورقلة</option>
                            <!-- إضافة ولاية أولاد جلال وأربع ولايات أخرى -->
                            <option value="أولاد جلال">أولاد جلال</option>
                            <option value="الجلفة">الجلفة</option>
                            <option value="المسيلة">المسيلة</option>
                            <option value="الوادي">الوادي</option>
                            <option value="برج بوعريريج">برج بوعريريج</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>البلدية <span class="required">*</span></label>
                        <input type="text" name="commune" class="form-control" 
                               placeholder="أدخل اسم البلدية" 
                               value="{{ old('commune') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>صفة الطالب <span class="required">*</span></label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="owner" name="applicant_type" value="مالك" required>
                            <label for="owner">مالك</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="heir" name="applicant_type" value="وارث" required>
                            <label for="heir">وارث</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="agent" name="applicant_type" value="وكيل" required>
                            <label for="agent">وكيل</label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ url('/') }}" class="btn btn-secondary">
                        <span>←</span>
                        <span>إلغاء</span>
                    </a>
                    <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                        <span>التالي</span>
                        <span>→</span>
                    </button>
                </div>
            </div>

            <!-- المرحلة 2: تعيين العقار -->
            <div class="form-section" id="step2">
                <h2 class="section-title">المرحلة الثانية: تعيين العقار</h2>

                <!-- اختيار نوع العقار: ممسوح أو غير ممسوح -->
                <div class="property-type-selector">
                    <h3>🗺️ نوع مسح العقار</h3>
                    <div class="property-type-cards">
                        <div class="property-card" onclick="selectSurveyType('surveyed')">
                            <input type="radio" name="survey_status" id="surveyed" value="ممسوح" required>
                            <div class="icon">📏</div>
                            <h4>عقار ممسوح</h4>
                            <p>العقار مسجل في المسح العقاري</p>
                        </div>

                        <div class="property-card" onclick="selectSurveyType('non_surveyed')">
                            <input type="radio" name="survey_status" id="non_surveyed" value="غير ممسوح" required>
                            <div class="icon">📝</div>
                            <h4>عقار غير ممسوح</h4>
                            <p>العقار غير مسجل في المسح</p>
                        </div>
                    </div>
                </div>

                <!-- حقول العقار الممسوح -->
                <div class="conditional-fields" id="surveyedFields" style="display: none;">
                    <h4 style="color: var(--primary); margin-bottom: 1.5rem; font-size: 1.3rem;">📏 بيانات العقار الممسوح</h4>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>بلدية تواجد العقار <span class="required">*</span></label>
                            <input type="text" name="surveyed_commune" class="form-control" 
                                   placeholder="أدخل بلدية تواجد العقار">
                        </div>

                        <div class="form-group">
                            <label>القسم <span class="required">*</span></label>
                            <input type="text" name="section" class="form-control" 
                                   placeholder="أدخل القسم">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>الرقم <span class="required">*</span></label>
                            <input type="text" name="parcel_number" class="form-control" 
                                   placeholder="رقم القطعة">
                        </div>

                        <div class="form-group">
                            <label>المساحة (م²) <span class="required">*</span></label>
                            <input type="number" step="0.01" name="surveyed_area" class="form-control" 
                                   placeholder="المساحة بالمتر المربع">
                        </div>
                    </div>
                </div>

             <!-- الحقول الحالية للعقار الغير ممسوح -->
<div class="conditional-fields" id="nonSurveyedFields" style="display: none;">
    <h4 style="color: var(--primary); margin-bottom: 1.5rem; font-size: 1.3rem;">📝 بيانات العقار الغير ممسوح</h4>
    
    <div class="form-row">
        <div class="form-group">
            <label>بلدية تواجد العقار <span class="required">*</span></label>
            <input type="text" name="non_surveyed_commune" class="form-control" 
                   placeholder="أدخل بلدية تواجد العقار">
        </div>

        <div class="form-group">
            <label>التجزئة / التعاونية / الحي <span class="required">*</span></label>
            <input type="text" name="subdivision" class="form-control" 
                   placeholder="أدخل التجزئة أو التعاونية أو الحي">
        </div>
    </div>

    <!-- ======== أضيفي هذين الحقلين الجديدين ======== -->
    <div class="form-row">
        <div class="form-group">
            <label>القسم (اختياري)</label>
            <input type="text" name="non_surveyed_section" class="form-control" 
                   placeholder="أدخل القسم إذا كان متوفراً">
        </div>

        <div class="form-group">
            <label>الرقم (اختياري)</label>
            <input type="text" name="non_surveyed_parcel_number" class="form-control" 
                   placeholder="أدخل رقم القطعة إذا كان متوفراً">
        </div>
    </div>
    <!-- ======== نهاية الحقول المضافة ======== -->

    <div class="form-group">
        <label>المساحة (م²) - اختياري</label>
        <input type="number" step="0.01" name="non_surveyed_area" class="form-control" 
               placeholder="المساحة بالمتر المربع (اختياري)">
    </div>
</div>
                <!-- نوع العقار -->
                <div class="form-group" style="margin-top: 2rem;">
                    <label>نوع العقار <span class="required">*</span></label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="housing" name="property_type" value="سكن تساهمي" required>
                            <label for="housing">سكن تساهمي</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="building_land" name="property_type" value="قطعة أرض صالحة للبناء" required>
                            <label for="building_land">قطعة أرض صالحة للبناء</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="farm_land" name="property_type" value="قطعة أرض فلاحية" required>
                            <label for="farm_land">قطعة أرض فلاحية</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="industrial" name="property_type" value="صناعي" required>
                            <label for="industrial">صناعي</label>
                        </div>
                    </div>
                </div>

                <!-- نوع الطلب -->
                <div class="form-group">
                    <label>نوع الطلب <span class="required">*</span></label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="new_request" name="request_type" value="طلب جديد" required checked>
                            <label for="new_request">طلب جديد</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="copy_request" name="request_type" value="نسخة دفتر" required>
                            <label for="copy_request">نسخة دفتر</label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(1)">
                        <span>←</span>
                        <span>السابق</span>
                    </button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                        <span>التالي</span>
                        <span>→</span>
                    </button>
                </div>
            </div>

            <!-- المرحلة 3: رفع الوثائق -->
            <div class="form-section" id="step3">
                <h2 class="section-title">المرحلة الثالثة: رفع الوثائق المطلوبة</h2>

                <!-- قائمة الوثائق المطلوبة -->
                <div class="documents-list">
                    <h3>📋 الوثائق المطلوبة</h3>

                    <div class="document-item">
                        <div class="icon">📄</div>
                        <div class="info">
                            <div class="title">1. عقد إثبات الملكية</div>
                            <div class="desc">العقد الأصلي الذي يثبت ملكية العقار</div>
                        </div>
                    </div>

                    <div class="document-item">
                        <div class="icon">🎂</div>
                        <div class="info">
                            <div class="title">2. شهادة الميلاد</div>
                            <div class="desc">نسخة من شهادة الميلاد رقم 12</div>
                        </div>
                    </div>

                    <div class="document-item">
                        <div class="icon">🪪</div>
                        <div class="info">
                            <div class="title">3. نسخة من بطاقة التعريف الوطنية</div>
                            <div class="desc">نسخة واضحة من الوجهين</div>
                        </div>
                    </div>

                    <div class="document-item">
                        <div class="icon">📋</div>
                        <div class="info">
                            <div class="title">4. مقتطف من القسم (CC12)</div>
                            <div class="desc">شهادة CC12 من البلدية</div>
                        </div>
                    </div>
                </div>

                <!-- منطقة رفع الملفات -->
                <div class="upload-section">
                    <h3>📤 قم برفع الوثائق</h3>
                    <p style="text-align: center; color: #666; margin-bottom: 1.5rem; font-weight: 600;">
                        <strong>يجب رفع 4 وثائق على الأقل</strong>
                    </p>
                    
                    <div class="upload-area" id="uploadArea">
                        <div class="icon">📁</div>
                        <p style="font-size: 1.2rem; font-weight: 700; color: var(--primary);">
                            <strong>اضغط هنا لاختيار الملفات</strong>
                        </p>
                        <p style="font-size: 1rem; color: #999; margin-top: 0.7rem;">
                            PDF, JPG, PNG (الحد الأقصى: 5MB لكل ملف)
                        </p>
                    </div>
                    
                    <div id="uploadedFiles" style="margin-top: 2rem;"></div>
                    
                    <div id="uploadWarning" style="display: none; background: #fff3cd; padding: 1rem; border-radius: 10px; margin-top: 1rem; color: #856404; text-align: center; font-weight: 600;">
                        ⚠️ يرجى رفع 4 وثائق على الأقل قبل التقديم
                    </div>

                    <div id="filesCount" style="margin-top: 1rem; text-align: center; font-weight: 700; color: var(--primary); font-size: 1.2rem;">
                        عدد الملفات المرفوعة: <span id="count">0</span> / 4
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(2)">
                        <span>←</span>
                        <span>السابق</span>
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span>✓</span>
                        <span>تقديم الطلب</span>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
let currentStep = 1;
let allFiles = [];

// رفع الملفات
document.getElementById('uploadArea').addEventListener('click', function() {
    const input = document.createElement('input');
    input.type = 'file';
    input.multiple = true;
    input.accept = '.pdf,.jpg,.jpeg,.png';
    input.onchange = function(e) {
        handleFileSelect(e.target.files);
    };
    input.click();
});

// اختيار نوع المسح
function selectSurveyType(type) {
    document.querySelectorAll('.property-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    event.currentTarget.classList.add('selected');
    
    if (type === 'surveyed') {
        document.getElementById('surveyed').checked = true;
        document.getElementById('surveyedFields').style.display = 'block';
        document.getElementById('nonSurveyedFields').style.display = 'none';
        
        // جعل الحقول مطلوبة
        document.querySelectorAll('#surveyedFields input').forEach(input => {
            input.required = true;
        });
        document.querySelectorAll('#nonSurveyedFields input').forEach(input => {
            input.required = false;
        });
    } else {
        document.getElementById('non_surveyed').checked = true;
        document.getElementById('nonSurveyedFields').style.display = 'block';
        document.getElementById('surveyedFields').style.display = 'none';
        
        // جعل الحقول مطلوبة
        document.querySelectorAll('#nonSurveyedFields input').forEach(input => {
            if (input.name !== 'non_surveyed_area') {
                input.required = true;
            }
        });
        document.querySelectorAll('#surveyedFields input').forEach(input => {
            input.required = false;
        });
    }
}

function nextStep(step) {
    const currentStepElement = document.getElementById(`step${currentStep}`);
    const inputs = currentStepElement.querySelectorAll('input[required], select[required]');
    let isValid = true;
    let errorMessage = '';

    inputs.forEach(input => {
        if (input.type === 'radio') {
            const radioGroup = currentStepElement.querySelectorAll(`input[name="${input.name}"]`);
            const isChecked = Array.from(radioGroup).some(radio => radio.checked);
            if (!isChecked) {
                isValid = false;
                errorMessage = 'الرجاء ملء جميع الحقول المطلوبة';
            }
        } else if (!input.value) {
            isValid = false;
            input.style.borderColor = '#e74c3c';
            setTimeout(() => input.style.borderColor = '', 2000);
            errorMessage = 'الرجاء ملء جميع الحقول المطلوبة';
        }
    });

    if (currentStep === 1) {
        const nationalId = document.getElementById('national_id').value.replace(/\s/g, '');
        if (nationalId.length !== 18 || !/^\d{18}$/.test(nationalId)) {
            isValid = false;
            errorMessage = '⚠️ رقم التعريف الوطني يجب أن يكون 18 رقماً بالضبط';
            document.getElementById('national_id').style.borderColor = '#e74c3c';
        } else {
            document.getElementById('national_id').value = nationalId;
        }
    }

    if (!isValid) {
        alert(errorMessage);
        return;
    }

    document.getElementById('loading').classList.add('active');
    
    setTimeout(() => {
        currentStep = step;
        updateSteps();
        document.getElementById('loading').classList.remove('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }, 500);
}

function prevStep(step) {
    currentStep = step;
    updateSteps();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function updateSteps() {
    document.querySelectorAll('.form-section').forEach(section => {
        section.classList.remove('active');
    });
    
    document.getElementById(`step${currentStep}`).classList.add('active');

    const steps = document.querySelectorAll('.step');
    steps.forEach((step, index) => {
        if (index + 1 === currentStep) {
            step.classList.add('active');
        } else {
            step.classList.remove('active');
        }
    });
}

function handleFileSelect(files) {
    Array.from(files).forEach(file => {
        if (file.size > 5 * 1024 * 1024) {
            alert(`❌ الملف ${file.name} أكبر من 5MB`);
            return;
        }
        
        const exists = allFiles.some(f => f.name === file.name && f.size === file.size);
        if (!exists) {
            allFiles.push(file);
        }
    });
    
    renderFilesList();
}

function renderFilesList() {
    const uploadedFilesDiv = document.getElementById('uploadedFiles');
    const uploadWarning = document.getElementById('uploadWarning');
    const countSpan = document.getElementById('count');
    
    uploadedFilesDiv.innerHTML = '';
    countSpan.textContent = allFiles.length;
    
    if (allFiles.length < 4) {
        uploadWarning.style.display = 'block';
    } else {
        uploadWarning.style.display = 'none';
    }
    
    allFiles.forEach((file, index) => {
        const fileItem = document.createElement('div');
        fileItem.className = 'file-item';
        fileItem.innerHTML = `
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 2rem;">
                    ${file.type.includes('pdf') ? '📄' : '🖼️'}
                </span>
                <div>
                    <div style="font-weight: 700; font-size: 1.05rem;">${file.name}</div>
                    <div style="font-size: 0.9rem; color: #666;">${(file.size / 1024).toFixed(2)} KB</div>
                </div>
            </div>
            <button type="button" class="remove-btn" onclick="removeFile(${index})">
                ✗ حذف
            </button>
        `;
        uploadedFilesDiv.appendChild(fileItem);
    });
}

function removeFile(index) {
    allFiles.splice(index, 1);
    renderFilesList();
}

document.getElementById('mainForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (allFiles.length < 4) {
        alert('⚠️ يجب رفع 4 وثائق على الأقل');
        return false;
    }
    
    const formData = new FormData(this);
    formData.delete('documents[]');
    
    allFiles.forEach(file => {
        formData.append('documents[]', file);
    });
    
    document.getElementById('loading').classList.add('active');
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('loading').classList.remove('active');
        document.open();
        document.write(html);
        document.close();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    })
    .catch(error => {
        document.getElementById('loading').classList.remove('active');
        alert('❌ حدث خطأ');
        console.error(error);
    });
});
</script>

</body>
</html>