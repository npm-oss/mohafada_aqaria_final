@extends('admin.layout')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap');
    
    * {
        font-family: 'Cairo', sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, #1a5632 0%, #2d7a4f 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(26, 86, 50, 0.3);
    }

    .page-header h1 {
        font-size: 2rem;
        font-weight: 900;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 0;
    }

    .form-card {
        background: white;
        border-radius: 15px;
        padding: 2.5rem;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        color: #2d2d2d;
        margin-bottom: 0.6rem;
        font-size: 1.05rem;
    }

    .form-group label .required {
        color: #e74c3c;
        margin-right: 0.3rem;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.9rem 1.2rem;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #1a5632;
        box-shadow: 0 0 0 3px rgba(26, 86, 50, 0.1);
    }

    .form-group small {
        display: block;
        color: #7f8c8d;
        margin-top: 0.5rem;
        font-size: 0.9rem;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 2px solid #dc3545;
    }

    .btn {
        padding: 1rem 2.5rem;
        border-radius: 10px;
        border: none;
        font-weight: 900;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
        box-shadow: 0 8px 25px rgba(26, 86, 50, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(26, 86, 50, 0.4);
    }

    .btn-secondary {
        background: #95a5a6;
        color: white;
    }

    .btn-secondary:hover {
        background: #7f8c8d;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        justify-content: center;
    }
</style>

<div class="page-header">
    <h1>
        <span>👤</span>
        <span>إضافة مستخدم جديد</span>
    </h1>
</div>

<div class="form-card">
    
    @if($errors->any())
    <div class="alert alert-danger">
        <ul style="margin: 0; padding-right: 1.5rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="form-group">
            <label><span class="required">*</span> الاسم الكامل</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="form-group">
            <label><span class="required">*</span> البريد الإلكتروني</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label>رقم الهاتف</label>
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+213 XXX XXX XXX">
        </div>

        <div class="form-group">
            <label><span class="required">*</span> الصلاحية</label>
            <select name="role" required>
                <option value="">-- اختر الصلاحية --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مدير (Admin)</option>
                <option value="moderator" {{ old('role') == 'moderator' ? 'selected' : '' }}>مشرف (Moderator)</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>مستخدم عادي (User)</option>
            </select>
        </div>

        <div class="form-group">
            <label><span class="required">*</span> كلمة المرور</label>
            <input type="password" name="password" required>
            <small>يجب أن تكون 8 أحرف على الأقل</small>
        </div>

        <div class="form-group">
            <label><span class="required">*</span> تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <span>💾</span>
                <span>حفظ المستخدم</span>
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <span>❌</span>
                <span>إلغاء</span>
            </a>
        </div>
    </form>

</div>
@endsection