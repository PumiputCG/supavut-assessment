<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('app.emp_import_title') }}</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        (function () {
            try {
                const KEY='supavut_theme_mode';
                const v=localStorage.getItem(KEY);
                const m=(v==='light'||v==='dark')?v:'dark';
                document.documentElement.classList.toggle('dark-mode', m==='dark');
            } catch (e) {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --bg:#f3f6fb; --card:#fff; --border:rgba(148,163,184,.45);
            --text:#111827; --muted:#6b7280;
            --primary:#1e3a8a; --primary-soft:rgba(30,58,138,.08);
            --danger:#b91c1c; --glass:rgba(255,255,255,.82);
        }
        :root.dark-mode{
            --bg:#0b1220; --card:#0b1220; --border:rgba(148,163,184,.35);
            --text:#e5e7eb; --muted:#9ca3af;
            --primary:#e0b761; --primary-soft:rgba(224,183,97,.14);
            --danger:#f87171; --glass:rgba(15,23,42,.72);
        }
        *{box-sizing:border-box}
        body{
            margin:0; min-height:100vh;
            font-family:'Prompt',system-ui,-apple-system,"Segoe UI",sans-serif;
            background:var(--bg); color:var(--text);
            display:flex; align-items:center; justify-content:center;
            padding:18px;
        }
        .wrap{width:100%;max-width:860px}
        .cardx{
            background:var(--card); border:1px solid var(--border);
            border-radius:16px; overflow:hidden;
            box-shadow:0 14px 34px rgba(2,6,23,.10);
        }
        :root.dark-mode .cardx{box-shadow:0 18px 44px rgba(2,6,23,.55)}
        .topbar{
            display:flex; align-items:center; justify-content:space-between; gap:12px;
            padding:14px 16px;
            background:linear-gradient(180deg, var(--glass), transparent);
            border-bottom:1px solid var(--border);
        }
        .titlebox{display:flex;align-items:center;gap:10px;min-width:0}
        .badge-icon{
            width:40px;height:40px;border-radius:10px;
            display:flex;align-items:center;justify-content:center;
            background:var(--primary-soft); color:var(--primary);
            flex:0 0 auto;
        }
        .title{margin:0;font-size:1.05rem;font-weight:700;line-height:1.2}
        .right-tools{display:flex;gap:8px;align-items:center;flex-wrap:wrap;justify-content:flex-end}
        .pill{
            display:inline-flex; align-items:center; gap:8px;
            padding:4px 10px; border-radius:999px;
            background:var(--glass); border:1px solid var(--border);
            backdrop-filter: blur(10px) saturate(140%);
            -webkit-backdrop-filter: blur(10px) saturate(140%);
        }
        .lang-switch{padding:4px 6px}
        .lang-switch form{display:flex;gap:4px;margin:0;padding:0}
        .lang-btn{
            appearance:none;border:0;background:transparent;cursor:pointer;
            border-radius:10px;padding:6px 10px;min-width:42px;
            font-size:.75rem;font-weight:900;letter-spacing:.04em;text-transform:uppercase;
            color:var(--muted);
        }
        .lang-btn[data-active="true"]{
            background:linear-gradient(135deg,#facc6b,#e0b761);
            color:#111827; box-shadow:0 10px 20px rgba(250,204,21,.25);
        }
        .theme-toggle-box{color:var(--muted)}
        .theme-toggle-box i{font-size:1rem}
        .theme-toggle-box .form-check-input{cursor:pointer}

        .content{padding:16px}
        .section{
            border:1px solid var(--border);
            border-radius:14px; padding:14px;
            background:rgba(255,255,255,.55);
        }
        :root.dark-mode .section{background:rgba(15,23,42,.42)}
        .actions{display:flex;gap:10px;margin-top:12px;flex-wrap:wrap}
        .btn-primary{background:var(--primary);border-color:var(--primary);font-weight:800}
        :root.dark-mode .btn-primary{
            background:linear-gradient(135deg,#facc6b,#e0b761);
            border-color:#e0b761;color:#111827;
            box-shadow:inset 0 0 0 1px rgba(255,255,255,.65);
        }
        .btn-outline-danger{font-weight:800}
        .btn-soft{
            border-radius:12px; font-weight:900;
            border:1px solid var(--border);
            background:var(--glass);
            color:var(--text)!important;
            padding:.42rem .7rem;
            display:inline-flex;align-items:center;gap:8px;
        }
        .footer{
            padding:12px 16px; border-top:1px solid var(--border);
            display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;
        }
        .btn-link-back{font-size:.85rem;text-decoration:none;color:var(--muted)}
        .btn-link-back:hover{text-decoration:underline}
        .file-list{
            margin-top:10px;padding:10px;border-radius:12px;
            border:1px dashed var(--border);
            background:var(--glass);display:none;
        }
        .file-pill{
            display:inline-flex;align-items:center;gap:6px;
            padding:4px 10px;border-radius:999px;
            margin:4px 6px 0 0;font-size:.8rem;
            background:var(--primary-soft);color:var(--text);
        }
        .hint{font-size:.82rem;color:var(--muted);margin-top:6px}
        .alert{border-radius:14px;font-size:.88rem;margin-bottom:12px}

        .modal-backdrop.show{opacity:.62}
        .emp-modal .modal-content{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:18px;
            box-shadow:0 22px 60px rgba(0,0,0,.45);
            overflow:hidden;
        }
        .emp-modal .modal-header{
            border-bottom:1px solid var(--border);
            background:linear-gradient(180deg, var(--glass), transparent);
        }
        .emp-modal .modal-footer{
            border-top:1px solid var(--border);
            background:linear-gradient(0deg, var(--glass), transparent);
        }
        .emp-search{
            width:100%;
            border:1px solid var(--border);
            background:var(--glass);
            border-radius:999px;
            padding:10px 12px;
            outline:none;
            font-size:.92rem;
            color:var(--text);
        }
        .emp-table-wrap{
            border:1px solid var(--border);
            border-radius:14px;
            background:var(--glass);
            overflow:auto;
            max-height:62vh;
        }
        .emp-table{width:100%;min-width:1100px;margin:0}
        .emp-table thead th{
            position:sticky;top:0;z-index:2;
            background:rgba(255,255,255,.92);
            border-bottom:1px solid var(--border);
            font-size:.78rem;color:var(--muted);
            padding:10px 10px;white-space:nowrap;
        }
        :root.dark-mode .emp-table thead th{background:rgba(11,18,32,.96)}
        .emp-table tbody td{
            border-top:1px solid rgba(148,163,184,.16);
            padding:10px 10px;font-size:.86rem;
            white-space:nowrap;vertical-align:middle;
        }
        :root.dark-mode .emp-table tbody td{border-top-color:rgba(148,163,184,.14)}
        .emp-table tbody tr:hover{background:rgba(224,183,97,.08)}
        .muted{color:var(--muted)}

        .pager{
            display:flex;align-items:center;justify-content:space-between;
            gap:10px;flex-wrap:wrap;margin-top:10px;
        }
        .pager .meta{font-size:.88rem;color:var(--muted)}
        .pagination{margin:0}
        .page-link{
            border-radius:12px!important;
            border:1px solid var(--border)!important;
            background:var(--glass)!important;
            color:var(--text)!important;
            padding:.28rem .62rem!important;
            font-weight:800;
        }
        .page-item.active .page-link{
            background:var(--primary)!important;
            border-color:var(--primary)!important;
            color:#fff!important;
        }
        :root.dark-mode .page-item.active .page-link{
            background:linear-gradient(135deg,#facc6b,#e0b761)!important;
            border-color:#e0b761!important;
            color:#111827!important;
        }
        .page-item.disabled .page-link{opacity:.55}
    </style>
</head>
<body>
@php
    $langOptions   = ['th' => 'TH', 'en' => 'EN'];
    $currentLocale = app()->getLocale();
    $isTh = ($currentLocale === 'th');

    $hintText = $isTh ? 'รองรับ .xlsx/.xls/.csv' : 'Supports .xlsx/.xls/.csv';
    $appendText = $isTh ? 'เพิ่ม/อัปเดต' : 'Append';
    $replaceText = $isTh ? 'แทนที่ทั้งหมด' : 'Replace';
    $replaceConfirm = $isTh ? 'ยืนยันแทนที่ทั้งหมด?' : 'Replace all?';
    $fileSelectedLabel = $isTh ? 'ไฟล์' : 'Files';

    $isAdmin = auth()->check() && (auth()->user()->role ?? '') === 'admin';
    $canViewEmployees = auth()->check();

    $empOk = false; $empCols = []; $empColsShown = []; $empRows = null;
    $empPerPage = 200;
    $empQ = trim((string)request()->query('emp_q', ''));

    $reqPage = max(1, (int)request()->query('emp_page', 1));
    $safePage = $reqPage;
    $pageAdjusted = false;

    if ($canViewEmployees) {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('employees')) {
                $empOk = true;
                $empCols = \Illuminate\Support\Facades\Schema::getColumnListing('employees');

                $empColsShown = array_values(array_filter($empCols, fn($c) => $c !== 'id'));

                $orderCol = in_array('employee_code', $empCols, true) ? 'employee_code'
                          : (in_array('id', $empCols, true) ? 'id' : ($empCols[0] ?? 'id'));

                $q = \App\Models\Employee::query();

                if ($empQ !== '') {
                    $prefer = ['employee_code','full_name_th','full_name_en','first_name','last_name','nickname','department','division','position','position_name','email','phone'];
                    $searchCols = array_values(array_intersect($prefer, $empCols));
                    if ($searchCols) {
                        $q->where(function($w) use ($searchCols, $empQ){
                            foreach($searchCols as $c) $w->orWhere($c,'like','%'.$empQ.'%');
                        });
                    }
                }

                $total = (clone $q)->count();
                $lastPage = max(1, (int)ceil($total / max(1, $empPerPage)));
                $safePage = min($reqPage, $lastPage);
                $pageAdjusted = ($safePage !== $reqPage);

                $empRows = $q->select($empCols)->orderBy($orderCol)
                    ->paginate($empPerPage, ['*'], 'emp_page', $safePage);
            }
        } catch (\Throwable $e) { $empOk = false; $empRows = null; }
    }

    $t = [
        'files' => $isTh ? 'ไฟล์' : 'Files',
        'emp'   => $isTh ? 'Employees' : 'Employees',
        'back'  => $isTh ? 'กลับ' : 'Back',
        'close' => $isTh ? 'ปิด' : 'Close',
        'no'    => $isTh ? 'โหลด employees ไม่สำเร็จ' : 'Failed to load employees',
        'needAdmin' => $isTh ? 'Admin เท่านั้น' : 'Admin only',
        'search' => $isTh ? 'ค้นหา…' : 'Search…',
    ];
@endphp

<div class="wrap">
    <div class="cardx">
        <div class="topbar">
            <div class="titlebox">
                <div class="badge-icon"><i class="bi bi-file-earmark-spreadsheet"></i></div>
                <h1 class="title mb-0">{{ __('app.emp_import_title') }}</h1>
            </div>

            <div class="right-tools">
                <div class="pill lang-switch">
                    <form id="localeForm" action="{{ route('locale.switch') }}" method="POST">
                        @csrf
                        <input type="hidden" name="locale" id="localeInput">
                        @foreach($langOptions as $code => $label)
                            <button type="button" class="lang-btn"
                                    data-locale="{{ $code }}"
                                    data-active="{{ $currentLocale === $code ? 'true' : 'false' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </form>
                </div>

                <div class="pill theme-toggle-box">
                    <i class="bi" id="themeIcon"></i>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" id="themeToggle">
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-start">
                    <i class="bi bi-check-circle-fill me-2"></i><div>{{ session('success') }}</div>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-start">
                    <i class="bi bi-x-circle-fill me-2"></i><div>{{ session('error') }}</div>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-warning mb-3">
                    <div class="fw-semibold"><i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $isTh ? 'ตรวจสอบข้อมูล' : 'Check' }}</div>
                    <ul class="ps-3 mb-0">
                        @foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach
                    </ul>
                </div>
            @endif

            @if(!$isAdmin)
                <div class="alert alert-warning d-flex align-items-start">
                    <i class="bi bi-shield-lock-fill me-2"></i><div>{{ $t['needAdmin'] }}</div>
                </div>
            @else
                <div class="section">
                    <form method="POST" action="{{ route('employees.import.append') }}" enctype="multipart/form-data">
                        @csrf
                        <label for="files" class="form-label mb-2">
                            <i class="bi bi-upload me-1"></i>{{ $t['files'] }}
                        </label>

                        <input id="files" type="file" name="files[]"
                               class="form-control @error('files') is-invalid @enderror"
                               accept=".xlsx,.xls,.csv" multiple required>

                        <div class="hint">{{ $hintText }}</div>
                        <div id="fileList" class="file-list"></div>

                        <div class="actions">
                            <button type="submit" class="btn btn-primary flex-grow-1" formaction="{{ route('employees.import.append') }}">
                                <i class="bi bi-plus-circle me-1"></i>{{ $appendText }}
                            </button>
                            <button type="submit" class="btn btn-outline-danger flex-grow-1"
                                    formaction="{{ route('employees.import.replace') }}"
                                    onclick="return confirm(@json($replaceConfirm));">
                                <i class="bi bi-arrow-repeat me-1"></i>{{ $replaceText }}
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <div class="footer">
            <a href="{{ route('profile') }}" class="btn-link-back">
                <i class="bi bi-arrow-left-short"></i>{{ $t['back'] }}
            </a>

            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('employees.import.template') }}" class="btn-soft">
                    <i class="bi bi-download"></i><span>{{ $isTh ? 'ดาวน์โหลดเอกสาร' : 'Download document' }}</span>
                </a>

                @if($canViewEmployees)
                    <button type="button" class="btn-soft" data-bs-toggle="modal" data-bs-target="#empDbModal">
                        <i class="bi bi-people"></i><span>{{ $t['emp'] }}</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

@if($canViewEmployees)
<div class="modal fade emp-modal" id="empDbModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-database-check"></i>
                    <div class="fw-bold">{{ $t['emp'] }}</div>
                </div>
                <button type="button" class="btn btn-sm btn-soft" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body">
                @if(!$empOk || !$empRows)
                    <div class="alert alert-warning mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $t['no'] }}</div>
                @else
                    @if($pageAdjusted)
                        <div id="empPageAdjusted"
                             data-from="{{ $reqPage }}"
                             data-to="{{ $safePage }}"
                             class="alert alert-info py-2 mb-2">
                            <i class="bi bi-info-circle me-1"></i>
                            {{ $isTh ? 'ปรับหน้าให้อัตโนมัติ เพราะหน้าที่เลือกไม่มีข้อมูล' : 'Page adjusted because requested page has no results' }}
                        </div>
                    @endif

                    <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                        <div style="min-width:260px;max-width:520px;width:100%">
                            <input id="empDbSearch" class="emp-search"
                                   value="{{ $empQ }}"
                                   placeholder="{{ $t['search'] }}" autocomplete="off">
                        </div>
                        <button class="btn-soft" id="empDbSearchAllBtn" type="button" title="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <div class="emp-table-wrap">
                        <table class="emp-table table table-borderless align-middle" id="empDbTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                @foreach($empColsShown as $c) <th>{{ $c }}</th> @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($empRows as $r)
                                @php
                                    $rowNo = (method_exists($empRows,'firstItem') ? ($empRows->firstItem() ?? 0) : 0) + $loop->index;

                                    $rowText = '';
                                    foreach($empColsShown as $c){
                                        $v = data_get($r, $c);
                                        if ($v === null || $v === '') continue;
                                        $rowText .= ' ' . (is_bool($v) ? ($v ? '1':'0') : (string)$v);
                                    }
                                    $rowText = mb_strtolower($rowText);
                                @endphp
                                <tr class="emp-row" data-search="{{ e($rowText) }}">
                                    <td class="muted fw-semibold">{{ $rowNo }}</td>
                                    @foreach($empColsShown as $c)
                                        @php $v = data_get($r, $c); @endphp
                                        <td>
                                            @if($v === null || $v === '')
                                                <span class="muted">-</span>
                                            @else
                                                {{ is_bool($v) ? ($v ? '1' : '0') : $v }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($empColsShown) + 1 }}">
                                        <div class="text-center muted py-4">
                                            {{ $isTh ? 'ไม่พบข้อมูลในหน้านี้' : 'No results on this page' }}
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    @php
                        $p = $empRows;
                        if ($p instanceof \Illuminate\Contracts\Pagination\Paginator) {
                            $p = $p->appends(['open'=>'emp','emp_q'=>$empQ]);
                        }
                    @endphp

                    @if($p instanceof \Illuminate\Contracts\Pagination\Paginator && $p->hasPages())
                        @php
                            $cur  = (int)$p->currentPage();
                            $last = method_exists($p,'lastPage') ? (int)$p->lastPage() : $cur;
                            $win  = 3;
                            $start = max(1, $cur - $win);
                            $end   = min($last, $cur + $win);
                        @endphp

                        <div class="pager">
                            <div class="meta">
                                Showing {{ $p->firstItem() ?? 0 }} to {{ $p->lastItem() ?? 0 }} of {{ method_exists($p,'total') ? $p->total() : ($p->lastItem() ?? 0) }} results
                            </div>

                            <ul class="pagination pagination-sm">
                                @if ($p->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">‹</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $p->previousPageUrl() }}" rel="prev">‹</a></li>
                                @endif

                                @if($start > 1)
                                    <li class="page-item"><a class="page-link" href="{{ $p->url(1) }}">1</a></li>
                                    @if($start > 2)
                                        <li class="page-item disabled"><span class="page-link">…</span></li>
                                    @endif
                                @endif

                                @for($i=$start; $i<=$end; $i++)
                                    @if($i === $cur)
                                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $p->url($i) }}">{{ $i }}</a></li>
                                    @endif
                                @endfor

                                @if($end < $last)
                                    @if($end < $last-1)
                                        <li class="page-item disabled"><span class="page-link">…</span></li>
                                    @endif
                                    <li class="page-item"><a class="page-link" href="{{ $p->url($last) }}">{{ $last }}</a></li>
                                @endif

                                @if ($p->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $p->nextPageUrl() }}" rel="next">›</a></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">›</span></li>
                                @endif
                            </ul>
                        </div>
                    @endif
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-soft" data-bs-dismiss="modal">
                    <i class="bi bi-check2"></i>{{ $t['close'] }}
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const KEY='supavut_theme_mode';
    const toggle=document.getElementById('themeToggle');
    const icon=document.getElementById('themeIcon');

    function setIcon(m){ if(icon) icon.className='bi '+(m==='dark'?'bi-moon-stars':'bi-sun'); }
    function applyTheme(mode){
        const m=(mode==='light')?'light':'dark';
        document.documentElement.classList.toggle('dark-mode', m==='dark');
        if(toggle) toggle.checked = (m==='dark');
        setIcon(m);
        try{ localStorage.setItem(KEY,m); }catch(e){}
    }
    (function initTheme(){
        try{
            const v=localStorage.getItem(KEY);
            applyTheme((v==='light'||v==='dark')?v:'dark');
            if(!v) localStorage.setItem(KEY,'dark');
        }catch(e){ applyTheme('dark'); }
    })();
    if(toggle) toggle.addEventListener('change', ()=> applyTheme(toggle.checked?'dark':'light'));

    const form=document.getElementById('localeForm');
    const input=document.getElementById('localeInput');
    if(form && input){
        form.querySelectorAll('.lang-btn').forEach(btn=>{
            btn.addEventListener('click', ()=>{
                input.value = btn.dataset.locale || 'th';
                form.submit();
            });
        });
    }

    const fileInput=document.getElementById('files');
    const fileListEl=document.getElementById('fileList');
    const LABEL=@json($fileSelectedLabel);
    if(fileInput && fileListEl){
        fileInput.addEventListener('change', ()=>{
            const files=Array.from(fileInput.files||[]);
            if(!files.length){ fileListEl.style.display='none'; fileListEl.innerHTML=''; return; }
            let html='<div class="fw-semibold mb-1">'+LABEL+' ('+files.length+')</div>';
            files.forEach(f=> html+='<span class="file-pill"><i class="bi bi-file-earmark-excel"></i>'+(f.name||'')+'</span>');
            fileListEl.innerHTML=html; fileListEl.style.display='block';
        });
    }

    const empModalEl=document.getElementById('empDbModal');
    const empSearch=document.getElementById('empDbSearch');
    const searchAllBtn=document.getElementById('empDbSearchAllBtn');
    const rows=document.querySelectorAll('#empDbTable .emp-row');

    function filterThisPage(){
        if(!empSearch || !rows.length) return;
        const q=(empSearch.value||'').trim().toLowerCase();
        rows.forEach(tr=>{
            const hay=(tr.getAttribute('data-search')||'');
            tr.style.display = (!q || hay.includes(q)) ? '' : 'none';
        });
    }

    if(empSearch){
        empSearch.addEventListener('input', filterThisPage);
        empSearch.addEventListener('keydown', (e)=>{
            if(e.key==='Enter'){ e.preventDefault(); if(searchAllBtn) searchAllBtn.click(); }
        });
    }

    if(searchAllBtn){
        searchAllBtn.addEventListener('click', ()=>{
            const q=(empSearch?.value||'').trim();
            const url=new URL(window.location.href);
            url.searchParams.set('open','emp');
            url.searchParams.delete('emp_page');
            if(q) url.searchParams.set('emp_q', q);
            else url.searchParams.delete('emp_q');
            window.location.href=url.toString();
        });
    }

    (function(){
        const adj=document.getElementById('empPageAdjusted');
        if(!adj) return;
        const to=adj.getAttribute('data-to');
        if(!to) return;
        const url=new URL(window.location.href);
        url.searchParams.set('emp_page', to);
        url.searchParams.set('open','emp');
        history.replaceState({}, '', url.toString());
    })();

    (function(){
        const url=new URL(window.location.href);
        if(url.searchParams.get('open')==='emp' && empModalEl){
            new bootstrap.Modal(empModalEl).show();
        }
    })();

    if(empModalEl){
        empModalEl.addEventListener('shown.bs.modal', ()=>{
            if(empSearch){ empSearch.focus(); empSearch.select(); }
            filterThisPage();
        });
    }
});
</script>
</body>
</html>
