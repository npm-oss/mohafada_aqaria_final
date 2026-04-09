@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('title', 'طلب شهادة سلبية جديدة')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Cairo', sans-serif;
    }

    :root {
        --primary: #1a5632;
        --primary-dark: #0d3d20;
        --secondary: #c49b63;
        --accent: #8b6f47;
        --bg-light: #f8f6f1;
        --text-dark: #2d2d2d;
        --text-light: #6b6b6b;
        --white: #ffffff;
        --success: #28a745;
        --error: #dc3545;
        --warning: #ffc107;
        --info: #17a2b8;
        --shadow: rgba(26, 86, 50, 0.1);
    }

    body {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        min-height: 100vh;
        padding: 2rem;
        direction: rtl;
        position: relative;
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
        background: radial-gradient(circle at 20% 50%, rgba(201, 160, 99, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
    }

    .extract-container {
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .extract-card {
        background: white;
        border-radius: 25px;
        box-shadow: 0 25px 70px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        animation: slideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Header */
    .card-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        padding: 2.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .card-header h3 {
        font-size: 2rem;
        font-weight: 900;
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        z-index: 2;
    }

    .close-btn {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        color: white;
        font-size: 1.3rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        position: relative;
        z-index: 2;
    }

    .close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg) scale(1.1);
    }

    .negative-form {
        padding: 3rem;
    }

    /* Alert Messages */
    .alert {
        padding: 1.2rem 1.8rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 600;
        animation: slideInRight 0.5s ease;
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(50px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        border: 3px solid #28a745;
    }

    .alert-error {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
        border: 3px solid #dc3545;
    }

    /* Info Notice */
    .info-notice {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        border-right: 5px solid #2196f3;
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 2.5rem;
        display: flex;
        align-items: start;
        gap: 1rem;
        animation: fadeIn 0.8s ease 0.3s backwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .info-notice .icon {
        font-size: 2rem;
        color: #2196f3;
    }

    .info-notice .content strong {
        display: block;
        margin-bottom: 0.5rem;
        color: #1565c0;
        font-size: 1.1rem;
    }

    .info-notice .content p {
        margin: 0;
        color: #0d47a1;
        line-height: 1.6;
    }

    /* Two Columns Layout */
    .two-columns {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2.5rem;
        margin-bottom: 2rem;
    }

    .info-card {
        background: var(--bg-light);
        border-radius: 18px;
        padding: 2.5rem;
        border: 3px solid rgba(26, 86, 50, 0.15);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.6s ease backwards;
    }

    .info-card:nth-child(1) { animation-delay: 0.5s; }
    .info-card:nth-child(2) { animation-delay: 0.7s; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .info-card:hover {
        border-color: var(--primary);
        box-shadow: 0 12px 35px var(--shadow);
        transform: translateY(-5px);
    }

    .info-card h2 {
        font-size: 1.5rem;
        color: var(--primary);
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid var(--secondary);
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 900;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 1.8rem;
        position: relative;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.7rem;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group label .required {
        color: var(--error);
        font-size: 1.3rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 1rem 1.3rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        background: white;
        font-family: 'Cairo', sans-serif;
    }

    .form-group input:hover,
    .form-group select:hover {
        border-color: var(--secondary);
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(26, 86, 50, 0.1);
        transform: translateY(-2px);
    }

    /* Submit Box */
    .submit-box {
        text-align: center;
        padding-top: 2.5rem;
        border-top: 3px solid rgba(26, 86, 50, 0.1);
        animation: fadeIn 1s ease 0.9s backwards;
    }

    .submit-box button {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 1.4rem 5rem;
        border: none;
        border-radius: 50px;
        font-size: 1.3rem;
        font-weight: 900;
        cursor: pointer;
        transition: all 0.4s ease;
        box-shadow: 0 10px 35px rgba(26, 86, 50, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }

    .submit-box button::before {
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

    .submit-box button:hover::before {
        width: 400px;
        height: 400px;
    }

    .submit-box button:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 45px rgba(26, 86, 50, 0.5);
    }

    .submit-box button:active {
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .two-columns {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        body {
            padding: 1rem;
        }

        .card-header {
            padding: 1.5rem;
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .card-header h3 {
            font-size: 1.5rem;
        }

        .negative-form {
            padding: 1.5rem;
        }

        .submit-box button {
            width: 100%;
            padding: 1.2rem 2rem;
        }
    }
</style>
@endpush

@section('content')

<div class="extract-container">

    <div class="extract-card">

        <!-- HEADER -->
        <div class="card-header">
            <h3>📝 طلب شهادة سلبية جديدة</h3>
            <a href="{{ url()->previous() }}" class="close-btn" title="إغلاق">✖</a>
        </div>

        {{-- عرض رسائل النجاح --}}
        @if(session('success'))
            <div class="alert alert-success">
                <span style="font-size: 1.5rem;">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- عرض رسائل الخطأ --}}
        @if($errors->any())
            <div class="alert alert-error">
                <span style="font-size: 1.5rem;">⚠</span>
                <div>
                    <strong>يرجى تصحيح الأخطاء التالية:</strong>
                    @foreach($errors->all() as $error)
                        <div style="margin-top: 0.5rem;">• {{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- فورم الطلب --}}
        <form 
            class="negative-form"
            method="POST"
            action="{{ route('negative.store') }}"
        >
            @csrf

            <!-- ملاحظة توضيحية -->
            <div class="info-notice">
                <div class="icon">ℹ️</div>
                <div class="content">
                    <strong>معلومات مهمة</strong>
                    <p>يرجى ملء جميع الحقول المطلوبة بدقة. ستتم معالجة طلبك في أقرب وقت ممكن.</p>
                </div>
            </div>

            <div class="two-columns">

                <!-- صاحب الملكية -->
                <div class="info-card">
                    <h2>
                        <span>📌</span>
                        <span>معلومات صاحب الملكية</span>
                    </h2>

                    <div class="form-group">
                        <label>
                            <span>اللقب</span>
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="owner_lastname" 
                            value="{{ old('owner_lastname') }}"
                            required
                            placeholder="أدخل اللقب"
                        >
                    </div>

                    <div class="form-group">
                        <label>
                            <span>الاسم</span>
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="owner_firstname"
                            value="{{ old('owner_firstname') }}"
                            required
                            placeholder="أدخل الاسم"
                        >
                    </div>

                    <div class="form-group">
                        <label>اسم الأب</label>
                        <input 
                            type="text" 
                            name="owner_father"
                            value="{{ old('owner_father') }}"
                            placeholder="أدخل اسم الأب (اختياري)"
                        >
                    </div>

                    <div class="form-group">
                        <label>تاريخ الميلاد</label>
                        <input 
                            type="date" 
                            name="owner_birthdate"
                            value="{{ old('owner_birthdate') }}"
                        >
                    </div>

                    <div class="form-group">
                        <label>مكان الميلاد</label>
                        <input 
                            type="text" 
                            name="owner_birthplace"
                            value="{{ old('owner_birthplace') }}"
                            placeholder="أدخل مكان الميلاد (اختياري)"
                        >
                    </div>
                </div>

                <!-- مقدم الطلب -->
                <div class="info-card">
                    <h2>
                        <span>👤</span>
                        <span>معلومات مقدم الطلب</span>
                    </h2>

                    <div class="form-group">
                        <label>
                            <span>اللقب</span>
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="applicant_lastname"
                            value="{{ old('applicant_lastname') }}"
                            required
                            placeholder="أدخل اللقب"
                        >
                    </div>

                    <div class="form-group">
                        <label>
                            <span>الاسم</span>
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="applicant_firstname"
                            value="{{ old('applicant_firstname') }}"
                            required
                            placeholder="أدخل الاسم"
                        >
                    </div>

                    <div class="form-group">
                        <label>اسم الأب</label>
                        <input 
                            type="text" 
                            name="applicant_father"
                            value="{{ old('applicant_father') }}"
                            placeholder="أدخل اسم الأب (اختياري)"
                        >
                    </div>

                    <div class="form-group">
                        <label>
                            <span>البريد الإلكتروني</span>
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="email"
                            value="{{ old('email') }}"
                            required
                            placeholder="example@email.com"
                        >
                    </div>

                    <div class="form-group">
                        <label>
                            <span>رقم الهاتف</span>
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="tel" 
                            name="phone"
                            value="{{ old('phone') }}"
                            required
                            placeholder="0XXX XX XX XX"
                            pattern="[0-9]{10}"
                        >
                    </div>
                </div>

            </div>

            <div class="submit-box">
                <button type="submit">
                    <span>📤</span>
                    <span>إرسال الطلب</span>
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
