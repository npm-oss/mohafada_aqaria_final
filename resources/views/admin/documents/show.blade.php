@extends('admin.layout')

@section('content')
<style>
/* استيراد خط عربي احترافي */
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap');

* {
    font-family: 'Cairo', sans-serif;
}

/* ====== التخطيط العام ====== */
.details-layout {
    display: grid;
    grid-template-columns: 3fr 1fr;
    gap: 35px;
    max-width: 1400px;
    margin: 40px auto;
    padding: 25px;
    animation: fadeInUp 0.6s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* العمود الأيسر */
.left-column {
    display: flex;
    flex-direction: column;
}

/* الكارد الكبير */
.info-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
    border-radius: 25px;
    border: 2px solid rgba(59, 130, 246, 0.1);
    backdrop-filter: blur(15px);
    box-shadow: 0 20px 60px rgba(0,0,0,0.08);
    padding: 35px;
    transition: all 0.4s ease;
}

.info-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 70px rgba(0,0,0,0.15);
    border-color: rgba(59, 130, 246, 0.3);
}

/* العنوان الرئيسي */
.info-card h3 {
    background: linear-gradient(135deg, #1a5632, #2d7a4f, #3d9970);
    color: white;
    padding: 20px 25px;
    font-size: 20px;
    font-weight: 800;
    margin: -35px -35px 30px -35px;
    border-radius: 25px 25px 0 0;
    box-shadow: 0 4px 15px rgba(26, 86, 50, 0.2);
    letter-spacing: 0.5px;
}

/* شبكة عمودين */
.grid-2columns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

/* كل عمود */
.column {
    background: white;
    padding: 25px;
    border-radius: 18px;
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
}

.column:hover {
    border-color: #1a5632;
    box-shadow: 0 8px 25px rgba(26, 86, 50, 0.1);
    transform: translateY(-3px);
}

.column h4 {
    font-size: 17px;
    font-weight: 800;
    margin-bottom: 18px;
    color: #1a5632;
    border-bottom: 3px solid #c49b63;
    padding-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.column .grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
}

.column .grid .info-row {
    display: grid;
    grid-template-columns: 150px 1fr;
    gap: 12px;
    padding: 12px;
    border-radius: 10px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.column .grid .info-row:hover {
    background: #e8f5e9;
    transform: translateX(5px);
}

.column .grid .info-row .label {
    font-weight: 700;
    color: #1a5632;
    font-size: 14px;
}

.column .grid .info-row .value {
    font-weight: 600;
    color: #2c3e50;
    font-size: 15px;
}

/* معلومات العقار ممتدة */
.property-info {
    margin-top: 30px;
    background: white;
    padding: 25px;
    border-radius: 18px;
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
}

.property-info:hover {
    border-color: #1a5632;
    box-shadow: 0 8px 25px rgba(26, 86, 50, 0.1);
}

.property-info h4 {
    font-size: 17px;
    font-weight: 800;
    margin-bottom: 18px;
    color: #1a5632;
    border-bottom: 3px solid #c49b63;
    padding-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.property-info .grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
}

.property-info .grid .info-row {
    display: grid;
    grid-template-columns: 180px 1fr;
    gap: 12px;
    padding: 12px;
    border-radius: 10px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.property-info .grid .info-row:hover {
    background: #e8f5e9;
    transform: translateX(5px);
}

.property-info .grid .info-row .label {
    font-weight: 700;
    color: #1a5632;
    font-size: 14px;
}

.property-info .grid .info-row .value {
    font-weight: 600;
    color: #2c3e50;
    font-size: 15px;
}

/* الحالة */
.status {
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 800;
    text-align: center;
    font-size: 14px;
    text-transform: capitalize;
    display: inline-block;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

.status:hover {
    transform: scale(1.05);
}

.status.pending { 
    background: linear-gradient(135deg, #fbbf24, #f59e0b); 
    color: #78350f;
}

.status.approved { 
    background: linear-gradient(135deg, #10b981, #059669); 
    color: white;
}

.status.rejected { 
    background: linear-gradient(135deg, #ef4444, #dc2626); 
    color: white;
}

/* العمود الجانبي */
.right-column {
    position: sticky;
    top: 30px;
    height: fit-content;
}

/* كارد الأزرار */
.side-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
    border-radius: 25px;
    padding: 25px;
    display: flex;
    flex-direction: column;
    gap: 15px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    border: 2px solid rgba(59, 130, 246, 0.1);
}

/* عنوان كارد الأزرار */
.side-card h3 {
    font-size: 18px;
    font-weight: 800;
    color: #1a5632;
    border-bottom: 3px solid #c49b63;
    padding-bottom: 12px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* الأزرار */
.btn {
    width: 100%;
    padding: 16px 20px;
    border-radius: 16px;
    border: none;
    font-weight: 800;
    cursor: pointer;
    color: white;
    font-size: 15px;
    text-align: center;
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.blue { 
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.red { 
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.green { 
    background: linear-gradient(135deg, #10b981, #059669);
}

.gray { 
    background: linear-gradient(135deg, #6b7280, #4b5563);
}

.btn:hover { 
    transform: translateY(-3px) scale(1.02); 
    box-shadow: 0 12px 30px rgba(0,0,0,0.25); 
}

.btn:active {
    transform: translateY(-1px) scale(1.01);
}

/* Alert Messages */
.alert {
    padding: 18px 25px;
    border-radius: 15px;
    margin-bottom: 25px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 12px;
    animation: slideDown 0.4s ease;
    font-size: 15px;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success {
    background: rgba(40, 167, 69, 0.12);
    color: #28a745;
    border: 3px solid #28a745;
}

.alert-danger {
    background: rgba(220, 53, 69, 0.12);
    color: #dc3545;
    border: 3px solid #dc3545;
}

/* Responsive */
@media (max-width: 968px) {
    .details-layout {
        grid-template-columns: 1fr;
    }

    .grid-2columns {
        grid-template-columns: 1fr;
    }

    .right-column {
        position: static;
    }
}

@media (max-width: 640px) {
    .details-layout {
        padding: 15px;
    }

    .info-card {
        padding: 20px;
    }

    .info-card h3 {
        margin: -20px -20px 20px -20px;
        font-size: 18px;
    }

    .column .grid .info-row,
    .property-info .grid .info-row {
        grid-template-columns: 1fr;
        gap: 5px;
    }

    .column .grid .info-row .label,
    .property-info .grid .info-row .label {
        background: #e8f5e9;
        padding: 8px;
        border-radius: 8px;
    }
}
</style>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert alert-success" style="max-width: 1400px; margin: 20px auto;">
    ✓ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger" style="max-width: 1400px; margin: 20px auto;">
    ⚠ {{ session('error') }}
</div>
@endif

<div class="details-layout">

    <!-- الكارد الكبير لكل المعلومات -->
    <div class="left-column">

        <div class="info-card">
            <h3>📄 تفاصيل الطلب</h3>

            <div class="grid-2columns">
                <!-- العمود الأيسر: معلومات الطالب -->
                <div class="column">
                    <h4>👤 معلومات الطالب</h4>
                    <div class="grid">
                        <div class="info-row">
                            <div class="label">نوع البطاقة</div>
                            <div class="value">{{ $request->card_type ?? '-' }}</div>
                        </div>

                        @if($request->applicant_type == 'company')
                            <div class="info-row">
                                <div class="label">اسم المؤسسة</div>
                                <div class="value">{{ $request->applicant_lastname ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">ممثل المؤسسة</div>
                                <div class="value">{{ $request->applicant_firstname ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">الرقم الجبائي</div>
                                <div class="value">{{ $request->applicant_nin ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">الإيميل</div>
                                <div class="value">{{ $request->applicant_email ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">الهاتف</div>
                                <div class="value">{{ $request->applicant_phone ?? '-' }}</div>
                            </div>
                        @else
                            <div class="info-row">
                                <div class="label">الاسم</div>
                                <div class="value">{{ $request->applicant_lastname ?? '-' }} {{ $request->applicant_firstname ?? '' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">رقم التعريف</div>
                                <div class="value">{{ $request->applicant_nin ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">اسم الأب</div>
                                <div class="value">{{ $request->applicant_father ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">الإيميل</div>
                                <div class="value">{{ $request->applicant_email ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">الهاتف</div>
                                <div class="value">{{ $request->applicant_phone ?? '-' }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- العمود الأيمن: معلومات صاحب الملكية -->
                <div class="column">
                    <h4>🏠 معلومات صاحب الملكية</h4>
                    <div class="grid">
                        @if($request->owner_type == 'company')
                            <div class="info-row">
                                <div class="label">اسم المؤسسة</div>
                                <div class="value">{{ $request->owner_lastname ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">ممثل المؤسسة</div>
                                <div class="value">{{ $request->owner_firstname ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">الرقم الجبائي</div>
                                <div class="value">{{ $request->owner_nin ?? '-' }}</div>
                            </div>
                        @else
                            <div class="info-row">
                                <div class="label">الاسم</div>
                                <div class="value">{{ $request->owner_lastname ?? '-' }} {{ $request->owner_firstname ?? '' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">رقم التعريف</div>
                                <div class="value">{{ $request->owner_nin ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">اسم الأب</div>
                                <div class="value">{{ $request->owner_father ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">تاريخ الميلاد</div>
                                <div class="value">{{ $request->owner_birthdate ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="label">مكان الميلاد</div>
                                <div class="value">{{ $request->owner_birthplace ?? '-' }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- معلومات العقار ممتدة أسفل العمودين -->
            <div class="property-info">
                <h4>🏘️ معلومات العقار</h4>
                <div class="grid">
                    <div class="info-row">
                        <div class="label">الحالة</div>
                        <div class="value">{{ $request->property_status == 'surveyed' ? '✅ ممسوح' : '❌ غير ممسوح' }}</div>
                    </div>

                    @if($request->property_status == 'surveyed')
                        <div class="info-row">
                            <div class="label">القسم</div>
                            <div class="value">{{ $request->section ?? '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="label">البلدية</div>
                            <div class="value">{{ $request->municipality ?? '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="label">رقم المخطط</div>
                            <div class="value">{{ $request->plan_number ?? '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="label">رقم القطعة</div>
                            <div class="value">{{ $request->parcel_number ?? '-' }}</div>
                        </div>
                    @else
                        <div class="info-row">
                            <div class="label">البلدية</div>
                            <div class="value">{{ $request->municipality_ns ?? '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="label">رقم التجزئة</div>
                            <div class="value">{{ $request->subdivision_number ?? '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="label">رقم القطعة</div>
                            <div class="value">{{ $request->parcel_number_ns ?? '-' }}</div>
                        </div>
                    @endif

                    <div class="info-row">
                        <div class="label">حالة الطلب</div>
                        <div class="value">
                            <span class="status {{ $request->status ?? 'pending' }}">
                                @if($request->status == 'approved')
                                    ✅ موافق
                                @elseif($request->status == 'rejected')
                                    ❌ مرفوض
                                @else
                                    ⏳ قيد المعالجة
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="label">تاريخ الإيداع</div>
                        <div class="value">📅 {{ $request->created_at ? $request->created_at->format('Y/m/d H:i') : '-' }}</div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- العمود الجانبي للأزرار -->
    <div class="right-column">
        <div class="side-card">
            <h3>⚙️ الإجراءات</h3>

            <!-- معالجة -->
            <a href="{{ route('admin.documents.process', $request->id) }}" class="btn blue">
                <span>🔧</span>
                <span>معالجة</span>
            </a>

            <!-- موافقة -->
            @if($request->status == 'pending')
            <form method="POST" action="{{ route('admin.documents.approve', $request->id) }}" 
                  onsubmit="return confirm('هل أنت متأكد من الموافقة على هذا الطلب؟')" style="margin: 0;">
                @csrf
                <button type="submit" class="btn green">
                    <span>✅</span>
                    <span>موافقة</span>
                </button>
            </form>

            <!-- رفض -->
            <form method="POST" action="{{ route('admin.documents.reject', $request->id) }}" 
                  onsubmit="return confirm('هل أنت متأكد من رفض هذا الطلب؟')" style="margin: 0;">
                @csrf
                <button type="submit" class="btn red">
                    <span>❌</span>
                    <span>رفض</span>
                </button>
            </form>
            @endif

            <!-- رجوع -->
            <a href="{{ route('admin.documents.index') }}" class="btn gray">
                <span>←</span>
                <span>رجوع</span>
            </a>

            <!-- حذف -->
            <form method="POST" action="{{ route('admin.documents.destroy', $request->id) }}"
                  onsubmit="return confirm('هل أنت متأكد من الحذف؟')" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn red">
                    <span>🗑️</span>
                    <span>حذف</span>
                </button>
            </form>
        </div>
    </div>

</div>
@endsection