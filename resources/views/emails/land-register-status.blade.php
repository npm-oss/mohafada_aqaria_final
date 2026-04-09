<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #1a5632, #0d3d20);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .email-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 18px;
            font-weight: bold;
            margin-top: 15px;
        }

        .status-approved {
            background: #28a745;
            color: white;
        }

        .status-rejected {
            background: #dc3545;
            color: white;
        }

        .email-body {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 20px;
            font-weight: bold;
            color: #1a5632;
            margin-bottom: 20px;
        }

        .message {
            font-size: 16px;
            line-height: 1.8;
            color: #333;
            margin-bottom: 30px;
        }

        .info-box {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            border-left: 5px solid #1a5632;
            margin-bottom: 25px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: bold;
            color: #666;
        }

        .info-value {
            color: #333;
            font-weight: 600;
        }

        .notes-box {
            background: #fff3cd;
            border: 2px solid #ffc107;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .notes-box h3 {
            color: #856404;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .notes-box p {
            color: #856404;
            line-height: 1.6;
        }

        .email-footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 3px solid #1a5632;
        }

        .email-footer p {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .contact-info {
            margin-top: 20px;
            color: #999;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            .email-body {
                padding: 25px 20px;
            }

            .email-header h1 {
                font-size: 22px;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>

<div class="email-container">
    <!-- Header -->
    <div class="email-header">
        <h1>🏛️ المحافظة العقارية</h1>
        <p>إشعار حالة طلب الدفتر العقاري</p>
        <div class="status-badge {{ $status == 'approved' ? 'status-approved' : 'status-rejected' }}">
            @if($status == 'approved')
                ✅ تم قبول الطلب
            @else
                ❌ تم رفض الطلب
            @endif
        </div>
    </div>

    <!-- Body -->
    <div class="email-body">
        <div class="greeting">
            السيد(ة): {{ $register->last_name }} {{ $register->first_name }}
        </div>

        <div class="message">
            @if($status == 'approved')
                <p>نود إعلامكم بأنه تم <strong style="color: #28a745;">قبول طلب الدفتر العقاري</strong> الخاص بكم بعد مراجعة جميع الوثائق المطلوبة.</p>
                <p style="margin-top: 15px;">يمكنكم زيارة مكاتبنا لاستلام الدفتر العقاري خلال أيام العمل الرسمية.</p>
            @else
                <p>نود إعلامكم بأنه تم <strong style="color: #dc3545;">رفض طلب الدفتر العقاري</strong> الخاص بكم.</p>
                <p style="margin-top: 15px;">يرجى مراجعة الملاحظات أدناه وتقديم طلب جديد بعد استيفاء المتطلبات.</p>
            @endif
        </div>

        <!-- معلومات الطلب -->
        <div class="info-box">
            <h3 style="color: #1a5632; margin-bottom: 15px;">📋 معلومات الطلب</h3>
            
            <div class="info-row">
                <span class="info-label">رقم الطلب:</span>
                <span class="info-value">#{{ $register->id }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">رقم التعريف الوطني:</span>
                <span class="info-value">{{ $register->national_id }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">رقم العقار:</span>
                <span class="info-value">{{ $register->property_number }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">اسم العقار:</span>
                <span class="info-value">{{ $register->property_name }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">نوع العقار:</span>
                <span class="info-value">{{ $register->property_type }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">تاريخ التقديم:</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($register->created_at)->format('Y/m/d') }}</span>
            </div>
        </div>

        <!-- ملاحظات الإدارة -->
        @if(!empty($register->admin_notes))
        <div class="notes-box">
            <h3>📝 ملاحظات الإدارة:</h3>
            <p>{{ $register->admin_notes }}</p>
        </div>
        @endif

        @if($status == 'approved')
        <div style="background: #d4edda; padding: 20px; border-radius: 10px; border: 2px solid #28a745;">
            <h3 style="color: #155724; margin-bottom: 10px;">✅ الخطوات القادمة:</h3>
            <ul style="color: #155724; line-height: 1.8; padding-right: 20px;">
                <li>احضر نسخة من بطاقة التعريف الوطنية</li>
                <li>قم بزيارة المحافظة العقارية خلال أوقات الدوام الرسمي</li>
                <li>استلم الدفتر العقاري من قسم الاستلام</li>
            </ul>
        </div>
        @else
        <div style="background: #f8d7da; padding: 20px; border-radius: 10px; border: 2px solid #dc3545;">
            <h3 style="color: #721c24; margin-bottom: 10px;">⚠️ ما يجب فعله:</h3>
            <ul style="color: #721c24; line-height: 1.8; padding-right: 20px;">
                <li>مراجعة الملاحظات المذكورة أعلاه</li>
                <li>تجهيز الوثائق الناقصة أو المطلوب تصحيحها</li>
                <li>تقديم طلب جديد عبر الموقع الإلكتروني</li>
            </ul>
        </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="email-footer">
        <p><strong>المحافظة العقارية</strong></p>
        <p>للاستفسارات والمعلومات الإضافية، يرجى التواصل معنا</p>
        
        <div class="contact-info">
            <p>📞 الهاتف: +213 XXX XXX XXX</p>
            <p>📧 البريد الإلكتروني: info@mohafada.dz</p>
            <p>🌐 الموقع الإلكتروني: www.mohafada.dz</p>
            <p style="margin-top: 15px; font-size: 12px;">
                © {{ date('Y') }} المحافظة العقارية - جميع الحقوق محفوظة
            </p>
        </div>
    </div>
</div>

</body>
</html>