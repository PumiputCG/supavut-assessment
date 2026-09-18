<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ app()->getLocale()==='en' ? 'Cycles' : 'กำหนดรอบ' }}</title>
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

        .form-label{font-weight:600 !important;font-size:.9rem;margin-bottom:.4rem}
        .form-control{
            background:var(--glass);
            border-color:var(--border);
            color:var(--text);
        }
        .form-control:focus{
            border-color: rgba(56,189,248,.55);
            box-shadow: 0 0 0 .2rem rgba(56,189,248,.16);
        }
        .dark-mode .form-control::placeholder{ color: rgba(229,231,235,.6); }

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
        .btn-soft{
            border-radius:12px;
            font-weight:700 !important;
            border:1px solid var(--border);
            background:var(--glass);
            color:var(--text);
        }
        .btn-soft:hover{filter:brightness(1.03)}
        .btn-outline-danger{font-weight:700 !important;border-radius:12px}
        .btn-mini{padding:.38rem .65rem;border-radius:12px;font-weight:700 !important}

        .table{margin:0}
        .table thead th{
            font-size:.80rem;
            color:var(--muted);
            border-bottom-color:var(--border);
            white-space:nowrap;
        }
        .table tbody td{
            border-top-color: rgba(148,163,184,.16);
            vertical-align:middle;
        }
        .dark-mode .table tbody td{ border-top-color: rgba(148,163,184,.14); }

        .cell-title{font-weight:700 !important;line-height:1.15}
        .cell-sub{font-size:.82rem;color:var(--muted)}

        .chip{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:4px 10px;
            border-radius:999px;
            border:1px solid var(--border);
            background:var(--glass);
            font-size:.82rem;
            white-space:nowrap;
            color:var(--text);
        }
        .chip.ok{ border-color: rgba(34,197,94,.35); background: rgba(34,197,94,.12); }
        .chip.eval{ border-color: rgba(148,163,184,.35); background: rgba(148,163,184,.10); }
        .chip.draft{ border-color: rgba(245,158,11,.35); background: rgba(245,158,11,.12); }

        .note-pill{
            display:inline-flex;
            align-items:center;
            max-width: 320px;
            padding:4px 10px;
            border-radius:999px;
            border:1px solid var(--border);
            background:var(--glass);
            font-size:.82rem;
            color:var(--text);
            overflow:hidden;
            text-overflow:ellipsis;
            white-space:nowrap;
            cursor:pointer;
            user-select:none;
        }
        .note-pill:hover{filter:brightness(1.03)}

        .note-modal{ position:fixed; inset:0; display:none; z-index:9999; }
        .note-modal.show{ display:block; }
        .note-modal .backdrop{ position:absolute; inset:0; background: rgba(0,0,0,.55); }
        .note-modal .panel{
            position:relative;
            max-width:720px;
            margin: 7vh auto 0;
            background: var(--card);
            border:1px solid var(--border);
            border-radius:18px;
            box-shadow:0 22px 60px rgba(0,0,0,.45);
            padding:14px;
        }
        .note-modal .panel h6{ margin:0; font-weight:700 !important; }
        .note-modal .body{
            margin-top:10px;
            padding:10px;
            border-radius:14px;
            border:1px solid var(--border);
            background: var(--glass);
            white-space: pre-wrap;
            max-height: 60vh;
            overflow:auto;
        }

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
        'title'   => $isEn ? 'Cycles' : 'รอบการประเมิน',
        'sub'     => $isEn ? 'Admin' : 'แอดมิน',
        'create'  => $isEn ? 'Create' : 'สร้าง',
        'start'   => $isEn ? 'Start' : 'เริ่มรอบ',
        'close'   => $isEn ? 'Close' : 'ปิดรอบ',
        'done'    => $isEn ? 'Evaluated' : 'ประเมินแล้ว',
        'draft'   => $isEn ? 'Draft' : 'ยังไม่เริ่ม',
        'active'  => $isEn ? 'Active' : 'กำลังประเมิน',
        'name'    => $isEn ? 'Name' : 'ชื่อรอบ',
        'note'    => $isEn ? 'Note' : 'หมายเหตุ',
        'period'  => $isEn ? 'Period' : 'ช่วงเวลา',
        'status'  => $isEn ? 'Status' : 'สถานะ',
        'opened'  => $isEn ? 'Opened' : 'เริ่ม',
        'closed'  => $isEn ? 'Closed' : 'ปิด',
        'read'    => 'Read',
        'read_on'  => $isEn ? 'Read ON' : 'เปิด',
        'read_off' => $isEn ? 'Read OFF' : 'ปิด',
        'action'  => $isEn ? 'Action' : 'การทำงาน',
        'confirm_open'  => $isEn ? 'Start this cycle?' : 'เริ่มรอบนี้?',
        'confirm_close' => $isEn ? 'Close this cycle?' : 'ปิดรอบนี้?',
        'confirm_del'   => $isEn ? 'Delete this cycle?' : 'ลบรอบนี้?',
        'no_cycles'     => $isEn ? 'No cycles.' : 'ยังไม่มีรอบ',
        'note_title'    => $isEn ? 'Note' : 'หมายเหตุ',
        'already'       => $isEn ? 'Already evaluated' : 'ประเมินแล้ว',
        'start_ph'       => $isEn ? 'e.g. 2026 Q1' : 'เช่น ไตรมาส 1/2026',
        'note_ph'        => $isEn ? 'Optional' : 'ไม่บังคับ',
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
            @if(session('ok'))
                <div class="alert alert-success py-2 mb-3">{{ session('ok') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger py-2 mb-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="section mb-3">
                <form method="POST" action="{{ route('admin.cycles.store') }}" class="row g-2 align-items-end">
                    @csrf

                    <div class="col-12 col-md-5">
                        <label class="form-label mb-1">{{ $t['name'] }}</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name') }}"
                               placeholder="{{ $t['start_ph'] }}"
                               required>
                    </div>

                    <div class="col-6 col-md-2">
                        <label class="form-label mb-1">{{ $isEn ? 'Start' : 'วันเริ่ม' }}</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                    </div>

                    <div class="col-6 col-md-2">
                        <label class="form-label mb-1">{{ $isEn ? 'End' : 'วันจบ' }}</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                    </div>

                    <div class="col-12 col-md-2">
                        <label class="form-label mb-1">{{ $t['note'] }}</label>
                        <input type="text"
                               name="note"
                               class="form-control"
                               value="{{ old('note') }}"
                               placeholder="{{ $t['note_ph'] }}">
                    </div>

                    <div class="col-12 col-md-1">
                        <button type="submit" class="btn btn-primary w-100">
                            {{ $t['create'] }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="section">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th style="width:80px;">#</th>
                            <th>{{ $isEn ? 'Cycle' : 'รอบ' }}</th>
                            <th style="width:320px;">{{ $t['note'] }}</th>
                            <th style="width:260px;">{{ $t['period'] }}</th>
                            <th style="width:160px;">{{ $t['status'] }}</th>
                            <th style="width:140px;">{{ $t['opened'] }}</th>
                            <th style="width:140px;">{{ $t['closed'] }}</th>
                            <th style="width:110px;" class="text-end">{{ $t['read'] }}</th>
                            <th style="width:260px;" class="text-end">{{ $t['action'] }}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($cycles as $c)
                            @php
                                $label = $c->name ?: ('Cycle #'.$c->id);

                                $isActive = (bool)($c->is_active ?? false);
                                $status   = (string)($c->status ?? '');
                                $isOpen   = ($status === \App\Models\Cycle::STATUS_OPEN);
                                $isClosed = ($status === \App\Models\Cycle::STATUS_CLOSED);

                                $hasBeenOpened = !empty($c->opened_at);
                                $isReallyActive = ($isActive && $isOpen);

                                $isEvaluated = ($isClosed && $hasBeenOpened && !$isReallyActive);
                                $isDraft = (!$hasBeenOpened && !$isReallyActive);

                                $start = $c->start_date ? \Illuminate\Support\Carbon::parse($c->start_date)->format('Y-m-d') : '-';
                                $end   = $c->end_date   ? \Illuminate\Support\Carbon::parse($c->end_date)->format('Y-m-d')   : '-';
                                $range = ($start !== '-' || $end !== '-') ? ($start.' - '.$end) : '-';

                                $opened = $c->opened_at ? \Illuminate\Support\Carbon::parse($c->opened_at)->format('m/d H:i') : '-';
                                $closed = $c->closed_at ? \Illuminate\Support\Carbon::parse($c->closed_at)->format('m/d H:i') : '-';

                                if ($isReallyActive) {
                                    $chipClass = 'ok';
                                    $chipText  = $t['active'];
                                } elseif ($isEvaluated) {
                                    $chipClass = 'eval';
                                    $chipText  = $t['done'];
                                } else {
                                    $chipClass = 'draft';
                                    $chipText  = $t['draft'];
                                }

                                $canOpen = $isDraft;
                                $canDelete = (!$isReallyActive && empty($c->opened_at));
                                $isReadMode = (bool)($c->is_read_mode ?? false);
                            @endphp

                            <tr>
                                <td class="fw-semibold" style="font-weight:700 !important;">{{ $c->id }}</td>

                                <td>
                                    <div class="cell-title">{{ $label }}</div>
                                    <div class="cell-sub">{{ $c->code ?? '' }}</div>
                                </td>

                                <td>
                                    @if($c->note)
                                        <span class="note-pill js-note"
                                              role="button"
                                              tabindex="0"
                                              data-title="{{ e($label) }}"
                                              data-note="{{ e($c->note) }}">
                                            {{ \Illuminate\Support\Str::limit($c->note, 80) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td class="cell-sub">{{ $range }}</td>

                                <td>
                                    <span class="chip {{ $chipClass }}">{{ $chipText }}</span>
                                </td>

                                <td class="cell-sub">{{ $opened }}</td>
                                <td class="cell-sub">{{ $closed }}</td>

                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.cycles.read_mode', $c->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-mini {{ $isReadMode ? 'btn-primary' : 'btn-soft' }}">
                                            {{ $isReadMode ? $t['read_on'] : $t['read_off'] }}
                                        </button>
                                    </form>
                                </td>

                                <td class="text-end">
                                    <div class="d-inline-flex gap-2 align-items-center">
                                        @if($isReallyActive)
                                            <form method="POST" action="{{ route('admin.cycles.close', $c->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-soft btn-mini"
                                                        onclick="return confirm('{{ $t['confirm_close'] }}')">
                                                    {{ $t['close'] }}
                                                </button>
                                            </form>
                                        @elseif($canOpen)
                                            <form method="POST" action="{{ route('admin.cycles.activate', $c->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-mini"
                                                        onclick="return confirm('{{ $t['confirm_open'] }}')">
                                                    {{ $t['start'] }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small">{{ $t['already'] }}</span>
                                        @endif

                                        @if($canDelete)
                                            <form method="POST" action="{{ route('admin.cycles.destroy', $c->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-mini"
                                                        onclick="return confirm('{{ $t['confirm_del'] }}')">
                                                    {{ $isEn ? 'Delete' : 'ลบ' }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    {{ $t['no_cycles'] }}
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

<div class="note-modal" id="noteModal" aria-hidden="true">
    <div class="backdrop" id="noteModalBackdrop"></div>
    <div class="panel">
        <div class="d-flex align-items-center justify-content-between">
            <h6 id="noteModalTitle">{{ $t['note_title'] }}</h6>
            <button type="button" class="btn btn-sm btn-soft" id="noteModalClose">OK</button>
        </div>
        <div class="body" id="noteModalBody"></div>
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

    const modal = document.getElementById('noteModal');
    const bd    = document.getElementById('noteModalBackdrop');
    const btnX  = document.getElementById('noteModalClose');
    const title = document.getElementById('noteModalTitle');
    const body  = document.getElementById('noteModalBody');

    function openNoteModal(t, n){
        if(title) title.textContent = t || 'Note';
        if(body)  body.textContent  = n || '';
        if(modal) modal.classList.add('show');
    }
    function closeNoteModal(){
        if(modal) modal.classList.remove('show');
    }

    document.querySelectorAll('.js-note').forEach(el=>{
        el.addEventListener('click', ()=> openNoteModal(el.dataset.title, el.dataset.note));
        el.addEventListener('keydown', (e)=>{
            if(e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openNoteModal(el.dataset.title, el.dataset.note); }
        });
    });

    if(bd) bd.addEventListener('click', closeNoteModal);
    if(btnX) btnX.addEventListener('click', closeNoteModal);
    document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape') closeNoteModal(); });
});
</script>
</body>
</html>
