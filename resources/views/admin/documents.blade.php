@extends('admin.layout')

@section('content')

<div class="bg-white shadow-md rounded-lg p-6">

    <h2 class="text-2xl font-bold mb-4 text-gray-700">
        📄 طلبات البطاقات العقارية
    </h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($documents->isEmpty())
        <p class="text-gray-500">لا توجد أي طلبات حالياً.</p>
    @else

        <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="py-3 px-4 text-right">#</th>
                    <th class="py-3 px-4 text-right">اسم صاحب الطلب</th>
                    <th class="py-3 px-4 text-right">نوع الوثيقة</th>
                    <th class="py-3 px-4 text-right">رقم العقد</th>
                    <th class="py-3 px-4 text-right">تاريخ الطلب</th>
                </tr>
            </thead>

            <tbody>
                @foreach($documents as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $item->id }}</td>
                        <td class="py-3 px-4">{{ $item->username }}</td>
                        <td class="py-3 px-4">{{ $item->document_type }}</td>
                        <td class="py-3 px-4">{{ $item->contract_number }}</td>
                        <td class="py-3 px-4">{{ $item->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    @endif
</div>

@endsection
