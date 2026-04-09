@extends('admin.layout')

@section('title', 'إعدادات النظام')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap');
    
    * { font-family: 'Cairo', sans-serif; }

    .settings-wrapper {
        background: #f8f6f1;
        min-height: 100vh;
        padding: 2rem;
    }

    .settings-header {
        background: linear-gradient(135deg, #1a5632 0%, #2d7a4f 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 15px 50px rgba(26, 86, 50, 0.3);
        position: relative;
        overflow: hidden;
        animation: fadeInDown 0.6s ease;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .settings-header::before {
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

    .settings-header-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .settings-header h1 {
        font-size: 2.5rem;
        font-weight: 900;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 0;
    }

    .settings-tabs {
        background: white;
        border-radius: 15px;
        padding: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        animation: fadeInUp 0.6s ease 0.2s backwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .tab-btn {
        padding: 1rem 2rem;
        border: none;
        background: transparent;
        color: #7f8c8d;
        font-weight: 700;
        font-size: 1rem;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .tab-btn:hover {
        background: rgba(26, 86, 50, 0.05);
        color: #1a5632;
    }

    .tab-btn.active {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
        box-shadow: 0 5px 20px rgba(26, 86, 50, 0.3);
    }

    .settings-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        display: none;
    }

    .settings-card.active {
        display: block;
    }

    .settings-card h3 {
        font-size: 1.8rem;
        font-weight: 900;
        color: #1a5632;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 4px solid #c9a063;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        color: #2d2d2d;
        margin-bottom: 0.8rem;
        font-size: 1.05rem;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 1rem 1.2rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #1a5632;
        box-shadow: 0 0 0 4px rgba(26, 86, 50, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
        font-family: 'Cairo', sans-serif;
    }

    .form-group small {
        display: block;
        color: #7f8c8d;
        margin-top: 0.5rem;
        font-size: 0.9rem;
    }

    .btn-save {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
        color: white;
        padding: 1.3rem 3rem;
        border-radius: 15px;
        border: none;
        font-weight: 900;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        box-shadow: 0 10px 30px rgba(26, 86, 50, 0.3);
    }

    .btn-save:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(26, 86, 50, 0.4);
    }

    .switch-container {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #f8f6f1;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 70px;
        height: 38px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 38px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 30px;
        width: 30px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background: linear-gradient(135deg, #1a5632, #2d7a4f);
    }

    input:checked + .slider:before {
        transform: translateX(32px);
    }

    .switch-label {
        font-weight: 600;
        color: #2d2d2d;
        flex: 1;
    }

    .alert {
        padding: 1.2rem 1.8rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 3px solid;
    }

    .alert-success {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border-color: #28a745;
    }

    .alert-danger {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border-color: #dc3545;
    }

    .color-picker-group {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #f8f6f1;
        padding: 1rem;
        border-radius: 12px;
    }

    .color-picker {
        width: 80px;
        height: 80px;
        border: 4px solid white;
        border-radius: 15px;
        cursor: pointer;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }

    .color-value {
        font-family: monospace;
        font-size: 1.2rem;
        font-weight: 700;
        color: #2d2d2d;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .settings-tabs {
            flex-direction: column;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="settings-wrapper">
    
    <div class="settings-header">
        <div class="settings-header-content">
            <h1>
                <span>⚙️</span>
                <span>إعدادات النظام</span>
            </h1>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <span style="font-size: 2rem;">✅</span>
        <div>{{ session('success') }}</div>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        <span style="font-size: 2rem;">⚠️</span>
        <div>{{ session('error') }}</div>
    </div>
    @endif

    <div class="settings-tabs">
        <button class="tab-btn active" onclick="switchTab('general')">
            <span>🏛️</span>
            <span>عام</span>
        </button>
        <button class="tab-btn" onclick="switchTab('contact')">
            <span>📞</span>
            <span>الاتصال</span>
        </button>
        <button class="tab-btn" onclick="switchTab('system')">
            <span>🔧</span>
            <span>النظام</span>
        </button>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf

        <!-- General Settings -->
        <div class="settings-card active" id="general-tab">
            <h3>
                <span>🏛️</span>
                <span>الإعدادات العامة</span>
            </h3>

            <div class="form-row">
                <div class="form-group">
                    <label>اسم الموقع <span style="color: red;">*</span></label>
                    <input type="text" name="site_name" value="{{ old('site_name', setting('site_name', 'المحافظة العقارية - أولاد جلال')) }}" required>
                </div>

                <div class="form-group">
                    <label>رابط الموقع</label>
                    <input type="url" name="site_url" value="{{ old('site_url', setting('site_url', url('/'))) }}">
                </div>
            </div>

            <div class="form-group">
                <label>وصف الموقع</label>
                <textarea name="site_description">{{ old('site_description', setting('site_description', 'نظام متكامل لإدارة الأراضي والملكيات العقارية')) }}</textarea>
                <small>وصف مختصر يظهر في محركات البحث</small>
            </div>
        </div>

        <!-- Contact Settings -->
        <div class="settings-card" id="contact-tab">
            <h3>
                <span>📞</span>
                <span>معلومات الاتصال</span>
            </h3>

            <div class="form-row">
                <div class="form-group">
                    <label>البريد الإلكتروني <span style="color: red;">*</span></label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', setting('contact_email', 'info@conservation.dz')) }}" required>
                </div>

                <div class="form-group">
                    <label>رقم الهاتف <span style="color: red;">*</span></label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', setting('contact_phone', '+213 XXX XXX XXX')) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>العنوان الكامل <span style="color: red;">*</span></label>
                <input type="text" name="contact_address" value="{{ old('contact_address', setting('contact_address', 'أولاد جلال، الجزائر')) }}" required>
            </div>

            <div class="form-group">
                <label>ساعات العمل</label>
                <input type="text" name="working_hours" value="{{ old('working_hours', setting('working_hours', 'الأحد - الخميس: 8:00 - 16:00')) }}">
            </div>
        </div>

        <!-- System Settings -->
        <div class="settings-card" id="system-tab">
            <h3>
                <span>🔧</span>
                <span>إعدادات النظام</span>
            </h3>

            <div class="switch-container">
                <label class="switch">
                    <input type="checkbox" name="site_active" value="1" {{ old('site_active', setting('site_active', true)) ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
                <div class="switch-label">
                    <strong>حالة الموقع</strong>
                    <div style="font-size: 0.9rem; color: #7f8c8d;">تفعيل/إيقاف الموقع</div>
                </div>
            </div>

            <div class="switch-container">
                <label class="switch">
                    <input type="checkbox" name="maintenance_mode" value="1" {{ old('maintenance_mode', setting('maintenance_mode', false)) ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
                <div class="switch-label">
                    <strong>وضع الصيانة</strong>
                    <div style="font-size: 0.9rem; color: #7f8c8d;">عرض صفحة الصيانة</div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>اللون الأساسي</label>
                    <div class="color-picker-group">
                        <input type="color" name="primary_color" value="{{ old('primary_color', setting('primary_color', '#1a5632')) }}" class="color-picker" onchange="updateColorValue(this, 'primary')">
                        <div>
                            <div style="font-size: 0.9rem; color: #7f8c8d;">القيمة:</div>
                            <div class="color-value" id="primary-value">{{ setting('primary_color', '#1a5632') }}</div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>اللون الثانوي</label>
                    <div class="color-picker-group">
                        <input type="color" name="secondary_color" value="{{ old('secondary_color', setting('secondary_color', '#c9a063')) }}" class="color-picker" onchange="updateColorValue(this, 'secondary')">
                        <div>
                            <div style="font-size: 0.9rem; color: #7f8c8d;">القيمة:</div>
                            <div class="color-value" id="secondary-value">{{ setting('secondary_color', '#c9a063') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <button type="submit" class="btn-save">
                <span>💾</span>
                <span>حفظ جميع الإعدادات</span>
            </button>
        </div>

    </form>

</div>

<script>
function switchTab(tabName) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.closest('.tab-btn').classList.add('active');
    
    document.querySelectorAll('.settings-card').forEach(card => card.classList.remove('active'));
    document.getElementById(tabName + '-tab').classList.add('active');
}

function updateColorValue(input, type) {
    document.getElementById(type + '-value').textContent = input.value;
}
</script>

@endsection
