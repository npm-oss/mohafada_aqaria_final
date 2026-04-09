@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('title', 'مستخرجات العقود')

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
        --accent: #8b6f47;
        --bg-light: #f8f6f1;
        --text-dark: #2d2d2d;
        --text-light: #6b6b6b;
        --white: #ffffff;
        --success: #28a745;
        --info: #17a2b8;
        --warning: #ffc107;
        --error: #dc3545;
        --shadow: rgba(26, 86, 50, 0.1);
    }

    body {
        font-family: 'Tajawal', 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        min-height: 100vh;
        padding: 2rem;
        direction: rtl;
        position: relative;
        overflow-x: hidden;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 30%, rgba(196, 155, 99, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(139, 111, 71, 0.1) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
    }

    .extract-container {
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* Back Button */
    .back-btn {
        position: fixed;
        top: 2rem;
        left: 2rem;
        width: 50px;
        height: 50px;
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
        transition: all 0.3s ease;
        text-decoration: none;
        z-index: 1000;
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateX(5px);
    }

    /* Page Header */
    .page-header {
        text-align: center;
        margin-bottom: 3rem;
        animation: fadeInDown 0.6s ease;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-header h1 {
        color: white;
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .page-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.2rem;
    }

    /* Extract Types Navigation */
    .extract-types {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2.5rem;
        animation: fadeIn 0.8s ease 0.2s backwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .extract-types button {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 1.2rem 1.5rem;
        border-radius: 15px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        font-family: inherit;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        text-align: center;
    }

    .extract-types button .icon {
        font-size: 2rem;
    }

    .extract-types button::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.5s, height 0.5s;
    }

    .extract-types button:hover::before {
        width: 300px;
        height: 300px;
    }

    .extract-types button:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .extract-types button.active {
        background: var(--secondary);
        border-color: var(--secondary);
        color: var(--primary-dark);
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 12px 35px rgba(196, 155, 99, 0.5);
    }

    .extract-types button span {
        position: relative;
        z-index: 2;
    }

    /* Extract Card */
    .extract-card {
        background: white;
        border-radius: 25px;
        box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
        overflow: hidden;
        animation: slideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
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

    .card-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        padding: 2.5rem 2rem;
        text-align: center;
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
        animation: rotate 15s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .card-header h3 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .card-header .note {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.9);
        position: relative;
        z-index: 2;
        margin: 0;
    }

    .card-body {
        padding: 2.5rem;
    }

    /* Form Sections */
    .form-section {
        margin-bottom: 2.5rem;
        animation: fadeIn 0.8s ease 0.4s backwards;
    }

    .section-title {
        font-size: 1.5rem;
        color: var(--primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 700;
        padding-bottom: 1rem;
        border-bottom: 3px solid var(--secondary);
    }

    .section-title .icon {
        font-size: 1.8rem;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.6rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group label .required {
        color: var(--error);
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 1rem 1.3rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(26, 86, 50, 0.1);
        transform: translateY(-2px);
    }

    .form-group input::placeholder {
        color: #aaa;
        font-style: italic;
    }

    /* Document Box */
    .document-box {
        background: linear-gradient(135deg, #f0f7ff, #e3f2fd);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 2rem;
        border: 2px solid var(--info);
        animation: fadeIn 0.8s ease 0.5s backwards;
    }

    .document-header {
        background: linear-gradient(135deg, var(--info), #0277bd);
        color: white;
        padding: 1.5rem 2rem;
        font-size: 1.3rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .document-body {
        padding: 2rem;
    }

    .doc-field {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        border: 2px solid rgba(23, 162, 184, 0.2);
        transition: all 0.3s ease;
    }

    .doc-field:hover {
        border-color: var(--info);
        box-shadow: 0 5px 20px rgba(23, 162, 184, 0.15);
        transform: translateX(-5px);
    }

    .doc-field > span {
        font-size: 2rem;
        flex-shrink: 0;
    }

    .doc-field > div {
        flex: 1;
    }

    .doc-field label {
        display: block;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .doc-field input {
        width: 100%;
        padding: 0.9rem 1.2rem;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .doc-field input:focus {
        outline: none;
        border-color: var(--info);
        box-shadow: 0 0 0 3px rgba(23, 162, 184, 0.1);
    }

    /* Submit Box */
    .submit-box {
        text-align: center;
        padding-top: 2rem;
        border-top: 2px solid rgba(26, 86, 50, 0.1);
        animation: fadeIn 0.8s ease 0.6s backwards;
    }

    .submit-box button {
        background: linear-gradient(135deg, var(--secondary), var(--accent));
        color: white;
        border: none;
        padding: 1.3rem 4rem;
        font-size: 1.2rem;
        font-weight: 700;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 30px rgba(139, 111, 71, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        overflow: hidden;
        font-family: inherit;
    }

    .submit-box button::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .submit-box button:hover::before {
        width: 300px;
        height: 300px;
    }

    .submit-box button:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 45px rgba(139, 111, 71, 0.5);
    }

    .submit-box button:active {
        transform: translateY(-2px) scale(1.02);
    }

    .submit-box button span {
        position: relative;
        z-index: 2;
    }

    /* Alert Messages */
    .alert {
        padding: 1.2rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideIn 0.5s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 2px solid #c3e6cb;
        border-right: 5px solid var(--success);
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 2px solid #f5c6cb;
        border-right: 5px solid var(--error);
    }

    .alert-info {
        background: #d1ecf1;
        color: #0c5460;
        border: 2px solid #bee5eb;
        border-right: 5px solid var(--info);
    }

    /* Info Banner */
    .info-banner {
        background: linear-gradient(135deg, #fff3e0, #ffe0b2);
        border-right: 5px solid var(--warning);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: start;
        gap: 1.2rem;
        animation: fadeIn 0.8s ease 0.3s backwards;
    }

    .info-banner .icon {
        font-size: 2.5rem;
        color: var(--warning);
        flex-shrink: 0;
    }

    .info-banner .content h4 {
        font-size: 1.1rem;
        color: #e65100;
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .info-banner .content p {
        margin: 0;
        color: #e65100;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 768px) {
        body {
            padding: 1rem;
        }

        .page-header h1 {
            font-size: 2rem;
        }

        .extract-types {
            grid-template-columns: repeat(2, 1fr);
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .submit-box button {
            width: 100%;
            padding: 1.2rem 2rem;
        }

        .back-btn {
            top: 1rem;
            left: 1rem;
        }
    }

    @media (max-width: 480px) {
        .extract-types {
            grid-template-columns: 1fr;
        }
    }

    /* Loading State */
    .submit-box button.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .submit-box button.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        left: 30px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Validation Error */
    .input-error {
        border-color: var(--error) !important;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
    }

    .error-message {
        color: var(--error);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
</style>

<a href="{{ url()->previous() }}" class="back-btn">←</a>

<div class="extract-container">

    <!-- Page Header -->
    <div class="page-header">
        <h1>📋 مستخرجات العقود</h1>
        <p>اختر نوع المستخرج وأكمل البيانات المطلوبة</p>
    </div>

    <!-- Extract Types Navigation -->
    <div class="extract-types">
        <button type="button" class="active" data-type="حجز" data-value="حجز">
            <span class="icon">🔒</span>
            <span>حجز</span>
        </button>
        <button type="button" data-type="عقد بيع" data-value="بيع">
            <span class="icon">💰</span>
            <span>عقد بيع</span>
        </button>
        <button type="button" data-type="عقد هبة" data-value="هبة">
            <span class="icon">🎁</span>
            <span>عقد هبة</span>
        </button>
        <button type="button" data-type="رهن أو امتياز" data-value="رهن_او_امتياز">
            <span class="icon">🏦</span>
            <span>رهن أو امتياز</span>
        </button>
        <button type="button" data-type="تشطيب" data-value="تشطيب">
            <span class="icon">✂️</span>
            <span>تشطيب</span>
        </button>
        <button type="button" data-type="عريضة" data-value="عريضة">
            <span class="icon">📝</span>
            <span>عريضة</span>
        </button>
        <button type="button" data-type="وثيقة ناقلة للملكية" data-value="وثيقة_ناقلة_للملكية">
            <span class="icon">📜</span>
            <span>وثيقة ناقلة للملكية</span>
        </button>
    </div>

    <!-- Extract Card -->
    <div class="extract-card">

        <div class="card-header">
            <h3 id="cardTitle">📋 طلب مستخرج 🔒 حجز</h3>
            <p class="note">الحقول التي تحمل (<span style="color: #ffeb3b;">*</span>) إجبارية</p>
        </div>

        <div class="card-body">

            {{-- عرض رسائل النجاح أو الخطأ --}}
            @if(session('success'))
                <div class="alert alert-success">
                    <span style="font-size: 1.5rem;">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <span style="font-size: 1.5rem;">⚠</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <span style="font-size: 1.5rem;">⚠</span>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Info Banner -->
            <div class="info-banner">
                <div class="icon">💡</div>
                <div class="content">
                    <h4>نصائح هامة</h4>
                    <p>تأكد من إدخال جميع البيانات بدقة. يمكنك استخدام رقم المجلد ورقم النشر للبحث عن الوثيقة المطلوبة.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('contracts.extract.store') }}" id="extractForm" novalidate>
                @csrf

                <!-- Hidden field for extract type - Arabic values -->
                <input type="hidden" name="extract_type" id="extractType" value="حجز">

                <!-- معلومات الطالب -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="icon">👤</span>
                        <span>معلومات مقدم الطلب</span>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="applicant_nin">
                                رقم التعريف الوطني (NIN)
                            </label>
                            <input 
                                type="text" 
                                id="applicant_nin"
                                name="applicant_nin"
                                placeholder="أدخل رقم التعريف الوطني"
                                value="{{ old('applicant_nin') }}"
                                class="{{ $errors->has('applicant_nin') ? 'input-error' : '' }}"
                            >
                            @if($errors->has('applicant_nin'))
                                <span class="error-message">⚠ {{ $errors->first('applicant_nin') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="applicant_lastname">
                                اللقب <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="applicant_lastname"
                                name="applicant_lastname"
                                placeholder="أدخل اللقب"
                                value="{{ old('applicant_lastname') }}"
                                required
                                class="{{ $errors->has('applicant_lastname') ? 'input-error' : '' }}"
                            >
                            @if($errors->has('applicant_lastname'))
                                <span class="error-message">⚠ {{ $errors->first('applicant_lastname') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="applicant_firstname">
                                الاسم <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="applicant_firstname"
                                name="applicant_firstname"
                                placeholder="أدخل الاسم"
                                value="{{ old('applicant_firstname') }}"
                                required
                                class="{{ $errors->has('applicant_firstname') ? 'input-error' : '' }}"
                            >
                            @if($errors->has('applicant_firstname'))
                                <span class="error-message">⚠ {{ $errors->first('applicant_firstname') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="applicant_father">
                                اسم الأب <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="applicant_father"
                                name="applicant_father"
                                placeholder="أدخل اسم الأب"
                                value="{{ old('applicant_father') }}"
                                required
                                class="{{ $errors->has('applicant_father') ? 'input-error' : '' }}"
                            >
                            @if($errors->has('applicant_father'))
                                <span class="error-message">⚠ {{ $errors->first('applicant_father') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="applicant_email">
                                البريد الإلكتروني
                            </label>
                            <input 
                                type="email" 
                                id="applicant_email"
                                name="applicant_email"
                                placeholder="example@email.com"
                                value="{{ old('applicant_email') }}"
                                class="{{ $errors->has('applicant_email') ? 'input-error' : '' }}"
                            >
                            @if($errors->has('applicant_email'))
                                <span class="error-message">⚠ {{ $errors->first('applicant_email') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="applicant_phone">
                                رقم الهاتف
                            </label>
                            <input 
                                type="tel" 
                                id="applicant_phone"
                                name="applicant_phone"
                                placeholder="0XXX XX XX XX"
                                value="{{ old('applicant_phone') }}"
                                class="{{ $errors->has('applicant_phone') ? 'input-error' : '' }}"
                            >
                            @if($errors->has('applicant_phone'))
                                <span class="error-message">⚠ {{ $errors->first('applicant_phone') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- معلومات الوثيقة -->
                <div class="document-box">

                    <div class="document-header">
                        📄 معلومات الوثيقة العقارية
                    </div>

                    <div class="document-body">

                        <div class="doc-field">
                            <span>📘</span>
                            <div>
                                <label for="volume_number">رقم المجلد <span style="color: var(--error);">*</span></label>
                                <input 
                                    type="text" 
                                    id="volume_number"
                                    name="volume_number"
                                    placeholder="أدخل رقم المجلد"
                                    value="{{ old('volume_number') }}"
                                    required
                                    class="{{ $errors->has('volume_number') ? 'input-error' : '' }}"
                                >
                                @if($errors->has('volume_number'))
                                    <span class="error-message">⚠ {{ $errors->first('volume_number') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="doc-field">
                            <span>🔢</span>
                            <div>
                                <label for="publication_number">رقم النشر <span style="color: var(--error);">*</span></label>
                                <input 
                                    type="text" 
                                    id="publication_number"
                                    name="publication_number"
                                    placeholder="أدخل رقم النشر"
                                    value="{{ old('publication_number') }}"
                                    required
                                    class="{{ $errors->has('publication_number') ? 'input-error' : '' }}"
                                >
                                @if($errors->has('publication_number'))
                                    <span class="error-message">⚠ {{ $errors->first('publication_number') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="doc-field">
                            <span>📅</span>
                            <div>
                                <label for="publication_date">تاريخ النشر</label>
                                <input 
                                    type="date" 
                                    id="publication_date"
                                    name="publication_date"
                                    value="{{ old('publication_date') }}"
                                    class="{{ $errors->has('publication_date') ? 'input-error' : '' }}"
                                >
                                @if($errors->has('publication_date'))
                                    <span class="error-message">⚠ {{ $errors->first('publication_date') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>

                <!-- زر الإرسال -->
                <div class="submit-box">
                    <button type="submit" id="submitBtn">
                        <span>تقديم الطلب</span>
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const buttons = document.querySelectorAll('.extract-types button');
    const cardTitle = document.getElementById('cardTitle');
    const extractType = document.getElementById('extractType');
    const form = document.getElementById('extractForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Extract type icons
    const typeIcons = {
        'حجز': '🔒',
        'عقد بيع': '💰',
        'عقد هبة': '🎁',
        'رهن أو امتياز': '🏦',
        'تشطيب': '✂️',
        'عريضة': '📝',
        'وثيقة ناقلة للملكية': '📜'
    };
    
    // Switch between extract types
    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            buttons.forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get the type from data-type attribute
            const displayType = this.getAttribute('data-type');
            const icon = typeIcons[displayType] || '📋';
            const typeValue = this.getAttribute('data-value');
            
            // Update card title and hidden input
            cardTitle.textContent = '📋 طلب مستخرج ' + icon + ' ' + displayType;
            extractType.value = typeValue;
            
            console.log('Selected extract_type:', typeValue); // For debugging
        });
    });
    
    // Form submission
    form.addEventListener('submit', function(e) {
        // Basic validation
        const requiredFields = form.querySelectorAll('input[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('input-error');
                
                // Remove error class after 3 seconds
                setTimeout(() => {
                    field.classList.remove('input-error');
                }, 3000);
            } else {
                field.classList.remove('input-error');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('يرجى ملء جميع الحقول المطلوبة (الم marked بـ *)');
            return false;
        }
        
        // Log form data for debugging
        console.log('Form data to be submitted:', {
            extract_type: extractType.value,
            applicant_nin: document.getElementById('applicant_nin').value,
            applicant_lastname: document.getElementById('applicant_lastname').value,
            applicant_firstname: document.getElementById('applicant_firstname').value,
            applicant_father: document.getElementById('applicant_father').value,
            volume_number: document.getElementById('volume_number').value,
            publication_number: document.getElementById('publication_number').value
        });
        
        // Add loading state
        submitBtn.classList.add('loading');
        submitBtn.innerHTML = '<span></span><span>جاري الإرسال...</span>';
        
        // Form will submit normally
        return true;
    });
    
    // Remove error class on input
    form.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('input-error');
        });
    });
    
});
</script>

@endsection