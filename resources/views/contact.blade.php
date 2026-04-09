@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('title', 'اتصل بنا')

@section('content')

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
        --bg-light: #f8f6f1;
        --text-dark: #2d2d2d;
        --text-light: #6b6b6b;
    }

    body {
        font-family: 'Tajawal', 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        min-height: 100vh;
        padding: 2rem;
        direction: rtl;
        overflow-x: hidden;
    }

    /* Background Animation */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
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

    .contact-container {
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* Back Button - Enhanced Animation */
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

    /* Page Header - Text Animation */
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
        text-shadow: 0 0 30px rgba(255,255,255,0.3);
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

    /* Contact Layout - Stagger Animation */
    .contact-layout {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 2rem;
        perspective: 1000px;
    }

    /* Info Card - 3D Flip Entrance */
    .contact-info-card {
        background: white;
        border-radius: 25px;
        padding: 2.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        height: fit-content;
        animation: flipInLeft 1s ease-out 0.5s both;
        transform-style: preserve-3d;
        transition: transform 0.6s ease;
    }

    @keyframes flipInLeft {
        from { 
            opacity: 0; 
            transform: rotateY(-90deg) translateX(-100px); 
        }
        to { 
            opacity: 1; 
            transform: rotateY(0) translateX(0); 
        }
    }

    .contact-info-card:hover {
        transform: translateY(-10px) rotateX(5deg);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
    }

    .contact-info-card h3 {
        font-size: 1.8rem;
        color: var(--primary);
        margin-bottom: 2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideRight 0.8s ease-out 0.8s both;
    }

    @keyframes slideRight {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* Info Items - Bounce Animation */
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

    .info-item:nth-child(2) { animation-delay: 1s; }
    .info-item:nth-child(3) { animation-delay: 1.2s; }
    .info-item:nth-child(4) { animation-delay: 1.4s; }
    .info-item:nth-child(5) { animation-delay: 1.6s; }

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
        width: 60px;
        height: 60px;
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

    .info-item:hover .icon {
        animation: iconSpin 0.6s ease;
    }

    @keyframes iconSpin {
        from { transform: rotate(0deg) scale(1); }
        to { transform: rotate(360deg) scale(1.2); }
    }

    .info-item .content h4 {
        font-size: 1.2rem;
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

    .info-item .content a {
        color: var(--secondary);
        text-decoration: none;
        font-weight: 600;
        position: relative;
        transition: all 0.3s ease;
    }

    .info-item .content a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        right: 0;
        width: 0;
        height: 2px;
        background: var(--secondary);
        transition: width 0.3s ease;
    }

    .info-item .content a:hover::after {
        width: 100%;
    }

    /* Social Links - Wave Animation */
    .social-links {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid rgba(26, 86, 50, 0.1);
        justify-content: center;
    }

    .social-link {
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        animation: socialWave 2s ease-in-out infinite;
        box-shadow: 0 5px 20px rgba(26, 86, 50, 0.3);
    }

    .social-link:nth-child(1) { animation-delay: 0s; }
    .social-link:nth-child(2) { animation-delay: 0.2s; }
    .social-link:nth-child(3) { animation-delay: 0.4s; }
    .social-link:nth-child(4) { animation-delay: 0.6s; }

    @keyframes socialWave {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .social-link:hover {
        transform: translateY(-15px) scale(1.2) rotate(10deg);
        background: linear-gradient(135deg, var(--secondary), #8b6f47);
        box-shadow: 0 15px 40px rgba(196,155,99,0.5);
        animation: none;
    }

    /* Contact Card - Slide Up Animation */
    .contact-card {
        background: white;
        border-radius: 25px;
        box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
        overflow: hidden;
        animation: slideUp 1s ease-out 0.7s both;
        transform-style: preserve-3d;
    }

    @keyframes slideUp {
        from { 
            opacity: 0; 
            transform: translateY(100px) rotateX(20deg); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0) rotateX(0); 
        }
    }

    .contact-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        padding: 2.5rem 2rem;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .contact-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: headerShine 5s linear infinite;
    }

    @keyframes headerShine {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .contact-header h2 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
        animation: textPop 0.8s ease-out 1s both;
    }

    @keyframes textPop {
        0% { transform: scale(0); opacity: 0; }
        80% { transform: scale(1.1); }
        100% { transform: scale(1); opacity: 1; }
    }

    .contact-header p {
        position: relative;
        z-index: 1;
        opacity: 0.9;
    }

    .contact-form {
        padding: 2.5rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    /* Input Groups - Focus Animations */
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

    .input-group textarea {
        min-height: 150px;
        resize: vertical;
    }

    /* Submit Button - Enhanced Animation */
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
    }

    @keyframes btnPulse {
        0%, 100% { box-shadow: 0 5px 20px rgba(139, 111, 71, 0.4); }
        50% { box-shadow: 0 10px 40px rgba(139, 111, 71, 0.6), 0 0 60px rgba(196,155,99,0.3); }
    }

    .submit-box button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .submit-box button:hover {
        transform: translateY(-8px) scale(1.08);
        box-shadow: 0 20px 60px rgba(139, 111, 71, 0.6);
        animation: none;
    }

    .submit-box button:hover::before {
        left: 100%;
    }

    .submit-box button:active {
        transform: translateY(-3px) scale(1.02);
    }

    /* Alert Animations */
    .alert {
        padding: 1.2rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: alertSlide 0.6s ease-out both;
        position: relative;
        overflow: hidden;
    }

    @keyframes alertSlide {
        from { 
            opacity: 0; 
            transform: translateX(100px) rotate(5deg); 
        }
        to { 
            opacity: 1; 
            transform: translateX(0) rotate(0); 
        }
    }

    .alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        animation: alertBar 2s ease-in-out infinite;
    }

    @keyframes alertBar {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        border: 2px solid #b1dfbb;
    }

    .alert-success::before { background: #28a745; }

    .alert-error {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
        border: 2px solid #f1b0b7;
    }

    .alert-error::before { background: #dc3545; }

    /* Floating Particles */
    .particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
        z-index: 0;
    }

    .particle {
        position: absolute;
        width: 10px;
        height: 10px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        animation: floatParticle 15s infinite;
    }

    @keyframes floatParticle {
        0%, 100% { 
            transform: translateY(100vh) rotate(0deg); 
            opacity: 0; 
        }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { 
            transform: translateY(-100vh) rotate(720deg); 
            opacity: 0; 
        }
    }

    @media (max-width: 1024px) {
        .contact-layout {
            grid-template-columns: 1fr;
        }
        .page-header h1 { font-size: 2.5rem; }
    }

    @media (max-width: 768px) {
        body { padding: 1rem; }
        .page-header h1 { font-size: 2rem; }
        .form-row { grid-template-columns: 1fr; }
        .back-btn { width: 50px; height: 50px; font-size: 1.2rem; }
    }
</style>

<!-- Floating Particles -->
<div class="particles" id="particles"></div>

<a href="{{ url()->previous() }}" class="back-btn">←</a>

<div class="contact-container">

    <div class="page-header">
        <h1>📞 اتصل بنا</h1>
        <p>نحن هنا للإجابة عن جميع استفساراتكم</p>
    </div>

    <div class="contact-layout">

        <div class="contact-info-card">
            <h3>
                <span style="animation: iconPulse 2s infinite;">📍</span>
                <span>معلومات التواصل</span>
            </h3>

            <div class="info-item">
                <div class="icon">📍</div>
                <div class="content">
                    <h4>العنوان</h4>
                    <p>{{ setting('contact_address', 'المحافظة العقارية، أولاد جلال، الجزائر') }}</p>
                </div>
            </div>

            <div class="info-item">
                <div class="icon">📞</div>
                <div class="content">
                    <h4>الهاتف</h4>
                    <p><a href="tel:{{ setting('contact_phone', '+213 XXX XXX XXX') }}">{{ setting('contact_phone', '+213 XXX XXX XXX') }}</a></p>
                </div>
            </div>

            <div class="info-item">
                <div class="icon">✉️</div>
                <div class="content">
                    <h4>البريد الإلكتروني</h4>
                    <p><a href="mailto:{{ setting('contact_email', 'info@conservation.dz') }}">{{ setting('contact_email', 'info@conservation.dz') }}</a></p>
                </div>
            </div>

            <div class="info-item">
                <div class="icon">🕐</div>
                <div class="content">
                    <h4>أوقات العمل</h4>
                    <p>{{ setting('working_hours', 'الأحد - الخميس: 8:00 - 16:00') }}</p>
                </div>
            </div>

            <div class="social-links">
                @if(setting('social_facebook'))
                    <a href="{{ setting('social_facebook') }}" target="_blank" class="social-link">📘</a>
                @endif
                @if(setting('social_twitter'))
                    <a href="{{ setting('social_twitter') }}" target="_blank" class="social-link">🐦</a>
                @endif
                @if(setting('social_instagram'))
                    <a href="{{ setting('social_instagram') }}" target="_blank" class="social-link">📷</a>
                @endif
                @if(setting('social_linkedin'))
                    <a href="{{ setting('social_linkedin') }}" target="_blank" class="social-link">💼</a>
                @endif
            </div>
        </div>

        <div class="contact-card">

            <div class="contact-header">
                <h2>📝 أرسل لنا رسالة</h2>
                <p>املأ النموذج وسنتواصل معك قريباً</p>
            </div>

            <div class="contact-form">

                @if(session('success'))
                    <div class="alert alert-success">
                        <span style="font-size: 1.5rem; animation: bounce 1s infinite;">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <span style="font-size: 1.5rem; animation: shake 0.5s;">⚠</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <span style="font-size: 1.5rem; animation: shake 0.5s;">⚠</span>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf

                    <div class="form-row">
                        <div class="input-group">
                            <label>الاسم الكامل <span style="color: red;">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="أدخل اسمك الكامل">
                        </div>

                        <div class="input-group">
                            <label>البريد الإلكتروني <span style="color: red;">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="example@email.com">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group">
                            <label>رقم الهاتف</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="0XXX XX XX XX">
                        </div>

                        <div class="input-group">
                            <label>الموضوع <span style="color: red;">*</span></label>
                            <select name="subject" required>
                                <option value="">اختر الموضوع</option>
                                <option value="inquiry" {{ old('subject') == 'inquiry' ? 'selected' : '' }}>استفسار عام</option>
                                <option value="complaint" {{ old('subject') == 'complaint' ? 'selected' : '' }}>شكوى</option>
                                <option value="suggestion" {{ old('subject') == 'suggestion' ? 'selected' : '' }}>اقتراح</option>
                                <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>دعم فني</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>الرسالة <span style="color: red;">*</span></label>
                        <textarea name="message" required placeholder="اكتب رسالتك هنا...">{{ old('message') }}</textarea>
                    </div>

                    <div class="submit-box">
                        <button type="submit">
                            <span style="font-size: 1.5rem;">✉️</span>
                            <span>إرسال الرسالة</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
    // Generate floating particles
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

    // Add bounce animation dynamically
    const style = document.createElement('style');
    style.textContent = `
        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    `;
    document.head.appendChild(style);
</script>

@endsection