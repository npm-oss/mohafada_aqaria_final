<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>المحافظة العقارية</title>

    <!-- ربط ملف CSS -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>

<body>

    <!-- NAVBAR -->
   <nav class="navbar">
    <div class="logo">المحــافـظـة الـعقــارية</div>

    <ul class="nav-links">
        <li><a href="{{ url('/') }}">الرئيسية</a></li>

        <!-- شهادة سلبية -->
        <li>
            <a href="{{ route('negative.index') }}">
                شهادة سلبية
            </a>
        </li>

        <!-- 🔽 طلب نسخة من الوثائق العقارية -->
        <li class="dropdown">
            <a href="javascript:void(0)">
                📄 طلب نسخة من الوثائق العقارية ▾
            </a>

            <ul class="dropdown-menu">

                <!-- ▶ البطاقات العقارية -->
                <li class="dropdown-sub">
                    <a href="javascript:void(0)">
                        ▶ البطاقات الشخصية والابجدية
                    </a>

                    <ul class="dropdown-submenu">
                        <li><a href="{{ route('card.personal') }}">شخص طبيعي</a></li>
                        <li><a href="{{ route('card.alphabetical') }}"> شخص معنوي </a></li>
                        
                    </ul>
                </li>

                <!-- مستخرجات العقود -->
                <li>
                    <a href="{{ route('contracts.extracts') }}">
                        مستخرجات العقود
                    </a>
                </li>

            </ul>
        </li>

        <li><a href="{{ route('login') }}">تسجيل الدخول</a></li>
    </ul>
</nav>
