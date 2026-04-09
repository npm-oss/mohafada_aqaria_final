@extends('admin.layout')

@section('title', 'تعديل المستخدم')

@section('content')
<style>
    .user-edit-page {
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-header {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
        padding: 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(26, 86, 50, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
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

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        font-size: 1rem;
        opacity: 0.9;
    }

    .back-btn {
        position: relative;
        z-index: 2;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        padding: 1rem 2rem;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 700;
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-btn:hover {
        background: white;
        color: #1a5632;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .form-container {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        max-width: 800px;
        margin: 0 auto;
    }

    .form-section {
        margin-bottom: 2.5rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a5632;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid #c49b63;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group {
        margin-bottom: 1.8rem;
    }

    .form-label {
        display: block;
        font-weight: 700;
        color: #1a5632;
        margin-bottom: 0.8rem;
        font-size: 1rem;
    }

    .required {
        color: #dc3545;
        margin-right: 0.2rem;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1.2rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: #1a5632;
        box-shadow: 0 0 0 4px rgba(26, 86, 50, 0.1);
        transform: translateY(-2px);
    }

    .form-input.error {
        border-color: #dc3545;
    }

    .form-input.error:focus {
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
    }

    .error-message {
        color: #dc3545;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-weight: 600;
    }

    .input-help {
        color: #6b7280;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        font-style: italic;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 1.2rem;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .checkbox-group:hover {
        border-color: #1a5632;
        background: linear-gradient(135deg, #e9ecef, #dee2e6);
    }

    .checkbox-input {
        width: 24px;
        height: 24px;
        cursor: pointer;
        accent-color: #1a5632;
    }

    .checkbox-label {
        font-weight: 600;
        color: #333;
        cursor: pointer;
        user-select: none;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 2px solid #f0f0f0;
    }

    .btn {
        padding: 1.2rem 2.5rem;
        border-radius: 15px;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
        flex: 1;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(26, 86, 50, 0.4);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6b7280, #9ca3af);
        color: white;
    }

    .btn-secondary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(108, 117, 125, 0.4);
    }

    .alert {
        padding: 1.2rem 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        animation: slideDown 0.5s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.15), rgba(40, 167, 69, 0.05));
        color: #28a745;
        border: 2px solid rgba(40, 167, 69, 0.3);
    }

    .alert-danger {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.15), rgba(220, 53, 69, 0.05));
        color: #dc3545;
        border: 2px solid rgba(220, 53, 69, 0.3);
    }

    .user-preview {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid #e0e0e0;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .preview-avatar {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #c49b63, #8b6f47);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        border: 3px solid white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    .preview-info {
        flex: 1;
    }

    .preview-name {
        font-size: 1.3rem;
        font-weight: 800;
        color: #1a5632;
        margin-bottom: 0.3rem;
    }

    .preview-email {
        color: #6b7280;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 2rem 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        .page-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }
</style>

<div class="user-edit-page">

    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">✏️ تعديل المستخدم</h1>
            <p class="page-subtitle">تحديث معلومات المستخدم في النظام</p>
        </div>
        <a href="{{ route('admin.users.show', $user->id) }}" class="back-btn">
            <span>←</span>
            <span>رجوع</span>
        </a>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert alert-success">
        <span style="font-size: 1.5rem;">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Error Alert -->
    @if($errors->any())
    <div class="alert alert-danger">
        <span style="font-size: 1.5rem;">⚠</span>
        <div>
            <strong>يوجد أخطاء في النموذج:</strong>
            <ul style="margin: 0.5rem 0 0 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Form Container -->
    <div class="form-container">

        <!-- User Preview -->
        <div class="user-preview">
            <div class="preview-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="preview-info">
                <div class="preview-name">{{ $user->name }}</div>
                <div class="preview-email">{{ $user->email }}</div>
            </div>
            <div style="background: {{ $user->is_admin ? 'linear-gradient(135deg, rgba(220, 53, 69, 0.15), rgba(220, 53, 69, 0.05))' : 'linear-gradient(135deg, rgba(23, 162, 184, 0.15), rgba(23, 162, 184, 0.05))' }}; color: {{ $user->is_admin ? '#dc3545' : '#17a2b8' }}; padding: 0.6rem 1.2rem; border-radius: 20px; font-weight: 700; border: 2px solid {{ $user->is_admin ? 'rgba(220, 53, 69, 0.3)' : 'rgba(23, 162, 184, 0.3)' }};">
                {{ $user->is_admin ? '👨‍💼 مدير' : '👤 مستخدم' }}
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Basic Info Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <span>ℹ️</span>
                    <span>المعلومات الأساسية</span>
                </h3>

                <!-- Name -->
                <div class="form-group">
                    <label class="form-label">
                        <span class="required">*</span>
                        الاسم الكامل:
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                        value="{{ old('name', $user->name) }}"
                        required
                        placeholder="أدخل الاسم الكامل">
                    @error('name')
                        <div class="error-message">
                            <span>⚠</span>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    <div class="input-help">الاسم الكامل للمستخدم كما سيظهر في النظام</div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">
                        <span class="required">*</span>
                        البريد الإلكتروني:
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                        value="{{ old('email', $user->email) }}"
                        required
                        placeholder="example@domain.com">
                    @error('email')
                        <div class="error-message">
                            <span>⚠</span>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    <div class="input-help">البريد الإلكتروني سيستخدم لتسجيل الدخول</div>
                </div>
            </div>

            <!-- Password Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <span>🔐</span>
                    <span>كلمة المرور (اختياري)</span>
                </h3>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label">كلمة المرور الجديدة:</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                        placeholder="اتركه فارغاً إذا لا تريد التغيير">
                    @error('password')
                        <div class="error-message">
                            <span>⚠</span>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    <div class="input-help">اترك الحقل فارغاً إذا لا تريد تغيير كلمة المرور</div>
                </div>

                <!-- Password Confirmation -->
                <div class="form-group">
                    <label class="form-label">تأكيد كلمة المرور:</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="form-input"
                        placeholder="أعد إدخال كلمة المرور الجديدة">
                    <div class="input-help">يجب أن تتطابق مع كلمة المرور الجديدة</div>
                </div>
            </div>

            <!-- Permissions Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <span>🔑</span>
                    <span>الصلاحيات</span>
                </h3>

                <!-- Is Admin -->
                <div class="form-group">
                    <label class="checkbox-group">
                        <input 
                            type="checkbox" 
                            name="is_admin" 
                            value="1"
                            class="checkbox-input"
                            {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                        <span class="checkbox-label">
                            👨‍💼 منح صلاحيات المدير للمستخدم
                        </span>
                    </label>
                    <div class="input-help" style="margin-right: 2.5rem;">
                        المدراء لديهم صلاحيات كاملة للوصول إلى لوحة التحكم
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <span>💾</span>
                    <span>حفظ التعديلات</span>
                </button>
                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary">
                    <span>✖</span>
                    <span>إلغاء</span>
                </a>
            </div>

        </form>

    </div>

</div>
@endsection
