
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>

    <!-- استدعاء CSS الخاص بالإدارة -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white h-screen shadow-md fixed top-0 right-0">
        <div class="p-6 text-center border-b">
            <h1 class="text-xl font-bold text-gray-700">لوحة التحكم</h1>
        </div>
<nav class="mt-4">
    <a href="/admin/dashboard" class="block px-6 py-3 hover:bg-gray-200">🏠 الرئيسية</a>
    <a href="/admin/users" class="block px-6 py-3 hover:bg-gray-200">👤 إدارة المستخدمين</a>
    <a href="/admin/messages" class="block px-6 py-3 hover:bg-gray-200">📩 الرسائل</a>
    <a href="/admin/appointments" class="block px-6 py-3 hover:bg-gray-200">📅 المواعيد</a>
    <a href="/admin/certificates" class="block px-6 py-3 hover:bg-gray-200">📄 الشهادات</a>

    <!-- ✨ الصفحات الجديدة -->
    <a href="/admin/negative-requests" class="block px-6 py-3 hover:bg-gray-200">📝 طلبات الشهادة السلبية</a>
    <a href="/admin/document-requests" class="block px-6 py-3 hover:bg-gray-200">📚 طلبات استخراج الوثائق العقارية</a>
    <a href="/admin/payment-requests" class="block px-6 py-3 hover:bg-gray-200">💳 طلبات الدفع الإلكتروني</a>
    <a href="/admin/topographic-requests" class="block px-6 py-3 hover:bg-gray-200">🗺 استخراج الوثائق المسحية</a>

    <a href="/admin/add-data" class="block px-6 py-3 hover:bg-gray-200">➕ إضافة بيانات</a>
    <a href="/admin/view-data" class="block px-6 py-3 hover:bg-gray-200">🗂 عرض البيانات</a>
    <a href="/admin/settings" class="block px-6 py-3 hover:bg-gray-200">⚙️ الإعدادات</a>
    <a href="/admin/change-password" class="block px-6 py-3 hover:bg-gray-200">🔐 تغيير كلمة المرور</a>

    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button class="w-full text-right px-6 py-3 text-red-600 hover:bg-red-100">
            🚪 تسجيل الخروج
        </button>
    </form>
</nav>

    </aside>

    <!-- Main Content -->
    <main class="mr-64 w-full p-6">
        @yield('content')
    </main>

</div>

</body>
</html>
