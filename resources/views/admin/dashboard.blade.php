@extends('admin.layout')

@section('title', 'لوحة التحكم')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #1a5632;
        --primary-light: #2e7d4a;
        --secondary: #c49b63;
        --success: #28a745;
        --info: #17a2b8;
        --warning: #ffc107;
        --danger: #dc3545;
        --purple: #6f42c1;
        --white: #ffffff;
        --light: #f8f6f1;
    }

    body {
        font-family: 'Cairo', sans-serif;
        background: linear-gradient(135deg, #f8f6f1 0%, #e8e3d9 100%);
    }

    .dashboard-container {
        padding: 2rem;
        min-height: 100vh;
    }

    /* Welcome Header */
    .welcome-header {
        background: linear-gradient(135deg, #1a5632 0%, #0d3d20 100%);
        padding: 3rem;
        border-radius: 40px;
        box-shadow: 0 25px 70px rgba(26, 86, 50, 0.4);
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
        animation: slideInDown 1s ease;
    }

    @keyframes slideInDown {
        from { opacity: 0; transform: translateY(-50px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .welcome-header::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulse 8s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.15; }
        50% { transform: scale(1.3); opacity: 0.25; }
    }

    .welcome-header::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: -50px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(196, 155, 99, 0.2) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-30px); }
    }

    .welcome-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .welcome-text h1 {
        color: var(--white);
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: 0.8rem;
        text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
        letter-spacing: -1px;
    }

    .welcome-text h1 .wave {
        display: inline-block;
        animation: wave 2s ease-in-out infinite;
        transform-origin: 70% 70%;
    }

    @keyframes wave {
        0%, 100% { transform: rotate(0deg); }
        10%, 30% { transform: rotate(14deg); }
        20% { transform: rotate(-8deg); }
        40% { transform: rotate(-4deg); }
        50% { transform: rotate(10deg); }
    }

    .welcome-text p {
        color: rgba(255,255,255,0.95);
        font-size: 1.4rem;
        font-weight: 400;
        letter-spacing: 0.5px;
    }

    .welcome-time {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(20px);
        padding: 1.5rem 3rem;
        border-radius: 100px;
        border: 3px solid rgba(255,255,255,0.3);
        box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    }

    .welcome-time .date {
        color: var(--white);
        font-size: 1.5rem;
        font-weight: 800;
        text-align: center;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: var(--white);
        border-radius: 35px;
        padding: 2.5rem;
        box-shadow: 0 15px 50px rgba(0,0,0,0.08);
        position: relative;
        overflow: hidden;
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.8s ease backwards;
        border: 2px solid transparent;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }
    .stat-card:nth-child(5) { animation-delay: 0.5s; }
    .stat-card:nth-child(6) { animation-delay: 0.6s; }
    .stat-card:nth-child(7) { animation-delay: 0.7s; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(50px) scale(0.9); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 8px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.6s ease;
    }

    .stat-card:hover {
        transform: translateY(-20px) scale(1.03);
        box-shadow: 0 30px 80px rgba(0,0,0,0.15);
        border-color: var(--primary);
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card::after {
        content: '';
        position: absolute;
        bottom: -80px;
        right: -80px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        opacity: 0.08;
        transition: all 0.6s ease;
    }

    .stat-card.certificates::after { background: #17a2b8; }
    .stat-card.documents::after { background: #ffc107; }
    .stat-card.land-registers::after { background: #1a5632; }
    .stat-card.bookings::after { background: #6f42c1; }
    .stat-card.messages::after { background: #c49b63; }
    .stat-card.users::after { background: #28a745; }
    .stat-card.extracts::after { background: #e74c3c; }

    .stat-card:hover::after {
        transform: scale(1.5);
        opacity: 0.15;
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .stat-icon {
        width: 90px;
        height: 90px;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        transition: all 0.5s ease;
        position: relative;
        z-index: 2;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.15) rotate(15deg);
        box-shadow: 0 15px 40px rgba(0,0,0,0.25);
    }

    .stat-card.certificates .stat-icon {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: var(--white);
    }

    .stat-card.documents .stat-icon {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: var(--white);
    }

    .stat-card.land-registers .stat-icon {
        background: linear-gradient(135deg, #1a5632, #2e7d4a);
        color: var(--white);
    }

    .stat-card.bookings .stat-icon {
        background: linear-gradient(135deg, #6f42c1, #5a32a3);
        color: var(--white);
    }

    .stat-card.messages .stat-icon {
        background: linear-gradient(135deg, #c49b63, #d4b185);
        color: var(--white);
    }

    .stat-card.users .stat-icon {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: var(--white);
    }

    .stat-card.extracts .stat-icon {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: var(--white);
    }

    .stat-badge {
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        animation: slideInRight 0.5s ease;
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .stat-card.certificates .stat-badge {
        background: rgba(23, 162, 184, 0.15);
        color: #17a2b8;
        border: 2px solid #17a2b8;
    }

    .stat-card.documents .stat-badge {
        background: rgba(255, 193, 7, 0.15);
        color: #ff9800;
        border: 2px solid #ff9800;
    }

    .stat-card.land-registers .stat-badge {
        background: rgba(26, 86, 50, 0.15);
        color: #1a5632;
        border: 2px solid #1a5632;
    }

    .stat-card.bookings .stat-badge {
        background: rgba(111, 66, 193, 0.15);
        color: #6f42c1;
        border: 2px solid #6f42c1;
    }

    .stat-card.messages .stat-badge {
        background: rgba(196, 155, 99, 0.15);
        color: #c49b63;
        border: 2px solid #c49b63;
    }

    .stat-card.users .stat-badge {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
        border: 2px solid #28a745;
    }

    .stat-card.extracts .stat-badge {
        background: rgba(231, 76, 60, 0.15);
        color: #e74c3c;
        border: 2px solid #e74c3c;
    }

    .stat-content {
        position: relative;
        z-index: 2;
    }

    .stat-content h3 {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .stat-number {
        font-size: 4rem;
        font-weight: 900;
        color: var(--primary);
        line-height: 1;
        margin-bottom: 1.5rem;
        text-shadow: 3px 3px 6px rgba(0,0,0,0.1);
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-change {
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        font-size: 1rem;
        padding: 0.7rem 1.5rem;
        border-radius: 50px;
        font-weight: 700;
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.15), rgba(40, 167, 69, 0.05));
        color: var(--success);
        border: 2px solid rgba(40, 167, 69, 0.3);
        transition: all 0.3s ease;
    }

    .stat-change:hover {
        background: var(--success);
        color: var(--white);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
    }

    /* Table Cards */
    .table-card {
        background: var(--white);
        border-radius: 40px;
        padding: 3rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        margin-bottom: 3rem;
        border: 2px solid transparent;
        transition: all 0.5s ease;
        animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .table-card:hover {
        box-shadow: 0 30px 80px rgba(0,0,0,0.12);
        transform: translateY(-8px);
        border-color: var(--primary);
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        padding-bottom: 2rem;
        border-bottom: 3px dashed rgba(26, 86, 50, 0.2);
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .table-header h2 {
        font-size: 2.2rem;
        color: var(--primary);
        font-weight: 900;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        letter-spacing: -0.5px;
    }

    .table-header h2 span:first-child {
        font-size: 3rem;
        filter: drop-shadow(3px 3px 8px rgba(0,0,0,0.2));
        animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }

    .filter-btn {
        padding: 1rem 3rem;
        border: none;
        background: linear-gradient(135deg, #1a5632, #2e7d4a);
        color: var(--white);
        border-radius: 100px;
        font-weight: 800;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.5s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        box-shadow: 0 8px 25px rgba(26, 86, 50, 0.3);
        position: relative;
        overflow: hidden;
    }

    .filter-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        transform: translate(-50%, -50%);
        transition: width 0.8s, height 0.8s;
    }

    .filter-btn:hover::before {
        width: 400px;
        height: 400px;
    }

    .filter-btn:hover {
        transform: translateX(-10px) scale(1.05);
        box-shadow: 0 15px 40px rgba(26, 86, 50, 0.5);
    }

    .table-wrapper {
        overflow-x: auto;
        border-radius: 25px;
    }

    .requests-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .requests-table thead {
        background: linear-gradient(135deg, #1a5632, #0d3d20);
    }

    .requests-table th {
        padding: 1.5rem 1.2rem;
        text-align: center;
        font-weight: 800;
        color: var(--white);
        font-size: 1rem;
        letter-spacing: 1px;
        white-space: nowrap;
        text-transform: uppercase;
    }

    .requests-table th:first-child {
        border-radius: 20px 0 0 0;
    }

    .requests-table th:last-child {
        border-radius: 0 20px 0 0;
    }

    .requests-table tbody tr {
        transition: all 0.5s ease;
        border-bottom: 2px solid rgba(26, 86, 50, 0.05);
        background: var(--white);
    }

    .requests-table tbody tr:nth-child(even) {
        background: rgba(248, 246, 241, 0.5);
    }

    .requests-table tbody tr:hover {
        background: linear-gradient(135deg, rgba(26, 86, 50, 0.08), rgba(46, 125, 74, 0.05));
        transform: scale(1.02);
        box-shadow: 0 10px 40px rgba(26, 86, 50, 0.15);
        position: relative;
        z-index: 10;
    }

    .requests-table td {
        padding: 1.5rem 1.2rem;
        text-align: center;
        color: #2c3e50;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .requests-table td strong {
        color: var(--primary);
        font-size: 1.2rem;
        font-weight: 900;
    }

    .requests-table td small {
        color: #666;
        font-size: 0.85rem;
        display: block;
        margin-top: 0.3rem;
    }

    .status-badge {
        display: inline-block;
        padding: 0.7rem 1.5rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: 2px solid;
    }

    .status-badge:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    .status-badge.pending {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #1976d2;
        border-color: #1976d2;
    }

    .status-badge.approved {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        color: #2e7d32;
        border-color: #2e7d32;
    }

    .status-badge.rejected {
        background: linear-gradient(135deg, #ffebee, #ffcdd2);
        color: #c62828;
        border-color: #c62828;
    }

    .status-badge.processing {
        background: linear-gradient(135deg, #fff3e0, #ffe0b2);
        color: #f57c00;
        border-color: #f57c00;
    }

    .status-badge.confirmed {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        color: #2e7d32;
        border-color: #2e7d32;
    }

    .status-badge.cancelled {
        background: linear-gradient(135deg, #ffebee, #ffcdd2);
        color: #c62828;
        border-color: #c62828;
    }

    .status-badge.new {
        background: linear-gradient(135deg, #f3e5f5, #e1bee7);
        color: #7b1fa2;
        border-color: #7b1fa2;
    }

    .status-badge.read {
        background: linear-gradient(135deg, #e0f2f1, #b2dfdb);
        color: #00796b;
        border-color: #00796b;
    }

    /* Type Badge */
    .type-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
        white-space: nowrap;
        border: 2px solid;
    }

    .type-badge.new {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.15), rgba(40, 167, 69, 0.05));
        color: #28a745;
        border-color: rgba(40, 167, 69, 0.3);
    }

    .type-badge.reprint {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.15), rgba(23, 162, 184, 0.05));
        color: #17a2b8;
        border-color: rgba(23, 162, 184, 0.3);
    }

    .type-badge.seizure {
        background: linear-gradient(135deg, rgba(26, 86, 50, 0.15), rgba(26, 86, 50, 0.05));
        color: #1a5632;
        border-color: rgba(26, 86, 50, 0.3);
    }

    .type-badge.sale {
        background: linear-gradient(135deg, rgba(196, 155, 99, 0.15), rgba(196, 155, 99, 0.05));
        color: #8b6f47;
        border-color: rgba(196, 155, 99, 0.3);
    }

    .type-badge.gift {
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.15), rgba(255, 107, 107, 0.05));
        color: #dc3545;
        border-color: rgba(255, 107, 107, 0.3);
    }

    .type-badge.mortgage {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.15), rgba(52, 152, 219, 0.05));
        color: #3498db;
        border-color: rgba(52, 152, 219, 0.3);
    }

    .type-badge.cancellation {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(255, 193, 7, 0.05));
        color: #f39c12;
        border-color: rgba(255, 193, 7, 0.3);
    }

    .type-badge.petition {
        background: linear-gradient(135deg, rgba(155, 89, 182, 0.15), rgba(155, 89, 182, 0.05));
        color: #9b59b6;
        border-color: rgba(155, 89, 182, 0.3);
    }

    .type-badge.ownership {
        background: linear-gradient(135deg, rgba(46, 204, 113, 0.15), rgba(46, 204, 113, 0.05));
        color: #27ae60;
        border-color: rgba(46, 204, 113, 0.3);
    }

    .action-buttons {
        display: flex;
        gap: 0.8rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1.5rem;
        border-radius: 15px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 800;
        transition: all 0.4s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }

    .action-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .action-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .action-btn:hover {
        transform: translateY(-5px) scale(1.08);
        box-shadow: 0 12px 30px rgba(0,0,0,0.25);
    }

    .action-btn.view {
        background: linear-gradient(135deg, #1a5632, #2e7d4a);
        color: var(--white);
    }

    .action-btn.process {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: var(--white);
    }

    .action-btn.confirm {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: var(--white);
    }

    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        color: var(--primary);
    }

    .empty-state .icon {
        font-size: 8rem;
        margin-bottom: 2rem;
        opacity: 0.3;
        animation: float 3s ease-in-out infinite;
    }

    .empty-state p {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .empty-state small {
        font-size: 1rem;
        color: #666;
    }

    @media (max-width: 768px) {
        .dashboard-container { padding: 1rem; }
        .stats-grid { grid-template-columns: 1fr; }
        .welcome-text h1 { font-size: 2rem; }
        .welcome-header { padding: 2rem; }
        .table-card { padding: 1.5rem; }
        .action-buttons { flex-direction: column; }
    }
</style>

<div class="dashboard-container">

    <!-- Welcome Header -->
    <div class="welcome-header">
        <div class="welcome-content">
            <div class="welcome-text">
                <h1><span class="wave">👋</span> مرحباً بعودتك!</h1>
                <p>نظرة شاملة على أداء النظام وإحصائيات اليوم</p>
            </div>
            <div class="welcome-time">
                <div class="date" id="currentDate"></div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card certificates">
            <div class="stat-header">
                <div class="stat-icon">📄</div>
                <div class="stat-badge">الشهادات</div>
            </div>
            <div class="stat-content">
                <h3>الشهادات السلبية</h3>
                <div class="stat-number">{{ \App\Models\NegativeCertificate::count() }}</div>
                <span class="stat-change">
                    <span>📈</span>
                    <span>+{{ \App\Models\NegativeCertificate::whereDate('created_at', today())->count() }} اليوم</span>
                </span>
            </div>
        </div>

        <div class="stat-card documents">
            <div class="stat-header">
                <div class="stat-icon">📑</div>
                <div class="stat-badge">البطاقات</div>
            </div>
            <div class="stat-content">
                <h3>البطاقات العقارية</h3>
                <div class="stat-number">{{ \App\Models\DocumentsRequest::count() }}</div>
                <span class="stat-change">
                    <span>📈</span>
                    <span>+{{ \App\Models\DocumentsRequest::whereDate('created_at', today())->count() }} اليوم</span>
                </span>
            </div>
        </div>

        <div class="stat-card land-registers">
            <div class="stat-header">
                <div class="stat-icon">🏛️</div>
                <div class="stat-badge">الدفاتر</div>
            </div>
            <div class="stat-content">
                <h3>الدفاتر العقارية</h3>
                <div class="stat-number">{{ \App\Models\LandRegister::count() }}</div>
                <span class="stat-change">
                    <span>📈</span>
                    <span>+{{ \App\Models\LandRegister::whereDate('created_at', today())->count() }} اليوم</span>
                </span>
            </div>
        </div>

        <div class="stat-card extracts">
            <div class="stat-header">
                <div class="stat-icon">📋</div>
                <div class="stat-badge">المستخرجات</div>
            </div>
            <div class="stat-content">
                <h3>مستخرجات العقود</h3>
                <div class="stat-number">{{ \App\Models\ContractExtract::count() }}</div>
                <span class="stat-change">
                    <span>📈</span>
                    <span>+{{ \App\Models\ContractExtract::whereDate('created_at', today())->count() }} اليوم</span>
                </span>
            </div>
        </div>

        <div class="stat-card bookings">
            <div class="stat-header">
                <div class="stat-icon">📅</div>
                <div class="stat-badge">الحجوزات</div>
            </div>
            <div class="stat-content">
                <h3>حجوزات المواعيد</h3>
                <div class="stat-number">{{ \App\Models\Appointment::count() }}</div>
                <span class="stat-change">
                    <span>🔔</span>
                    <span>{{ \App\Models\Appointment::where('status', 'pending')->count() }} معلقة</span>
                </span>
            </div>
        </div>

        <div class="stat-card messages">
            <div class="stat-header">
                <div class="stat-icon">📩</div>
                <div class="stat-badge">الرسائل</div>
            </div>
            <div class="stat-content">
                <h3>رسائل التواصل</h3>
                <div class="stat-number">{{ \App\Models\ContactMessage::count() }}</div>
                <span class="stat-change">
                    <span>🔔</span>
                    <span>{{ \App\Models\ContactMessage::where('status', 'new')->count() }} جديدة</span>
                </span>
            </div>
        </div>

       
    </div>

    <!-- ✅✅✅ آخر طلبات الشهادات السلبية - نفس طريقة صفحة index ✅✅✅ -->
    <div class="table-card">
        <div class="table-header">
            <h2>
                <span>📄</span>
                <span>آخر طلبات الشهادات السلبية</span>
            </h2>
            <a href="{{ route('admin.certificates.index') }}" class="filter-btn">
                <span>عرض الكل</span>
                <span>←</span>
            </a>
        </div>
        <div class="table-wrapper">
            <table class="requests-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم الكامل</th>
                        <th>البريد الإلكتروني</th>
                        <th>نوع الطلب</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // ✅ جلب البيانات بنفس طريقة صفحة index
                        $latestCertificates = \App\Models\NegativeCertificate::orderBy('created_at', 'desc')->take(5)->get();
                    @endphp
                    
                    @forelse($latestCertificates as $certificate)
                    <tr>
                        <td><strong>#{{ $certificate->id }}</strong></td>
                        <!-- ✅✅✅ نفس طريقة العرض في صفحة index ✅✅✅ -->
                        <td>
                            <strong style="color: var(--primary); font-size: 1.1rem;">
                                {{ $certificate->owner_firstname }} {{ $certificate->owner_lastname }}
                            </strong>
                        </td>
                        <td><small>{{ $certificate->email ?? 'غير متوفر' }}</small></td>
                        <td>
                            @if($certificate->type == 'new')
                                <span class="type-badge new">🆕 جديدة</span>
                            @elseif($certificate->type == 'reprint')
                                <span class="type-badge reprint">🔄 إعادة استخراج</span>
                            @else
                                <span class="type-badge" style="background: linear-gradient(135deg, rgba(108, 117, 125, 0.15), rgba(108, 117, 125, 0.05)); color: #6c757d; border-color: rgba(108, 117, 125, 0.3);">
                                    {{ $certificate->type }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $certificate->status }}">
                                @if($certificate->status == 'pending')
                                    ⏳ قيد الانتظار
                                @elseif($certificate->status == 'processing')
                                    🔄 قيد المعالجة
                                @elseif($certificate->status == 'approved')
                                    ✅ موافق عليها
                                @elseif($certificate->status == 'rejected')
                                    ❌ مرفوضة
                                @else
                                    {{ $certificate->status }}
                                @endif
                            </span>
                        </td>
                        <td>{{ $certificate->created_at->format('Y/m/d') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.certificates.show', $certificate->id) }}" class="action-btn view">
                                    <span>👁️</span>
                                    <span>عرض</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="icon">📭</div>
                                <p>لا توجد طلبات شهادات سلبية</p>
                                <small>عند تقديم طلبات جديدة ستظهر هنا</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- آخر مستخرجات العقود -->
    <div class="table-card">
        <div class="table-header">
            <h2>
                <span>📋</span>
                <span>آخر مستخرجات العقود</span>
            </h2>
            <a href="{{ route('admin.extracts.index') }}" class="filter-btn">
                <span>عرض الكل</span>
                <span>←</span>
            </a>
        </div>
        <div class="table-wrapper">
            <table class="requests-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نوع العقد</th>
                        <th>المقدم</th>
                        <th>رقم المجلد</th>
                        <th>رقم النشر</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $latestExtracts = \App\Models\ContractExtract::orderBy('created_at', 'desc')->take(5)->get();
                    @endphp
                    
                    @forelse($latestExtracts as $extract)
                    @php
                        $typeClass = '';
                        $typeLabel = '';
                        $typeIcon = '';
                        
                        switch($extract->extract_type) {
                            case 'seizure':
                                $typeClass = 'seizure';
                                $typeLabel = 'حجز';
                                $typeIcon = '🔒';
                                break;
                            case 'sale':
                                $typeClass = 'sale';
                                $typeLabel = 'عقد بيع';
                                $typeIcon = '💰';
                                break;
                            case 'gift':
                                $typeClass = 'gift';
                                $typeLabel = 'عقد هبة';
                                $typeIcon = '🎁';
                                break;
                            case 'mortgage':
                                $typeClass = 'mortgage';
                                $typeLabel = 'رهن أو امتياز';
                                $typeIcon = '🏦';
                                break;
                            case 'cancellation':
                                $typeClass = 'cancellation';
                                $typeLabel = 'تشطيب';
                                $typeIcon = '✂️';
                                break;
                            case 'petition':
                                $typeClass = 'petition';
                                $typeLabel = 'عريضة';
                                $typeIcon = '📝';
                                break;
                            case 'ownership':
                                $typeClass = 'ownership';
                                $typeLabel = 'وثيقة ناقلة للملكية';
                                $typeIcon = '📜';
                                break;
                            default:
                                $typeClass = 'seizure';
                                $typeLabel = $extract->extract_type ?? 'غير محدد';
                                $typeIcon = '📄';
                        }
                        
                        $extractStatus = $extract->status ?? 'قيد المعالجة';
                        $statusClass = 'pending';
                        $statusText = '⏳ ' . $extractStatus;
                        
                        if ($extractStatus == 'مقبول') {
                            $statusClass = 'approved';
                            $statusText = '✅ مقبول';
                        } elseif ($extractStatus == 'مرفوض') {
                            $statusClass = 'rejected';
                            $statusText = '❌ مرفوض';
                        }
                    @endphp
                    <tr>
                        <td><strong>#{{ $extract->id }}</strong></td>
                        <td>
                            <span class="type-badge {{ $typeClass }}">
                                {{ $typeIcon }} {{ $typeLabel }}
                            </span>
                        </td>
                        <td>{{ $extract->applicant_lastname }} {{ $extract->applicant_firstname }}</td>
                        <td><strong>{{ $extract->volume_number ?? '-' }}</strong></td>
                        <td><strong>{{ $extract->publication_number ?? '-' }}</strong></td>
                        <td>
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                        <td>{{ $extract->created_at->format('Y/m/d') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.extracts.show', $extract->id) }}" class="action-btn view">
                                    <span>👁️</span>
                                    <span>عرض</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="icon">📭</div>
                                <p>لا توجد مستخرجات عقود</p>
                                <small>عند تقديم طلبات جديدة ستظهر هنا</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- آخر طلبات البطاقات العقارية -->
    <div class="table-card">
        <div class="table-header">
            <h2>
                <span>📑</span>
                <span>آخر طلبات البطاقات العقارية</span>
            </h2>
            <a href="{{ route('admin.documents.index') }}" class="filter-btn">
                <span>عرض الكل</span>
                <span>←</span>
            </a>
        </div>
        <div class="table-wrapper">
            <table class="requests-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>صاحب الملكية</th>
                        <th>نوع البطاقة</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $latestDocuments = \App\Models\DocumentsRequest::orderBy('created_at', 'desc')->take(5)->get();
                    @endphp
                    
                    @forelse($latestDocuments as $document)
                    @php
                        $docStatus = $document->status ?? 'pending';
                        $docClass = 'pending';
                        $docText = '⏳ قيد المعالجة';
                        
                        if ($docStatus == 'approved') {
                            $docClass = 'approved';
                            $docText = '✅ مقبول';
                        } elseif ($docStatus == 'rejected') {
                            $docClass = 'rejected';
                            $docText = '❌ مرفوض';
                        } elseif ($docStatus == 'processing') {
                            $docClass = 'processing';
                            $docText = '⚙️ قيد المعالجة';
                        }
                    @endphp
                    <tr>
                        <td><strong>#{{ $document->id }}</strong></td>
                        <td>{{ $document->applicant_lastname }} {{ $document->applicant_firstname }}</td>
                        <td>{{ $document->document_type ?? 'بطاقة عقارية' }}</td>
                        <td>
                            <span class="status-badge {{ $docClass }}">{{ $docText }}</span>
                        </td>
                        <td>{{ $document->created_at->format('Y/m/d') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.documents.show', $document->id) }}" class="action-btn view">
                                    <span>👁️</span>
                                    <span>عرض</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="icon">📭</div>
                                <p>لا توجد طلبات بطاقات عقارية</p>
                                <small>عند تقديم طلبات جديدة ستظهر هنا</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- آخر طلبات الدفتر العقاري -->
    <div class="table-card">
        <div class="table-header">
            <h2>
                <span>🏛️</span>
                <span>آخر طلبات الدفتر العقاري</span>
            </h2>
            <a href="{{ route('admin.land.registers.index') }}" class="filter-btn">
                <span>عرض الكل</span>
                <span>←</span>
            </a>
        </div>
        <div class="table-wrapper">
            <table class="requests-table">
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>الاسم الكامل</th>
                        <th>رقم الهوية</th>
                        <th>نوع الطلب</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $latestRegisters = \App\Models\LandRegister::orderBy('created_at', 'desc')->take(5)->get();
                    @endphp
                    
                    @forelse($latestRegisters as $register)
                    @php
                        $regStatus = $register->status ?? 'pending';
                        $regClass = 'pending';
                        $regText = '⏳ قيد الانتظار';
                        
                        if ($regStatus == 'approved') {
                            $regClass = 'approved';
                            $regText = '✅ مقبول';
                        } elseif ($regStatus == 'rejected') {
                            $regClass = 'rejected';
                            $regText = '❌ مرفوض';
                        } elseif ($regStatus == 'processing') {
                            $regClass = 'processing';
                            $regText = '⚙️ قيد المعالجة';
                        }
                    @endphp
                    <tr>
                        <td><strong>#{{ $register->id }}</strong></td>
                        <td>{{ $register->full_name ?? 'غير محدد' }}</td>
                        <td>{{ $register->national_id ?? '-' }}</td>
                        <td>{{ $register->request_type ?? 'طلب جديد' }}</td>
                        <td>
                            <span class="status-badge {{ $regClass }}">{{ $regText }}</span>
                        </td>
                        <td>{{ $register->created_at->format('Y/m/d') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.land.registers.show', $register->id) }}" class="action-btn view">
                                    <span>👁️</span>
                                    <span>عرض</span>
                                </a>
                                <a href="{{ url('/admin/land-registers/' . $register->id . '/process-view') }}" class="action-btn process">
                                    <span>⚙️</span>
                                    <span>معالجة</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="icon">🏛️</div>
                                <p>لا توجد طلبات دفتر عقاري</p>
                                <small>عند تقديم طلبات جديدة ستظهر هنا</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- آخر طلبات الحجز -->
    <div class="table-card">
        <div class="table-header">
            <h2>
                <span>📅</span>
                <span>آخر طلبات الحجز</span>
            </h2>
            <a href="{{ route('admin.appointments.index') }}" class="filter-btn">
                <span>عرض الكل</span>
                <span>←</span>
            </a>
        </div>
        <div class="table-wrapper">
            <table class="requests-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم الكامل</th>
                        <th>نوع الخدمة</th>
                        <th>التاريخ المطلوب</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $latestAppointments = \App\Models\Appointment::orderBy('created_at', 'desc')->take(5)->get();
                    @endphp
                    
                    @forelse($latestAppointments as $appointment)
                    @php
                        $appStatus = $appointment->status ?? 'pending';
                        $appClass = 'pending';
                        $appText = '⏳ معلق';
                        
                        if ($appStatus == 'confirmed') {
                            $appClass = 'confirmed';
                            $appText = '✅ مؤكد';
                        } elseif ($appStatus == 'cancelled') {
                            $appClass = 'cancelled';
                            $appText = '❌ ملغي';
                        }
                    @endphp
                    <tr>
                        <td><strong>#{{ $appointment->id }}</strong></td>
                        <td>{{ $appointment->full_name ?? 'غير محدد' }}</td>
                        <td>{{ $appointment->service_type ?? 'غير محدد' }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y/m/d') }}</td>
                        <td>
                            <span class="status-badge {{ $appClass }}">{{ $appText }}</span>
                        </td>
                        <td>{{ $appointment->created_at->format('Y/m/d') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="action-btn view">
                                    <span>👁️</span>
                                    <span>عرض</span>
                                </a>
                                @if($appStatus == 'pending')
                                <a href="{{ route('admin.appointments.confirm', $appointment->id) }}" class="action-btn confirm">
                                    <span>✅</span>
                                    <span>تأكيد</span>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="icon">📭</div>
                                <p>لا توجد طلبات حجز</p>
                                <small>عند تقديم طلبات جديدة ستظهر هنا</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- آخر الرسائل -->
    <div class="table-card">
        <div class="table-header">
            <h2>
                <span>📩</span>
                <span>آخر الرسائل الواردة</span>
            </h2>
            <a href="{{ route('admin.messages.index') }}" class="filter-btn">
                <span>عرض الكل</span>
                <span>←</span>
            </a>
        </div>
        <div class="table-wrapper">
            <table class="requests-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المرسل</th>
                        <th>البريد الإلكتروني</th>
                        <th>الموضوع</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $latestMessages = \App\Models\ContactMessage::orderBy('created_at', 'desc')->take(5)->get();
                    @endphp
                    
                    @forelse($latestMessages as $message)
                    @php
                        $msgStatus = $message->status ?? 'new';
                        $msgClass = $msgStatus == 'new' ? 'new' : 'read';
                        $msgText = $msgStatus == 'new' ? '🆕 جديدة' : '👁️ مقروءة';
                    @endphp
                    <tr>
                        <td><strong>#{{ $message->id }}</strong></td>
                        <td>{{ $message->name ?? 'غير محدد' }}</td>
                        <td><small>{{ $message->email ?? 'غير متوفر' }}</small></td>
                        <td>{{ $message->subject ?? 'رسالة عامة' }}</td>
                        <td>
                            <span class="status-badge {{ $msgClass }}">{{ $msgText }}</span>
                        </td>
                        <td>{{ $message->created_at->format('Y/m/d') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.messages.show', $message->id) }}" class="action-btn view">
                                    <span>👁️</span>
                                    <span>عرض</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="icon">📭</div>
                                <p>لا توجد رسائل</p>
                                <small>عند وصول رسائل جديدة ستظهر هنا</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function updateDateTime() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const dateStr = now.toLocaleDateString('ar-EG', options);
        document.getElementById('currentDate').textContent = dateStr;
    }

    updateDateTime();
    setInterval(updateDateTime, 60000);
</script>

@endsection