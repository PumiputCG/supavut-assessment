<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('app.assess_eval_title', ['code' => $employee->employee_code]) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">

    <script>
        (function () {
            const KEY = 'supavut_theme_mode';
            try {
                const saved = localStorage.getItem(KEY);
                const mode = (saved === 'light' || saved === 'dark') ? saved : 'dark';
                document.documentElement.classList.toggle('dark-mode', mode === 'dark');
                if (!saved) localStorage.setItem(KEY, mode);
            } catch (e) {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>

    <style>
        .ip-help{
    margin:10px 0 10px;
    padding:8px 10px;
    border-radius:12px;
    border:1px dashed rgba(148,163,184,0.55);
    background:rgba(0,0,0,0.02);
    color:var(--muted);
    font-size:0.86rem;
    line-height:1.45;
    display:flex;
    gap:10px;
    align-items:flex-start;
}
html.dark-mode .ip-help{
    background:#0b1120;
    border-color:#334155;
}
.ip-help i{ font-size:1.05rem; line-height:1.2; color:var(--info); }
.ip-help b{ color:var(--text); font-weight:600; }

        :root{
            --bg:#f5f7fb;
            --card-bg:#ffffff;
            --text:#111827;
            --muted:#6b7280;
            --border:#e5e7eb;
            --glass: rgba(255,255,255,0.72);
            --shadow: 0 18px 40px rgba(15,23,42,0.14);
            --chip-bg:#f9fafb;
            --chip-border:#d1d5db;
            --gold:#facc15;
            --gold2:#f59e0b;
            --danger:#b91c1c;
            --danger2:#fca5a5;
            --ok:#16a34a;
            --info:#2563eb;
        }
        html.dark-mode{
            --bg:#020617;
            --card-bg:#020617;
            --text:#e5e7eb;
            --muted:#9ca3af;
            --border:#1f2937;
            --glass: rgba(255,255,255,0.08);
            --shadow: 0 18px 40px rgba(0,0,0,0.6);
            --chip-bg:#020617;
            --chip-border:#374151;
            --gold:#facc15;
            --gold2:#f59e0b;
            --danger:#ef4444;
            --danger2:#fecaca;
            --ok:#22c55e;
            --info:#60a5fa;
        }

        body{
            margin:0;
            padding:16px;
            font-family:Prompt,system-ui,sans-serif;
            background:var(--bg);
            color:var(--text);
            transition:background .2s,color .2s;
        }

        .wrap{
            max-width:900px;
            margin:0 auto;
            background:var(--card-bg);
            border-radius:18px;
            padding:18px 20px;
            border:1px solid var(--border);
            box-shadow:var(--shadow);
        }

        .muted{font-size:0.8rem;color:var(--muted)}
        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:8px;
            margin-bottom:12px;
            flex-wrap:wrap;
        }
        .top-bar-left{min-width:0}
        .top-title{font-size:0.95rem;font-weight:600}
        .top-bar-right{
            display:flex;
            align-items:center;
            gap:8px;
            flex-wrap:wrap;
            justify-content:flex-end;
        }

        .top-actions{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
        .lang-switch{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:4px 6px;
            border-radius:999px;
            background:var(--glass);
            border:1px solid var(--border);
            backdrop-filter: blur(10px) saturate(140%);
            box-shadow: 0 10px 24px rgba(0,0,0,0.12);
        }
        html.dark-mode .lang-switch{box-shadow: 0 10px 24px rgba(0,0,0,0.35);}
        .lang-form{margin:0;display:flex;gap:6px;align-items:center}
        .lang-btn-square{
            border:1px solid transparent;
            background:transparent;
            color:var(--text);
            padding:6px 10px;
            border-radius:10px;
            font-size:.75rem;
            font-weight:900;
            letter-spacing:.04em;
            text-transform:uppercase;
            min-width:42px;
            cursor:pointer;
            transition:transform .15s, box-shadow .15s, border-color .15s, background .15s;
        }
        .lang-btn-square:hover{transform:translateY(-1px);box-shadow:0 10px 18px rgba(0,0,0,0.10)}
        html.dark-mode .lang-btn-square:hover{box-shadow:0 10px 18px rgba(0,0,0,0.35)}
        .lang-btn-square[data-active="true"]{
            background:linear-gradient(135deg,var(--gold2),var(--gold));
            color:#111827;
            border-color:rgba(250,204,21,.9);
            box-shadow:0 0 0 2px rgba(255,255,255,.18) inset;
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
            box-shadow: 0 10px 24px rgba(0,0,0,0.12);
        }
        html.dark-mode .theme-toggle-box{box-shadow: 0 10px 24px rgba(0,0,0,0.35);}
        #themeIcon{font-size:1.05rem;line-height:1}
        .form-check-input{cursor:pointer}

        .emp-row{display:flex;align-items:center;gap:12px;flex-wrap:wrap}
        .avatar{width:52px;height:52px;border-radius:999px;overflow:hidden;border:2px solid #4b5563;background:#111827;flex-shrink:0;cursor:pointer;transition:box-shadow .18s,border-color .18s,transform .18s}
        .avatar img{width:100%;height:100%;object-fit:cover}
        .avatar:hover{border-color:var(--gold);box-shadow:0 0 0 2px rgba(250,204,21,0.55);transform:translateY(-1px)}
        .emp-main{font-size:0.9rem}
        .emp-name{font-weight:600;font-size:1.25rem}
        .emp-meta{font-size:0.9rem;color:var(--muted);margin-top:2px}

        h1{font-size:1.1rem;margin:14px 0 4px}
        h2{font-size:1rem;margin:16px 0 4px}

        .btn-formula{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:4px 10px;
            border-radius:999px;
            border:1px solid rgba(148,163,184,0.55);
            background:rgba(0,0,0,0.03);
            color:var(--text);
            font-size:0.75rem;
            cursor:pointer;
            margin-left:8px;
            vertical-align:middle;
            transition:transform .15s, box-shadow .15s, background .15s, border-color .15s;
        }
        html.dark-mode .btn-formula{background:#111827;border-color:#4b5563;color:#e5e7eb}
        .btn-formula:hover{transform:translateY(-1px);box-shadow:0 10px 18px rgba(0,0,0,0.10)}
        html.dark-mode .btn-formula:hover{box-shadow:0 10px 18px rgba(0,0,0,0.35)}

        .score-box{padding:8px 10px;border-radius:12px;background:rgba(15,23,42,0.06);border:1px solid var(--border);margin-bottom:6px}
        html.dark-mode .score-box{background:#0b1220;}
        .score-box.summary{border-color:rgba(250,204,21,0.55);box-shadow:0 0 0 1px rgba(250,204,21,0.15);background:rgba(250,204,21,0.08)}
        html.dark-mode .score-box.summary{background:#020617;border-color:var(--gold)}
        .score-box.total{background:rgba(34,197,94,0.08);border-color:rgba(34,197,94,0.45)}
        html.dark-mode .score-box.total{background:#022c22;border-color:#16a34a}
        .score-box.bonus{background:rgba(59,130,246,0.08);border-color:rgba(148,163,184,0.45)}
        html.dark-mode .score-box.bonus{background:#111827;border-color:#4b5563}

        .score-box.ip-alert{
            border-color: rgba(248,113,113,0.85);
            box-shadow: 0 0 0 1px rgba(248,113,113,0.35);
            background: rgba(248,113,113,0.06);
        }
        html.dark-mode .score-box.ip-alert{
            border-color: rgba(248,113,113,0.55);
            background: rgba(185,28,28,0.14);
        }

        .score-box.ip-ok{
            border-color: rgba(34,197,94,0.65);
            box-shadow: 0 0 0 1px rgba(34,197,94,0.20);
            background: rgba(34,197,94,0.06);
        }
        html.dark-mode .score-box.ip-ok{
            border-color: rgba(34,197,94,0.55);
            background: rgba(2,44,34,0.45);
        }

        .ip-minimal-warning{
            margin-top:6px;
            font-size:0.88rem;
            color:var(--danger);
        }
        html.dark-mode .ip-minimal-warning{color:var(--danger2);}

        .score-main{font-size:1.3rem;font-weight:700}
        .score-box-footer{display:flex;justify-content:flex-end;margin-top:8px}

        .summary-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:8px;margin-top:4px}
        .summary-chip{padding:6px 10px;border-radius:999px;background:rgba(0,0,0,0.03);border:1px dashed rgba(148,163,184,0.6);display:flex;justify-content:space-between;align-items:center;font-size:0.85rem}
        html.dark-mode .summary-chip{background:#020617;border-color:#4b5563}
        .summary-chip-label{white-space:normal;color:var(--text)}
        .summary-chip-value{font-weight:600;color:var(--text)}
        .summary-total-line{margin-top:8px;font-size:0.9rem;font-weight:600}

        table{width:100%;border-collapse:collapse;font-size:0.88rem;margin-top:6px}
        th,td{padding:6px 8px;border-bottom:1px solid var(--border)}
        th{text-align:left;color:var(--muted);font-weight:500}
        td{text-align:right}
        .badge-raw{display:inline-block;margin-left:4px;font-size:0.78rem;padding:2px 8px;border-radius:999px;background:rgba(0,0,0,0.04);border:1px solid rgba(148,163,184,0.5);color:var(--text)}
        html.dark-mode .badge-raw{background:#111827;border-color:#4b5563;color:#e5e7eb}

        .row-bottom{display:flex;justify-content:space-between;align-items:center;gap:8px;flex-wrap:wrap;margin-top:14px}
        a.btn-back{
            display:inline-block;
            padding:6px 14px;
            border-radius:999px;
            border:1px solid rgba(148,163,184,0.55);
            color:var(--text);
            text-decoration:none;
            font-size:0.85rem;
            transition:background .18s,border-color .18s,box-shadow .18s,transform .18s;
        }
        a.btn-back:hover{
            background:rgba(0,0,0,0.03);
            box-shadow:0 0 0 1px rgba(148,163,184,0.28);
            transform:translateY(-0.5px);
        }
        html.dark-mode a.btn-back:hover{background:#111827}

        .btn{
            padding:6px 14px;
            border-radius:999px;
            border:1px solid rgba(148,163,184,0.55);
            background:rgba(0,0,0,0.03);
            color:var(--text);
            font-size:0.8rem;
            cursor:pointer;
            transition:background .18s,border-color .18s,box-shadow .18s,transform .18s;
        }
        html.dark-mode .btn{background:#111827;border-color:#4b5563;color:#e5e7eb}
        .btn[disabled]{opacity:0.4;cursor:not-allowed}
        .btn-save{background:linear-gradient(135deg,var(--gold2),var(--gold));border-color:rgba(250,204,21,.95);color:#111827;font-weight:700}
        .btn-save[disabled]{opacity:.45;cursor:not-allowed;background:#854d0e;border-color:#854d0e;color:#fefce8}

        .perf-table th:first-child,.perf-table td:first-child{text-align:left}
        .perf-table th:nth-child(2),.perf-table td:nth-child(2){text-align:center}
        .perf-table td{text-align:center}

        .btn-crit{
            padding:3px 9px;border-radius:999px;border:1px solid rgba(148,163,184,0.55);
            background:rgba(0,0,0,0.03);color:var(--text);font-size:0.7rem;cursor:pointer;
        }
        html.dark-mode .btn-crit{background:#0b1120;border-color:#4b5563;color:#e5e7eb}
        .btn-crit:hover{background:rgba(0,0,0,0.06)}
        html.dark-mode .btn-crit:hover{background:#020617}
        h2 .btn-crit{margin-left:6px;vertical-align:middle;}

        .modal-overlay{position:fixed;inset:0;background:rgba(15,23,42,0.8);display:none;align-items:center;justify-content:center;z-index:50;padding:16px}
        .modal-box{
            max-width:800px;width:100%;max-height:90vh;overflow:auto;
            background:var(--card-bg);
            border-radius:16px;border:1px solid var(--border);
            box-shadow:0 22px 50px rgba(0,0,0,0.55);
            padding:18px 20px;font-size:0.9rem;color:var(--text);line-height:1.6;
        }
        html.dark-mode .modal-box{background:#020617;border-color:#4b5563;color:#e5e7eb;box-shadow:0 22px 50px rgba(0,0,0,0.8);}
        .modal-header{display:flex;justify-content:space-between;align-items:center;gap:8px;margin-bottom:8px}
        .modal-title{font-size:1.1rem;font-weight:600}
        .modal-close{border:none;background:transparent;color:var(--muted);font-size:1.2rem;cursor:pointer}
        .modal-sub{font-size:0.88rem;color:var(--muted);margin-bottom:8px}

        .sticky-ip-box{position:sticky;top:0;z-index:5;border-radius:12px;box-shadow:0 16px 30px rgba(0,0,0,0.25)}
        html.dark-mode .sticky-ip-box{background:#020617;box-shadow:0 16px 30px rgba(0,0,0,0.65)}

        .rating-group{margin-top:10px;padding:10px;border-radius:12px;border:1px solid var(--border);background:rgba(0,0,0,0.02)}
        html.dark-mode .rating-group{background:#020617;border-color:#1f2937}
        .rating-group.filled{border-color:rgba(250,204,21,0.9);box-shadow:0 0 0 1px rgba(250,204,21,0.4);}
        html.dark-mode .rating-group.filled{border-color:var(--gold);box-shadow:0 0 0 1px rgba(250,204,21,0.45)}
        .rating-group.pulse{animation:pulseGlow .9s ease-in-out 0s 2;}
        @keyframes pulseGlow{
            0%{box-shadow:0 0 0 0 rgba(250,204,21,.0);}
            50%{box-shadow:0 0 0 3px rgba(250,204,21,.55);}
            100%{box-shadow:0 0 0 0 rgba(250,204,21,.0);}
        }

        /* ✅ กรอบเขียวเมื่อ “มีคะแนน” (Numeric) */
        .rating-group.done{
            border-color: rgba(34,197,94,0.75);
            box-shadow: 0 0 0 1px rgba(34,197,94,0.22);
            background: rgba(34,197,94,0.06);
        }
        html.dark-mode .rating-group.done{
            border-color: rgba(34,197,94,0.55);
            box-shadow: 0 0 0 1px rgba(34,197,94,0.18);
            background: rgba(2,44,34,0.45);
        }

        .rating-header{display:flex;justify-content:space-between;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:6px}
        .rating-title{font-size:0.86rem;font-weight:600}
        .rating-current{font-size:0.8rem;color:var(--muted)}
        .rating-row{display:flex;align-items:flex-start;justify-content:space-between;gap:8px;flex-wrap:wrap;margin-bottom:6px}
        .rating-row-label{font-size:0.8rem;color:var(--text);min-width:150px}
        html.dark-mode .rating-row-label{color:#e5e7eb}
        .rating-buttons{display:flex;gap:6px;flex-wrap:wrap;align-items:center}

        .rating-pill{
            min-width:30px;
            padding:4px 10px;
            border-radius:999px;
            border:1px solid rgba(148,163,184,0.55);
            background:rgba(0,0,0,0.03);
            color:var(--text);
            font-size:0.78rem;
            cursor:pointer;
            text-align:center;
            transition:background .18s,border-color .18s,box-shadow .18s,transform .18s;
        }
        html.dark-mode .rating-pill{background:#020617;border-color:#4b5563;color:#e5e7eb}
        .rating-pill.active{
            background:linear-gradient(135deg,var(--gold2),var(--gold));
            color:#111827;
            border-color:rgba(250,204,21,.95);
            box-shadow:0 0 0 1px rgba(250,204,21,0.65),0 0 14px rgba(250,204,21,0.35);
            transform:translateY(-0.5px);
        }

        .btn-fill{
            margin-left:8px;
            padding:3px 10px;
            border-radius:999px;
            border:1px solid rgba(148,163,184,0.55);
            background:rgba(0,0,0,0.03);
            color:var(--text);
            font-size:0.75rem;
            cursor:pointer;
            transition:transform .15s, box-shadow .15s, background .15s;
        }
        html.dark-mode .btn-fill{background:#111827;border-color:#4b5563;color:#e5e7eb}
        .btn-fill:hover{transform:translateY(-1px);box-shadow:0 10px 18px rgba(0,0,0,0.10)}
        html.dark-mode .btn-fill:hover{box-shadow:0 10px 18px rgba(0,0,0,0.35)}

        .avatar-modal-box{max-width:none;width:auto;max-height:none;overflow:visible;background:transparent;border:none;box-shadow:none;padding:0;display:flex;flex-direction:column;align-items:center;justify-content:center}
        .avatar-modal-img{max-width:90vw;max-height:80vh;border-radius:18px;border:2px solid var(--gold);box-shadow:0 22px 60px rgba(0,0,0,0.65)}
        .avatar-modal-close{margin-top:12px;padding:6px 16px;border-radius:999px;border:1px solid rgba(148,163,184,0.55);background:rgba(0,0,0,0.03);color:var(--text);font-size:0.8rem;cursor:pointer}
        html.dark-mode .avatar-modal-close{background:#111827;border-color:#4b5563;color:#e5e7eb}
        .avatar-modal-close:hover{background:rgba(0,0,0,0.06)}
        html.dark-mode .avatar-modal-close:hover{background:#020617}

        .flash-box{margin-bottom:10px;padding:8px 10px;border-radius:12px;font-size:0.85rem;border:1px solid transparent}
        .flash-success{background:rgba(34,197,94,0.10);border-color:rgba(34,197,94,0.45);color:#166534}
        html.dark-mode .flash-success{background:#022c22;border-color:#16a34a;color:#bbf7d0}
        .flash-warning{background:rgba(234,88,12,0.10);border-color:rgba(234,88,12,0.45);color:#9a3412}
        html.dark-mode .flash-warning{background:#451a03;border-color:#ea580c;color:#fed7aa}
        .flash-info{background:rgba(37,99,235,0.10);border-color:rgba(37,99,235,0.35);color:#1d4ed8}
        html.dark-mode .flash-info{background:rgba(96,165,250,0.12);border-color:rgba(96,165,250,0.35);color:#bfdbfe}

        .calc-box{
            padding:10px 12px;
            border-radius:12px;
            border:1px solid var(--border);
            background:rgba(0,0,0,0.02);
        }
        html.dark-mode .calc-box{background:#0b1120;border-color:#1f2937}
        .calc-mono{
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size:0.85rem;
            line-height:1.55;
            white-space:pre-wrap;
        }

        .modal-actions{
            position:sticky;
            bottom:0;
            z-index:6;
            display:flex;
            justify-content:flex-end;
            gap:10px;
            padding:10px 0 2px;
            margin-top:12px;
            background: linear-gradient(to top, rgba(255,255,255,0.92), rgba(255,255,255,0));
            backdrop-filter: blur(8px) saturate(140%);
        }
        html.dark-mode .modal-actions{
            background: linear-gradient(to top, rgba(2,6,23,0.92), rgba(2,6,23,0));
        }

        
    </style>
</head>

<body>
@php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Schema;

    $loc = app()->getLocale();
    $naText = 'N/A';

    $viewerRole = $viewerRole ?? ($assessmentRole ?? 'supervisor');
    $hideEvaluateActionButtons = isset($hideEvaluateActionButtons) ? (bool)$hideEvaluateActionButtons : false;
    $showUserActionButtons = !$hideEvaluateActionButtons;

    $empTable = method_exists($employee, 'getTable') ? $employee->getTable() : 'export_employees';

    $divLeadCols = ['division_score_leadership','division_score_leader','division_leadership'];
    $divAttCols  = ['division_score_attitude','division_score_attritude','division_attitude','division_attritude'];

    $pickCol = function(array $cols, string $fallback) use ($empTable) {
        foreach ($cols as $c) {
            try {
                if (Schema::hasColumn($empTable, $c)) return $c;
            } catch (\Throwable $e) {}
        }
        return $fallback;
    };

    $laLeadName = ($viewerRole === 'division')
        ? $pickCol($divLeadCols, 'division_score_leadership')
        : 'score_leadership';

    $laAttName  = ($viewerRole === 'division')
        ? $pickCol($divAttCols, 'division_score_attitude')
        : 'score_attitude';

    $pickVal = function(array $cols) use ($employee) {
        foreach ($cols as $c) {
            $v = data_get($employee, $c);
            if ($v !== null && $v !== '') return $v;
        }
        return null;
    };

    if ($viewerRole === 'division') {
        $leaderScore = $pickVal($divLeadCols);
        $attitudeScore = $pickVal($divAttCols);
    } else {
        if (!isset($leaderScore)) $leaderScore = data_get($employee, 'score_leadership');
        if (!isset($attitudeScore)) $attitudeScore = data_get($employee, 'score_attitude');

        if (($leaderScore === null || $leaderScore === '') && (data_get($employee, 'supervisor_score_leadership') !== null && data_get($employee, 'supervisor_score_leadership') !== '')) {
            $leaderScore = data_get($employee, 'supervisor_score_leadership');
        }
        if (($attitudeScore === null || $attitudeScore === '') && (data_get($employee, 'supervisor_score_attitude') !== null && data_get($employee, 'supervisor_score_attitude') !== '')) {
            $attitudeScore = data_get($employee, 'supervisor_score_attitude');
        }
    }

    $weightAttendance = (int)($calc['weightAttendance'] ?? 0);
    $weightIndividual = (int)($calc['weightIndividual'] ?? 0);
    $weightDeptOkr = (int)($calc['weightDeptOkr'] ?? 0);
    $weightCompanyOkr = (int)($calc['weightCompanyOkr'] ?? 0);
    $weightOkrReporting = (int)($calc['weightOkrReporting'] ?? 0);
    $weightSystem = (int)($calc['weightSystem'] ?? 0);
    $weightBonus = (int)($calc['weightBonus'] ?? 0);

    $base = (float)($calc['base'] ?? 100);
    $raw  = (float)($calc['raw'] ?? 0);
    $rawPercent = (float)($calc['rawPercent'] ?? 0);
    $attendancePoints = (float)($calc['attendancePoints'] ?? 0);

    $deduct_absent = (float)($calc['deduct_absent'] ?? 0);
    $deduct_sick = (float)($calc['deduct_sick'] ?? 0);
    $deduct_personal = (float)($calc['deduct_personal'] ?? 0);
    $deduct_late = (float)($calc['deduct_late'] ?? 0);
    $totalDeduct = (float)($calc['totalDeduct'] ?? 0);

    $deptOkrWeighted = (float)($calc['deptOkrWeighted'] ?? 0);
    $companyOkrWeighted = (float)($calc['companyOkrWeighted'] ?? 0);
    $okrReportWeighted = (float)($calc['okrReportWeighted'] ?? 0);
    $systemWeighted = (float)($calc['systemWeighted'] ?? 0);
    $bonusScore = (float)($calc['bonusScore'] ?? 0);
    $otherPoints = (float)($calc['otherPoints'] ?? 0);

    $ipTotalScore = (float)($calc['ipTotalScore'] ?? 0);
    $ipFullScore  = (float)($calc['ipFullScore'] ?? 0);
    $ipPercent = (float)($calc['ipPercent'] ?? 0);
    $ipWeightedScore = $calc['ipWeightedScore'] ?? null;
    $ipWeightedInit = (is_numeric($ipWeightedScore) ? (float)$ipWeightedScore : null);

    $maxWithBonus = (float)($calc['maxWithBonus'] ?? 0);
    $totalWithBonus = (float)($calc['totalWithBonus'] ?? 0);

    $gradeLetter = (string)($calc['gradeLetter'] ?? 'F');
    $gradeText = (string)($calc['gradeText'] ?? '');

    $warningCnt = (float)($calc['warning'] ?? 0);
    $suspensionCnt = (float)($calc['suspension'] ?? 0);

    $roleLabel = $viewerRole === 'division'
        ? ($loc==='th' ? 'ผู้ประเมิน: Division' : 'Evaluator: Division')
        : ($loc==='th' ? 'ผู้ประเมิน: Supervisor' : 'Evaluator: Supervisor');

    $statusText = trim((string)($employee->assessment_status ?? ''));

    $ipEvaluated = $viewerRole === 'division'
        ? ($statusText === '2/2')
        : in_array($statusText, ['1/1','2/2'], true);

    $alreadyEvaluated = $ipEvaluated;

    $ipItems = $ipItems ?? [];
    $ipItems = collect($ipItems)->map(function($t) use ($leaderScore, $attitudeScore){
        if (!is_array($t)) return $t;
        $id = trim((string)($t['id'] ?? ''));
        if ($id === 'leadership') $id = 'leader';
        if ($id === 'attritude') $id = 'attitude';
        $t['id'] = $id;

        if ($id === 'leader') $t['score'] = $leaderScore;
        if ($id === 'attitude') $t['score'] = $attitudeScore;

        return $t;
    })->values()->all();

    $ipBase = collect($ipItems)->filter(function ($x) {
        $id = is_array($x) ? ($x['id'] ?? null) : null;
        return !in_array($id, ['leader','attitude'], true);
    })->values()->all();

    $ipItemsModal = collect($ipItems)->filter(function($x){
        $id = is_array($x) ? ($x['id'] ?? null) : null;
        return !in_array($id, ['owner','problem'], true);
    })->values()->all();

    $backUrl = Route::has('assessment.employees') ? route('assessment.employees') : url('/assessment/employees');

    $saveUrl = null;
    if (Route::has('assessment.employees.store')) {
        $saveUrl = route('assessment.employees.store', ['employee' => $employee->id]);
    } elseif (Route::has('assessment.employees.save')) {
        $saveUrl = route('assessment.employees.save', ['employee' => $employee->id]);
    } else {
        $saveUrl = url('/assessment/employees/'.$employee->id);
    }

    $criteriaMap = [
        'teamwork' => 'Teamwork (Asakai)',
        'comm' => $loc==='th' ? 'เกณฑ์ Communication' : 'Communication (Red Alert)',
        'leader' => $loc==='th' ? 'เกณฑ์ Leadership' : 'Leadership criteria',
        'attitude' => $loc==='th' ? 'เกณฑ์ Attitude' : 'Attitude criteria',
        'planning' => $loc==='th' ? 'เกณฑ์ Planning' : 'Planning (Kaizen)',
        'owner' => $loc==='th' ? 'เกณฑ์ Ownership' : 'Ownership (Quality systems)',
        'problem' => $loc==='th' ? 'เกณฑ์ Problem Solving' : 'Problem Solving (QCC)',
        'dept_okr' => $loc==='th' ? 'เกณฑ์ Dept OKR' : 'Dept OKR criteria',
        'company_okr' => $loc==='th' ? 'เกณฑ์ Company OKR score' : 'Company OKR score',
        'okr_reporting' => $loc==='th' ? 'OKR - Reporting score' : 'OKR - Reporting score',
        'system' => $loc==='th' ? 'System (SMBR)' : 'System (SMBR)',
        'bonus' => $loc==='th' ? 'เกณฑ์ Bonus' : 'Bonus criteria',
    ];

    $criteriaDetailMap = [
 
'attendance' => $loc==='th'
    ? "วิธีการให้คะแนน\n\n"
      . "• ขาดงาน: -3 คะแนน/วัน\n"
      . "• ป่วย (มี & ไม่มีใบรับรองแพทย์): -1 คะแนน/วัน\n"
      . "• ลากิจ: -1 คะแนน/วัน\n"
      . "• สาย: -0.25 คะแนน/วัน\n\n"
      . "หมายเหตุ: สถิติทั้งหมดคิดคำนวณตั้งแต่วันที่ 1 มกราคม 2568 ถึง 31 ธันวาคม 2568"
    : "Scoring method\n\n"
      . "• Absent: -3 points/day\n"
      . "• Sick (with & without medical certificate): -1 point/day\n"
      . "• Personal leave: -1 point/day\n"
      . "• Late: -0.25 point/day\n\n"
      . "Note: Statistics are calculated from 1 Jan 2025 to 31 Dec 2025",

'ip' => $loc==='th'
    ? "Individual Performance score\n"
      . "\tวิธีการให้คะแนน : การให้คะแนนแต่ละหัวข้อในส่วนของ Soft skills สามารถให้คะแนนได้ดังต่อไปนี้\n"
      . "\tหัวข้อการประเมิน\n"
      . "\t• Teamwork\n"
      . "\t• Communication\n"
      . "\t• Leadership\n"
      . "\t• Attitude / Discipline\n"
      . "\t• Planning/Proactivity"
    : "Individual Performance score\n"
      . "\tScoring method: Each Soft skills topic can be scored as follows.\n"
      . "\tEvaluation topics\n"
      . "\t• Teamwork\n"
      . "\t• Communication\n"
      . "\t• Leadership\n"
      . "\t• Attitude / Discipline\n"
      . "\t• Planning/Proactivity",



'teamwork' => $loc==='th'
    ? "Teamwork\n"
      . "\tการประเมินคะแนนจากการเข้าร่วมการประชุม Asakai\n\n"
      . "\tคะแนน 10 : เข้าร่วมการประชุม 99.00 - 100 %\n"
      . "\tคะแนน 9  : เข้าร่วมการประชุม 98.00 - 98.99 %\n"
      . "\tคะแนน 8  : เข้าร่วมการประชุม 97.00 - 97.99 %\n"
      . "\tคะแนน 7  : เข้าร่วมการประชุม 96.00 - 96.99 %\n"
      . "\tคะแนน 6  : เข้าร่วมการประชุม 95.00 - 95.99 %\n"
      . "\tคะแนน 5  : เข้าร่วมการประชุม 94.00 - 94.99 %\n"
      . "\tคะแนน 4  : เข้าร่วมการประชุม 93.00 - 93.99 %\n"
      . "\tคะแนน 3  : เข้าร่วมการประชุม 92.00 - 92.99 %\n"
      . "\tคะแนน 2  : เข้าร่วมการประชุม 91.00 - 91.99 %\n"
      . "\tคะแนน 1  : เข้าร่วมการประชุม 90.00 - 90.99 %\n"
      . "\tคะแนน 0  : เข้าร่วมการประชุม < 90%\n\n"
      . "หมายเหตุ\n"
      . "\tการเข้าร่วมการประชุม Asakai ได้รับการยกเว้นสำหรับแผนกดังต่อไปนี้ MK, PD, PE, QAN, ML, ACC, BOI\n"
      . "\tโดยจะไม่นำมาคิดเป็นคะแนน"
    : "Teamwork\n"
      . "\tScoring is based on Asakai meeting attendance.\n\n"
      . "\tScore 10: 99.00 - 100%\n"
      . "\tScore 9 : 98.00 - 98.99%\n"
      . "\tScore 8 : 97.00 - 97.99%\n"
      . "\tScore 7 : 96.00 - 96.99%\n"
      . "\tScore 6 : 95.00 - 95.99%\n"
      . "\tScore 5 : 94.00 - 94.99%\n"
      . "\tScore 4 : 93.00 - 93.99%\n"
      . "\tScore 3 : 92.00 - 92.99%\n"
      . "\tScore 2 : 91.00 - 91.99%\n"
      . "\tScore 1 : 90.00 - 90.99%\n"
      . "\tScore 0 : < 90%\n\n"
      . "Note\n"
      . "\tAsakai meeting attendance is exempt for MK, PD, PE, QAN, ML, ACC, BOI and will not be counted as a score.",

'comm' => $loc==='th'
    ? "Communication\n"
      . "\tการประเมินคะแนนจากการเข้าร่วมการประชุม Red Alert ของทุกแผนก โดยให้คะแนนดังต่อไปนี้\n\n"
      . "\tคะแนน 10 : เข้าร่วมการประชุม 99.00 - 100 %\n"
      . "\tคะแนน 9  : เข้าร่วมการประชุม 98.00 - 98.99 %\n"
      . "\tคะแนน 8  : เข้าร่วมการประชุม 97.00 - 97.99 %\n"
      . "\tคะแนน 7  : เข้าร่วมการประชุม 96.00 - 96.99 %\n"
      . "\tคะแนน 6  : เข้าร่วมการประชุม 95.00 - 95.99 %\n"
      . "\tคะแนน 5  : เข้าร่วมการประชุม 94.00 - 94.99 %\n"
      . "\tคะแนน 4  : เข้าร่วมการประชุม 93.00 - 93.99 %\n"
      . "\tคะแนน 3  : เข้าร่วมการประชุม 92.00 - 92.99 %\n"
      . "\tคะแนน 2  : เข้าร่วมการประชุม 91.00 - 91.99 %\n"
      . "\tคะแนน 1  : เข้าร่วมการประชุม 90.00 - 90.99 %\n"
      . "\tคะแนน 0  : เข้าร่วมการประชุม < 90%\n\n"
      . "หมายเหตุ\n"
      . "\tเนื่องจากสถานการณ์การดำเนินงานและลักษณะงานเฉพาะด้าน ของแผนก MK, PM, QAN และ PD ในปี 2568\n"
      . "\tบริษัทฯ ขอสงวนสิทธิ์ในการ \"ทบทวนหรือปรับสัดส่วนน้ำหนัก\" ในหัวข้อการสื่อสาร (Communication)\n"
      . "\tให้สอดคล้องกับหน้างานจริง หรือพิจารณาใช้เกณฑ์อื่นที่เหมาะสมทดแทน เพื่อความยุติธรรมในการประเมินสูงสุด"
    : "Communication\n"
      . "\tScoring is based on Red Alert meeting attendance (all departments).\n\n"
      . "\tScore 10: 99.00 - 100%\n"
      . "\tScore 9 : 98.00 - 98.99%\n"
      . "\tScore 8 : 97.00 - 97.99%\n"
      . "\tScore 7 : 96.00 - 96.99%\n"
      . "\tScore 6 : 95.00 - 95.99%\n"
      . "\tScore 5 : 94.00 - 94.99%\n"
      . "\tScore 4 : 93.00 - 93.99%\n"
      . "\tScore 3 : 92.00 - 92.99%\n"
      . "\tScore 2 : 91.00 - 91.99%\n"
      . "\tScore 1 : 90.00 - 90.99%\n"
      . "\tScore 0 : < 90%\n\n"
      . "Note\n"
      . "\tDue to operational conditions and the specific nature of work for MK, PM, QAN, and PD in 2025,\n"
      . "\tthe company reserves the right to \"review or adjust the weighting proportion\" for the Communication topic\n"
      . "\tto align with actual work conditions or to apply alternative criteria for the highest fairness in evaluation.",

'leader' => $loc==='th'
    ? "Leadership\n"
      . "\tการประเมินคะแนนจากหัวหน้างานโดยตรง\n"
      . "\tโดยหัวหน้างานต้องประเมินผ่านระบบ Supavut Assessment\n\n"
      . "\t8 - 10 เสมอ (เป็นแบบอย่างที่ดีเยี่ยม)\n"
      . "\t• 10: สร้างการเปลี่ยนแปลงเชิงบวก สร้างแรงบันดาลใจ และสร้างผู้นำรุ่นใหม่ได้\n"
      . "\t• 9 : คิดเชิงกลยุทธ์ แก้ปัญหาซับซ้อนได้ดีเยี่ยม\n"
      . "\t• 8 : บริหารจัดการทีมได้ดีเยี่ยม งานสำเร็จตามเป้าหมายเสมอ เป็นที่พึ่งพาของน้องๆ ได้\n\n"
      . "\t5 - 7 บ่อยครั้ง (มีประสิทธิภาพตามเกณฑ์)\n"
      . "\t• 7 : รับผิดชอบงานและทีมได้ดี ตัดสินใจถูกต้องในสถานการณ์ปกติ\n"
      . "\t• 6 : บริหารงานได้ตามเป้าหมาย แต่อาจต้องขอคำปรึกษาในเรื่องยากๆ บ้าง\n"
      . "\t• 5 : (ผ่านเกณฑ์ขั้นต่ำ) คุมงาน Routine ได้ แต่ยังขาดความคิดริเริ่มหรือความเด็ดขาดในบางครั้ง\n\n"
      . "\t2 - 4 นานๆ ครั้ง (ต้องปรับปรุง)\n"
      . "\t• 4 : ไม่กล้าตัดสินใจ รอรับคำสั่งเป็นหลัก งานทีมเริ่มสะดุด\n"
      . "\t• 3 : แก้ปัญหาเฉพาะหน้าไม่ได้ ควบคุมอารมณ์ไม่ได้เมื่อเจอความกดดัน\n"
      . "\t• 2 : ปล่อยปละละเลย สับสนทิศทาง ขาดความรับผิดชอบ\n\n"
      . "\t1 แทบไม่เคย (ต้องแก้ไขเร่งด่วน)\n"
      . "\t• สร้างความแตกแยกในทีม, โยนความผิดให้คนอื่น, ทัศนคติเชิงลบอย่างรุนแรง\n\n"
      . "\t0 ไม่มีผลงานเลย\n"
      . "\t• ละทิ้งหน้าที่ ไม่มีการบริหารจัดการใดๆ เลย"
    : "Leadership\n"
      . "\tEvaluated directly by the supervisor via the Supavut Assessment system.\n\n"
      . "\t8 - 10 Always (Excellent role model)\n"
      . "\t• 10: Creates positive change, inspires others, and develops new leaders.\n"
      . "\t• 9 : Thinks strategically and solves complex problems exceptionally well.\n"
      . "\t• 8 : Manages the team excellently; consistently achieves targets and is relied upon by team members.\n\n"
      . "\t5 - 7 Often (Meets performance standards)\n"
      . "\t• 7 : Handles responsibilities for work and team well; makes correct decisions in normal situations.\n"
      . "\t• 6 : Meets targets, but may need advice for difficult issues at times.\n"
      . "\t• 5 : (Minimum pass) Can manage routine work, but sometimes lacks initiative or decisiveness.\n\n"
      . "\t2 - 4 Sometimes (Needs improvement)\n"
      . "\t• 4 : Hesitates to decide; mostly waits for instructions; team workflow starts to stall.\n"
      . "\t• 3 : Cannot handle immediate problems; cannot control emotions under pressure.\n"
      . "\t• 2 : Neglects duties; lacks direction; shows poor responsibility.\n\n"
      . "\t1 Almost never (Urgent improvement required)\n"
      . "\t• Creates conflict, blames others, or shows severely negative attitude.\n\n"
      . "\t0 No performance\n"
      . "\t• Abandons responsibilities; shows no leadership/management at all.",

'attitude' => $loc==='th'
    ? "Attitude / Discipline\n"
      . "\tการประเมินคะแนนจากหัวหน้างานโดยตรง\n"
      . "\tโดยหัวหน้างานต้องประเมินผ่านระบบ Supavut Assessment\n\n"
      . "\t8 - 10 เสมอ (เป็นเจ้าของงาน)\n"
      . "\t• 10: ทำงานเกินความคาดหวังเสมอ หาทางพัฒนางานให้ดีขึ้นโดยไม่ต้องสั่ง งานผิดพลาดเป็นศูนย์\n"
      . "\t• 9 : คาดการณ์ปัญหาล่วงหน้าและป้องกันได้ ส่งงานก่อนกำหนด และคุณภาพดี\n"
      . "\t• 8 : รับผิดชอบงานตัวเองได้สมบูรณ์แบบ 100% ไม่ต้องให้หัวหน้ามาตามงาน\n\n"
      . "\t5 - 7 บ่อยครั้ง (รับผิดชอบตามเกณฑ์)\n"
      . "\t• 7 : ทำงานครบตาม Job Description (JD) ส่งงานตรงเวลา คุณภาพผ่านเกณฑ์มาตรฐาน\n"
      . "\t• 6 : ทำงานเสร็จแต่ต้องมีการติดตามทวงถามบ้าง แก้ปัญหาเฉพาะหน้าได้พอใช้\n"
      . "\t• 5 : (คาบเส้น) ทำงานแค่พอให้เสร็จๆ ไป และไม่กระตือรือร้นที่จะทำงานเพิ่ม\n\n"
      . "\t2 - 4 นานๆ ครั้ง (ขาดความรับผิดชอบ)\n"
      . "\t• 4 : ส่งงานช้ากว่ากำหนดเป็นประจำ งานมีข้อผิดพลาดจุกจิกเพราะความไม่รอบคอบ\n"
      . "\t• 3 : เกี่ยงงาน (Avoid tasks) อ้างว่า \"ทำไม่ได้\" หรือ \"ไม่ใช่หน้าที่\" ทั้งที่อยู่ใน JD\n"
      . "\t• 2 : ละเลยงานสำคัญ จนเกิดความเสียหาย ต้องให้เพื่อนร่วมงานมาช่วยแก้หรือทำแทน\n\n"
      . "\t1 แทบไม่เคย (ไร้ความรับผิดชอบ)\n"
      . "\t• สั่งงานแล้วไม่ทำ ดื้อแพ่ง แข็งข้อ หรือรับปากแล้วทิ้งงานไปเฉยๆ โดยไม่แจ้งให้ทราบ\n\n"
      . "\t0 ไม่มีผลงานเลย/ละทิ้งงาน\n"
      . "\t• ตั้งใจทำให้งานเสียหาย หรือหายตัวไปติดต่อไม่ได้"
    : "Attitude / Discipline\n"
      . "\tEvaluated directly by the supervisor via the Supavut Assessment system.\n\n"
      . "\t8 - 10 Always (Ownership)\n"
      . "\t• 10: Consistently exceeds expectations; improves work without being told; zero errors.\n"
      . "\t• 9 : Anticipates and prevents problems; delivers ahead of schedule with high quality.\n"
      . "\t• 8 : Fully accountable for own work (100%); no need for follow-ups.\n\n"
      . "\t5 - 7 Often (Meets responsibility standards)\n"
      . "\t• 7 : Completes all Job Description (JD) duties; on-time delivery; quality meets standards.\n"
      . "\t• 6 : Work gets done but needs some follow-up; problem-solving is acceptable.\n"
      . "\t• 5 : (Borderline) Does only what is necessary; lacks proactiveness to do more.\n\n"
      . "\t2 - 4 Sometimes (Lacks responsibility)\n"
      . "\t• 4 : Frequently misses deadlines; recurring minor mistakes due to carelessness.\n"
      . "\t• 3 : Avoids tasks; claims \"can't do\" or \"not my duty\" although it is in the JD.\n"
      . "\t• 2 : Neglects critical tasks causing damage; coworkers must fix/do the work instead.\n\n"
      . "\t1 Almost never (No responsibility)\n"
      . "\t• Defiant or ignores assigned work; promises then abandons tasks without informing.\n\n"
      . "\t0 No performance / abandons work\n"
      . "\t• Intentionally damages work or disappears and cannot be contacted.",

'planning' => $loc==='th'
    ? "Planning/Proactivity\n"
      . "\tการประเมินคะแนนจากการเข้าร่วมกิจกรรม Kaizen/ไตรมาส\n\n"
      . "\tคะแนน 10 : ได้รับรางวัลชนะเลิศ\n"
      . "\tคะแนน 9  : ได้รับรางวัลรองชนะเลิศอันดับ 1\n"
      . "\tคะแนน 8  : ได้รับรางวัลรองชนะเลิศอันดับ 2\n"
      . "\tคะแนน 7  : ได้รับรางวัลชมเชย\n"
      . "\tคะแนน 6  : ผ่านเข้ารอบนำเสนอผลงาน\n"
      . "\tคะแนน 4  : หน่วยงานที่ส่งเข้าร่วมตามกำหนดเวลา\n"
      . "\tคะแนน 1  : หน่วยงานที่ส่งเข้าร่วมแต่ส่งล่าช้า\n"
      . "\tคะแนน 0  : หน่วยงานที่ไม่ส่งเข้าร่วม\n\n"
      . "หมายเหตุ\n"
      . "\tกิจกรรม Kaizen คำนวณจากกิจกรรม Kaizen แต่ละไตรมาส เพื่อนำมาหาคะแนนเฉลี่ยต่อปี"
    : "Planning/Proactivity\n"
      . "\tEvaluation is based on Kaizen participation per quarter.\n\n"
      . "\tScore 10: Winner\n"
      . "\tScore 9 : 1st runner-up\n"
      . "\tScore 8 : 2nd runner-up\n"
      . "\tScore 7 : Honorable mention\n"
      . "\tScore 6 : Qualified to present\n"
      . "\tScore 4 : Submitted on time\n"
      . "\tScore 1 : Submitted late\n"
      . "\tScore 0 : No submission\n\n"
      . "Note\n"
      . "\tKaizen is calculated per quarter and then averaged to obtain the annual score.",

'dept_okr' => $loc==='th'
    ? "Department level OKR score\n"
      . "\tเงื่อนไขการให้คะแนนเป็นไปตามข้อกำหนดและเงื่อนไขของแผนก QMS (คะแนนเต็ม 10 คะแนน)\n"
      . "\tโดยมีรายละเอียดตามตารางด้านล่าง\n\n"
      . "\tCriteria of Total Score\n"
      . "\t≥ 110                     10 คะแนน\n"
      . "\t≥ 100 และ < 110            9 คะแนน\n"
      . "\t≥ 90  และ < 100            8 คะแนน\n"
      . "\t≥ 80  และ < 90             7 คะแนน\n"
      . "\t≥ 70  และ < 80             6 คะแนน\n"
      . "\t< 70                       5 คะแนน\n\n"
      . "หมายเหตุ: คะแนนที่แสดงผล คือคะแนนที่คำนวณกับสัดส่วน (Weight) แล้ว"
    : "Department level OKR score\n"
      . "\tScoring criteria follow the QMS department requirements (maximum 10 points)\n"
      . "\tDetails are shown in the table below\n\n"
      . "\tCriteria of Total Score\n"
      . "\t≥ 110                     10 points\n"
      . "\t≥ 100 and < 110            9 points\n"
      . "\t≥ 90  and < 100            8 points\n"
      . "\t≥ 80  and < 90             7 points\n"
      . "\t≥ 70  and < 80             6 points\n"
      . "\t< 70                       5 points\n\n"
      . "Note: The score displayed is the weighted score after applying the proportion (Weight).",


'company_okr' => $loc==='th'
    ? "Company level OKR score\n"
      . "\tคะแนนของ Department level OKR score ทั้งหมด (คะแนนเต็ม 10 คะแนน)\n"
      . "\tโดยมีรายละเอียดตามตารางด้านล่าง\n\n"
      . "\tCriteria of Total Score\n"
      . "\t≥ 110                     10 คะแนน\n"
      . "\t≥ 100 และ < 110            9 คะแนน\n"
      . "\t≥ 90  และ < 100            8 คะแนน\n"
      . "\t≥ 80  และ < 90             7 คะแนน\n"
      . "\t≥ 70  และ < 80             6 คะแนน\n"
      . "\t< 70                       5 คะแนน\n\n"
      . "\tหมายเหตุ: คะแนนที่แสดงผล คือคะแนนที่คำนวณกับสัดส่วน (Weight) แล้ว"
    : "Company level OKR score\n"
      . "\tAverage of all Department-level OKR scores (maximum 10 points).\n"
      . "\tDetails are shown in the table below.\n\n"
      . "\tCriteria of Total Score\n"
      . "\t≥ 110                     10 points\n"
      . "\t≥ 100 and < 110            9 points\n"
      . "\t≥ 90  and < 100            8 points\n"
      . "\t≥ 80  and < 90             7 points\n"
      . "\t≥ 70  and < 80             6 points\n"
      . "\t< 70                       5 points\n\n"
      . "\tNote: The score displayed is the weighted score after applying the proportion (Weight).",

'okr_reporting' => $loc==='th'
    ? "OKR - Reporting score\n"
      . "\tคะแนนเฉลี่ยของ OKR - Reporting score ทุกเดือน (คะแนนเต็ม 10 คะแนน)\n"
      . "\tโดยมีรายละเอียดตามตารางด้านล่าง\n\n"
      . "\tCriteria of Total Score\n"
      . "\t≥ 110                     10 คะแนน\n"
      . "\t≥ 100 และ < 110            9 คะแนน\n"
      . "\t≥ 90  และ < 100            8 คะแนน\n"
      . "\t≥ 80  และ < 90             7 คะแนน\n"
      . "\t≥ 70  และ < 80             6 คะแนน\n"
      . "\t< 70                       5 คะแนน\n\n"
      . "\tหมายเหตุ: คะแนนที่แสดงผล คือคะแนนที่คำนวณกับสัดส่วน (Weight) แล้ว"
    : "OKR - Reporting score\n"
      . "\tAverage of monthly OKR - Reporting scores (maximum 10 points).\n"
      . "\tDetails are shown in the table below.\n\n"
      . "\tCriteria of Total Score\n"
      . "\t≥ 110                     10 points\n"
      . "\t≥ 100 and < 110            9 points\n"
      . "\t≥ 90  and < 100            8 points\n"
      . "\t≥ 80  and < 90             7 points\n"
      . "\t≥ 70  and < 80             6 points\n"
      . "\t< 70                       5 points\n\n"
      . "\tNote: The score displayed is the weighted score after applying the proportion (Weight).",

'system' => $loc==='th'
    ? "System (SMBR)\n"
      . "\t5 = ดีเยี่ยม\n"
      . "\t4 = ดี\n"
      . "\t3 = ปานกลาง\n"
      . "\t2 = พอใช้\n"
      . "\t≤ 1 = ปรับปรุง\n\n"
      . "หมายเหตุ: คะแนนที่แสดงผล คือคะแนนที่คำนวณกับสัดส่วน (Weight) แล้ว"
    : "System (SMBR)\n"
      . "\t5 = Excellent\n"
      . "\t4 = Good\n"
      . "\t3 = Fair\n"
      . "\t2 = Acceptable\n"
      . "\t≤ 1 = Needs improvement\n\n"
      . "Note: The score displayed is the weighted score after applying the proportion (Weight).",

'bonus' => $loc==='th'
    ? "Bonus Score\n\n"
      . "เพิ่มคะแนน\n"
      . "\t1) คะแนนรายบุคคล/รายแผนกจากการแข่งขันภายนอกหรือสร้างชื่อเสียงให้บริษัทฯ (+5 คะแนน)\n"
      . "\t\tหลักฐานที่ต้องแนบ:\n"
      . "\t\t- ใบประกาศนียบัตร\n"
      . "\t\t- โล่รางวัล\n"
      . "\t\t- รูปถ่ายกิจกรรม\n"
      . "\t\t- หนังสือเชิญ\n"
      . "\t\t- หรือลิงก์ข่าวประชาสัมพันธ์\n"
      . "\t2) คะแนนการเข้าร่วม 100% จากการร่วมเป็นคณะกรรมการอย่างใดอย่างหนึ่งของบริษัทฯ (+5 คะแนน)\n"
      . "\tตัวอย่าง: คปอ, การจัดการพลังงาน, สวัสดิการ, คณะทำงาน 5ส\n"
      . "\t3) คะแนนจากการเข้าร่วม 100% ในการเป็นผู้ตรวจประเมินภายในตามระบบมาตรฐานของบริษัทฯ (+5 คะแนน)\n"
      . "\tตัวอย่างมาตรฐาน: มรท.8001:2563, IATF16949:2016 & ISO9001:2015, ISO14001:2015\n"
      . "\t4) รางวัล Zero PPM Award 2025 เพิ่มคะแนนให้กับหน่วยงานที่เกี่ยวข้อง (+2 คะแนน)\n"
      . "\t5) รางวัล Paint Facility Certification Notice เพิ่มคะแนนให้กับหน่วยงานที่เกี่ยวข้อง (+1 คะแนน)\n"
      . "\t6) รางวัล Model of Thailand 5S Award 2025 เพิ่มคะแนนให้กับหน่วยงานที่เกี่ยวข้อง (+1 คะแนน)\n"
      . "\t7) รางวัล Top Supplier Award เพิ่มคะแนนให้กับหน่วยงานที่เกี่ยวข้อง (+2 คะแนน)\n\n"
      . "ตัดคะแนน\n"
      . "\t1) ตัดคะแนนแผนกที่เกี่ยวข้องจากการทำให้เกิดงาน Claim (อ้างอิงตามเกณฑ์ของแผนก QC และ QA)\n"
      . "\t2) ตัดคะแนนแผนกที่เกี่ยวข้องกรณีได้รับ CAR จากลูกค้า หรือหน่วยงานตรวจรับรอง\n"
      . "\tและไม่สามารถดำเนินการปิดแก้ไขได้ภายในระยะเวลาที่กำหนด (อ้างอิงตามเกณฑ์ของแผนก QMS)\n"
      . "\t3) ตัดคะแนนรายบุคคล/รายแผนก จากการไม่ปฏิบัติตามข้อระเบียบบังคับด้านความปลอดภัย\n"
      . "\tอาชีวอนามัย และสิ่งแวดล้อม (อ้างอิงตามเกณฑ์ของแผนก SHE)\n\n"
      . "หมายเหตุ:\n"
      . "\tคะแนน Bonus Score จะถูกนำไปบวก/ลบกับคะแนนการประเมินรวม\n"
      . "\tสูงสุด +5 คะแนน และต่ำสุด -5 คะแนน"
    : "Bonus Score\n\n"
      . "Add points\n"
      . "\t1) Individual/department points from external competitions or enhancing the company’s reputation (+5 points)\n"
      . "\t\tRequired evidence:\n"
      . "\t\t- Certificate\n"
      . "\t\t- Trophy/Plaque\n"
      . "\t\t- Activity photos\n"
      . "\t\t- Invitation letter\n"
      . "\t\t- Or a PR/news link\n"
      . "\t2) 100% participation points for serving as a company committee member (+5 points)\n"
      . "\tExamples: Safety Committee, Energy Management, Welfare, 5S Working Team\n"
      . "\t3) 100% participation points for serving as an internal auditor under the company’s standard systems (+5 points)\n"
      . "\tExamples of standards: TIS 8001:2563, IATF16949:2016 & ISO9001:2015, ISO14001:2015\n"
      . "\t4) Zero PPM Award 2025: add points to the related department (+2 points)\n"
      . "\t5) Paint Facility Certification Notice: add points to the related department (+1 points)\n"
      . "\t6) Model of Thailand 5S Award 2025: Add points to the relevant department(s) only (+1 point)\n"
      . "\t7) Top Supplier Award: add points to the related department (+2 points)\n\n"
      . "Deduct points\n"
      . "\t1) Deduct points from the related department for generating claim jobs (based on QC and QA criteria)\n"
      . "\t2) Deduct points from the related department if a CAR is issued by a customer or a certification/audit body\n"
      . "\tand corrective actions cannot be closed within the specified timeframe (based on QMS criteria)\n"
      . "\t3) Deduct points from an individual/department for non-compliance with mandatory safety,\n"
      . "\toccupational health, and environmental regulations (based on SHE criteria)\n\n"
      . "Note:\n"
      . "\tThe Bonus Score will be added to (or deducted from) the overall assessment score.\n"
      . "\tMaximum +5 points and minimum -5 points",



        'total' => $loc==='th'
    ? "ระดับผลการประเมิน\n"
      . "\tบริษัทกำหนดระดับผลการประเมินไว้ 5 ระดับ เพื่อสะท้อนถึงผลสัมฤทธิ์ของงาน และพฤติกรรม ดังนี้\n"
      . "\tผลระดับคะแนน\n"
      . "\t1) ระดับดีเยี่ยม (Outstanding): ผลงานโดดเด่นเหนือความคาดหมายอย่างชัดเจน\n"
      . "\t2) ระดับดี (Exceed): ผลงานสูงกว่ามาตรฐานที่กำหนด\n"
      . "\t3) ระดับปานกลาง (Meet Expectation): ผลงานเป็นไปตามมาตรฐานและความรับผิดชอบ\n"
      . "\t4) ระดับพอใช้ (Below Expectation): ผลงานต่ำกว่ามาตรฐานในบางส่วน\n"
      . "\t5) ระดับต้องปรับปรุง (Needs Improvement): ผลงานต่ำกว่ามาตรฐาน และต้องได้รับการพัฒนาเร่งด่วน\n\n"
      . "เงื่อนไขการปรับระดับผลการประเมินจากมาตรการทางวินัย\n"
      . "\tเพื่อให้สอดคล้องกับนโยบายการกำกับดูแลกิจการที่ดี และส่งเสริมให้พนักงานรักษาไว้ซึ่งระเบียบวินัย\n"
      . "\tบริษัทฯ จึงกำหนดเงื่อนไขประวัติการลงโทษทางวินัย มาประกอบการพิจารณาปรับระดับผลการประเมินสุดท้ายดังนี้\n"
      . "\tประเภทบทลงโทษทางวินัย\n"
      . "\t1) ตักเตือนด้วยวาจา: ไม่มีการปรับลดระดับ (พิจารณาผลตามคะแนนจริง)\n"
      . "\t2) ตักเตือนเป็นลายลักษณ์อักษร: ปรับลดลง 1 ระดับ (จากผลประเมินที่คำนวณได้)\n"
      . "\t3) พักงาน: ปรับลดลง 2 ระดับ (จากผลประเมินที่คำนวณได้)\n\n"
      . "หมายเหตุ"
      . "\tหากการปรับลดระดับส่งผลให้เกรดต่ำกว่าระดับ \"ต้องปรับปรุง (Needs Improvement)\"\n"
      . "\tให้ถือว่าสิ้นสุดที่ระดับ \"ต้องปรับปรุง (Needs Improvement)\"\n\n"
      . "หลักการและเหตุผล\n"
      . "\tการประเมินผลปฏิบัติงานของบริษัทฯ มุ่งเน้นทั้ง \"ผลสำเร็จของงาน\" และ \"การปฏิบัติตนตามกฎระเบียบ\" ควบคู่กัน\n"
      . "\tพนักงานที่ได้รับการพิจารณาโทษทางวินัย ย่อมส่งผลต่อคุณสมบัติความเหมาะสมในการได้รับการพิจารณาผลตอบแทน\n"
      . "\tพิเศษประจำปีเพื่อความเป็นธรรมต่อพนักงานส่วนใหญ่ที่ปฏิบัติตามกฎระเบียบอย่างเคร่งครัดทั้งนี้ให้มีผลบังคับใช้สำหรับ\n"
      . "\tการประเมินผลการปฏิบัติงานประจำปี 2568 เป็นต้นไป"
    : "Performance rating levels\n"
      . "\tThe company defines 5 performance rating levels to reflect both work achievement and behavior as follows:\n"
      . "\tRating levels\n"
      . "\t1) Outstanding: Performance clearly exceeds expectations.\n"
      . "\t2) Exceed: Performance is above the defined standard.\n"
      . "\t3) Meet Expectation: Performance meets the standard and responsibilities.\n"
      . "\t4) Below Expectation: Performance is below the standard in some areas.\n"
      . "\t5) Needs Improvement: Performance is below the standard and requires urgent improvement.\n\n"
      . "Disciplinary adjustment conditions\n"
      . "\tTo align with good corporate governance and to encourage employees to maintain discipline,\n"
      . "\tthe company sets the following disciplinary-record conditions to adjust the final performance rating:\n\n"
      . "\tType of disciplinary action\n"
      . "\t1) Verbal warning: No rating reduction (based on the actual calculated result).\n"
      . "\t2) Written warning: Reduce by 1 level (from the calculated rating).\n"
      . "\t3) Suspension: Reduce by 2 levels (from the calculated rating).\n\n"
      . "Note"
      . "\tIf the reduction causes the rating to fall below \"Needs Improvement\",\n"
      . "\tthe final rating will remain at \"Needs Improvement\".\n\n"
      . "Principle and rationale\n"
      . "\tThe company’s performance evaluation emphasizes both \"work results\" and \"compliance with rules\" together.\n"
      . "\tEmployees who receive disciplinary actions may affect their eligibility for the annual special compensation consideration.\n"
      . "\tThis is to ensure fairness for the majority of employees who strictly comply with company rules.\n"
      . "\tThis policy is effective starting from the 2025 annual performance evaluation onward.",



            ];

    $calcMap = [
    'attendance' => ($loc==='th'
        ? "Attendance\n"
          . "\tวิธีการคำนวณคะแนน : % Attendance ที่ได้ × เกณฑ์คะแนน Attendance ÷ 100"
        : "Attendance\n"
          . "\tCalculation: % Attendance achieved × Attendance criteria ÷ 100"
    ),

    'ip' => ($loc==='th'
        ? "Individual Performance score\n"
          . "\tนำผลรวมคะแนน Teamwork, Communication, Leadership, Attitude/Discipline,\n"
          . "\tPlanning/Proactivity (Kaizen)\n"
          . "\tมาคำนวณเป็นคะแนน Total Individual Performance Score"
        : "Individual Performance score\n"
          . "\tSum the scores of Teamwork, Communication, Leadership, Attitude/Discipline,\n"
          . "\tPlanning/Proactivity (Kaizen)\n"
          . "\tto calculate the Total Individual Performance Score."
    ),

    'dept_okr' => ($loc==='th'
        ? "Department level OKR score\n"
          . "\tนำผลรวมหรือผลเฉลี่ยของแต่ละหัวข้อมาคำนวณ %\n"
          . "\tเพื่อเทียบ Criteria และลง Score ตาม Criteria"
        : "Department level OKR score\n"
          . "\tUse the total/average of each item to calculate the %,\n"
          . "\tthen compare with the criteria and assign the score accordingly."
    ),

    'company_okr' => ($loc==='th'
        ? "Company level OKR score\n"
          . "\tค่าเฉลี่ยของ Department level OKR score ทั้งหมด"
        : "Company level OKR score\n"
          . "\tAverage of all Department level OKR scores."
    ),

    'okr_reporting' => ($loc==='th'
        ? "OKR - Reporting score\n"
          . "\tOKR - Reporting score = Ontime Submission\n"
          . "\t+ Ontime evidence submission\n"
          . "\t+ Accuracy\n"
          . "\t(3 หัวข้อการประเมิน)"
        : "OKR - Reporting score\n"
          . "\tOKR - Reporting score = Ontime Submission\n"
          . "\t+ Ontime evidence submission\n"
          . "\t+ Accuracy\n"
          . "\t(3 evaluation items)"
    ),

    'system' => ($loc==='th'
        ? "System (SMBR)\n"
          . "\tจำนวนคะแนนสุทธิ × คะแนนเกณฑ์การประเมินตาม Level (10, 20) 5 (คะแนนเต็ม)\n"
        : "System (SMBR)\n"
          . "\tNet points × Level criteria score (10, 20) 5 (full score)\n"
    ),

    'bonus' => ($loc==='th'
        ? "Bonus score\n"
          . "\tนำคะแนนที่ได้จากการประเมิน Bonus Score ไปบวกเข้ากับคะแนนการประเมินรวม"
        : "Bonus score\n"
          . "\tThe Bonus Score is added to the total evaluation score."
    ),


'total' => ($loc==='th'
    ? "สรุปคะแนนรวมทั้งหมด\n"
      . "\tคือผลรวมคะแนนของผลลัพธ์ทุกหัวข้อ"
    : "Total score summary\n"
      . "\tThis is the sum of the results from all categories."
),


];


    $fmt1 = function($v){
        if ($v === null || $v === '') return '-';
        $n = (float)$v;
        return rtrim(rtrim(number_format($n,1,'.',''),'0'),'.');
    };

    $cycleIdForJs = $cycleIdForJs ?? ($cycleId ?? ($activeCycleId ?? ($cycle->id ?? null)));

    $ipUiHas = is_numeric($ipWeightedInit);
    $hasLeaderScore = is_numeric($leaderScore);
    $hasAttitudeScore = is_numeric($attitudeScore);
    $laReadyServer = ($hasLeaderScore && $hasAttitudeScore);
@endphp

<div class="wrap">
    @php
        $flashSuccess = session('success');
        $flashSuccessText = '';
        if (is_string($flashSuccess) && trim($flashSuccess) !== '') {
            $flashSuccessText = __($flashSuccess);
        }
    @endphp
    @if($flashSuccessText !== '')
        <div class="flash-box flash-success">{{ $flashSuccessText }}</div>
    @endif
    @if(session('warning'))
        <div class="flash-box flash-warning">{{ session('warning') }}</div>
    @endif
    @if(session('error'))
        <div class="flash-box flash-warning">{{ session('error') }}</div>
    @endif

    <div id="js-flash" class="flash-box flash-info" style="display:none;"></div>

    <div class="top-bar">
        <div class="top-bar-left">
            <div class="top-title">{{ __('app.assess_eval_header_title') }}</div>
            <div class="muted" style="margin-top:2px;">{{ $roleLabel }}</div>
        </div>

        <div class="top-bar-right top-actions">
            <div class="lang-switch" aria-label="Language">
                <form id="localeForm" method="POST" action="{{ Route::has('locale.switch') ? route('locale.switch') : url('/locale') }}" class="lang-form">
                    @csrf
                    <input type="hidden" name="locale" id="localeInput" value="{{ $loc }}">
                    <button type="button" class="lang-btn-square" data-locale="th" data-active="{{ $loc==='th' ? 'true' : 'false' }}">TH</button>
                    <button type="button" class="lang-btn-square" data-locale="en" data-active="{{ $loc==='en' ? 'true' : 'false' }}">EN</button>
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

    <div class="emp-row">
        <div class="avatar" onclick="openAvatarModal()" title="{{ __('app.assess_avatar_tooltip') }}">
            <img src="{{ $avatarUrl }}" alt="avatar">
        </div>
        <div class="emp-main">
            <div class="emp-name">
                {{ $loc === 'en'
                    ? (trim((string)($employee->full_name_en ?? '')) !== '' ? $employee->full_name_en : ($employee->full_name_th ?? $employee->employee_code))
                    : (trim((string)($employee->full_name_th ?? '')) !== '' ? $employee->full_name_th : ($employee->full_name_en ?? $employee->employee_code))
                }}
            </div>
            <div class="emp-meta">
                {{ __('app.assess_emp_meta', [
                    'code' => $employee->employee_code ?? '-',
                    'position' => $employee->position ?? '-',
                    'dept' => $employee->dept_abbr_qms ?? $employee->dept_abbr_hr ?? '-',
                ]) }}
            </div>

            <div class="muted" id="eval-badge" style="margin-top:4px; {{ $alreadyEvaluated ? '' : 'display:none;' }}">★ {{ $loc==='th' ? 'ประเมินแล้ว' : 'Evaluated' }}</div>
        </div>
    </div>

    <h2 style="margin-top:16px;">
        {{ __('app.assess_weight_title') }}
    </h2>
    <div class="score-box summary">
        @if(!empty($summaryLines))
            <div class="summary-grid">
                @foreach($summaryLines as $line)
                    <div class="summary-chip">
                        <span class="summary-chip-label">{{ $line['label'] }}</span>
                        <span class="summary-chip-value">{{ $line['value'] }}%</span>
                    </div>
                @endforeach
            </div>
            <div class="summary-total-line">
                @if($loc === 'th')
                    {{ __('app.assess_weight_total_line_th', ['points' => number_format($maxWithBonus,0)]) }}
                @else
                    {{ __('app.assess_weight_total_line', ['points' => number_format($maxWithBonus,0)]) }}
                @endif
            </div>
        @else
            <div style="font-weight:700">{{ __('app.assess_weight_not_defined') }}</div>
        @endif
    </div>

    <h1>
        {{ __('app.assess_att_title') }}
        <button type="button" class="btn-formula" onclick="openCalcModal('attendance')">
            {{ $loc==='th' ? 'สูตร' : 'Formula' }}
        </button>

        <button type="button"
            class="btn-crit"
            title="{{ $loc==='th' ? 'ดูคำอธิบาย Attendance' : 'View Attendance note' }}"
            onclick="openCriteriaModal('attendance')">&#9432;</button>
    </h1>

    <div class="score-box">
        <div class="score-main" id="att-main">{{ number_format($attendancePoints,2) }} / {{ $weightAttendance }}</div>
        <div class="score-box-footer">
            <button type="button" class="btn" onclick="openAttModal()">
                {{ __('app.assess_btn_view_detail') }}
            </button>
        </div>
    </div>

    <h2 id="ip-title">
        {{ __('app.assess_ip_title') }}
        <button type="button" class="btn-formula" onclick="openCalcModal('ip')">
            {{ $loc==='th' ? 'สูตร' : 'Formula' }}
        </button>

          <button type="button"
            class="btn-crit"
            title="{{ $loc==='th' ? 'ดูคำอธิบาย Individual Performance' : 'View Individual Performance note' }}"
            onclick="openCriteriaModal('ip')">&#9432;</button>
    </h2>

    <div class="score-box {{ (!$laReadyServer) ? 'ip-alert' : ($ipUiHas ? 'ip-ok' : 'ip-alert') }}" id="ip-summary-box">
        <div class="score-main" id="ip-summary-main">
            {{ $ipUiHas ? number_format((float)$ipWeightedInit,2) : '-' }} / {{ $weightIndividual }}
        </div>

        <div class="ip-minimal-warning" id="ip-minimal-warning" style="{{ ($laReadyServer && $ipUiHas) ? 'display:none;' : '' }}">
            @if(!$laReadyServer)
                {{ $loc==='th'
                    ? 'ยังไม่มีคะแนน Leadership / Attitude → ให้เลือก (หรือเลือก N/A) แล้วกด “คำนวณ” ในรายละเอียด Individual Performance'
                    : 'Missing Leadership / Attitude → pick (or choose N/A), then press “Calculate” in Individual Performance details.'
                }}
            @else
                {{ $loc==='th'
                    ? 'กด “คำนวณ” ในรายละเอียด Individual Performance เพื่อดูผลลัพธ์'
                    : 'Press “Calculate” in Individual Performance details to see the result.'
                }}
            @endif
        </div>

        <div class="score-box-footer" style="gap:10px;flex-wrap:wrap;">
            <button type="button" class="btn" onclick="openIpModal()">
                {{ __('app.assess_btn_view_detail') }}
            </button>
        </div>
    </div>

    @if($weightDeptOkr > 0)
        <h2>
            {{ __('app.assess_okr_dept_title') }}
            <button type="button" class="btn-formula" onclick="openCalcModal('dept_okr')">{{ $loc==='th' ? 'สูตร' : 'Formula' }}</button>
            <button type="button" class="btn-crit" onclick="openCriteriaModal('dept_okr')">&#9432;</button>
        </h2>
        <div class="score-box">
            <div class="score-main" id="deptokr-main">{{ number_format($deptOkrWeighted,2) }} / {{ $weightDeptOkr }}</div>
        </div>
    @endif

    @if($weightCompanyOkr > 0)
        <h2>
            {{ __('app.assess_okr_company_title') }}
            <button type="button" class="btn-formula" onclick="openCalcModal('company_okr')">{{ $loc==='th' ? 'สูตร' : 'Formula' }}</button>
            <button type="button" class="btn-crit" onclick="openCriteriaModal('company_okr')">&#9432;</button>
        </h2>
        <div class="score-box">
            <div class="score-main" id="companyokr-main">{{ number_format($companyOkrWeighted,2) }} / {{ $weightCompanyOkr }}</div>
        </div>
    @endif

    @if($weightOkrReporting > 0)
        <h2>
            {{ __('app.assess_okr_reporting_title') }}
            <button type="button" class="btn-formula" onclick="openCalcModal('okr_reporting')">{{ $loc==='th' ? 'สูตร' : 'Formula' }}</button>
            <button type="button" class="btn-crit" onclick="openCriteriaModal('okr_reporting')">&#9432;</button>
        </h2>
        <div class="score-box">
            <div class="score-main" id="okrreport-main">{{ number_format($okrReportWeighted,2) }} / {{ $weightOkrReporting }}</div>
        </div>
    @endif

    @if($weightSystem > 0)
        <h2>
            {{ __('app.assess_system_title') }}
            <button type="button" class="btn-formula" onclick="openCalcModal('system')">{{ $loc==='th' ? 'สูตร' : 'Formula' }}</button>
            <button type="button" class="btn-crit" onclick="openCriteriaModal('system')">&#9432;</button>
        </h2>
        <div class="score-box">
            <div class="score-main" id="system-main">{{ number_format($systemWeighted,2) }} / {{ $weightSystem }}</div>
        </div>
    @endif

    <h2>
        {{ __('app.assess_bonus_title') }}
        <button type="button" class="btn-formula" onclick="openCalcModal('bonus')">{{ $loc==='th' ? 'สูตร' : 'Formula' }}</button>
        <button type="button" class="btn-crit" onclick="openCriteriaModal('bonus')">&#9432;</button>
    </h2>
    <div class="score-box bonus">
        <div class="score-main" id="bonus-main">{{ number_format($bonusScore,2) }} / {{ $weightBonus }}</div>
    </div>

    <h2>
        {{ __('app.assess_total_title') }}
        <button type="button" class="btn-formula" onclick="openCalcModal('total')">{{ $loc==='th' ? 'สูตร' : 'Formula' }}</button>

        <button type="button"
            class="btn-crit"
            title="{{ $loc==='th' ? 'ดูคำอธิบายคะแนนรวม' : 'View total score note' }}"
            onclick="openCriteriaModal('total')">&#9432;</button>
    </h2>
    <div class="score-box total">
        <div class="score-main" id="total-score-main">
            {{ number_format($totalWithBonus,2) }} / {{ number_format($maxWithBonus,2) }}
        </div>
    </div>

    <div class="row-bottom">
        <a href="{{ $backUrl }}" class="btn-back">
            {{ __('app.assess_btn_back_to_list') }}
        </a>

        <form method="POST" action="{{ $saveUrl }}" id="save-total-form">
            @csrf
            <input type="hidden" name="viewer_role" value="{{ $viewerRole }}">
            <input type="hidden" id="score_leadership" name="{{ $laLeadName }}" value="{{ $leaderScore !== null ? number_format($leaderScore,1,'.','') : '' }}">
            <input type="hidden" id="score_attitude" name="{{ $laAttName }}" value="{{ $attitudeScore !== null ? number_format($attitudeScore,1,'.','') : '' }}">

            @if($showUserActionButtons)
                <button type="button" class="btn btn-save" onclick="openConfirmSaveModal()">
                    {{ $loc==='th' ? 'บันทึกคะแนน' : 'Save score' }}
                </button>
            @endif
        </form>
    </div>
</div>

<div id="att-modal" class="modal-overlay" onclick="overlayClick(event,'att-modal')">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title">{{ __('app.assess_att_modal_title') }}</div>
            <button type="button" class="modal-close" onclick="closeAttModal()">×</button>
        </div>

        <div class="modal-sub">{{ __('app.assess_att_modal_intro') }}</div>

        <table>
            <thead>
            <tr>
                <th>{{ __('app.assess_att_col_type') }}</th>
                <th style="text-align:center;">{{ __('app.assess_att_col_count') }}</th>
                <th style="text-align:center;">{{ __('app.assess_att_col_each') }}</th>
                <th style="text-align:right;">{{ __('app.assess_att_col_total') }}</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>{{ __('app.assess_att_row_absent') }}</td>
                <td style="text-align:center;">{{ rtrim(rtrim(number_format((float)($calc['absent'] ?? 0),2,'.',''),'0'),'.') }}</td>
                <td style="text-align:center;">-3</td>
                <td>-{{ number_format($deduct_absent,2) }}</td>
            </tr>
            <tr>
                <td>{{ __('app.assess_att_row_sick') }}</td>
                <td style="text-align:center;">{{ rtrim(rtrim(number_format((float)($calc['sick'] ?? 0),2,'.',''),'0'),'.') }}</td>
                <td style="text-align:center;">-1</td>
                <td>-{{ number_format($deduct_sick,2) }}</td>
            </tr>
            <tr>
                <td>{{ __('app.assess_att_row_personal') }}</td>
                <td style="text-align:center;">{{ rtrim(rtrim(number_format((float)($calc['personal'] ?? 0),2,'.',''),'0'),'.') }}</td>
                <td style="text-align:center;">-1</td>
                <td>-{{ number_format($deduct_personal,2) }}</td>
            </tr>
            <tr>
                <td>{{ __('app.assess_att_row_late') }}</td>
                <td style="text-align:center;">{{ rtrim(rtrim(number_format((float)($calc['late'] ?? 0),2,'.',''),'0'),'.') }}</td>
                <td style="text-align:center;">-0.25</td>
                <td>-{{ number_format($deduct_late,2) }}</td>
            </tr>
            <tr>
                <td>{{ __('app.assess_att_row_maternity') }}</td>
                <td style="text-align:center;">{{ rtrim(rtrim(number_format((float)($calc['maternity'] ?? 0),2,'.',''),'0'),'.') }}</td>
                <td style="text-align:center;">-</td>
                <td>-</td>
            </tr>
            <tr>
                <td>{{ __('app.assess_att_row_ordain') }}</td>
                <td style="text-align:center;">{{ rtrim(rtrim(number_format((float)($calc['ordain'] ?? 0),2,'.',''),'0'),'.') }}</td>
                <td style="text-align:center;">-</td>
                <td>-</td>
            </tr>
            <tr>
                <td>{{ __('app.assess_att_row_warning') }}</td>
                <td style="text-align:center;">{{ rtrim(rtrim(number_format((float)($calc['warning'] ?? 0),2,'.',''),'0'),'.') }}</td>
                <td style="text-align:center;">-</td>
                <td>-</td>
            </tr>
            <tr>
                <td>{{ __('app.assess_att_row_suspension') }}</td>
                <td style="text-align:center;">{{ rtrim(rtrim(number_format((float)($calc['suspension'] ?? 0),2,'.',''),'0'),'.') }}</td>
                <td style="text-align:center;">-</td>
                <td>-</td>
            </tr>
            </tbody>

            <tfoot>
            <tr>
                <th colspan="3">{{ __('app.assess_att_footer_deduct') }}</th>
                <th>-{{ number_format($totalDeduct,2) }}</th>
            </tr>
            <tr>
                <th colspan="3">{{ __('app.assess_att_footer_remaining') }}</th>
                <th>
                    {{ number_format($raw,2) }} / {{ number_format($base,2) }}
                    <span class="badge-raw">{{ number_format($rawPercent,2) }}%</span>
                </th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<div id="ip-modal" class="modal-overlay" onclick="overlayClick(event,'ip-modal')">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title">{{ __('app.assess_ip_modal_title') }}</div>
            <button type="button" class="modal-close" onclick="closeIpModal()">×</button>
        </div>

        <div class="score-box sticky-ip-box" id="ip-modal-box" style="margin-bottom:10px;">
    <div class="score-main" id="ip-modal-main">- / {{ $weightIndividual }}</div>
    <div class="ip-minimal-warning" id="ip-modal-minimal-warning" style="margin-top:6px;"></div>
</div>

<!-- NEW: Help / Explanation card -->
<div class="score-box" id="ip-help-card" style="margin-bottom:10px;">
    <div class="ip-help" style="margin:0;">
        <i class="bi bi-info-circle"></i>
        <div>
            <div>• <b>N/A</b> = {{ $loc==='th' ? 'ไม่นำคะแนนมาคำนวณ' : 'Excluded from calculation' }}</div>

            <div>
                • {{ $loc==='th'
    ? 'กรุณากด "คำนวณ" ก่อน แล้วกด “บันทึก” เพื่อบันทึกคะแนน'
    : 'Please click “Calculate” first, then click “Save” to save the score.'
}}

            </div>
        </div>
    </div>
</div>

        <table class="perf-table">
            <thead>
            <tr>
                <th style="text-align:left;">{{ __('app.assess_table_topic') }}</th>
                <th>{{ __('app.assess_table_criteria') }}</th>
                <th>{{ __('app.assess_table_score') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ipItemsModal as $topic)
                @php
                    $s = $topic['score'] ?? null;
                    $key = $topic['id'] ?? '';
                    $isLA = in_array($key, ['leader','attitude'], true);

                    if ($isLA) {
                        if ($s !== null) $displayScore = rtrim(rtrim(number_format((float)$s,1,'.',''),'0'),'.');
                        else $displayScore = '-';
                    } else {
                        $displayScore = ($s !== null) ? rtrim(rtrim(number_format((float)$s,1,'.',''),'0'),'.') : $naText;
                    }
                @endphp
                <tr>
                    <td style="text-align:left;">{{ $topic['label'] ?? $key }}</td>
                    <td><button type="button" class="btn-crit" onclick="openCriteriaModal('{{ $key }}')">&#9432;</button></td>
                    <td>
                        <span class="ip-cell-text" id="cell-{{ $key }}">{{ $displayScore }}</span>
                        @if($isLA && $s === null)
                            <button type="button" class="btn-fill" onclick="focusIpGroup('{{ $key==='leader' ? 'leadership' : 'attitude' }}')">
                                {{ $loc==='th' ? 'เติม' : 'Fill' }}
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="rating-group" id="group-leadership">
            <div class="rating-header">
                <div class="rating-title">{{ __('app.assess_ip_leadership_label') }}</div>
                <div class="rating-current">
                    <span id="score_leadership_display">{{ $leaderScore !== null ? $fmt1($leaderScore) : '-' }}</span><span id="score_leadership_suffix">{{ $leaderScore !== null ? ' / 10' : '' }}</span>
                </div>
            </div>

            <div class="rating-row">
                <div class="rating-row-label">{{ __('app.assess_ip_rating_overall_label') }}</div>
                <div class="rating-buttons">
                    <button type="button" class="rating-pill rating-band" data-group="leadership" data-band="always">{{ $loc==='th' ? 'เสมอ' : 'Always' }}</button>
                    <button type="button" class="rating-pill rating-band" data-group="leadership" data-band="often">{{ $loc==='th' ? 'บ่อย' : 'Often' }}</button>
                    <button type="button" class="rating-pill rating-band" data-group="leadership" data-band="seldom">{{ $loc==='th' ? 'นานๆครั้ง' : 'Sometimes' }}</button>
                    <button type="button" class="rating-pill rating-band" data-group="leadership" data-band="almost_never">{{ $loc==='th' ? 'แทบไม่เคย' : 'Almost never' }}</button>
                    <button type="button" class="rating-pill rating-band" data-group="leadership" data-band="never">{{ $loc==='th' ? 'ไม่เคย' : 'Never' }}</button>
                </div>
            </div>

            <div class="rating-row">
                <div class="rating-row-label">{{ $loc==='th' ? 'คะแนนที่เลือก' : 'Pick score' }}</div>
                <div class="rating-buttons" id="leadership-score-options"></div>
            </div>
        </div>

        <div class="rating-group" id="group-attitude">
            <div class="rating-header">
                <div class="rating-title">{{ __('app.assess_ip_attitude_label') }}</div>
                <div class="rating-current">
                    <span id="score_attitude_display">{{ $attitudeScore !== null ? $fmt1($attitudeScore) : '-' }}</span><span id="score_attitude_suffix">{{ $attitudeScore !== null ? ' / 10' : '' }}</span>
                </div>
            </div>

            <div class="rating-row">
                <div class="rating-row-label">{{ __('app.assess_ip_rating_overall_label') }}</div>
                <div class="rating-buttons">
                    <button type="button" class="rating-pill rating-band" data-group="attitude" data-band="always">{{ $loc==='th' ? 'เสมอ' : 'Always' }}</button>
                    <button type="button" class="rating-pill rating-band" data-group="attitude" data-band="often">{{ $loc==='th' ? 'บ่อย' : 'Often' }}</button>
                    <button type="button" class="rating-pill rating-band" data-group="attitude" data-band="seldom">{{ $loc==='th' ? 'นานๆครั้ง' : 'Sometimes' }}</button>
                    <button type="button" class="rating-pill rating-band" data-group="attitude" data-band="almost_never">{{ $loc==='th' ? 'แทบไม่เคย' : 'Almost never' }}</button>
                    <button type="button" class="rating-pill rating-band" data-group="attitude" data-band="never">{{ $loc==='th' ? 'ไม่เคย' : 'Never' }}</button>
                </div>
            </div>

            <div class="rating-row">
                <div class="rating-row-label">{{ $loc==='th' ? 'คะแนนที่เลือก' : 'Pick score' }}</div>
                <div class="rating-buttons" id="attitude-score-options"></div>
            </div>
        </div>

        <div class="modal-actions">
            @if($showUserActionButtons)
                <button type="button" class="btn" onclick="ipModalCalculate()">{{ $loc==='th' ? 'คำนวณ' : 'Calculate' }}</button>
                <button type="button" class="btn btn-save" onclick="ipModalSave()">{{ $loc==='th' ? 'บันทึก' : 'Save' }}</button>
            @endif
        </div>
    </div>
</div>

<div id="criteria-modal" class="modal-overlay" onclick="overlayClick(event,'criteria-modal')">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title" id="criteria-title">{{ $loc==='th' ? 'เกณฑ์' : 'Criteria' }}</div>
            <button type="button" class="modal-close" onclick="closeCriteriaModal()">×</button>
        </div>
        <div id="criteria-body"></div>
    </div>
</div>

<div id="calc-modal" class="modal-overlay" onclick="overlayClick(event,'calc-modal')">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title" id="calc-title">{{ $loc==='th' ? 'สูตร' : 'Formula' }}</div>
            <button type="button" class="modal-close" onclick="closeCalcModal()">×</button>
        </div>
        <div id="calc-body"></div>
    </div>
</div>

<div id="confirm-save-modal" class="modal-overlay" onclick="overlayClick(event,'confirm-save-modal')">
    <div class="modal-box" style="max-width:520px;">
        <div class="modal-header">
            <div class="modal-title">{{ $loc==='th' ? 'ยืนยันการบันทึก' : 'Confirm save' }}</div>
            <button type="button" class="modal-close" onclick="closeConfirmSaveModal()">×</button>
        </div>

        <div id="confirm-save-msg" class="calc-box" style="margin-bottom:10px;"></div>

        <div style="display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap">
            <button type="button" class="btn" onclick="closeConfirmSaveModal()">{{ $loc==='th' ? 'ยกเลิก' : 'Cancel' }}</button>
            <button type="button" class="btn btn-save" id="confirm-save-btn" onclick="confirmSaveNow()">{{ $loc==='th' ? 'บันทึก' : 'Save' }}</button>
        </div>
    </div>
</div>

<div id="avatar-modal" class="modal-overlay" onclick="overlayClick(event,'avatar-modal')">
    <div class="modal-box avatar-modal-box">
        <img src="{{ $avatarUrl }}" class="avatar-modal-img" alt="avatar-large">
        <button type="button" class="avatar-modal-close" onclick="closeAvatarModal()">{{ $loc==='th' ? 'ปิด' : 'Close' }}</button>
    </div>
</div>

<script>
    const CFG = {
        loc: @json($loc),
        cycleId: @json($cycleIdForJs),
        employeeCode: @json((string)($employee->employee_code ?? '')),
        viewerRole: @json((string)$viewerRole),

        weightAttendance: @json($weightAttendance),
        weightIndividual: @json($weightIndividual),

        attendancePoints: @json($attendancePoints),
        otherPoints: @json($otherPoints),
        bonusScore: @json($bonusScore),

        warningCnt: @json($warningCnt),
        suspensionCnt: @json($suspensionCnt),

        maxWithBonus: @json($maxWithBonus),

        ipEvaluated: @json($ipEvaluated),
        ipInitialWeighted: @json($ipWeightedInit),

        ipBase: @json($ipBase),

        criteriaMap: @json($criteriaMap),
        criteriaDetailMap: @json($criteriaDetailMap),
        calcMap: @json($calcMap),
    };

    const STATE = {
        leadership: { band: null, score: @json($leaderScore) },
        attitude:   { band: null, score: @json($attitudeScore) },
        ipCalculated: @json(is_numeric($ipWeightedInit)),
        ipCalc: { ipWeighted: @json(is_numeric($ipWeightedInit) ? (float)$ipWeightedInit : null) }
    };

    const DOM0 = { totalText: null };
    let JSFLASH_TIMER = null;

    function el(id){ return document.getElementById(id); }
    function overlayClick(e, id){
        if (e.target && e.target.id === id) el(id).style.display = 'none';
    }

    function showJsFlash(type, msg){
        const box = el('js-flash');
        if (!box) return;

        let cls = 'flash-info';
        if (type === 'success') cls = 'flash-success';
        if (type === 'warning') cls = 'flash-warning';

        box.className = 'flash-box ' + cls;
        box.textContent = msg;
        box.style.display = 'block';

        if (JSFLASH_TIMER) clearTimeout(JSFLASH_TIMER);
        JSFLASH_TIMER = setTimeout(()=>{ box.style.display = 'none'; }, 2500);
    }

    function openAttModal(){ el('att-modal').style.display = 'flex'; }
    function closeAttModal(){ el('att-modal').style.display = 'none'; }

    function openIpModal(){
        el('ip-modal').style.display = 'flex';
        renderScoreOptions('leadership');
        renderScoreOptions('attitude');
        renderSelections();
        renderIpComputed();
    }
    function closeIpModal(){ el('ip-modal').style.display = 'none'; }

    function openCriteriaModal(key){
        const title = (CFG.criteriaMap && CFG.criteriaMap[key]) ? CFG.criteriaMap[key] : (CFG.loc==='th' ? 'เกณฑ์' : 'Criteria');
        const txt = (CFG.criteriaDetailMap && CFG.criteriaDetailMap[key]) ? CFG.criteriaDetailMap[key] : (CFG.loc==='th' ? 'ยังไม่ได้ใส่รายละเอียดเกณฑ์' : 'Criteria details not set.');
        el('criteria-title').textContent = title;
        el('criteria-body').innerHTML = `<div class="calc-box"><div class="calc-mono">${escapeHtml(txt)}</div></div>`;
        el('criteria-modal').style.display = 'flex';
    }
    function closeCriteriaModal(){ el('criteria-modal').style.display = 'none'; }

    function openCalcModal(key){
        el('calc-title').textContent = (CFG.loc==='th' ? 'สูตร' : 'Formula');
        const txt = (CFG.calcMap && CFG.calcMap[key]) ? CFG.calcMap[key] : '-';
        el('calc-body').innerHTML = `<div class="calc-box"><div class="calc-mono">${escapeHtml(txt)}</div></div>`;
        el('calc-modal').style.display = 'flex';
    }
    function closeCalcModal(){ el('calc-modal').style.display = 'none'; }

    function setEvaluatedBadge(on){
        const b = el('eval-badge');
        if (!b) return;
        b.style.display = on ? '' : 'none';
    }

    function openConfirmSaveModal(){
        const ls = getScoreLabel('leadership');
        const as = getScoreLabel('attitude');
        const msg = (CFG.loc==='th')
            ? `คุณต้องการบันทึกคะแนนนี้ลงฐานข้อมูลหรือไม่?\nLeadership: ${ls}\nAttitude: ${as}`
            : `Do you want to save to database?\nLeadership: ${ls}\nAttitude: ${as}`;
        el('confirm-save-msg').innerHTML = `<div class="calc-mono">${escapeHtml(msg)}</div>`;
        el('confirm-save-modal').style.display = 'flex';
    }
    function closeConfirmSaveModal(){ el('confirm-save-modal').style.display = 'none'; }

    function confirmSaveNow(){
        syncHiddenInputs();
        el('save-total-form').submit();
    }

    function openAvatarModal(){ el('avatar-modal').style.display = 'flex'; }
    function closeAvatarModal(){ el('avatar-modal').style.display = 'none'; }

    function escapeHtml(s){
        return String(s)
            .replaceAll('&','&amp;')
            .replaceAll('<','&lt;')
            .replaceAll('>','&gt;');
    }

    function setThemeIcon(){
        const isDark = document.documentElement.classList.contains('dark-mode');
        const icon = el('themeIcon');
        if (!icon) return;
        icon.className = 'bi ' + (isDark ? 'bi-moon-stars-fill' : 'bi-brightness-high-fill');
        const toggle = el('themeToggle');
        if (toggle) toggle.checked = isDark;
    }

    function bindTheme(){
        const toggle = el('themeToggle');
        if (!toggle) return;
        toggle.addEventListener('change', function(){
            const isDark = !!toggle.checked;
            document.documentElement.classList.toggle('dark-mode', isDark);
            try { localStorage.setItem('supavut_theme_mode', isDark ? 'dark' : 'light'); } catch(e){}
            setThemeIcon();
        });
        setThemeIcon();
    }

    function bindLang(){
        const buttons = document.querySelectorAll('.lang-btn-square[data-locale]');
        buttons.forEach(btn=>{
            btn.addEventListener('click', ()=>{
                const loc = btn.getAttribute('data-locale');
                el('localeInput').value = loc;
                el('localeForm').submit();
            });
        });
    }

    function inferBandFromScore(s){
        if (s === null || s === undefined || s === '') return null;
        const v = parseFloat(s);
        if (!isFinite(v)) return null;

        const iv = Math.round(v);

        if ([10,9,8].includes(iv)) return 'always';
        if ([7,6,5].includes(iv)) return 'often';
        if ([4,3,2].includes(iv)) return 'seldom';
        if (iv === 1) return 'almost_never';
        if (iv === 0) return 'never';

        return null;
    }

    function scoresForBand(band){
        if (band === 'always') return [10,9,8];
        if (band === 'often') return [7,6,5];
        if (band === 'seldom') return [4,3,2];
        if (band === 'almost_never') return [1];
        if (band === 'never') return [0];
        return [];
    }

    function renderScoreOptions(group){
        const boxId = group === 'leadership' ? 'leadership-score-options' : 'attitude-score-options';
        const box = el(boxId);
        if (!box) return;

        box.innerHTML = '';

        if (STATE[group].na) {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'rating-pill rating-score active';
            b.textContent = 'N/A';
            b.dataset.group = group;
            b.dataset.score = 'na';
            b.addEventListener('click', ()=>setBand(group, 'na'));
            box.appendChild(b);
            return;
        }

        const band = STATE[group].band;
        if (!band) return;

        const vals = scoresForBand(band);
        vals.forEach(v=>{
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'rating-pill rating-score';
            b.textContent = String(v);
            b.dataset.group = group;
            b.dataset.score = String(v);
            b.addEventListener('click', ()=>setScore(group, v));
            box.appendChild(b);
        });

        refreshActivePills();
    }

    function markIpDirty(){
        STATE.ipCalculated = false;
        STATE.ipCalc = { ipWeighted: null };

        if (el('ip-summary-main')) el('ip-summary-main').textContent = `- / ${CFG.weightIndividual}`;
        if (el('ip-modal-main')) el('ip-modal-main').textContent = `- / ${CFG.weightIndividual}`;

        const w2 = el('ip-modal-minimal-warning');
        if (w2) {
            w2.textContent = (CFG.loc==='th')
                ? 'กด “คำนวณ” เพื่อแสดงผลลัพธ์'
                : 'Press “Calculate” to show the result.';
        }

        restoreTotalOnly();
        applyIpBoxState();
    }

    function setBand(group, band){
        STATE[group].band = band;
        STATE[group].na = (band === 'na');

        if (STATE[group].na) {
            STATE[group].score = null;
        } else {
            const vals = scoresForBand(band);
            const cur = (STATE[group].score === null || STATE[group].score === undefined || !isFinite(Number(STATE[group].score))) ? null : Math.round(Number(STATE[group].score));
            if (!vals.includes(cur)) {
                STATE[group].score = null;
            } else {
                STATE[group].score = cur;
            }
        }

        renderScoreOptions(group);
        renderSelections();
        markIpDirty();
    }

    function setScore(group, score){
        STATE[group].na = false;
        STATE[group].score = (score === null ? null : Math.round(Number(score)));
        STATE[group].band = inferBandFromScore(STATE[group].score);

        renderScoreOptions(group);
        renderSelections();
        markIpDirty();
    }

    function hasValidScore(group){
        if (STATE[group].na) return true;
        const s = STATE[group].score;
        return (s !== null && s !== undefined && s !== '' && isFinite(Number(s)));
    }

    /* ✅ “มีคะแนน” = numeric เท่านั้น (เอาไว้ทำกรอบเขียว) */
    function hasNumericScore(group){
        if (STATE[group].na) return false;
        const s = STATE[group].score;
        return (s !== null && s !== undefined && s !== '' && isFinite(Number(s)));
    }

    function updateGroupDone(){
        ['leadership','attitude'].forEach(g=>{
            const groupBox = el('group-' + g);
            if (!groupBox) return;
            groupBox.classList.toggle('done', hasNumericScore(g));
        });
    }

    function refreshActivePills(){
        document.querySelectorAll('.rating-pill').forEach(btn=>{
            btn.classList.remove('active');
        });

        document.querySelectorAll('.rating-pill[data-group]').forEach(btn=>{
            const g = btn.dataset.group;
            const band = btn.dataset.band;
            if (band) {
                if (STATE[g].na && band === 'na') btn.classList.add('active');
                if (!STATE[g].na && STATE[g].band === band) btn.classList.add('active');
            }
        });

        document.querySelectorAll('.rating-score').forEach(btn=>{
            const g = btn.dataset.group;
            const ds = btn.dataset.score;
            if (ds === 'na') {
                if (STATE[g].na) btn.classList.add('active');
                return;
            }
            const sc = parseFloat(ds);
            if (!STATE[g].na && STATE[g].score !== null && Number(sc) === Number(STATE[g].score)) {
                btn.classList.add('active');
            }
        });

        ['leadership','attitude'].forEach(g=>{
            const groupBox = el('group-' + g);
            if (!groupBox) return;
            if (STATE[g].band !== null) groupBox.classList.add('filled');
            else groupBox.classList.remove('filled');
        });

        updateGroupDone();
    }

    function getScoreLabel(group){
        if (STATE[group].na) return 'N/A';
        if (STATE[group].score === null || STATE[group].score === undefined) return '-';
        const n = Number(STATE[group].score);
        if (!isFinite(n)) return '-';
        return String(Math.round(n));
    }

    function setSuffix(group, label){
        const suf = el('score_' + group + '_suffix');
        if (!suf) return;
        if (label === 'N/A' || label === '-') suf.textContent = '';
        else suf.textContent = ' / 10';
    }

    function computeIpWeighted(){
        let baseTotal = 0;
        let baseCount = 0;

        (CFG.ipBase || []).forEach(it=>{
            const s = (it && typeof it === 'object') ? it.score : null;
            if (s !== null && s !== undefined && s !== '' && isFinite(Number(s))) {
                baseTotal += Number(s);
                baseCount += 1;
            }
        });

        let laTotal = 0;
        let laCount = 0;

        if (!STATE.leadership.na && STATE.leadership.score !== null && isFinite(Number(STATE.leadership.score))) {
            laTotal += Number(STATE.leadership.score);
            laCount += 1;
        }
        if (!STATE.attitude.na && STATE.attitude.score !== null && isFinite(Number(STATE.attitude.score))) {
            laTotal += Number(STATE.attitude.score);
            laCount += 1;
        }

        const scoredTopics = baseCount + laCount;
        if (scoredTopics <= 0) {
            return { ipWeighted: null, ipFull: 0, ipTotal: 0 };
        }

        const ipFull = 10 * scoredTopics;
        const ipTotal = baseTotal + laTotal;
        const ipWeighted = (ipTotal / ipFull) * Number(CFG.weightIndividual || 0);

        return { ipWeighted, ipFull, ipTotal };
    }

    function laReady(){
        return hasValidScore('leadership') && hasValidScore('attitude');
    }

    function applyIpBoxState(){
        const box = el('ip-summary-box');
        if (!box) return;

        const laOk = laReady();

        const hasCalc = (
            STATE.ipCalculated &&
            STATE.ipCalc &&
            STATE.ipCalc.ipWeighted !== null &&
            STATE.ipCalc.ipWeighted !== undefined &&
            isFinite(Number(STATE.ipCalc.ipWeighted))
        );

        const ok = (laOk && hasCalc);

        box.classList.remove('ip-alert','ip-ok');
        box.classList.add(ok ? 'ip-ok' : 'ip-alert');

        const msgPick = (CFG.loc==='th')
            ? 'กรุณาเลือกคะแนน Leadership และ Attitude (หรือเลือก N/A) ให้ครบก่อนคำนวณ'
            : 'Please pick Leadership and Attitude (or choose N/A) before calculating.';
        const msgCalc = (CFG.loc==='th')
            ? 'กด “คำนวณ” เพื่อแสดงผลลัพธ์'
            : 'Press “Calculate” to show the result.';

        const w1 = el('ip-minimal-warning');
        if (w1){
            if (ok){
                w1.style.display = 'none';
                w1.textContent = '';
            } else {
                w1.style.display = '';
                w1.textContent = laOk ? msgCalc : msgPick;
            }
        }

        const w2 = el('ip-modal-minimal-warning');
        if (w2){
            if (ok) w2.textContent = '';
            else w2.textContent = laOk ? msgCalc : msgPick;
        }
    }

    function syncHiddenInputs(){
        const lead = el('score_leadership');
        const att = el('score_attitude');

        if (STATE.leadership.na || STATE.leadership.score === null || STATE.leadership.score === undefined) lead.value = '';
        else lead.value = (Number(STATE.leadership.score).toFixed(1));

        if (STATE.attitude.na || STATE.attitude.score === null || STATE.attitude.score === undefined) att.value = '';
        else att.value = (Number(STATE.attitude.score).toFixed(1));
    }

    function renderSelections(){
        const ls = getScoreLabel('leadership');
        const as = getScoreLabel('attitude');

        el('score_leadership_display').textContent = ls;
        el('score_attitude_display').textContent = as;

        setSuffix('leadership', ls);
        setSuffix('attitude', as);

        if (el('cell-leader')) el('cell-leader').textContent = ls;
        if (el('cell-attitude')) el('cell-attitude').textContent = as;

        refreshActivePills();
        syncHiddenInputs();
        applyIpBoxState();
    }

    function renderIpComputed(){
        if (!STATE.ipCalculated || !STATE.ipCalc || STATE.ipCalc.ipWeighted === null || !isFinite(Number(STATE.ipCalc.ipWeighted))) {
            if (el('ip-modal-main')) el('ip-modal-main').textContent = `- / ${CFG.weightIndividual}`;
            if (el('ip-summary-main')) el('ip-summary-main').textContent = `- / ${CFG.weightIndividual}`;
            const w2 = el('ip-modal-minimal-warning');
            if (w2) {
                w2.textContent = (CFG.loc==='th')
                    ? 'กด “คำนวณ” เพื่อแสดงผลลัพธ์'
                    : 'Press “Calculate” to show the result.';
            }
            return;
        }

        const v = Number(STATE.ipCalc.ipWeighted).toFixed(2);
        if (el('ip-modal-main')) el('ip-modal-main').textContent = `${v} / ${CFG.weightIndividual}`;
        if (el('ip-summary-main')) el('ip-summary-main').textContent = `${v} / ${CFG.weightIndividual}`;
        const w2 = el('ip-modal-minimal-warning');
        if (w2) w2.textContent = '';

        const total = Number(CFG.attendancePoints || 0) + Number(STATE.ipCalc.ipWeighted || 0) + Number(CFG.otherPoints || 0) + Number(CFG.bonusScore || 0);
        el('total-score-main').textContent = `${total.toFixed(2)} / ${Number(CFG.maxWithBonus || 0).toFixed(2)}`;
    }

    function captureTotalOnly(){
        const t = el('total-score-main');
        DOM0.totalText = t ? t.textContent : '';
    }

    function restoreTotalOnly(){
        if (DOM0.totalText === null) return;
        const t = el('total-score-main');
        if (t) t.textContent = DOM0.totalText;
    }

    function focusIpGroup(group){
        openIpModal();
        const box = el('group-' + group);
        if (!box) return;
        box.classList.add('pulse');
        box.scrollIntoView({behavior:'smooth', block:'center'});
        setTimeout(()=>box.classList.remove('pulse'), 1200);
    }

    function bindBandButtons(){
        document.querySelectorAll('.rating-pill[data-group][data-band]').forEach(btn=>{
            btn.addEventListener('click', ()=>{
                const g = btn.dataset.group;
                const band = btn.dataset.band;
                setBand(g, band);
            });
        });
    }

    function initStateFromServer(){
        ['leadership','attitude'].forEach(g=>{
            if (STATE[g].na) {
                STATE[g].band = 'na';
            } else {
                const s = STATE[g].score;
                if (s !== null && s !== undefined && s !== '' && isFinite(Number(s))) {
                    const iv = Math.round(Number(s));
                    STATE[g].score = iv;
                    STATE[g].band = inferBandFromScore(iv);
                    STATE[g].na = false;
                } else {
                    STATE[g].band = null;
                    STATE[g].na = false;
                    STATE[g].score = null;
                }
            }
            renderScoreOptions(g);
        });

        renderSelections();

        if (CFG.ipInitialWeighted !== null && CFG.ipInitialWeighted !== undefined && isFinite(Number(CFG.ipInitialWeighted))) {
            STATE.ipCalculated = true;
            STATE.ipCalc = { ipWeighted: Number(CFG.ipInitialWeighted) };
            renderIpComputed();
            applyIpBoxState();
        } else {
            markIpDirty();
        }

        if (CFG.ipEvaluated) setEvaluatedBadge(true);
        else setEvaluatedBadge(false);
    }

    function ipModalCalculate(){
        const missing = [];
        if (!hasValidScore('leadership')) missing.push('leadership');
        if (!hasValidScore('attitude')) missing.push('attitude');

        if (missing.length > 0){
            showJsFlash('warning', (CFG.loc==='th')
                ? 'กรุณาเลือกคะแนน Leadership และ Attitude ให้ครบก่อนคำนวณ'
                : 'Please pick Leadership and Attitude before calculating.'
            );
            focusIpGroup(missing[0]);
            return;
        }

        const res = computeIpWeighted();
        if (!res || res.ipWeighted === null || !isFinite(Number(res.ipWeighted))){
            showJsFlash('warning', (CFG.loc==='th') ? 'ไม่สามารถคำนวณได้' : 'Cannot calculate.');
            return;
        }

        STATE.ipCalculated = true;
        STATE.ipCalc = { ipWeighted: Number(res.ipWeighted) };
        renderIpComputed();
        applyIpBoxState();

        showJsFlash('success', (CFG.loc==='th') ? 'คำนวณแล้ว' : 'Calculated.');
    }

    function ipModalSave(){
        closeIpModal();
    }

    document.addEventListener('DOMContentLoaded', function(){
        bindTheme();
        bindLang();
        bindBandButtons();
        captureTotalOnly();
        initStateFromServer();
    });
</script>

</body>
</html>
