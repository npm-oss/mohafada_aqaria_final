@extends('admin.layout')

@section('content')

<h1 class="text-2xl font-bold mb-6">➕ إضافة بيانات</h1>

<form class="bg-white p-6 rounded shadow w-1/2">

    <label class="block mb-2 font-bold">العنوان</label>
    <input class="w-full border p-2 rounded mb-4" type="text">

    <label class="block mb-2 font-bold">الوصف</label>
    <textarea class="w-full border p-2 rounded mb-4"></textarea>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">حفظ</button>

</form>

@endsection
