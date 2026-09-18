{{-- resources/views/assessment/overview.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('app.assess_overview_title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
        (function () {
            try {
                const v = localStorage.getItem('supavut_theme_mode');
                const m = (v === 'light' || v === 'dark') ? v : 'dark';
                document.documentElement.classList.toggle('dark-mode', m === 'dark');
                document.body && document.body.classList.toggle('dark-mode', m === 'dark');
                if (!v) localStorage.setItem('supavut_theme_mode', m);
            } catch (e) {
                document.documentElement.classList.add('dark-mode');
                document.body && document.body.classList.add('dark-mode');
            }
        })();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg:#f5f7fb;--glass:rgba(255,255,255,.92);--stroke:#e5e7eb;--text:#111827;--muted:#6b7280;
            --accent:#111827;--glass-bg:var(--glass);--border-soft:var(--stroke);--text-main:var(--text);--text-muted:var(--muted);
        }
        html.dark-mode, body.dark-mode{
            --bg:#020617;--glass:rgba(11,18,32,.92);--stroke:#1f2937;--text:#e5e7eb;--muted:#9ca3af;
            --accent:#e0b761;--glass-bg:rgba(15,23,42,.96);--border-soft:var(--stroke);--text-main:var(--text);--text-muted:var(--muted);
        }
        body{
            margin:0;padding:16px;
            font-family:Prompt,system-ui,-apple-system,Segoe UI,sans-serif;
            background:
                radial-gradient(circle at top, rgba(224,183,97,.14), transparent 60%),
                radial-gradient(circle at bottom, rgba(30,58,138,.10), transparent 60%),
                var(--bg);
            color:var(--text);
            transition:background-color .2s ease,color .2s ease;
            font-weight:400;
        }
        body *{font-weight:400 !important;}
        html.dark-mode body, body.dark-mode{
            background:
                radial-gradient(circle at top, rgba(224,183,97,.10), transparent 55%),
                radial-gradient(circle at bottom, rgba(148,163,184,.12), transparent 55%),
                var(--bg);
        }

        .wrap{max-width:2200px;margin:0 auto;}
        .card-glass{
            background:var(--glass);
            border:1px solid var(--stroke);
            border-radius:18px;
            box-shadow:0 18px 40px rgba(0,0,0,.10);
        }
        body.dark-mode .card-glass{box-shadow:0 18px 40px rgba(0,0,0,.45);}
        .muted{color:var(--muted);}

        .header-card{position:relative;}
        .top-right{
            position:absolute;top:10px;right:12px;
            display:flex;gap:10px;align-items:center;z-index:5;
        }
        .pill{
            display:inline-flex;align-items:center;gap:8px;
            padding:6px 9px;border-radius:999px;
            background:var(--glass-bg);
            border:1px solid var(--border-soft);
            backdrop-filter: blur(10px) saturate(140%);
            -webkit-backdrop-filter: blur(10px) saturate(140%);
            box-shadow: 0 10px 24px rgba(15,23,42,0.14);
        }
        body.dark-mode .pill{box-shadow:0 10px 24px rgba(15,23,42,0.30);}
        .lang-switch form{display:flex;gap:4px;margin:0;}
        .lang-btn{
            appearance:none;border:1px solid transparent;background:transparent;
            color:var(--text-main);
            border-radius:10px;padding:3px 8px;
            font-size:.74rem;letter-spacing:.03em;text-transform:uppercase;
            min-width:40px;cursor:pointer;
        }
        .lang-btn[data-active="true"]{
            background:linear-gradient(135deg,#facc6b,#e0b761);
            color:#111827;border-color:rgba(250,204,21,0.9);
            box-shadow:0 6px 16px rgba(250,204,21,.34), inset 0 0 0 1px rgba(255,255,255,.7);
        }
        .theme-toggle{display:inline-flex;align-items:center;gap:10px;color:var(--text-muted);font-size:.85rem;}
        .theme-toggle .form-check-input{cursor:pointer;}

        .toolbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center;padding-right:240px;}
        .title{font-size:1.12rem;color:var(--text);letter-spacing:.2px;margin:0;}
        .search{
            width:min(980px,100%);
            border:1px solid var(--stroke);
            background:rgba(255,255,255,.75);
            border-radius:999px;
            padding:10px 12px;
            outline:none;
            font-size:.95rem;
        }
        body.dark-mode .search{background:rgba(2,6,23,.35);color:var(--text);}
        .count{font-size:.9rem;color:var(--muted);margin-left:auto;}

        .action-btn{
            display:inline-flex;align-items:center;gap:8px;
            text-decoration:none;
            padding:8px 10px;border-radius:999px;
            border:1px solid rgba(224,183,97,.40);
            background:linear-gradient(135deg, rgba(250,204,107,.32), rgba(224,183,97,.18));
            color:var(--text-main) !important;
            white-space:nowrap;
        }
        .action-btn:hover{filter:brightness(1.02);}

        .tblwrap{
            padding:12px;
            overflow:auto;
            border-radius:18px;
            border:1px solid var(--stroke);
            background:rgba(255,255,255,.55);
        }
        body.dark-mode .tblwrap{background:rgba(2,6,23,.28);border-color:rgba(31,41,55,.75);}

        table{min-width:1200px;width:100%;font-size:.93rem;}
        thead th{
            position:sticky;top:0;z-index:2;
            background:rgba(255,255,255,.92);
            color:var(--muted);
            font-size:.80rem;
            border-bottom:1px solid var(--stroke) !important;
            white-space:nowrap;
            padding:9px 8px !important;
            text-align:center;
        }
        body.dark-mode thead th{background:rgba(11,18,32,.96);border-bottom:1px solid rgba(31,41,55,.75) !important;}
        tbody td{
            border-top:1px solid rgba(229,231,235,.55) !important;
            padding:9px 8px !important;
            vertical-align:middle;
            text-align:center;
        }
        tbody tr:hover{background:rgba(224,183,97,.08);}
        body.dark-mode tbody tr:hover{background:rgba(224,183,97,.10);}
        body.dark-mode tbody td{border-top:1px solid rgba(31,41,55,.55) !important;}

        .idx{width:70px;color:var(--muted);font-variant-numeric:tabular-nums;}
        .ava-cell{width:60px;}
        .ava{
            width:40px;height:40px;border-radius:14px;
            border:1px solid var(--stroke);
            object-fit:cover;background:rgba(17,24,39,.04);
            cursor:zoom-in;
        }
        body.dark-mode .ava{background:rgba(2,6,23,.35);}
        .ava-fb{
            width:40px;height:40px;border-radius:14px;
            border:1px solid var(--stroke);
            display:inline-flex;align-items:center;justify-content:center;
            background:rgba(224,183,97,.10);
            color:var(--accent);
        }

        .code,.nm,.pos{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;text-align:center;}
        .code{width:140px;font-variant-numeric:tabular-nums;}
        .nm{max-width:620px;color:var(--text);}
        .pos{max-width:420px;color:var(--muted);}
        .num{white-space:nowrap;font-variant-numeric:tabular-nums;}

        .back{
            display:inline-flex;align-items:center;gap:8px;text-decoration:none;
            color:var(--text-main) !important;
            padding:9px 12px;border-radius:999px;
            border:1px solid var(--border-soft);
            background:var(--glass-bg);
            backdrop-filter: blur(10px) saturate(140%);
            -webkit-backdrop-filter: blur(10px) saturate(140%);
            box-shadow:0 10px 24px rgba(15,23,42,0.14);
            transition:transform .10s ease, box-shadow .16s ease, border-color .16s ease;
        }
        body.dark-mode .back{box-shadow:0 10px 24px rgba(15,23,42,0.30);}
        .back:hover{transform:translateY(-1px);border-color:rgba(224,183,97,.55);box-shadow:0 14px 34px rgba(224,183,97,.18);}

        .modal-content{
            background:rgba(255,255,255,.96);
            border:1px solid var(--stroke);
            border-radius:18px;
            color:var(--text);
        }
        body.dark-mode .modal-content{background:rgba(11,18,32,.96);}
        .btn-close{filter:invert(0) grayscale(1); opacity:.9}
        body.dark-mode .btn-close{filter:invert(1) grayscale(1); opacity:.9}
        .photo-box{
            width:100%;
            border-radius:18px;
            border:1px solid var(--stroke);
            background:rgba(17,24,39,.04);
            overflow:hidden;
        }
        body.dark-mode .photo-box{background:rgba(2,6,23,.35);}
        .photo-box img{width:100%;height:auto;display:block;object-fit:contain;max-height:78vh;}

        .pager{
            display:flex;gap:10px;align-items:center;justify-content:center;
            margin-top:14px;flex-wrap:wrap;
        }
        .pager a{
            text-decoration:none;
            padding:8px 10px;border-radius:999px;
            border:1px solid var(--border-soft);
            background:var(--glass-bg);
            color:var(--text-main) !important;
        }
        .pager .muted{font-size:.9rem;}
    </style>
</head>
<body>
@php
    $meUser = auth()->user();
    $meEmp  = $meUser?->employee;

    $isEn   = app()->getLocale() === 'en';
    $t = function($en,$th) use ($isEn){ return $isEn ? $en : $th; };

    $meCode = trim((string)($meUser?->username ?? data_get($meEmp,'employee_code','')));

   
    $allViewCodes = ['60002','60003','60004','65049'];
    $canAllView = in_array($meCode, $allViewCodes, true);

  
    $allMode = $canAllView && ((string)request('all') === '1');

 
    $cycle = $cycle ?? \App\Models\Cycle::query()
        ->where('is_active', true)
        ->orderByDesc('id')
        ->first();

    if (!$cycle) {
        $cycle = \App\Models\Cycle::query()
            ->where('status', \App\Models\Cycle::STATUS_OPEN)
            ->orderByDesc('id')
            ->first();
    }

    $cycleId = $cycle ? (int)$cycle->id : 0;

    $cycleLabel = $cycle ? trim((string)($cycle->code ?? ('#'.$cycleId))) : '-';
    if ($cycle) {
        $nm = $isEn ? trim((string)($cycle->name_en ?? '')) : trim((string)($cycle->name_th ?? ''));
        if ($nm !== '') $cycleLabel .= ' • '.$nm;
        $cycleLabel .= ' (OPEN)';
    } else {
        $cycleLabel = $t('No open cycle', 'ไม่มีรอบที่เปิดอยู่');
    }

    // ซ่อนคะแนนของผู้บริหาร (กันแสดงข้อมูลเขาเองในตารางสายบังคับบัญชา)
    $blockedCodes = ['60002','60003','60004','65049'];


    $urlAll  = request()->fullUrlWithQuery(['all'=>1]);
    $urlMine = request()->fullUrlWithQuery(['all'=>null]);


    $scope = $scope ?? (string)request('scope','dept');
    $deptBlocks = $deptBlocks ?? [];
    $divisions  = $divisions ?? [];

   
    $isNullish = function($v){
        if ($v === null) return true;
        $s = trim((string)$v);
        if ($s === '') return true;
        if (!is_numeric($s)) return false;
        return ((float)$s) <= 0.0;
    };

    $fmtPercent = function($v) use ($isNullish){
        if ($isNullish($v)) return '-';
        $n = (float)$v;
        $s = rtrim(rtrim(number_format($n, 2, '.', ''), '0'), '.');
        return $s.'%';
    };

    $fmtScore = function($v) use ($isNullish){
        if ($isNullish($v)) return '-';
        $n = (float)$v;
        return rtrim(rtrim(number_format($n, 2, '.', ''), '0'), '.');
    };

   
    $exportTable = null;
    if ($allMode) {
        if (\Illuminate\Support\Facades\Schema::hasTable('export_employee')) $exportTable = 'export_employee';
        elseif (\Illuminate\Support\Facades\Schema::hasTable('export_employees')) $exportTable = 'export_employees';
    }

    $col = function($table, array $cands){
        foreach ($cands as $c) {
            if ($table && \Illuminate\Support\Facades\Schema::hasColumn($table, $c)) return $c;
        }
        return null;
    };

    $allPage = null;
    $allErr  = '';

    if ($allMode) {
        if (!$cycleId) {
            $allErr = $t('No open cycle now.', 'ตอนนี้ไม่มีรอบที่เปิดอยู่');
        } elseif (!$exportTable) {
            $allErr = $t('Export table not found (export_employee / export_employees).', 'ไม่พบตาราง export_employee / export_employees');
        } else {
            $cEmp   = $col($exportTable, ['employee_code']);
            $cPos   = $col($exportTable, ['position','employee_position','pos']);
            $cNTH   = $col($exportTable, ['full_name_th','name_th','employee_name_th']);
            $cNEN   = $col($exportTable, ['full_name_en','name_en','employee_name_en']);

         
            $cSelf  = $col($exportTable, ['q_percent']);
            $cSupSc = $col($exportTable, ['supervisor_final_score']);

            if (!$cEmp) {
                $allErr = $t('Export table missing employee_code.', 'ตาราง export ไม่มีคอลัมน์ employee_code');
            } else {
                $perPage = 700;

                $q = \Illuminate\Support\Facades\DB::table($exportTable.' as ex')
                    ->leftJoin('employees as e', 'e.employee_code', '=', 'ex.'.$cEmp);

                if (\Illuminate\Support\Facades\Schema::hasColumn($exportTable, 'cycle_id')) {
                    $q->where('ex.cycle_id', $cycleId);
                }

                $q->select([
                    'ex.'.$cEmp.' as code',

                    $cNTH ? ('ex.'.$cNTH.' as name_th') : \Illuminate\Support\Facades\DB::raw('NULL as name_th'),
                    $cNEN ? ('ex.'.$cNEN.' as name_en') : \Illuminate\Support\Facades\DB::raw('NULL as name_en'),
                    $cPos ? ('ex.'.$cPos.' as position') : \Illuminate\Support\Facades\DB::raw('NULL as position'),

                    $cSelf  ? ('ex.'.$cSelf.' as self') : \Illuminate\Support\Facades\DB::raw('NULL as self'),
                    $cSupSc ? ('ex.'.$cSupSc.' as sup_score') : \Illuminate\Support\Facades\DB::raw('NULL as sup_score'),

                    'e.full_name_th as e_name_th',
                    'e.full_name_en as e_name_en',
                    'e.position as e_pos',
                ])->orderBy('ex.'.$cEmp);

                $allPage = $q->simplePaginate($perPage)->appends(request()->query());

                $mapped = $allPage->getCollection()->map(function($r) use ($isEn) {
                    $code = trim((string)($r->code ?? ''));

                    $nTH = trim((string)($r->name_th ?? ''));
                    $nEN = trim((string)($r->name_en ?? ''));

                    $eTH = trim((string)($r->e_name_th ?? ''));
                    $eEN = trim((string)($r->e_name_en ?? ''));

                    $name = $isEn
                        ? (($nEN !== '' ? $nEN : ($eEN !== '' ? $eEN : ($nTH !== '' ? $nTH : ($eTH !== '' ? $eTH : $code)))))
                        : (($nTH !== '' ? $nTH : ($eTH !== '' ? $eTH : ($nEN !== '' ? $nEN : ($eEN !== '' ? $eEN : $code)))));

                    $pos = trim((string)($r->position ?? ''));
                    if ($pos === '') $pos = trim((string)($r->e_pos ?? ''));
                    if ($pos === '') $pos = '-';

                    return [
                        'code' => $code,
                        'name' => $name !== '' ? $name : '-',
                        'position' => $pos,
                        'self' => $r->self ?? null,
                        'sup_score' => $r->sup_score ?? null,
                    ];
                });

                $allPage->setCollection($mapped);
            }
        }
    }

    $rowsByCode = [];
    $addRow = function ($node, $fallbackCode=null, $fallbackName=null, $fallbackPos=null)
        use (&$rowsByCode, $blockedCodes)
    {
        $code = trim((string)(
            data_get($node,'employee_code')
            ?? data_get($node,'code')
            ?? data_get($node,'username')
            ?? $fallbackCode
        ));
        if ($code === '') return;

        $nameTH = trim((string)(data_get($node,'full_name_th') ?? ''));
        $nameEN = trim((string)(data_get($node,'full_name_en') ?? ''));

        $pos  = trim((string)(data_get($node,'position') ?? $fallbackPos ?? '-')) ?: '-';

        $photo = trim((string)(data_get($node,'_profile_url') ?? ''));

        $self = data_get($node,'_self_q_percent');
        $supScore = data_get($node,'_sup_final_score');

        if (in_array($code, $blockedCodes, true)) {
            $self=null; $supScore=null; $nameTH=''; $nameEN='';
        }

        $prev = $rowsByCode[$code] ?? null;

        $rowsByCode[$code] = [
            'code'=>$code,
            'name_th'=>($prev && ($prev['name_th'] ?? '') !== '' ? $prev['name_th'] : $nameTH),
            'name_en'=>($prev && ($prev['name_en'] ?? '') !== '' ? $prev['name_en'] : $nameEN),

            'position'=>($prev && ($prev['position'] ?? '-') !== '-' ? $prev['position'] : ($pos ?: '-')),
            'photo'=>($prev && !empty($prev['photo']) ? $prev['photo'] : ($photo ?: '')),

            'self'=>($prev && $prev['self'] !== null ? $prev['self'] : $self),
            'sup_score'=>($prev && $prev['sup_score'] !== null ? $prev['sup_score'] : $supScore),
        ];
    };

    if (!$allMode) {
        if ($scope === 'plant') {
            foreach ($deptBlocks as $dept) {
                foreach ((data_get($dept,'divisions') ?? []) as $div) {
                    foreach ((data_get($div,'supBlocks') ?? []) as $sup) {
                        $addRow($sup, data_get($sup,'sup_code'), data_get($sup,'sup_name'), data_get($sup,'position'));
                        foreach ((data_get($sup,'employees') ?? []) as $emp) {
                            $addRow($emp,
                                data_get($emp,'employee_code') ?? data_get($emp,'code') ?? data_get($emp,'username'),
                                null,
                                data_get($emp,'position')
                            );
                        }
                    }
                }
            }
        } else {
            foreach ($divisions as $div) {
                foreach ((data_get($div,'supBlocks') ?? []) as $sup) {
                    $addRow($sup, data_get($sup,'sup_code'), data_get($sup,'sup_name'), data_get($sup,'position'));
                    foreach ((data_get($sup,'employees') ?? []) as $emp) {
                        $addRow($emp,
                            data_get($emp,'employee_code') ?? data_get($emp,'code') ?? data_get($emp,'username'),
                            null,
                            data_get($emp,'position')
                        );
                    }
                }
            }
        }

        if ($meCode !== '' && isset($rowsByCode[$meCode])) unset($rowsByCode[$meCode]);

        $rows = array_values($rowsByCode);

        $codes = array_values(array_filter(array_map(fn($r)=>trim((string)($r['code'] ?? '')), $rows)));
        $empIndex = collect();
        if (!empty($codes)) {
            $empIndex = \App\Models\Employee::query()
                ->select(['employee_code','full_name_th','full_name_en','position'])
                ->whereIn('employee_code', $codes)
                ->get()
                ->keyBy('employee_code');
        }

        foreach ($rows as &$r) {
            $c = trim((string)($r['code'] ?? ''));
            if ($c === '') continue;

            $e = $empIndex->get($c);
            if ($e) {
                $th = trim((string)($e->full_name_th ?? ''));
                $en = trim((string)($e->full_name_en ?? ''));
                if (($r['name_th'] ?? '') === '' && $th !== '') $r['name_th'] = $th;
                if (($r['name_en'] ?? '') === '' && $en !== '') $r['name_en'] = $en;

                if (($r['position'] ?? '-') === '-' && trim((string)($e->position ?? '')) !== '') {
                    $r['position'] = trim((string)$e->position);
                }
            }
        }
        unset($r);

        foreach ($rows as &$r) {
            $nTH = trim((string)($r['name_th'] ?? ''));
            $nEN = trim((string)($r['name_en'] ?? ''));
            $r['name'] = $isEn
                ? ($nEN !== '' ? $nEN : ($nTH !== '' ? $nTH : ($r['code'] ?? '-')))
                : ($nTH !== '' ? $nTH : ($nEN !== '' ? $nEN : ($r['code'] ?? '-')));
        }
        unset($r);

        usort($rows, function($a,$b){
            $pa = (string)($a['position'] ?? '');
            $pb = (string)($b['position'] ?? '');
            $c1 = strnatcasecmp($pa,$pb);
            if ($c1 !== 0) return $c1;

            $c2 = strnatcasecmp((string)($a['name'] ?? ''), (string)($b['name'] ?? ''));
            if ($c2 !== 0) return $c2;

            return strnatcasecmp((string)($a['code'] ?? ''), (string)($b['code'] ?? ''));
        });
    }

    $tTitle  = $allMode
        ? $t('All employees evaluations', 'ผลประเมินพนักงานทั้งหมด')
        : $t('Employees in your line', 'พนักงานในสายของคุณ');

    $tSearch = $t('Search code / name / position...', 'ค้นหา รหัส/ชื่อ/ตำแหน่ง...');
@endphp

<div class="wrap">
    <div class="card card-glass mb-3 header-card">
        <div class="card-body" style="padding:16px 16px 14px 16px;">
            <div class="top-right">
                <div class="pill lang-switch">
                    <form id="localeForm" action="{{ route('locale.switch') }}" method="POST">
                        @csrf
                        <input type="hidden" name="locale" id="localeInput">
                        <button type="button" class="lang-btn" data-locale="th" data-active="{{ app()->getLocale()==='th' ? 'true' : 'false' }}">TH</button>
                        <button type="button" class="lang-btn" data-locale="en" data-active="{{ app()->getLocale()==='en' ? 'true' : 'false' }}">EN</button>
                    </form>
                </div>
                <div class="pill theme-toggle">
                    <div class="form-check form-switch m-0">
                        <input class="form-check-input" type="checkbox" id="themeToggle">
                    </div>
                </div>
            </div>

            <div class="toolbar">
                <div class="title">{{ $tTitle }}</div>

                @if($canAllView)
                    @if(!$allMode)
                        <a class="action-btn" href="{{ $urlAll }}">
                            {{ $t('View all employees','ดูพนักงานทั้งหมด') }}
                        </a>
                    @else
                        <a class="action-btn" href="{{ $urlMine }}">
                            {{ $t('Back to my line','กลับไปดูพนักงานในสาย') }}
                        </a>
                    @endif
                @endif

                <div class="count" id="countShown">
                    @if($allMode)
                        {{ $allPage ? $allPage->count() : 0 }}
                    @else
                        {{ isset($rows) ? count($rows) : 0 }}
                    @endif
                </div>
            </div>

            <div class="mt-2 muted" style="font-size:.88rem;">
                {{ $t('Current open cycle','รอบที่เปิดอยู่') }}:
                <span style="color:var(--text-main)">{{ $cycleLabel }}</span>
            </div>

            <div class="mt-3">
                <input id="q" class="search" placeholder="{{ $tSearch }}">
            </div>

            @if($allMode && $allErr)
                <div class="mt-3" style="color:var(--muted)">{{ $allErr }}</div>
            @endif
        </div>
    </div>

    <div class="tblwrap card-glass">
        <table class="table table-borderless align-middle mb-0">
            <thead>
            <tr>
                <th class="idx">{{ $t('#','ลำดับ') }}</th>

                @if(!$allMode)
                    <th style="width:60px;"></th>
                @endif

                <th style="width:140px;">{{ $t('Emp Code','รหัสพนักงาน') }}</th>
                <th style="min-width:260px;">{{ $t('Name','ชื่อ') }}</th>
                <th style="min-width:220px;">{{ $t('Position','ตำแหน่ง') }}</th>

                <th style="width:180px;">{{ $t('Self evaluation score','คะแนนประเมิน(ตัวเอง)') }}</th>
                <th style="width:210px;">{{ $t('Supervisor evaluation score','คะแนนประเมิน(จากหัวหน้า)') }}</th>
            </tr>
            </thead>

            <tbody id="tbody">
            @if($allMode)
                @php $baseIndex = $allPage ? (($allPage->currentPage() - 1) * $allPage->perPage()) : 0; @endphp

                @if($allPage)
                    @foreach($allPage as $r)
                        @php
                            $code = trim((string)($r['code'] ?? ''));
                            $nm   = trim((string)($r['name'] ?? '-')) ?: '-';
                            $pos  = trim((string)($r['position'] ?? '-')) ?: '-';

                            $selfTxt = $fmtPercent($r['self'] ?? null);
                            $supScoreTxt = $fmtScore($r['sup_score'] ?? null);

                            $blob = strtolower(trim($code.' '.$nm.' '.$pos));
                        @endphp
                        <tr data-search="{{ e($blob) }}">
                            <td class="idx js-ord">{{ $baseIndex + $loop->iteration }}</td>
                            <td class="code" title="{{ e($code) }}">{{ $code }}</td>
                            <td class="nm" title="{{ e($nm) }}">{{ $nm }}</td>
                            <td class="pos" title="{{ e($pos) }}">{{ $pos }}</td>
                            <td class="num">{{ $selfTxt }}</td>
                            <td class="num">{{ $supScoreTxt }}</td>
                        </tr>
                    @endforeach
                @endif
            @else
                @foreach(($rows ?? []) as $r)
                    @php
                        $code = trim((string)($r['code'] ?? ''));
                        $nm   = trim((string)($r['name'] ?? '-')) ?: '-';
                        $pos  = trim((string)($r['position'] ?? '-')) ?: '-';

                        $selfTxt = $fmtPercent($r['self'] ?? null);
                        $supScoreTxt = $fmtScore($r['sup_score'] ?? null);

                        $blob = strtolower(trim($code.' '.$nm.' '.$pos));
                    @endphp

                    <tr data-search="{{ e($blob) }}">
                        <td class="idx js-ord">{{ $loop->iteration }}</td>

                        <td class="ava-cell">
                            @if(!empty($r['photo']))
                                <img class="ava js-zoom"
                                     src="{{ e($r['photo']) }}"
                                     loading="lazy"
                                     data-name="{{ e($nm) }}"
                                     alt="p">
                            @else
                                <span class="ava-fb">{{ mb_substr($nm,0,1) }}</span>
                            @endif
                        </td>

                        <td class="code" title="{{ e($code) }}">{{ $code }}</td>
                        <td class="nm" title="{{ e($nm) }}">{{ $nm }}</td>
                        <td class="pos" title="{{ e($pos) }}">{{ $pos }}</td>

                        <td class="num">{{ $selfTxt }}</td>
                        <td class="num">{{ $supScoreTxt }}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

    @if($allMode && $allPage && ($allPage->previousPageUrl() || $allPage->nextPageUrl()))
        <div class="pager">
            @if($allPage->previousPageUrl())
                <a href="{{ $allPage->previousPageUrl() }}">{{ $t('Prev','ก่อนหน้า') }}</a>
            @endif
            <span class="muted">{{ $t('Page','หน้า') }} {{ $allPage->currentPage() }}</span>
            @if($allPage->nextPageUrl())
                <a href="{{ $allPage->nextPageUrl() }}">{{ $t('Next','ถัดไป') }}</a>
            @endif
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('profile') }}" class="back">
            <span>{{ __('app.assess_back_profile') }}</span>
        </a>
    </div>
</div>

{{-- Photo modal --}}
<div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <div class="modal-title">{{ $t('Photo','รูป') }}</div>
                    <div class="muted" id="pSub">-</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('app.assess_overview_btn_close') }}"></button>
            </div>
            <div class="modal-body">
                <div class="photo-box">
                    <img id="pImg" alt="photo">
                </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid var(--stroke)">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    {{ __('app.assess_overview_btn_close') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
    const html = document.documentElement;
    const toggle = document.getElementById('themeToggle');

    function getMode(){ try{ return localStorage.getItem('supavut_theme_mode'); }catch(e){ return null; } }
    function setMode(m){ try{ localStorage.setItem('supavut_theme_mode', m); }catch(e){} }
    function applyMode(m){
        const dark = (m === 'dark');
        html.classList.toggle('dark-mode', dark);
        document.body.classList.toggle('dark-mode', dark);
        if (toggle) toggle.checked = dark;
    }
    const init = (getMode()==='light' || getMode()==='dark') ? getMode() : 'dark';
    applyMode(init);
    if (toggle){
        toggle.addEventListener('change', () => {
            const m = toggle.checked ? 'dark' : 'light';
            setMode(m); applyMode(m);
        });
    }

    // locale
    const localeForm = document.getElementById('localeForm');
    const localeInput = document.getElementById('localeInput');
    document.querySelectorAll('.lang-btn').forEach(b=>{
        b.addEventListener('click', ()=>{
            const loc = b.getAttribute('data-locale');
            if (localeInput) localeInput.value = loc;
            if (localeForm) localeForm.submit();
        });
    });

    // photo modal
    const photoModalEl = document.getElementById('photoModal');
    const photoModal = photoModalEl ? new bootstrap.Modal(photoModalEl) : null;
    const pImg = document.getElementById('pImg');
    const pSub = document.getElementById('pSub');
    const tbody = document.getElementById('tbody');

    if (tbody) {
        tbody.addEventListener('click', (ev)=>{
            const t = ev.target;
            if (!t || !t.classList || !t.classList.contains('js-zoom')) return;
            if (!photoModal || !pImg) return;
            const src = t.getAttribute('src') || '';
            if (!src) return;
            pImg.src = src;
            if (pSub) pSub.textContent = t.getAttribute('data-name') || '-';
            photoModal.show();
        });
        tbody.querySelectorAll('.js-zoom').forEach(img=>{
            img.setAttribute('tabindex','0');
            img.setAttribute('role','button');
        });
    }

    // search
    const q = document.getElementById('q');
    const countShown = document.getElementById('countShown');
    let timer = null;

    function runFilter(){
        if (!tbody) return;
        const s = (q ? q.value : '').toLowerCase().trim();
        let n = 0;

        tbody.querySelectorAll('tr').forEach(tr=>{
            const blob = (tr.getAttribute('data-search') || '');
            const ok = !s || blob.includes(s);
            tr.style.display = ok ? '' : 'none';
            if (ok) n++;
        });
        if (countShown) countShown.textContent = String(n);
    }

    if (q) {
        q.addEventListener('input', ()=>{
            if (timer) clearTimeout(timer);
            timer = setTimeout(runFilter, 80);
        });
    }
})();
</script>
</body>
</html>
