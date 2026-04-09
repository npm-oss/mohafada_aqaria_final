@extends('admin.layout')

@section('title','نتائج البحث في الوثائق')

@section('content')

<style>
/* استيراد خط عربي احترافي */
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap');

* {
    font-family: 'Cairo', sans-serif;
}

body {
    background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%) !important;
    min-height: 100vh;
}

/* ====== الحاوية الرئيسية ====== */
.page-container {
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

/* ====== رأس الصفحة ====== */
.page-header {
    background: linear-gradient(135deg, #065f46 0%, #047857 50%, #059669 100%);
    padding: 35px;
    border-radius: 25px;
    margin-bottom: 35px;
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 15px 40px rgba(6, 95, 70, 0.4);
}

.page-title {
    font-size: 28px;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 15px;
}

.results-count {
    background: rgba(255,255,255,0.25);
    padding: 12px 25px;
    border-radius: 30px;
    font-weight: 700;
    font-size: 16px;
    backdrop-filter: blur(10px);
}

/* ====== شبكة البطاقات ====== */
.documents-grid {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

/* ====== بطاقة الوثيقة ====== */
.document-card {
    background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
    border-radius: 25px;
    border: 2px solid rgba(5, 150, 105, 0.2);
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    overflow: hidden;
    transition: all 0.4s ease;
    page-break-inside: avoid;
}

.document-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 30px 70px rgba(0,0,0,0.25);
    border-color: rgba(5, 150, 105, 0.4);
}

/* ====== رأس البطاقة ====== */
.card-header {
    background: linear-gradient(135deg, #065f46, #047857, #059669);
    color: white;
    padding: 20px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-id {
    font-weight: 800;
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.document-type-badge {
    background: rgba(255,255,255,0.95);
    color: #065f46;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 700;
    font-size: 14px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* ====== جسم البطاقة ====== */
.card-body {
    padding: 30px;
}

/* ====== تخطيط المعلومات والصور ====== */
.card-content {
    display: flex;
    flex-direction: column;
    gap: 35px;
}

/* ====== قسم المعلومات ====== */
.info-section {
    display: flex;
    flex-direction: column;
    gap: 20px;
    order: 1;
}

.section-title {
    font-size: 20px;
    font-weight: 800;
    color: #065f46;
    border-bottom: 3px solid #fbbf24;
    padding-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ====== شبكة المعلومات ====== */
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

@media (max-width: 640px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
}

.info-box {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    padding: 18px;
    border-radius: 12px;
    border: 2px solid #bbf7d0;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.info-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, #059669, #10b981);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.info-box:hover {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border-color: #059669;
    transform: translateX(5px);
}

.info-box:hover::before {
    opacity: 1;
}

.info-box.full-width {
    grid-column: 1 / -1;
}

.info-label {
    font-size: 13px;
    color: #047857;
    font-weight: 600;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.info-value {
    font-weight: 700;
    font-size: 16px;
    color: #064e3b;
}

/* ====== تنسيق التاريخ ====== */
.date-value {
    color: #059669;
    font-weight: 700;
    font-size: 15px;
}

/* ====== قسم الصور ====== */
.images-section {
    display: flex;
    flex-direction: column;
    gap: 20px;
    order: 2;
}

.images-title {
    font-size: 18px;
    font-weight: 800;
    color: #065f46;
    border-bottom: 3px solid #fbbf24;
    padding-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.images-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
}

@media (max-width: 968px) {
    .images-container {
        grid-template-columns: 1fr;
    }
}

.image-wrapper {
    position: relative;
}

.image-label {
    font-size: 15px;
    font-weight: 700;
    color: #065f46;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    padding: 10px 15px;
    border-radius: 10px;
    border-right: 4px solid #059669;
}

.document-image {
    width: 100%;
    height: auto;
    min-height: 350px;
    max-height: 450px;
    object-fit: contain;
    border-radius: 15px;
    cursor: pointer;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    transition: all 0.4s ease;
    border: 3px solid #bbf7d0;
    background: #f0fdf4;
}

.document-image:hover {
    transform: scale(1.02);
    border-color: #059669;
    box-shadow: 0 12px 35px rgba(0,0,0,0.25);
}

.no-image-box {
    height: 350px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-radius: 15px;
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    color: #059669;
    font-size: 16px;
    font-weight: 600;
    gap: 10px;
    border: 2px dashed #86efac;
}

/* ====== زر الطباعة في الأسفل ====== */
.print-button-container {
    display: flex;
    justify-content: center;
    margin-top: 40px;
    margin-bottom: 30px;
}

.print-btn {
    padding: 18px 50px;
    border-radius: 20px;
    border: none;
    font-weight: 700;
    cursor: pointer;
    color: white;
    font-size: 20px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 10px 30px rgba(6, 95, 70, 0.4);
    background: linear-gradient(135deg, #065f46, #047857);
}

.print-btn:hover { 
    transform: translateY(-3px) scale(1.05); 
    box-shadow: 0 15px 40px rgba(6, 95, 70, 0.6); 
}

/* ====== رسالة لا توجد نتائج ====== */
.no-results {
    text-align: center;
    padding: 80px 40px;
    background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
    border-radius: 25px;
    border: 2px dashed #86efac;
}

.no-results-icon {
    font-size: 80px;
    margin-bottom: 25px;
}

.no-results-text {
    font-size: 24px;
    font-weight: 700;
    color: #059669;
}

/* ====== Modal للصور ====== */
.image-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.95);
    justify-content: center;
    align-items: center;
    z-index: 9999;
    backdrop-filter: blur(10px);
}

.modal-image {
    max-width: 90%;
    max-height: 90%;
    border-radius: 15px;
    box-shadow: 0 25px 80px rgba(0,0,0,0.5);
}

.close-modal {
    position: absolute;
    top: 30px;
    right: 40px;
    color: white;
    font-size: 40px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.close-modal:hover {
    transform: scale(1.2);
    color: #10b981;
}

/* ====== Pagination ====== */
.pagination-wrapper {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}

.pagination-wrapper nav {
    background: white;
    padding: 15px 25px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

/* ====== أنماط الطباعة - الصور فقط ====== */
@media print {
    body {
        background: white !important;
        margin: 0;
        padding: 0;
    }
    
    /* إخفاء كل شيء ما عدا الصور */
    .page-header,
    .print-button-container,
    .pagination-wrapper,
    .info-section,
    .section-title,
    .info-grid,
    .images-title,
    .image-modal,
    .card-header {
        display: none !important;
    }
    
    .page-container {
        max-width: 100%;
        margin: 0;
        padding: 0;
    }
    
    .documents-grid {
        gap: 0;
    }
    
    .document-card {
        page-break-after: always;
        break-after: page;
        margin: 0;
        padding: 15px;
        border: none;
        box-shadow: none;
        background: white;
        border-radius: 0;
    }
    
    .card-body {
        padding: 0;
    }
    
    .card-content {
        display: block !important;
    }
    
    .images-section {
        width: 100%;
        display: block !important;
    }
    
    .images-container {
        display: flex !important;
        flex-direction: column;
        gap: 30px;
    }
    
    .image-wrapper {
        page-break-inside: avoid;
        break-inside: avoid;
        margin-bottom: 30px;
    }
    
    .image-label {
        font-size: 18px;
        font-weight: 800;
        color: #065f46 !important;
        background: #ecfdf5 !important;
        border-right: 5px solid #059669 !important;
        padding: 15px 20px;
        margin-bottom: 15px;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        page-break-inside: avoid;
        page-break-after: avoid;
        border-radius: 8px;
    }
    
    .document-image {
        width: 100% !important;
        height: auto !important;
        max-height: 95vh !important;
        min-height: auto !important;
        object-fit: contain;
        border: 3px solid #065f46 !important;
        border-radius: 8px;
        box-shadow: none;
        background: white;
        page-break-inside: avoid;
        page-break-after: avoid;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    .no-image-box {
        display: none !important;
    }
    
    /* تأكد من طباعة كل صورة في صفحة منفصلة */
    .image-wrapper:not(:last-child) {
        page-break-after: always;
        break-after: page;
    }
}
</style>

<div class="page-container">

    <!-- رأس الصفحة -->
    <div class="page-header">
        <h2 class="page-title">
            <span>📋</span>
            <span>نتائج البحث في الوثائق</span>
        </h2>
        <span class="results-count">{{ $documents->total() }} وثيقة</span>
    </div>

    @if($documents->count())

        <div class="documents-grid" id="documents-container">

            @foreach($documents as $document)

                <div class="document-card" data-id="{{ $document->id }}">

                    <!-- رأس البطاقة -->
                    <div class="card-header">
                        <span class="card-id">
                            <span>🆔</span>
                            <span>#{{ $document->id }}</span>
                        </span>

                        <span class="document-type-badge">
                            {{ $document->document_type ?? 'غير محدد' }}
                        </span>
                    </div>

                    <!-- جسم البطاقة -->
                    <div class="card-body">

                        <div class="card-content">

                            <!-- قسم المعلومات -->
                            <div class="info-section">

                                <div class="section-title">👤 معلومات الشخص</div>

                                <div class="info-grid">

                                    <div class="info-box">
                                        <div class="info-label">📝 اللقب</div>
                                        <div class="info-value">{{ $document->person_lastname ?? 'غير متوفر' }}</div>
                                    </div>

                                    <div class="info-box">
                                        <div class="info-label">📝 الاسم الأول</div>
                                        <div class="info-value">{{ $document->person_firstname ?? 'غير متوفر' }}</div>
                                    </div>

                                    <div class="info-box">
                                        <div class="info-label">📝 اسم الأب</div>
                                        <div class="info-value">{{ $document->person_father ?? 'غير متوفر' }}</div>
                                    </div>

                                    <div class="info-box">
                                        <div class="info-label">🎂 تاريخ الميلاد</div>
                                        <div class="info-value date-value">
                                            @php
                                                $date = $document->person_birthdate;
                                                if($date) {
                                                    $carbon = \Carbon\Carbon::parse($date);
                                                    $months = ['', 'جانفي', 'فيفري', 'مارس', 'أفريل', 'ماي', 'جوان', 'جويلية', 'أوت', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
                                                    echo $carbon->day . ' ' . $months[$carbon->month] . ' ' . $carbon->year;
                                                } else {
                                                    echo 'غير متوفر';
                                                }
                                            @endphp
                                        </div>
                                    </div>

                                    <div class="info-box">
                                        <div class="info-label">🏠 مكان الميلاد</div>
                                        <div class="info-value">{{ $document->person_birthplace ?? 'غير متوفر' }}</div>
                                    </div>

                                    <div class="info-box">
                                        <div class="info-label">📚 رقم المجلد</div>
                                        <div class="info-value">{{ $document->volume_number ?? 'غير محدد' }}</div>
                                    </div>

                                    <div class="info-box">
                                        <div class="info-label">📰 رقم النشر</div>
                                        <div class="info-value">{{ $document->publication_number ?? 'غير محدد' }}</div>
                                    </div>

                                    <div class="info-box">
                                        <div class="info-label">🗓 تاريخ النشر</div>
                                        <div class="info-value date-value">
                                            @php
                                                $date = $document->publication_date;
                                                if($date) {
                                                    $carbon = \Carbon\Carbon::parse($date);
                                                    $months = ['', 'جانفي', 'فيفري', 'مارس', 'أفريل', 'ماي', 'جوان', 'جويلية', 'أوت', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
                                                    echo $carbon->day . ' ' . $months[$carbon->month] . ' ' . $carbon->year;
                                                } else {
                                                    echo 'غير متوفر';
                                                }
                                            @endphp
                                        </div>
                                    </div>

                                    <div class="info-box full-width">
                                        <div class="info-label">📝 الملاحظات</div>
                                        <div class="info-value">{{ $document->notes ?? 'لا توجد ملاحظات' }}</div>
                                    </div>

                                    <div class="info-box">
                                        <div class="info-label">📅 تاريخ الإضافة</div>
                                        <div class="info-value date-value">
                                            @php
                                                $date = $document->created_at;
                                                if($date) {
                                                    $carbon = \Carbon\Carbon::parse($date);
                                                    $months = ['', 'جانفي', 'فيفري', 'مارس', 'أفريل', 'ماي', 'جوان', 'جويلية', 'أوت', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
                                                    echo $carbon->day . ' ' . $months[$carbon->month] . ' ' . $carbon->year . ' - ' . $carbon->format('H:i');
                                                } else {
                                                    echo 'غير متوفر';
                                                }
                                            @endphp
                                        </div>
                                    </div>

                                    <div class="info-box">
                                        <div class="info-label">⏰ آخر تحديث</div>
                                        <div class="info-value date-value">
                                            @php
                                                $date = $document->updated_at;
                                                if($date) {
                                                    $carbon = \Carbon\Carbon::parse($date);
                                                    $months = ['', 'جانفي', 'فيفري', 'مارس', 'أفريل', 'ماي', 'جوان', 'جويلية', 'أوت', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
                                                    echo $carbon->day . ' ' . $months[$carbon->month] . ' ' . $carbon->year . ' - ' . $carbon->format('H:i');
                                                } else {
                                                    echo 'غير متوفر';
                                                }
                                            @endphp
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <!-- قسم الصور -->
                            <div class="images-section">
                                <div class="images-title">📷 صور الوثيقة</div>
                                
                                <div class="images-container">
                                    <!-- الصورة الأمامية -->
                                    <div class="image-wrapper">
                                        <div class="image-label">🔹 الجهة الأمامية</div>
                                        @if($document->document_front_image)
                                            <img src="{{ asset('images/'.$document->document_front_image) }}" 
                                                 class="document-image" 
                                                 onclick="showImageModal(this.src)"
                                                 alt="الجهة الأمامية">
                                        @else
                                            <div class="no-image-box">
                                                <span>📷</span>
                                                <span>لا توجد صورة أمامية</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- الصورة الخلفية -->
                                    <div class="image-wrapper">
                                        <div class="image-label">🔹 الجهة الخلفية</div>
                                        @if($document->document_back_image)
                                            <img src="{{ asset('images/'.$document->document_back_image) }}" 
                                                 class="document-image" 
                                                 onclick="showImageModal(this.src)"
                                                 alt="الجهة الخلفية">
                                        @else
                                            <div class="no-image-box">
                                                <span>📷</span>
                                                <span>لا توجد صورة خلفية</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper no-print">
            {{ $documents->links() }}
        </div>

        <!-- زر الطباعة في الأسفل -->
        <div class="print-button-container no-print">
            <button onclick="window.print()" class="print-btn">
                <span>🖨️</span>
                <span>طباعة الصور</span>
            </button>
        </div>

    @else

        <div class="no-results">
            <div class="no-results-icon">🔍</div>
            <div class="no-results-text">لا توجد نتائج مطابقة للبحث</div>
        </div>

    @endif

</div>

<!-- Modal للصور -->
<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <span class="close-modal">&times;</span>
    <img id="modalImg" class="modal-image">
</div>

<script>
// عرض الصورة في Modal
function showImageModal(src){
    document.getElementById('imageModal').style.display = 'flex';
    document.getElementById('modalImg').src = src;
}

function closeImageModal(){
    document.getElementById('imageModal').style.display = 'none';
}

// إغلاق الـ Modal بزر ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>

@endsection
