@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('title', 'طلب بطاقة عقارية')

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

    .form-container {
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .page-header {
        text-align: center;
        margin-bottom: 2rem;
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
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .page-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
    }

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

    .document-form {
        background: white;
        border-radius: 25px;
        box-shadow: 0 25px 70px rgba(0, 0, 0, 0.3);
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

    .form-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        padding: 2rem;
        text-align: center;
        color: white;
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
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: rotate 15s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .form-header h2 {
        font-size: 2rem;
        position: relative;
        z-index: 2;
    }

    .form-body {
        padding: 2.5rem;
    }

    /* Card Type Display */
    .card-type-section {
        background: linear-gradient(135deg, #e8f5e9, #f1f8e9);
        border: 2px solid var(--primary);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: center;
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

    .card-type-label {
        font-size: 1rem;
        color: var(--text-light);
        margin-bottom: 0.5rem;
        display: block;
    }

    .card-type-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
    }

    /* Section Cards */
    .card-section {
        background: var(--bg-light);
        border-radius: 20px;
        margin-bottom: 2rem;
        overflow: hidden;
        border: 2px solid rgba(26, 86, 50, 0.1);
        transition: all 0.3s ease;
        animation: fadeIn 0.8s ease backwards;
    }

    .card-section:nth-child(1) { animation-delay: 0.3s; }
    .card-section:nth-child(2) { animation-delay: 0.4s; }
    .card-section:nth-child(3) { animation-delay: 0.5s; }

    .card-section:hover {
        border-color: var(--primary);
        box-shadow: 0 8px 25px var(--shadow);
    }

    .section-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 1.5rem 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .section-header h3 {
        font-size: 1.4rem;
        font-weight: 700;
        margin: 0;
    }

    .section-header .icon {
        font-size: 1.8rem;
    }

    .section-body {
        padding: 2rem;
    }

    /* Row Layout */
    .row-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    /* Radio Group */
    .radio-group {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding: 1.2rem;
        background: white;
        border-radius: 12px;
        border: 2px solid #e0e0e0;
    }

    .radio-label {
        display: flex;
        align-items: center;
        cursor: pointer;
        font-weight: 500;
        color: var(--text-dark);
        padding: 0.8rem 1.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        flex: 1;
        justify-content: center;
    }

    .radio-label:hover {
        background: rgba(26, 86, 50, 0.05);
    }

    .radio-label input[type="radio"] {
        display: none;
    }

    .radio-custom {
        display: inline-block;
        width: 24px;
        height: 24px;
        border: 3px solid #d0d0d0;
        border-radius: 50%;
        margin-left: 10px;
        position: relative;
        transition: all 0.3s ease;
    }

    .radio-label input:checked ~ .radio-custom {
        border-color: var(--primary);
        background: var(--primary);
        box-shadow: 0 0 0 3px rgba(26, 86, 50, 0.2);
    }

    .radio-label input:checked ~ .radio-custom::after {
        content: '✓';
        position: absolute;
        color: white;
        font-size: 14px;
        font-weight: bold;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .radio-label input:checked ~ span:not(.radio-custom) {
        color: var(--primary);
        font-weight: 700;
    }

    /* Fieldsets */
    fieldset {
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        padding: 2rem;
        margin: 0;
        background: white;
        transition: all 0.3s ease;
    }

    fieldset:hover {
        border-color: var(--primary);
    }

    legend {
        font-weight: 700;
        color: var(--primary);
        padding: 0.5rem 1rem;
        font-size: 1.1rem;
        background: var(--bg-light);
        border-radius: 8px;
        border: 2px solid var(--primary);
    }

    /* Input Fields */
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.6rem;
        font-size: 1rem;
    }

    input[type="text"],
    input[type="email"],
    input[type="date"],
    input[type="number"] {
        width: 100%;
        padding: 1rem 1.3rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
        font-family: inherit;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="date"]:focus,
    input[type="number"]:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(26, 86, 50, 0.1);
        transform: translateY(-2px);
    }

    input::placeholder {
        color: #aaa;
        font-style: italic;
    }

    /* Fields Container */
    .fields-container {
        display: none;
        animation: fadeInScale 0.5s ease;
    }

    .fields-container.active {
        display: block;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Submit Button */
    .submit-container {
        text-align: center;
        padding: 2rem 0;
        border-top: 2px solid rgba(26, 86, 50, 0.1);
        margin-top: 2rem;
    }

    .submit-btn {
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
    }

    .submit-btn::before {
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

    .submit-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .submit-btn:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 45px rgba(139, 111, 71, 0.5);
    }

    .submit-btn:active {
        transform: translateY(-2px) scale(1.02);
    }

    .submit-btn span {
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

    /* Responsive */
    @media (max-width: 1024px) {
        .row-container {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        body {
            padding: 1rem;
        }

        .page-header h1 {
            font-size: 1.8rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .section-body {
            padding: 1.5rem;
        }

        .radio-group {
            flex-direction: column;
            gap: 1rem;
        }

        .submit-btn {
            width: 100%;
            padding: 1.2rem 2rem;
        }

        .back-btn {
            top: 1rem;
            left: 1rem;
        }
    }

    /* Loading State */
    .loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .loading .submit-btn::after {
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
</style>

<a href="{{ url()->previous() }}" class="back-btn">←</a>

<div class="form-container">

    <div class="page-header">
        <h1>🏛️ طلب بطاقة عقارية</h1>
        <p>يرجى ملء جميع الحقول المطلوبة بدقة</p>
    </div>

    <div class="document-form">

        <div class="form-body">

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

            <form method="POST" action="{{ route('admin.documents.store') }}" id="documentForm">
                @csrf

                {{-- نوع البطاقة --}}
                <div class="card-type-section">
                    <span class="card-type-label">نوع البطاقة المطلوبة</span>
                    <div class="card-type-value">
                        <span>📄</span>
                        <span>{{ $cardType ?? 'البطاقة العقارية' }}</span>
                    </div>
                    <input type="hidden" name="card_type" value="{{ $cardType ?? 'natural' }}">
                </div>

                {{-- معلومات الطالب وصاحب الملكية --}}
                <div class="row-container">

                    {{-- معلومات الطالب --}}
                    <div class="card-section">
                        <div class="section-header">
                            <span class="icon">👤</span>
                            <h3>معلومات مقدم الطلب</h3>
                        </div>
                        <div class="section-body">
                            
                            {{-- اختيار نوع الطالب --}}
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="applicant_type" value="person" checked>
                                    <span class="radio-custom"></span>
                                    <span>👨 شخص</span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="applicant_type" value="company">
                                    <span class="radio-custom"></span>
                                    <span>🏢 مؤسسة</span>
                                </label>
                            </div>

                            {{-- حقول الطالب (شخص) --}}
                            <div id="applicantPersonFields" class="fields-container active">
                                <fieldset>
                                    <legend>معلومات الشخص</legend>
                                    <div class="form-group">
                                        <input type="text" name="applicant_nin" placeholder="رقم بطاقة التعريف الوطنية" value="{{ old('applicant_nin') }}" class="applicant-person-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="applicant_lastname" placeholder="اللقب *" value="{{ old('applicant_lastname') }}" required class="applicant-person-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="applicant_firstname" placeholder="الاسم *" value="{{ old('applicant_firstname') }}" required class="applicant-person-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="applicant_father" placeholder="اسم الأب" value="{{ old('applicant_father') }}" class="applicant-person-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="applicant_email" placeholder="البريد الإلكتروني *" value="{{ old('applicant_email') }}" required class="applicant-person-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="applicant_phone" placeholder="رقم الهاتف *" value="{{ old('applicant_phone') }}" required class="applicant-person-field">
                                    </div>
                                </fieldset>
                            </div>

                            {{-- حقول الطالب (مؤسسة) --}}
                            <div id="applicantCompanyFields" class="fields-container">
                                <fieldset>
                                    <legend>معلومات المؤسسة</legend>
                                    <div class="form-group">
                                        <input type="text" name="company_name" placeholder="اسم المؤسسة *" value="{{ old('company_name') }}" class="applicant-company-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="company_nin" placeholder="رقم التعريف الضريبي للمؤسسة" value="{{ old('company_nin') }}" class="applicant-company-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="company_representative" placeholder="ممثل المؤسسة *" value="{{ old('company_representative') }}" class="applicant-company-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="company_email" placeholder="البريد الإلكتروني للمؤسسة *" value="{{ old('company_email') }}" class="applicant-company-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="company_phone" placeholder="هاتف المؤسسة *" value="{{ old('company_phone') }}" class="applicant-company-field">
                                    </div>
                                </fieldset>
                            </div>

                        </div>
                    </div>

                    {{-- معلومات صاحب الملكية --}}
                    <div class="card-section">
                        <div class="section-header">
                            <span class="icon">🏠</span>
                            <h3>معلومات صاحب الملكية</h3>
                        </div>
                        <div class="section-body">
                            
                            {{-- اختيار نوع صاحب الملكية --}}
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="owner_type" value="person" checked>
                                    <span class="radio-custom"></span>
                                    <span>👨 شخص</span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="owner_type" value="company">
                                    <span class="radio-custom"></span>
                                    <span>🏢 مؤسسة</span>
                                </label>
                            </div>

                            {{-- حقول صاحب الملكية (شخص) --}}
                            <div id="ownerPersonFields" class="fields-container active">
                                <fieldset>
                                    <legend>معلومات الشخص</legend>
                                    <div class="form-group">
                                        <input type="text" name="owner_nin" placeholder="رقم التعريف الوطني" value="{{ old('owner_nin') }}" class="owner-person-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="owner_lastname" placeholder="اللقب *" value="{{ old('owner_lastname') }}" required class="owner-person-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="owner_firstname" placeholder="الاسم *" value="{{ old('owner_firstname') }}" required class="owner-person-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="owner_father" placeholder="اسم الأب" value="{{ old('owner_father') }}" class="owner-person-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="date" name="owner_birthdate" placeholder="تاريخ الميلاد" value="{{ old('owner_birthdate') }}" class="owner-person-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="owner_birthplace" placeholder="مكان الميلاد" value="{{ old('owner_birthplace') }}" class="owner-person-field">
                                    </div>
                                </fieldset>
                            </div>

                            {{-- حقول صاحب الملكية (مؤسسة) --}}
                            <div id="ownerCompanyFields" class="fields-container">
                                <fieldset>
                                    <legend>معلومات المؤسسة</legend>
                                    <div class="form-group">
                                        <input type="text" name="owner_company_name" placeholder="اسم المؤسسة *" value="{{ old('owner_company_name') }}" class="owner-company-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="owner_company_nin" placeholder="رقم التعريف الضريبي للمؤسسة" value="{{ old('owner_company_nin') }}" class="owner-company-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="owner_company_representative" placeholder="ممثل المؤسسة *" value="{{ old('owner_company_representative') }}" class="owner-company-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="owner_company_email" placeholder="البريد الإلكتروني للمؤسسة" value="{{ old('owner_company_email') }}" class="owner-company-field">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="owner_company_phone" placeholder="هاتف المؤسسة" value="{{ old('owner_company_phone') }}" class="owner-company-field">
                                    </div>
                                </fieldset>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- معلومات العقار --}}
                <div class="card-section">
                    <div class="section-header">
                        <span class="icon">📍</span>
                        <h3>معلومات العقار</h3>
                    </div>
                    <div class="section-body">
                        
                        {{-- حالة العقار --}}
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="property_status" value="surveyed" checked>
                                <span class="radio-custom"></span>
                                <span>✓ ممسوح</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="property_status" value="not_surveyed">
                                <span class="radio-custom"></span>
                                <span>✗ غير ممسوح</span>
                            </label>
                        </div>

                        {{-- حقول العقار الممسوح --}}
                        <div id="surveyedFields" class="fields-container active">
                            <fieldset>
                                <legend>معلومات العقار الممسوح</legend>
                                <div class="form-group">
                                    <input type="text" name="section" placeholder="القسم *" value="{{ old('section') }}" class="surveyed-field">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="municipality" placeholder="البلدية *" value="{{ old('municipality') }}" class="surveyed-field">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="plan_number" placeholder="رقم المخطط *" value="{{ old('plan_number') }}" class="surveyed-field">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="parcel_number" placeholder="رقم القطعة *" value="{{ old('parcel_number') }}" class="surveyed-field">
                                </div>
                            </fieldset>
                        </div>

                        {{-- حقول العقار غير الممسوح --}}
                        <div id="notSurveyedFields" class="fields-container">
                            <fieldset>
                                <legend>معلومات العقار غير الممسوح</legend>
                                <div class="form-group">
                                    <input type="text" name="municipality_ns" placeholder="البلدية *" value="{{ old('municipality_ns') }}" class="not-surveyed-field">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="subdivision_number" placeholder="رقم التجزئة *" value="{{ old('subdivision_number') }}" class="not-surveyed-field">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="parcel_number_ns" placeholder="رقم القطعة *" value="{{ old('parcel_number_ns') }}" class="not-surveyed-field">
                                </div>
                            </fieldset>
                        </div>

                    </div>
                </div>

                {{-- زر الإرسال --}}
                <div class="submit-container">
                    <button type="submit" class="submit-btn">
                        <span>📤 تقديم الطلب</span>
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Toggle Applicant Type
    const applicantTypeRadios = document.querySelectorAll('input[name="applicant_type"]');
    const applicantPersonFields = document.getElementById('applicantPersonFields');
    const applicantCompanyFields = document.getElementById('applicantCompanyFields');
    
    // Function to update required attributes for applicant fields
    function updateApplicantRequiredFields(type) {
        const personInputs = document.querySelectorAll('.applicant-person-field');
        const companyInputs = document.querySelectorAll('.applicant-company-field');
        
        if (type === 'person') {
            applicantPersonFields.classList.add('active');
            applicantCompanyFields.classList.remove('active');
            
            // Enable required for person fields that need it
            personInputs.forEach(input => {
                if (input.placeholder.includes('*')) {
                    input.setAttribute('required', 'required');
                }
            });
            
            // Disable required for company fields
            companyInputs.forEach(input => {
                input.removeAttribute('required');
            });
        } else {
            applicantPersonFields.classList.remove('active');
            applicantCompanyFields.classList.add('active');
            
            // Disable required for person fields
            personInputs.forEach(input => {
                input.removeAttribute('required');
            });
            
            // Enable required for company fields that need it
            companyInputs.forEach(input => {
                if (input.placeholder.includes('*')) {
                    input.setAttribute('required', 'required');
                }
            });
        }
    }
    
    applicantTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            updateApplicantRequiredFields(this.value);
        });
    });
    
    // Toggle Owner Type
    const ownerTypeRadios = document.querySelectorAll('input[name="owner_type"]');
    const ownerPersonFields = document.getElementById('ownerPersonFields');
    const ownerCompanyFields = document.getElementById('ownerCompanyFields');
    
    // Function to update required attributes for owner fields
    function updateOwnerRequiredFields(type) {
        const personInputs = document.querySelectorAll('.owner-person-field');
        const companyInputs = document.querySelectorAll('.owner-company-field');
        
        if (type === 'person') {
            ownerPersonFields.classList.add('active');
            ownerCompanyFields.classList.remove('active');
            
            // Enable required for person fields that need it
            personInputs.forEach(input => {
                if (input.placeholder.includes('*')) {
                    input.setAttribute('required', 'required');
                }
            });
            
            // Disable required for company fields
            companyInputs.forEach(input => {
                input.removeAttribute('required');
            });
        } else {
            ownerPersonFields.classList.remove('active');
            ownerCompanyFields.classList.add('active');
            
            // Disable required for person fields
            personInputs.forEach(input => {
                input.removeAttribute('required');
            });
            
            // Enable required for company fields that need it
            companyInputs.forEach(input => {
                if (input.placeholder.includes('*')) {
                    input.setAttribute('required', 'required');
                }
            });
        }
    }
    
    ownerTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            updateOwnerRequiredFields(this.value);
        });
    });
    
    // Toggle Property Status
    const propertyStatusRadios = document.querySelectorAll('input[name="property_status"]');
    const surveyedFields = document.getElementById('surveyedFields');
    const notSurveyedFields = document.getElementById('notSurveyedFields');
    
    // Function to update required attributes for property fields
    function updatePropertyRequiredFields(status) {
        const surveyedInputs = document.querySelectorAll('.surveyed-field');
        const notSurveyedInputs = document.querySelectorAll('.not-surveyed-field');
        
        if (status === 'surveyed') {
            surveyedFields.classList.add('active');
            notSurveyedFields.classList.remove('active');
            
            // Enable required for surveyed fields that need it
            surveyedInputs.forEach(input => {
                if (input.placeholder.includes('*')) {
                    input.setAttribute('required', 'required');
                }
            });
            
            // Disable required for not surveyed fields
            notSurveyedInputs.forEach(input => {
                input.removeAttribute('required');
            });
        } else {
            surveyedFields.classList.remove('active');
            notSurveyedFields.classList.add('active');
            
            // Disable required for surveyed fields
            surveyedInputs.forEach(input => {
                input.removeAttribute('required');
            });
            
            // Enable required for not surveyed fields that need it
            notSurveyedInputs.forEach(input => {
                if (input.placeholder.includes('*')) {
                    input.setAttribute('required', 'required');
                }
            });
        }
    }
    
    propertyStatusRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            updatePropertyRequiredFields(this.value);
        });
    });
    
    // Initialize required fields on page load
    updatePropertyRequiredFields('surveyed');
    
    // Form Submission with Loading State
    const form = document.getElementById('documentForm');
    form.addEventListener('submit', function(e) {
        // Add loading state
        form.classList.add('loading');
    });
    
});
</script>

@endsection