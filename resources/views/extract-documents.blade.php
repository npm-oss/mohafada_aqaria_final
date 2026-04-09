@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-8">

    <!-- العنوان -->
    <h1 class="text-2xl font-bold text-center text-green-800 mb-6">
        اس نسخة من الوثائق العقارية
    </h1>

    <!-- زر رئيسي -->
    <div class="relative">

        <button onclick="toggleMainMenu()"
            class="w-full flex justify-between items-center bg-green-700 text-white px-6 py-4 rounded-lg font-bold">
            📄 طلب نسخة من الوثائق 
            <span>▾</span>
        </button>

        <!-- القائمة الرئيسية -->
        <div id="mainMenu"
             class="hidden mt-4 border rounded-lg overflow-hidden bg-white">

            <!-- البطاقات العقارية -->
            <button onclick="toggleCardsMenu()"
                class="w-full flex justify-between items-center px-6 py-4 font-semibold hover:bg-gray-100">
                ▶ البطاقات العقارية
            </button>

            <div id="cardsMenu" class="hidden bg-gray-50 border-t">
                <a href="#" class="block px-10 py-3 hover:bg-blue-50">
                    البطاقة الشخصية
                </a>
                <a href="#" class="block px-10 py-3 hover:bg-blue-50">
                    البطاقة الأجدية
                </a>
                <a href="#" class="block px-10 py-3 hover:bg-blue-50">
                    البطاقةالحضاريةالخاصة
                </a>
            </div>
            <a href="#" class="block px-10 py-3 hover:bg-blue-50">
                    البطاقة الريفية
                </a>
            </div>

            <!-- مستخرجات العقود -->
            <button onclick="toggleContractsMenu()"
                class="w-full flex justify-between items-center px-6 py-4 font-semibold hover:bg-gray-100 border-t">
                ▶ مستخرجات العقود
            </button>

            <div id="contractsMenu" class="hidden bg-gray-50 border-t">
                <a href="#" class="block px-10 py-3 hover:bg-green-50">
                    مستخرج عقد بيع
                </a>
                <a href="#" class="block px-10 py-3 hover:bg-green-50">
                    مستخرج عقد ملكية
                </a>
                <a href="#" class="block px-10 py-3 hover:bg-green-50">
                    مستخرج عقد رهن
                </a>
            </div>

        </div>
    </div>

</div>

<!-- JavaScript -->
<script>
function toggleMainMenu() {
    document.getElementById('mainMenu').classList.toggle('hidden');

    // نسكر القوائم الفرعية
    document.getElementById('cardsMenu').classList.add('hidden');
    document.getElementById('contractsMenu').classList.add('hidden');
}

function toggleCardsMenu() {
    document.getElementById('cardsMenu').classList.toggle('hidden');
    document.getElementById('contractsMenu').classList.add('hidden');
}

function toggleContractsMenu() {
    document.getElementById('contractsMenu').classList.toggle('hidden');
    document.getElementById('cardsMenu').classList.add('hidden');
}
</script>

@endsection
