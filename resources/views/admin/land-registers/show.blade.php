@extends('admin.layout')

@section('title', 'تفاصيل الطلب #' . $register->id)

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap');
    
    * {
        font-family: 'Cairo', sans-serif;
    }

    body {
        background: #f5f7fa;
    }

    .page-header {
        background: linear-gradient(135deg, #1a5632 0%, #0d3d20 50%, #1a5632 100%);
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
        position: relative;
        overflow: hidden;
        animation: slideInDown 0.6s ease;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(201, 160, 99, 0.1) 0%, transparent 70%);
        animation: rotate 25s linear infinite;
    }

    .page-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, transparent, #c9a063, transparent);
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% { opacity: 0.3; transform: translateX(-100%); }
        50% { opacity: 1; transform: translateX(100%); }
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes slideInDown {
        0% { opacity: 0; transform: translateY(-30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .header-left, .header-right {
        position: relative;
        z-index: 2;
    }

    .header-left h1 {
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        font-weight: 800;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .header-left h1 span:first-child {
        animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .header-left p {
        font-size: 0.95rem;
        opacity: 0.95;
    }

    .header-right {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.8rem 1.6rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        border: none;
        cursor: pointer;
        font-family: inherit;
        font-size: 0.9rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255,255,255,0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.5s, height 0.5s;
    }

    .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn:hover {
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .btn-back {
        background: linear-gradient(135deg, rgba(255,255,255,0.25), rgba(255,255,255,0.15));
        color: white;
        backdrop-filter: blur(10px);
    }

    .btn-process {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
        animation: glow 2s ease-in-out infinite;
    }

    @keyframes glow {
        0%, 100% { box-shadow: 0 5px 15px rgba(23, 162, 184, 0.4); }
        50% { box-shadow: 0 8px 25px rgba(23, 162, 184, 0.7); }
    }

    .details-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .details-card {
        background: white;
        padding: 2rem;
        border-radius: 18px;
        box-shadow: 0 6px 25px rgba(0,0,0,0.08);
        animation: fadeInUp 0.6s ease;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .details-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #1a5632, #c9a063, #1a5632);
        background-size: 200% 100%;
        animation: gradient 3s ease infinite;
    }

    @keyframes gradient {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .details-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(26, 86, 50, 0.15);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding-bottom: 1.2rem;
        border-bottom: 2px solid #f0f2f5;
        margin-bottom: 1.5rem;
    }

    .card-header span {
        font-size: 2rem;
        animation: rotate360 3s linear infinite;
    }

    @keyframes rotate360 {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .card-header h2 {
        font-size: 1.4rem;
        color: #1a5632;
        font-weight: 800;
        background: linear-gradient(135deg, #1a5632, #c9a063);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .info-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.3rem;
        margin-bottom: 1.3rem;
    }

    .info-item {
        padding: 1.2rem;
        background: linear-gradient(135deg, #f8f6f1 0%, #ffffff 100%);
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .info-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(201, 160, 99, 0.1), transparent);
        transition: left 0.5s;
    }

    .info-item:hover::before {
        left: 100%;
    }

    .info-item:hover {
        transform: translateX(-5px) scale(1.02);
        box-shadow: 0 6px 15px rgba(26, 86, 50, 0.12);
        border-color: #c9a063;
    }

    .info-label {
        font-size: 0.75rem;
        color: #666;
        margin-bottom: 0.5rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 700;
        color: #1a5632;
        word-break: break-word;
        line-height: 1.5;
    }

    .survey-info {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        padding: 1.5rem;
        border-radius: 16px;
        margin-top: 1.5rem;
        border: 3px solid #28a745;
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.15);
        position: relative;
        overflow: hidden;
    }

    .survey-info::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    .survey-info h4 {
        color: #1a5632;
        margin-bottom: 1.2rem;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-weight: 800;
        position: relative;
        z-index: 1;
    }

    .documents-card {
        background: white;
        padding: 2rem;
        border-radius: 18px;
        box-shadow: 0 6px 25px rgba(0,0,0,0.08);
        margin-top: 2rem;
        animation: fadeInUp 0.7s ease 0.2s backwards;
    }

    .documents-counter {
        background: linear-gradient(135deg, #e7f3ff 0%, #cfe9ff 100%);
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        border: 3px solid #2196f3;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(33, 150, 243, 0.2);
    }

    .documents-counter::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(33, 150, 243, 0.15) 0%, transparent 70%);
        animation: rotate 25s linear infinite;
    }

    .documents-counter > * {
        position: relative;
        z-index: 1;
    }

    .documents-counter .big-number {
        font-size: 3.5rem;
        font-weight: 900;
        color: #1976d2;
        margin-bottom: 0.5rem;
        animation: scaleUp 2s ease-in-out infinite;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    @keyframes scaleUp {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }

    .documents-counter .label {
        font-size: 1.1rem;
        color: #1565c0;
        font-weight: 700;
    }

    .documents-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .document-item {
        background: linear-gradient(135deg, #f8f6f1 0%, #ffffff 100%);
        padding: 1.8rem;
        border-radius: 16px;
        border: 2px solid transparent;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .document-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #1a5632, #c9a063, #1a5632);
        transform: scaleX(0);
        transition: transform 0.5s ease;
    }

    .document-item:hover::before {
        transform: scaleX(1);
    }

    .document-item:hover {
        border-color: #1a5632;
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 15px 40px rgba(26, 86, 50, 0.25);
    }

    .document-icon {
        font-size: 3rem;
        margin-bottom: 0.8rem;
        text-align: center;
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    .document-name {
        font-weight: 700;
        color: #1a5632;
        margin-bottom: 0.8rem;
        word-break: break-word;
        font-size: 0.9rem;
        min-height: 40px;
        line-height: 1.4;
    }

    .document-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.6rem;
        font-size: 0.8rem;
        color: #666;
        font-weight: 600;
    }

    .btn-download {
        width: 100%;
        padding: 0.9rem;
        background: linear-gradient(135deg, #1a5632, #2d7a4d);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(26, 86, 50, 0.3);
        position: relative;
        overflow: hidden;
        font-size: 0.85rem;
    }

    .btn-download::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255,255,255,0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.5s, height 0.5s;
    }

    .btn-download:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-download:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 18px rgba(26, 86, 50, 0.4);
    }

    .file-error {
        text-align: center;
        color: #dc3545;
        font-weight: 600;
        padding: 0.9rem;
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        border-radius: 10px;
        border: 2px solid #dc3545;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
        font-size: 0.85rem;
    }

    .empty-documents {
        text-align: center;
        padding: 3rem 1.5rem;
        color: #999;
    }

    .empty-documents .icon {
        font-size: 5rem;
        opacity: 0.2;
        margin-bottom: 1rem;
    }

    .empty-documents p {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .status-section {
        background: white;
        padding: 2rem;
        border-radius: 18px;
        box-shadow: 0 6px 25px rgba(0,0,0,0.08);
        animation: fadeInRight 0.7s ease;
    }

    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .current-status {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, #f8f6f1, #ffffff);
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }

    .current-status .badge {
        display: inline-block;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: 800;
        margin-top: 0.8rem;
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        animation: pulse 2.5s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .badge.pending {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        color: #ff9800;
    }

    .badge.processing {
        background: linear-gradient(135deg, #d1ecf1, #bee5eb);
        color: #17a2b8;
    }

    .badge.approved {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #28a745;
    }

    .badge.rejected {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #dc3545;
    }

    .status-form {
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8f6f1, #ffffff);
        border-radius: 16px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        margin-bottom: 0.6rem;
        color: #1a5632;
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 0.9rem;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 0.9rem;
        font-family: inherit;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .form-control:focus {
        outline: none;
        border-color: #1a5632;
        box-shadow: 0 0 0 3px rgba(26, 86, 50, 0.1);
        transform: scale(1.01);
    }

    .btn-submit {
        width: 100%;
        padding: 1.1rem;
        background: linear-gradient(135deg, #1a5632, #0d3d20);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.7rem;
        font-family: inherit;
        box-shadow: 0 6px 20px rgba(26, 86, 50, 0.25);
        position: relative;
        overflow: hidden;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255,255,255,0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.5s, height 0.5s;
    }

    .btn-submit:hover::before {
        width: 400px;
        height: 400px;
    }

    .btn-submit:hover {
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 10px 30px rgba(26, 86, 50, 0.4);
    }

    .alert {
        padding: 1.2rem 1.8rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideInDown 0.5s ease;
        font-size: 0.95rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        border-left: 5px solid #28a745;
        color: #155724;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.15);
    }

    .alert-warning {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        border-left: 5px solid #ffc107;
        color: #856404;
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.15);
    }

    .alert-error {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        border-left: 5px solid #dc3545;
        color: #721c24;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.15);
    }

    @media (max-width: 968px) {
        .details-grid {
            grid-template-columns: 1fr;
        }

        .info-row {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            text-align: center;
            padding: 1.5rem;
        }

        .header-right {
            width: 100%;
            justify-content: center;
        }

        .documents-grid {
            grid-template-columns: 1fr;
        }

        .header-left h1 {
            font-size: 1.4rem;
        }

        .documents-counter .big-number {
            font-size: 2.5rem;
        }

        .card-header h2 {
            font-size: 1.2rem;
        }

        .info-value {
            font-size: 0.9rem;
        }
    }
</style>

<div class="page-header">
    <div class="header-left">
        <h1>
            <span>📋</span>
            <span>تفاصيل الطلب #{{ $register->id }}</span>
        </h1>
        <p>
            نوع الطلب: 
            <strong>{{ $register->request_type == 'نسخة دفتر' ? '📋 نسخة دفتر عقاري' : '📝 طلب دفتر جديد' }}</strong>
        </p>
    </div>
    <div class="header-right">
        <a href="{{ route('admin.land.registers.index') }}" class="btn btn-back">
            <span>←</span>
            <span>رجوع</span>
        </a>
        
        @if($register->status == 'pending')
            @if($register->request_type == 'طلب جديد')
                <a href="{{ route('admin.land.registers.processView', $register->id) }}" class="btn btn-process">
                    <span>🤖</span>
                    <span>معالجة الطلب</span>
                </a>
            @elseif($register->request_type == 'نسخة دفتر')
                <a href="{{ route('admin.land.registers.processCopyView', $register->id) }}" class="btn btn-process">
                    <span>📋</span>
                    <span>معالجة طلب النسخة</span>
                </a>
            @endif
        @endif
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    <span style="font-size: 1.8rem;">✅</span>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning">
    <span style="font-size: 1.8rem;">⚠️</span>
    <span>{{ session('warning') }}</span>
</div>
@endif

@if(session('error'))
<div class="alert alert-error">
    <span style="font-size: 1.8rem;">❌</span>
    <span>{{ session('error') }}</span>
</div>
@endif

<div class="details-grid">
    <div>
        <!-- بيانات المتقدم -->
        <div class="details-card">
            <div class="card-header">
                <span>👤</span>
                <h2>بيانات المتقدم</h2>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <div class="info-label">رقم التعريف الوطني</div>
                    <div class="info-value">{{ $register->national_id }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">الاسم الكامل</div>
                    <div class="info-value">
                        @if($register->request_type == 'نسخة دفتر')
                            {{ $register->full_name ?? ($register->last_name . ' ' . $register->first_name) }}
                        @else
                            {{ $register->last_name . ' ' . $register->first_name }}
                        @endif
                    </div>
                </div>
            </div>

            @if($register->request_type == 'طلب جديد')
                @if($register->father_name)
                <div class="info-row">
                    <div class="info-item">
                        <div class="info-label">اسم الأب</div>
                        <div class="info-value">{{ $register->father_name }}</div>
                    </div>
                    @if($register->birth_date)
                    <div class="info-item">
                        <div class="info-label">تاريخ الميلاد</div>
                        <div class="info-value">{{ $register->birth_date }}</div>
                    </div>
                    @endif
                </div>
                @endif

                @if($register->applicant_type)
                <div class="info-item" style="grid-column: 1 / -1;">
                    <div class="info-label">صفة الطالب</div>
                    <div class="info-value">{{ $register->applicant_type }}</div>
                </div>
                @endif
            @endif

            <div class="info-row">
                <div class="info-item">
                    <div class="info-label">رقم الهاتف</div>
                    <div class="info-value">{{ $register->phone }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">البريد الإلكتروني</div>
                    <div class="info-value">{{ $register->email }}</div>
                </div>
            </div>

            @if($register->request_type == 'طلب جديد' && $register->wilaya)
            <div class="info-row">
                <div class="info-item">
                    <div class="info-label">الولاية</div>
                    <div class="info-value">{{ $register->wilaya }}</div>
                </div>
                @if($register->commune)
                <div class="info-item">
                    <div class="info-label">البلدية</div>
                    <div class="info-value">{{ $register->commune }}</div>
                </div>
                @endif
            </div>
            @endif

            <div class="info-row" style="margin-top: 1.5rem;">
                <div class="info-item">
                    <div class="info-label">تاريخ التقديم</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($register->created_at)->format('Y/m/d H:i') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">آخر تحديث</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($register->updated_at)->format('Y/m/d H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- معلومات العقار -->
        @if($register->request_type == 'نسخة دفتر')
            <div class="details-card" style="margin-top: 2rem;">
                <div class="card-header">
                    <span>🏛️</span>
                    <h2>معلومات طلب النسخة</h2>
                </div>

                <div class="info-row">
                    @if($register->section)
                    <div class="info-item">
                        <div class="info-label">القسم</div>
                        <div class="info-value">{{ $register->section }}</div>
                    </div>
                    @endif
                    
                    <div class="info-item">
                        <div class="info-label">رقم مجموعة الملكية</div>
                        <div class="info-value">{{ $register->property_group ?? 'غير محدد' }}</div>
                    </div>
                </div>

                <div class="info-row">
                    @if($register->register_number)
                    <div class="info-item">
                        <div class="info-label">رقم الدفتر العقاري</div>
                        <div class="info-value">{{ $register->register_number }}</div>
                    </div>
                    @endif
                    
                    @if($register->property_number)
                    <div class="info-item">
                        <div class="info-label">رقم العقار</div>
                        <div class="info-value">{{ $register->property_number }}</div>
                    </div>
                    @endif
                </div>

                @if($register->admin_notes && str_contains($register->admin_notes, 'سبب الطلب'))
                <div class="info-item" style="grid-column: 1 / -1; margin-top: 1.5rem;">
                    <div class="info-label">سبب طلب النسخة</div>
                    <div class="info-value" style="white-space: pre-wrap;">{{ $register->admin_notes }}</div>
                </div>
                @endif
            </div>

        @elseif($register->request_type == 'طلب جديد' && $register->survey_status)
            <div class="details-card" style="margin-top: 2rem;">
                <div class="card-header">
                    <span>🏠</span>
                    <h2>معلومات العقار</h2>
                </div>

                <div class="survey-info">
                    <h4>📏 حالة المسح: {{ $register->survey_status }}</h4>
                    
                    @if($register->survey_status === 'ممسوح')
                        <div class="info-row">
                            @if($register->surveyed_commune)
                            <div class="info-item">
                                <div class="info-label">البلدية</div>
                                <div class="info-value">{{ $register->surveyed_commune }}</div>
                            </div>
                            @endif
                            @if($register->section)
                            <div class="info-item">
                                <div class="info-label">القسم</div>
                                <div class="info-value">{{ $register->section }}</div>
                            </div>
                            @endif
                        </div>
                        <div class="info-row">
                            @if($register->parcel_number)
                            <div class="info-item">
                                <div class="info-label">رقم القطعة</div>
                                <div class="info-value">{{ $register->parcel_number }}</div>
                            </div>
                            @endif
                            @if($register->surveyed_area)
                            <div class="info-item">
                                <div class="info-label">المساحة</div>
                                <div class="info-value">{{ $register->surveyed_area }} م²</div>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="info-row">
                            @if($register->non_surveyed_commune)
                            <div class="info-item">
                                <div class="info-label">البلدية</div>
                                <div class="info-value">{{ $register->non_surveyed_commune }}</div>
                            </div>
                            @endif
                            @if($register->subdivision)
                            <div class="info-item">
                                <div class="info-label">التجزئة/التعاونية/الحي</div>
                                <div class="info-value">{{ $register->subdivision }}</div>
                            </div>
                            @endif
                        </div>

                        @if(!empty($register->non_surveyed_section) || !empty($register->non_surveyed_parcel_number))
                        <div class="info-row">
                            @if(!empty($register->non_surveyed_section))
                            <div class="info-item">
                                <div class="info-label">القسم</div>
                                <div class="info-value">{{ $register->non_surveyed_section }}</div>
                            </div>
                            @endif
                            
                            @if(!empty($register->non_surveyed_parcel_number))
                            <div class="info-item">
                                <div class="info-label">الرقم</div>
                                <div class="info-value">{{ $register->non_surveyed_parcel_number }}</div>
                            </div>
                            @endif
                        </div>
                        @endif

                        @if($register->non_surveyed_area)
                        <div class="info-item" style="margin-top: 1rem;">
                            <div class="info-label">المساحة</div>
                            <div class="info-value">{{ $register->non_surveyed_area }} م²</div>
                        </div>
                        @endif
                    @endif
                </div>

                <div class="info-row" style="margin-top: 2rem;">
                    @if($register->property_type)
                    <div class="info-item">
                        <div class="info-label">نوع العقار</div>
                        <div class="info-value">{{ $register->property_type }}</div>
                    </div>
                    @endif
                    @if($register->request_type)
                    <div class="info-item">
                        <div class="info-label">نوع الطلب</div>
                        <div class="info-value">{{ $register->request_type }}</div>
                    </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- الوثائق المرفقة -->
        @if($register->request_type == 'طلب جديد')
        <div class="documents-card">
            <div class="card-header">
                <span>📎</span>
                
                <h2>الوثائق المرفقة</h2>
            </div>

            @php
                $documentsArray = [];
                if (!empty($register->documents)) {
                    $decoded = json_decode($register->documents, true);
                    if (is_array($decoded)) {
                        $documentsArray = $decoded;
                    }
                }
                $documentsCount = count($documentsArray);
            @endphp

            <div class="documents-counter">
                <div class="big-number">{{ $documentsCount }}</div>
                <div class="label">
                    @if($documentsCount == 0) لم يتم رفع أي وثائق
                    @elseif($documentsCount == 1) وثيقة واحدة
                    @elseif($documentsCount == 2) وثيقتان
                    @else {{ $documentsCount }} وثائق @endif
                </div>
            </div>

            @if($documentsCount > 0)
                <div class="documents-grid">
                    @foreach($documentsArray as $index => $doc)
                        @php
                            $filePath = is_array($doc) ? ($doc['path'] ?? '') : $doc;
                            $fileName = is_array($doc) ? ($doc['original_name'] ?? 'وثيقة ' . ($index + 1)) : 'وثيقة ' . ($index + 1);
                            $fileSize = is_array($doc) ? ($doc['size'] ?? 0) : 0;
                            
                            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                            $icon = strtolower($extension) == 'pdf' ? '📄' : '🖼️';
                            
                            $fullStoragePath = storage_path('app/public/' . $filePath);
                            $fileExists = file_exists($fullStoragePath);
                        @endphp

                        <div class="document-item">
                            <div class="document-icon">{{ $icon }}</div>
                            <div class="document-name">{{ $fileName }}</div>
                            
                            @if($fileSize > 0)
                            <div class="document-meta">
                                📦 {{ number_format($fileSize / 1024, 2) }} KB
                            </div>
                            @endif
                            
                            @if($fileExists)
                                <a href="{{ route('document.view', ['path' => $filePath]) }}" target="_blank" class="btn-download">
                                    👁️ عرض الملف
                                </a>
                                
                                <a href="{{ route('document.view', ['path' => $filePath]) }}?download=1" download class="btn-download" style="margin-top: 8px; background: linear-gradient(135deg, #c9a063, #b8944f);">
                                    ⬇️ تحميل
                                </a>
                            @else
                                <div class="file-error">
                                    ❌ الملف غير موجود
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-documents">
                    <div class="icon">📭</div>
                    <p>لا توجد وثائق مرفقة</p>
                </div>
            @endif
        </div>
        @endif
    </div>

    <!-- حالة الطلب -->
    <div class="status-section">
        <div class="card-header">
            <span>⚙️</span>
            <h2>حالة الطلب</h2>
        </div>

        <div class="current-status">
            <div class="info-label">الحالة الحالية</div>
            <div class="badge {{ $register->status ?? 'pending' }}">
                @switch($register->status ?? 'pending')
                    @case('pending') ⏳ قيد الانتظار @break
                    @case('processing') 🔄 قيد المعالجة @break
                    @case('approved') ✅ مقبول @break
                    @case('rejected') ❌ مرفوض @break
                    @default ⏳ قيد الانتظار
                @endswitch
            </div>
        </div>

        @if(isset($register->admin_notes) && !empty($register->admin_notes) && !str_contains($register->admin_notes, 'سبب الطلب'))
        <div class="info-item" style="margin-bottom: 2rem;">
            <div class="info-label">ملاحظات الإدارة</div>
            <div class="info-value" style="white-space: pre-wrap;">{{ $register->admin_notes }}</div>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.land.registers.updateStatus', $register->id) }}" class="status-form">
            @csrf

            <div class="form-group">
                <label>تحديث الحالة</label>
                <select name="status" class="form-control" required>
                    <option value="pending" {{ ($register->status ?? 'pending') == 'pending' ? 'selected' : '' }}>⏳ قيد الانتظار</option>
                    <option value="processing" {{ ($register->status ?? '') == 'processing' ? 'selected' : '' }}>🔄 قيد المعالجة</option>
                    <option value="approved" {{ ($register->status ?? '') == 'approved' ? 'selected' : '' }}>✅ مقبول</option>
                    <option value="rejected" {{ ($register->status ?? '') == 'rejected' ? 'selected' : '' }}>❌ مرفوض</option>
                </select>
            </div>

            <div class="form-group">
                <label>ملاحظات الإدارة</label>
                <textarea name="admin_notes" class="form-control" rows="5">{{ !str_contains($register->admin_notes ?? '', 'سبب الطلب') ? $register->admin_notes : '' }}</textarea>
            </div>

            <button type="submit" class="btn-submit">💾 حفظ التحديثات</button>
        </form>
    </div>
</div>

@endsection