<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>من نحن - المحافظة العقارية أولاد جلال</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1a5632;
            --primary-dark: #0d3d20;
            --secondary: #c49b63;
            --accent: #8b6f47;
            --bg-light: #f8f6f1;
            --text-dark: #2d2d2d;
            --text-light: #6b6b6b;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.8;
            overflow-x: hidden;
        }

        /* ========== NAVBAR ========== */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 30px rgba(26, 86, 50, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-family: 'Amiri', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            box-shadow: 0 4px 15px rgba(26, 86, 50, 0.2);
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            padding: 0.7rem 1.2rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
            background: rgba(26, 86, 50, 0.05);
        }

        .btn-login {
            background: var(--primary);
            color: white !important;
            padding: 0.7rem 1.8rem !important;
            border-radius: 25px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(26, 86, 50, 0.3);
        }

        /* ========== PAGE HEADER ========== */
        .page-header {
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            position: relative;
            overflow: hidden;
            margin-top: 80px;
        }

        .page-header::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: radial-gradient(circle at 20% 30%, rgba(196, 155, 99, 0.15) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(50px, 30px) rotate(5deg); }
        }

        .page-header-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 2rem;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-header h1 {
            font-family: 'Amiri', serif;
            font-size: 4rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
        }

        .page-header p {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
        }

        /* ========== ABOUT SECTION ========== */
        .about-section {
            padding: 6rem 2rem;
            background: white;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            margin-bottom: 4rem;
        }

        .about-image {
            position: relative;
        }

        .animated-illustration {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            animation: zoomInOut 4s ease-in-out infinite;
        }

        @keyframes zoomInOut {
            0%, 100% {
                transform: scale(1) rotate(0deg);
            }
            50% {
                transform: scale(1.1) rotate(2deg);
            }
        }

        .about-content h2 {
            font-family: 'Amiri', serif;
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .about-content p {
            font-size: 1.15rem;
            color: var(--text-light);
            line-height: 1.9;
            margin-bottom: 1.5rem;
        }

        /* ========== MISSION & VISION ========== */
        .mission-vision {
            padding: 6rem 2rem;
            background: var(--bg-light);
        }

        .mv-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 3rem;
        }

        .mv-card {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .mv-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .mv-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(26, 86, 50, 0.15);
        }

        .mv-card:hover::before {
            transform: scaleX(1);
        }

        .mv-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 2rem;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .mv-card h3 {
            font-family: 'Amiri', serif;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .mv-card p {
            font-size: 1.1rem;
            color: var(--text-light);
            line-height: 1.9;
        }

        /* ========== VALUES ========== */
        .values {
            padding: 6rem 2rem;
            background: white;
        }

        .section-title {
            font-family: 'Amiri', serif;
            font-size: 3rem;
            color: var(--primary);
            text-align: center;
            margin-bottom: 3rem;
            font-weight: 700;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .value-card {
            background: var(--bg-light);
            padding: 2.5rem;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .value-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .value-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: rotate 3s ease-in-out infinite;
        }

        @keyframes rotate {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(10deg); }
        }

        .value-card h4 {
            font-family: 'Amiri', serif;
            font-size: 1.4rem;
            color: var(--primary);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .value-card p {
            color: var(--text-light);
            font-size: 1.05rem;
        }

        /* ========== TEAM ========== */
        .team {
            padding: 6rem 2rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            text-align: center;
        }

        .team h2 {
            font-family: 'Amiri', serif;
            font-size: 3rem;
            color: white;
            margin-bottom: 1.5rem;
        }

        .team p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            max-width: 800px;
            margin: 0 auto 3rem;
        }

        .team-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            max-width: 1000px;
            margin: 0 auto;
        }

        .stat-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-number {
            font-family: 'Amiri', serif;
            font-size: 3rem;
            font-weight: 700;
            color: var(--secondary);
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: white;
            font-size: 1.1rem;
        }

        /* ========== CTA ========== */
        .cta {
            padding: 6rem 2rem;
            background: white;
            text-align: center;
        }

        .cta h2 {
            font-family: 'Amiri', serif;
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .cta p {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 2.5rem;
        }

        .btn {
            padding: 1rem 2.5rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 6px 25px rgba(26, 86, 50, 0.3);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 35px rgba(26, 86, 50, 0.4);
        }

        /* ========== FOOTER ========== */
        .footer {
            background: var(--primary-dark);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .footer p {
            color: rgba(255, 255, 255, 0.7);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 968px) {
            .nav-links {
                display: none;
            }

            .page-header h1 {
                font-size: 2.5rem;
            }

            .about-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .section-title {
                font-size: 2rem;
            }
        }

        /* ========== SCROLL REVEAL ========== */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .scroll-reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">
                <div class="logo-icon">🏛️</div>
                <span>المحافظة العقارية</span>
            </a>

            <ul class="nav-links">
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('about') }}">من نحن</a></li>
                <li><a href="{{ route('contact') }}">اتصل بنا</a></li>
                <li><a href="{{ route('login') }}" class="btn-login">تسجيل الدخول</a></li>
            </ul>
        </div>
    </nav>

    <!-- PAGE HEADER -->
    <section class="page-header">
        <div class="page-header-content">
            <h1>من نحن</h1>
            <p>تعرف على المحافظة العقارية أولاد جلال</p>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section class="about-section">
        <div class="container">
            <div class="about-grid scroll-reveal">
                <div class="about-image">
                    <svg class="animated-illustration" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                        <!-- Building -->
                        <rect x="150" y="150" width="200" height="250" fill="#1a5632" rx="10"/>
                        
                        <!-- Windows Row 1 -->
                        <rect x="170" y="180" width="50" height="50" fill="#c49b63" rx="5"/>
                        <rect x="240" y="180" width="50" height="50" fill="#c49b63" rx="5"/>
                        
                        <!-- Windows Row 2 -->
                        <rect x="170" y="250" width="50" height="50" fill="#c49b63" rx="5"/>
                        <rect x="240" y="250" width="50" height="50" fill="#c49b63" rx="5"/>
                        
                        <!-- Windows Row 3 -->
                        <rect x="170" y="320" width="50" height="50" fill="#c49b63" rx="5"/>
                        <rect x="240" y="320" width="50" height="50" fill="#c49b63" rx="5"/>
                        
                        <!-- Door -->
                        <rect x="205" y="340" width="90" height="60" fill="#8b6f47" rx="5"/>
                        
                        <!-- Roof -->
                        <polygon points="250,100 120,150 380,150" fill="#0d3d20"/>
                        
                        <!-- Flag with Animation -->
                        <line x1="250" y1="100" x2="250" y2="50" stroke="#c49b63" stroke-width="4"/>
                        <polygon points="250,50 310,70 250,90" fill="#c49b63">
                            <animateTransform
                                attributeName="transform"
                                type="rotate"
                                from="0 250 70"
                                to="15 250 70"
                                dur="1.5s"
                                repeatCount="indefinite"
                                values="0 250 70; 15 250 70; 0 250 70"
                            />
                        </polygon>
                        
                        <!-- Ground -->
                        <rect x="0" y="400" width="500" height="100" fill="#f8f6f1"/>
                    </svg>
                </div>

                <div class="about-content">
                    <h2>المحافظة العقارية أولاد جلال</h2>
                    <p>
                        المحافظة العقارية أولاد جلال هي مؤسسة حكومية متخصصة في إدارة السجل العقاري وحماية الملكية العقارية في منطقة أولاد جلال.
                    </p>
                    <p>
                        تأسست المحافظة لتكون الجهة المرجعية الرسمية لكافة المعاملات العقارية، حيث نعمل على توثيق وحفظ حقوق الملكية بما يضمن الشفافية والعدالة لجميع المواطنين.
                    </p>
                    <p>
                        نسعى لتقديم خدمات عقارية متطورة من خلال نظام إلكتروني حديث يسهل الإجراءات ويوفر الوقت والجهد على المواطنين.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- MISSION & VISION -->
    <section class="mission-vision">
        <div class="container">
            <div class="mv-grid">
                <div class="mv-card scroll-reveal">
                    <div class="mv-icon">🎯</div>
                    <h3>رسالتنا</h3>
                    <p>
                        حماية الحقوق العقارية وتنظيم الملكية العقارية من خلال نظام سجل عقاري دقيق وموثوق، وتقديم خدمات إلكترونية متميزة تسهل على المواطنين إتمام معاملاتهم بكل يسر وشفافية.
                    </p>
                </div>

                <div class="mv-card scroll-reveal">
                    <div class="mv-icon">👁️</div>
                    <h3>رؤيتنا</h3>
                    <p>
                        أن نكون المؤسسة الرائدة في الخدمات العقارية على مستوى الوطن، ونموذجاً في التحول الرقمي والحوكمة الإلكترونية، مع ضمان أعلى معايير الجودة والشفافية والكفاءة.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- VALUES -->
    <section class="values">
        <div class="container">
            <h2 class="section-title scroll-reveal">قيمنا</h2>

            <div class="values-grid">
                <div class="value-card scroll-reveal">
                    <div class="value-icon">🛡️</div>
                    <h4>الأمانة والمصداقية</h4>
                    <p>نحافظ على ثقة المواطنين من خلال الدقة والشفافية</p>
                </div>

                <div class="value-card scroll-reveal">
                    <div class="value-icon">⚖️</div>
                    <h4>العدالة والنزاهة</h4>
                    <p>نطبق القانون بعدالة ونزاهة على الجميع دون تمييز</p>
                </div>

                <div class="value-card scroll-reveal">
                    <div class="value-icon">🚀</div>
                    <h4>الابتكار والتطوير</h4>
                    <p>نسعى للتحديث المستمر وتبني أحدث التقنيات</p>
                </div>

                <div class="value-card scroll-reveal">
                    <div class="value-icon">🤝</div>
                    <h4>خدمة المواطن</h4>
                    <p>المواطن هو محور اهتمامنا ونعمل على تسهيل إجراءاته</p>
                </div>

                <div class="value-card scroll-reveal">
                    <div class="value-icon">📊</div>
                    <h4>الاحترافية والكفاءة</h4>
                    <p>نقدم خدماتنا بأعلى معايير الجودة والاحترافية</p>
                </div>

                <div class="value-card scroll-reveal">
                    <div class="value-icon">🔒</div>
                    <h4>الأمن والسرية</h4>
                    <p>نحمي بيانات المواطنين ونضمن سريتها التامة</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TEAM -->
    <section class="team">
        <div class="container">
            <h2>فريق العمل</h2>
            <p>
                نفخر بفريق عمل متخصص ومحترف يعمل بجد لخدمة المواطنين وتقديم أفضل الخدمات العقارية
            </p>

            <div class="team-stats">
                <div class="stat-box scroll-reveal">
                    <span class="stat-number">50+</span>
                    <span class="stat-label">موظف متخصص</span>
                </div>

                <div class="stat-box scroll-reveal">
                    <span class="stat-number">15+</span>
                    <span class="stat-label">سنة خبرة</span>
                </div>

                <div class="stat-box scroll-reveal">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">دعم فني</span>
                </div>

                <div class="stat-box scroll-reveal">
                    <span class="stat-number">100%</span>
                    <span class="stat-label">التزام بالجودة</span>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="container scroll-reveal">
            <h2>هل لديك استفسار؟</h2>
            <p>فريقنا جاهز للإجابة على جميع أسئلتك ومساعدتك</p>
            <a href="{{ route('contact') }}" class="btn btn-primary">
                📞 اتصل بنا الآن
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>© 2025 المحافظة العقارية أولاد جلال - جميع الحقوق محفوظة</p>
        </div>
    </footer>

    <script>
        // Scroll reveal animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.scroll-reveal').forEach(element => {
            observer.observe(element);
        });
    </script>

</body>
</html>