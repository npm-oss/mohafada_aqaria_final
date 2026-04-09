<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        body { margin: 0; padding: 0; font-family: DejaVu Sans; }

        .page {
            position: relative;
            width: 210mm;
            height: 297mm;
        }

        .bg {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .field {
            position: absolute;
            font-size: 14px;
            font-weight: bold;
        }

        .break { page-break-after: always; }
    </style>
</head>
<body>

<!-- ✅ الواجهة الأولى -->
<div class="page">
    <img src="{{ public_path('certificates/front.jpg') }}" class="bg">

    <!-- اسم ولقب الطالب -->
    <div class="field" style="top: 420px; right: 180px;">
        {{ $full_name }}
    </div>

    <!-- عنوان كامل -->
    <div class="field" style="top: 460px; right: 180px;">
        {{ $address }}
    </div>

    <!-- الغرض -->
    <div class="field" style="top: 550px; right: 180px;">
        {{ $purpose }}
    </div>
</div>

<div class="break"></div>

<!-- ✅ الواجهة الثانية -->
<div class="page">
    <img src="{{ public_path('certificates/back.jpg') }}" class="bg">

    <!-- البلدية -->
    <div class="field" style="top: 260px; right: 120px;">
        {{ $commune }}
    </div>

    <!-- القسم -->
    <div class="field" style="top: 260px; right: 320px;">
        {{ $section }}
    </div>

    <!-- المساحة -->
    <div class="field" style="top: 260px; right: 500px;">
        {{ $area }} م²
    </div>

    <!-- التاريخ -->
    <div class="field" style="top: 780px; right: 150px;">
        {{ $date }}
    </div>
</div>

</body>
</html>
