@extends('admin.layout')

@section('content')
<div class="bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-bold mb-4">💳 طلبات الدفع الإلكتروني</h2>

    @if(session('success'))
        <div class="p-3 bg-green-200 text-green-800 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(count($payments) > 0)
        <table class="w-full border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">اسم المستخدم</th>
                    <th class="p-2 border">المبلغ</th>
                    <th class="p-2 border">الوثيقة</th>
                    <th class="p-2 border">التاريخ</th>
                </tr>
            </thead>

            <tbody>
                @foreach($payments as $pay)
                    <tr>
                        <td class="p-2 border">{{ $pay->id }}</td>
                        <td class="p-2 border">{{ $pay->user_name }}</td>
                        <td class="p-2 border">{{ $pay->amount }} دج</td>
                        <td class="p-2 border">{{ $pay->document_type }}</td>
                        <td class="p-2 border">{{ $pay->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600">لا توجد طلبات دفع لحد الآن.</p>
    @endif

</div>
@endsection
