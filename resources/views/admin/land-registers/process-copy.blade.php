@extends('admin.layout')

@section('title', 'معالجة طلب نسخة #' . $register->id)

@section('content')

<style>
    :root {
        --primary-green: #1a5632;
        --light-green: #28a745;
        --dark-green: #155028;
        --mint: #e8f5e9;
        --white: #ffffff;
        --off-white: #f8faf8;
        --gray: #f5f7f5;
        --text-dark: #1a1a1a;
        --text-gray: #666666;
        --border: #e0e8e0;
        --danger: #e74c3c;
        --warning: #f39c12;
        --success: #28a745;
        --info: #3498db;
        --purple: #9b59b6;
        --orange: #fd7e14;
    }

    * { 
        box-sizing: border-box; 
        font-family: 'Tajawal', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        margin: 0;
        padding: 0;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
    }

    /* Header متطور */
    .page-header {
        background: linear-gradient(135deg, #0a2f1a 0%, #1a5632 50%, #2d7a4c 100%);
        padding: 2.5rem;
        border-radius: 30px;
        margin-bottom: 2.5rem;
        color: var(--white);
        box-shadow: 0 20px 40px rgba(26, 86, 50, 0.3);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
    }
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%; right: -10%;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 10s ease-in-out infinite;
    }
    .page-header::after {
        content: '📄';
        position: absolute;
        bottom: -20px; left: 20px;
        font-size: 8rem;
        opacity: 0.1;
        transform: rotate(-15deg);
    }
    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(20px, -20px) rotate(5deg); }
    }
    .page-header h1 {
        font-size: 2.2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
        position: relative;
        font-weight: 700;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    .page-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-right: 3rem;
        position: relative;
    }

    .btn-back {
        background: rgba(255,255,255,0.15);
        color: var(--white);
        padding: 0.9rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        border: 1px solid rgba(255,255,255,0.2);
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        margin-bottom: 1rem;
    }
    .btn-back:hover {
        background: rgba(255,255,255,0.25);
        transform: translateX(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .process-card {
        background: var(--white);
        padding: 2.5rem;
        border-radius: 30px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .process-card:hover {
        box-shadow: 0 20px 40px rgba(26, 86, 50, 0.1);
        transform: translateY(-5px);
    }
    .process-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 4px;
        background: linear-gradient(90deg, var(--primary-green), var(--light-green), var(--primary-green));
    }

    .section-title {
        font-size: 1.5rem;
        color: var(--primary-green);
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid var(--mint);
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 700;
        position: relative;
    }
    .section-title span:first-child {
        background: var(--mint);
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        font-size: 1.5rem;
    }

    /* بطاقة معلومات مقدم الطلب المصغرة */
    .requester-mini-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 1.2rem 2rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }
    .requester-mini-card::before {
        content: '👤';
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 4rem;
        opacity: 0.2;
    }
    .requester-mini-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: rgba(255,255,255,0.15);
        padding: 0.7rem 1.5rem;
        border-radius: 50px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
    }
    .requester-mini-item .icon {
        font-size: 1.3rem;
    }
    .requester-mini-item .label {
        font-size: 0.8rem;
        opacity: 0.8;
    }
    .requester-mini-item .value {
        font-size: 1rem;
        font-weight: 700;
        color: white;
    }

    /* حقل البحث المتطور */
    .search-form-container {
        background: linear-gradient(135deg, #f8fafc 0%, #f0f4f8 100%);
        padding: 2.5rem;
        border-radius: 30px;
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 2rem;
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.02);
    }
    .search-fields {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-top: 1rem;
    }
    .search-field {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }
    .search-field label {
        font-weight: 700;
        color: var(--primary-green);
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .search-field label i {
        color: var(--light-green);
    }
    .search-field input {
        padding: 1.2rem 1.5rem;
        border: 2px solid transparent;
        border-radius: 20px;
        font-size: 1rem;
        background: var(--white);
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
    }
    .search-field input:focus {
        outline: none;
        border-color: var(--light-green);
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.15);
        transform: scale(1.02);
    }
    .search-field input::placeholder {
        color: #aaa;
        font-size: 0.9rem;
    }

    .btn-search {
        background: linear-gradient(135deg, #1a5632 0%, #2d7a4c 50%, #3f9e66 100%);
        color: var(--white);
        padding: 1.3rem 2rem;
        font-size: 1.2rem;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        width: 100%;
        margin-top: 2rem;
        font-weight: 700;
        transition: all 0.4s ease;
        box-shadow: 0 10px 25px rgba(26, 86, 50, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }
    .btn-search::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    .btn-search:hover::before {
        left: 100%;
    }
    .btn-search:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 20px 35px rgba(26, 86, 50, 0.4); 
    }
    .btn-search:disabled {
        background: #95a5a6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* نتائج البحث المتطورة */
    .results-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, #2d7a4c 100%);
        color: var(--white);
        padding: 1.8rem 2.5rem;
        border-radius: 30px 30px 30px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        box-shadow: 0 10px 25px rgba(26, 86, 50, 0.2);
    }
    .results-header h3 { 
        font-size: 1.4rem; 
        margin: 0; 
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    #resultCount {
        background: rgba(255,255,255,0.2);
        padding: 0.7rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
    }

    /* بطاقة العقار المحترفة */
    .property-card {
        background: var(--white);
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 30px;
        padding: 2rem;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }
    .property-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 150px; height: 150px;
        background: linear-gradient(135deg, transparent 50%, rgba(40, 167, 69, 0.03) 100%);
        border-radius: 50%;
        transition: all 0.4s ease;
    }
    .property-card:hover {
        transform: translateY(-10px) scale(1.01);
        box-shadow: 0 30px 50px rgba(26, 86, 50, 0.15);
        border-color: var(--light-green);
    }
    .property-card.selected {
        border: 3px solid var(--light-green);
        background: linear-gradient(135deg, #f0fff4 0%, var(--white) 100%);
        box-shadow: 0 20px 40px rgba(40, 167, 69, 0.2);
    }
    .property-card.selected::before {
        content: '✓';
        position: absolute;
        top: 20px; left: 20px;
        width: 40px; height: 40px;
        background: var(--light-green);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        z-index: 10;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px dashed var(--border);
    }
    .owner-info h4 { 
        color: var(--primary-green); 
        font-size: 1.4rem; 
        margin: 0 0 0.5rem 0;
        font-weight: 800;
    }
    .owner-info span { 
        color: var(--text-gray); 
        font-size: 1rem;
        background: var(--off-white);
        padding: 0.3rem 1rem;
        border-radius: 20px;
    }

    .property-badge {
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .badge-surveyed { 
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        color: var(--primary-green); 
        border: 1px solid var(--light-green);
    }
    .badge-not-surveyed { 
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        color: #e65100; 
        border: 1px solid #ffb74d;
    }

    .card-body {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .info-row { 
        display: flex; 
        flex-direction: column; 
        gap: 0.5rem;
        background: var(--off-white);
        padding: 1rem;
        border-radius: 20px;
        transition: all 0.3s ease;
    }
    .info-row:hover {
        background: var(--mint);
        transform: translateY(-3px);
    }
    .info-label { 
        font-size: 0.8rem; 
        color: var(--text-gray); 
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value { 
        font-size: 1.1rem; 
        color: var(--text-dark); 
        font-weight: 700;
    }

    .register-box {
        background: linear-gradient(135deg, var(--primary-green) 0%, #2d7a4c 100%);
        color: var(--white);
        padding: 1.2rem;
        border-radius: 20px;
        text-align: center;
        margin: 1.5rem 0;
        box-shadow: 0 10px 20px rgba(26, 86, 50, 0.2);
    }
    .register-box .label { 
        font-size: 0.9rem; 
        opacity: 0.9; 
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .register-box .value { 
        font-size: 1.8rem; 
        font-weight: 800; 
        font-family: 'Courier New', monospace;
        letter-spacing: 2px;
    }

    .btn-select {
        width: 100%;
        padding: 1.2rem;
        border: 2px solid var(--primary-green);
        background: var(--white);
        color: var(--primary-green);
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        margin-top: 1rem;
    }
    .btn-select:hover:not(:disabled) { 
        background: linear-gradient(135deg, var(--primary-green) 0%, #2d7a4c 100%);
        color: var(--white); 
        transform: scale(1.02);
        box-shadow: 0 10px 20px rgba(26, 86, 50, 0.2);
    }
    .btn-select.selected { 
        background: var(--light-green); 
        border-color: var(--light-green); 
        color: var(--white); 
    }
    .btn-select:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: var(--border);
        border-color: var(--text-gray);
    }

    /* حالة عدم وجود نتائج */
    .no-property-found {
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
        border: 2px dashed var(--danger);
        border-radius: 40px;
        padding: 4rem;
        text-align: center;
        color: var(--danger);
        margin-bottom: 2rem;
    }
    .no-property-found .icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        animation: bounce 2s ease-in-out infinite;
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    .no-property-found h3 {
        font-size: 2rem;
        margin-bottom: 1rem;
        font-weight: 800;
    }
    .no-property-found p {
        color: #666;
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }
    .btn-reject {
        background: linear-gradient(135deg, var(--danger) 0%, #c0392b 100%);
        color: white;
        padding: 1.2rem 3rem;
        border: none;
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        box-shadow: 0 10px 20px rgba(231, 76, 60, 0.3);
    }
    .btn-reject:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(231, 76, 60, 0.4);
    }

    /* عرض تفاصيل العقار المختار */
    .selected-property-display {
        background: linear-gradient(135deg, #f0fff4 0%, var(--white) 100%);
        padding: 2.5rem;
        border-radius: 30px;
        border: 3px solid var(--light-green);
        display: none;
        box-shadow: 0 20px 40px rgba(40, 167, 69, 0.1);
    }
    .selected-property-display.show {
        display: block;
        animation: slideUp 0.5s ease;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin: 2rem 0;
    }
    .detail-box { 
        background: var(--white); 
        padding: 1.5rem; 
        border-radius: 20px; 
        border: 1px solid var(--border);
        box-shadow: 0 5px 15px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }
    .detail-box:hover {
        border-color: var(--light-green);
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(40, 167, 69, 0.1);
    }
    .detail-box label { 
        display: block; 
        font-size: 0.9rem; 
        color: var(--text-gray); 
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .detail-box .value { 
        display: block; 
        font-size: 1.3rem; 
        font-weight: 800; 
        color: var(--primary-green);
    }

    .comparison-box {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        border: 2px solid #ff9800;
        border-radius: 20px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        position: relative;
        overflow: hidden;
    }
    .comparison-box::before {
        content: '⚠️';
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 3rem;
        opacity: 0.2;
    }
    .comparison-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
    .comparison-item {
        background: rgba(255,255,255,0.5);
        padding: 1rem;
        border-radius: 15px;
        backdrop-filter: blur(10px);
    }
    .comparison-item .label {
        font-size: 0.85rem;
        color: #e65100;
        margin-bottom: 0.3rem;
    }
    .comparison-item .value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #bf360c;
    }

    .owner-check {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.8rem;
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        border-radius: 20px;
        border: 2px solid var(--light-green);
        margin-top: 2rem;
    }
    .owner-check input[type="checkbox"] { 
        width: 30px; 
        height: 30px; 
        accent-color: var(--primary-green); 
        cursor: pointer;
        border-radius: 10px;
    }
    .owner-check label { 
        font-size: 1.1rem; 
        cursor: pointer; 
        color: var(--text-dark); 
        font-weight: 600;
        flex: 1;
    }

    /* خيارات نوع النسخة */
    .copy-type-selector { 
        display: grid; 
        grid-template-columns: repeat(2, 1fr); 
        gap: 2rem; 
        margin: 2rem 0;
    }
    .copy-type-option {
        padding: 2.5rem;
        border: 2px solid var(--border);
        border-radius: 30px;
        cursor: pointer;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        background: linear-gradient(135deg, var(--white) 0%, var(--off-white) 100%);
        position: relative;
        overflow: hidden;
    }
    .copy-type-option::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 5px;
        background: linear-gradient(90deg, var(--primary-green), var(--light-green), var(--primary-green));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    .copy-type-option:hover { 
        border-color: var(--light-green); 
        transform: translateY(-10px); 
        box-shadow: 0 20px 40px rgba(26, 86, 50, 0.15);
    }
    .copy-type-option.selected { 
        border-color: var(--primary-green); 
        background: linear-gradient(135deg, #f0fff4 0%, #e8f5e9 100%);
        box-shadow: 0 15px 35px rgba(40, 167, 69, 0.2);
    }
    .copy-type-option.selected::before { 
        transform: scaleX(1); 
    }
    .copy-type-option .icon { 
        font-size: 4rem; 
        margin-bottom: 1.5rem;
        display: inline-block;
        animation: float 3s ease-in-out infinite;
    }
    .copy-type-option .title { 
        font-size: 1.4rem; 
        font-weight: 800; 
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }
    .copy-type-option .description {
        color: var(--text-gray);
        font-size: 0.95rem;
    }
    .copy-type-option.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
        background: var(--border);
        filter: grayscale(1);
    }

    .form-control {
        width: 100%;
        padding: 1.3rem 1.8rem;
        border: 2px solid var(--border);
        border-radius: 20px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--white);
    }
    .form-control:focus { 
        outline: none; 
        border-color: var(--light-green); 
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.1);
        transform: scale(1.01);
    }

    .btn-submit {
        background: linear-gradient(135deg, #1a5632 0%, #2d7a4c 50%, #3f9e66 100%);
        color: var(--white);
        padding: 1.4rem;
        font-size: 1.2rem;
        width: 100%;
        border: none;
        border-radius: 50px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.4s ease;
        box-shadow: 0 15px 30px rgba(26, 86, 50, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }
    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    .btn-submit:hover::before {
        left: 100%;
    }
    .btn-submit:hover:not(:disabled) { 
        transform: translateY(-5px); 
        box-shadow: 0 25px 45px rgba(26, 86, 50, 0.4); 
    }
    .btn-submit:disabled { 
        background: #95a5a6; 
        cursor: not-allowed; 
        box-shadow: none; 
        opacity: 0.6;
    }

    .alert {
        padding: 1.5rem 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        border: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .alert-success { 
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        color: var(--primary-green); 
        border-right: 5px solid var(--light-green);
    }
    .alert-error { 
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
        color: #c62828; 
        border-right: 5px solid var(--danger);
    }

    .loading-container { 
        text-align: center; 
        padding: 5rem; 
        color: var(--primary-green); 
    }
    .spinner {
        border: 5px solid var(--border);
        border-top: 5px solid var(--primary-green);
        border-radius: 50%;
        width: 70px; height: 70px;
        animation: spin 1s linear infinite;
        margin: 0 auto 1.5rem;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* معاينة الإيميل */
    .email-preview {
        background: linear-gradient(135deg, #f8f6f1, #fff);
        border: 3px solid #c9a063;
        border-radius: 15px;
        padding: 2rem;
        margin: 2rem 0;
        display: none;
        animation: slideDown 0.5s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .email-preview.active {
        display: block;
    }

    .email-preview h4 {
        color: #1a5632;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        font-size: 1.3rem;
    }

    .email-content {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        border-right: 5px solid #c9a063;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .email-subject {
        font-weight: 700;
        color: #2d2d2d;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e0e0e0;
        font-size: 1.15rem;
    }

    .email-body {
        color: #5d4037;
        line-height: 2;
        font-size: 1.05rem;
    }

    .property-highlight {
        background: #e8f5e9;
        padding: 1rem;
        border-radius: 10px;
        margin: 1rem 0;
        border-right: 4px solid #28a745;
    }

    @media (max-width: 768px) {
        .card-body { grid-template-columns: 1fr; }
        .copy-type-selector { grid-template-columns: 1fr; }
        .comparison-grid { grid-template-columns: 1fr; }
        .requester-mini-card { flex-direction: column; align-items: stretch; }
    }
</style>

<div class="page-header">
    <h1>
        <span>📋</span>
        <span>معالجة طلب نسخة #{{ $register->id }}</span>
    </h1>
    <p>التحقق من الدفتر العقاري وإصدار النسخة</p>
</div>

<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.land.registers.show', $register->id) }}" class="btn-back">
        <span>←</span>
        <span>رجوع للتفاصيل</span>
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-error">
        <ul style="margin: 0; padding-right: 1.5rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ===== بطاقة مقدم الطلب المصغرة ===== --}}
<div class="requester-mini-card">
    <div class="requester-mini-item">
        <span class="icon">👤</span>
        <div>
            <div class="label">مقدم الطلب</div>
            <div class="value">{{ $register->full_name }}</div>
        </div>
    </div>
    <div class="requester-mini-item">
        <span class="icon">📞</span>
        <div>
            <div class="label">رقم الهاتف</div>
            <div class="value">{{ $register->phone }}</div>
        </div>
    </div>
    <div class="requester-mini-item">
        <span class="icon">📅</span>
        <div>
            <div class="label">تاريخ الطلب</div>
            <div class="value">{{ \Carbon\Carbon::parse($register->created_at)->format('Y-m-d') }}</div>
        </div>
    </div>
</div>

{{-- ===== نموذج البحث المتطور ===== --}}
<div class="process-card">
    <h2 class="section-title">
        <span>🔍</span>
        <span>البحث في قاعدة البيانات العقارية</span>
    </h2>

    <div class="search-form-container">
        <div class="search-fields">
            <div class="search-field">
                <label><i>📍</i> القسم <span style="color:#e74c3c">*</span></label>
                <input type="text" id="section" placeholder="أدخل رقم القسم ... مثال: 05" value="{{ old('section', $register->section ?? '') }}">
            </div>
            <div class="search-field">
                <label><i>🔢</i> الرقم <span style="color:#e74c3c">*</span></label>
                <input type="text" id="number" placeholder="أدخل رقم العقار ... مثال: 123" value="{{ old('number', $register->number ?? '') }}">
            </div>
            <div class="search-field">
                <label><i>🏛️</i> البلدية / الموقع</label>
                <input type="text" id="location" placeholder="أدخل اسم البلدية ... (اختياري)" value="{{ old('location', $register->location ?? '') }}">
            </div>
        </div>
        <button type="button" class="btn-search" onclick="doSearch()" id="searchBtn">
            <span>🔍</span>
            <span>بحث في السجلات</span>
        </button>
    </div>

    {{-- نتائج البحث المتطورة --}}
    <div id="resultsSection" style="display:none;">
        <div class="results-header">
            <h3>
                <span>📊</span>
                <span>نتائج البحث</span>
            </h3>
            <div id="resultCount">0 نتيجة</div>
        </div>
        <div id="resultsContainer"></div>
    </div>
</div>

{{-- ===== لوحة التحقق من المالك ===== --}}
<div class="process-card">
    <h2 class="section-title">
        <span>✅</span>
        <span>التحقق من هوية المالك</span>
    </h2>

    <div class="verification-box" id="verificationBox">
        <div class="empty-icon">🔍</div>
        <h3 style="margin-bottom: 1rem; color: var(--text-dark);">لم يتم اختيار عقار بعد</h3>
        <p style="font-size: 1.1rem;">قم بالبحث أولاً، ثم اختر العقار المناسب من النتائج أعلاه</p>
    </div>

    <div class="selected-property-display" id="propertyDisplay">
        <h3 style="color:var(--primary-green); margin-bottom:2rem; display:flex; align-items:center; gap:1rem; font-size:1.8rem;">
            <span style="background: var(--light-green); color: white; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 15px;">✓</span>
            <span>تم تحديد العقار، يمكنك متابعة التحقق</span>
        </h3>
        
        <div class="detail-grid">
            <div class="detail-box">
                <label>👤 المالك</label>
                <div class="value" id="display_owner">-</div>
            </div>
            <div class="detail-box">
                <label>📋 رقم الدفتر</label>
                <div class="value" id="display_register">-</div>
            </div>
            <div class="detail-box">
                <label>🏷️ نوع العقار</label>
                <div class="value" id="display_type">-</div>
            </div>
            <div class="detail-box">
                <label>📍 الموقع</label>
                <div class="value" id="display_location">-</div>
            </div>
            <div class="detail-box">
                <label>📏 المساحة</label>
                <div class="value" id="display_area">-</div>
            </div>
            <div class="detail-box">
                <label>🆔 رقم التعريف</label>
                <div class="value" id="display_national_id">-</div>
            </div>
        </div>
        
        {{-- مقارنة الهوية المتطورة --}}
        <div class="comparison-box">
            <h4 style="color: #e65100; margin-bottom: 1.5rem; font-size: 1.3rem;">🔍 التحقق من تطابق الهوية</h4>
            <div class="comparison-grid">
                <div class="comparison-item">
                    <div class="label">بيانات مقدم الطلب</div>
                    <div class="value">{{ $register->full_name }}</div>
                </div>
                <div class="comparison-item">
                    <div class="label">بيانات المالك في السجل</div>
                    <div class="value" id="comparison_owner">-</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== قسم اختيار الإشعار ===== --}}
<div class="process-card" id="notificationSection" style="display: none;">
    <h2 class="section-title">
        <span>📧</span>
        <span>اختيار نوع الإشعار</span>
    </h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 1rem;">
        {{-- الإشعار الأول: النسخة قيد الإنجاز --}}
        <div class="copy-type-option" onclick="selectNotification('in_progress', this)" id="notifInProgress">
            <div class="icon">⚙️</div>
            <div class="title">النسخة قيد الإنجاز</div>
            <div class="description">إشعار المواطن بأن طلب النسخة قيد المعالجة</div>
            <div style="margin-top: 1rem; padding: 0.5rem; background: #e8f5e9; border-radius: 10px; font-size: 0.9rem;">
                <strong>الرسالة:</strong> طلبك للنسخة قيد الإنجاز، سيتم إشعارك عند الجاهزية
            </div>
        </div>

        {{-- الإشعار الثاني: لا يملك نسخة ويحتاج دفتر عقاري جديد --}}
        <div class="copy-type-option" onclick="selectNotification('new_register', this)" id="notifNewRegister">
            <div class="icon">📄</div>
            <div class="title">طلب دفتر عقاري جديد</div>
            <div class="description">إشعار المواطن بضرورة طلب دفتر عقاري جديد</div>
            <div style="margin-top: 1rem; padding: 0.5rem; background: #fff3e0; border-radius: 10px; font-size: 0.9rem;">
                <strong>الرسالة:</strong> لا يوجد نسخة متاحة، عليك التقدم بطلب دفتر عقاري جديد
            </div>
        </div>
    </div>

    {{-- معاينة الإيميل --}}
    <div class="email-preview" id="emailPreview">
        <h4>📧 معاينة الإيميل الذي سيتم إرساله</h4>
        <div class="email-content">
            <div class="email-subject" id="emailSubject"></div>
            <div class="email-body" id="emailBody"></div>
        </div>
    </div>
</div>

{{-- ===== النموذج النهائي المتكامل ===== --}}
<form method="POST"
      action="{{ route('admin.land.registers.process-copy-submit', $register->id) }}"
      id="processingForm">
    @csrf
    
    {{-- حقول مخفية لإرضاء التحقق في الـ Controller --}}
    <input type="hidden" name="is_verified" value="1">
    
    {{-- نستخدم القيم الصحيحة المقبولة من قاعدة البيانات --}}
    <input type="hidden" name="copy_type" value="عادية" id="copyTypeField">
    
    {{-- الحقول الفعلية التي نستخدمها --}}
    <input type="hidden" name="selected_property_id" id="selectedPropertyId" value="">
    <input type="hidden" name="property_data" id="propertyData" value="">
    <input type="hidden" name="notification_type" id="notificationType" value="">

    {{-- الملاحظات والإجراء النهائي --}}
    <div class="process-card">
        <h2 class="section-title">
            <span>📝</span>
            <span>إتمام المعالجة</span>
        </h2>
        
        <div style="margin-bottom: 2rem;">
            <label style="display: block; font-weight: 700; color: var(--primary-green); margin-bottom: 1rem; font-size: 1.1rem;">
                <span>📌</span> ملاحظات المعالجة (اختياري)
            </label>
            <textarea name="admin_notes" class="form-control" rows="4"
                      placeholder="أضف ملاحظاتك هنا ...">{{ old('admin_notes') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <button type="button" class="btn-submit" style="background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);" 
                    onclick="if(confirm('⚠️ هل أنت متأكد من رفض هذا الطلب؟\n\nهذا الإجراء لا يمكن التراجع عنه.')) { document.getElementById('rejectForm').submit(); }">
                <span>❌</span>
                <span>رفض الطلب</span>
            </button>
            <button type="submit" class="btn-submit" id="btnSubmit" disabled>
                <span>📧</span>
                <span>إرسال الإشعار</span>
            </button>
        </div>
    </div>
</form>

{{-- نموذج الرفض المخفي --}}
<form method="POST" action="{{ route('admin.land.registers.reject', $register->id) }}" id="rejectForm" style="display: none;">
    @csrf
</form>

<script>
// ==============================
// المتغيرات العامة
// ==============================
let selectedProperty = null;
let propertyFound = false;
let selectedNotification = '';

// URL البحث
const SEARCH_URL = "{{ route('admin.land.properties.search') }}";
const CSRF_TOKEN = "{{ csrf_token() }}";

// ==============================
// دالة البحث المتطورة
// ==============================
function doSearch() {
    const section = document.getElementById('section').value.trim();
    const number = document.getElementById('number').value.trim();
    const location = document.getElementById('location').value.trim();

    if (!section || !number) {
        alert('⚠️ يرجى إدخال القسم والرقم');
        return;
    }

    const btn = document.getElementById('searchBtn');
    const container = document.getElementById('resultsContainer');
    const resultsSection = document.getElementById('resultsSection');
    
    // تعطيل الزر وإظهار التحميل
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner" style="width: 25px; height: 25px; border-width: 3px;"></span> جاري البحث في قاعدة البيانات...';
    resultsSection.style.display = 'block';
    container.innerHTML = '<div class="loading-container"><div class="spinner"></div><div style="font-size: 1.2rem;">جاري البحث عن العقار ...</div></div>';

    // إرسال الطلب
    fetch(SEARCH_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            section: section,
            number: number,
            location: location
        })
    })
    .then(async response => {
        const data = await response.json();
        if (!response.ok) throw new Error(data.message || `خطأ ${response.status}`);
        return data;
    })
    .then(data => {
        if (data.success && data.found) {
            propertyFound = true;
            renderProperty(data.data);
            document.getElementById('resultCount').textContent = '✅ تم العثور على عقار واحد';
            
            // إظهار قسم الإشعارات
            document.getElementById('notificationSection').style.display = 'block';
        } else {
            propertyFound = false;
            renderNoResults(data.message || 'لم يتم العثور على عقار مطابق');
        }
    })
    .catch(err => {
        console.error('Search Error:', err);
        propertyFound = false;
        renderNoResults(err.message);
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<span>🔍</span><span>بحث في السجلات</span>';
    });
}

// ==============================
// عرض العقار بتصميم متطور
// ==============================
function renderProperty(property) {
    const container = document.getElementById('resultsContainer');
    
    const badgeClass = property.property_type === 'ممسوح' ? 'badge-surveyed' : 'badge-not-surveyed';
    const fatherName = property.father_name ? `بن ${property.father_name}` : '';
    
    const html = `
        <div class="property-card" id="property-${property.id}">
            <div class="card-header">
                <div class="owner-info">
                    <h4>${property.owner_name || 'غير معروف'}</h4>
                    <span>${fatherName}</span>
                </div>
                <span class="property-badge ${badgeClass}">${property.property_type || 'عقار'}</span>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <span class="info-label">رقم التعريف الوطني</span>
                    <span class="info-value" dir="ltr">${property.national_id || '-'}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">تاريخ الميلاد</span>
                    <span class="info-value">${property.birth_date || '-'}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">مكان الميلاد</span>
                    <span class="info-value">${property.birth_place || '-'}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">القسم</span>
                    <span class="info-value">${property.section || '-'}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">الرقم</span>
                    <span class="info-value">${property.number || '-'}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">الموقع</span>
                    <span class="info-value">${property.location || 'غير محدد'}</span>
                </div>
            </div>
            <div class="register-box">
                <div class="label">رقم الدفتر العقاري</div>
                <div class="value">${property.register_number || '-'}</div>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin: 1rem 0; padding: 0 0.5rem;">
                <span style="font-size: 1rem; color: var(--text-gray);">المساحة</span>
                <span style="font-size: 1.3rem; font-weight: 800; color: var(--primary-green);">${property.area ? property.area + ' م²' : 'غير محدد'}</span>
            </div>
            <button type="button" class="btn-select" onclick='selectProperty(${property.id}, this, ${JSON.stringify(property).replace(/'/g, "\\'")})'>
                <span>🔘</span> اختيار هذا العقار
            </button>
        </div>
    `;
    
    container.innerHTML = html;
}

// ==============================
// عرض حالة عدم وجود نتائج
// ==============================
function renderNoResults(message) {
    const container = document.getElementById('resultsContainer');
    document.getElementById('resultCount').textContent = '❌ لا توجد نتائج';
    
    container.innerHTML = `
        <div class="no-property-found">
            <div class="icon">🏠❌</div>
            <h3>لم يتم العثور على العقار</h3>
            <p>${message}</p>
            <p style="font-size: 1rem;">تأكد من صحة البيانات المدخلة: القسم والرقم</p>
            <button type="button" class="btn-reject" onclick="document.getElementById('rejectForm').submit();">
                <span>❌</span> رفض الطلب
            </button>
        </div>
    `;
}

// ==============================
// اختيار عقار
// ==============================
function selectProperty(propertyId, btn, propertyData) {
    // إزالة التحديد السابق
    document.querySelectorAll('.property-card').forEach(c => c.classList.remove('selected'));
    document.querySelectorAll('.btn-select').forEach(b => {
        b.classList.remove('selected');
        b.innerHTML = '<span>🔘</span> اختيار هذا العقار';
    });
    
    // تحديد العقار الحالي
    const card = document.getElementById('property-' + propertyId);
    card.classList.add('selected');
    btn.classList.add('selected');
    btn.innerHTML = '<span>✓</span> تم الاختيار';
    
    // حفظ بيانات العقار
    selectedProperty = propertyData;
    
    // تحديث الحقول المخفية
    document.getElementById('selectedPropertyId').value = propertyId;
    document.getElementById('propertyData').value = JSON.stringify(propertyData);
    
    // إظهار التفاصيل
    showPropertyDetails(propertyData);
    
    // التمرير للوحة التحقق
    document.getElementById('propertyDisplay').scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// ==============================
// عرض تفاصيل العقار المختار
// ==============================
function showPropertyDetails(p) {
    document.getElementById('verificationBox').style.display = 'none';
    document.getElementById('propertyDisplay').classList.add('show');
    
    document.getElementById('display_owner').textContent = p.owner_name || '-';
    document.getElementById('display_register').textContent = p.register_number || '-';
    document.getElementById('display_type').textContent = p.property_type || '-';
    document.getElementById('display_location').textContent = p.location || '-';
    document.getElementById('display_area').textContent = p.area ? p.area + ' م²' : '-';
    document.getElementById('display_national_id').textContent = p.national_id || '-';
    
    // تحديث المقارنة
    document.getElementById('comparison_owner').textContent = p.owner_name || '-';
}

// ==============================
// اختيار نوع الإشعار
// ==============================
function selectNotification(type, element) {
    // إزالة التحديد السابق
    document.querySelectorAll('.copy-type-option').forEach(opt => {
        opt.classList.remove('selected');
    });
    
    // تحديد العنصر الحالي
    element.classList.add('selected');
    
    // حفظ نوع الإشعار
    selectedNotification = type;
    document.getElementById('notificationType').value = type;
    
    // إظهار معاينة الإيميل
    showEmailPreview(type);
    
    // تفعيل زر الإرسال
    document.getElementById('btnSubmit').disabled = false;
}

// ==============================
// معاينة الإيميل
// ==============================
function showEmailPreview(type) {
    const preview = document.getElementById('emailPreview');
    const subject = document.getElementById('emailSubject');
    const body = document.getElementById('emailBody');
    const applicantName = "{{ $register->full_name }}";
    
    preview.style.display = 'block';
    
    if (type === 'in_progress') {
        subject.textContent = '⚙️ طلب نسخة الدفتر العقاري قيد الإنجاز';
        body.innerHTML = `
            <p><strong>السيد(ة) ${applicantName}،</strong></p>
            <p>نود إعلامك بأن طلبك للحصول على نسخة من الدفتر العقاري قيد المعالجة.</p>
            ${selectedProperty ? `
            <div style="background: #e8f5e9; padding: 1rem; border-radius: 10px; margin: 1rem 0;">
                <strong>📋 تفاصيل العقار:</strong><br>
                المالك: ${selectedProperty.owner_name}<br>
                رقم الدفتر: ${selectedProperty.register_number}<br>
                الموقع: ${selectedProperty.location}
            </div>
            ` : ''}
            <p><strong>📌 حالة الطلب:</strong> قيد الإنجاز</p>
            <p>سيتم إشعارك فور جاهزية النسخة عبر البريد الإلكتروني أو رسالة نصية.</p>
            <p>مع جزيل الشكر،<br>المحافظة العقارية</p>
        `;
    } else if (type === 'new_register') {
        subject.textContent = '📄 طلب دفتر عقاري جديد';
        body.innerHTML = `
            <p><strong>السيد(ة) ${applicantName}،</strong></p>
            <p>بالإشارة إلى طلبك للحصول على نسخة من الدفتر العقاري،</p>
            <p><strong>❌ لا توجد نسخة متاحة للعقار المطلوب.</strong></p>
            <p>للاستفادة من الخدمة، عليك التقدم بطلب للحصول على دفتر عقاري جديد.</p>
            <p><strong>📌 الإجراءات المطلوبة:</strong></p>
            <ul>
                <li>تعبئة استمارة طلب دفتر عقاري جديد</li>
                <li>إرفاق المستندات التالية:
                    <ul>
                        <li>عقد الملكية</li>
                        <li>بطاقة التعريف الوطنية</li>
                        <li>شهادة الإقامة</li>
                        <li>رسوم التسجيل</li>
                    </ul>
                </li>
                <li>تقديم الملف إلى مصالح المحافظة العقارية</li>
            </ul>
            <p>لمزيد من المعلومات، يرجى الاتصال بنا.</p>
        `;
    }
}

// ==============================
// تفعيل البحث بالضغط على Enter
// ==============================
['section', 'number', 'location'].forEach(id => {
    const input = document.getElementById(id);
    if (input) {
        input.addEventListener('keypress', e => {
            if (e.key === 'Enter') { 
                e.preventDefault(); 
                doSearch(); 
            }
        });
    }
});

// ==============================
// تأكيد قبل الإرسال النهائي
// ==============================
document.getElementById('processingForm').addEventListener('submit', e => {
    if (!selectedNotification) {
        e.preventDefault();
        alert('⚠️ الرجاء اختيار نوع الإشعار أولاً');
        return;
    }
    
    // تحديث قيمة copy_type حسب نوع الإشعار (اختياري)
    if (selectedNotification === 'in_progress') {
        document.getElementById('copyTypeField').value = 'عادية';
    } else if (selectedNotification === 'new_register') {
        document.getElementById('copyTypeField').value = 'مطابقة للأصل';
    }
    
    if (!confirm('📧 تأكيد إرسال الإشعار\n\nهل أنت متأكد من إرسال هذا الإشعار للمواطن؟')) {
        e.preventDefault();
    }
});
</script>

@endsection