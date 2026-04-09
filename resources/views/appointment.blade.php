<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>حجز موعد | المحافظة العقارية</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary: #1a5632;
            --primary-dark: #0d3d20;
            --secondary: #c49b63;
            --bg-light: #f8f6f1;
            --text-dark: #2d2d2d;
            --text-light: #6b6b6b;
            --danger: #e74c3c;
            --success: #27ae60;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            min-height: 100vh;
            padding: 2rem;
            direction: rtl;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: bgPulse 8s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes bgPulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        .particles {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: floatParticle 15s infinite;
        }

        @keyframes floatParticle {
            0%, 100% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
        }

        .booking-container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* ===== زر الرجوع - نفس تنسيق صفحة اتصل بنا ===== */
        .back-btn {
            position: fixed;
            top: 2rem;
            left: 2rem;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            color: white;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            text-decoration: none;
            z-index: 1000;
            animation: floatBtn 3s ease-in-out infinite, glowBtn 2s ease-in-out infinite alternate;
        }

        @keyframes floatBtn {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes glowBtn {
            from { box-shadow: 0 0 20px rgba(255,255,255,0.2); }
            to { box-shadow: 0 0 40px rgba(255,255,255,0.6), 0 0 60px rgba(196,155,99,0.4); }
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.2) rotate(360deg);
            border-color: var(--secondary);
        }

        /* رأس الصفحة */
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            animation: slideDown 1s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-header h1 {
            color: white;
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 1rem;
            animation: titleGlow 3s ease-in-out infinite;
        }

        @keyframes titleGlow {
            0%, 100% { text-shadow: 0 0 30px rgba(255,255,255,0.3); }
            50% { text-shadow: 0 0 50px rgba(255,255,255,0.6), 0 0 80px var(--secondary); }
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.4rem;
            animation: fadeInUp 1s ease-out 0.3s both;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .booking-layout {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 2rem;
            perspective: 1000px;
        }

        /* بطاقة المعلومات */
        .info-card {
            background: white;
            border-radius: 25px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            height: fit-content;
            animation: flipInRight 1s ease-out 0.5s both;
            transform-style: preserve-3d;
            transition: transform 0.6s ease;
        }

        @keyframes flipInRight {
            from { opacity: 0; transform: rotateY(90deg) translateX(100px); }
            to { opacity: 1; transform: rotateY(0) translateX(0); }
        }

        .info-card:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
        }

        .info-card h3 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .info-item {
            display: flex;
            align-items: start;
            gap: 1.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background: var(--bg-light);
            border-radius: 15px;
            border-right: 4px solid var(--secondary);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            animation: bounceIn 0.8s ease-out both;
        }

        .info-item:nth-child(2) { animation-delay: 0.2s; }
        .info-item:nth-child(3) { animation-delay: 0.4s; }
        .info-item:nth-child(4) { animation-delay: 0.6s; }

        @keyframes bounceIn {
            0% { opacity: 0; transform: scale(0.3) translateY(50px); }
            50% { transform: scale(1.05) translateY(-10px); }
            70% { transform: scale(0.95) translateY(5px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        .info-item:hover {
            transform: translateX(-15px) scale(1.03);
            box-shadow: 0 15px 40px rgba(26, 86, 50, 0.2);
            border-right-width: 8px;
        }

        .info-item .icon {
            font-size: 2rem;
            flex-shrink: 0;
            width: 60px; height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 20px rgba(26, 86, 50, 0.3);
            animation: iconPulse 2s ease-in-out infinite;
            color: white;
        }

        @keyframes iconPulse {
            0%, 100% { transform: scale(1); box-shadow: 0 5px 20px rgba(26, 86, 50, 0.3); }
            50% { transform: scale(1.1); box-shadow: 0 8px 30px rgba(26, 86, 50, 0.5); }
        }

        .info-item:hover .icon { animation: iconSpin 0.6s ease; }

        @keyframes iconSpin {
            from { transform: rotate(0deg) scale(1); }
            to { transform: rotate(360deg) scale(1.2); }
        }

        .info-item .content h4 {
            font-size: 1.3rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .info-item .content p {
            color: var(--text-light);
            font-size: 1rem;
            line-height: 1.6;
            margin: 0;
        }

        .info-item .content strong { color: var(--secondary); }

        /* بطاقة الفورم */
        .booking-card {
            background: white;
            border-radius: 25px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            animation: slideUp 1s ease-out 0.7s both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(100px) rotateX(20deg); }
            to { opacity: 1; transform: translateY(0) rotateX(0); }
        }

        .booking-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 2.5rem 2rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .booking-header::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: headerShine 5s linear infinite;
        }

        @keyframes headerShine {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .booking-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .booking-header p {
            position: relative;
            z-index: 1;
            opacity: 0.9;
            font-size: 1.2rem;
        }

        .booking-form { padding: 2.5rem; }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        /* ===== Input Groups - نفس تنسيق اتصل بنا (مربعات) ===== */
        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
            animation: fadeInUp 0.6s ease-out both;
        }

        .input-group:nth-child(1) { animation-delay: 1.2s; }
        .input-group:nth-child(2) { animation-delay: 1.4s; }
        .input-group:nth-child(3) { animation-delay: 1.6s; }
        .input-group:nth-child(4) { animation-delay: 1.8s; }

        .input-group label {
            display: block;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.6rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input-group input,
        .input-group select,
        .input-group textarea {
            width: 100%;
            padding: 1rem 1.3rem;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            background: white;
            font-family: inherit;
        }

        .input-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .input-group input:focus,
        .input-group select:focus,
        .input-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(26, 86, 50, 0.1), 0 10px 30px rgba(26, 86, 50, 0.2);
            transform: translateY(-3px) scale(1.02);
        }

        .input-group:focus-within label {
            color: var(--primary);
            transform: translateX(-10px);
        }

        .required { color: var(--danger); }

        /* Submit Box */
        .submit-box {
            text-align: center;
            padding-top: 2rem;
            border-top: 2px solid rgba(26, 86, 50, 0.1);
            animation: fadeIn 1s ease-out 2s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .submit-box button {
            background: linear-gradient(135deg, var(--secondary), #8b6f47);
            color: white;
            border: none;
            padding: 1.3rem 4rem;
            font-size: 1.2rem;
            font-weight: 700;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            font-family: inherit;
            position: relative;
            overflow: hidden;
            animation: btnPulse 2s ease-in-out infinite;
            width: 100%;
            justify-content: center;
        }

        @keyframes btnPulse {
            0%, 100% { box-shadow: 0 5px 20px rgba(139,111,71,0.4); }
            50% { box-shadow: 0 10px 40px rgba(139,111,71,0.6), 0 0 60px rgba(196,155,99,0.3); }
        }

        .submit-box button::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .submit-box button:hover {
            transform: translateY(-8px) scale(1.08);
            box-shadow: 0 20px 60px rgba(139,111,71,0.6);
            animation: none;
        }

        .submit-box button:hover::before { left: 100%; }
        .submit-box button:disabled { opacity: 0.7; cursor: not-allowed; }

        .loading-spinner {
            display: none;
            width: 22px; height: 22px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .error-message {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            border-right: 6px solid var(--danger);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            display: none;
            align-items: center;
            gap: 0.8rem;
            font-weight: 700;
            color: #721c24;
            border: 2px solid #f1b0b7;
        }

        .success-message {
            background: rgba(232,248,245,0.95);
            border-radius: 50px;
            padding: 2.5rem;
            text-align: center;
            border: 4px solid var(--success);
            animation: pop-in 0.6s cubic-bezier(0.34,1.56,0.64,1);
            display: none;
            margin-top: 2rem;
        }

        @keyframes pop-in {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }

        .success-icon {
            width: 100px; height: 100px;
            background: var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 3rem;
            color: white;
            animation: success-pulse 2s infinite;
        }

        @keyframes success-pulse {
            0%,100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(39,174,96,0.5); }
            50% { transform: scale(1.1); box-shadow: 0 0 30px 10px rgba(39,174,96,0.5); }
        }

        .success-message h2 { font-size: 2rem; color: var(--success); margin-bottom: 1rem; }
        .success-message p  { font-size: 1.2rem; line-height: 1.8; color: #2c3e50; }

        .footer-note {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
        }

        @media (max-width: 1024px) {
            .booking-layout { grid-template-columns: 1fr; }
            .page-header h1 { font-size: 2.5rem; }
        }

        @media (max-width: 768px) {
            body { padding: 1rem; }
            .page-header h1 { font-size: 2rem; }
            .form-row { grid-template-columns: 1fr; }
            .back-btn { width: 50px; height: 50px; font-size: 1.2rem; }
        }
    </style>
</head>
<body>

    <div class="particles" id="particles"></div>

    <!-- زر الرجوع - نفس تنسيق صفحة اتصل بنا -->
    <a href="{{ route('home') }}" class="back-btn">←</a>

    <div class="booking-container">

        <div class="page-header">
            <h1>📅 حجز موعد</h1>
            <p>المحافظة العقارية – أولاد جلال</p>
        </div>

        <div class="booking-layout">

            <!-- بطاقة المعلومات -->
            <div class="info-card">
                <h3><span>📍</span><span>معلومات هامة</span></h3>

                <div class="info-item">
                    <div class="icon">📅</div>
                    <div class="content">
                        <h4>أيام الاستقبال</h4>
                        <p>الاثنين والأربعاء فقط<br><strong>من 08:00 إلى 12:00 ظهراً</strong></p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon">⚠️</div>
                    <div class="content">
                        <h4>الحجز إلزامي</h4>
                        <p>لا يُستقبل أي مراجع دون موعد مسبق</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon">📞</div>
                    <div class="content">
                        <h4>للاستفسار</h4>
                        <p>الهاتف: <strong>+213 XXX XXX XXX</strong><br>البريد: <strong>contact@conservation.dz</strong></p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon">📍</div>
                    <div class="content">
                        <h4>العنوان</h4>
                        <p>المحافظة العقارية، أولاد جلال، الجزائر</p>
                    </div>
                </div>
            </div>

            <!-- بطاقة الفورم -->
            <div class="booking-card">
                <div class="booking-header">
                    <h2>📝 املأ النموذج</h2>
                    <p>تأكد من صحة المعلومات</p>
                </div>

                <div class="booking-form">

                    <div class="error-message" id="errorMessage">
                        <span style="font-size:1.5rem;">⚠</span>
                        <span id="errorText"></span>
                    </div>

                    <form id="bookingForm">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-row">
                            <div class="input-group">
                                <label>الاسم <span class="required">*</span></label>
                                <input type="text" name="firstname" placeholder="أدخل اسمك" required>
                            </div>
                            <div class="input-group">
                                <label>اللقب <span class="required">*</span></label>
                                <input type="text" name="lastname" placeholder="أدخل لقبك" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="input-group">
                                <label>البريد الإلكتروني <span class="required">*</span></label>
                                <input type="email" name="email" placeholder="example@email.com" required>
                            </div>
                            <div class="input-group">
                                <label>رقم الهاتف <span class="required">*</span></label>
                                <input type="tel" name="phone" placeholder="05XXXXXXXX" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="input-group">
                                <label>تاريخ الموعد <span class="required">*</span></label>
                                <input type="date" id="bookingDate" name="booking_date" required>
                            </div>
                            <div class="input-group">
                                <label>نوع الخدمة <span class="required">*</span></label>
                                <select name="service_type" required>
                                    <option value="">-- اختر --</option>
                                    <option value="شهادة سلبية">📄 شهادة سلبية</option>
                                    <option value="تصحيح معلومات">✏️ تصحيح معلومات</option>
                                    <option value="استفسار إداري">❓ استفسار إداري</option>
                                    <option value="طلب إثبات ملكية">📋 طلب إثبات ملكية</option>
                                    <option value="معاملة عاجلة">⚡ معاملة عاجلة</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-group">
                            <label>ملاحظات إضافية <span style="color:#7f8c8d;">(اختياري)</span></label>
                            <textarea name="notes" placeholder="أضف أي تفاصيل إضافية..."></textarea>
                        </div>

                        <div class="submit-box">
                            <button type="submit" id="submitBtn">
                                <span style="font-size:1.5rem;">✉️</span>
                                <span class="btn-text">تأكيد الحجز</span>
                                <span class="loading-spinner"></span>
                            </button>
                        </div>
                    </form>

                    <div class="success-message" id="successMsg">
                        <div class="success-icon">✓</div>
                        <h2>تم الحجز بنجاح!</h2>
                        <p>
                            تم تسجيل موعدك بنجاح.<br>
                            <strong>سيتم إرسال تفاصيل الموعد إلى بريدك الإلكتروني.</strong><br>
                            <span style="color:var(--danger);font-weight:700;">⚠️ يرجى الالتزام بالموعد والحضور قبل 10 دقائق.</span>
                        </p>
                    </div>

                </div>
            </div>

        </div>

        <div class="footer-note">
            جميع الحقوق محفوظة © 2025 المحافظة العقارية – أولاد جلال
        </div>
    </div>

    <script>
        (function() {
            const particlesContainer = document.getElementById('particles');
            for(let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (10 + Math.random() * 10) + 's';
                particle.style.width = (5 + Math.random() * 10) + 'px';
                particle.style.height = particle.style.width;
                particlesContainer.appendChild(particle);
            }

            const today = new Date().toISOString().split('T')[0];
            const dateInput = document.getElementById('bookingDate');
            dateInput.setAttribute('min', today);

            dateInput.addEventListener('change', function() {
                if (!this.value) return;
                const day = new Date(this.value).getDay();
                if (day !== 1 && day !== 3) {
                    alert('عذراً! الحجز متاح فقط يومي الاثنين والأربعاء.');
                    this.value = '';
                }
            });

            const form       = document.getElementById('bookingForm');
            const submitBtn  = document.getElementById('submitBtn');
            const errorDiv   = document.getElementById('errorMessage');
            const successDiv = document.getElementById('successMsg');
            const errorText  = document.getElementById('errorText');

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                submitBtn.disabled = true;
                submitBtn.querySelector('.btn-text').style.opacity = '0';
                submitBtn.querySelector('.loading-spinner').style.display = 'block';
                errorDiv.style.display = 'none';
                successDiv.style.display = 'none';

                try {
                    const response = await fetch('/appointment/store', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: new FormData(this)
                    });

                    const data = await response.json();

                    if (data.success) {
                        successDiv.style.display = 'block';
                        form.reset();
                        successDiv.scrollIntoView({ behavior: 'smooth' });
                    } else {
                        errorText.textContent = data.message || 'حدث خطأ، يرجى المحاولة مرة أخرى';
                        errorDiv.style.display = 'flex';
                    }
                } catch (error) {
                    errorText.textContent = 'حدث خطأ في الاتصال بالخادم';
                    errorDiv.style.display = 'flex';
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.querySelector('.btn-text').style.opacity = '1';
                    submitBtn.querySelector('.loading-spinner').style.display = 'none';
                }
            });
        })();
    </script>
</body>
</html>