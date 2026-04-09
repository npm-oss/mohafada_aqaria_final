<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', config('app.name', 'المحافظة العقارية'))</title>
<head>
    <!-- CSS عام -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- CSS البطاقات (لازم يكون آخر واحد) -->
    @stack('styles')
</head>


<body class="bg-gray-100 font-sans">

    {{-- NAVBAR (يظهر فقط إذا ما طلبناش إخفاءه) --}}
    @if(!isset($hideNavbar) || $hideNavbar === false)
        @include('layouts.navigation')
    @endif

    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto mt-12 px-4">
        @yield('content')
    </main>

    {{-- ===== JavaScript DROPDOWN ===== --}}
    <script>
        // شهادة سلبية
        function toggleNegativeMenu() {
            const menu = document.getElementById('negativeMenu');
            if (!menu) return;
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        // استخراج الوثائق العقارية
        function toggleExtractMenu() {
            const menu = document.getElementById('extractMenu');
            if (!menu) return;

            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';

            const cards = document.getElementById('cardsMenu');
            if (cards) cards.style.display = 'none';
        }

        // submenu البطاقات
        function toggleCardsMenu(event) {
            event.stopPropagation();
            const menu = document.getElementById('cardsMenu');
            if (!menu) return;

            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        // غلق القوائم عند الضغط خارجها
        document.addEventListener('click', function (e) {
            const negative = document.getElementById('negativeMenu');
            const extract  = document.getElementById('extractMenu');

            if (negative && !e.target.closest('.negative-dropdown')) {
                negative.style.display = 'none';
            }

            if (extract && !e.target.closest('.extract-dropdown')) {
                extract.style.display = 'none';
            }
        });
    </script>

</body>
</html>
