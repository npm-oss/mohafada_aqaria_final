@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('title', 'إعادة استخراج شهادة سلبية')

@push('styles')
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

    .negative-container {
        max-width: 900px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .negative-card {
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
        animation: rotate 15s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .card-header h2 {
        font-size: 2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        z-index: 2;
    }

    .close-btn {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
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
        background: rgba(255, 255, 255, 0.25);
        transform: rotate(90deg) scale(1.1);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding: 2.5rem;
    }

    /* Info Banner */
    .info-banner {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        border-right: 5px solid var(--info);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: start;
        gap: 1.2rem;
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

    .info-banner .icon {
        font-size: 2.5rem;
        color: var(--info);
        flex-shrink: 0;
    }

    .info-banner .content {
        flex: 1;
    }

    .info-banner .content h3 {
        font-size: 1.2rem;
        color: #0277bd;
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .info-banner .content p {
        margin: 0;
        color: #01579b;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .info-banner .content ul {
        margin: 0.8rem 0 0 1.5rem;
        color: #01579b;
    }

    .info-banner .content ul li {
        margin-bottom: 0.3rem;
    }

    /* Section Divider */
    .note {
        text-align: center;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary);
        margin: 2rem 0 2rem;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .note::before,
    .note::after {
        content: '';
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--secondary), transparent);
    }

    /* Form */
    form {
        animation: fadeIn 0.8s ease 0.4s backwards;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-group {
        animation: fadeIn 0.8s ease backwards;
    }

    .form-group:nth-child(1) { animation-delay: 0.5s; }
    .form-group:nth-child(2) { animation-delay: 0.6s; }
    .form-group:nth-child(3) { animation-delay: 0.7s; }
    .form-group:nth-child(4) { animation-delay: 0.8s; }

    .form-group label {
        display: block;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.6rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group label .icon {
        color: var(--primary);
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

    /* Search Options */
    .search-options {
        background: linear-gradient(135deg, #fff3e0, #ffe0b2);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 2px solid var(--secondary);
        animation: fadeIn 0.8s ease 0.9s backwards;
    }

    .search-options h4 {
        color: var(--accent);
        margin-bottom: 1rem;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .option-group {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .radio-option input[type="radio"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: var(--primary);
    }

    .radio-option label {
        cursor: pointer;
        font-weight: 500;
        color: var(--text-dark);
        margin: 0 !important;
    }

    /* Submit Box */
    .submit-box {
        text-align: center;
        padding-top: 2rem;
        border-top: 2px solid rgba(26, 86, 50, 0.1);
        animation: fadeIn 0.8s ease 1s backwards;
    }

    .submit-box button {
        background: linear-gradient(135deg, var(--info), #0277bd);
        color: white;
        padding: 1.3rem 4rem;
        border: none;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 30px rgba(23, 162, 184, 0.4);
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
        box-shadow: 0 15px 45px rgba(23, 162, 184, 0.5);
    }

    .submit-box button:active {
        transform: translateY(-2px) scale(1.02);
    }

    .submit-box button span {
        position: relative;
        z-index: 2;
    }

    /* Help Text */
    .help-text {
        text-align: center;
        margin-top: 1.5rem;
        color: var(--text-light);
        font-size: 0.95rem;
    }

    .help-text a {
        color: var(--info);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .help-text a:hover {
        color: var(--primary);
        text-decoration: underline;
    }

    /* Alert Messages */
    .alert {
        padding: 1.2rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
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

    /* Responsive */
    @media (max-width: 768px) {
        body {
            padding: 1rem;
        }

        .card-header {
            padding: 1.5rem 1rem;
        }

        .card-header h2 {
            font-size: 1.4rem;
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

        .option-group {
            flex-direction: column;
        }
    }

    /* Loading State */
    .loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .loading button::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        left: 20px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')

<div class="negative-container">

    <div class="negative-card">

        <!-- HEADER -->
        <div class="card-header">
            <h2>🔁 إعادة استخراج شهادة سلبية</h2>
            <a href="{{ url()->previous() }}" class="close-btn">✖</a>
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
                <div class="icon">ℹ️</div>
                <div class="content">
                    <h3>كيفية إعادة الاستخراج</h3>
                    <p>يمكنك البحث عن طلبك السابق باستخدام:</p>
                    <ul>
                        <li><strong>رقم الطلب</strong> - الطريقة الأسرع والأدق</li>
                        <li><strong>البيانات الشخصية</strong> - اللقب والاسم والبريد الإلكتروني</li>
                    </ul>
                </div>
            </div>

            <p class="note">──── معلومات البحث ────</p>

            <form method="POST" action="{{ route('negative.reprint.search') }}" id="reprintForm">
                @csrf

                <!-- Search Options -->
                <div class="search-options">
                    <h4>🔍 اختر طريقة البحث</h4>
                    <div class="option-group">
                        <div class="radio-option">
                            <input 
                                type="radio" 
                                id="searchByNumber" 
                                name="search_type" 
                                value="number"
                                checked
                                onchange="toggleSearchFields()"
                            >
                            <label for="searchByNumber">بواسطة رقم الطلب</label>
                        </div>
                        <div class="radio-option">
                            <input 
                                type="radio" 
                                id="searchByData" 
                                name="search_type" 
                                value="data"
                                onchange="toggleSearchFields()"
                            >
                            <label for="searchByData">بواسطة البيانات الشخصية</label>
                        </div>
                    </div>
                </div>

                <div class="form-grid">

                    <div class="form-group" id="requestNumberGroup">
                        <label>
                            <span class="icon">🔢</span>
                            رقم الطلب
                        </label>
                        <input 
                            type="text" 
                            name="request_number"
                            id="request_number"
                            placeholder="مثال: 2025/00123"
                            value="{{ old('request_number') }}"
                        >
                    </div>

                    <div class="form-group" id="lastnameGroup" style="display: none;">
                        <label>
                            <span class="icon">👤</span>
                            اللقب
                        </label>
                        <input 
                            type="text"
                            name="lastname"
                            id="lastname"
                            placeholder="أدخل اللقب"
                            value="{{ old('lastname') }}"
                        >
                    </div>

                    <div class="form-group" id="firstnameGroup" style="display: none;">
                        <label>
                            <span class="icon">✍️</span>
                            الاسم
                        </label>
                        <input 
                            type="text"
                            name="firstname"
                            id="firstname"
                            placeholder="أدخل الاسم"
                            value="{{ old('firstname') }}"
                        >
                    </div>

                    <div class="form-group" id="emailGroup" style="display: none;">
                        <label>
                            <span class="icon">✉️</span>
                            البريد الإلكتروني
                        </label>
                        <input 
                            type="email"
                            name="email"
                            id="email"
                            placeholder="example@email.com"
                            value="{{ old('email') }}"
                        >
                    </div>

                </div>

                <div class="submit-box">
                    <button type="submit">
                        <span>🔍 البحث عن الطلب</span>
                    </button>
                    <div class="help-text">
                        لم تجد طلبك؟ 
                        <a href="{{ route('contact') }}">تواصل معنا للمساعدة</a>
                    </div>
                </div>

            </form>

        </div>

    </div>

</div>

<script>
    function toggleSearchFields() {
        const searchByNumber = document.getElementById('searchByNumber').checked;
        
        // Request Number Field
        const requestNumberGroup = document.getElementById('requestNumberGroup');
        const requestNumber = document.getElementById('request_number');
        
        // Personal Data Fields
        const lastnameGroup = document.getElementById('lastnameGroup');
        const firstnameGroup = document.getElementById('firstnameGroup');
        const emailGroup = document.getElementById('emailGroup');
        
        const lastname = document.getElementById('lastname');
        const firstname = document.getElementById('firstname');
        const email = document.getElementById('email');
        
        if (searchByNumber) {
            // Show request number, hide others
            requestNumberGroup.style.display = 'block';
            lastnameGroup.style.display = 'none';
            firstnameGroup.style.display = 'none';
            emailGroup.style.display = 'none';
            
            // Set required
            requestNumber.setAttribute('required', 'required');
            lastname.removeAttribute('required');
            firstname.removeAttribute('required');
            email.removeAttribute('required');
            
            // Clear other fields
            lastname.value = '';
            firstname.value = '';
            email.value = '';
        } else {
            // Hide request number, show others
            requestNumberGroup.style.display = 'none';
            lastnameGroup.style.display = 'block';
            firstnameGroup.style.display = 'block';
            emailGroup.style.display = 'block';
            
            // Set required
            requestNumber.removeAttribute('required');
            lastname.setAttribute('required', 'required');
            firstname.setAttribute('required', 'required');
            email.setAttribute('required', 'required');
            
            // Clear request number
            requestNumber.value = '';
        }
    }
    
    // Form validation and loading state
    document.getElementById('reprintForm').addEventListener('submit', function(e) {
        const searchByNumber = document.getElementById('searchByNumber').checked;
        const requestNumber = document.getElementById('request_number').value.trim();
        const lastname = document.getElementById('lastname').value.trim();
        const firstname = document.getElementById('firstname').value.trim();
        const email = document.getElementById('email').value.trim();
        
        if (searchByNumber) {
            if (!requestNumber) {
                e.preventDefault();
                alert('يرجى إدخال رقم الطلب');
                return false;
            }
        } else {
            if (!lastname || !firstname || !email) {
                e.preventDefault();
                alert('يرجى ملء جميع الحقول المطلوبة');
                return false;
            }
        }
        
        // Add loading state
        this.classList.add('loading');
    });
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleSearchFields();
    });
</script>

@endsection