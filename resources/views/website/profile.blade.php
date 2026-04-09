<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حسابي - المحافظة العقارية</title>
    <!-- إضافة Font Awesome للأيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --primary: #1a5632;
            --primary-dark: #0d3d20;
            --secondary: #c49b63;
            --accent: #8b6f47;
            --danger: #dc3545;
            --danger-dark: #bd2130;
        }

        body {
            font-family: 'Tajawal', 'Segoe UI', 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            position: relative;
            overflow: hidden;
            padding: 1rem;
        }

        body::before {
            content: '';
            position: absolute;
            width: 200%; height: 200%;
            background:
                radial-gradient(circle at 20% 50%, rgba(196,155,99,0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(139,111,71,0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(255,255,255,0.05) 0%, transparent 40%);
            animation: moveBackground 20s ease-in-out infinite;
        }

        @keyframes moveBackground {
            0%,100% { transform: translate(0,0) rotate(0deg); }
            50%      { transform: translate(-50px,50px) rotate(5deg); }
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 15s ease-in-out infinite;
        }
        .shape:nth-child(1) {
            top: 10%; left: 20%;
            width: 80px; height: 80px;
            background: var(--secondary); border-radius: 50%;
            animation-delay: 0s;
        }
        .shape:nth-child(2) {
            top: 60%; right: 15%;
            width: 120px; height: 120px;
            background: var(--accent);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation-delay: 2s;
        }
        .shape:nth-child(3) {
            bottom: 20%; left: 10%;
            width: 100px; height: 100px;
            background: white;
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
            animation-delay: 4s;
        }

        @keyframes float {
            0%,100% { transform: translateY(0) rotate(0deg); }
            25%      { transform: translateY(-30px) rotate(90deg); }
            50%      { transform: translateY(-60px) rotate(180deg); }
            75%      { transform: translateY(-30px) rotate(270deg); }
        }

        .card {
            position: relative; z-index: 10;
            background: rgba(255,255,255,0.98);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.3), 0 0 0 1px rgba(255,255,255,0.2);
            width: 100%; max-width: 460px;
            padding: 2.5rem 2.5rem 2rem;
            animation: slideIn 0.8s cubic-bezier(0.4,0,0.2,1);
            text-align: center;
        }

        @keyframes slideIn {
            from { opacity:0; transform:translateY(50px) scale(0.9); }
            to   { opacity:1; transform:translateY(0) scale(1); }
        }

        /* سهم العودة للرئيسية */
        .back-button {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: var(--primary);
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: rgba(26, 86, 50, 0.1);
            border-radius: 50px;
            transition: all 0.3s ease;
            border: 1px solid rgba(26, 86, 50, 0.2);
        }

        .back-button i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .back-button:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 86, 50, 0.3);
        }

        .back-button:hover i {
            transform: translateX(-5px);
        }

        /* الأيقونة */
        .avatar {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.2rem;
            margin: 0 auto 1rem;
            box-shadow: 0 10px 30px rgba(26,86,50,0.3);
            position: relative;
        }
        .avatar::before {
            content: '';
            position: absolute; inset: -5px;
            border-radius: 50%;
            border: 3px solid var(--secondary);
            opacity: 0.5;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%,100% { transform:scale(1);   opacity:0.5; }
            50%      { transform:scale(1.1); opacity:0.8; }
        }

        h1 {
            color: var(--primary);
            font-size: 1.6rem; font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .subtitle { color: #888; font-size: 0.9rem; margin-bottom: 1rem; }

        .badge {
            background: #e8f5e9; color: var(--primary);
            padding: 0.4rem 1.2rem; border-radius: 20px;
            font-size: 0.88rem; font-weight: 700;
            display: inline-block; margin-bottom: 1.8rem;
            border: 1.5px solid rgba(26,86,50,0.2);
        }

        /* معلومات الحساب */
        .info-box {
            background: #f8f6f1;
            border-radius: 15px;
            padding: 0.5rem 1.2rem;
            margin-bottom: 1.8rem;
            text-align: right;
        }
        .info-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 0.8rem 0;
            border-bottom: 1px solid #eee;
            font-size: 0.92rem;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #999; font-size: 0.85rem; }
        .info-value { color: #333; font-weight: 700; }

        /* أزرار */
        .btn-logout, .btn-delete {
            width: 100%; padding: 1.1rem;
            border: none; border-radius: 15px;
            font-size: 1rem; font-weight: 700;
            font-family: inherit; cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
            position: relative; overflow: hidden;
            margin-bottom: 1rem;
        }

        .btn-logout {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 8px 25px rgba(26,86,50,0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, var(--danger), var(--danger-dark));
            color: white;
            box-shadow: 0 8px 25px rgba(220,53,69,0.3);
        }

        .btn-logout::before, .btn-delete::before {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            width: 0; height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            transform: translate(-50%,-50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-logout:hover::before, .btn-delete:hover::before { 
            width: 500px; height: 500px; 
        }

        .btn-logout:hover, .btn-delete:hover {
            transform: translateY(-3px);
        }

        .btn-logout:hover { box-shadow: 0 15px 40px rgba(26,86,50,0.4); }
        .btn-delete:hover { box-shadow: 0 15px 40px rgba(220,53,69,0.4); }

        .btn-logout span, .btn-delete span { position: relative; z-index: 2; }

        /* نافذة تأكيد الحذف */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.show {
            display: flex;
            opacity: 1;
        }

        .modal-box {
            background: white;
            border-radius: 30px;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            text-align: center;
            transform: scale(0.9);
            transition: transform 0.3s ease;
            box-shadow: 0 30px 60px rgba(0,0,0,0.3);
        }

        .modal-overlay.show .modal-box {
            transform: scale(1);
        }

        .modal-icon {
            width: 70px; height: 70px;
            background: rgba(220,53,69,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--danger);
            margin: 0 auto 1rem;
        }

        .modal-box h3 {
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .modal-box p {
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .modal-buttons {
            display: flex;
            gap: 1rem;
        }

        .modal-btn {
            flex: 1;
            padding: 1rem;
            border: none;
            border-radius: 15px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-btn.confirm {
            background: var(--danger);
            color: white;
        }

        .modal-btn.confirm:hover {
            background: var(--danger-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220,53,69,0.3);
        }

        .modal-btn.cancel {
            background: #f0f0f0;
            color: #333;
        }

        .modal-btn.cancel:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }

        .divider {
            margin: 1rem 0;
            border-top: 1px solid #eee;
            position: relative;
        }

        .divider span {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 0 10px;
            color: #999;
            font-size: 0.8rem;
        }

        @media (max-width: 576px) {
            .card { padding: 2rem 1.5rem; border-radius: 20px; }
            h1 { font-size: 1.4rem; }
            .back-button { 
                padding: 5px 10px; 
                font-size: 0.9rem;
            }
            .modal-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="shape"></div>
<div class="shape"></div>
<div class="shape"></div>

<!-- نافذة تأكيد الحذف -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3>تأكيد حذف الحساب</h3>
        <p>هل أنت متأكد من حذف حسابك؟ هذا الإجراء لا يمكن التراجع عنه وسيتم حذف جميع بياناتك نهائياً.</p>
        <div class="modal-buttons">
            <form method="POST" action="{{ route('profile.delete') }}" style="flex: 1;" id="deleteForm">
                @csrf
                @method('DELETE')
                <button type="submit" class="modal-btn confirm">
                    <i class="fas fa-trash"></i> نعم، احذف حسابي
                </button>
            </form>
            <button type="button" class="modal-btn cancel" onclick="closeModal()">
                <i class="fas fa-times"></i> إلغاء
            </button>
        </div>
    </div>
</div>

<div class="card">

    <!-- سهم العودة للرئيسية -->
    <a href="{{ route('home') }}" class="back-button">
        <i class="fas fa-arrow-right"></i>
        <span>العودة للرئيسية</span>
    </a>

    <div class="avatar">👤</div>

    <h1>مرحباً، {{ Auth::guard('website')->user()->name }}</h1>
    <p class="subtitle">أنت مسجل الدخول بنجاح</p>
    <span class="badge">✅ مستخدم نشط</span>

    <div class="info-box">
        <div class="info-row">
            <span class="info-value">{{ Auth::guard('website')->user()->name }}</span>
            <span class="info-label">الاسم</span>
        </div>
        <div class="info-row">
            <span class="info-value">{{ Auth::guard('website')->user()->email }}</span>
            <span class="info-label">البريد الإلكتروني</span>
        </div>
        <div class="info-row">
            <span class="info-value">{{ Auth::guard('website')->user()->created_at->format('Y/m/d') }}</span>
            <span class="info-label">تاريخ التسجيل</span>
        </div>
    </div>

    <!-- زر تسجيل الخروج -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">
            <span>🚪 تسجيل الخروج</span>
        </button>
    </form>

    <div class="divider">
        <span>أو</span>
    </div>

    <!-- زر حذف الحساب -->
    <button type="button" class="btn-delete" onclick="openModal()">
        <span>🗑️ حذف الحساب</span>
    </button>

</div>

<script>
    function openModal() {
        document.getElementById('deleteModal').classList.add('show');
    }

    function closeModal() {
        document.getElementById('deleteModal').classList.remove('show');
    }

    // إغلاق النافذة عند الضغط على ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    // إغلاق النافذة عند الضغط خارجها
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>

</body>
</html>