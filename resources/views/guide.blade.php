{{-- resources/views/guide.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('app.guide_title') }} • {{ __('app.site_title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --bg:#f5f7fb; --card:#ffffff; --primary:#1e3a8a; --primary-soft:rgba(30,58,138,.08);
            --stroke:rgba(148,163,184,.5); --text:#111827; --muted:#6b7280; --glass:rgba(248,250,252,.94);
        }
        html.dark-mode, body.dark-mode{
            --bg:#020617; --card:#020617; --primary:#e0b761; --primary-soft:rgba(224,183,97,.18);
            --stroke:rgba(148,163,184,.7); --text:#e5e7eb; --muted:#9ca3af; --glass:rgba(15,23,42,.92);
        }
        *{box-sizing:border-box}
        body{
            margin:0; min-height:100vh; font-family:'Prompt',system-ui,-apple-system,"Segoe UI",sans-serif;
            background:
                radial-gradient(circle at top, rgba(56,189,248,.12) 0, transparent 55%),
                radial-gradient(circle at bottom, rgba(234,179,8,.16) 0, transparent 60%),
                var(--bg);
            color:var(--text);
            display:flex; align-items:center; justify-content:center;
            padding:16px;
            transition:background-color .25s ease, color .25s ease;
        }
        .wrap{width:100%; max-width:520px; position:relative;}
        .card-glass{
            background:var(--card);
            border:1px solid var(--stroke);
            border-radius:22px;
            padding:24px 22px 20px;
            position:relative;
            overflow:hidden;
            box-shadow:0 22px 50px rgba(15,23,42,.35), 0 0 0 1px rgba(255,255,255,.06);
        }
        html.dark-mode .card-glass{
            box-shadow:0 26px 60px rgba(15,23,42,.85), 0 0 0 1px rgba(148,163,184,.35);
        }
        .card-glass::before{
            content:""; position:absolute; inset:-40%;
            background:
                radial-gradient(circle at 0 0, rgba(56,189,248,.16), transparent 55%),
                radial-gradient(circle at 100% 100%, rgba(234,179,8,.18), transparent 55%);
            opacity:.6; pointer-events:none;
        }
        .inner{position:relative; z-index:2;}

        /* Language switcher */
        .lang-fab{position:fixed; top:12px; right:12px; z-index:50; display:flex; align-items:center;}
        .lang-fab form{
            display:flex; gap:6px; margin:0; padding:5px 8px;
            background:var(--glass); border:1px solid var(--stroke); border-radius:999px;
            backdrop-filter:blur(10px) saturate(140%);
            -webkit-backdrop-filter:blur(10px) saturate(140%);
            box-shadow:0 12px 30px rgba(15,23,42,.35);
        }
        .lang-btn-square{
            border:0; cursor:pointer; border-radius:9px;
            padding:6px 10px; min-width:46px;
            font-size:.78rem; font-weight:600; letter-spacing:.03em; text-transform:uppercase;
            color:var(--text); background:transparent;
            transition:transform .08s ease, box-shadow .16s ease, background-color .16s ease;
        }
        .lang-btn-square[data-active="true"]{
            background:linear-gradient(135deg,#facc6b,#e0b761);
            color:#111827;
            box-shadow:0 6px 16px rgba(250,204,21,.38), inset 0 0 0 1px rgba(255,255,255,.7);
        }
        .lang-btn-square:hover{transform:translateY(-1px); box-shadow:0 4px 12px rgba(15,23,42,.45);}

        /* Theme toggle */
        .theme-toggle-box{
            position:absolute; top:14px; right:16px;
            display:inline-flex; align-items:center; gap:6px;
            font-size:.78rem; color:var(--muted);
        }
        .theme-toggle-box .form-check-input{cursor:pointer}

        .logo-img{
            width:80px; height:80px; object-fit:contain; display:block;
            margin:0 auto 10px; border-radius:18px; padding:10px;
            background:rgba(255,255,255,.92);
        }
        html.dark-mode .logo-img{background:rgba(15,23,42,.95)}

        .system-badge{
            display:inline-flex; align-items:center; gap:6px;
            padding:4px 10px; border-radius:999px;
            background:var(--primary-soft); color:var(--primary);
            font-size:.75rem; font-weight:500;
        }
        html.dark-mode .system-badge{background:rgba(15,23,42,.9); border:1px solid var(--stroke)}
        .system-dot{width:6px; height:6px; border-radius:999px; background:#22c55e}

        .title{font-size:1.4rem; font-weight:700; margin:10px 0 2px; text-align:center;}
        .subtitle{font-size:.9rem; color:var(--muted); margin:0 0 14px; text-align:center;}

        .btn-guide{
            width:100%;
            border-radius:999px;
            padding:.60rem .95rem;
            font-weight:700;
            font-size:.92rem;

            border:1px solid var(--stroke);
            background:rgba(148,163,184,.10);
            color:var(--text);

            box-shadow:0 12px 26px rgba(15,23,42,.14);
            backdrop-filter: blur(10px) saturate(140%);
            -webkit-backdrop-filter: blur(10px) saturate(140%);

            display:grid;
            grid-template-columns:26px 1fr 26px;
            align-items:center;
            justify-items:center;
            text-align:center;

            transition:transform .10s ease, box-shadow .18s ease, border-color .18s ease, background-color .18s ease;
        }
        html.dark-mode .btn-guide{
            background:rgba(255,255,255,.04);
            box-shadow:0 18px 40px rgba(0,0,0,.35);
        }

        .btn-guide > i{
            grid-column:1;
            justify-self:center;

            width:26px; height:26px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border-radius:999px;

            background:rgba(56,189,248,.14);
            color:#0284c7;
        }
        html.dark-mode .btn-guide > i{
            background:rgba(56,189,248,.16);
            color:#7dd3fc;
        }

        .btn-guide .btn-guide-label{grid-column:2; width:100%; text-align:center; line-height:1.2;}
        .btn-guide::after{content:""; grid-column:3;}

        .btn-guide:hover{
            transform:translateY(-1px);
            border-color:rgba(56,189,248,.55);
            background:rgba(56,189,248,.10);
            box-shadow:0 18px 36px rgba(15,23,42,.18);
        }
        html.dark-mode .btn-guide:hover{
            background:rgba(56,189,248,.12);
            box-shadow:0 22px 44px rgba(0,0,0,.48);
        }
        .btn-guide:active{transform:translateY(0);}

        .btn-secondary-soft{
            width:100%;
            border-radius:999px;
            padding:.55rem .95rem;
            font-weight:600;
            border:1px solid var(--stroke);
            background:rgba(15,23,42,.02);
            color:var(--text);
        }
        html.dark-mode .btn-secondary-soft{background:rgba(15,23,42,.9)}
        .btn-secondary-soft:hover{background:rgba(148,163,184,.1)}

        .footer-text{font-size:.78rem; color:var(--muted); text-align:center; margin-top:14px;}

 
        .group-box{
            text-align:left;
            background: var(--glass);
            border: 1px solid var(--stroke);
            border-radius: 18px;
            padding: 12px;
            box-shadow: 0 14px 34px rgba(15,23,42,.16);
        }
        html.dark-mode .group-box{ box-shadow: 0 18px 42px rgba(0,0,0,.35); }

        .group-head{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
            padding: 2px 4px 8px;
            margin-bottom: 8px;
            border-bottom: 1px solid rgba(148,163,184,.35);
        }
        .group-title{
            display:flex;
            align-items:center;
            gap:8px;
            font-weight:800;
            color: var(--text);
            letter-spacing:.01em;
        }
        .group-title i{
            width:26px; height:26px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border-radius:10px;
            background: rgba(56,189,248,.12);
            color:#0284c7;
        }
        html.dark-mode .group-title i{
            background: rgba(56,189,248,.14);
            color:#7dd3fc;
            border: 1px solid rgba(56,189,248,.22);
        }
        .group-sub{
            font-size:.78rem;
            color: var(--muted);
            margin: 0;
        }

        /* Modal */
        .modal-content{
            border-radius:18px;
            border:1px solid var(--stroke);
            background:var(--card);
            color:var(--text);
        }
        .modal-header, .modal-footer{border-color:rgba(148,163,184,.45)}

        .step-item{
            background: var(--glass);
            border: 1px solid var(--stroke);
            border-radius: 14px;
            padding: 12px;
            margin-bottom: 12px;
        }
        .step-head{
            display:flex;
            align-items:flex-start;
            gap:10px;
            margin-bottom:10px;
        }
        .step-num{
            width:28px; height:28px;
            border-radius:999px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            font-weight:800;
            font-size:.85rem;
            color:#111827;
            background: linear-gradient(135deg,#facc6b,#e0b761);
            flex:0 0 auto;
            box-shadow: 0 8px 18px rgba(250,204,21,.22);
        }
        .step-text{
            font-size:.92rem;
            line-height:1.45;
            color: var(--text);
            margin-top:2px;
        }
        .guide-img{
            width:100%;
            height:auto;
            border-radius:14px;
            border:1px solid rgba(148,163,184,.45);
            box-shadow:0 14px 36px rgba(15,23,42,.35);
        }
        .img-missing{
            border:1px dashed rgba(148,163,184,.6);
            border-radius:14px;
            padding:12px;
            color:var(--muted);
            background: rgba(148,163,184,.06);
            display:flex;
            align-items:center;
            gap:8px;
            font-size:.9rem;
        }

        @media (max-width:576px){
            .card-glass{padding:22px 18px 18px; border-radius:18px;}
        }
    </style>
</head>

<body>
@php

    $registerSteps = [
        ['text_key' => 'guide_register_step1', 'image' => asset('images/guide/register1.png'), 'exists' => file_exists(public_path('images/guide/register1.png'))],
        ['text_key' => 'guide_register_step2', 'image' => asset('images/guide/register2.png'), 'exists' => file_exists(public_path('images/guide/register2.png'))],
        ['text_key' => 'guide_register_step3', 'image' => asset('images/guide/register3.png'), 'exists' => file_exists(public_path('images/guide/register3.png'))],
        ['text_key' => 'guide_register_step4', 'image' => asset('images/guide/register4.png'), 'exists' => file_exists(public_path('images/guide/register4.png'))],
        ['text_key' => 'guide_register_step5', 'image' => asset('images/guide/register5.png'), 'exists' => file_exists(public_path('images/guide/register5.png'))],
    ];

  
    $editProfileSteps = [
        ['text_key' => 'guide_edit_profile_step1', 'image' => asset('images/guide/editprofile1.png'), 'exists' => file_exists(public_path('images/guide/editprofile1.png'))],
        ['text_key' => 'guide_edit_profile_step2', 'image' => asset('images/guide/editprofile2.png'), 'exists' => file_exists(public_path('images/guide/editprofile2.png'))],
        ['text_key' => 'guide_edit_profile_step3', 'image' => asset('images/guide/editprofile3.png'), 'exists' => file_exists(public_path('images/guide/editprofile3.png'))],
        ['text_key' => 'guide_edit_profile_step4', 'image' => asset('images/guide/editprofile4.png'), 'exists' => file_exists(public_path('images/guide/editprofile4.png'))],
    ];


    $forgotPasswordSteps = [
        ['text_key' => 'guide_forgot_password_step1', 'image' => asset('images/guide/forgetpassword1.png'), 'exists' => file_exists(public_path('images/guide/forgetpassword1.png'))],
        ['text_key' => 'guide_forgot_password_step2', 'image' => asset('images/guide/forgetpassword2.png'), 'exists' => file_exists(public_path('images/guide/forgetpassword2.png'))],
        ['text_key' => 'guide_forgot_password_step3', 'image' => asset('images/guide/forgetpassword3.png'), 'exists' => file_exists(public_path('images/guide/forgetpassword3.png'))],
        ['text_key' => 'guide_forgot_password_step4', 'image' => asset('images/guide/forgetpassword4.png'), 'exists' => file_exists(public_path('images/guide/forgetpassword4.png'))],
    ];

  
    $selfAssessmentSteps = [
        ['text_key' => 'guide_self_assessment_step1', 'image' => asset('images/guide/self1.png'), 'exists' => file_exists(public_path('images/guide/self1.png'))],
        ['text_key' => 'guide_self_assessment_step2', 'image' => asset('images/guide/self2.png'), 'exists' => file_exists(public_path('images/guide/self2.png'))],
        ['text_key' => 'guide_self_assessment_step3', 'image' => asset('images/guide/self3.png'), 'exists' => file_exists(public_path('images/guide/self3.png'))],
        ['text_key' => 'guide_self_assessment_step4', 'image' => asset('images/guide/self4.png'), 'exists' => file_exists(public_path('images/guide/self4.png'))],
    ];

 
    $employeeAssessmentSteps = [
        ['text_key' => 'guide_employee_assessment_step1', 'image' => asset('images/guide/Assessment1.png'), 'exists' => file_exists(public_path('images/guide/Assessment1.png'))],
        ['text_key' => 'guide_employee_assessment_step2', 'image' => asset('images/guide/Assessment2.png'), 'exists' => file_exists(public_path('images/guide/Assessment2.png'))],
        ['text_key' => 'guide_employee_assessment_step3', 'image' => asset('images/guide/Assessment3.png'), 'exists' => file_exists(public_path('images/guide/Assessment3.png'))],
        ['text_key' => 'guide_employee_assessment_step4', 'image' => asset('images/guide/Assessment4.png'), 'exists' => file_exists(public_path('images/guide/Assessment4.png'))],
        ['text_key' => 'guide_employee_assessment_step5', 'image' => asset('images/guide/Assessment5.png'), 'exists' => file_exists(public_path('images/guide/Assessment5.png'))],
        ['text_key' => 'guide_employee_assessment_step6', 'image' => asset('images/guide/Assessment6.png'), 'exists' => file_exists(public_path('images/guide/Assessment6.png'))],
        ['text_key' => 'guide_employee_assessment_step7', 'image' => asset('images/guide/Assessment7.png'), 'exists' => file_exists(public_path('images/guide/Assessment7.png'))],
        ['text_key' => 'guide_employee_assessment_step8', 'image' => asset('images/guide/Assessment8.png'), 'exists' => file_exists(public_path('images/guide/Assessment8.png'))],
    ];

    // ✅ โซนการประเมิน: ดูผลลัพธ์ (6 ข้อ = 6 รูป) ✅ Overview1.png ถึง Overview6.png
    $resultsSteps = [
        ['text_key' => 'guide_results_step1', 'image' => asset('images/guide/Overview1.png'), 'exists' => file_exists(public_path('images/guide/Overview1.png'))],
        ['text_key' => 'guide_results_step2', 'image' => asset('images/guide/Overview2.png'), 'exists' => file_exists(public_path('images/guide/Overview2.png'))],
        ['text_key' => 'guide_results_step3', 'image' => asset('images/guide/Overview3.png'), 'exists' => file_exists(public_path('images/guide/Overview3.png'))],
        ['text_key' => 'guide_results_step4', 'image' => asset('images/guide/Overview4.png'), 'exists' => file_exists(public_path('images/guide/Overview4.png'))],
        ['text_key' => 'guide_results_step5', 'image' => asset('images/guide/Overview5.png'), 'exists' => file_exists(public_path('images/guide/Overview5.png'))],
        ['text_key' => 'guide_results_step6', 'image' => asset('images/guide/Overview6.png'), 'exists' => file_exists(public_path('images/guide/Overview6.png'))],
    ];

    // ✅ Renderer (ป้องกันปัญหา blade/return)
    $renderSteps = function($steps) {
        foreach($steps as $idx => $st){
            echo '<div class="step-item">';
            echo '  <div class="step-head">';
            echo '    <div class="step-num">'.($idx+1).'</div>';
            echo '    <div class="step-text">'.e(__('app.'.$st['text_key'])).'</div>';
            echo '  </div>';

            if (!empty($st['exists'])) {
                echo '  <img src="'.e($st['image']).'" class="guide-img" alt="'.e(__('app.guide_image_alt')).' '.($idx+1).'">';
            } else {
                echo '  <div class="img-missing"><i class="bi bi-image"></i> '.e(__('app.guide_image_missing')).'</div>';
            }
            echo '</div>';
        }
    };
@endphp

{{-- Language switcher --}}
<div class="lang-fab" aria-label="Language switcher">
    <form id="localeForm" action="{{ route('locale.switch') }}" method="POST" class="d-flex m-0 p-0">
        @csrf
        <input type="hidden" name="locale" id="localeInput">
        <button type="button" class="lang-btn-square" data-locale="th" data-active="{{ app()->getLocale()==='th' ? 'true' : 'false' }}">TH</button>
        <button type="button" class="lang-btn-square" data-locale="en" data-active="{{ app()->getLocale()==='en' ? 'true' : 'false' }}">EN</button>
    </form>
</div>

<div class="wrap">
    <div class="card-glass">
        {{-- Theme toggle --}}
        <div class="theme-toggle-box">
            <i class="bi bi-moon-stars"></i>
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" id="themeToggle">
            </div>
            <span>{{ __('app.theme_dark') }}</span>
        </div>

        <div class="inner text-center">
            <img src="{{ asset('images/logo.jpg') }}" class="logo-img" alt="Supavut Logo">

            <div class="d-flex justify-content-center mb-2">
                <div class="system-badge">
                    <span class="system-dot"></span>
                    {{ __('app.system_badge') }}
                </div>
            </div>

            <div class="title">{{ __('app.guide_title') }}</div>
            <div class="subtitle">{{ __('app.guide_subtitle') }}</div>

            {{-- ✅ กลุ่ม: บัญชี --}}
            <div class="group-box mb-3">
                <div class="group-head">
                    <div>
                        <div class="group-title">
                            <i class="bi bi-person-badge"></i>
                            {{ __('app.guide_group_account') }}
                        </div>
                        <p class="group-sub mb-0">{{ __('app.guide_group_account_desc') }}</p>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="button" class="btn-guide" data-bs-toggle="modal" data-bs-target="#guideModal-register">
                        <i class="bi bi-person-plus"></i>
                        <span class="btn-guide-label">{{ __('app.guide_btn_register_login') }}</span>
                    </button>

                    <button type="button" class="btn-guide" data-bs-toggle="modal" data-bs-target="#guideModal-editprofile">
                        <i class="bi bi-person-gear"></i>
                        <span class="btn-guide-label">{{ __('app.guide_btn_edit_profile') }}</span>
                    </button>

                    <button type="button" class="btn-guide" data-bs-toggle="modal" data-bs-target="#guideModal-forgotpassword">
                        <i class="bi bi-key"></i>
                        <span class="btn-guide-label">{{ __('app.guide_btn_forgot_password') }}</span>
                    </button>
                </div>
            </div>

            {{-- ✅ กลุ่ม: การประเมิน --}}
            <div class="group-box">
                <div class="group-head">
                    <div>
                        <div class="group-title">
                            <i class="bi bi-clipboard-data"></i>
                            {{ __('app.guide_group_assessment') }}
                        </div>
                        <p class="group-sub mb-0">{{ __('app.guide_group_assessment_desc') }}</p>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="button" class="btn-guide" data-bs-toggle="modal" data-bs-target="#guideModal-selfassessment">
                        <i class="bi bi-clipboard-check"></i>
                        <span class="btn-guide-label">{{ __('app.guide_btn_self_assessment') }}</span>
                    </button>

                    <button type="button" class="btn-guide" data-bs-toggle="modal" data-bs-target="#guideModal-employeeassessment">
                        <i class="bi bi-people-fill"></i>
                        <span class="btn-guide-label">{{ __('app.guide_btn_employee_assessment') }}</span>
                    </button>

                    <button type="button" class="btn-guide" data-bs-toggle="modal" data-bs-target="#guideModal-results">
                        <i class="bi bi-graph-up-arrow"></i>
                        <span class="btn-guide-label">{{ __('app.guide_btn_view_results') }}</span>
                    </button>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ url('/') }}" class="btn btn-secondary-soft">
                    <i class="bi bi-arrow-left-circle me-1"></i>
                    {{ __('app.guide_back_to_welcome') }}
                </a>
            </div>

            <div class="footer-text">© {{ date('Y') }} Supavut Industry Co., Ltd.</div>
        </div>
    </div>
</div>

{{-- ✅ Modal: สมัครสมาชิก/เข้าสู่ระบบ --}}
<div class="modal fade" id="guideModal-register" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-0">
                        <i class="bi bi-person-plus me-1"></i>
                        {{ __('app.guide_modal_register_login_title') }}
                    </h5>
                    <div class="small mt-1" style="color: var(--muted) !important;">
                        {{ __('app.guide_modal_register_login_desc') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('app.cancel') }}"></button>
            </div>
            <div class="modal-body">
                @php $renderSteps($registerSteps); @endphp
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary-soft" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>{{ __('app.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Modal: แก้ไขข้อมูลส่วนตัว --}}
<div class="modal fade" id="guideModal-editprofile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-0">
                        <i class="bi bi-person-gear me-1"></i>
                        {{ __('app.guide_modal_edit_profile_title') }}
                    </h5>
                    <div class="small mt-1" style="color: var(--muted) !important;">
                        {{ __('app.guide_modal_edit_profile_desc') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('app.cancel') }}"></button>
            </div>
            <div class="modal-body">
                @php $renderSteps($editProfileSteps); @endphp
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary-soft" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>{{ __('app.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Modal: ลืมรหัสผ่าน --}}
<div class="modal fade" id="guideModal-forgotpassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-0">
                        <i class="bi bi-key me-1"></i>
                        {{ __('app.guide_modal_forgot_password_title') }}
                    </h5>
                    <div class="small mt-1" style="color: var(--muted) !important;">
                        {{ __('app.guide_modal_forgot_password_desc') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('app.cancel') }}"></button>
            </div>
            <div class="modal-body">
                @php $renderSteps($forgotPasswordSteps); @endphp
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary-soft" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>{{ __('app.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Modal: การประเมินตัวเอง --}}
<div class="modal fade" id="guideModal-selfassessment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-0">
                        <i class="bi bi-clipboard-check me-1"></i>
                        {{ __('app.guide_modal_self_assessment_title') }}
                    </h5>
                    <div class="small mt-1" style="color: var(--muted) !important;">
                        {{ __('app.guide_modal_self_assessment_desc') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('app.cancel') }}"></button>
            </div>
            <div class="modal-body">
                @php $renderSteps($selfAssessmentSteps); @endphp
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary-soft" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>{{ __('app.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Modal: ประเมินพนักงาน --}}
<div class="modal fade" id="guideModal-employeeassessment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-0">
                        <i class="bi bi-people-fill me-1"></i>
                        {{ __('app.guide_modal_employee_assessment_title') }}
                    </h5>
                    <div class="small mt-1" style="color: var(--muted) !important;">
                        {{ __('app.guide_modal_employee_assessment_desc') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('app.cancel') }}"></button>
            </div>
            <div class="modal-body">
                @php $renderSteps($employeeAssessmentSteps); @endphp
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary-soft" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>{{ __('app.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Modal: ดูผลลัพธ์ --}}
<div class="modal fade" id="guideModal-results" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-0">
                        <i class="bi bi-graph-up-arrow me-1"></i>
                        {{ __('app.guide_modal_results_title') }}
                    </h5>
                    <div class="small mt-1" style="color: var(--muted) !important;">
                        {{ __('app.guide_modal_results_desc') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('app.cancel') }}"></button>
            </div>
            <div class="modal-body">
                @php $renderSteps($resultsSteps); @endphp
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary-soft" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>{{ __('app.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ===== Theme sync =====
    const THEME_STORAGE_KEY = 'supavut_theme_mode';
    const toggle = document.getElementById('themeToggle');

    function applyTheme(mode) {
        const t = (mode === 'light') ? 'light' : 'dark';
        if (t === 'dark') {
            document.body.classList.add('dark-mode');
            document.documentElement.classList.add('dark-mode');
            if (toggle) toggle.checked = true;
        } else {
            document.body.classList.remove('dark-mode');
            document.documentElement.classList.remove('dark-mode');
            if (toggle) toggle.checked = false;
        }
        try { localStorage.setItem(THEME_STORAGE_KEY, t); } catch(e) {}
    }

    let init = 'dark';
    try {
        const saved = localStorage.getItem(THEME_STORAGE_KEY);
        if (saved === 'dark' || saved === 'light') init = saved;
    } catch(e) {}
    applyTheme(init);

    if (toggle) {
        toggle.addEventListener('change', function () {
            applyTheme(this.checked ? 'dark' : 'light');
        });
    }

    // ===== Language switcher =====
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

    // ===== Offline notice + redirect =====
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
