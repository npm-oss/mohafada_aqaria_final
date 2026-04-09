<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد - المحافظة العقارية</title>
    <!-- إضافة Font Awesome للأيقونات (للأسهم) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary: #1a5632;
            --primary-dark: #0d3d20;
            --secondary: #c49b63;
            --accent: #8b6f47;
            --white: #ffffff;
            --shadow: rgba(26, 86, 50, 0.15);
        }

        body {
            font-family: 'Tajawal', 'Segoe UI', 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            position: relative;
            overflow: hidden;
            padding: 1rem;
        }

        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background:
                radial-gradient(circle at 20% 50%, rgba(196,155,99,0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(139,111,71,0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(255,255,255,0.05) 0%, transparent 40%);
            animation: moveBackground 20s ease-in-out infinite;
        }

        @keyframes moveBackground {
            0%,100% { transform: translate(0,0) rotate(0deg); }
            50%      { transform: translate(-50px,50px) rotate(5deg); }
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 15s ease-in-out infinite;
        }
        .shape:nth-child(1) {
            top: 10%; left: 20%;
            width: 80px; height: 80px;
            background: var(--secondary);
            border-radius: 50%;
            animation-delay: 0s;
        }
        .shape:nth-child(2) {
            top: 60%; right: 15%;
            width: 120px; height: 120px;
            background: var(--accent);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation-delay: 2s;
        }
        .shape:nth-child(3) {
            bottom: 20%; left: 10%;
            width: 100px; height: 100px;
            background: var(--white);
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
            animation-delay: 4s;
        }

        @keyframes float {
            0%,100% { transform: translateY(0) rotate(0deg); }
            25%      { transform: translateY(-30px) rotate(90deg); }
            50%      { transform: translateY(-60px) rotate(180deg); }
            75%      { transform: translateY(-30px) rotate(270deg); }
        }

        .register-container {
            position: relative;
            z-index: 10;
            background: rgba(255,255,255,0.98);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            box-shadow:
                0 30px 80px rgba(0,0,0,0.3),
                0 0 0 1px rgba(255,255,255,0.2);
            width: 100%;
            max-width: 480px;
            padding: 2.5rem 2.5rem 2rem;
            animation: slideIn 0.8s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
        }

        @keyframes slideIn {
            from { opacity:0; transform:translateY(50px) scale(0.9); }
            to   { opacity:1; transform:translateY(0)    scale(1);   }
        }

        /* سهم العودة للرئيسية */
        .back-button {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: var(--primary);
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: rgba(26, 86, 50, 0.1);
            border-radius: 50px;
            transition: all 0.3s ease;
            border: 1px solid rgba(26, 86, 50, 0.2);
            z-index: 20;
        }

        .back-button i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .back-button:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 86, 50, 0.3);
        }

        .back-button:hover i {
            transform: translateX(-5px);
        }

        .logo {
            text-align: center;
            margin-bottom: 1.5rem;
            animation: fadeInDown 0.8s ease 0.2s backwards;
        }

        .logo-icon {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: inline-flex;
            align-items: center; justify-content: center;
            font-size: 2.5rem; color: white;
            margin-bottom: 1rem;
            box-shadow: 0 10px 30px rgba(26,86,50,0.3);
            position: relative;
        }

        .logo-icon::before {
            content: '';
            position: absolute; inset: -5px;
            border-radius: 50%;
            border: 3px solid var(--secondary);
            opacity: 0.5;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%,100% { transform:scale(1);   opacity:0.5; }
            50%      { transform:scale(1.1); opacity:0.8; }
        }

        @keyframes fadeInDown {
            from { opacity:0; transform:translateY(-20px); }
            to   { opacity:1; transform:translateY(0); }
        }

        h2 {
            text-align: center;
            color: var(--primary);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
            animation: fadeInDown 0.8s ease 0.3s backwards;
        }

        .subtitle {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1.8rem;
            animation: fadeInDown 0.8s ease 0.4s backwards;
        }

        form { animation: fadeIn 0.8s ease 0.5s backwards; }

        @keyframes fadeIn {
            from { opacity:0; }
            to   { opacity:1; }
        }

        .form-group {
            margin-bottom: 1.4rem;
            position: relative;
        }

        label {
            display: block;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .input-container { position: relative; }

        .input-icon {
            position: absolute;
            right: 1.2rem; top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: var(--primary);
            opacity: 0.6;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 1rem 3.2rem 1rem 1.2rem;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: white;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(26,86,50,0.1);
            transform: translateY(-2px);
        }
        input::placeholder { color: #aaa; }

        .password-toggle {
            position: absolute;
            left: 1.2rem; top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.2rem;
            color: #999;
            transition: all 0.3s ease;
            background: none;
            border: none;
            padding: 0;
            z-index: 10;
        }
        .password-toggle:hover { color: var(--primary); }

        /* مؤشر قوة كلمة المرور */
        .strength-bar {
            display: flex; gap: 4px;
            margin-top: 0.5rem; height: 4px;
        }
        .strength-bar span {
            flex: 1; border-radius: 10px;
            background: #e0e0e0;
            transition: background 0.3s ease;
        }
        .strength-text {
            font-size: 0.78rem; margin-top: 0.3rem;
            color: #999; min-height: 1rem;
        }

        .error-message {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 1rem 1.2rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            animation: shake 0.5s ease;
            box-shadow: 0 5px 15px rgba(238,90,82,0.3);
        }

        @keyframes shake {
            0%,100% { transform:translateX(0);   }
            25%      { transform:translateX(-10px); }
            75%      { transform:translateX(10px);  }
        }

        .btn-register {
            width: 100%;
            padding: 1.1rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(26,86,50,0.3);
            margin-top: 0.5rem;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            width: 0; height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            transform: translate(-50%,-50%);
            transition: width 0.6s, height 0.6s;
        }
        .btn-register:hover::before { width: 500px; height: 500px; }
        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(26,86,50,0.4);
        }
        .btn-register span { position: relative; z-index: 2; }

        .btn-register.loading { pointer-events:none; opacity:0.8; }
        .btn-register.loading::after {
            content: '';
            position: absolute;
            width: 18px; height: 18px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            right: 20px; top: 50%;
            transform: translateY(-50%);
        }
        @keyframes spin { to { transform: translateY(-50%) rotate(360deg); } }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
            font-size: 0.95rem;
        }
        .login-link a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .login-link a:hover { color: var(--secondary); text-decoration: underline; }

        @media (max-width: 576px) {
            .register-container { padding: 2rem 1.5rem; border-radius: 20px; }
            h2 { font-size: 1.5rem; }
            .back-button {
                padding: 5px 10px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>

<div class="shape"></div>
<div class="shape"></div>
<div class="shape"></div>

<div class="register-container">

    <!-- سهم العودة للرئيسية -->
    <a href="{{ route('home') }}" class="back-button">
        <i class="fas fa-arrow-right"></i>
        <span>العودة للرئيسية</span>
    </a>

    <div class="logo">
        <div class="logo-icon">🏛️</div>
    </div>

    <h2>إنشاء حساب جديد</h2>
    <p class="subtitle">أنشئ حسابك للوصول إلى الخدمات العقارية</p>

    @if($errors->any())
    <div class="error-message">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        <!-- الاسم -->
        <div class="form-group">
            <label>الاسم الكامل</label>
            <div class="input-container">
                <input type="text" name="name" placeholder="أدخل اسمك الكامل"
                       value="{{ old('name') }}" required autofocus>
                <span class="input-icon">👤</span>
            </div>
        </div>

        <!-- البريد -->
        <div class="form-group">
            <label>البريد الإلكتروني</label>
            <div class="input-container">
                <input type="email" name="email" placeholder="example@gmail.com"
                       value="{{ old('email') }}" required>
                <span class="input-icon">📧</span>
            </div>
        </div>

        <!-- كلمة المرور -->
        <div class="form-group">
            <label>كلمة المرور</label>
            <div class="input-container">
                <input type="password" name="password" id="password"
                       placeholder="8 أحرف على الأقل" required
                       oninput="checkStrength(this.value)">
                <span class="input-icon">🔒</span>
                <button type="button" class="password-toggle" onclick="togglePass('password', this)">👁️</button>
            </div>
            <div class="strength-bar">
                <span id="s1"></span><span id="s2"></span>
                <span id="s3"></span><span id="s4"></span>
            </div>
            <div class="strength-text" id="strengthText"></div>
        </div>

        <!-- تأكيد كلمة المرور -->
        <div class="form-group">
            <label>تأكيد كلمة المرور</label>
            <div class="input-container">
                <input type="password" name="password_confirmation" id="password2"
                       placeholder="أعد كتابة كلمة المرور" required>
                <span class="input-icon">🔒</span>
                <button type="button" class="password-toggle" onclick="togglePass('password2', this)">👁️</button>
            </div>
        </div>

        <button type="submit" class="btn-register" id="registerBtn">
            <span>إنشاء الحساب</span>
        </button>

    </form>

    <div class="login-link">
        عندك حساب؟ <a href="{{ route('login') }}">سجّل الدخول</a>
    </div>

</div>

<script>
function togglePass(id, btn) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
    } else {
        input.type = 'password';
        btn.textContent = '👁️';
    }
}

function checkStrength(val) {
    const bars   = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
    const txt    = document.getElementById('strengthText');
    let score    = 0;
    if (val.length >= 8)           score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const colors = ['#dc3545','#ffc107','#17a2b8','#28a745'];
    const labels = ['ضعيفة جداً','متوسطة','جيدة','قوية جداً 💪'];

    bars.forEach((b, i) => {
        b.style.background = i < score ? colors[score-1] : '#e0e0e0';
    });
    txt.textContent = val.length ? 'قوة كلمة المرور: ' + labels[score-1] : '';
    txt.style.color = val.length ? colors[score-1] : '#999';
}

document.getElementById('registerForm').addEventListener('submit', function() {
    const btn = document.getElementById('registerBtn');
    btn.classList.add('loading');
    btn.querySelector('span').textContent = 'جاري الإنشاء...';
});
</script>

</body>
</html>