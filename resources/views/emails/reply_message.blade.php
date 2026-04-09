<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>رد على رسالتك</title>

<style>
body{
    font-family: Cairo, Tahoma, sans-serif;
    background:#f4f4f4;
    margin:0;
    padding:20px;
    line-height:1.6;
}

.email-container{
    max-width:600px;
    margin:auto;
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.1);
    border:1px solid #e0e0e0;
}

.header{
    background:linear-gradient(135deg,#1a5632,#2d7a4f);
    color:white;
    padding:30px;
    text-align:center;
}

.content{
    padding:30px 25px;
}

.greeting{
    font-size:20px;
    font-weight:bold;
    color:#1a5632;
    border-bottom:3px solid #c49b63;
    padding-bottom:15px;
    margin-bottom:25px;
}

.box{
    background:#f8f9fa;
    border-right:5px solid #c49b63;
    padding:20px;
    border-radius:12px;
    margin-bottom:25px;
}

.reply-box{
    background:#e8f4fd;
    border-right:5px solid #17a2b8;
    padding:20px;
    border-radius:12px;
    margin-bottom:25px;
}

.btn{
    display:inline-block;
    background:linear-gradient(135deg,#1a5632,#2d7a4f);
    color:white !important;
    text-decoration:none;
    padding:14px 30px;
    border-radius:50px;
    font-weight:bold;
    margin-top:20px;
}
</style>

</head>

<body>

<div class="email-container">

<div class="header">
<h2>📧 المحافظة العقارية</h2>
<p>رد على استفسارك</p>
</div>

<div class="content">

<div class="greeting">
السلام عليكم ورحمة الله وبركاته
</div>

<!-- معلومات المرسل -->
<div class="box">
<table width="100%">
<tr>
<td><strong>إلى:</strong></td>
<td>{{ $userMessage->name ?? 'عميلنا العزيز' }}</td>
</tr>

<tr>
<td><strong>البريد:</strong></td>
<td>{{ $userMessage->email ?? '' }}</td>
</tr>

<tr>
<td><strong>الموضوع:</strong></td>
<td>{{ $userMessage->subject ?? 'استفسار' }}</td>
</tr>

<tr>
<td><strong>التاريخ:</strong></td>
<td>{{ now()->format('Y/m/d H:i') }}</td>
</tr>
</table>
</div>

<!-- الرسالة الأصلية -->
@if(!empty($userMessage->message))
<div class="box">
<strong>📨 الرسالة الأصلية:</strong>
<p style="white-space:pre-wrap;">
{{ $userMessage->message }}
</p>
</div>
@endif

<!-- رد الإدارة -->
<div class="reply-box">
<strong>💬 رد الإدارة:</strong>

<p style="white-space:pre-wrap;">
{{ $adminMessage ?? 'نشكرك على تواصلك معنا، سيتم الرد قريباً.' }}
</p>
</div>

<div style="text-align:center;">
<a href="mailto:{{ config('mail.from.address') }}" class="btn">
📝 الرد على البريد
</a>
</div>

<div style="margin-top:30px;color:#555;font-size:15px;">
<p>شكراً لتواصلك معنا.</p>
<p>يمكنك الرد مباشرة على هذا البريد الإلكتروني.</p>
</div>

</div>

<div style="background:#f8f6f1;padding:25px;text-align:center;color:#7f8c8d;font-size:14px;border-top:3px solid #c49b63;">
© {{ date('Y') }} جميع الحقوق محفوظة
</div>

</div>

</body>
</html>