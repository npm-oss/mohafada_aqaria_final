<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'طلب شهادة سلبية')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSS خاص بالصفحة --}}
    <link rel="stylesheet" href="{{ asset('css/negative-new.css') }}">
</head>
<body>

    <main class="page-wrapper">
        @yield('content')
    </main>

</body>
</html>
