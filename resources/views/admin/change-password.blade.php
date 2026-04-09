@extends('admin.layout')

@section('content')

<h1 class="text-2xl font-bold mb-6">🔐 تغيير كلمة المرور</h1>

<form class="w-1/2 bg-white p-6 rounded shadow">

    <label class="font-bold">كلمة المرور الحالية</label>
    <input class="w-full border p-2 rounded mb-4" type="password">

    <label class="font-bold">كلمة المرور الجديدة</label>
    <input class="w-full border p-2 rounded mb-4" type="password">

    <button class="bg-green-600 text-white px-4 py-2 rounded">تغيير</button>

</form>

@endsection
