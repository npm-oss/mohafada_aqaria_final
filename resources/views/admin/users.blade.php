@extends('admin.layout')

@section('content')

<h1 class="text-2xl font-bold mb-6">👤 إدارة المستخدمين</h1>

<table class="w-full bg-white rounded shadow">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3">ID</th>
            <th class="p-3">الاسم</th>
            <th class="p-3">البريد الإلكتروني</th>
            <th class="p-3">نوع المستخدم</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($users ?? [] as $user)
            <tr class="border-b">
                <td class="p-3">{{ $user->id }}</td>
                <td class="p-3">{{ $user->name }}</td>
                <td class="p-3">{{ $user->email }}</td>
                <td class="p-3">
                    @if($user->is_admin)
                        <span class="text-red-600 font-bold">أدمن</span>
                    @else
                        مستخدم عادي
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
