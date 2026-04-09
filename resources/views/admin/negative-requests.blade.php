@extends('layouts.admin')

@section('title', 'طلبات الشهادات السلبية')

@section('content')

<div class="extract-container">
    <div class="extract-card">
        <div class="card-title">📝 قائمة طلبات الشهادات السلبية</div>

        <table>
            <thead>
                <tr>
                    <th>الاسم الكامل</th>
                    <th>البريد الإلكتروني</th>
                    <th>نوع الطلب</th>
                    <th>الحالة</th>
                    <th>التاريخ</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                {{-- هنا رح تجيب الطلبات من Controller --}}
                @forelse($requests ?? [] as $request)
                <tr>
                    <td>{{ $request->owner_firstname }} {{ $request->owner_lastname }}</td>
                    <td>{{ $request->email }}</td>
                    <td>{{ $request->type }}</td>
                    <td>{{ $request->status }}</td>
                    <td>{{ $request->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.certificates.show', $request->id) }}" class="btn btn-info">عرض</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">لا توجد طلبات</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
