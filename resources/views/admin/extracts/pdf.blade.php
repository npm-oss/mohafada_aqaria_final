<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مستخرج عقد #{{ $extract->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            direction: rtl;
            text-align: right;
            line-height: 1.8;
            color: #333;
        }

        .header {
            text-align: center;
            padding: 2rem 0;
            border-bottom: 3px solid #1a5632;
            margin-bottom: 2rem;
        }

        .header h1 {
            color: #1a5632;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #666;
            font-size: 1.2rem;
        }

        .document-title {
            text-align: center;
            background: linear-gradient(135deg, #1a5632, #2d7a4f);
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin: 2rem 0;
            font-size: 1.8rem;
            font-weight: bold;
        }

        .section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
        }

        .section-title {
            color: #1a5632;
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #c49b63;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #ddd;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: bold;
            color: #1a5632;
            width: 40%;
        }

        .info-value {
            color: #333;
            width: 60%;
            font-weight: 600;
        }

        .extract-type {
            text-align: center;
            padding: 1rem;
            background: #e8f5e9;
            border: 2px solid #4caf50;
            border-radius: 10px;
            margin: 1rem 0;
            font-size: 1.3rem;
            font-weight: bold;
            color: #2e7d32;
        }

        .footer {
            margin-top: 3rem;
            padding-top: 1rem;
            border-top: 2px solid #1a5632;
            text-align: center;
            color: #666;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 3rem;
            padding: 2rem 0;
        }

        .signature-box {
            width: 45%;
            text-align: center;
            padding: 1rem;
            border: 2px dashed #1a5632;
            border-radius: 10px;
        }

        .signature-label {
            font-weight: bold;
            color: #1a5632;
            margin-bottom: 3rem;
            display: block;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 5rem;
            color: rgba(26, 86, 50, 0.05);
            font-weight: bold;
            z-index: -1;
        }
    </style>
</head>
<body>

    <!-- Watermark -->
    <div class="watermark">المحافظة العقارية</div>

    <!-- Header -->
    <div class="header">
        <h1>🇩🇿 الجمهورية الجزائرية الديمقراطية الشعبية</h1>
        <p>المحافظة العقارية</p>
    </div>

    <!-- Document Title -->
    <div class="document-title">
        📋 مستخرج عقد
    </div>

    <!-- Extract Type -->
    <div class="extract-type">
        @if($extract->extract_type == 'original')
            📄 نسخة أصلية
        @elseif($extract->extract_type == 'copy')
            📑 نسخة طبق الأصل
        @else
            📋 نسخة مصادق عليها
        @endif
    </div>

    <!-- Request Number -->
    <div style="text-align: center; margin: 1rem 0; font-size: 1.1rem;">
        <strong>رقم الطلب:</strong> #{{ str_pad($extract->id, 6, '0', STR_PAD_LEFT) }}
    </div>

    <!-- Applicant Information -->
    <div class="section">
        <div class="section-title">👤 معلومات الطالب</div>

        <div class="info-row">
            <div class="info-label">اللقب:</div>
            <div class="info-value">{{ $extract->applicant_lastname }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">الاسم:</div>
            <div class="info-value">{{ $extract->applicant_firstname }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">اسم الأب:</div>
            <div class="info-value">{{ $extract->applicant_father }}</div>
        </div>

        @if($extract->applicant_nin)
        <div class="info-row">
            <div class="info-label">رقم التعريف الوطني:</div>
            <div class="info-value">{{ $extract->applicant_nin }}</div>
        </div>
        @endif

        @if($extract->applicant_email)
        <div class="info-row">
            <div class="info-label">البريد الإلكتروني:</div>
            <div class="info-value">{{ $extract->applicant_email }}</div>
        </div>
        @endif

        @if($extract->applicant_phone)
        <div class="info-row">
            <div class="info-label">رقم الهاتف:</div>
            <div class="info-value">{{ $extract->applicant_phone }}</div>
        </div>
        @endif
    </div>

    <!-- Contract Information -->
    <div class="section">
        <div class="section-title">📄 معلومات العقد المطلوب</div>

        <div class="info-row">
            <div class="info-label">رقم المجلد:</div>
            <div class="info-value">{{ $extract->volume_number }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">رقم النشر:</div>
            <div class="info-value">{{ $extract->publication_number }}</div>
        </div>

        @if($extract->publication_date)
        <div class="info-row">
            <div class="info-label">تاريخ النشر:</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($extract->publication_date)->format('Y/m/d') }}</div>
        </div>
        @endif
    </div>

    <!-- Request Information -->
    <div class="section">
        <div class="section-title">📊 معلومات الطلب</div>

        <div class="info-row">
            <div class="info-label">تاريخ التقديم:</div>
            <div class="info-value">{{ $extract->created_at->format('Y/m/d H:i') }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">الحالة:</div>
            <div class="info-value">
                @if($extract->status == 'قيد المعالجة')
                    ⏳ قيد المعالجة
                @elseif($extract->status == 'مقبول')
                    ✅ مقبول
                @else
                    ❌ مرفوض
                @endif
            </div>
        </div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <span class="signature-label">الطالب</span>
            <div style="height: 50px;"></div>
        </div>

        <div class="signature-box">
            <span class="signature-label">المحافظ العقاري</span>
            <div style="height: 50px;"></div>
            <div style="margin-top: 1rem; font-size: 0.9rem; color: #666;">
                التاريخ: {{ now()->format('Y/m/d') }}
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>هذه الوثيقة صادرة عن المحافظة العقارية</p>
        <p style="margin-top: 0.5rem; font-size: 0.9rem;">
            تاريخ الطباعة: {{ now()->format('Y/m/d H:i') }}
        </p>
    </div>

</body>
</html>