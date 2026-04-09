<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استخراج الشهادة #{{ $certificate->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #95a5a6;
            font-family: 'Amiri', 'Arial', serif;
            padding: 0;
            margin: 0;
        }

        /* ========== TOOLBAR FIXE ========== */
        .fixed-toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            padding: 15px 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            z-index: 9999;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .toolbar-title {
            color: white;
            font-family: 'Cairo', Arial;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .certificate-selector {
            display: flex;
            gap: 10px;
            background: rgba(255,255,255,0.1);
            padding: 5px;
            border-radius: 8px;
        }

        .cert-btn {
            padding: 10px 25px;
            border: 2px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-family: 'Cairo', Arial;
            font-size: 1rem;
            background: rgba(255,255,255,0.2);
            color: white;
            transition: all 0.3s;
        }

        .cert-btn.active {
            background: #f39c12;
            border-color: #f39c12;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Cairo', Arial;
            font-size: 1rem;
        }

        .btn-save { background: linear-gradient(135deg, #27ae60, #229954); color: white; }
        .btn-print { background: linear-gradient(135deg, #3498db, #2980b9); color: white; }
        .btn-back { background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.4);
        }

        /* ========== CONTENEUR PRINCIPAL ========== */
        .main-container {
            margin-top: 90px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
        }

        /* Masquage des certificats non actifs */
        .certificate-wrapper {
            display: none;
            width: 100%;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        .certificate-wrapper.active {
            display: flex;
        }

        /* Conteneur des deux pages d'un certificat (côte à côte) */
        .pages-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            width: 100%;
        }

        /* Chaque page A4 */
        .document-page {
            background: white;
            padding: 5mm;
            box-shadow: 0 5px 25px rgba(0,0,0,0.3);
            width: 210mm;
            min-height: 297mm;
            transition: transform 0.3s;
        }

        /* En mode écran, on réduit légèrement pour voir les deux côte à côte */
        @media screen and (min-width: 1400px) {
            .document-page {
                width: 48%;
                min-width: 190mm;
            }
        }

        /* Styles généraux des tableaux */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        td, th {
            border: 1.5px solid black;
            padding: 2px 4px;
            vertical-align: top;
            font-size: 10pt;
        }

        th {
            background: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            border: none;
            background: transparent;
            outline: none;
            font-family: 'Amiri', Arial;
            font-size: 10pt;
            padding: 1px;
            direction: rtl;
            width: 100%;
        }

        input:focus, textarea:focus { background: #fffacd; }
        textarea { resize: vertical; min-height: 20px; }

        .inline-input {
            display: inline-block;
            width: auto;
            min-width: 40px;
            border-bottom: 1px solid #333;
        }

        .main-header {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 8px;
            border-bottom: 2px solid #000;
            padding-bottom: 3px;
        }

        .section-title {
            background: #e8e8e8;
            padding: 3px;
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
        }

        .small-text { 
            font-size: 7.5pt; 
            line-height: 1.15; 
        }
        
        .checkbox {
            width: 10px;
            height: 10px;
            border: 1px solid #000;
            display: inline-block;
            margin-left: 3px;
            vertical-align: middle;
        }

        /* Impression */
        @media print {
            body { background: white; margin: 0; padding: 0; }
            .fixed-toolbar, .certificate-selector { display: none !important; }
            .main-container { margin-top: 0; padding: 0; gap: 0; }
            .certificate-wrapper.active { display: block; }
            .pages-container { display: block; }
            .document-page {
                box-shadow: none;
                page-break-after: always;
                width: 100%;
                min-height: auto;
                padding: 3mm;
                margin: 0 auto;
            }
            .document-page:last-child { page-break-after: auto; }
            @page { size: A4 portrait; margin: 0; }
        }
    </style>
</head>
<body>

<div class="fixed-toolbar">
    <div class="toolbar-title">
        <i class="fas fa-file-signature me-2"></i>
        استخراج الشهادة رقم {{ $certificate->id }}
    </div>
    
    <div class="certificate-selector">
        <button type="button" class="cert-btn active" onclick="showCertificate('negative')">
            <i class="fas fa-minus-circle"></i> شهادة سلبية
        </button>
        <button type="button" class="cert-btn" onclick="showCertificate('positive')">
            <i class="fas fa-plus-circle"></i> شهادة إيجابية
        </button>
    </div>

    <div style="display: flex; gap: 15px;">
        <button type="button" class="btn btn-back" onclick="window.location='{{ route('admin.certificates.index') }}'">
            <i class="fas fa-arrow-right me-2"></i> رجوع
        </button>
        <button type="button" class="btn btn-print" onclick="window.print()">
            <i class="fas fa-print me-2"></i> طباعة
        </button>
        <button type="button" class="btn btn-save" onclick="document.getElementById('mainForm').submit()">
            <i class="fas fa-save me-2"></i> حفظ
        </button>
    </div>
</div>

<form method="POST" action="{{ route('admin.certificates.extract.save', $certificate->id) }}" id="mainForm">
    @csrf
    
    <div class="main-container">
        
        <!-- ========== الشهادة السلبية (وجهان متقابلان) ========== -->
        <div id="negative-cert" class="certificate-wrapper active">
            <div class="pages-container">
                <!-- الوجه الأول (السلبية) -->
                <div class="document-page">
                    <div class="main-header">إدارة الأملاك الوطنيـــــــــة</div>
                    <table>
                        <tr>
                            <td style="width: 48%;">
                                <div style="font-weight: bold; text-align: center; font-size: 10pt; margin-bottom: 3px;">إيطار مخصص للمحافظ</div>
                                <div style="font-size: 9pt; line-height: 1.4;">
                                    <div>دج طلب عدد : <input type="text" name="neg_request_number" class="inline-input" style="width: 60px;"></div>
                                    <div>سعر: <input type="text" name="neg_price" class="inline-input" style="width: 50px;"> خدمــــات عدد : <input type="text" name="neg_services_num" class="inline-input" style="width: 50px;"></div>
                                    <div>موضع في: <input type="text" name="neg_placed_in" class="inline-input" style="width: 100px;"></div>
                                    <div>إجراء : <input type="text" name="neg_procedure" class="inline-input" style="width: 120px;"></div>
                                    <div>جدول مسلم في : <input type="text" name="neg_delivered_in" class="inline-input" style="width: 80px;"></div>
                                    <div>حجـــــم : <input type="text" name="neg_volume" class="inline-input" style="width: 50px;"></div>
                                </div>
                            </td>
                            <td style="width: 32%;">
                                <div class="section-title" style="font-size: 11pt;">طــــــــابـع المكتــــب</div>
                                <div style="height: 90px; margin-top: 3px;"></div>
                            </td>
                            <td style="width: 20%; text-align: center; vertical-align: top;">
                                <div style="font-weight: bold; font-size: 10pt; margin-bottom: 35px;">عدد 1 م.ع</div>
                                <div style="font-size: 9pt; margin-bottom: 5px;">مكرر</div>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td style="width: 80%;">
                                <div class="section-title" style="font-size: 10pt;">توصيــــــــة هـــــامـــــة</div>
                                <div style="padding: 5px; text-align: center; font-size: 9pt; font-weight: bold;">تقـــديم لــزومــا الطلبات على نسختين و بالآلـــــة الراقنــــة</div>
                            </td>
                            <td style="width: 20%;">
                                <div class="section-title" style="font-size: 9pt;">مراجع الطلب</div>
                                <div style="height: 30px;"></div>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td style="width: 70%; vertical-align: top;">
                                <div class="section-title" style="font-size: 10pt;">طــــلـب معلومات موجزة (1)</div>
                                <div style="padding: 5px; font-size: 9pt; line-height: 1.5;">
                                    <div style="margin-bottom: 4px;">على (1) <input type="text" name="neg_on_procedure" class="inline-input" style="width: 100px;"> <span style="margin-right: 20px; font-weight: bold;">إجــــراء</span></div>
                                    <div style="margin-bottom: 6px;">خـــارج عن (1) <input type="text" name="neg_outside_from" class="inline-input" style="width: 120px;"></div>
                                    <div style="margin-top: 6px; margin-bottom: 4px;">أنــا الممضي أســفـــله (2) .</div>
                                    <div style="margin-bottom: 4px;">الســــاكـــن بـــ (3) : <input type="text" name="neg_resident_at" style="width: 250px;"></div>
                                    <div style="margin-bottom: 8px;">أطلب مستخـــرجا (4)</div>
                                    <div style="font-size: 8.5pt; line-height: 1.4; margin-right: 12px;">
                                        <div style="margin-bottom: 3px;"><span class="checkbox"></span> من الحجزات الغير الباطلة و لا المشطبة ، (5)؛</div>
                                        <div style="margin-bottom: 3px;"><span class="checkbox"></span> من تسجيلات الإمتيازات و الرهـــون المستبقية ، (5)</div>
                                        <div style="margin-bottom: 3px;"><span class="checkbox"></span> من الوثائق المسجلة أو المشهورة ( ما عدى التسجيلات و الحجزات و التأشيرات بالهـــامش)</div>
                                    </div>
                                    <div class="small-text" style="margin-top: 3px; margin-right: 12px;">التي لها أثر اكتسابي للأشـــخــاص اللذين عينها المعلومات المطلوبة(1)أ</div>
                                    <div style="margin-top: 4px; font-size: 8.5pt; margin-right: 12px;"><span class="checkbox"></span> من تأشيرات الأحكــام المعلنة الفسخ و الإبطــال و النقضي الحاصلة قبل أول مــارس 1961</div>
                                    <div style="margin-top: 4px; font-size: 8.5pt; margin-right: 12px;"><span class="checkbox"></span> و الصــادرة أو المشهـــورة منذ (6) 01 مـــارس1961</div>
                                    <div style="margin-top: 4px; font-size: 8.5pt; margin-right: 12px;">إلــى يــومـــنا هــذا (7) <input type="text" name="neg_date_to" class="inline-input" style="width: 90px;"> إلــى تاريخ هــــذا الطـــلـب</div>
                                    <div class="small-text" style="margin-top: 3px; margin-right: 12px;">النــاشــىء عن الأشـــخــاص و العـــقـــارات المبينة ظهر هذا الطلب</div>
                                    <div style="margin-top: 3px; font-size: 8.5pt; margin-right: 12px;">باستثناء – التسجيل أو الإشـــهـــار المطــلوب بـــتـــه (8)؛ (1)</div>
                                    <div class="small-text" style="margin-top: 3px; margin-right: 12px;">– الرسوم و الأحكـــام المذكـــورة في المقـــالة أو الوثيقة الموضــعة مـــع هــــذا الطلب</div>
                                    <div style="margin-top: 3px; font-size: 8.5pt; margin-right: 12px;">– الإجراءات الآتية : (9)</div>
                                </div>
                            </td>
                            <td style="width: 30%; font-size: 7pt; line-height: 1.2; padding: 3px; vertical-align: top;">
                                <p style="margin: 0 0 2px 0;">(1) يشطب عند الاقتضاء</p>
                                <p style="margin: 0 0 2px 0;">(2) استوفى مهنة الطالب</p>
                                <p style="margin: 0 0 2px 0;">(3) العنوان الكامل</p>
                                <p style="margin: 3px 0 2px 0;">(4) إذا أراد الطالب التحصيل من نقلة خامسة نوثائق يلزم أن يعوض كاملة مستخرج بـــة نقلة .</p>
                                <p style="margin: 3px 0 2px 0;">(5) يضع علامة على الخريطة المعنية</p>
                                <p style="margin: 3px 0 2px 0;">(6)(7) تسليم المعلومات التالية...</p>
                                <p style="margin: 3px 0 2px 0;">(8) في حالة طلب المعلومات على الإجـــراء هذه .</p>
                                <p style="margin: 0;">(9) يبين نوعها ( تسجيل حجز ـالشهار ـ تاريخ ـ حجم وعدد</p>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <div class="section-title" style="font-size: 10pt;">معـــلـومـات أخـــرى مطلــــوبـــة</div>
                                <div style="padding: 5px; text-align: center; font-weight: bold; font-size: 9pt;">* طلب خارج الإجراء</div>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td style="width: 28%;">
                                <div class="section-title" style="font-size: 9pt;">طلب غير قيــــاسي</div>
                                <div style="padding: 5px; font-size: 8.5pt;">
                                    <div style="margin-bottom: 3px; font-weight: bold;">وضع مرفوض نيتة</div>
                                    <div style="margin-bottom: 2px;"><span class="checkbox"></span> عدم استعمال الأنية في حالة</div>
                                    <div style="margin-bottom: 2px;"><span class="checkbox"></span> عدم إقامة نسخة ثانية</div>
                                    <div style="margin-bottom: 2px;"><span class="checkbox"></span> بيان غير كامل بالأطـــراف</div>
                                    <div style="margin-bottom: 2px;"><span class="checkbox"></span> بيان غير كامل للعقارات</div>
                                    <div style="margin-bottom: 2px;"><span class="checkbox"></span> عدم الدفع على الحساب</div>
                                    <div><span class="checkbox"></span> الأنيــــــة</div>
                                </div>
                            </td>
                            <td style="width: 42%;">
                                <div style="padding: 5px; font-size: 8.5pt;">
                                    <div style="margin-bottom: 8px;">أودع مبلغا قدره <input type="text" name="neg_amount" class="inline-input" style="width: 60px;"> دج و أتعهد بأداء ما يفي من</div>
                                    <div>المصاريف عند الاقتضاء بعد تسليم المعلومات .</div>
                                </div>
                            </td>
                            <td style="width: 30%;">
                                <div style="padding: 5px; text-align: center;">
                                    <div style="font-weight: bold; font-size: 10pt; margin-bottom: 12px;">فــــــــــــي</div>
                                    <input type="text" name="neg_place_date" style="width: 90%; text-align: center; margin-bottom: 15px; font-size: 9pt;">
                                    <div style="font-weight: bold; font-size: 10pt; margin-bottom: 6px;">إمضـــاء الطــــلب:</div>
                                    <div style="height: 35px; border-bottom: 1.5px solid black; margin-top: 3px;"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div> <!-- fin première page négative -->

                <!-- الوجه الثاني (السلبية) -->
                <div class="document-page">
                    <table>
                        <tr>
                            <td style="width: 56%; vertical-align: top;">
                                <table style="margin-bottom: 3px;">
                                    <tr><td class="section-title" style="font-size: 11pt; padding: 4px;">شهــــــــادة للمحافـــــــظ</td></tr>
                                    <tr><td style="font-size: 9pt; padding: 6px; line-height: 1.4;">إن المحـــافظ العقاري الممضى أسفله يتأكــد أنـه لا يوجــد أي أجــزاء أخــر في وثائقـه ماعدا الإجراءات المذكورة أسفلـــه و التي سـلــم من أجلهـا مستخرجـا طيه (4).</td></tr>
                                </table>
                                <table style="margin-top: 3px;">
                                    <tr>
                                        <td colspan="4" class="section-title" style="font-size: 9pt;">إجـــــــــــراءات</td>
                                        <td colspan="3" class="section-title" style="font-size: 9pt;">حقوق مسجلة أو مشهورة<br><span style="font-size: 7.5pt;">سند المدين أو القرينة القانونية المعني</span></td>
                                    </tr>
                                    <tr style="font-size: 8pt;">
                                        <th style="width: 10%;">نوع</th><th style="width: 12%;">تاريخ</th><th style="width: 8%;">حجم</th><th style="width: 8%;">رقم</th>
                                        <th style="width: 10%;">نوع</th><th style="width: 12%;">تاريخ</th><th style="width: 18%;">المعني</th>
                                    </tr>
                                    @for($i = 1; $i <= 8; $i++)
                                    <tr>
                                        <td><input type="text" name="neg_proc{{ $i }}_type"></td>
                                        <td><input type="text" name="neg_proc{{ $i }}_date"></td>
                                        <td><input type="text" name="neg_proc{{ $i }}_volume"></td>
                                        <td><input type="text" name="neg_proc{{ $i }}_num"></td>
                                        <td><input type="text" name="neg_right{{ $i }}_type"></td>
                                        <td><input type="text" name="neg_right{{ $i }}_date"></td>
                                        <td><input type="text" name="neg_right{{ $i }}_concerned"></td>
                                    </tr>
                                    @endfor
                                </table>
                                <table style="margin-top: 3px;">
                                    <tr style="font-size: 8pt;">
                                        <td colspan="2" style="text-align: center; padding: 5px;"><div>يصدق عن</div><div style="margin-top: 3px; font-weight: bold;">أساطير</div></td>
                                        <td colspan="2" style="text-align: center; padding: 5px;"><div>كلمـــــة</div></td>
                                        <td colspan="2" style="text-align: center; padding: 5px;"><div>فـــى:</div><div style="margin-top: 3px;">المحافظة</div></td>
                                        <td style="text-align: center; padding: 5px;"><div>رقــم باطلة</div></td>
                                        <td style="text-align: center; padding: 5px;"><div>أرقـام</div></td>
                                    </tr>
                                </table>
                                <table style="margin-top: 3px;">
                                    <tr><td class="small-text" style="padding: 4px; line-height: 1.15;">
                                        <p style="margin: 0 0 2px 0;">(1) ن و ج، تاريخ و اسم الأطراف</p>
                                        <p style="margin: 0 0 2px 0;">(2) يذكر لزوما فيما يخص الأشخاص الطبيعية الإسم و الألقاب...</p>
                                        <p style="margin: 0 0 2px 0;">(3) تبرأ مسؤولية المحافظ عند وجود أية غلطة في بيان العقارات.</p>
                                        <p style="margin: 0;">(4) لا يسلم مستخرجا و لا نسخة فيما يخص المعلومات المذكورة.</p>
                                    </td></tr>
                                </table>
                            </td>
                            <td style="width: 44%; vertical-align: top;">
                                <table style="margin-bottom: 3px;">
                                    <tr><td class="section-title" style="font-size: 9pt; padding: 4px;">بيـــــــــان ســـــــــند المديــــــــن و (مساحـــــة الإقتنيـــــــاء) (1)</td></tr>
                                    <tr><td style="height: 50px; padding: 4px;"><textarea name="neg_debtor_deed" rows="2"></textarea></td></tr>
                                </table>
                                <table style="margin-bottom: 3px;">
                                    <tr><td class="section-title" style="font-size: 9pt; padding: 4px;">هـــــــــويــــــة الأشـــــخـــــاص المبـــلـــغ عنها لمعلــومـــــات المطلــــــــوبة (2)</td></tr>
                                    <tr><td style="height: 50px; padding: 4px;"><textarea name="neg_persons_identity" rows="2"></textarea></td></tr>
                                </table>
                                <table>
                                    <tr><td colspan="6" class="section-title" style="font-size: 9pt; padding: 4px;">بيـــــــــان فـــــــــــردى للعقـــــــــــــارت (3)</td></tr>
                                    <tr style="font-size: 7.5pt;">
                                        <th rowspan="2" style="width: 10%;">قطعة</th>
                                        <th colspan="2" style="width: 32%;">للعقار الريفي</th>
                                        <th colspan="2" style="width: 35%;">مراجع الأراضي</th>
                                        <th rowspan="2" style="width: 23%;">ببلديــــــة<br>بدرج هذا</th>
                                    </tr>
                                    <tr style="font-size: 7pt;">
                                        <th style="width: 14%;">نهج و رقــم<br>أو المكـــان<br>المـــجاورون</th>
                                        <th style="width: 12%;">عدد<br>مساحة</th>
                                        <th style="width: 16%;">القسم<br>أو المكان المذكور</th>
                                        <th style="width: 16%;">عدد<br>مساحة</th>
                                    </tr>
                                    @for($i = 0; $i < 6; $i++)
                                    <tr>
                                        <td><input type="text" name="neg_prop{{ $i }}_piece"></td>
                                        <td><input type="text" name="neg_prop{{ $i }}_address"></td>
                                        <td><input type="text" name="neg_prop{{ $i }}_num_area"></td>
                                        <td><input type="text" name="neg_prop{{ $i }}_section"></td>
                                        <td><input type="text" name="neg_prop{{ $i }}_land_num"></td>
                                        <td><input type="text" name="neg_prop{{ $i }}_municipality"></td>
                                    </tr>
                                    @endfor
                                    <tr><td colspan="6" class="small-text" style="padding: 4px; line-height: 1.15;">تستعمل ورقة ملحقة أو اكثر (ورق مطبوع عدد 4 م ع) إذا كانت لجداول أعــــــــــلاه غــــــــــير كافيـــــــــــة ، يعين عددها في داخل هذه الخريطة <input type="text" name="neg_additional_sheets" class="inline-input" style="width: 40px; border: 1px solid #000; margin: 0 3px;"></td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div> <!-- fin deuxième page négative -->
            </div> <!-- pages-container negative -->
        </div> <!-- certificate-wrapper negative -->

        <!-- ========== الشهادة الإيجابية (وجهان متقابلان) ========== -->
        <div id="positive-cert" class="certificate-wrapper">
            <div class="pages-container">
                <!-- الوجه الأول (الإيجابية) - مشابه للسلبية مع تغيير العنوان -->
                <div class="document-page">
                    <div class="main-header">إدارة الأملاك الوطنيـــــــــة - شهادة إيجابية</div>
                    <table>
                        <tr>
                            <td style="width: 48%;">
                                <div style="font-weight: bold; text-align: center; font-size: 10pt; margin-bottom: 3px;">إيطار مخصص للمحافظ</div>
                                <div style="font-size: 9pt; line-height: 1.4;">
                                    <div>دج طلب عدد : <input type="text" name="pos_request_number" class="inline-input" style="width: 60px;"></div>
                                    <div>سعر: <input type="text" name="pos_price" class="inline-input" style="width: 50px;"> خدمــــات عدد : <input type="text" name="pos_services_num" class="inline-input" style="width: 50px;"></div>
                                    <div>موضع في: <input type="text" name="pos_placed_in" class="inline-input" style="width: 100px;"></div>
                                    <div>إجراء : <input type="text" name="pos_procedure" class="inline-input" style="width: 120px;"></div>
                                    <div>جدول مسلم في : <input type="text" name="pos_delivered_in" class="inline-input" style="width: 80px;"></div>
                                    <div>حجـــــم : <input type="text" name="pos_volume" class="inline-input" style="width: 50px;"></div>
                                </div>
                            </td>
                            <td style="width: 32%;">
                                <div class="section-title" style="font-size: 11pt;">طــــــــابـع المكتــــب</div>
                                <div style="height: 90px; margin-top: 3px;"></div>
                            </td>
                            <td style="width: 20%; text-align: center; vertical-align: top;">
                                <div style="font-weight: bold; font-size: 10pt; margin-bottom: 35px;">عدد 1 م.ع</div>
                                <div style="font-size: 9pt; margin-bottom: 5px;">مكرر</div>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td style="width: 80%;">
                                <div class="section-title" style="font-size: 10pt;">توصيــــــــة هـــــامـــــة</div>
                                <div style="padding: 5px; text-align: center; font-size: 9pt; font-weight: bold;">تقـــديم لــزومــا الطلبات على نسختين و بالآلـــــة الراقنــــة</div>
                            </td>
                            <td style="width: 20%;">
                                <div class="section-title" style="font-size: 9pt;">مراجع الطلب</div>
                                <div style="height: 30px;"></div>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td style="width: 70%; vertical-align: top;">
                                <div class="section-title" style="font-size: 10pt;">طــــلـب معلومات موجزة (1)</div>
                                <div style="padding: 5px; font-size: 9pt; line-height: 1.5;">
                                    <div style="margin-bottom: 4px;">على (1) <input type="text" name="pos_on_procedure" class="inline-input" style="width: 100px;"> <span style="margin-right: 20px; font-weight: bold;">إجــــراء</span></div>
                                    <div style="margin-bottom: 6px;">خـــارج عن (1) <input type="text" name="pos_outside_from" class="inline-input" style="width: 120px;"></div>
                                    <div style="margin-top: 6px; margin-bottom: 4px;">أنــا الممضي أســفـــله (2) .</div>
                                    <div style="margin-bottom: 4px;">الســــاكـــن بـــ (3) : <input type="text" name="pos_resident_at" style="width: 250px;"></div>
                                    <div style="margin-bottom: 8px;">أطلب مستخـــرجا (4)</div>
                                    <div style="font-size: 8.5pt; line-height: 1.4; margin-right: 12px;">
                                        <div style="margin-bottom: 3px;"><span class="checkbox"></span> من الحجزات الغير الباطلة و لا المشطبة ، (5)؛</div>
                                        <div style="margin-bottom: 3px;"><span class="checkbox"></span> من تسجيلات الإمتيازات و الرهـــون المستبقية ، (5)</div>
                                        <div style="margin-bottom: 3px;"><span class="checkbox"></span> من الوثائق المسجلة أو المشهورة ( ما عدى التسجيلات و الحجزات و التأشيرات بالهـــامش)</div>
                                    </div>
                                    <div class="small-text" style="margin-top: 3px; margin-right: 12px;">التي لها أثر اكتسابي للأشـــخــاص اللذين عينها المعلومات المطلوبة(1)أ</div>
                                    <div style="margin-top: 4px; font-size: 8.5pt; margin-right: 12px;"><span class="checkbox"></span> من تأشيرات الأحكــام المعلنة الفسخ و الإبطــال و النقضي الحاصلة قبل أول مــارس 1961</div>
                                    <div style="margin-top: 4px; font-size: 8.5pt; margin-right: 12px;"><span class="checkbox"></span> و الصــادرة أو المشهـــورة منذ (6) 01 مـــارس1961</div>
                                    <div style="margin-top: 4px; font-size: 8.5pt; margin-right: 12px;">إلــى يــومـــنا هــذا (7) <input type="text" name="pos_date_to" class="inline-input" style="width: 90px;"> إلــى تاريخ هــــذا الطـــلـب</div>
                                    <div class="small-text" style="margin-top: 3px; margin-right: 12px;">النــاشــىء عن الأشـــخــاص و العـــقـــارات المبينة ظهر هذا الطلب</div>
                                    <div style="margin-top: 3px; font-size: 8.5pt; margin-right: 12px;">باستثناء – التسجيل أو الإشـــهـــار المطــلوب بـــتـــه (8)؛ (1)</div>
                                    <div class="small-text" style="margin-top: 3px; margin-right: 12px;">– الرسوم و الأحكـــام المذكـــورة في المقـــالة أو الوثيقة الموضــعة مـــع هــــذا الطلب</div>
                                    <div style="margin-top: 3px; font-size: 8.5pt; margin-right: 12px;">– الإجراءات الآتية : (9)</div>
                                </div>
                            </td>
                            <td style="width: 30%; font-size: 7pt; line-height: 1.2; padding: 3px; vertical-align: top;">
                                <p style="margin: 0 0 2px 0;">(1) يشطب عند الاقتضاء</p>
                                <p style="margin: 0 0 2px 0;">(2) استوفى مهنة الطالب</p>
                                <p style="margin: 0 0 2px 0;">(3) العنوان الكامل</p>
                                <p style="margin: 3px 0 2px 0;">(4) إذا أراد الطالب التحصيل من نقلة خامسة نوثائق يلزم أن يعوض كاملة مستخرج بـــة نقلة .</p>
                                <p style="margin: 3px 0 2px 0;">(5) يضع علامة على الخريطة المعنية</p>
                                <p style="margin: 0;">(9) يبين نوعها ( تسجيل حجز ـالشهار ـ تاريخ ـ حجم وعدد</p>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <div class="section-title" style="font-size: 10pt;">معـــلـومـات أخـــرى مطلــــوبـــة</div>
                                <div style="padding: 5px; text-align: center; font-weight: bold; font-size: 9pt;">* طلب خارج الإجراء</div>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td style="width: 28%;">
                                <div class="section-title" style="font-size: 9pt;">طلب غير قيــــاسي</div>
                                <div style="padding: 5px; font-size: 8.5pt;">
                                    <div style="margin-bottom: 3px; font-weight: bold;">وضع مرفوض نيتة</div>
                                    <div style="margin-bottom: 2px;"><span class="checkbox"></span> عدم استعمال الأنية في حالة</div>
                                    <div style="margin-bottom: 2px;"><span class="checkbox"></span> عدم إقامة نسخة ثانية</div>
                                    <div style="margin-bottom: 2px;"><span class="checkbox"></span> بيان غير كامل بالأطـــراف</div>
                                    <div style="margin-bottom: 2px;"><span class="checkbox"></span> بيان غير كامل للعقارات</div>
                                    <div style="margin-bottom: 2px;"><span class="checkbox"></span> عدم الدفع على الحساب</div>
                                    <div><span class="checkbox"></span> الأنيــــــة</div>
                                </div>
                            </td>
                            <td style="width: 42%;">
                                <div style="padding: 5px; font-size: 8.5pt;">
                                    <div style="margin-bottom: 8px;">أودع مبلغا قدره <input type="text" name="pos_amount" class="inline-input" style="width: 60px;"> دج و أتعهد بأداء ما يفي من</div>
                                    <div>المصاريف عند الاقتضاء بعد تسليم المعلومات .</div>
                                </div>
                            </td>
                            <td style="width: 30%;">
                                <div style="padding: 5px; text-align: center;">
                                    <div style="font-weight: bold; font-size: 10pt; margin-bottom: 12px;">فــــــــــــي</div>
                                    <input type="text" name="pos_place_date" style="width: 90%; text-align: center; margin-bottom: 15px; font-size: 9pt;">
                                    <div style="font-weight: bold; font-size: 10pt; margin-bottom: 6px;">إمضـــاء الطــــلب:</div>
                                    <div style="height: 35px; border-bottom: 1.5px solid black; margin-top: 3px;"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div> <!-- fin première page positive -->

                <!-- الوجه الثاني (الإيجابية) - حسب الصورة -->
                <div class="document-page">
                    <table>
                        <tr>
                            <td style="width: 45%; vertical-align: top;">
                                <table style="margin-bottom: 3px;">
                                    <tr><td class="section-title" style="font-size: 9pt; padding: 4px;">بيـــــــــان ســـــــــند المديــــــــن و (مساحـــــة الإقتنيـــــــاء) (1)</td></tr>
                                    <tr><td style="height: 45px; padding: 4px;"><textarea name="pos_debtor_deed" rows="2"></textarea></td></tr>
                                </table>
                                <table style="margin-bottom: 3px;">
                                    <tr><td class="section-title" style="font-size: 9pt; padding: 4px;">هـــــــــويــــــة الأشـــــخـــــاص النــاشــىء عنها المعلومــــــات المطلــــــــوبة (2)</td></tr>
                                    <tr><td style="height: 45px; padding: 4px;"><textarea name="pos_persons_identity" rows="2"></textarea></td></tr>
                                </table>
                                <table>
                                    <tr><td colspan="5" class="section-title" style="font-size: 9pt; padding: 4px;">بيـــــــــان فـــــــــــردى للعقـــــــــــــارت (3)</td></tr>
                                    <tr style="font-size: 7.5pt;">
                                        <th rowspan="2" style="width: 12%;">قطعة</th>
                                        <th colspan="2" style="width: 40%;">للعقار الريفي<br>نهج و رقــم<br>أو المكــان المجــاورون</th>
                                        <th colspan="2" style="width: 48%;">مراجع الأراضي</th>
                                    </tr>
                                    <tr style="font-size: 7pt;">
                                        <th>عدد</th>
                                        <th>مساحة</th>
                                        <th style="width: 20%;">القسم<br>أو المكان المذكور</th>
                                        <th style="width: 28%;">ببلديـــــة<br>بدرج هــذا</th>
                                    </tr>
                                    @for($i = 0; $i < 6; $i++)
                                    <tr>
                                        <td><input type="text" name="pos_prop{{ $i }}_piece"></td>
                                        <td><input type="text" name="pos_prop{{ $i }}_num"></td>
                                        <td><input type="text" name="pos_prop{{ $i }}_area"></td>
                                        <td><input type="text" name="pos_prop{{ $i }}_section"></td>
                                        <td><input type="text" name="pos_prop{{ $i }}_municipality"></td>
                                    </tr>
                                    @endfor
                                    <tr><td colspan="5" class="small-text" style="padding: 4px;">تستعمل ورقة ملحقة أو اكثر (أوراق مطبوعة عدد 4 م ع) إذا كانت الجداول أعــــــلاه غــــــير كافيــــــة ، يعين عددها في داخل هذه التربيعة <input type="text" name="pos_additional" style="width: 40px; border: 1px solid #000;"></td></tr>
                                </table>
                            </td>
                            <td style="width: 55%; vertical-align: top;">
                                <table style="margin-bottom: 3px;">
                                    <tr><td class="section-title" style="font-size: 11pt; padding: 4px;">شهــــــــادة للمحافـــــــظ</td></tr>
                                    <tr><td style="font-size: 9pt; padding: 6px; line-height: 1.4;">إن المحافــظ العقاري الممضى أسفلــه يشـهـــد بأن المعلومات المذكورة أعلاه مطابقة للقيود الموجودة في وثائقه، و لا توجد أي إجراءات أخرى غير المذكورة أسفله.</td></tr>
                                </table>
                                <table style="margin-top: 3px;">
                                    <tr>
                                        <td colspan="3" class="section-title" style="font-size: 9pt;">إجـــــــــــراءات</td>
                                        <td colspan="4" class="section-title" style="font-size: 9pt;">حقوق مسجلة أو مشهورة<br><span style="font-size: 7.5pt;">سند المدين أو القرينة القانونية</span></td>
                                    </tr>
                                    <tr style="font-size: 8pt;">
                                        <th style="width: 10%;">نوع</th>
                                        <th style="width: 11%;">تاريخ</th>
                                        <th style="width: 11%;">حجم و رقم</th>
                                        <th style="width: 10%;">نوع</th>
                                        <th style="width: 11%;">تاريخ</th>
                                        <th style="width: 11%;">المعني</th>
                                        <th style="width: 18%;">معلومات أخرى</th>
                                    </tr>
                                    @for($i = 1; $i <= 8; $i++)
                                    <tr>
                                        <td><input type="text" name="pos_proc{{ $i }}_type"></td>
                                        <td><input type="text" name="pos_proc{{ $i }}_date"></td>
                                        <td><input type="text" name="pos_proc{{ $i }}_vol_num"></td>
                                        <td><input type="text" name="pos_right{{ $i }}_type"></td>
                                        <td><input type="text" name="pos_right{{ $i }}_date"></td>
                                        <td><input type="text" name="pos_right{{ $i }}_concerned"></td>
                                        @if($i == 1)
                                        <td rowspan="8" style="vertical-align: top; padding: 3px;"><textarea name="pos_other_info" style="height: 100%; min-height: 150px;"></textarea></td>
                                        @endif
                                    </tr>
                                    @endfor
                                </table>
                                <table style="margin-top: 3px;">
                                    <tr style="font-size: 8pt;">
                                        <td colspan="2" style="text-align: center; padding: 5px;">يصدق عن<br>المحافظ<br>لـ أساطير</td>
                                        <td colspan="2" style="text-align: center; padding: 5px;">كلمــــة</td>
                                        <td style="text-align: center; padding: 5px;">فـــى:<br>المحافظة</td>
                                        <td style="text-align: center; padding: 5px;">رقــم بالدفتر</td>
                                        <td style="text-align: center; padding: 5px;">أرقـام</td>
                                    </tr>
                                </table>
                                <table style="margin-top: 3px;">
                                    <tr><td class="small-text" style="padding: 4px; line-height: 1.15;">
                                        <p style="margin: 0 0 2px 0;">(1) نوع و تاريخ و اسم الأطراف</p>
                                        <p style="margin: 0 0 2px 0;">(2) يذكر لزوما فيما يخص الأشخاص الطبيعية الإسم و الألقاب وتاريخ ومكان الولادة</p>
                                        <p style="margin: 0 0 2px 0;">(3) تبرأ مسؤولية المحافظ عند وجود أية غلطة في بيان العقارات</p>
                                        <p style="margin: 0;">(4) لا يسلم مستخرجا و لا نسخة فيما يخص المعلومات المذكورة</p>
                                    </td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div> <!-- fin deuxième page positive -->
            </div> <!-- pages-container positive -->
        </div> <!-- certificate-wrapper positive -->

    </div> <!-- main-container -->

    <input type="hidden" name="certificate_type" id="cert_type_input" value="negative">
</form>

<script>
    function showCertificate(type) {
        document.querySelectorAll('.certificate-wrapper').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.cert-btn').forEach(el => el.classList.remove('active'));
        document.getElementById(type + '-cert').classList.add('active');
        event.target.closest('.cert-btn').classList.add('active');
        document.getElementById('cert_type_input').value = type;
    }

    // استرجاع القيم المحفوظة في localStorage
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        const key = 'cert_{{ $certificate->id }}_' + input.name;
        const saved = localStorage.getItem(key);
        if (saved && input.type !== 'hidden') input.value = saved;
        input.addEventListener('input', () => {
            if (input.name) localStorage.setItem(key, input.value);
        });
    });

    // عند حفظ النموذج، نقوم بحذف البيانات المحفوظة بعد الإرسال
    document.getElementById('mainForm').addEventListener('submit', () => {
        setTimeout(() => {
            inputs.forEach(input => {
                if (input.name) localStorage.removeItem('cert_{{ $certificate->id }}_' + input.name);
            });
        }, 1000);
    });
</script>

</body>
</html>