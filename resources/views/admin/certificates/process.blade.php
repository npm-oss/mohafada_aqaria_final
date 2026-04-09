@extends('admin.layout')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap');

    * { font-family: 'Cairo', sans-serif; }

    .page-process { animation: fadeInUp 0.6s ease; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .status-header {
        background: linear-gradient(135deg, #1a5632 0%, #0d3d20 50%, #1a5632 100%);
        color: white; padding: 3rem 2rem; border-radius: 25px;
        margin-bottom: 2.5rem; text-align: center; box-shadow: 0 15px 50px rgba(26,86,50,0.3);
        position: relative; overflow: hidden;
    }

    .status-header::before {
        content: '';
        position: absolute; top: -50%; right: -50%; width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(201,160,99,0.15) 0%, transparent 70%);
        animation: rotate 25s linear infinite;
    }

    @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

    .status-header-content { position: relative; z-index: 2; }

    .status-header h2 { font-size: 2.5rem; margin-bottom: 1rem; font-weight: 900; display: flex; align-items: center; justify-content: center; gap: 1rem; }

    .status-header h2 span { animation: pulse 2s ease-in-out infinite; }

    @keyframes pulse { 0%,100%{transform:scale(1);} 50%{transform:scale(1.1);} }

    .status-header p { font-size:1.3rem; opacity:0.95; font-weight:600; }
    .status-badge { display:inline-block; padding:0.8rem 2rem; border-radius:50px; font-weight:800; font-size:1.1rem; margin-top:1rem; background: rgba(255,255,255,0.25); border:3px solid white; backdrop-filter: blur(10px); box-shadow: 0 8px 25px rgba(0,0,0,0.2); }

    .extract-card { background:white; border-radius:25px; padding:3rem; margin-bottom:2.5rem; box-shadow:0 10px 40px rgba(26,86,50,0.12); transition:all 0.4s cubic-bezier(0.4,0,0.2,1); position:relative; overflow:hidden; }
    .extract-card::before { content:''; position:absolute; top:0; left:0; width:100%; height:5px; background: linear-gradient(90deg,#1a5632,#c9a063,#1a5632); background-size:200% 100%; animation:gradient 3s ease infinite; }
    @keyframes gradient { 0%,100%{background-position:0% 50%;} 50%{background-position:100% 50%;} }

    .extract-card h4 { font-size:1.8rem; color:#1a5632; margin-bottom:2rem; padding-bottom:1.2rem; border-bottom:4px solid #c9a063; font-weight:900; display:flex; align-items:center; gap:1rem; }

    .top-actions { display:flex; gap:1.5rem; justify-content:center; flex-wrap:wrap; padding:0; }
    .btn-process, .btn-search, .btn-certificate { padding:1.2rem 2.5rem; border-radius:15px; text-decoration:none; font-weight:800; font-size:1.1rem; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:0.8rem; position:relative; overflow:hidden; transition:all 0.4s cubic-bezier(0.4,0,0.2,1); }
    .btn-process { background: linear-gradient(135deg, #17a2b8, #138496); color:white; box-shadow:0 6px 20px rgba(23,162,184,0.3);}
    .btn-process:hover { transform: translateY(-5px) scale(1.05); box-shadow:0 12px 35px rgba(23,162,184,0.5);}
    .btn-certificate { background: linear-gradient(135deg,#c9a063,#a67c52); box-shadow:0 6px 20px rgba(201,160,99,0.3); color:white;}
    .btn-search { background: linear-gradient(135deg,#dc3545,#c82333); color:white;}
    .btn-process::before, .btn-certificate::before, .btn-search::before { content:''; position:absolute; top:50%; left:50%; width:0; height:0; background:rgba(255,255,255,0.3); border-radius:50%; transform:translate(-50%,-50%); transition:width 0.6s,height 0.6s;}
    .btn-process:hover::before, .btn-certificate:hover::before, .btn-search:hover::before { width:400px; height:400px; }

    .citizen-info .row { display:grid; grid-template-columns:200px 1fr; align-items:center; padding:1.5rem; background:linear-gradient(135deg,#f8f6f1 0%,#ffffff 100%); border-radius:15px; gap:1.5rem; border:2px solid transparent; transition:all 0.3s ease; }
    .citizen-info .row:hover { transform:translateX(-5px); border-color:#c9a063; box-shadow:0 5px 20px rgba(26,86,50,0.1);}
    .citizen-info .row label { font-weight:800; color:#1a5632; display:flex; align-items:center; gap:0.5rem; }
    .citizen-info .row input { padding:1rem 1.5rem; border:3px solid #e0e0e0; border-radius:12px; font-size:1.05rem; background:white; font-weight:600; color:#2d2d2d; transition:all 0.3s ease; }
    .citizen-info .row input:focus { outline:none; border-color:#1a5632; box-shadow:0 0 0 4px rgba(26,86,50,0.15); transform:scale(1.02); }

    .submit-box { text-align:center; padding-top:2rem; margin-top:2rem; border-top:3px solid #c9a063; display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;}
    .submit-box button { padding:1.3rem 4rem; background: linear-gradient(135deg,#1a5632,#2d7a4f); color:white; border:none; border-radius:15px; font-size:1.2rem; font-weight:900; cursor:pointer; display:inline-flex; align-items:center; gap:0.8rem; position:relative; overflow:hidden; transition:all 0.4s cubic-bezier(0.4,0,0.2,1);}
    .submit-box button::before { content:''; position:absolute; top:50%; left:50%; width:0; height:0; background:rgba(255,255,255,0.3); border-radius:50%; transform:translate(-50%,-50%); transition:width 0.6s,height 0.6s; }
    .submit-box button:hover::before { width:500px; height:500px; }
    .submit-box button:hover { transform: translateY(-5px) scale(1.05); box-shadow:0 15px 45px rgba(26,86,50,0.5); }

    .modal-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:10000; backdrop-filter:blur(5px);}
    .modal-content { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); background:white; border-radius:25px; width:95%; max-width:1400px; max-height:90vh; overflow:hidden; box-shadow:0 25px 80px rgba(0,0,0,0.4); }

    .search-table-container { overflow-x:auto; border-radius:15px; box-shadow:0 5px 20px rgba(0,0,0,0.1);}
    .search-table { width:100%; border-collapse:collapse; min-width:1200px;}
    .search-table th, .search-table td { padding:1rem; text-align:center; }
</style>

<div class="page-process">

    <!-- Status Header -->
    <div class="status-header">
        <div class="status-header-content">
            <h2>⚙️ معالجة الطلب</h2>
            <p>رقم الطلب: <strong>{{ $certificate->request_number ?? '-' }}</strong></p>
            <span class="status-badge">🔄 قيد المعالجة</span>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">⚠️ {{ session('error') }}</div>
    @endif

    <!-- Extract Certificate -->
    <div class="extract-card top-actions">
        <a href="{{ route('admin.certificates.extract', $certificate->id) }}" class="btn-process btn-certificate">🧾 استخراج شهادة</a>
    </div>

    <!-- Citizen Info Form -->
    <div class="extract-card citizen-info">
        <h4>📝 معلومات المواطن</h4>
        <form id="citizenForm">
            <div class="row">
                <label>اللقب *</label>
                <input type="text" name="owner_lastname" id="owner_lastname"
                    value="{{ old('owner_lastname', $certificate->owner_lastname) }}" required>
            </div>
            <div class="row">
                <label>الاسم *</label>
                <input type="text" name="owner_firstname" id="owner_firstname"
                    value="{{ old('owner_firstname', $certificate->owner_firstname) }}" required>
            </div>
            <div class="row">
                <label>اسم الأب</label>
                <input type="text" name="owner_father" id="owner_father"
                    value="{{ old('owner_father', $certificate->owner_father) }}">
            </div>
            <div class="row">
                <label>تاريخ الميلاد</label>
                {{-- ✅ تم التصحيح: owner_birthdate بدل birth_date --}}
                <input type="date" name="birth_date" id="birth_date"
                    value="{{ old('birth_date', $certificate->owner_birthdate) }}">
            </div>
            <div class="row">
                <label>مكان الميلاد</label>
                {{-- ✅ تم التصحيح: owner_birthplace بدل birth_place --}}
                <input type="text" name="birth_place" id="birth_place"
                    value="{{ old('birth_place', $certificate->owner_birthplace) }}">
            </div>
            <div class="submit-box">
                <button type="button" class="btn-search" onclick="openSearchModal()">🔍 بحث في الشهادات</button>
            </div>
        </form>
    </div>

    <!-- Back Button -->
    <div class="extract-card" style="text-align:center;">
        <a href="{{ route('admin.certificates.index') }}" class="btn-process">← رجوع للقائمة</a>
    </div>
</div>

<!-- Modal -->
<div class="modal-overlay" id="searchModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>📋 نتائج البحث في الشهادات السلبية</h3>
            <button class="modal-close" onclick="closeSearchModal()">×</button>
        </div>
        <div class="modal-body">
            <div class="loading-spinner" id="loadingSpinner">جاري البحث...</div>
            <div class="search-table-container" id="tableContainer" style="display:none;">
                <table class="search-table">
                    <thead>
                        <tr>
                            <th>#</th><th>اللقب</th><th>الاسم</th><th>اسم الأب</th>
                            <th>تاريخ الميلاد</th><th>مكان الميلاد</th>
                            <th>المساحة</th><th>الموقع</th><th>رقم القطعة</th>
                            <th>رقم المجمع</th><th>القسم</th><th>تاريخ النشر</th>
                            <th>رقم النشر</th><th>المجلد</th><th>التسمية</th>
                            <th>الوصف</th><th>اختيار</th>
                        </tr>
                    </thead>
                    <tbody id="searchResults"></tbody>
                </table>
            </div>
            <div id="noResults" style="display:none; text-align:center; padding:3rem;">لا توجد نتائج مطابقة</div>
        </div>
    </div>
</div>

<script>
function openSearchModal() {
    const lastname  = document.getElementById('owner_lastname').value.trim();
    const firstname = document.getElementById('owner_firstname').value.trim();
    if (!lastname || !firstname) { alert('يرجى ملء الاسم واللقب'); return; }

    document.getElementById('searchModal').style.display = 'block';
    document.getElementById('loadingSpinner').style.display = 'block';
    document.getElementById('tableContainer').style.display = 'none';
    document.getElementById('noResults').style.display = 'none';
    document.getElementById('searchResults').innerHTML = '';

    fetchSearchResults();
}

function closeSearchModal() {
    document.getElementById('searchModal').style.display = 'none';
}

function fetchSearchResults() {
    const params = new URLSearchParams({
        owner_lastname:  document.getElementById('owner_lastname').value.trim(),
        owner_firstname: document.getElementById('owner_firstname').value.trim(),
        owner_father:    document.getElementById('owner_father').value.trim(),
        birth_date:      document.getElementById('birth_date').value,
        birth_place:     document.getElementById('birth_place').value.trim()
    });

    fetch('/search-cert?' + params.toString())
    .then(res => res.json())
    .then(data => {
        document.getElementById('loadingSpinner').style.display = 'none';

        if (!data || data.count === 0) {
            document.getElementById('noResults').style.display = 'block';
            return;
        }

        const tbody = document.getElementById('searchResults');
        tbody.innerHTML = '';

        data.data.forEach((item, index) => {
            tbody.innerHTML += `<tr>
                <td>${index + 1}</td>
                <td>${item.owner_lastname  || '-'}</td>
                <td>${item.owner_firstname || '-'}</td>
                <td>${item.owner_father    || '-'}</td>
                <td>${item.birth_date      || '-'}</td>
                <td>${item.birth_place     || '-'}</td>
                <td>${item.area            || '-'}</td>
                <td>${item.location        || '-'}</td>
                <td>${item.plot_number     || '-'}</td>
                <td>${item.group_number    || '-'}</td>
                <td>${item.section         || '-'}</td>
                <td>${item.publication_date   || '-'}</td>
                <td>${item.publication_number || '-'}</td>
                <td>${item.volume          || '-'}</td>
                <td>${item.title           || '-'}</td>
                <td>${item.description     || '-'}</td>
                <td><button type="button" class="btn-select" onclick="selectRecord(${item.id})">اختيار</button></td>
            </tr>`;
        });

        document.getElementById('tableContainer').style.display = 'block';
    })
    .catch(() => {
        document.getElementById('loadingSpinner').style.display = 'none';
        document.getElementById('noResults').style.display = 'block';
    });
}

function selectRecord(id) {
    fetch('/get-cert/' + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById('owner_lastname').value  = data.owner_lastname  || '';
        document.getElementById('owner_firstname').value = data.owner_firstname || '';
        document.getElementById('owner_father').value    = data.owner_father    || '';
        // ✅ نستعمل owner_birthdate و owner_birthplace من الـ API
        document.getElementById('birth_date').value      = data.owner_birthdate || data.birth_date  || '';
        document.getElementById('birth_place').value     = data.owner_birthplace|| data.birth_place || '';
        closeSearchModal();
        alert('تم استيراد البيانات بنجاح ✅');
    });
}

document.getElementById('searchModal').addEventListener('click', function(e) {
    if (e.target === this) closeSearchModal();
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeSearchModal();
});
</script>

@endsection