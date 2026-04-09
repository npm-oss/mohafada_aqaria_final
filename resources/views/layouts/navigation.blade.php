<nav class="navbar">
    <div class="logo">المحافظة العقارية</div>

    <ul class="nav-links">

        <li>
            <a href="{{ route('home') }}">الرئيسية</a>
        </li>

        {{-- شهادة سلبية --}}
        <li class="dropdown negative-dropdown">
            <a href="javascript:void(0)" onclick="toggleNegativeMenu()">
                طلب شهادة سلبية ▾
            </a>

            <ul class="dropdown-menu" id="negativeMenu">
                <li>
                    <a href="{{ route('negative.new') }}">➕ طلب جديد</a>
                </li>
                <li>
                    <a href="{{ route('negative.reprint') }}">🔁 إعادة استخراج</a>
                </li>
            </ul>
        </li>

        {{-- استخراج نسخة من الوثائق العقارية --}}
        <li class="dropdown extract-dropdown">
            <a href="javascript:void(0)" onclick="toggleExtractMenu()">
                📄 طلب نسخة من الوثائق العقارية ▾
            </a>

            <ul class="dropdown-menu" id="extractMenu">

                {{-- البطاقات العقارية --}}
                <li class="submenu">
                    <a href="javascript:void(0)" onclick="toggleCardsMenu(event)">
                        ▶ البطاقات الشخصية والابجدية
                    </a>

                    <ul class="submenu-menu" id="cardsMenu">
                        <li>
                            ✅ <a href="{{ route('card.natural') }}">شخص طبيعي</a>
                        </li>
                        <li>
                            ✅ <a href="{{ route('card.moral') }}">شخص معنوي</a>
                        </li>
                    </ul>
                </li>

                {{-- مستخرجات العقود --}}
                <li>
                  <a href="/contracts/extracts">

                        مستخرجات العقود
                    </a>
                </li>

            </ul>
        </li>

        <li>
            <a href="{{ route('login') }}">تسجيل الدخول</a>
        </li>

    </ul>
</nav>
