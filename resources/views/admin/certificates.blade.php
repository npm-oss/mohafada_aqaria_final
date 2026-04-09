@extends('admin.layout')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-blue-700">📄 طلب الشهادة السلبية</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- طلب جديد -->
    <a href="{{ route('admin.certificates.new') }}"
       class="p-6 bg-white shadow-lg rounded-lg border border-gray-200 hover:bg-blue-50 transition">
        <h2 class="text-xl font-bold text-blue-700 mb-2">🆕 طلب جديد</h2>
        <p class="text-gray-600">إنشاء طلب شهادة سلبية جديد وملء المعلومات.</p>
    </a>

    <!-- إعادة استخراج -->
    <a href="{{ route('admin.certificates.reprint') }}"
       class="p-6 bg-white shadow-lg rounded-lg border border-gray-200 hover:bg-blue-50 transition">
        <h2 class="text-xl font-bold text-blue-700 mb-2">🔄 إعادة استخراج</h2>
        <p class="text-gray-600">إعادة تحميل أو طباعة شهادة سلبية سابقة.</p>
    </a>

</div>

@endsection
