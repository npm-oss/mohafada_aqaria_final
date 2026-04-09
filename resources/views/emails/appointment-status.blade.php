<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تحديث حالة الموعد</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f6f1 0%, #e8e3d9 100%);
            padding: 2rem;
            direction: rtl;
        }

        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .email-header {
            background: linear-gradient(135deg, #1a5632 0%, #0d3d20 100%);
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .email-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .email-header-content {
            position: relative;
            z-index: 2;
        }

        .logo {
            font-size: 5rem;
            margin-bottom: 1rem;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.3));
        }

        .email-header h1 {
            color: #ffffff;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .email-header p {
            color: rgba(255,255,255,0.95);
            font-size: 1.1rem;
        }

        .email-body {
            padding: 3rem 2.5rem;
        }

        .status-badge {
            display: inline-block;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-size: 1.3rem;
            font-weight: 800;
            margin-bottom: 2rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .status-badge.confirmed {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            color: #2e7d32;
            border: 3px solid #2e7d32;
        }

        .status-badge.cancelled {
            background: linear-gradient(135deg, #ffebee, #ffcdd2);
            color: #c62828;
            border: 3px solid #c62828;
        }

        .status-badge.completed {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            color: #1976d2;
            border: 3px solid #1976d2;
        }

        .greeting {
            font-size: 1.4rem;
            color: #1a5632;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .message {
            font-size: 1.1rem;
            color: #333;
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .info-box {
            background: linear-gradient(135deg, #f8f6f1, #e8e3d9);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 3px solid #1a5632;
        }

        .info-box h3 {
            color: #1a5632;
            font-size: 1.3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            margin-bottom: 0.8rem;
            background: white;
            border-radius: 12px;
            border-right: 5px solid #c49b63;
        }

        .info-label {
            color: #666;
            font-weight: 600;
            font-size: 1rem;
        }

        .info-value {
            color: #1a5632;
            font-weight: 800;
            font-size: 1rem;
        }

        .notes-box {
            background: #fff8e1;
            border: 3px solid #ffc107;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .notes-box h4 {
            color: #f57c00;
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .notes-box p {
            color: #333;
            font-size: 1rem;
            line-height: 1.7;
        }

        .action-button {
            display: inline-block;
            padding: 1.2rem 3rem;
            background: linear-gradient(135deg, #1a5632, #2e7d4a);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1.1rem;
            margin: 1rem 0;
            box-shadow: 0 10px 30px rgba(26, 86, 50, 0.3);
            transition: all 0.3s ease;
        }

        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(26, 86, 50, 0.5);
        }

        .email-footer {
            background: #f8f6f1;
            padding: 2rem;
            text-align: center;
            border-top: 3px dashed #c49b63;
        }

        .email-footer p {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .contact-info {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #1a5632;
            font-weight: 600;
        }

        .divider {
            height: 3px;
            background: linear-gradient(90deg, transparent, #c49b63, transparent);
            margin: 2rem 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="email-header-content">
                <div class="logo">📅</div>
                <h1>المحافظة العقارية</h1>
                <p>تحديث حالة موعدك</p>
            </div>
        </div>

        <!-- Body -->
        <div class="email-body">
            @if($status == 'confirmed')
                <div class="status-badge confirmed">✅ تم تأكيد موعدك</div>
                
                <div class="greeting">
                    السيد(ة) {{ $appointment->full_name }},
                </div>

                <div class="message">
                    نسعد بإبلاغكم أنه تم <strong>تأكيد موعدكم</strong> بنجاح في المحافظة العقارية.
                </div>

            @elseif($status == 'cancelled')
                <div class="status-badge cancelled">❌ تم إلغاء موعدك</div>
                
                <div class="greeting">
                    السيد(ة) {{ $appointment->full_name }},
                </div>

                <div class="message">
                    نأسف لإبلاغكم بأنه تم <strong>إلغاء موعدكم</strong> في المحافظة العقارية.
                </div>

            @elseif($status == 'completed')
                <div class="status-badge completed">✅ تم إنجاز موعدك</div>
                
                <div class="greeting">
                    السيد(ة) {{ $appointment->full_name }},
                </div>

                <div class="message">
                    نشكركم على زيارتكم. تم <strong>إنجاز موعدكم</strong> بنجاح.
                </div>
            @endif

            <div class="info-box">
                <h3>📋 تفاصيل الموعد</h3>
                
                <div class="info-row">
                    <span class="info-label">رقم الموعد:</span>
                    <span class="info-value">#{{ $appointment->id }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">نوع الخدمة:</span>
                    <span class="info-value">{{ $appointment->service_type ?? 'غير محدد' }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">تاريخ الموعد:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y/m/d') }}</span>
                </div>

                @if($appointment->appointment_time)
                <div class="info-row">
                    <span class="info-label">وقت الموعد:</span>
                    <span class="info-value">{{ $appointment->appointment_time }}</span>
                </div>
                @endif

                <div class="info-row">
                    <span class="info-label">الحالة:</span>
                    <span class="info-value">
                        @if($status == 'confirmed')
                            ✅ مؤكد
                        @elseif($status == 'cancelled')
                            ❌ ملغي
                        @elseif($status == 'completed')
                            ✅ مكتمل
                        @endif
                    </span>
                </div>
            </div>

            @if(!empty($appointment->admin_notes))
            <div class="notes-box">
                <h4>📝 ملاحظات الإدارة</h4>
                <p>{{ $appointment->admin_notes }}</p>
            </div>
            @endif

            <div class="divider"></div>

            @if($status == 'confirmed')
            <div class="message">
                <strong>يرجى الحضور في الموعد المحدد مع إحضار:</strong>
                <ul style="margin-right: 2rem; margin-top: 1rem; line-height: 2;">
                    <li>بطاقة التعريف الوطنية</li>
                    <li>جميع الوثائق المطلوبة</li>
                    <li>نسخة من هذا البريد الإلكتروني</li>
                </ul>
            </div>
            @endif

            @if($status == 'cancelled')
            <div class="message">
                <strong>يمكنكم إعادة الحجز من خلال:</strong>
                <ul style="margin-right: 2rem; margin-top: 1rem; line-height: 2;">
                    <li>زيارة موقعنا الإلكتروني</li>
                    <li>الاتصال بنا على الرقم: {{ setting('contact_phone', '+213 XXX XXX XXX') }}</li>
                    <li>زيارة المحافظة مباشرة</li>
                </ul>
            </div>
            @endif

            <div style="text-align: center; margin-top: 2rem;">
                <a href="{{ url('/') }}" class="action-button">
                    🏠 زيارة الموقع الإلكتروني
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>المحافظة العقارية - أولاد جلال</strong></p>
            <p>{{ setting('contact_address', 'أولاد جلال، الجزائر') }}</p>
            
            <div class="contact-info">
                <div class="contact-item">
                    <span>📞</span>
                    <span>{{ setting('contact_phone', '+213 XXX XXX XXX') }}</span>
                </div>
                <div class="contact-item">
                    <span>✉️</span>
                    <span>{{ setting('contact_email', 'info@conservation.dz') }}</span>
                </div>
            </div>

            <div class="divider"></div>

            <p style="font-size: 0.85rem; color: #999;">
                هذه رسالة تلقائية، يرجى عدم الرد عليها
            </p>
        </div>
    </div>
</body>
</html>