<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('app.assess_employees_page_title') }} • {{ config('app.name', 'Supavut Assessment') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
        (function () {
            try {
                const saved = localStorage.getItem('supavut_theme_mode');
                const mode = (saved === 'light' || saved === 'dark') ? saved : 'dark';
                if (mode === 'dark') document.documentElement.classList.add('dark-mode');
            } catch (e) {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f5f7fb;
            --card-bg: #ffffff;
            --primary: #111827;
            --primary-soft: rgba(15,23,42,0.06);
            --border-soft: rgba(148,163,184,0.45);
            --text-main: #111827;
            --text-muted: #6b7280;
            --accent: #111827;
            --glass-bg: rgba(255,255,255,0.9);
            --gold: #e0b761;
            --gold2:#f8d57a;
        }

        html.dark-mode {
            --bg: #020617;
            --card-bg: rgba(15,23,42,0.98);
            --primary: #e5e7eb;
            --primary-soft: rgba(148,163,184,0.08);
            --border-soft: rgba(148,163,184,0.7);
            --text-main: #e5e7eb;
            --text-muted: #9ca3af;
            --accent: #e0b761;
            --glass-bg: rgba(15,23,42,0.96);
            --gold: #e0b761;
            --gold2:#f8d57a;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Prompt', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at top, rgba(15,23,42,0.08) 0, transparent 55%),
                radial-gradient(circle at bottom, rgba(0,0,0,0.12) 0, transparent 60%),
                var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            color: var(--text-main);
            transition: background-color .25s ease, color .25s ease;
        }

        .page-wrap { width: 100%; max-width: 1100px; }

        .card-glass {
            background: var(--card-bg);
            border-radius: 22px;
            border: 1px solid var(--border-soft);
            box-shadow:
                0 22px 50px rgba(15, 23, 42, 0.25),
                0 0 0 1px rgba(255,255,255,0.65);
            padding: 20px 20px 18px;
            position: relative;
            overflow: hidden;
        }

        html.dark-mode .card-glass {
            box-shadow:
                0 22px 50px rgba(15, 23, 42, 0.85),
                0 0 0 1px rgba(15,23,42,0.9);
        }

        .card-glass::before {
            content: "";
            position: absolute;
            inset: -40%;
            background:
                radial-gradient(circle at 0 0, rgba(148,163,184,0.18), transparent 55%),
                radial-gradient(circle at 100% 100%, rgba(0,0,0,0.18), transparent 55%);
            opacity: 0.7;
            pointer-events: none;
        }

        .card-inner {
            position: relative;
            z-index: 1;
            margin-top: 92px;
        }

        .top-right-stack {
            position: absolute;
            top: 10px;
            right: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: flex-end;
            z-index: 99999;
        }

        .top-right-row {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .lang-switch {
            display: inline-flex;
            padding: 4px 6px;
            border-radius: 999px;
            background: var(--glass-bg);
            border: 1px solid var(--border-soft);
            backdrop-filter: blur(10px) saturate(140%);
            -webkit-backdrop-filter: blur(10px) saturate(140%);
            box-shadow: 0 10px 24px rgba(15,23,42,0.25);
            position: relative;
            z-index: 99999;
        }

        .lang-switch form { display: flex; gap: 4px; margin: 0; padding: 0; }

        .lang-btn-square {
            appearance: none;
            border: 0;
            cursor: pointer;
            border-radius: 9px;
            padding: 4px 8px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: .03em;
            text-transform: uppercase;
            color: var(--text-main);
            background: transparent;
            border: 1px solid transparent;
            min-width: 40px;
            transition: background-color .16s ease, color .16s ease, box-shadow .16s ease, transform .08s ease, border-color .16s ease;
        }

        .lang-btn-square[data-active="true"]{
            background: linear-gradient(135deg, var(--gold2), var(--gold));
            color: #111827;
            border-color: rgba(250,204,21,.9);
            box-shadow: 0 10px 24px rgba(224,183,97,.35), inset 0 0 0 1px rgba(255,255,255,.85);
        }

        .lang-btn-square:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15,23,42,0.4);
        }

        .lang-btn-square[data-active="true"]:hover{
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(224,183,97,.45), inset 0 0 0 1px rgba(255,255,255,.9);
        }

        .theme-toggle-box {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px;
            background: var(--glass-bg);
            border-radius: 999px;
            border: 1px solid var(--border-soft);
            backdrop-filter: blur(10px) saturate(140%);
            -webkit-backdrop-filter: blur(10px) saturate(140%);
            box-shadow: 0 10px 24px rgba(15,23,42,0.25);
        }

        .theme-toggle-box .form-check-input { cursor: pointer; margin-top: 0; }

        /* ===== Title row ===== */
        .title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .page-title {
            font-size: 1.15rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        .title-actions{
            display:flex;
            align-items:center;
            justify-content:flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ===== Criteria button moved to title row ===== */
        .criteria-inline-btn{
            appearance:none;
            border:1px solid var(--border-soft);
            background: var(--glass-bg);
            color: var(--text-main);
            border-radius: 999px;
            padding: 6px 10px 6px 8px;
            display:inline-flex;
            align-items:center;
            gap:10px;
            cursor:pointer;
            backdrop-filter: blur(10px) saturate(140%);
            -webkit-backdrop-filter: blur(10px) saturate(140%);
            box-shadow: 0 12px 26px rgba(15,23,42,0.18);
            transition: transform .12s ease, box-shadow .12s ease, background-color .12s ease;
            line-height: 1;
        }
        .criteria-inline-btn:hover{
            transform: translateY(-1px);
            box-shadow: 0 18px 40px rgba(15,23,42,0.22);
            background: rgba(255,255,255,0.96);
        }
        html.dark-mode .criteria-inline-btn{
            background: rgba(15,23,42,0.92);
        }
        html.dark-mode .criteria-inline-btn:hover{
            background: rgba(30,64,175,0.55);
        }

        .criteria-thumb-sm{
            width: 34px;
            height: 34px;
            border-radius: 12px;
            overflow:hidden;
            position: relative;
            flex-shrink: 0;
            box-shadow: 0 10px 22px rgba(15,23,42,0.18);
        }
        .criteria-thumb-sm img{
            width:100%;
            height:100%;
            object-fit: cover;
            display:block;
        }
        .criteria-thumb-sm .criteria-thumb-sm-icon{
            position:absolute;
            bottom:4px;
            right:4px;
            width:18px;
            height:18px;
            border-radius:999px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            background: rgba(17,24,39,0.75);
            color:#fff;
            font-size: .72rem;
        }
        html.dark-mode .criteria-thumb-sm .criteria-thumb-sm-icon{
            background: rgba(2,6,23,0.78);
        }

        .criteria-inline-text{
            font-size: .86rem;
            font-weight: 700;
            white-space: nowrap;
        }

        /* ===== Status dots (no border/frame) ===== */
        .status-legend{
            display:inline-flex;
            align-items:center;
            gap: 10px;
            font-size: .82rem;
            color: var(--text-muted);
            flex-wrap: wrap;
        }
        .status-legend .legend-item{
            display:inline-flex;
            align-items:center;
            gap: 6px;
            white-space: nowrap;
            font-weight: 600;
        }

        .status-inline{
            display:inline-flex;
            align-items:center;
            gap: 8px;
            font-size: .84rem;
            font-weight: 600;
            color: var(--text-main);
        }
        html.dark-mode .status-inline > span:last-child{
    color:#111827 !important;
}
        .status-dot{
            width: 10px;
            height: 10px;
            border-radius: 999px;
            display:inline-block;
        }
        .status-dot.green{ background:#22c55e; }
        .status-dot.red{ background:#ef4444; }

        .status-empty { display: block; min-height: 20px; }

        .section-title {
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .table-wrap {
            margin-top: 8px;
            border-radius: 16px;
            border: 1px solid var(--border-soft);
            overflow: hidden;
            background: var(--glass-bg);
        }

        table { margin-bottom: 0; }

        table thead {
            background: #111827;
            color: #e5e7eb;
        }

        html.dark-mode table thead { background: #020617; }

        table thead th {
            border-bottom-color: rgba(55,65,81,0.9) !important;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            white-space: nowrap;
        }

        table tbody tr {
            font-size: 0.86rem;
            color: var(--text-main);
        }

        table tbody tr:nth-child(odd) { background-color: rgba(243,244,246,0.9); }
        table tbody tr:nth-child(even) { background-color: rgba(229,231,235,0.9); }

        html.dark-mode table tbody tr:nth-child(odd) {
            background-color: rgba(15,23,42,0.9);
            color: #e5e7eb;
        }

        html.dark-mode table tbody tr:nth-child(even) {
            background-color: rgba(15,23,42,0.85);
            color: #e5e7eb;
        }

        table tbody td { vertical-align: middle; }

        tbody tr[data-emp-row="1"] td { cursor: pointer; }

        tbody tr[data-emp-row="1"] td.evaluate-cell,
        tbody tr[data-emp-row="1"] td.evaluate-cell * {
            cursor: default !important;
        }

        tbody tr[data-emp-row="1"]:hover {
            background-color: rgba(191,219,254,0.35) !important;
        }

        html.dark-mode tbody tr[data-emp-row="1"]:hover {
            background-color: rgba(30,64,175,0.55) !important;
        }

        .code-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border-radius: 999px;
            border: 1px solid rgba(148,163,184,0.7);
            padding: 2px 8px;
            font-size: 0.8rem;
            background: rgba(255,255,255,0.85);
        }

        html.dark-mode .code-badge {
            background: rgba(15,23,42,0.85);
            color: #e5e7eb;
        }

        .dept-full { font-weight: 500; }
        .dept-abbr { font-size: 0.78rem; color: var(--text-muted); }

        .empty-state {
            padding: 18px;
            text-align: center;
            font-size: 0.88rem;
            color: var(--text-muted);
        }

        .btn-back {
            border-radius: 999px;
            padding: 0.5rem 1.2rem;
            font-size: 0.9rem;
            font-weight: 500;
            border: 1px solid var(--border-soft);
            background: transparent;
            color: var(--text-main);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-back:hover { background: var(--primary-soft); }

        .evaluate-cell { text-align: center; }

        .btn-eval {
            border-radius: 999px;
            font-size: 0.75rem;
            padding: 3px 12px;
            border: 1px solid var(--border-soft);
            background: #ffffff;
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
        }

        .btn-eval:hover { background: var(--primary-soft); }

        html.dark-mode .btn-eval {
            background: rgba(15,23,42,0.95);
            color: #e5e7eb;
        }

        html.dark-mode .btn-eval:hover {
            background: rgba(30,64,175,0.65);
            color: #e5e7eb;
        }

        .btn-eval span { font-size: 0.74rem; }

        .emp-name-trigger {
            border-radius: 999px;
            padding: 2px 9px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color .15s ease, box-shadow .15s ease;
        }

        .emp-name-trigger:hover {
            background: var(--primary-soft);
            box-shadow: 0 4px 10px rgba(15,23,42,0.15);
        }

        html.dark-mode .emp-name-trigger:hover {
            background: rgba(30,64,175,0.55);
            box-shadow: 0 4px 14px rgba(15,23,42,0.8);
        }

        .emp-avatar-sm {
            width: 28px;
            height: 28px;
            border-radius: 999px;
            object-fit: cover;
            border: 1px solid var(--border-soft);
            background: rgba(243,244,246,0.9);
            flex-shrink: 0;
        }

        html.dark-mode .emp-avatar-sm {
            background: rgba(15,23,42,0.9);
        }

        .emp-hover-card {
            position: fixed;
            z-index: 9999;
            pointer-events: none;
            background: var(--glass-bg);
            border-radius: 18px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 18px 48px rgba(15,23,42,0.45);
            padding: 14px 16px;
            min-width: 320px;
            max-width: 380px;
            opacity: 0;
            transform: translateY(6px);
            transition: opacity .14s ease, transform .14s ease;
        }

        .emp-hover-card.visible { opacity: 1; transform: translateY(0); }

        .emp-hover-main { display: flex; align-items: center; gap: 14px; }

        .emp-hover-avatar-wrap {
            width: 76px;
            height: 76px;
            border-radius: 999px;
            overflow: hidden;
            border: 1px solid var(--border-soft);
            background: rgba(243,244,246,0.9);
            flex-shrink: 0;
        }

        html.dark-mode .emp-hover-avatar-wrap { background: rgba(15,23,42,0.9); }

        .emp-hover-avatar { width: 100%; height: 100%; object-fit: cover; }

        .emp-hover-text { min-width: 0; }

        .emp-hover-name { font-size: 1rem; font-weight: 600; margin-bottom: 3px; }
        .emp-hover-code { font-size: 0.8rem; color: var(--text-muted); margin-bottom: 2px; }
        .emp-hover-pos  { font-size: 0.82rem; margin-bottom: 2px; }
        .emp-hover-dept { font-size: 0.82rem; }

        .emp-hover-dept span { font-size: 0.8rem; color: var(--text-muted); }

        .modal-emp-detail {
            background: var(--glass-bg);
            border-radius: 22px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 22px 50px rgba(15,23,42,0.85), 0 0 0 1px rgba(255,255,255,0.06);
            color: var(--text-main);
        }

        html.dark-mode .modal-emp-detail { background: var(--card-bg); }

        .modal-emp-detail .modal-header,
        .modal-emp-detail .modal-footer {
            border-color: rgba(148,163,184,0.35);
        }

        .emp-modal-main {
            display: flex;
            gap: 18px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .emp-modal-avatar-wrap {
            width: 120px;
            height: 120px;
            border-radius: 22px;
            overflow: hidden;
            border: 2px solid rgba(255,255,255,0.9);
            box-shadow: 0 14px 28px rgba(15,23,42,0.4);
            background: #e5e7eb;
            flex-shrink: 0;
            cursor: zoom-in;
        }

        html.dark-mode .emp-modal-avatar-wrap {
            border-color: rgba(148,163,184,0.75);
            background: #020617;
        }

        .emp-modal-avatar { width: 100%; height: 100%; object-fit: cover; }

        .emp-modal-info { flex: 1; min-width: 220px; }

        .emp-modal-info-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-size: 0.9rem;
            padding: 4px 0;
        }

        .emp-modal-info-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--text-muted);
            flex-basis: 30%;
        }

        .emp-modal-info-value { font-weight: 500; flex: 1; }

        #empPhotoModal .modal-dialog { max-width: 900px; }

        #empPhotoModal .modal-content {
            background: rgba(15,23,42,0.9);
            border-radius: 24px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 24px 60px rgba(15,23,42,0.95);
        }

        #empPhotoModal .modal-body { background: transparent; }

        #empPhotoModalImg {
            max-height: 80vh;
            border-radius: 18px;
            border: 2px solid rgba(255,255,255,0.9);
            box-shadow: 0 18px 40px rgba(0,0,0,0.85);
        }

        #empPhotoModal .btn-close-white {
            background-color: rgba(15,23,42,0.75);
            border-radius: 999px;
            padding: 0.4rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.85);
        }

        .criteria-modal .modal-dialog { max-width: 980px; }

        .criteria-modal .modal-content {
            border-radius: 22px;
            border: 1px solid var(--border-soft);
            background: rgba(15,23,42,0.92);
            box-shadow: 0 24px 60px rgba(15,23,42,0.95);
            overflow: hidden;
        }

        .criteria-modal .modal-body{
            padding: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
        }

        .criteria-modal img{
            max-width: 100%;
            max-height: 86vh;
            width: auto;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 16px;
        }

        .criteria-modal .btn-close-white {
            background-color: rgba(15,23,42,0.75);
            border-radius: 999px;
            padding: 0.4rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.85);
        }

        .bottom-actions {
            margin-top: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .assessor-icon-btn{
            appearance:none;
            border:1px solid var(--border-soft);
            background: rgba(255,255,255,0.92);
            color: var(--text-main);
            border-radius: 999px;
            padding: 4px 10px;
            display:inline-flex;
            align-items:center;
            gap:6px;
            font-size:.78rem;
            line-height:1;
            cursor:pointer;
            transition: background-color .15s ease, box-shadow .15s ease, transform .08s ease;
        }
        .assessor-icon-btn:hover{
            background: var(--primary-soft);
            box-shadow: 0 10px 22px rgba(15,23,42,0.18);
            transform: translateY(-1px);
        }
        html.dark-mode .assessor-icon-btn{
            background: rgba(15,23,42,0.92);
            color:#e5e7eb;
        }
        html.dark-mode .assessor-icon-btn:hover{
            background: rgba(30,64,175,0.55);
            box-shadow: 0 14px 30px rgba(15,23,42,0.8);
        }

        .assessor-lines{
            display:flex;
            flex-direction:column;
            gap:10px;
        }
        .assessor-line{
            display:flex;
            align-items:flex-start;
            gap:10px;
            padding:10px 12px;
            border-radius:16px;
            border:1px solid var(--border-soft);
            background: var(--glass-bg);
        }
        html.dark-mode .assessor-line{ background: rgba(15,23,42,0.92); }
        .assessor-line .lbl{
            font-weight:700;
            min-width:92px;
            white-space:nowrap;
        }
        .assessor-line .val{
            font-weight:500;
            word-break:break-word;
        }

        @media (max-width: 768px) {
            .card-glass { padding: 16px 14px 14px; }
            .page-title { font-size: 1.05rem; }
            .table-wrap { border-radius: 14px; }
            .title-row { flex-direction: column; align-items: flex-start; }
            .title-actions{ width:100%; justify-content:flex-start; }
            .bottom-actions { flex-direction: column-reverse; align-items: stretch; }
            .bottom-actions .btn-back { width: 100%; justify-content: center; }
            .card-inner { margin-top: 98px; }
        }

        @media (max-width: 576px) {
            .emp-modal-main { flex-direction: column; align-items: center; }
            .emp-modal-info-row { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>

<body>
@php
    $locale = app()->getLocale();

    $defaultAvatarDataUri = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgMTI4IDEyOCI+PHJlY3Qgd2lkdGg9IjEyOCIgaGVpZ2h0PSIxMjgiIHJ4PSI2NCIgZmlsbD0iI2U1ZTdlYiIvPjxjaXJjbGUgY3g9IjY0IiBjeT0iNTIiIHI9IjIyIiBmaWxsPSIjOTRhM2I4Ii8+PHBhdGggZD0iTTI0IDExNGM4LTIyIDI2LTM0IDQwLTM0czMyIDEyIDQwIDM0IiBmaWxsPSIjOTRhM2I4Ii8+PC9zdmc+';

    $criteriaImg = asset('images/assessment/score_criteria.png');

    $employeesSupervisor = ($employeesSupervisor ?? collect());
    $employeesDivision   = ($employeesDivision ?? collect());

    $employeesSupervisor = is_array($employeesSupervisor) ? collect($employeesSupervisor) : (is_iterable($employeesSupervisor) ? collect($employeesSupervisor) : collect());
    $employeesDivision   = is_array($employeesDivision) ? collect($employeesDivision) : (is_iterable($employeesDivision) ? collect($employeesDivision) : collect());

    $cycleId = $cycleId ?? ($activeCycleId ?? (($cycle ?? null)?->id ?? null));

    $exportStatusByCode = $exportStatusByCode ?? $exportStatusMap ?? $statusMap ?? [];
    $exportStatusByCode = is_array($exportStatusByCode) ? $exportStatusByCode : [];

    if (empty($exportStatusByCode) && !empty($cycleId) && class_exists(\App\Models\ExportEmployee::class)) {
        $exportStatusByCode = \App\Models\ExportEmployee::query()
            ->where('cycle_id', (int)$cycleId)
            ->pluck('assessment_status', 'employee_code')
            ->toArray();
    }

    $statusFromExport = function ($emp) use ($exportStatusByCode) {
        $code = trim((string)($emp->employee_code ?? ''));
        if ($code === '') return null;
        return $exportStatusByCode[$code] ?? null;
    };

    $employeesSupervisor = $employeesSupervisor->filter(function ($e) use ($statusFromExport) {
        $s = trim((string)($statusFromExport($e) ?? ''));
        if ($s === '') $s = trim((string)($e->assessment_status ?? ''));
        return $s !== '' && $s !== '0/0';
    })->values();

    $employeesDivision = $employeesDivision->filter(function ($e) use ($statusFromExport) {
        $s = trim((string)($statusFromExport($e) ?? ''));
        if ($s === '') $s = trim((string)($e->assessment_status ?? ''));
        return $s !== '' && $s !== '0/0';
    })->values();

    /**
     * IMPORTANT CHANGE:
     * - Supervisor = DONE (green) only when Leadership + Attitude are BOTH present
     *   (from any of: score_leadership/supervisor_score_leadership + score_attitude/supervisor_score_attitude)
     * - Division   = DONE (green) only when division_score_leadership + division_score_attitude are BOTH present
     * - assessment_status (0/2,1/2,2/2) stays the same; we only change the indicator rule.
     */
    $supHasScoreByCode = $supHasScoreByCode ?? $supHasScoreMap ?? [];
    $divHasScoreByCode = $divHasScoreByCode ?? $divHasScoreMap ?? [];

    $supHasScoreByCode = is_array($supHasScoreByCode) ? $supHasScoreByCode : [];
    $divHasScoreByCode = is_array($divHasScoreByCode) ? $divHasScoreByCode : [];

    $allCodesForExport = $employeesSupervisor->pluck('employee_code')
        ->merge($employeesDivision->pluck('employee_code'))
        ->filter(fn($v) => trim((string)$v) !== '')
        ->unique()
        ->values()
        ->all();

    $isValidScoreValue = function ($v) {
        if ($v === null) return false;
        $s = trim((string)$v);
        if ($s === '') return false;
        $s2 = strtolower((string)preg_replace('/\s+/', '', $s));
        return !in_array($s2, ['na','n/a','n\\a','-','--','–','—'], true);
    };

    if ((!empty($cycleId)) && class_exists(\App\Models\ExportEmployee::class) && !empty($allCodesForExport)) {
        $supLeaderCols = ['score_leadership','supervisor_score_leadership'];
        $supAttCols    = ['score_attitude','supervisor_score_attitude'];

        $divLeaderCols = ['division_score_leadership'];
        $divAttCols    = ['division_score_attitude'];

        $supLeaderColsExists = [];
        foreach ($supLeaderCols as $c) { if (\Illuminate\Support\Facades\Schema::hasColumn('export_employees', $c)) $supLeaderColsExists[] = $c; }

        $supAttColsExists = [];
        foreach ($supAttCols as $c) { if (\Illuminate\Support\Facades\Schema::hasColumn('export_employees', $c)) $supAttColsExists[] = $c; }

        $divLeaderColsExists = [];
        foreach ($divLeaderCols as $c) { if (\Illuminate\Support\Facades\Schema::hasColumn('export_employees', $c)) $divLeaderColsExists[] = $c; }

        $divAttColsExists = [];
        foreach ($divAttCols as $c) { if (\Illuminate\Support\Facades\Schema::hasColumn('export_employees', $c)) $divAttColsExists[] = $c; }

        $cols = ['employee_code'];
        foreach (array_merge($supLeaderColsExists, $supAttColsExists, $divLeaderColsExists, $divAttColsExists) as $c) {
            if (!in_array($c, $cols, true)) $cols[] = $c;
        }

        if (count($cols) > 1) {
            $rows = \App\Models\ExportEmployee::query()
                ->where('cycle_id', (int)$cycleId)
                ->whereIn('employee_code', $allCodesForExport)
                ->get($cols);

            foreach ($rows as $r) {
                $k = trim((string)($r->employee_code ?? ''));
                if ($k === '') continue;

                if (!array_key_exists($k, $supHasScoreByCode)) {
                    $hasLeader = false;
                    foreach ($supLeaderColsExists as $c) {
                        if ($isValidScoreValue($r->{$c} ?? null)) { $hasLeader = true; break; }
                    }
                    $hasAtt = false;
                    foreach ($supAttColsExists as $c) {
                        if ($isValidScoreValue($r->{$c} ?? null)) { $hasAtt = true; break; }
                    }
                    $supHasScoreByCode[$k] = ($hasLeader && $hasAtt);
                }

                if (!array_key_exists($k, $divHasScoreByCode)) {
                    $hasLeader = false;
                    foreach ($divLeaderColsExists as $c) {
                        if ($isValidScoreValue($r->{$c} ?? null)) { $hasLeader = true; break; }
                    }
                    $hasAtt = false;
                    foreach ($divAttColsExists as $c) {
                        if ($isValidScoreValue($r->{$c} ?? null)) { $hasAtt = true; break; }
                    }
                    $divHasScoreByCode[$k] = ($hasLeader && $hasAtt);
                }
            }
        }
    }

    $assessorByCode = $assessorByCode ?? $assessorMap ?? [];
    $assessorByCode = is_array($assessorByCode) ? $assessorByCode : [];

    if (empty($assessorByCode) && !empty($cycleId) && class_exists(\App\Models\ExportEmployee::class)) {
        if (!empty($allCodesForExport)) {
            $rows = \App\Models\ExportEmployee::query()
                ->where('cycle_id', (int)$cycleId)
                ->whereIn('employee_code', $allCodesForExport)
                ->get(['employee_code','sup_id','sup_name','div_mgr_id','div_mgr_name']);

            foreach ($rows as $r) {
                $k = trim((string)$r->employee_code);
                if ($k === '') continue;

                $assessorByCode[$k] = [
                    'sup_id'      => $r->sup_id,
                    'sup_name'    => $r->sup_name,
                    'div_id'      => $r->div_mgr_id,
                    'div_name'    => $r->div_mgr_name,
                ];
            }
        }
    }

    $collectAssessorCodes = collect();

    foreach ($employeesSupervisor as $e) {
        $collectAssessorCodes->push(trim((string)($e->sup_id ?? '')));
        $collectAssessorCodes->push(trim((string)($e->div_mgr_id ?? $e->div_id ?? '')));
    }
    foreach ($employeesDivision as $e) {
        $collectAssessorCodes->push(trim((string)($e->sup_id ?? '')));
        $collectAssessorCodes->push(trim((string)($e->div_mgr_id ?? $e->div_id ?? '')));
    }
    foreach ($assessorByCode as $m) {
        if (is_array($m)) {
            $collectAssessorCodes->push(trim((string)($m['sup_id'] ?? '')));
            $collectAssessorCodes->push(trim((string)($m['div_id'] ?? '')));
        }
    }

    $assessorCodes = $collectAssessorCodes
        ->filter(fn($v) => $v !== '' && $v !== '-')
        ->unique()
        ->values()
        ->all();

    $assessorNameByCode = [];

    if (!empty($assessorCodes) && class_exists(\App\Models\Employee::class)) {
        $assessorNameByCode = \App\Models\Employee::query()
            ->whereIn('employee_code', $assessorCodes)
            ->get(['employee_code','full_name_th','full_name_en'])
            ->mapWithKeys(function ($r) {
                $code = trim((string)($r->employee_code ?? ''));
                if ($code === '') return [];
                $th = trim((string)($r->full_name_th ?? ''));
                $en = trim((string)($r->full_name_en ?? ''));
                if ($th === '' && $en !== '') $th = $en;
                if ($en === '' && $th !== '') $en = $th;
                return [$code => ['th' => $th, 'en' => $en]];
            })
            ->toArray();
    }

    $resolveAssessorName = function (?string $id, ?string $fallbackName) use ($locale, $assessorNameByCode) {
        $id = trim((string)($id ?? ''));
        $fallbackName = trim((string)($fallbackName ?? ''));
        if ($id !== '') {
            $m = $assessorNameByCode[$id] ?? null;
            if (is_array($m)) {
                $picked = trim((string)(($locale === 'en') ? ($m['en'] ?? '') : ($m['th'] ?? '')));
                if ($picked !== '') return $picked;
            }
        }
        return $fallbackName;
    };

    $fmtAssessorLine = function (?string $id, ?string $name) {
        $id = trim((string)($id ?? ''));
        $name = trim((string)($name ?? ''));
        if ($id === '' && $name === '') return '-';
        if ($id === '' && $name !== '') return $name;
        if ($id !== '' && $name === '') return '(' . $id . ')';
        return '(' . $id . ') ' . $name;
    };

    $getAssessorLines = function ($emp) use ($assessorByCode, $resolveAssessorName, $fmtAssessorLine) {
        $code = trim((string)($emp->employee_code ?? ''));
        $m = $code !== '' ? ($assessorByCode[$code] ?? null) : null;

        $supId = $m['sup_id'] ?? ($emp->sup_id ?? null);
        $supNmFallback = $m['sup_name'] ?? ($emp->sup_name ?? null);
        $supNm = $resolveAssessorName($supId, $supNmFallback);

        $divId = $m['div_id'] ?? ($emp->div_mgr_id ?? $emp->div_id ?? null);
        $divNmFallback = $m['div_name'] ?? ($emp->div_mgr_name ?? $emp->div_name ?? null);
        $divNm = $resolveAssessorName($divId, $divNmFallback);

        return [
            $fmtAssessorLine((string)$supId, (string)$supNm),
            $fmtAssessorLine((string)$divId, (string)$divNm),
        ];
    };

    $me     = auth()->user();
    $myCode = $me?->username ?? $me?->employee_code ?? $me?->employeeCode ?? null;

    $empTypeMapEn = [
        'รายเดือน' => 'Monthly',
        'รายวัน'   => 'Daily',
        'พนักงานรายเดือน' => 'Monthly',
        'พนักงานรายวัน'   => 'Daily',
    ];
    $empTypeMapTh = [
        'Monthly' => 'รายเดือน',
        'Daily'   => 'รายวัน',
    ];

    $displayEmpType = function ($raw) use ($locale, $empTypeMapEn, $empTypeMapTh) {
        $s = trim((string)($raw ?? ''));
        if ($s === '') return '-';
        if ($locale === 'en') return $empTypeMapEn[$s] ?? $s;
        return $empTypeMapTh[$s] ?? $s;
    };

    $mapGet = function ($map, $primaryKey, $fallbackKey = null) {
        if ($map instanceof \Illuminate\Support\Collection) {
            if ($primaryKey !== null && $map->has($primaryKey)) return $map->get($primaryKey);
            if ($fallbackKey !== null && $map->has($fallbackKey)) return $map->get($fallbackKey);
            return null;
        }
        if (is_array($map)) {
            if ($primaryKey !== null && array_key_exists($primaryKey, $map)) return $map[$primaryKey];
            if ($fallbackKey !== null && array_key_exists($fallbackKey, $map)) return $map[$fallbackKey];
            return null;
        }
        return null;
    };

    $avatarUrlFromPath = function ($path) {
        $p = trim((string)($path ?? ''));
        if ($p === '') return null;
        if (preg_match('~^https?://~i', $p)) return $p;
        $p = ltrim($p, '/');
        if (str_starts_with($p, 'storage/')) return asset($p);
        return asset('storage/' . $p);
    };

    $pickAvatarUrl = function ($emp) use ($avatarUrlFromPath, $defaultAvatarDataUri) {
        $empCandidates = [
            $emp->profile_picture ?? null,
            $emp->profile_photo ?? null,
            $emp->profile_image ?? null,
            $emp->photo ?? null,
            $emp->avatar ?? null,
            $emp->image ?? null,
            $emp->picture ?? null,
        ];

        foreach ($empCandidates as $c) {
            $u = $avatarUrlFromPath($c);
            if ($u) return $u;
        }

        $pic = null;

        if (method_exists($emp, 'relationLoaded') && $emp->relationLoaded('appUser')) {
            $pic = $emp->appUser?->profile_picture ?? $emp->appUser?->avatar ?? $emp->appUser?->photo ?? $emp->appUser?->image ?? null;
        } elseif (isset($emp->appUser)) {
            $pic = $emp->appUser?->profile_picture ?? $emp->appUser?->avatar ?? $emp->appUser?->photo ?? $emp->appUser?->image ?? null;
        }

        if (!$pic) {
            if (method_exists($emp, 'relationLoaded') && $emp->relationLoaded('user')) {
                $pic = $emp->user?->profile_picture ?? $emp->user?->avatar ?? $emp->user?->photo ?? $emp->user?->image ?? null;
            } elseif (isset($emp->user)) {
                $pic = $emp->user?->profile_picture ?? $emp->user?->avatar ?? $emp->user?->photo ?? $emp->user?->image ?? null;
            }
        }

        $u = $avatarUrlFromPath($pic);
        if ($u) return $u;

        return $defaultAvatarDataUri;
    };

    $parseAssessStatus = function ($raw) {
        $s = trim((string)($raw ?? ''));
        if ($s === '' || $s === '-') return [null, null, null];
        if (!preg_match('/^\s*(\d+)\s*\/\s*(\d+)\s*$/', $s, $m)) return [null, null, null];
        $done = (int)$m[1];
        $req  = (int)$m[2];
        if ($req < 0) $req = 0;
        if ($done < 0) $done = 0;
        return [$done, $req, $done . '/' . $req];
    };

    $assessorModalTitle = $locale === 'en' ? 'Assessor' : 'ผู้ประเมิน';
    $assessorBtnLabel   = $locale === 'en' ? 'View' : 'ดู';

    $criteriaTitle = $locale === 'en' ? 'Scoring criteria' : 'เกณฑ์การให้คะแนน';

    $legendAssessed = $locale === 'en' ? 'Assessed' : 'ประเมินแล้ว';
    $legendPending  = $locale === 'en' ? 'Not assessed' : 'ยังไม่ประเมิน';
@endphp

<div class="page-wrap">
    <div class="card-glass">

        <div class="top-right-stack">
            <div class="top-right-row">
                <div class="lang-switch" aria-label="Language switcher">
                    <form id="localeForm" action="{{ route('locale.switch') }}" method="POST">
                        @csrf
                        <button type="submit" name="locale" value="th" class="lang-btn-square" data-active="{{ $locale==='th' ? 'true' : 'false' }}">TH</button>
                        <button type="submit" name="locale" value="en" class="lang-btn-square" data-active="{{ $locale==='en' ? 'true' : 'false' }}">EN</button>
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

        <div class="card-inner">
            <div class="title-row">
                <div class="page-title">
                    <i class="bi bi-people-fill"></i>
                    <span>{{ __('app.assess_employees_page_title') }}</span>
                </div>

                <div class="title-actions">
                    <button type="button"
                            class="criteria-inline-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#criteriaModal"
                            title="{{ $criteriaTitle }}">
                        <span class="criteria-thumb-sm" aria-hidden="true">
                            <img src="{{ $criteriaImg }}" alt="criteria" loading="lazy" decoding="async" onerror="this.onerror=null;this.src='{{ $defaultAvatarDataUri }}';">
                            <span class="criteria-thumb-sm-icon"><i class="bi bi-card-checklist"></i></span>
                        </span>
                        <span class="criteria-inline-text">{{ $criteriaTitle }}</span>
                    </button>

                    <div class="status-legend" aria-label="Legend">
                        <span class="legend-item">
                            <span class="status-dot green"></span>
                            <span>{{ $legendAssessed }}</span>
                        </span>
                        <span class="legend-item">
                            <span class="status-dot red"></span>
                            <span>{{ $legendPending }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-2 mb-1">
                <div class="section-title">
                    <i class="bi bi-person-workspace"></i>
                    <span>{{ __('app.assess_employees_supervisor_title') }}</span>
                </div>
            </div>

            <div class="table-wrap mb-4">
                @if($employeesSupervisor->isEmpty())
                    <div class="empty-state">
                        {{ __('app.assess_employees_empty_supervisor') }}
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm align-middle text-nowrap">
                            <thead>
                            <tr>
                                <th style="width: 56px;">{{ __('app.assess_employees_table_no') }}</th>
                                <th style="width: 90px;">{{ __('app.assess_employees_table_code') }}</th>
                                <th style="width: 260px;">{{ __('app.assess_employees_table_name') }}</th>
                                <th style="width: 120px;">{{ $locale==='en' ? 'Assessor' : 'ผู้ประเมิน' }}</th>
                                <th style="width: 120px;">{{ __('app.assess_employees_table_type') }}</th>
                                <th>{{ __('app.assess_employees_table_position') }}</th>
                                <th>{{ __('app.assess_employees_table_department') }}</th>
                                <th style="width: 110px;">{{ __('app.assess_employees_table_score') }}</th>
                                <th style="width: 150px;">{{ __('app.assess_employees_table_status') }}</th>
                                <th style="width: 120px;">{{ __('app.assess_employees_table_action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employeesSupervisor as $emp)
                                @php
                                    $displayName = ($locale === 'en')
                                        ? ($emp->full_name_en ?? $emp->full_name_th ?? '-')
                                        : ($emp->full_name_th ?? $emp->full_name_en ?? '-');

                                    $position = $emp->position ?? '-';
                                    $deptFull = $emp->department ?? '-';
                                    $abbr = $emp->dept_abbr_qms ?: ($emp->dept_abbr_hr ?? null);

                                    $avatarUrl = $pickAvatarUrl($emp);

                                    $isMe = $myCode && (string)$emp->employee_code === (string)$myCode;

                                    $empTypeRaw  = $emp->employee_type ?? '-';
                                    $empTypeText = $displayEmpType($empTypeRaw);

                                    $finalScoreSup = $mapGet($supScores ?? null, (string)$emp->employee_code, $emp->id);

                                    [$supLine, $divLine] = $getAssessorLines($emp);

                                    if ($isMe) {
                                        $statusValue = null;
                                        $showEvaluateButton = false;
                                    } else {
                                        $statusRaw = $statusFromExport($emp);
                                        if ($statusRaw === null || trim((string)$statusRaw) === '') $statusRaw = ($emp->assessment_status ?? null);
                                        [$doneCnt, $reqCnt, $statusValue] = $parseAssessStatus($statusRaw);
                                        $showEvaluateButton = true;
                                    }

                                    $codeKey = trim((string)($emp->employee_code ?? ''));
                                    $hasSupScore = ($codeKey !== '') ? (bool)($supHasScoreByCode[$codeKey] ?? false) : false;
                                @endphp

                                <tr data-emp-row="1"
                                    data-name="{{ $displayName }}"
                                    data-position="{{ $position }}"
                                    data-dept="{{ $deptFull }}"
                                    data-abbr="{{ $abbr }}"
                                    data-code="{{ $emp->employee_code }}"
                                    data-avatar="{{ $avatarUrl }}"
                                    data-type="{{ $empTypeText }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="code-badge">
                                            <i class="bi bi-person-badge me-1"></i>
                                            {{ $emp->employee_code }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="emp-name-trigger">
                                            <img src="{{ $avatarUrl }}" alt="avatar" class="emp-avatar-sm" loading="lazy" decoding="async" onerror="this.onerror=null;this.src='{{ $defaultAvatarDataUri }}';">
                                            <span>{{ $displayName }}</span>
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button"
                                                class="assessor-icon-btn"
                                                data-assessor-btn="1"
                                                data-sup="{{ e($supLine) }}"
                                                data-div="{{ e($divLine) }}"
                                                title="{{ $assessorModalTitle }}">
                                            <i class="bi bi-person-lines-fill"></i>
                                            <span style="font-weight:600;">{{ $assessorBtnLabel }}</span>
                                        </button>
                                    </td>
                                    <td>{{ $empTypeText }}</td>
                                    <td>{{ $position }}</td>
                                    <td>
                                        <span class="dept-full">{{ $deptFull }}</span>
                                        @if($abbr)
                                            <span class="dept-abbr">({{ $abbr }})</span>
                                        @endif
                                    </td>

                                    <td>{{ $finalScoreSup !== null ? $finalScoreSup : '-' }}</td>

                                    <td>
                                        @if($statusValue)
                                            <span class="status-inline">
                                                <span class="status-dot {{ $hasSupScore ? 'green' : 'red' }}"></span>
                                                <span>{{ $statusValue }}</span>
                                            </span>
                                        @else
                                            <span class="status-empty">&nbsp;</span>
                                        @endif
                                    </td>

                                    <td class="evaluate-cell">
                                        @if($showEvaluateButton)
                                            <a href="{{ route('assessment.employees.show', ['employee' => $emp->id, 'role' => 'supervisor']) }}"
                                               class="btn-eval"
                                               title="{{ __('app.assess_employees_button_evaluate') }}">
                                                <i class="bi bi-clipboard-check"></i>
                                                <span>{{ __('app.assess_employees_button_evaluate') }}</span>
                                            </a>
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="mt-2 mb-1">
                <div class="section-title">
                    <i class="bi bi-diagram-3"></i>
                    <span>{{ __('app.assess_employees_division_title') }}</span>
                </div>
            </div>

            <div class="table-wrap">
                @if($employeesDivision->isEmpty())
                    <div class="empty-state">
                        {{ __('app.assess_employees_empty_division') }}
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm align-middle text-nowrap">
                            <thead>
                            <tr>
                                <th style="width: 56px;">{{ __('app.assess_employees_table_no') }}</th>
                                <th style="width: 90px;">{{ __('app.assess_employees_table_code') }}</th>
                                <th style="width: 260px;">{{ __('app.assess_employees_table_name') }}</th>
                                <th style="width: 120px;">{{ $locale==='en' ? 'Assessor' : 'ผู้ประเมิน' }}</th>
                                <th style="width: 120px;">{{ __('app.assess_employees_table_type') }}</th>
                                <th>{{ __('app.assess_employees_table_position') }}</th>
                                <th>{{ __('app.assess_employees_table_department') }}</th>
                                <th style="width: 110px;">{{ __('app.assess_employees_table_score') }}</th>
                                <th style="width: 150px;">{{ __('app.assess_employees_table_status') }}</th>
                                <th style="width: 120px;">{{ __('app.assess_employees_table_action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employeesDivision as $emp)
                                @php
                                    $displayName = ($locale === 'en')
                                        ? ($emp->full_name_en ?? $emp->full_name_th ?? '-')
                                        : ($emp->full_name_th ?? $emp->full_name_en ?? '-');

                                    $position = $emp->position ?? '-';
                                    $deptFull = $emp->department ?? '-';
                                    $abbr = $emp->dept_abbr_qms ?: ($emp->dept_abbr_hr ?? null);

                                    $avatarUrl = $pickAvatarUrl($emp);

                                    $isMe = $myCode && (string)$emp->employee_code === (string)$myCode;

                                    $empTypeRaw  = $emp->employee_type ?? '-';
                                    $empTypeText = $displayEmpType($empTypeRaw);

                                    $finalScoreDiv = $mapGet($divScores ?? null, (string)$emp->employee_code, $emp->id);

                                    [$supLine, $divLine] = $getAssessorLines($emp);

                                    if ($isMe) {
                                        $statusValue = null;
                                        $showEvaluateButton = false;
                                    } else {
                                        $statusRaw = $statusFromExport($emp);
                                        if ($statusRaw === null || trim((string)$statusRaw) === '') $statusRaw = ($emp->assessment_status ?? null);
                                        [$doneCnt, $reqCnt, $statusValue] = $parseAssessStatus($statusRaw);
                                        $showEvaluateButton = true;
                                    }

                                    $codeKey = trim((string)($emp->employee_code ?? ''));
                                    $hasDivScore = ($codeKey !== '') ? (bool)($divHasScoreByCode[$codeKey] ?? false) : false;
                                @endphp

                                <tr data-emp-row="1"
                                    data-name="{{ $displayName }}"
                                    data-position="{{ $position }}"
                                    data-dept="{{ $deptFull }}"
                                    data-abbr="{{ $abbr }}"
                                    data-code="{{ $emp->employee_code }}"
                                    data-avatar="{{ $avatarUrl }}"
                                    data-type="{{ $empTypeText }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="code-badge">
                                            <i class="bi bi-person-badge me-1"></i>
                                            {{ $emp->employee_code }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="emp-name-trigger">
                                            <img src="{{ $avatarUrl }}" alt="avatar" class="emp-avatar-sm" loading="lazy" decoding="async" onerror="this.onerror=null;this.src='{{ $defaultAvatarDataUri }}';">
                                            <span>{{ $displayName }}</span>
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button"
                                                class="assessor-icon-btn"
                                                data-assessor-btn="1"
                                                data-sup="{{ e($supLine) }}"
                                                data-div="{{ e($divLine) }}"
                                                title="{{ $assessorModalTitle }}">
                                            <i class="bi bi-person-lines-fill"></i>
                                            <span style="font-weight:600;">{{ $assessorBtnLabel }}</span>
                                        </button>
                                    </td>
                                    <td>{{ $empTypeText }}</td>
                                    <td>{{ $position }}</td>
                                    <td>
                                        <span class="dept-full">{{ $deptFull }}</span>
                                        @if($abbr)
                                            <span class="dept-abbr">({{ $abbr }})</span>
                                        @endif
                                    </td>

                                    <td>{{ $finalScoreDiv !== null ? $finalScoreDiv : '-' }}</td>

                                    <td>
                                        @if($statusValue)
                                            <span class="status-inline">
                                                <span class="status-dot {{ $hasDivScore ? 'green' : 'red' }}"></span>
                                                <span>{{ $statusValue }}</span>
                                            </span>
                                        @else
                                            <span class="status-empty">&nbsp;</span>
                                        @endif
                                    </td>

                                    <td class="evaluate-cell">
                                        @if($showEvaluateButton)
                                            <a href="{{ route('assessment.employees.show', ['employee' => $emp->id, 'role' => 'division']) }}"
                                               class="btn-eval"
                                               title="{{ __('app.assess_employees_button_evaluate') }}">
                                                <i class="bi bi-clipboard-check"></i>
                                                <span>{{ __('app.assess_employees_button_evaluate') }}</span>
                                            </a>
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="bottom-actions">
                <div>
                    <a href="{{ route('profile') }}" class="btn-back">
                        <i class="bi bi-arrow-left-short"></i>
                        {{ __('app.assess_employees_back_profile') }}
                    </a>
                </div>
                <div></div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade criteria-modal" id="criteriaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content position-relative">
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            <img src="{{ $criteriaImg }}" alt="criteria" loading="lazy" decoding="async" onerror="this.onerror=null;this.src='{{ $defaultAvatarDataUri }}';">
        </div>
    </div>
</div>

<div class="modal fade" id="assessorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-emp-detail">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-person-lines-fill me-2"></i>
                    {{ $assessorModalTitle }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="assessor-lines">
                    <div class="assessor-line">
                        <div class="lbl">Supervisor:</div>
                        <div class="val" id="assessorSupVal">-</div>
                    </div>
                    <div class="assessor-line">
                        <div class="lbl">Division:</div>
                        <div class="val" id="assessorDivVal">-</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>
                    {{ $locale==='en' ? 'Close' : 'ปิด' }}
                </button>
            </div>
        </div>
    </div>
</div>

<div id="empHoverCard" class="emp-hover-card" style="display:none;">
    <div class="emp-hover-main">
        <div class="emp-hover-avatar-wrap">
            <img src="{{ $defaultAvatarDataUri }}" alt="avatar" class="emp-hover-avatar">
        </div>
        <div class="emp-hover-text">
            <div class="emp-hover-name"></div>
            <div class="emp-hover-code"></div>
            <div class="emp-hover-pos"></div>
            <div class="emp-hover-dept"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="empDetailModal" tabindex="-1" aria-labelledby="empDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-emp-detail">
            <div class="modal-header">
                <h5 class="modal-title" id="empDetailModalLabel">
                    <i class="bi bi-person-vcard me-2"></i>
                    <span id="empModalName">-</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="emp-modal-main">
                    <div class="emp-modal-avatar-wrap" id="empModalAvatarWrap">
                        <img src="{{ $defaultAvatarDataUri }}" alt="avatar large" id="empModalAvatar" class="emp-modal-avatar">
                    </div>
                    <div class="emp-modal-info">
                        <div class="emp-modal-info-row">
                            <div class="emp-modal-info-label">{{ $locale==='en' ? 'Employee ID' : 'รหัสพนักงาน' }}</div>
                            <div class="emp-modal-info-value" id="empModalCode">-</div>
                        </div>
                        <div class="emp-modal-info-row">
                            <div class="emp-modal-info-label">{{ $locale==='en' ? 'Full name' : 'ชื่อ-สกุล' }}</div>
                            <div class="emp-modal-info-value" id="empModalNameValue">-</div>
                        </div>
                        <div class="emp-modal-info-row">
                            <div class="emp-modal-info-label">{{ $locale==='en' ? 'Position' : 'ตำแหน่ง' }}</div>
                            <div class="emp-modal-info-value" id="empModalPosition">-</div>
                        </div>
                        <div class="emp-modal-info-row">
                            <div class="emp-modal-info-label">{{ $locale==='en' ? 'Department' : 'แผนก' }}</div>
                            <div class="emp-modal-info-value" id="empModalDept">-</div>
                        </div>
                        <div class="emp-modal-info-row">
                            <div class="emp-modal-info-label">{{ $locale==='en' ? 'Employee type' : 'ประเภทการจ้าง' }}</div>
                            <div class="emp-modal-info-value" id="empModalType">-</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>
                    {{ $locale==='en' ? 'Close' : 'ปิด' }}
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="empPhotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body p-0 d-flex justify-content-center align-items-center position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <img src="{{ $defaultAvatarDataUri }}" alt="employee photo" id="empPhotoModalImg" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const THEME_STORAGE_KEY = 'supavut_theme_mode';
    const toggle = document.getElementById('themeToggle');
    const iconEl = document.getElementById('themeIcon');

    function applyTheme(theme) {
        const mode = (theme === 'light') ? 'light' : 'dark';
        if (mode === 'dark') {
            document.documentElement.classList.add('dark-mode');
            if (toggle) toggle.checked = true;
        } else {
            document.documentElement.classList.remove('dark-mode');
            if (toggle) toggle.checked = false;
        }
        if (iconEl) iconEl.className = 'bi ' + (mode === 'dark' ? 'bi-moon-stars' : 'bi-sun');
        try { localStorage.setItem(THEME_STORAGE_KEY, mode); } catch (e) {}
    }

    function getInitialTheme() {
        try {
            const saved = localStorage.getItem(THEME_STORAGE_KEY);
            if (saved === 'dark' || saved === 'light') return saved;
        } catch (e) {}
        return 'dark';
    }

    applyTheme(getInitialTheme());
    if (toggle) toggle.addEventListener('change', function () { applyTheme(this.checked ? 'dark' : 'light'); });

    (function () {
        const OFFLINE_MESSAGE = @json(__('app.offline_alert') ?? 'คุณออฟไลน์อยู่ กรุณาตรวจสอบการเชื่อมต่ออินเทอร์เน็ต');
        const OFFLINE_URL = @json(route('offline'));

        function goOfflinePage() {
            if (window.__supavutOfflineHandled) return;
            window.__supavutOfflineHandled = true;
            alert(OFFLINE_MESSAGE);
            window.location.href = OFFLINE_URL;
        }

        if (!navigator.onLine) goOfflinePage();
        window.addEventListener('offline', goOfflinePage);
    })();

    const DEFAULT_AVATAR = @json($defaultAvatarDataUri);

    function setSafeImg(el, src){
        if (!el) return;
        const wanted = (src && String(src).trim() !== '') ? String(src) : DEFAULT_AVATAR;
        if (el.dataset.lastSrc === wanted) return;
        el.dataset.lastSrc = wanted;
        el.onerror = null;
        el.src = wanted;
        el.onerror = function(){
            this.onerror = null;
            this.dataset.lastSrc = DEFAULT_AVATAR;
            this.src = DEFAULT_AVATAR;
        };
    }

    const hoverCard = document.getElementById('empHoverCard');
    const rows = document.querySelectorAll('tr[data-emp-row="1"]');

    const locale = @json(app()->getLocale());
    const LBL_CODE = locale === 'en' ? 'Employee ID: ' : 'รหัสพนักงาน: ';
    const LBL_POS  = locale === 'en' ? 'Position: '    : 'ตำแหน่ง: ';
    const LBL_DEPT = locale === 'en' ? 'Department: '  : 'แผนก: ';
    const LBL_TYPE = locale === 'en' ? 'Type: '        : 'ประเภท: ';

    function clamp(n, min, max){ return Math.max(min, Math.min(max, n)); }

    function showHoverCard(row, e){
        if (!hoverCard) return;

        const name = row.dataset.name || '-';
        const code = row.dataset.code || '-';
        const pos  = row.dataset.position || '-';
        const dept = row.dataset.dept || '-';
        const abbr = row.dataset.abbr || '';
        const type = row.dataset.type || '-';
        const avatar = row.dataset.avatar || '';

        hoverCard.style.display = 'block';

        const imgEl = hoverCard.querySelector('.emp-hover-avatar');
        setSafeImg(imgEl, avatar);

        hoverCard.querySelector('.emp-hover-name').textContent = name;
        hoverCard.querySelector('.emp-hover-code').textContent = LBL_CODE + code + '  •  ' + LBL_TYPE + type;
        hoverCard.querySelector('.emp-hover-pos').textContent = LBL_POS + pos;

        const deptText = abbr ? (dept + ' (' + abbr + ')') : dept;
        hoverCard.querySelector('.emp-hover-dept').textContent = LBL_DEPT + deptText;

        requestAnimationFrame(() => hoverCard.classList.add('visible'));

        const pad = 14;
        const rect = hoverCard.getBoundingClientRect();
        const x = clamp(e.clientX + 16, pad, window.innerWidth - rect.width - pad);
        const y = clamp(e.clientY + 16, pad, window.innerHeight - rect.height - pad);

        hoverCard.style.left = x + 'px';
        hoverCard.style.top  = y + 'px';
    }

    function hideHoverCard(){
        if (!hoverCard) return;
        hoverCard.classList.remove('visible');
        setTimeout(() => {
            hoverCard.style.display = 'none';
        }, 120);
    }

    const empModal = document.getElementById('empDetailModal');
    const empModalInst = empModal ? new bootstrap.Modal(empModal) : null;

    const photoModal = document.getElementById('empPhotoModal');
    const photoModalInst = photoModal ? new bootstrap.Modal(photoModal) : null;

    function openDetailModal(row){
        if (!empModalInst) return;

        const name = row.dataset.name || '-';
        const code = row.dataset.code || '-';
        const pos  = row.dataset.position || '-';
        const dept = row.dataset.dept || '-';
        const abbr = row.dataset.abbr || '';
        const type = row.dataset.type || '-';
        const avatar = row.dataset.avatar || '';

        document.getElementById('empModalName').textContent = name;
        document.getElementById('empModalNameValue').textContent = name;
        document.getElementById('empModalCode').textContent = code;
        document.getElementById('empModalPosition').textContent = pos;
        document.getElementById('empModalDept').textContent = abbr ? (dept + ' (' + abbr + ')') : dept;
        document.getElementById('empModalType').textContent = type;

        const img = document.getElementById('empModalAvatar');
        setSafeImg(img, avatar);

        empModalInst.show();
    }

    const assessorModalEl = document.getElementById('assessorModal');
    const assessorModalInst = assessorModalEl ? new bootstrap.Modal(assessorModalEl) : null;

    function openAssessorModal(btn){
        if (!assessorModalInst) return;
        const sup = (btn.dataset.sup || '').trim() || '-';
        const div = (btn.dataset.div || '').trim() || '-';
        const supEl = document.getElementById('assessorSupVal');
        const divEl = document.getElementById('assessorDivVal');
        if (supEl) supEl.textContent = sup;
        if (divEl) divEl.textContent = div;
        assessorModalInst.show();
    }

    function isClickOnAction(e){
        const a = e.target.closest('a.btn-eval');
        if (a) return true;
        const cell = e.target.closest('td.evaluate-cell');
        if (cell) return true;
        const assessorBtn = e.target.closest('button.assessor-icon-btn');
        if (assessorBtn) return true;
        return false;
    }

    rows.forEach(row => {
        row.addEventListener('mouseenter', (e) => showHoverCard(row, e));
        row.addEventListener('mousemove',  (e) => showHoverCard(row, e));
        row.addEventListener('mouseleave', () => hideHoverCard());

        row.addEventListener('click', (e) => {
            if (isClickOnAction(e)) return;
            openDetailModal(row);
        });
    });

    document.querySelectorAll('button.assessor-icon-btn[data-assessor-btn="1"]').forEach(btn => {
        btn.addEventListener('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            openAssessorModal(this);
        });
    });

    const avatarWrap = document.getElementById('empModalAvatarWrap');
    if (avatarWrap) {
        avatarWrap.addEventListener('click', function () {
            const img = document.getElementById('empModalAvatar');
            const big = document.getElementById('empPhotoModalImg');
            if (!img || !big || !photoModalInst) return;
            const src = img.dataset.lastSrc || img.src || DEFAULT_AVATAR;
            setSafeImg(big, src);
            photoModalInst.show();
        });
    }
});
</script>
</body>
</html>
