<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('app.profile_title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f5f7fb;
            --card-bg: #ffffff;
            --primary: #1e3a8a;
            --primary-soft: rgba(30, 58, 138, 0.08);
            --border-soft: rgba(148, 163, 184, 0.45);
            --text-main: #111827;
            --text-muted: #6b7280;
            --accent: #e0b761;
            --accent-soft: rgba(224,183,97,0.12);
            --glass-bg: rgba(248,250,252,0.96);
        }

        body.dark-mode {
            --bg: #020617;
            --card-bg: #020617;
            --primary: #e0b761;
            --primary-soft: rgba(224,183,97,0.16);
            --border-soft: rgba(148,163,184,0.7);
            --text-main: #e5e7eb;
            --text-muted: #9ca3af;
            --glass-bg: rgba(15,23,42,0.96);
        }

        * { box-sizing: border-box; }

        body{
            margin: 0;
            min-height: 100vh;
            font-family: 'Prompt', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            color: var(--text-main);
            transition: background-color .25s ease, color .25s ease;
            position: relative;
            isolation: isolate;
        }

        body::before{
            content:"";
            position: fixed;
            inset: 0;
            z-index: -2;
            background-image: url('{{ asset('images/pb-bg-02.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            transform: scale(1.03);
            opacity: 0.38;
            filter: saturate(1.08) contrast(1.05);
            pointer-events: none;
        }
        body.dark-mode::before{
            opacity: 0.22;
            filter: saturate(1.02) contrast(1.08);
        }

        body::after{
            content:"";
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            background:
                radial-gradient(circle at top, rgba(56,189,248,0.16) 0, transparent 55%),
                radial-gradient(circle at bottom, rgba(234,179,8,0.18) 0, transparent 60%),
                linear-gradient(180deg, rgba(255,255,255,0.62), rgba(255,255,255,0.72));
        }
        body.dark-mode::after{
            background:
                radial-gradient(circle at top, rgba(56,189,248,0.14) 0, transparent 55%),
                radial-gradient(circle at bottom, rgba(234,179,8,0.16) 0, transparent 60%),
                linear-gradient(180deg, rgba(2,6,23,0.45), rgba(2,6,23,0.72));
        }

        .corner-tools{
            position: fixed;
            top: 12px;
            right: 12px;
            z-index: 80;
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .lang-switch {
            display: inline-flex;
            padding: 4px 6px;
            border-radius: 999px;
            background: var(--glass-bg);
            border: 1px solid var(--border-soft);
            backdrop-filter: blur(10px) saturate(140%);
            -webkit-backdrop-filter: blur(10px) saturate(140%);
            box-shadow: 0 10px 24px rgba(15,23,42,0.35);
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
            transition: background-color .16s ease, color .16s ease, box-shadow .16s ease, transform .08s ease;
        }
        .lang-btn-square[data-active="true"] {
            background: linear-gradient(135deg,#facc6b,#e0b761);
            color: #111827;
            border-color: rgba(250,204,21,0.9);
            box-shadow: 0 6px 16px rgba(250,204,21,0.38), inset 0 0 0 1px rgba(255,255,255,0.7);
        }
        .lang-btn-square:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(15,23,42,0.45); }
        .lang-btn-square[data-active="true"]:hover { box-shadow: 0 7px 18px rgba(250,204,21,0.55); }

        .theme-toggle-box {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--text-muted);
            padding: 4px 10px;
            background: var(--glass-bg);
            border-radius: 999px;
            border: 1px solid var(--border-soft);
            backdrop-filter: blur(10px) saturate(140%);
            -webkit-backdrop-filter: blur(10px) saturate(140%);
            box-shadow: 0 10px 24px rgba(15,23,42,0.35);
        }
        .theme-toggle-box .form-check-input { cursor: pointer; }

        .page-wrap { width: 100%; max-width: 960px; }

        .profile-card {
            background: var(--card-bg);
            border-radius: 22px;
            padding: 22px 22px 20px;
            border: 1px solid var(--border-soft);
            box-shadow:
                0 22px 50px rgba(15, 23, 42, 0.45),
                0 0 0 1px rgba(255, 255, 255, 0.04);
            position: relative;
            overflow: hidden;
        }

        body.dark-mode .profile-card {
            box-shadow:
                0 26px 60px rgba(15, 23, 42, 0.9),
                0 0 0 1px rgba(148, 163, 184, 0.35);
        }

        .profile-card::before {
            content: "";
            position: absolute;
            inset: -40%;
            background:
                radial-gradient(circle at 0 0, rgba(56,189,248,0.18), transparent 55%),
                radial-gradient(circle at 100% 100%, rgba(234,179,8,0.20), transparent 55%);
            opacity: 0.55;
            pointer-events: none;
        }

        .profile-inner { position: relative; z-index: 1; }

        .brand-row{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 12px;
            margin-bottom: 10px;
        }

        .brand-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cycle-inline{
            font-size: .9rem;
            font-weight: 900;
            letter-spacing: .01em;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .avatar-wrap { display: flex; align-items: center; gap: 16px; margin-top: 10px; }
        .avatar-img {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            border: 2px solid rgba(255,255,255,0.8);
            box-shadow: 0 10px 24px rgba(15,23,42,0.45);
            background: #e5e7eb;
            overflow: hidden;
            cursor: pointer;
        }
        .avatar-img img, .avatar-img svg { width: 100%; height: 100%; object-fit: cover; display: block; }
        body.dark-mode .avatar-img { border-color: rgba(148,163,184,0.65); background: #020617; }

        .avatar-modal-box {
            max-width: 320px;
            width: 100%;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 22px 50px rgba(15,23,42,0.85), 0 0 0 1px rgba(255,255,255,0.06);
        }
        .avatar-modal-box img, .avatar-modal-box svg { width: 100%; height: auto; display: block; }

        .user-main-code { font-size: 1.2rem; font-weight: 600; margin-bottom: 2px; }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            padding: 3px 10px;
            border-radius: 999px;
            border: 1px solid rgba(148,163,184,0.6);
            background: rgba(15,23,42,0.02);
        }
        body.dark-mode .role-badge { background: rgba(15,23,42,0.8); }
        .role-dot { width: 7px; height: 7px; border-radius: 999px; background: #22c55e; }
        .role-admin {
            background: linear-gradient(135deg,#facc6b,#e0b761);
            border-color: rgba(250,204,21,0.9);
            color: #111827;
        }
        .role-admin .role-dot { background: #f97316; }
        body.dark-mode .role-admin { color: #f9fafb; }

        .info-section {
            margin-top: 18px;
            padding: 14px 16px;
            border-radius: 16px;
            background: var(--glass-bg);
            border: 1px solid var(--border-soft);
        }
        .info-title {
            font-size: 0.88rem;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0,1fr));
            gap: 8px 20px;
            font-size: 0.9rem;
        }
        .info-label {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--text-muted);
        }
        .info-value { font-weight: 500; }

        .btn-area {
            margin-top: 18px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .btn-assess-base {
            border-radius: 999px;
            padding: 0.55rem 1.3rem;
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
        }
        .btn-assess-self {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #f9fafb;
            box-shadow: 0 10px 24px rgba(37,99,235,0.45);
        }
        .btn-assess-self:hover { filter: brightness(1.05); box-shadow: 0 12px 28px rgba(37,99,235,0.55); }

        .btn-assess-employees {
            background: linear-gradient(135deg,#facc6b,#e0b761);
            color: #111827;
            box-shadow: 0 10px 24px rgba(250,204,21,0.45);
        }
        .btn-assess-employees:hover { filter: brightness(1.03); box-shadow: 0 12px 28px rgba(250,204,21,0.6); }

        .btn-assess-summary {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #ecfdf5;
            border: 1px solid rgba(34,197,94,0.95);
            box-shadow: 0 10px 26px rgba(22,163,74,0.55), 0 0 0 1px rgba(187,247,208,0.35);
        }
        .btn-assess-summary::before {
            content: "";
            position: absolute;
            inset: -40%;
            background: linear-gradient(120deg, rgba(240,253,250,0.0) 0%, rgba(187,247,208,0.45) 40%, rgba(240,253,250,0.0) 80%);
            opacity: 0;
            transform: translate3d(-10%, 0, 0) skewX(-15deg);
            transition: opacity .25s ease, transform .25s ease;
        }
        .btn-assess-summary:hover {
            filter: brightness(1.06);
            box-shadow: 0 14px 32px rgba(22,163,74,0.8), 0 0 0 1px rgba(187,247,208,0.6);
        }
        .btn-assess-summary:hover::before {
            opacity: 0.45;
            transform: translate3d(10%, 0, 0) skewX(-15deg);
        }

        .btn-edit {
            border-radius: 999px;
            padding: 0.55rem 1.1rem;
            font-size: 0.9rem;
            font-weight: 500;
            border: 1px solid var(--border-soft);
            background: rgba(15,23,42,0.02);
            color: var(--text-main);
        }
        body.dark-mode .btn-edit { background: rgba(15,23,42,0.9); }
        .btn-edit:hover { background: rgba(148,163,184,0.1); }

        .btn-logout {
            border-radius: 999px;
            padding: 0.55rem 1.1rem;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            background: #ef4444;
            color: #fef2f2;
        }
        .btn-logout:hover { filter: brightness(1.05); }

        .btn-upload {
            border-radius: 999px;
            padding: 0.55rem 1.4rem;
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            background: var(--accent);
            color: #111827;
            box-shadow: 0 10px 24px rgba(250,204,21,0.35);
        }
        .btn-upload:hover { filter: brightness(1.03); }

        .btn-admin-cycle{
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #f9fafb;
            box-shadow: 0 10px 24px rgba(37,99,235,0.42);
        }
        .btn-admin-cycle:hover{ filter: brightness(1.05); box-shadow: 0 12px 28px rgba(37,99,235,0.55); }

        .btn-admin-download{
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #ecfdf5;
            box-shadow: 0 10px 26px rgba(22,163,74,0.48);
            border: 1px solid rgba(34,197,94,0.95);
        }
        .btn-admin-download:hover{ filter: brightness(1.06); box-shadow: 0 14px 32px rgba(22,163,74,0.72); }

        .footer-text {
            margin-top: 18px;
            font-size: 0.78rem;
            color: var(--text-muted);
            text-align: right;
        }

        .app-switch-loader{
            position: fixed;
            inset: 0;
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 18px;
            background: rgba(255,255,255,0.98);
        }
        .app-switch-loader.show{ display:flex; }

        .loader-stage{
            width: min(520px, 94vw);
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            gap: 14px;
            text-align:center;
        }

        .dl-frame{
            width: 190px;
            height: 190px;
            border-radius: 999px;
            overflow:hidden;
            position:relative;
            background:#ffffff;
            box-shadow: 0 26px 72px rgba(2,6,23,.16);
        }
        .dl-frame img{
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
            border-radius: 999px;
            background:#ffffff;
            transform: scale(1.01);
        }

        .dl-ring{
            position:absolute;
            inset: -18px;
            width: calc(100% + 36px);
            height: calc(100% + 36px);
            pointer-events:none;
            opacity: .95;
            filter: drop-shadow(0 12px 18px rgba(0,0,0,.10));
            animation: ringSpin 2.6s linear infinite;
        }
        .dl-ring circle{
            fill:none;
            stroke:#111827;
            stroke-width: 4.5;
            stroke-linecap: round;
            stroke-dasharray: 430 148;
            animation: ringDash 1.25s linear infinite;
        }
        @keyframes ringDash{
            to{ stroke-dashoffset: -578; }
        }
        @keyframes ringSpin{
            to{ transform: rotate(360deg); }
        }

        .loader-text{
            font-weight: 1000;
            font-size: 1.06rem;
            letter-spacing: .01em;
            color: #111827;
        }
        .loader-count{
            font-weight: 1100;
            font-size: 2.8rem;
            line-height: 1;
            color: #111827;
            letter-spacing: .02em;
            min-height: 2.8rem;
        }
        .count-pop{
            animation: pop .26s ease;
        }
        @keyframes pop{
            0%{ transform: scale(.86); opacity:.45; }
            60%{ transform: scale(1.08); opacity:1; }
            100%{ transform: scale(1); opacity:1; }
        }

        .welcome-modal .modal-content{
            background:#ffffff !important;
            color:#111827 !important;
            border:1px solid rgba(148,163,184,.55) !important;
            border-radius: 22px;
            overflow:hidden;
            box-shadow: 0 26px 70px rgba(2,6,23,.28);
        }
        .welcome-modal .modal-header,
        .welcome-modal .modal-footer{
            background:#ffffff !important;
            border-color: rgba(148,163,184,.45) !important;
        }
        .welcome-modal .modal-content *{
            color:#111827 !important;
        }
        .welcome-modal .btn-close{
            filter:none !important;
            opacity:.75;
        }

        .wm-body{
            padding: 18px 18px 16px;
            text-align:center;
            background:#ffffff !important;
        }
        .wm-logo{
            width: 132px;
            height: 132px;
            margin: 4px auto 10px;
            border-radius: 999px;
            overflow:hidden;
            background:#ffffff;
            border: 1px solid rgba(148,163,184,.55);
            box-shadow: 0 18px 46px rgba(2,6,23,.12);
        }
        .wm-logo img{
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
            border-radius: 999px;
        }
        .wm-title{
            font-weight: 1000;
            font-size: 1.10rem;
            letter-spacing: .01em;
            line-height: 1.2;
        }

        @media (max-width: 768px) {
            .profile-card { padding: 18px 16px 16px; }
            .info-grid { grid-template-columns: minmax(0,1fr); }
            .btn-area { flex-direction: column; align-items: stretch; }
            .btn-area > * { width: 100%; text-align: center; }
            .dl-frame{ width:170px; height:170px; }
            .corner-tools{ top:10px; right:10px; gap:6px; }
        }
    </style>
</head>
<body>

<script>
(function () {
    try {
        const saved = localStorage.getItem('supavut_theme_mode');
        const mode = (saved === 'light' || saved === 'dark') ? saved : 'dark';
        if (mode === 'dark') document.body.classList.add('dark-mode');
        else document.body.classList.remove('dark-mode');
        if (!saved) localStorage.setItem('supavut_theme_mode', mode);
    } catch (e) {
        document.body.classList.add('dark-mode');
    }
})();
</script>

<div class="corner-tools">
    <div class="lang-switch" aria-label="Language switcher">
        <form id="localeForm" action="{{ route('locale.switch') }}" method="POST">
            @csrf
            <input type="hidden" name="locale" id="localeInput">
            <button type="button" class="lang-btn-square" data-locale="th" data-active="{{ app()->getLocale()==='th' ? 'true' : 'false' }}">TH</button>
            <button type="button" class="lang-btn-square" data-locale="en" data-active="{{ app()->getLocale()==='en' ? 'true' : 'false' }}">EN</button>
        </form>
    </div>

    <div class="theme-toggle-box">
        <i class="bi bi-moon-stars"></i>
        <div class="form-check form-switch m-0">
            <input class="form-check-input" type="checkbox" id="themeToggle">
        </div>
        <span>{{ __('app.profile_dark_mode') }}</span>
    </div>
</div>

<div id="appSwitchLoader" class="app-switch-loader" aria-hidden="true">
    <div class="loader-stage" role="status" aria-live="polite">
        <div class="dl-frame" aria-label="logo">
            <img src="{{ asset('images/welcomeweb.jpg') }}" alt="Supavut Logo">
            <svg class="dl-ring" viewBox="0 0 220 220" aria-hidden="true">
                <circle cx="110" cy="110" r="92"></circle>
            </svg>
        </div>

        <div class="loader-text" id="loaderMainText">กำลังเข้าสู่ ...</div>
        <div class="loader-count" id="loaderCount">3</div>
    </div>
</div>

@php
    $user    = Auth::user();
    $isAdmin = $user && $user->role === 'admin';

    $hasAvatar  = $user && !empty($user->profile_picture);
    $avatarPath = $hasAvatar ? asset('storage/' . $user->profile_picture) : null;

    $employeeCode = $user->username ?? __('app.profile_unknown');
    $employee = $user?->employee ?? null;

    $empFullName = null;
    if (app()->getLocale() === 'en') {
        $empFullName = $employee?->full_name_en ?: ($employee?->full_name_th ?: null);
    } else {
        $empFullName = $employee?->full_name_th ?: ($employee?->full_name_en ?: null);
    }

    $firstName = $user->name ?? null;
    $lastName  = $user->lastname ?? null;

    $displayFullName = $empFullName ?: trim(($firstName ?? '') . ' ' . ($lastName ?? ''));
    if ($displayFullName === '') $displayFullName = __('app.profile_fallback_name');

    $positionRaw   = $employee?->position ?: ($user->position ?? __('app.profile_unknown'));

    $positionDisplay = preg_replace('/\bStaff\b/i', '', (string)$positionRaw);
    $positionDisplay = preg_replace('/\s+/', ' ', trim($positionDisplay));
    if ($positionDisplay === '') $positionDisplay = (string)$positionRaw;

    $departmentRaw = $employee?->department ?: ($user->department ?? __('app.profile_unknown'));

    $deptQms = $employee?->dept_abbr_qms;
    $deptHr  = $employee?->dept_abbr_hr;

    if ($deptQms && $deptHr) {
        $departmentDisplay = ($deptQms === $deptHr) ? $deptQms : ($deptQms . ' / ' . $deptHr);
    } else {
        $departmentDisplay = $deptQms ?: ($deptHr ?: $departmentRaw);
    }
    if (!$departmentDisplay) $departmentDisplay = $departmentRaw;

    $posLevel = (int) ($employee?->position_level ?? 0);
    $isExecutiveLevel = in_array($posLevel, [
        \App\Models\Employee::LEVEL_CFO,
        \App\Models\Employee::LEVEL_CEO,
        \App\Models\Employee::LEVEL_PRESIDENT,
    ], true);

    $pNorm = \App\Models\Employee::normalizePosition($positionRaw) ?? '';
    $isExecutiveByName = in_array($pNorm, [
        'cfo','ceo','chief financial officer','chief executive officer','president',
    ], true);

    $isExecutive = (!$isAdmin) && ($isExecutiveLevel || $isExecutiveByName);

    if ($isAdmin) {
        $badgeText = __('app.profile_role_admin');
        $badgeIcon = 'bi-shield-lock';
    } elseif ($isExecutive) {
        $badgeText = strtoupper($pNorm) === 'CFO' ? 'CFO' : (strtoupper($pNorm) === 'CEO' ? 'CEO' : (ucfirst($pNorm) ?: 'Executive'));
        if ($pNorm === 'chief financial officer') $badgeText = 'CFO';
        if ($pNorm === 'chief executive officer') $badgeText = 'CEO';
        if ($pNorm === 'president') $badgeText = 'President';
        $badgeIcon = 'bi-award';
    } else {
        $badgeText = '';
        $badgeIcon = '';
    }

    $canSelf        = $user && method_exists($user, 'canEvaluateSelf') ? $user->canEvaluateSelf() : false;

    $SHOW_SELF_ASSESS_BUTTON = false;

    $canEvalEmp     = $user && method_exists($user, 'canEvaluateEmployees') ? $user->canEvaluateEmployees() : false;
    $canViewEvalEmp = $user && method_exists($user, 'canViewEmployeesEvaluation') ? $user->canViewEmployeesEvaluation() : false;

    $activeCycle = \App\Models\Cycle::active();
    $cycleEnd    = $activeCycle?->end_date;

    $fmtTh = function ($d) { return $d ? $d->format('d/m/Y') : null; };
    $fmtEn = function ($d) { return $d ? $d->format('M d, Y') : null; };

    $endTxt = (app()->getLocale()==='en') ? $fmtEn($cycleEnd) : $fmtTh($cycleEnd);
@endphp

<div class="page-wrap">
    <div class="profile-card">
        <div class="profile-inner">

            <div class="brand-row">
                <div class="brand-title">
                    <i class="bi bi-bar-chart-line-fill"></i>
                    {{ __('app.profile_brand') }}
                </div>

                <div class="cycle-inline">
                    @if($cycleEnd)
                        @if(app()->getLocale()==='en')
                            Cycle closes on {{ $endTxt }} 23:59
                        @else
                            วันปิดรอบ: {{ $endTxt }} 23:59
                        @endif
                    @else
                        @if(app()->getLocale()==='en')
                            No cycle is open yet
                        @else
                            ยังไม่เปิดรอบ
                        @endif
                    @endif
                </div>
            </div>

            <div class="avatar-wrap">
                <div class="avatar-img" role="button" data-bs-toggle="modal" data-bs-target="#avatarModal" aria-label="View profile picture">
                    @if($hasAvatar)
                        <img src="{{ $avatarPath }}" alt="Avatar">
                    @else
                        <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="avatarGrad" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0%" stop-color="#9ca3af"/>
                                    <stop offset="100%" stop-color="#4b5563"/>
                                </linearGradient>
                            </defs>
                            <rect x="0" y="0" width="80" height="80" rx="18" fill="#e5e7eb"/>
                            <circle cx="40" cy="28" r="14" fill="url(#avatarGrad)"/>
                            <path d="M15 66c3-13 13-21 25-21s22 8 25 21" fill="url(#avatarGrad)"/>
                        </svg>
                    @endif
                </div>

                <div class="flex-grow-1">
                    <div class="user-main-code">
                        {{ app()->getLocale()==='en' ? 'Number:' : 'หมายเลขที่:' }} {{ $employeeCode }}
                    </div>

                    @if($badgeText !== '')
                        <div class="mt-1">
                            <span class="role-badge {{ $isAdmin ? 'role-admin' : '' }}">
                                <span class="role-dot"></span>
                                <i class="bi {{ $badgeIcon }} me-1"></i> {{ $badgeText }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="info-section mt-3">
                <div class="info-title w-100">
                    <i class="bi bi-card-list"></i>
                    <span>{{ __('app.profile_employee_info_title') }}</span>
                </div>
                <div class="info-grid">
                    <div>
                        <div class="info-label">{{ app()->getLocale() === 'en' ? 'Full name' : 'ชื่อ-สกุล' }}</div>
                        <div class="info-value">{{ $displayFullName }}</div>
                    </div>

                    <div>
                        <div class="info-label">{{ __('app.profile_position') }}</div>
                        <div class="info-value">{{ $positionDisplay }}</div>
                    </div>

                    <div>
                        <div class="info-label">{{ app()->getLocale() === 'en' ? 'Department' : 'แผนก' }}</div>
                        <div class="info-value">{{ $departmentDisplay }}</div>
                    </div>
                </div>
            </div>

            <div class="btn-area">
                @if(!$isAdmin)
                    @if($SHOW_SELF_ASSESS_BUTTON && $canSelf && !$isExecutive)
                        <a href="{{ url('/assessment') }}" class="btn-assess-base btn-assess-self">
                            <i class="bi bi-clipboard-check me-1"></i>
                            {{ __('app.profile_button_assessment_self') ?? 'ประเมินตัวเอง' }}
                        </a>
                    @endif

                    @if($canEvalEmp || $isExecutive)
                        <a href="{{ url('/assessment/employees') }}" class="btn-assess-base btn-assess-employees">
                            <i class="bi bi-people-fill me-1"></i>
                            {{ __('app.profile_button_assessment_employees') ?? 'ประเมินพนักงาน' }}
                        </a>
                    @endif

                    @if($canViewEvalEmp)
                        <a href="{{ url('/assessment/overview') }}" class="btn-assess-base btn-assess-summary">
                            <i class="bi bi-graph-up-arrow me-1"></i>
                            {{ __('app.profile_button_view_evaluations') ?? 'ดูผลสรุป' }}
                        </a>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="btn btn-edit">
                        <i class="bi bi-pencil-square me-1"></i>
                        {{ __('app.profile_button_edit') }}
                    </a>
                @else
                    <a href="{{ route('employees.import.form') }}" class="btn btn-upload">
                        <i class="bi bi-file-earmark-spreadsheet me-1"></i>
                        {{ __('app.profile_button_upload_excel') }}
                    </a>

                    <a href="{{ route('admin.cycles') }}" class="btn-assess-base btn-admin-cycle">
                        <i class="bi bi-calendar2-range me-1"></i>
                        {{ app()->getLocale()==='en' ? 'Set Cycle' : 'กำหนดรอบ' }}
                    </a>

                    <a href="{{ route('admin.results.download') }}" class="btn-assess-base btn-admin-download">
                        <i class="bi bi-download me-1"></i>
                        {{ app()->getLocale()==='en' ? 'Download Results' : 'ดาวน์โหลดผล' }}
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="ms-auto">
                    @csrf
                    <button type="submit" class="btn btn-logout">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        {{ __('app.profile_button_logout') }}
                    </button>
                </form>
            </div>

            <div class="footer-text">
                © {{ date('Y') }} Supavut Industry • {{ __('app.profile_footer') }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade welcome-modal" id="welcomeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <div class="fw-bold">
                    <i class="bi bi-stars me-1"></i>
                    {{ app()->getLocale()==='en' ? 'Welcome' : 'ยินดีต้อนรับ' }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="wm-body">
                <div class="wm-logo">
                    <img src="{{ asset('images/welcomeweb.jpg') }}" alt="Welcome">
                </div>
                <div class="wm-title">
                    {{ app()->getLocale()==='en'
                        ? 'Welcome to Supavut Assessment'
                        : 'ยินดีต้อนรับสู่เว็บ Supavut Assessment' }}
                </div>
            </div>

            <div class="modal-footer py-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal"
                        style="border-color: rgba(148,163,184,.55); color:#111827;">
                    {{ app()->getLocale()==='en' ? 'Close' : 'ปิด' }}
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: transparent; border: none;">
            <div class="modal-body d-flex justify-content-center">
                <div class="avatar-modal-box">
                    @if($hasAvatar)
                        <img src="{{ $avatarPath }}" alt="Avatar large">
                    @else
                        <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="avatarGradBig" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0%" stop-color="#9ca3af"/>
                                    <stop offset="100%" stop-color="#4b5563"/>
                                </linearGradient>
                            </defs>
                            <rect x="0" y="0" width="80" height="80" rx="20" fill="#e5e7eb"/>
                            <circle cx="40" cy="28" r="14" fill="url(#avatarGradBig)"/>
                            <path d="M15 66c3-13 13-21 25-21s22 8 25 21" fill="url(#avatarGradBig)"/>
                        </svg>
                    @endif
                </div>
            </div>
            <button type="button"
                    class="btn btn-sm btn-light position-absolute top-0 end-0 m-3"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const THEME_STORAGE_KEY = 'supavut_theme_mode';
    const toggle = document.getElementById('themeToggle');

    const loader = document.getElementById('appSwitchLoader');
    const loaderText = document.getElementById('loaderMainText');
    const loaderCount = document.getElementById('loaderCount');

    function applyTheme(theme) {
        const mode = (theme === 'light') ? 'light' : 'dark';
        if (mode === 'dark') {
            document.body.classList.add('dark-mode');
            if (toggle) toggle.checked = true;
        } else {
            document.body.classList.remove('dark-mode');
            if (toggle) toggle.checked = false;
        }
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

    if (toggle) {
        toggle.addEventListener('change', function () {
            applyTheme(this.checked ? 'dark' : 'light');
        });
    }

    function showLoader(mainText){
        if (loaderText) loaderText.textContent = mainText || 'กำลังเข้าสู่...';
        if (loaderCount) loaderCount.textContent = '3';
        if (loader) loader.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function popCount(){
        if (!loaderCount) return;
        loaderCount.classList.remove('count-pop');
        void loaderCount.offsetWidth;
        loaderCount.classList.add('count-pop');
    }

    function startCountdown(seconds, onDone){
        let n = seconds;
        if (loaderCount) loaderCount.textContent = String(n);
        popCount();

        const t = setInterval(function(){
            n -= 1;
            if (n <= 0) {
                clearInterval(t);
                onDone && onDone();
                return;
            }
            if (loaderCount) loaderCount.textContent = String(n);
            popCount();
        }, 1000);
    }

    function runSwitch(url, targetName){
        const msg = 'กำลังเข้าสู่ ' + targetName + '...';
        showLoader(msg);

        window.__switchingNow = true;
        startCountdown(3, function(){
            window.location.href = url;
        });
    }

    document.querySelectorAll('a[data-switch-to]').forEach(function(a){
        a.addEventListener('click', function(e){
            e.preventDefault();
            if (window.__switchingNow) return;

            const to = (this.getAttribute('data-switch-to') || '').toLowerCase();
            const url = this.href;

            if (to === 'pb') runSwitch(url, 'Supavut Penalty & Bonus');
            else runSwitch(url, 'Supavut Assessment');
        });
    });

    const form = document.getElementById('localeForm');
    const input = document.getElementById('localeInput');
    if (form && input) {
        form.querySelectorAll('.lang-btn-square').forEach(btn => {
            btn.addEventListener('click', () => {
                input.value = btn.dataset.locale;
                form.submit();
            });
        });
    }

    const WELCOME_FLAG_KEY = 'supavut_show_welcome_assessment';

    function getNavType(){
        try{
            const nav = performance.getEntriesByType && performance.getEntriesByType('navigation');
            if (nav && nav.length) return nav[0].type;
        }catch(e){}
        try{
            if (performance && performance.navigation) {
                const t = performance.navigation.type;
                if (t === 2) return 'back_forward';
                if (t === 1) return 'reload';
                return 'navigate';
            }
        }catch(e){}
        return 'navigate';
    }

    function consumeQuerySignal(){
        try{
            const u = new URL(window.location.href);
            const sp = u.searchParams;
            const hit =
                sp.get('welcome') === '1' ||
                sp.get('switched') === '1' ||
                (sp.get('from') || '').toLowerCase() === 'pb';

            if (hit) {
                sp.delete('welcome');
                sp.delete('switched');
                sp.delete('from');
                const clean = u.pathname + (sp.toString() ? ('?' + sp.toString()) : '') + u.hash;
                history.replaceState({}, '', clean);
                return true;
            }
        }catch(e){}
        return false;
    }

    function consumeSessionSignal(){
        try{
            const v = sessionStorage.getItem(WELCOME_FLAG_KEY);
            if (v === '1') {
                sessionStorage.removeItem(WELCOME_FLAG_KEY);
                return true;
            }
        }catch(e){}
        return false;
    }

    function referrerSignal(){
        try{
            const ref = (document.referrer || '').toLowerCase();
            return ref.includes('/pb/');
        }catch(e){}
        return false;
    }

    function shouldShowWelcomeModal(){
        const navType = getNavType();
        if (navType === 'back_forward') return false;
        return consumeQuerySignal() || consumeSessionSignal() || referrerSignal();
    }

    function showWelcomeModalOnce(){
        try {
            const wmEl = document.getElementById('welcomeModal');
            if (!wmEl) return;
            const wm = new bootstrap.Modal(wmEl, { backdrop: true, keyboard: true });
            wm.show();
        } catch (e) {}
    }

    if (shouldShowWelcomeModal()) {
        showWelcomeModalOnce();
    }

    window.addEventListener('pageshow', function(ev){
        if (ev && ev.persisted) {
            try{
                const wmEl = document.getElementById('welcomeModal');
                if (wmEl) {
                    const inst = bootstrap.Modal.getInstance(wmEl);
                    if (inst) inst.hide();
                }
                document.body.classList.remove('modal-open');
                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            }catch(e){}
        }
    });

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
});
</script>

</body>
</html>
