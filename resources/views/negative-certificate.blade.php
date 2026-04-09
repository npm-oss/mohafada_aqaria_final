@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/negative.css') }}">

<div class="negative-page">

    <!-- اللوغو -->
    <div class="logo">
        المحــافـظـة الـعقــارية
    </div>

    <!-- العنوان -->
    <h1 class="title">طلب الشهادة السلبية</h1>

    <!-- الوصف -->
    <p class="subtitle">
        هذه الصفحة مخصصة لتقديم طلب شهادة سلبية بطريقة إلكترونية مبسطة.
    </p>

    <!-- أزرار الخدمات -->
    <div class="actions">
        <a href="{{ route('negative.new') }}" class="btn primary">
            ➕ طلب شهادة جديدة
        </a>

        <a href="{{ route('negative.reprint') }}" class="btn secondary">
            🔁 إعادة استخراج شهادة
        </a>
    </div>

</div>
@endsection
