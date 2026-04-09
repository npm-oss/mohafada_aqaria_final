<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    {{-- VITE مرة وحدة فقط --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .icon-box {
            width: 160px;
            height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 16px;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
        }
        .icon-box span {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .icon-box:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- أيقونات فقط -->
    <div class="flex justify-center gap-10 mt-20">

        <a href="{{ route('negative.new') }}"
           class="icon-box bg-blue-600 text-white hover:bg-blue-700">
            <span>➕</span>
            طلب جديد
        </a>

        <a href="{{ route('negative.reprint') }}"
           class="icon-box bg-green-600 text-white hover:bg-green-700">
            <span>🔁</span>
            إعادة استخراج
        </a>

    </div>

    <main class="mt-10 px-6">
        @yield('content')
    </main>

</body>
</html>

