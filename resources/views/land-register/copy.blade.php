<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>طلب نسخة دفتر عقاري | المحافظة العقارية</title>
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
            --primary-light: #2d7a4d;
            --secondary: #c9a063;
            --bg-light: #f8f6f1;
            --danger: #e74c3c;
            --text-dark: #2d2d2d;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #0d3d20 0%, #1a5632 50%, #2d7a4d 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(201, 160, 99, 0.1);
            border-radius: 20px;
            animation: float-rotate 25s infinite linear;
        }

        .shape:nth-child(1) { width: 120px; height: 120px; top: 10%; right: 10%; animation-delay: 0s; }
        .shape:nth-child(2) { width: 180px; height: 180px; bottom: 10%; left: 5%; animation-delay: 8s; }
        .shape:nth-child(3) { width: 100px; height: 100px; top: 50%; left: 15%; animation-delay: 16s; }

        @keyframes float-rotate {
            0% { transform: rotate(0deg) translateY(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: rotate(360deg) translateY(-50px); opacity: 0; }
        }

        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--secondary);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--secondary);
            animation: float-particle 18s infinite;
        }

        @keyframes float-particle {
            0%, 100% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 0.5; }
            90% { opacity: 0.5; }
            100% { transform: translateY(-10vh) scale(1); opacity: 0; }
        }

        .container {
            width: 100%;
            max-width: 800px;
            position: relative;
            z-index: 10;
        }

        .form-wrapper {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            box-shadow: 
                0 25px 70px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.3) inset;
            overflow: hidden;
            animation: slide-up 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slide-up {
            0% { opacity: 0; transform: translateY(50px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        .form-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(201, 160, 99, 0.2) 0%, transparent 60%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .icon-wrapper {
            width: 90px;
            height: 90px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
            font-size: 2.8rem;
            border: 2px solid rgba(201, 160, 99, 0.5);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(201, 160, 99, 0.4); transform: scale(1); }
            50% { box-shadow: 0 0 0 20px rgba(201, 160, 99, 0); transform: scale(1.05); }
        }

        .form-header h1 {
            font-family: 'Amiri', serif;
            font-size: 2.2rem;
            color: white;
            margin-bottom: 0.3rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .form-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }

        .form-body {
            padding: 2.5rem;
        }

        .section-divider {
            display: flex;
            align-items: center;
            margin: 2rem 0 1.5rem;
            color: var(--primary);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .section-divider::before,
        .section-divider::after {
            content: '';
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--secondary), transparent);
        }

        .section-divider::before { margin-left: 1rem; }
        .section-divider::after { margin-right: 1rem; }

        .section-icon {
            background: var(--primary);
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            margin: 0 0.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.2rem;
        }

        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr; }
            .form-body { padding: 1.5rem; }
            .form-header h1 { font-size: 1.6rem; }
            .icon-wrapper { width: 70px; height: 70px; font-size: 2rem; }
        }

        .form-group {
            position: relative;
            margin-bottom: 0.5rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 1.1rem 1.3rem;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Tajawal', sans-serif;
            background: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control:hover {
            border-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(201, 160, 99, 0.15);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 
                0 0 0 4px rgba(26, 86, 50, 0.1),
                0 8px 20px rgba(26, 86, 50, 0.1);
            transform: translateY(-3px);
        }

        .floating-label {
            position: absolute;
            right: 1.3rem;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            padding: 0 0.4rem;
            color: #999;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            pointer-events: none;
            z-index: 3;
        }

        .form-control:focus ~ .floating-label,
        .form-control:not(:placeholder-shown) ~ .floating-label {
            top: 0;
            font-size: 0.8rem;
            color: var(--primary);
            font-weight: 700;
        }

        .required-star {
            color: var(--danger);
            margin-right: 3px;
        }

        .optional-tag {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(201, 160, 99, 0.15);
            color: var(--primary);
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            z-index: 3;
        }

        select.form-control {
            appearance: none;
            cursor: pointer;
            padding-left: 2.5rem;
            color: var(--text-dark);
        }

        select.form-control:invalid {
            color: #999;
        }

        .select-arrow {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 0.9rem;
            pointer-events: none;
            transition: transform 0.3s ease;
        }

        .form-control:focus ~ .select-arrow {
            transform: translateY(-50%) rotate(180deg);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
            padding-top: 1.2rem;
        }

        textarea ~ .floating-label {
            top: 1.2rem;
        }

        textarea:focus ~ .floating-label,
        textarea:not(:placeholder-shown) ~ .floating-label {
            top: 0;
        }

        .info-note {
            background: rgba(201, 160, 99, 0.1);
            border-right: 4px solid var(--secondary);
            padding: 0.8rem 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            font-size: 0.9rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            flex: 1;
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 700;
            font-family: 'Tajawal', sans-serif;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        .btn::before {
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

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            box-shadow: 0 6px 20px rgba(26, 86, 50, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(26, 86, 50, 0.4);
        }

        .btn-secondary {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 2px solid #dee2e6;
        }

        .btn-secondary:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-3px);
        }

        .alert {
            padding: 1.2rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slide-in 0.5s ease;
            border-right: 4px solid;
        }

        @keyframes slide-in {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .alert-success {
            background: #d4edda;
            border-right-color: #27ae60;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            border-right-color: #e74c3c;
            color: #721c24;
        }

        .loading-screen {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(13, 61, 32, 0.95);
            z-index: 9999;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 1.5rem;
        }

        .loading-screen.active {
            display: flex;
        }

        .loader {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255,255,255,0.3);
            border-top-color: var(--secondary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-text {
            color: white;
            font-size: 1.2rem;
            font-weight: 500;
        }

        .hidden-field {
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .hidden-field.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
            animation: slide-down 0.3s ease;
        }

        @keyframes slide-down {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="particles" id="particles"></div>

    <div class="loading-screen" id="loading">
        <div class="loader"></div>
        <div class="loading-text">جاري معالجة طلبك...</div>
    </div>

    <div class="container">
        <div class="form-wrapper">
            <div class="form-header">
                <div class="header-content">
                    <div class="icon-wrapper">📖</div>
                    <h1>طلب نسخة دفتر عقاري</h1>
                    <p>محافظة العقارية أولاد جلال</p>
                </div>
            </div>

            <div class="form-body">
                
                @if(session('success'))
                <div class="alert alert-success">
                    <span style="font-size: 1.5rem;">✅</span>
                    <div><strong>تم بنجاح!</strong><br>{{ session('success') }}</div>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    <span style="font-size: 1.5rem;">❌</span>
                    <div><strong>عذراً!</strong><br>{{ session('error') }}</div>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    <span style="font-size: 1.5rem;">⚠️</span>
                    <div>
                        <strong>يرجى تصحيح الأخطاء:</strong>
                        <ul style="margin: 0.3rem 0 0 0; padding-right: 1.2rem; font-size: 0.9rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('land.register.copy.store') }}" id="copyForm">
                    @csrf
                    <input type="hidden" name="request_type" value="نسخة دفتر">

                    <div class="section-divider">
                        <span class="section-icon">👤</span>
                        <span>المعلومات الشخصية</span>
                    </div>

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <div class="input-wrapper">
                                <input type="text" name="full_name" class="form-control" 
                                       placeholder=" " value="{{ old('full_name') }}" required>
                                <label class="floating-label">الاسم الكامل <span class="required-star">*</span></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-wrapper">
                                <input type="text" name="national_id" class="form-control" 
                                       placeholder=" " maxlength="18" value="{{ old('national_id') }}" required>
                                <label class="floating-label">رقم التعريف الوطني <span class="required-star">*</span></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-wrapper">
                                <input type="tel" name="phone" class="form-control" 
                                       placeholder=" " value="{{ old('phone') }}" required>
                                <label class="floating-label">رقم الهاتف <span class="required-star">*</span></label>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <div class="input-wrapper">
                                <input type="email" name="email" class="form-control" 
                                       placeholder=" " value="{{ old('email') }}" required>
                                <label class="floating-label">البريد الإلكتروني <span class="required-star">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="section-divider">
                        <span class="section-icon">🏛️</span>
                        <span>معلومات العقار</span>
                    </div>

                    <div class="info-note">
                        <span>ℹ️</span>
                        <span>إذا كنت لا تعلم رقم الدفتر العقاري، يمكنك تركه فارغاً</span>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <input type="text" name="section" class="form-control"
                                       placeholder=" " value="{{ old('section') }}" required>
                                <label class="floating-label">القسم <span class="required-star">*</span></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-wrapper">
                                <input type="number" name="property_group" class="form-control" 
                                       placeholder=" " value="{{ old('property_group') }}" required>
                                <label class="floating-label">رقم مجموعة الملكية <span class="required-star">*</span></label>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <div class="input-wrapper">
                                <input type="text" name="register_number" class="form-control" 
                                       placeholder=" " value="{{ old('register_number') }}">
                                <label class="floating-label">رقم الدفتر العقاري</label>
                                <span class="optional-tag">اختياري</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group full-width" style="margin-top: 1rem;">
                        <div class="input-wrapper">
                            <select name="request_reason" class="form-control" id="reasonSelect" required>
                                <option value="" disabled selected></option>
                                <option value="فقدان النسخة الأصلية" {{ old('request_reason') == 'فقدان النسخة الأصلية' ? 'selected' : '' }}>فقدان النسخة الأصلية</option>
                                <option value="تلف الدفتر" {{ old('request_reason') == 'تلف الدفتر' ? 'selected' : '' }}>تلف الدفتر</option>
                                <option value="للإجراءات الإدارية" {{ old('request_reason') == 'للإجراءات الإدارية' ? 'selected' : '' }}>للإجراءات الإدارية</option>
                                <option value="للتقاضي" {{ old('request_reason') == 'للتقاضي' ? 'selected' : '' }}>للتقاضي</option>
                                <option value="أخرى" {{ old('request_reason') == 'أخرى' ? 'selected' : '' }}>سبب آخر...</option>
                            </select>
                            <span class="select-arrow">▼</span>
                            <label class="floating-label">سبب الطلب <span class="required-star">*</span></label>
                        </div>
                    </div>

                    <div class="form-group full-width hidden-field" id="otherReasonContainer">
                        <div class="input-wrapper">
                            <textarea name="other_reason" class="form-control" 
                                      placeholder=" " id="otherReasonTextarea">{{ old('other_reason') }}</textarea>
                            <label class="floating-label">توضيح السبب <span class="required-star">*</span></label>
                        </div>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">
                            <span>📤</span>
                            <span>تقديم الطلب</span>
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            <span>←</span>
                            <span>العودة</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const particlesContainer = document.getElementById('particles');
        for(let i = 0; i < 25; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 18 + 's';
            particle.style.animationDuration = (12 + Math.random() * 8) + 's';
            particlesContainer.appendChild(particle);
        }

        document.getElementById('copyForm').addEventListener('submit', function() {
            document.getElementById('loading').classList.add('active');
        });

        const reasonSelect = document.getElementById('reasonSelect');
        const otherContainer = document.getElementById('otherReasonContainer');
        const otherTextarea = document.getElementById('otherReasonTextarea');

        reasonSelect.addEventListener('change', function() {
            if (this.value === 'أخرى') {
                otherContainer.classList.add('show');
                otherTextarea.required = true;
                setTimeout(() => otherTextarea.focus(), 100);
            } else {
                otherContainer.classList.remove('show');
                otherTextarea.required = false;
            }
        });

        if (reasonSelect.value === 'أخرى') {
            otherContainer.classList.add('show');
            otherTextarea.required = true;
        }

        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>

</body>
</html>