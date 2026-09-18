<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ app()->getLocale()==='en' ? 'Download Results' : 'ดาวน์โหลดผล' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
        (function () {
            try {
                const KEY = 'supavut_theme_mode';
                const saved = localStorage.getItem(KEY);
                const mode = (saved === 'light' || saved === 'dark') ? saved : 'dark';
                if (mode === 'dark') document.documentElement.classList.add('dark-mode');
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
            --bg:#f3f6fb;
            --card:#ffffff;
            --border:rgba(148,163,184,.45);
            --text:#111827;
            --muted:#6b7280;
            --primary:#1e3a8a;
            --primary-soft:rgba(30,58,138,.08);
            --danger:#b91c1c;
            --glass:rgba(255,255,255,.82);
        }
        .dark-mode{
            --bg:#0b1220;
            --card:#0b1220;
            --border:rgba(148,163,184,.35);
            --text:#e5e7eb;
            --muted:#9ca3af;
            --primary:#e0b761;
            --primary-soft:rgba(224,183,97,.14);
            --danger:#f87171;
            --glass:rgba(15,23,42,.72);
        }

        *{box-sizing:border-box}
        body{
            margin:0;
            min-height:100vh;
            font-family:'Prompt',system-ui,-apple-system,"Segoe UI",sans-serif;
            background:var(--bg);
            color:var(--text);
            display:flex;
            align-items:flex-start;
            justify-content:center;
            padding:18px;
            transition:background-color .2s ease,color .2s ease;
        }
        body *{font-weight:400 !important;}

        .wrap{width:100%;max-width:1100px}
        .cardx{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:16px;
            box-shadow:0 14px 34px rgba(2,6,23,.10);
            overflow:hidden;
            position:relative;
        }
        .dark-mode .cardx{box-shadow:0 18px 44px rgba(2,6,23,.55)}

        .topbar{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            padding:14px 16px;
            background:linear-gradient(180deg, var(--glass), transparent);
            border-bottom:1px solid var(--border);
        }
        .titlebox{display:flex;align-items:center;gap:10px;min-width:0}
        .title{
            margin:0;
            font-size:1.05rem;
            font-weight:600 !important;
            line-height:1.2;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }
        .subtitle{
            margin:2px 0 0;
            font-size:.82rem;
            color:var(--muted);
        }

        .right-tools{display:flex;gap:8px;align-items:center;flex-wrap:wrap;justify-content:flex-end}

        .lang-switch{
            display:inline-flex;
            padding:4px 6px;
            border-radius:999px;
            background:var(--glass);
            border:1px solid var(--border);
            backdrop-filter: blur(10px) saturate(140%);
            -webkit-backdrop-filter: blur(10px) saturate(140%);
        }
        .lang-switch form{display:flex;gap:4px;margin:0;padding:0}
        .lang-btn-square{
            appearance:none;border:0;background:transparent;cursor:pointer;
            border-radius:10px;padding:6px 10px;min-width:42px;
            font-size:.75rem;font-weight:900 !important;letter-spacing:.04em;text-transform:uppercase;
            color:var(--muted);
            border:1px solid transparent;
            transition:transform .08s ease, box-shadow .16s ease, background-color .16s ease, color .16s ease, border-color .16s ease;
        }
        .lang-btn-square:hover{transform:translateY(-1px);box-shadow:0 8px 18px rgba(2,6,23,.12)}
        .lang-btn-square[data-active="true"]{
            background:linear-gradient(135deg,#facc6b,#e0b761);
            color:#111827;
            border-color:rgba(250,204,21,.9);
            box-shadow:0 10px 20px rgba(250,204,21,.25);
        }

        .theme-toggle-box{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:4px 10px;
            border-radius:999px;
            background:var(--glass);
            border:1px solid var(--border);
            backdrop-filter: blur(10px) saturate(140%);
            -webkit-backdrop-filter: blur(10px) saturate(140%);
            color:var(--muted);
        }
        .theme-toggle-box .form-check-input{cursor:pointer}
        .theme-toggle-box i{font-size:1rem}

        .content{padding:16px;padding-bottom:72px}
        .section{
            border:1px solid var(--border);
            border-radius:14px;
            padding:14px;
            background:rgba(255,255,255,.55);
        }
        .dark-mode .section{background:rgba(15,23,42,.42)}

        .btn-primary{
            background:var(--primary);
            border-color:var(--primary);
            font-weight:700 !important;
            border-radius:12px;
        }
        .dark-mode .btn-primary{
            background:linear-gradient(135deg,#facc6b,#e0b761);
            border-color:#e0b761;
            color:#111827;
            box-shadow:inset 0 0 0 1px rgba(255,255,255,.65);
        }
        .btn-mini{padding:.38rem .65rem;border-radius:12px;font-weight:700 !important}

        .table{margin:0}
        .table thead th{
            font-size:.80rem;
            color:var(--muted);
            border-bottom-color:var(--border);
            white-space:nowrap;
            text-align:center;
        }
        .table tbody td{
            border-top-color: rgba(148,163,184,.16);
            vertical-align:middle;
            text-align:center;
        }
        .dark-mode .table tbody td{ border-top-color: rgba(148,163,184,.14); }

        .cell-title{font-weight:700 !important;line-height:1.15}
        .cell-sub{font-size:.82rem;color:var(--muted)}

        .chip{
            display:inline-flex;
            align-items:center;
            padding:4px 10px;
            border-radius:999px;
            border:1px solid var(--border);
            background:var(--glass);
            font-size:.82rem;
            white-space:nowrap;
            color:var(--text);
        }
        .chip.ok{ border-color: rgba(34,197,94,.35); background: rgba(34,197,94,.12); }
        .chip.closed{ border-color: rgba(148,163,184,.35); background: rgba(148,163,184,.10); }
        .chip.unk{ border-color: rgba(245,158,11,.35); background: rgba(245,158,11,.12); }

        .search{
            width:100%;
            border:1px solid var(--border);
            background:var(--glass);
            border-radius:999px;
            padding:10px 12px;
            outline:none;
            font-size:.92rem;
            color:var(--text);
        }
        .search:focus{
            border-color: rgba(56,189,248,.55);
            box-shadow: 0 0 0 .2rem rgba(56,189,248,.16);
        }
        .dark-mode .search::placeholder{ color: rgba(229,231,235,.6); }

        .btn-link-back{font-size:.85rem;text-decoration:none;color:var(--muted);display:inline-flex;align-items:center;gap:2px}
        .btn-link-back:hover{text-decoration:underline}

        .card-back{
            position:absolute;
            left:16px;
            bottom:16px;
            z-index:5;
        }

        @media (max-width: 768px){
            .subtitle{display:none}
        }
    </style>
</head>

<body>
@php
    $langOptions   = ['th' => 'TH', 'en' => 'EN'];
    $currentLocale = app()->getLocale();
    $isEn = ($currentLocale === 'en');

    $t = [
        'title'  => $isEn ? 'Downloads' : 'ดาวน์โหลด',
        'sub'    => $isEn ? 'Results' : 'ผลการประเมิน',
        'search' => $isEn ? 'Search…' : 'ค้นหา…',
        'cycle'  => $isEn ? 'Cycle' : 'รอบ',
        'status' => $isEn ? 'Status' : 'สถานะ',
        'action' => $isEn ? 'Action' : 'ทำงาน',
        'open'   => $isEn ? 'Open' : 'เปิด',
        'closed' => $isEn ? 'Closed' : 'ปิด',
        'unk'    => $isEn ? 'Unknown' : 'ไม่ทราบ',
        'dl'     => $isEn ? 'Download' : 'ดาวน์โหลด',
        'empty'  => $isEn ? 'No cycles.' : 'ยังไม่มีรอบ',
    ];
@endphp

<div class="wrap">
    <div class="cardx">
        <div class="topbar">
            <div class="titlebox">
                <div class="min-w-0">
                    <h1 class="title">{{ $t['title'] }}</h1>
                    <p class="subtitle mb-0">{{ $t['sub'] }}</p>
                </div>
            </div>

            <div class="right-tools">
                <div class="lang-switch" aria-label="Language switcher">
                    <form id="localeForm" action="{{ route('locale.switch') }}" method="POST" class="d-flex m-0 p-0">
                        @csrf
                        <input type="hidden" name="locale" id="localeInput">
                        @foreach($langOptions as $code => $label)
                            <button type="button"
                                    class="lang-btn-square"
                                    data-locale="{{ $code }}"
                                    data-active="{{ $currentLocale === $code ? 'true' : 'false' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </form>
                </div>

                <div class="theme-toggle-box" title="Theme/ธีม">
                    <i class="bi" id="themeIcon"></i>
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" id="themeToggle">
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="section">
                <div class="d-flex justify-content-end mb-3">
                    <div style="min-width:260px;max-width:520px;width:100%;">
                        <input id="q" class="search" placeholder="{{ $t['search'] }}">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th style="width:90px;">ID</th>
                            <th class="text-start">{{ $t['cycle'] }}</th>
                            <th style="width:160px;">{{ $t['status'] }}</th>
                            <th style="width:200px;">{{ $t['action'] }}</th>
                        </tr>
                        </thead>
                        <tbody id="tbody">
                        @forelse($cycles as $c)
                            @php
                                $name  = trim((string)($c->name ?? ''));
                                $code  = trim((string)($c->code ?? ''));
                                $label = $name !== '' ? $name : ($code !== '' ? $code : ('Cycle #'.$c->id));

                                $status = (string)($c->status ?? '');
                                if ($status === '' && isset($c->is_active)) $status = $c->is_active ? 'open' : 'closed';

                                $blob = strtolower(trim($c->id.' '.$label.' '.$status));
                            @endphp

                            <tr data-search="{{ e($blob) }}">
                                <td class="fw-semibold" style="font-weight:700 !important;">{{ $c->id }}</td>

                                <td class="text-start">
                                    <div class="cell-title">{{ $label }}</div>
                                </td>

                                <td>
                                    @if($status === 'open' || $status === 'active')
                                        <span class="chip ok">{{ $t['open'] }}</span>
                                    @elseif($status === 'closed')
                                        <span class="chip closed">{{ $t['closed'] }}</span>
                                    @else
                                        <span class="chip unk">{{ $t['unk'] }}</span>
                                    @endif
                                </td>

                                <td>
                                    <a class="btn btn-primary btn-mini"
                                       href="{{ route('admin.results.download.cycle', $c->id) }}">
                                        {{ $t['dl'] }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    {{ $t['empty'] }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $cycles->links() }}
                </div>
            </div>
        </div>

        <div class="card-back">
            <a href="{{ route('profile') }}" class="btn-link-back">
                <i class="bi bi-arrow-left-short"></i>กลับ
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const KEY = 'supavut_theme_mode';
    const toggle = document.getElementById('themeToggle');
    const icon = document.getElementById('themeIcon');

    function setIcon(mode) {
        if (!icon) return;
        icon.className = 'bi ' + (mode === 'dark' ? 'bi-moon-stars' : 'bi-sun');
    }

    function applyTheme(mode) {
        const m = (mode === 'light') ? 'light' : 'dark';
        document.documentElement.classList.toggle('dark-mode', m === 'dark');
        if (toggle) toggle.checked = (m === 'dark');
        setIcon(m);
        try { localStorage.setItem(KEY, m); } catch (e) {}
    }

    function getInitialTheme() {
        try {
            const saved = localStorage.getItem(KEY);
            if (saved === 'dark' || saved === 'light') return saved;
        } catch (e) {}
        return 'dark';
    }

    applyTheme(getInitialTheme());

    if (toggle) {
        toggle.addEventListener('change', function () {
            applyTheme(this.checked ? 'dark' : 'light');
        });
    }

    const form = document.getElementById('localeForm');
    const input = document.getElementById('localeInput');
    if (form && input) {
        form.querySelectorAll('.lang-btn-square').forEach(btn => {
            btn.addEventListener('click', () => {
                input.value = btn.dataset.locale || 'th';
                form.submit();
            });
        });
    }

    const q = document.getElementById('q');
    const tbody = document.getElementById('tbody');
    let timer = null;

    function run(){
        if(!tbody) return;
        const s = (q ? q.value : '').toLowerCase().trim();
        tbody.querySelectorAll('tr').forEach(tr=>{
            const blob = (tr.getAttribute('data-search') || '');
            tr.style.display = (!s || blob.includes(s)) ? '' : 'none';
        });
    }

    if(q){
        q.addEventListener('input', ()=>{
            if(timer) clearTimeout(timer);
            timer = setTimeout(run, 80);
        });
    }
});
</script>
</body>
</html>
