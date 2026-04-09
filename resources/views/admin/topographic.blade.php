@extends('admin.layout')

@section('content')
<div class="bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-bold mb-4">📌 طلبات استخراج الوثائق المسحية</h2>

    @if(count($topographic) > 0)
        <table class="w-full border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">اسم صاحب الطلب</th>
                    <th class="p-2 border">نوع الوثيقة</th>
                    <th class="p-2 border">العنوان</th>
                    <th class="p-2 border">التاريخ</th>
                </tr>
            </thead>

            <tbody>
                @foreach($topographic as $item)
                    <tr>
                        <td class="p-2 border">{{ $item->id }}</td>
                        <td class="p-2 border">{{ $item->user_name }}</td>
                        <td class="p-2 border">{{ $item->doc_type }}</td>
                        <td class="p-2 border">{{ $item->location }}</td>
                        <td class="p-2 border">{{ $item->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600">لا توجد طلبات استخراج وثائق مسحية.</p>
    @endif

</div>
@endsection
