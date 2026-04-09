<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - المحافظة العقارية</title>
    <!-- إضافة Font Awesome للأيقونات (للأسهم) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        /* Animated Background */
        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(196, 155, 99, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(139, 111, 71, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 40%);
            animation: moveBackground 20s ease-in-out infinite;
        }

        @keyframes moveBackground {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-50px, 50px) rotate(5deg); }
        }

        /* Floating Shapes */
        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 15s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            top: 10%;
            left: 20%;
            width: 80px;
            height: 80px;
            background: var(--secondary);
            border-radius: 50%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            top: 60%;
            right: 15%;
            width: 120px;
            height: 120px;
            background: var(--accent);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            bottom: 20%;
            left: 10%;
            width: 100px;
            height: 100px;
            background: var(--white);
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-30px) rotate(90deg); }
            50% { transform: translateY(-60px) rotate(180deg); }
            75% { transform: translateY(-30px) rotate(270deg); }
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 10;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            box-shadow: 
                0 30px 80px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            width: 100%;
            max-width: 480px;
            padding: 3rem 2.5rem;
            animation: slideIn 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
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

        /* Logo */
        .logo {
            text-align: center;
            margin-bottom: 2rem;
            animation: fadeInDown 0.8s ease 0.2s backwards;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 1rem;
            box-shadow: 0 10px 30px rgba(26, 86, 50, 0.3);
            position: relative;
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            border: 3px solid var(--secondary);
            opacity: 0.5;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Heading */
        h2 {
            text-align: center;
            color: var(--primary);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            animation: fadeInDown 0.8s ease 0.3s backwards;
        }

        .subtitle {
            text-align: center;
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 2.5rem;
            animation: fadeInDown 0.8s ease 0.4s backwards;
        }

        /* Form */
        form {
            animation: fadeIn 0.8s ease 0.5s backwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Form Group */
        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }

        label {
            display: block;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 0.6rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        /* Input Container */
        .input-container {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.3rem;
            color: var(--primary);
            opacity: 0.6;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        input {
            width: 100%;
            padding: 1.1rem 3.5rem 1.1rem 1.2rem;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: white;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(26, 86, 50, 0.1);
            transform: translateY(-2px);
        }

        input:focus + .input-icon {
            opacity: 1;
            transform: translateY(-50%) scale(1.1);
        }

        input::placeholder {
            color: #aaa;
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.3rem;
            color: #999;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Remember & Forgot */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: auto;
            cursor: pointer;
        }

        .forgot-link {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-login {
            width: 100%;
            padding: 1.2rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(26, 86, 50, 0.3);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-login:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(26, 86, 50, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .btn-login span {
            position: relative;
            z-index: 2;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            margin-top: 2rem;
            color: #666;
            font-size: 0.95rem;
        }

        .register-link a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        /* Error Messages */
        .error-message {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 1rem 1.2rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            animation: shake 0.5s ease;
            box-shadow: 0 5px 15px rgba(238, 90, 82, 0.3);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        /* Loading State */
        .btn-login.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        @keyframes spin {
            to { transform: translateY(-50%) rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-container {
                padding: 2rem 1.5rem;
                border-radius: 20px;
            }

            h2 {
                font-size: 1.6rem;
            }

            .logo-icon {
                width: 70px;
                height: 70px;
                font-size: 2rem;
            }

            input {
                padding: 1rem 3rem 1rem 1rem;
            }

            .back-button {
                padding: 5px 10px;
                font-size: 0.9rem;
            }
        }

        /* Success Animation */
        @keyframes success {
            0% { transform: scale(0.8); opacity: 0; }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>

<body>

<!-- Floating Shapes -->
<div class="shape"></div>
<div class="shape"></div>
<div class="shape"></div>

<!-- Login Container -->
<div class="login-container">

    <!-- سهم العودة للرئيسية -->
    <a href="{{ route('home') }}" class="back-button">
        <i class="fas fa-arrow-right"></i>
        <span>العودة للرئيسية</span>
    </a>

    <!-- Logo -->
    <div class="logo">
        <div class="logo-icon">🏛️</div>
    </div>

    <!-- Heading -->
    <h2>مرحباً بك</h2>
    <p class="subtitle">سجل دخولك للوصول إلى لوحة التحكم</p>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <!-- Email Field -->
        <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <div class="input-container">
                <input 
                    type="email" 
                    id="email"
                    name="email" 
                    placeholder="example@domain.com"
                    value="{{ old('email') }}"
                    required 
                    autofocus
                >
                <span class="input-icon">📧</span>
            </div>
        </div>

        <!-- Password Field -->
        <div class="form-group">
            <label for="password">كلمة المرور</label>
            <div class="input-container">
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    placeholder="••••••••"
                    required
                >
                <span class="input-icon">🔒</span>
                <span class="password-toggle" onclick="togglePassword()">👁️</span>
            </div>
        </div>

        <!-- Remember & Forgot -->
        <div class="form-options">
            <label class="remember-me">
                <input type="checkbox" name="remember">
                <span>تذكرني</span>
            </label>
            <a href="#" class="forgot-link">نسيت كلمة المرور؟</a>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-login" id="loginBtn">
            <span>تسجيل الدخول</span>
        </button>

    </form>

    <!-- Register Link -->
    <div class="register-link">
        ليس لديك حساب؟ <a href="{{ route('register') }}">إنشاء حساب جديد</a>
    </div>

</div>

<script>
// Toggle Password Visibility
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggle = document.querySelector('.password-toggle');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggle.textContent = '🙈';
    } else {
        passwordInput.type = 'password';
        toggle.textContent = '👁️';
    }
}

// Form Submit Loading
document.getElementById('loginForm').addEventListener('submit', function() {
    const btn = document.getElementById('loginBtn');
    btn.classList.add('loading');
    btn.querySelector('span').textContent = 'جاري التحقق...';
});

// Add shake animation on error
const errorMessage = document.querySelector('.error-message');
if (errorMessage) {
    errorMessage.style.animation = 'shake 0.5s ease';
}
</script>

</body>
</html>