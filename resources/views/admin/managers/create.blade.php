@extends('admin.layout')

@section('title', 'إضافة مشرف جديد')

@section('content')
<style>
    .form-card {
        background: white; border-radius: 20px; padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08); max-width: 750px; margin: 0 auto;
    }
    .form-card h2 {
        font-size: 1.8rem; font-weight: 800; color: #1a5632;
        margin-bottom: 2rem; padding-bottom: 1rem;
        border-bottom: 3px solid #c49b63;
        display: flex; align-items: center; gap: 0.8rem;
    }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; font-weight: 700; color: #1a5632; margin-bottom: 0.6rem; }
    .form-input {
        width: 100%; padding: 1rem 1.2rem;
        border: 2px solid #e0e0e0; border-radius: 12px;
        font-size: 1rem; font-family: inherit;
        transition: all 0.3s ease; background: white;
    }
    .form-input:focus { outline: none; border-color: #1a5632; box-shadow: 0 0 0 4px rgba(26,86,50,0.1); }
    .error-text { color: #dc3545; font-size: 0.85rem; margin-top: 0.4rem; }
    .divider { border: none; border-top: 2px solid #f8f6f1; margin: 2rem 0; }
    .perms-section-title {
        font-weight: 700; color: #1a5632; margin-bottom: 0.5rem;
        font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;
    }
    .perms-hint { color: #6b7280; font-size: 0.9rem; margin-bottom: 1rem; }
    .permissions-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 1rem;
    }
    .perm-card {
        border: 2px solid #e0e0e0; border-radius: 12px; padding: 1rem 1.2rem;
        cursor: pointer; transition: all 0.3s ease;
        display: flex; align-items: center; gap: 0.8rem; user-select: none;
    }
    .perm-card:hover { border-color: #1a5632; background: rgba(26,86,50,0.03); }
    .perm-card.checked { border-color: #1a5632; background: rgba(26,86,50,0.08); }
    .perm-card input[type="checkbox"] {
        width: 18px; height: 18px; accent-color: #1a5632;
        cursor: pointer; flex-shrink: 0;
        pointer-events: none; /* ← مهم: يمنع التعارض */
    }
    .perm-label { font-weight: 600; color: #2d2d2d; font-size: 0.95rem; }
    .btn-select-all {
        padding: 0.5rem 1.2rem; background: rgba(26,86,50,0.1); color: #1a5632;
        border: 2px solid rgba(26,86,50,0.2); border-radius: 8px;
        font-size: 0.85rem; font-weight: 700; cursor: pointer;
        transition: all 0.3s ease; font-family: inherit; margin-bottom: 1rem;
    }
    .btn-select-all:hover { background: #1a5632; color: white; }
    .form-actions { display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; flex-wrap: wrap; }
    .btn-save {
        padding: 1rem 2.5rem; background: linear-gradient(135deg, #1a5632, #0d3d20);
        color: white; border: none; border-radius: 12px;
        font-size: 1rem; font-weight: 700; cursor: pointer;
        transition: all 0.3s ease; font-family: inherit;
        box-shadow: 0 5px 15px rgba(26,86,50,0.3);
    }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(26,86,50,0.4); }
    .btn-back {
        padding: 1rem 2rem; background: #f8f6f1; color: #2d2d2d;
        text-decoration: none; border-radius: 12px;
        font-size: 1rem; font-weight: 600; transition: all 0.3s ease;
        display: inline-flex; align-items: center; gap: 0.5rem;
    }
    .btn-back:hover { background: #e0e0e0; color: #2d2d2d; }
    .alert-error {
        background: rgba(220,53,69,0.1); border: 2px solid rgba(220,53,69,0.3);
        color: #dc3545; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;
    }
</style>

<div class="form-card">
    <h2>➕ إضافة مشرف جديد</h2>

    @if($errors->any())
    <div class="alert-error">
        @foreach($errors->all() as $error)
            <div>⚠️ {{ $error }}</div>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('admin.managers.store') }}">
        @csrf

        <div class="form-group">
            <label>👤 الاسم الكامل</label>
            <input type="text" name="name" class="form-input"
                   value="{{ old('name') }}" placeholder="اسم المشرف" required>
            @error('name')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>📧 البريد الإلكتروني</label>
            <input type="email" name="email" class="form-input"
                   value="{{ old('email') }}" placeholder="example@domain.com" required>
            @error('email')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>🔒 كلمة المرور</label>
            <input type="password" name="password" class="form-input"
                   placeholder="8 أحرف على الأقل" required>
            @error('password')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>🔒 تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" class="form-input"
                   placeholder="أعد كتابة كلمة المرور" required>
        </div>

        <hr class="divider">

        <div class="perms-section-title">🛡️ تحديد الصلاحيات</div>
        <p class="perms-hint">اختر الصفحات التي يمكن للمشرف الوصول إليها. إذا لم تختر شيئاً سيكون مديراً عاماً بكل الصلاحيات.</p>

        <button type="button" class="btn-select-all" id="selectAllBtn">
            ✅ تحديد الكل / إلغاء الكل
        </button>

        {{-- ← أزلنا onclick من الـ label --}}
        <div class="permissions-grid" id="permsGrid">
            @foreach($allPermissions as $key => $label)
            <label class="perm-card {{ in_array($key, old('permissions', [])) ? 'checked' : '' }}">
                <input type="checkbox" name="permissions[]" value="{{ $key }}"
                       {{ in_array($key, old('permissions', [])) ? 'checked' : '' }}>
                <span class="perm-label">{{ $label }}</span>
            </label>
            @endforeach
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.managers.index') }}" class="btn-back">← رجوع</a>
            <button type="submit" class="btn-save">💾 حفظ المشرف</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ✅ الضغط على الكارت يغير الـ checkbox
    document.querySelectorAll('#permsGrid .perm-card').forEach(function (card) {
        card.addEventListener('click', function () {
            const cb = this.querySelector('input[type="checkbox"]');
            cb.checked = !cb.checked;
            this.classList.toggle('checked', cb.checked);
        });
    });

    // ✅ تحديد الكل / إلغاء الكل
    document.getElementById('selectAllBtn').addEventListener('click', function () {
        const cbs   = document.querySelectorAll('#permsGrid input[type="checkbox"]');
        const cards = document.querySelectorAll('#permsGrid .perm-card');
        const allChecked = [...cbs].every(c => c.checked);
        cbs.forEach((cb, i) => {
            cb.checked = !allChecked;
            cards[i].classList.toggle('checked', !allChecked);
        });
    });

});
</script>

@endsection