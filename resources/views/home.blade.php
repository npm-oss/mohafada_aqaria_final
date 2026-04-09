<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ setting('site_name', 'المحافظة العقارية - أولاد جلال') }}</title>
    <meta name="description" content="{{ setting('site_description', 'نظام متكامل لإدارة الأراضي') }}">
    <meta name="keywords" content="{{ setting('site_keywords', 'محافظة عقارية') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: {{ setting('primary_color', '#1a5632') }};
            --primary-dark: #0d3d20;
            --primary-light: #2d7a4d;
            --secondary: {{ setting('secondary_color', '#c9a063') }};
            --accent: #8b6f47;
            --gold: #ffd700;
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

        .navbar.scrolled {
            padding: 0.3rem 0;
            box-shadow: 0 4px 40px rgba(26, 86, 50, 0.15);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0.8rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-family: 'Amiri', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 4px 15px rgba(26, 86, 50, 0.2);
            animation: logo-pulse 3s ease-in-out infinite;
        }

        @keyframes logo-pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 4px 15px rgba(26, 86, 50, 0.2); }
            50% { transform: scale(1.1); box-shadow: 0 8px 30px rgba(26, 86, 50, 0.4); }
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 0.3rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            padding: 0.6rem 1rem;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-links a::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: var(--primary);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.4s, height 0.4s;
            z-index: -1;
        }

        .nav-links a:hover::before {
            width: 100px;
            height: 100px;
        }

        .nav-links a:hover {
            color: white;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            min-width: 280px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-20px) rotateX(-15deg);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            margin-top: 0.5rem;
            padding: 1rem;
            border: 2px solid transparent;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) rotateX(0);
            border-color: var(--secondary);
        }

        .dropdown-menu li {
            list-style: none;
            margin-bottom: 0.5rem;
        }

        .dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.9rem 1rem;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .dropdown-menu a:hover {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            transform: translateX(-10px);
        }

        .dropdown-submenu {
            position: absolute;
            right: 100%;
            top: 0;
            background: white;
            min-width: 250px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateX(20px);
            transition: all 0.4s ease;
            margin-right: 0.5rem;
            padding: 1rem;
        }

        .dropdown-sub:hover .dropdown-submenu {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white !important;
            padding: 0.6rem 1.5rem !important;
            border-radius: 25px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(26, 86, 50, 0.3);
            animation: btn-glow 2s ease-in-out infinite;
        }

        @keyframes btn-glow {
            0%, 100% { box-shadow: 0 4px 15px rgba(26, 86, 50, 0.3); }
            50% { box-shadow: 0 8px 30px rgba(26, 86, 50, 0.6); }
        }

        /* ========== HERO ========== */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            background: linear-gradient(135deg, #0d3d20 0%, #1a5632 50%, #2d7a4d 100%);
            overflow: hidden;
            margin-top: 70px;
        }

        .circles-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            border: 2px solid rgba(201, 160, 99, 0.3);
            animation: circle-float 20s ease-in-out infinite;
        }

        .circle:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            background: rgba(201, 160, 99, 0.1);
            animation-delay: 0s;
        }

        .circle:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            left: 5%;
            border-color: rgba(255, 215, 0, 0.4);
            animation-delay: 2s;
        }

        .circle:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 20%;
            background: rgba(255, 255, 255, 0.1);
            animation-delay: 4s;
        }

        .circle:nth-child(4) {
            width: 200px;
            height: 200px;
            top: 10%;
            right: 10%;
            border-color: rgba(201, 160, 99, 0.2);
            animation-delay: 1s;
        }

        .circle:nth-child(5) {
            width: 150px;
            height: 150px;
            top: 50%;
            right: 5%;
            background: rgba(201, 160, 99, 0.05);
            animation-delay: 3s;
        }

        .circle:nth-child(6) {
            width: 100px;
            height: 100px;
            bottom: 20%;
            right: 15%;
            border-color: rgba(255, 215, 0, 0.3);
            animation-delay: 5s;
        }

        .circle:nth-child(7) {
            width: 180px;
            height: 180px;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-color: rgba(255, 255, 255, 0.1);
            animation: circle-pulse 4s ease-in-out infinite;
        }

        .circle:nth-child(8) {
            width: 300px;
            height: 300px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 3px dashed rgba(201, 160, 99, 0.2);
            animation: circle-rotate 30s linear infinite;
        }

        .circle:nth-child(9) {
            width: 400px;
            height: 400px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 2px dotted rgba(255, 215, 0, 0.15);
            animation: circle-rotate 40s linear infinite reverse;
        }

        @keyframes circle-float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -30px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(20px, 30px) scale(1.05); }
        }

        @keyframes circle-pulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; }
            50% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.8; }
        }

        @keyframes circle-rotate {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 8px;
            height: 8px;
            background: var(--gold);
            border-radius: 50%;
            opacity: 0;
            animation: particle-float 15s linear infinite;
            box-shadow: 0 0 20px var(--gold);
        }

        @keyframes particle-float {
            0% { 
                opacity: 0;
                transform: translateY(100vh) translateX(0) scale(0);
            }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { 
                opacity: 0;
                transform: translateY(-100vh) translateX(100px) scale(1.5);
            }
        }

        .hero-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 2rem;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 5rem;
            align-items: center;
            position: relative;
            z-index: 10;
        }

        .hero-content {
            animation: fadeInRight 1.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(-80px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 2.5rem;
            border: 2px solid rgba(255, 255, 255, 0.25);
            animation: badge-pulse 3s ease-in-out infinite;
        }

        @keyframes badge-pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(201, 160, 99, 0.7); }
            50% { box-shadow: 0 0 0 20px rgba(201, 160, 99, 0); }
        }

        .hero h1 {
            font-family: 'Amiri', serif;
            font-size: 4.5rem;
            font-weight: 900;
            color: white;
            margin-bottom: 2rem;
            line-height: 1.2;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .hero p {
            font-size: 1.4rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 3rem;
            line-height: 2;
        }

        .hero-buttons {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1.3rem 3rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 400px;
            height: 400px;
        }

      .btn-primary {
    background: linear-gradient(135deg, var(--gold), #e5c78f);
    color: var(--primary-dark);
    box-shadow: 0 10px 35px rgba(255, 215, 0, 0.4);
    animation: btn-float 3s ease-in-out infinite;
}

        @keyframes btn-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .btn-primary:hover {
            transform: translateY(-15px) scale(1.05);
            box-shadow: 0 20px 50px rgba(26, 86, 50, 0.6);
            animation: none;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            color: white;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: white;
            color: var(--primary);
            border-color: white;
            transform: translateY(-5px);
        }

        .hero-visual {
            position: relative;
            animation: fadeInLeft 1.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(80px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .orbit-container {
            position: relative;
            width: 500px;
            height: 500px;
            margin: 0 auto;
        }

        .orbit-ring {
            position: absolute;
            border-radius: 50%;
            border: 2px solid rgba(201, 160, 99, 0.3);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .orbit-ring:nth-child(1) {
            width: 300px;
            height: 300px;
            animation: orbit-rotate 20s linear infinite;
        }

        .orbit-ring:nth-child(2) {
            width: 400px;
            height: 400px;
            animation: orbit-rotate 25s linear infinite reverse;
        }

        .orbit-ring:nth-child(3) {
            width: 500px;
            height: 500px;
            border-style: dashed;
            animation: orbit-rotate 35s linear infinite;
        }

        @keyframes orbit-rotate {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .orbit-dot {
            position: absolute;
            width: 20px;
            height: 20px;
            background: var(--gold);
            border-radius: 50%;
            box-shadow: 0 0 20px var(--gold);
            animation: dot-pulse 2s ease-in-out infinite;
        }

        @keyframes dot-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.3); }
        }

        .orbit-ring:nth-child(1) .orbit-dot {
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .orbit-ring:nth-child(2) .orbit-dot {
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
        }

        .orbit-ring:nth-child(3) .orbit-dot {
            top: 50%;
            right: -10px;
            transform: translateY(-50%);
            background: var(--secondary);
        }

        .center-building {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
            color: white;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: building-float 6s ease-in-out infinite;
            border: 5px solid rgba(255, 215, 0, 0.3);
        }

        @keyframes building-float {
            0%, 100% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(1.1); }
        }

        .center-building::before {
            content: '';
            position: absolute;
            width: 120%;
            height: 120%;
            border-radius: 50%;
            border: 2px solid rgba(255, 215, 0, 0.2);
            animation: pulse-ring 2s ease-out infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        /* ========== WHO WE ARE ========== */
        .who-we-are {
            padding: 6rem 2rem;
            background: white;
            position: relative;
            overflow: hidden;
        }

        .who-we-are::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(201, 160, 99, 0.1);
            border-radius: 50%;
            top: -150px;
            right: -150px;
            animation: blob-float 8s ease-in-out infinite;
        }

        @keyframes blob-float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, 30px) scale(1.1); }
        }

        .who-container {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .section-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            padding: 0.6rem 1.8rem;
            border-radius: 30px;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 20px rgba(26, 86, 50, 0.2);
            animation: badge-float 3s ease-in-out infinite;
        }

        @keyframes badge-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .section-title {
            font-family: 'Amiri', serif;
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            font-weight: 900;
            animation: title-shine 3s ease-in-out infinite;
        }

        @keyframes title-shine {
            0%, 100% { text-shadow: 0 0 0 transparent; }
            50% { text-shadow: 0 0 20px rgba(26, 86, 50, 0.2); }
        }

        .who-description {
            font-size: 1.3rem;
            color: var(--text-light);
            line-height: 2;
            margin-bottom: 3rem;
        }

        .btn-about {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            padding: 1.2rem 3rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 10px 35px rgba(26, 86, 50, 0.3);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            animation: btn-about-float 3s ease-in-out infinite;
        }

        @keyframes btn-about-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .btn-about:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 20px 50px rgba(26, 86, 50, 0.5);
            animation: none;
        }

        /* ========== FEATURES ========== */
        .features {
            padding: 6rem 2rem;
            background: var(--bg-light);
            position: relative;
        }

        .features::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(26, 86, 50, 0.05);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
            animation: blob-float-2 10s ease-in-out infinite;
        }

        @keyframes blob-float-2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(50px, -30px) scale(1.2); }
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-subtitle {
            font-size: 1.3rem;
            color: var(--text-light);
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2.5rem;
        }

        .feature-card {
            background: white;
            padding: 3rem;
            border-radius: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
            animation: card-entry 0.8s ease-out backwards;
        }

        .feature-card:nth-child(1) { animation-delay: 0.1s; }
        .feature-card:nth-child(2) { animation-delay: 0.2s; }
        .feature-card:nth-child(3) { animation-delay: 0.3s; }
        .feature-card:nth-child(4) { animation-delay: 0.4s; }
        .feature-card:nth-child(5) { animation-delay: 0.5s; }
        .feature-card:nth-child(6) { animation-delay: 0.6s; }

        @keyframes card-entry {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--gold));
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.5s ease;
        }

        .feature-card:hover {
            transform: translateY(-15px) scale(1.02) rotate(2deg);
            box-shadow: 0 30px 60px rgba(26, 86, 50, 0.2);
            border-color: var(--gold);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }

        .feature-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 15px 35px rgba(26, 86, 50, 0.3);
            transition: all 0.4s ease;
            position: relative;
            animation: icon-bounce 2s ease-in-out infinite;
        }

        @keyframes icon-bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }



        
        .feature-icon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 3px solid var(--gold);
            animation: icon-pulse 2s ease-out infinite;
        }

        @keyframes icon-pulse {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.15) rotate(360deg);
            animation: none;
        }

        .feature-card h3 {
            font-family: 'Amiri', serif;
            font-size: 1.8rem;
            color: var(--primary);
            margin-bottom: 1.2rem;
            font-weight: 900;
        }

        .feature-card p {
            color: var(--text-light);
            line-height: 1.9;
            font-size: 1.1rem;
        }

        /* ========== QUICK SERVICES ========== */
        .quick-services {
            padding: 6rem 2rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            position: relative;
            overflow: hidden;
        }

        .quick-services::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 215, 0, 0.1);
            border-radius: 50%;
            top: -200px;
            right: -200px;
            animation: float-rotate 30s ease-in-out infinite;
        }

        @keyframes float-rotate {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(50px, 50px) rotate(180deg); }
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2.5rem;
            position: relative;
            z-index: 2;
        }

        .service-card {
            background: rgba(255, 255, 255, 0.98);
            padding: 2.5rem;
            border-radius: 30px;
            text-align: center;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 3px solid transparent;
            position: relative;
            overflow: hidden;
            animation: service-pop 0.6s ease-out backwards;
            min-height: 320px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .service-card:nth-child(1) { animation-delay: 0.1s; }
        .service-card:nth-child(2) { animation-delay: 0.2s; }
        .service-card:nth-child(3) { animation-delay: 0.3s; }
        .service-card:nth-child(4) { animation-delay: 0.4s; }

        @keyframes service-pop {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(201, 160, 99, 0.2) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s;
        }

        .service-card:hover::before {
            opacity: 1;
        }

        .service-card:hover {
            transform: translateY(-20px) scale(1.05) rotate(5deg);
            background: white;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
            border-color: var(--gold);
        }

        .service-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin: 0 auto 1.5rem;
            color: white;
            box-shadow: 0 15px 35px rgba(26, 86, 50, 0.3);
            transition: all 0.6s ease;
            position: relative;
            z-index: 2;
            animation: service-icon-shake 3s ease-in-out infinite;
        }

        @keyframes service-icon-shake {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
        }

        .service-card:hover .service-icon {
            transform: scale(1.3) rotate(360deg);
            background: linear-gradient(135deg, var(--gold), var(--secondary));
            animation: none;
        }

        .service-card h3 {
            font-family: 'Amiri', serif;
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
            font-weight: 900;
            position: relative;
            z-index: 2;
        }

        .service-card p {
            font-size: 1.05rem;
            color: var(--text-light);
            position: relative;
            z-index: 2;
        }

        /* ========== STATS ========== */
        .stats {
            padding: 5rem 2rem;
            background: white;
            position: relative;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            text-align: center;
        }

        .stat-item {
            position: relative;
            padding: 2rem;
            transition: all 0.4s ease;
            animation: stat-float 4s ease-in-out infinite;
        }

        .stat-item:nth-child(1) { animation-delay: 0s; }
        .stat-item:nth-child(2) { animation-delay: 1s; }
        .stat-item:nth-child(3) { animation-delay: 2s; }
        .stat-item:nth-child(4) { animation-delay: 3s; }

        @keyframes stat-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .stat-item:hover {
            transform: scale(1.1);
            animation: none;
        }

        .stat-circle {
            width: 150px;
            height: 150px;
            margin: 0 auto 1.5rem;
            position: relative;
            animation: circle-glow 3s ease-in-out infinite;
        }

        @keyframes circle-glow {
            0%, 100% { filter: drop-shadow(0 0 0 transparent); }
            50% { filter: drop-shadow(0 0 20px rgba(26, 86, 50, 0.3)); }
        }

        .stat-circle svg {
            transform: rotate(-90deg);
        }

        .stat-circle-bg {
            fill: none;
            stroke: #e0e0e0;
            stroke-width: 8;
        }

        .stat-circle-progress {
            fill: none;
            stroke: url(#gradient);
            stroke-width: 8;
            stroke-linecap: round;
            stroke-dasharray: 440;
            stroke-dashoffset: 440;
            animation: circle-progress 2s ease-out forwards;
        }

        @keyframes circle-progress {
            to { stroke-dashoffset: 0; }
        }

        .stat-number {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Amiri', serif;
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--primary);
            animation: number-pulse 2s ease-in-out infinite;
        }

        @keyframes number-pulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(1.1); }
        }

        .stat-label {
            font-size: 1.2rem;
            color: var(--text-dark);
            font-weight: 600;
        }

        /* ========== CTA ========== */
        .cta {
            padding: 6rem 2rem;
            background: var(--bg-light);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(201, 160, 99, 0.1);
            border-radius: 50%;
            top: -150px;
            left: -150px;
            animation: cta-blob 8s ease-in-out infinite;
        }

        @keyframes cta-blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(50px, 50px) scale(1.2); }
        }

        .cta-box {
            max-width: 1000px;
            margin: 0 auto;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 5rem 4rem;
            border-radius: 50px;
            box-shadow: 0 30px 90px rgba(26, 86, 50, 0.4);
            position: relative;
            overflow: hidden;
            animation: cta-pulse 4s ease-in-out infinite;
        }

        @keyframes cta-pulse {
            0%, 100% { box-shadow: 0 30px 90px rgba(26, 86, 50, 0.4); }
            50% { box-shadow: 0 40px 100px rgba(26, 86, 50, 0.6); }
        }

        .cta-box::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 215, 0, 0.2) 0%, transparent 70%);
            animation: rotate 30s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .cta-content {
            position: relative;
            z-index: 2;
        }

        .cta-box h2 {
            font-family: 'Amiri', serif;
            font-size: 3rem;
            color: white;
            margin-bottom: 2rem;
            font-weight: 900;
            animation: title-glow 3s ease-in-out infinite;
        }

        @keyframes title-glow {
            0%, 100% { text-shadow: 0 0 0 transparent; }
            50% { text-shadow: 0 0 30px rgba(255, 215, 0, 0.5); }
        }

        .cta-box p {
            font-size: 1.4rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 3rem;
            line-height: 1.8;
        }

        /* ========== FOOTER ========== */
        .footer {
            background: var(--primary-dark);
            color: white;
            padding: 4rem 2rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 215, 0, 0.05);
            border-radius: 50%;
            bottom: -200px;
            right: -200px;
            animation: footer-blob 10s ease-in-out infinite;
        }

        @keyframes footer-blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-50px, -50px) scale(1.1); }
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
            position: relative;
            z-index: 2;
        }

        .footer-section {
            animation: footer-fade-up 0.8s ease-out backwards;
        }

        .footer-section:nth-child(1) { animation-delay: 0.1s; }
        .footer-section:nth-child(2) { animation-delay: 0.2s; }
        .footer-section:nth-child(3) { animation-delay: 0.3s; }
        .footer-section:nth-child(4) { animation-delay: 0.4s; }

        @keyframes footer-fade-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer-section h3 {
            font-family: 'Amiri', serif;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--gold);
            position: relative;
            display: inline-block;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: -5px;
            right: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            animation: line-expand 1s ease-out forwards;
            animation-delay: 0.5s;
        }

        @keyframes line-expand {
            to { width: 100%; }
        }

        .footer-section p,
        .footer-section a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: block;
            margin-bottom: 0.8rem;
            transition: all 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--gold);
            padding-right: 10px;
            transform: translateX(-5px);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            animation: social-float 3s ease-in-out infinite;
        }

        .social-links a:nth-child(1) { animation-delay: 0s; }
        .social-links a:nth-child(2) { animation-delay: 0.5s; }
        .social-links a:nth-child(3) { animation-delay: 1s; }
        .social-links a:nth-child(4) { animation-delay: 1.5s; }

        @keyframes social-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .social-links a:hover {
            background: var(--gold);
            color: var(--primary-dark);
            transform: translateY(-5px) scale(1.2);
            animation: none;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
            position: relative;
            z-index: 2;
            animation: fade-in 1s ease-out;
        }

        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* ========== SCROLL REVEAL ========== */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 1s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .scroll-reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1200px) {
            .hero h1 { font-size: 3.5rem; }
            .section-title { font-size: 3rem; }
            .orbit-container { width: 400px; height: 400px; }
        }

        @media (max-width: 968px) {
            .nav-links { display: none; }
            .hero-container { 
                grid-template-columns: 1fr;
                gap: 3rem;
            }
            .hero h1 { font-size: 2.5rem; }
            .section-title { font-size: 2.2rem; }
            .orbit-container { width: 350px; height: 350px; }
            .services-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
            .section-title { font-size: 1.8rem; }
            .btn { padding: 1rem 2rem; font-size: 1rem; }
            .orbit-container { width: 300px; height: 300px; }
            .services-grid {
                grid-template-columns: 1fr;
            }
            .service-card {
                min-height: 280px;
            }
        }
    </style>
</head>
<body>

    <svg width="0" height="0">
        <defs>
            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" style="stop-color:#1a5632"/>
                <stop offset="100%" style="stop-color:#c9a063"/>
            </linearGradient>
        </defs>
    </svg>

    <!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div class="logo">
    <img src="{{ asset('images/logo.png') }}" 
         alt="Logo"
         style="width:45px;height:45px;object-fit:contain;">
         
    <span>{{ setting('site_name', 'المحافظة العقارية') }}</span>
</div>

            <ul class="nav-links">
                <li><a href="{{ route('home') }}">الرئيسية</a></li>

                <li class="dropdown">
                    <a href="javascript:void(0)">الشهادة السلبية <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('negative.new') }}"><i class="fas fa-plus-circle"></i> طلب جديد</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="javascript:void(0)">الوثائق العقارية <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-sub">
                            <a href="javascript:void(0)"><i class="fas fa-id-card"></i> البطاقات <i class="fas fa-chevron-left"></i></a>
                            <ul class="dropdown-submenu">
                                <li><a href="{{ route('card.natural') }}">البطاقة الشخصية</a></li>
                                <li><a href="{{ route('card.moral') }}">البطاقة الأبجدية</a></li>
                                <li><a href="{{ route('card.urban_private') }}">البطاقة الحضرية الخاصة</a></li>
                                <li><a href="{{ route('card.rural_card') }}">البطاقة الريفية</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ url('/contracts/extracts') }}"><i class="fas fa-file-contract"></i> مستخرجات العقود</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="javascript:void(0)">الدفتر العقاري <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('land.register.create') }}"><i class="fas fa-book"></i> طلب إنشاء دفتر</a></li>
                        <li><a href="{{ route('land.register.copy') }}"><i class="fas fa-copy"></i> طلب نسخة دفتر</a></li>
                    </ul>
                </li>

                <li><a href="{{ route('appointment') }}">حجز موعد</a></li>
                <li><a href="{{ route('about') }}">من نحن</a></li>
                <li><a href="{{ route('contact') }}">اتصل بنا</a></li>
      <!-- NAVBAR - قسم المستخدم فقط -->
@auth('website')
<li class="dropdown">
    <a href="javascript:void(0)" class="btn-login">
        <i class="fas fa-user-circle"></i>
        {{ Auth::guard('website')->user()->name }}
        <i class="fas fa-chevron-down"></i>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route('profile') }}">
                <i class="fas fa-user"></i> الملف الشخصي
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;padding:0;">
                @csrf
                <button type="submit" style="background:none;border:none;width:100%;text-align:right;padding:0.9rem 1rem;border-radius:15px;color:inherit;font-size:1rem;font-family:inherit;cursor:pointer;display:flex;align-items:center;gap:0.8rem;">
                    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                </button>
            </form>
        </li>
    </ul>
</li>
@else
<li>
    <a href="{{ route('login') }}" class="btn-login">
        <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
    </a>
</li>
@endauth
            </ul>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="circles-container">
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
        </div>

        <div class="particles" id="particles"></div>

        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-certificate"></i>
                    <span>الخدمات الإلكترونية الرسمية</span>
                </div>
                <h1>
                    {{ setting('site_name', 'المحافظة العقارية') }}
                </h1>
                <p>
                    {{ setting('site_description', 'نظام متكامل لإدارة الأراضي والملكيات العقارية') }}<br>
                    خدمات إلكترونية سريعة وآمنة ومتاحة على مدار الساعة
                </p>
             <div class="hero-buttons">
    <a href="{{ route('negative.new') }}" class="btn btn-primary">
        <i class="fas fa-file-alt"></i>
        <span>طلب شهادة سلبية</span>
    </a>
</div>
            </div>

            <div class="hero-visual">
                <div class="orbit-container">
                    <div class="orbit-ring">
                        <div class="orbit-dot"></div>
                    </div>
                    <div class="orbit-ring">
                        <div class="orbit-dot"></div>
                    </div>
                    <div class="orbit-ring">
                        <div class="orbit-dot"></div>
                    </div>
                    <div class="center-building">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- WHO WE ARE -->
    <section class="who-we-are">
        <div class="who-container scroll-reveal">
            <div class="section-badge"><i class="fas fa-landmark"></i> من نحن</div>
            <h2 class="section-title">{{ setting('site_name', 'المحافظة العقارية') }}</h2>
            <p class="who-description">
                {{ setting('site_description', 'مؤسسة حكومية رائدة في مجال إدارة وتنظيم الملكيات العقارية') }}
            </p>
            <a href="{{ route('about') }}" class="btn-about">
                <i class="fas fa-arrow-left"></i>
                <span>اقرأ المزيد عنا</span>
            </a>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="features">
        <div class="container">
            <div class="section-header scroll-reveal">
                <div class="section-badge"><i class="fas fa-star"></i> خدماتنا الأساسية</div>
                <h2 class="section-title">ماذا نقدم لك؟</h2>
                <p class="section-subtitle">
                    مجموعة شاملة من الخدمات العقارية الإلكترونية لتسهيل إجراءاتك
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-card scroll-reveal">
                    <div class="feature-icon"><i class="fas fa-book"></i></div>
                    <h3>مسك السجل العقاري</h3>
                    <p>تسجيل وتدوين كافة الحقوق العينية الأصلية والتبعية بشكل منظم ودقيق</p>
                </div>

                <div class="feature-card scroll-reveal">
                    <div class="feature-icon"><i class="fas fa-bullhorn"></i></div>
                    <h3>إشهار المعاملات</h3>
                    <p>إشهار كافة العقود والتصرفات القانونية بطريقة رسمية معتمدة</p>
                </div>

                <div class="feature-card scroll-reveal">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>حماية الملكية</h3>
                    <p>ضمان استقرار الملكية العقارية ومنع النزاعات القانونية</p>
                </div>

                <div class="feature-card scroll-reveal">
                    <div class="feature-icon"><i class="fas fa-sync-alt"></i></div>
                    <h3>تحيين المعلومات</h3>
                    <p>تحديث وضعية العقار بشكل فوري عند حدوث أي تغيير</p>
                </div>

                <div class="feature-card scroll-reveal">
                    <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
                    <h3>تقديم المعلومات</h3>
                    <p>إتاحة الحصول على شهادات ووثائق عقارية رسمية معتمدة</p>
                </div>

                <div class="feature-card scroll-reveal">
                    <div class="feature-icon"><i class="fas fa-city"></i></div>
                    <h3>دعم التنمية</h3>
                    <p>توفير بيانات عقارية دقيقة تساهم في التخطيط الحكومي</p>
                </div>
            </div>
        </div>
    </section>

    <!-- QUICK SERVICES -->
    <section class="quick-services">
        <div class="container">
            <div class="section-header">
                <div class="section-badge" style="background: rgba(255,255,255,0.25); color: white;">
                    <i class="fas fa-bolt"></i> خدمات سريعة
                </div>
                <h2 class="section-title" style="color: white;">ابدأ طلبك الآن</h2>
                <p class="section-subtitle" style="color: rgba(255,255,255,0.95);">
                    اختر الخدمة المناسبة وقم بإكمال طلبك إلكترونياً
                </p>
            </div>

            <div class="services-grid">
                <a href="{{ route('negative.new') }}" style="text-decoration: none;">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-file-alt"></i></div>
                        <h3>شهادة سلبية</h3>
                        <p>احصل على شهادة سلبية رسمية معتمدة</p>
                    </div>
                </a>

                <a href="{{ route('card.natural') }}" style="text-decoration: none;">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-home"></i></div>
                        <h3>البطاقات العقارية</h3>
                        <p>استخرج نسخة من البطاقات العقارية</p>
                    </div>
                </a>

                <a href="{{ url('/contracts/extracts') }}" style="text-decoration: none;">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-file-contract"></i></div>
                        <h3>مستخرجات العقود</h3>
                        <p>احصل على مستخرج رسمي من العقود</p>
                    </div>
                </a>

                <a href="{{ route('land.register.create') }}" style="text-decoration: none;">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-book-open"></i></div>
                        <h3>الدفتر العقاري</h3>
                        <p>طلب إنشاء أو نسخة دفتر عقاري</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- STATS -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item scroll-reveal">
                    <div class="stat-circle">
                        <svg width="150" height="150" viewBox="0 0 150 150">
                            <circle class="stat-circle-bg" cx="75" cy="75" r="70"/>
                            <circle class="stat-circle-progress" cx="75" cy="75" r="70"/>
                        </svg>
                        <span class="stat-number">20K+</span>
                    </div>
                    <span class="stat-label">طلب مكتمل</span>
                </div>

                <div class="stat-item scroll-reveal">
                    <div class="stat-circle">
                        <svg width="150" height="150" viewBox="0 0 150 150">
                            <circle class="stat-circle-bg" cx="75" cy="75" r="70"/>
                            <circle class="stat-circle-progress" cx="75" cy="75" r="70"/>
                        </svg>
                        <span class="stat-number">99%</span>
                    </div>
                    <span class="stat-label">نسبة الرضا</span>
                </div>

                <div class="stat-item scroll-reveal">
                    <div class="stat-circle">
                        <svg width="150" height="150" viewBox="0 0 150 150">
                            <circle class="stat-circle-bg" cx="75" cy="75" r="70"/>
                            <circle class="stat-circle-progress" cx="75" cy="75" r="70"/>
                        </svg>
                        <span class="stat-number">24/7</span>
                    </div>
                    <span class="stat-label">خدمة متواصلة</span>
                </div>

                <div class="stat-item scroll-reveal">
                    <div class="stat-circle">
                        <svg width="150" height="150" viewBox="0 0 150 150">
                            <circle class="stat-circle-bg" cx="75" cy="75" r="70"/>
                            <circle class="stat-circle-progress" cx="75" cy="75" r="70"/>
                        </svg>
                        <span class="stat-number">8K+</span>
                    </div>
                    <span class="stat-label">مستخدم نشط</span>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="container">
            <div class="cta-box">
                <div class="cta-content">
                    <h2><i class="fas fa-headset"></i> هل تحتاج مساعدة؟</h2>
                    <p>فريقنا جاهز للإجابة على استفساراتك ومساعدتك في إتمام إجراءاتك</p>
                    <div class="hero-buttons">
                        <a href="{{ route('contact') }}" class="btn btn-primary">
                            <i class="fas fa-phone"></i>
                            <span>اتصل بنا</span>
                        </a>
                        <a href="{{ route('appointment') }}" class="btn btn-secondary">
                            <i class="fas fa-calendar-alt"></i>
                            <span>احجز موعد</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3><i class="fas fa-landmark"></i> {{ setting('site_name', 'المحافظة العقارية') }}</h3>
                <p>{{ setting('site_description', 'نظام متكامل لإدارة الأراضي والملكيات العقارية') }}</p>
                <div class="social-links">
                    @if(setting('social_facebook'))
                        <a href="{{ setting('social_facebook') }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(setting('social_twitter'))
                        <a href="{{ setting('social_twitter') }}" target="_blank"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if(setting('social_instagram'))
                        <a href="{{ setting('social_instagram') }}" target="_blank"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(setting('social_linkedin'))
                        <a href="{{ setting('social_linkedin') }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    @endif
                </div>
            </div>

            <div class="footer-section">
                <h3>روابط سريعة</h3>
                <a href="{{ route('home') }}"><i class="fas fa-home"></i> الرئيسية</a>
                <a href="{{ route('about') }}"><i class="fas fa-info-circle"></i> من نحن</a>
                <a href="{{ route('negative.new') }}"><i class="fas fa-file-alt"></i> طلب شهادة سلبية</a>
                <a href="{{ route('contact') }}"><i class="fas fa-envelope"></i> اتصل بنا</a>
            </div>

            <div class="footer-section">
                <h3>الخدمات</h3>
                <a href="{{ route('card.natural') }}"><i class="fas fa-id-card"></i> البطاقات العقارية</a>
                <a href="{{ url('/contracts/extracts') }}"><i class="fas fa-file-contract"></i> مستخرجات العقود</a>
                <a href="{{ route('land.register.create') }}"><i class="fas fa-book"></i> الدفتر العقاري</a>
            </div>

            <div class="footer-section">
                <h3>تواصل معنا</h3>
                <p><i class="fas fa-map-marker-alt"></i> {{ setting('contact_address', 'أولاد جلال، الجزائر') }}</p>
                <p><i class="fas fa-phone"></i> {{ setting('contact_phone', '+213 XXX XXX XXX') }}</p>
                <p><i class="fas fa-envelope"></i> {{ setting('contact_email', 'info@conservation.dz') }}</p>
                @if(setting('working_hours'))
                    <p><i class="fas fa-clock"></i> {{ setting('working_hours') }}</p>
                @endif
            </div>
        </div>

        <div class="footer-bottom">
            <p><i class="fas fa-copyright"></i> 2025 {{ setting('site_name', 'المحافظة العقارية') }} - جميع الحقوق محفوظة</p>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        const particlesContainer = document.getElementById('particles');
        for(let i = 0; i < 50; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (10 + Math.random() * 10) + 's';
            particlesContainer.appendChild(particle);
        }

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -100px 0px' });

        document.querySelectorAll('.scroll-reveal').forEach(element => {
            observer.observe(element);
        });
    </script>

</body>
</html>