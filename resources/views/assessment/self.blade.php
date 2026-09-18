{{-- resources/views/assessment/self.blade.php --}}
@php
    $locale = app()->getLocale();
    $empName = ($locale === 'en')
        ? ($employee->full_name_en ?? $employee->full_name_th ?? $employee->employee_code)
        : ($employee->full_name_th ?? $employee->full_name_en ?? $employee->employee_code);
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <title>
        {{ __('app.assess_self_title', ['name' => $empName]) ?? 'Self Assessment' }}
        • {{ config('app.name', 'Supavut Assessment') }}
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Libs --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg:#0b1120;
            --card-bg:#020617;
            --text:#e5e7eb;
            --muted:#9ca3af;
            --border:#1f2937;
            --accent:#e0b761;
        }
        body.light-mode{
            --bg:#f3f4f6;
            --card-bg:#ffffff;
            --text:#111827;
            --muted:#6b7280;
            --border:#e5e7eb;
            --accent:#f59e0b;
        }

        *{box-sizing:border-box;}
        body{
            margin:0;
            padding:16px;
            min-height:100vh;
            font-family:system-ui,Prompt,sans-serif;
            background:var(--bg);
            color:var(--text);
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .page-wrap{
            width:100%;
            max-width:1100px;
        }
        .card-main{
            background:var(--card-bg);
            border-radius:18px;
            border:1px solid rgba(148,163,184,.35);
            box-shadow:0 18px 40px rgba(15,23,42,0.7);
            padding:20px 18px 18px;
            position:relative;
            overflow:hidden;
        }
        body.light-mode .card-main{
            box-shadow:0 12px 30px rgba(15,23,42,0.12);
            border-color:#e5e7eb;
        }
        .inner{
            position:relative;
            z-index:1;
            margin-top:34px;
        }

        /* Lang + theme */
        .top-right-stack{
            position:absolute;
            top:10px;
            right:14px;
            display:flex;
            flex-direction:column;
            gap:6px;
            z-index:2;
        }
        .lang-switch{
            display:inline-flex;
            padding:4px;
            border-radius:999px;
            border:1px solid rgba(148,163,184,.55);
            backdrop-filter:blur(10px) saturate(140%);
            -webkit-backdrop-filter:blur(10px) saturate(140%);
            background:rgba(15,23,42,0.9);
        }
        body.light-mode .lang-switch{
            background:rgba(255,255,255,0.98);
        }
        .lang-switch form{display:flex;gap:4px;margin:0;}
        .lang-btn{
            border:0;
            padding:4px 10px;
            border-radius:999px;
            font-size:.75rem;
            font-weight:600;
            letter-spacing:.04em;
            text-transform:uppercase;
            cursor:pointer;
            background:transparent;
            color:var(--text);
        }
        .lang-btn[data-active="true"]{
            background:linear-gradient(135deg,#fef9c3,#facc15);
            color:#111827;
            box-shadow:0 5px 14px rgba(252,211,77,0.4);
        }
        .theme-toggle-box{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:4px 10px;
            border-radius:999px;
            border:1px solid rgba(148,163,184,.55);
            backdrop-filter:blur(10px) saturate(140%);
            -webkit-backdrop-filter:blur(10px) saturate(140%);
            background:rgba(15,23,42,0.95);
            font-size:.78rem;
            color:var(--muted);
        }
        body.light-mode .theme-toggle-box{
            background:rgba(255,255,255,0.98);
        }

        /* Header */
        .title-row{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:12px;
            margin-bottom:10px;
        }
        .page-title{
            font-size:1.3rem;
            font-weight:700;
            display:flex;
            align-items:center;
            gap:8px;
        }

        /* Employee info – formal card */
        .emp-card{
            margin-top:10px;
            padding:14px 16px;
            border-radius:14px;
            border:1px solid rgba(148,163,184,.6);
            background:rgba(15,23,42,0.96);
            display:flex;
            gap:16px;
            align-items:center;
        }
        body.light-mode .emp-card{
            background:#ffffff;
        }
        .emp-avatar{
            width:70px;
            height:70px;
            border-radius:14px;
            overflow:hidden;
            border:2px solid rgba(248,250,252,0.95);
            background:#111827;
            flex-shrink:0;
        }
        body.light-mode .emp-avatar{
            background:#e5e7eb;
        }
        .emp-avatar img{
            width:100%;
            height:100%;
            object-fit:cover;
        }
        .emp-main{flex:1;}
        .emp-name{
            font-weight:600;
            font-size:1rem;
            margin-bottom:4px;
        }
        .emp-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
            gap:4px 14px;
            font-size:.8rem;
            color:var(--muted);
        }
        .emp-label{
            font-weight:500;
            color:var(--text);
        }
        .chip-row{
            margin-top:8px;
            display:flex;
            flex-wrap:wrap;
            gap:6px;
        }
        .chip{
            font-size:.75rem;
            border-radius:999px;
            padding:2px 9px;
            border:1px solid rgba(148,163,184,.7);
            background:rgba(15,23,42,0.98);
        }
        body.light-mode .chip{
            background:#f9fafb;
        }
        .chip.done{
            border-color:rgba(34,197,94,0.9);
            color:#22c55e;
        }

        /* Question list */
        .q-list{
            margin-top:18px;
            border-radius:14px;
            border:1px solid rgba(148,163,184,.45);
            padding:10px 10px 8px;
            max-height:560px;
            overflow:auto;
            background:rgba(15,23,42,0.98);
        }
        body.light-mode .q-list{
            background:#ffffff;
        }
        .q-item{
            border-radius:12px;
            padding:10px 12px 12px;
            margin-bottom:10px;
            background:rgba(15,23,42,0.98);
            border:1px solid rgba(148,163,184,.35);
        }
        body.light-mode .q-item{
            background:#f9fafb;
        }

        /* ข้อที่ยังไม่ได้กรอก (error) */
        .q-item.error{
            border-color:#f97316;
            box-shadow:0 0 0 1px rgba(248,250,252,0.08);
        }
        body.light-mode .q-item.error{
            border-color:#fb923c;
            box-shadow:0 0 0 1px rgba(251,146,60,0.3);
        }

        .q-category{
            font-size:.82rem;
            margin-bottom:6px;
        }
        .q-cat-main{
            font-weight:600;
        }
        .q-cat-sub,
        .q-cat-skill{
            color:var(--muted);
            margin-top:1px;
        }

        .q-question{
            margin-top:4px;
        }
        .q-number{
            font-size:.9rem;
            font-weight:600;
            color:var(--accent);
            margin-bottom:3px;
        }
        .q-text{
            font-size:1rem;
            line-height:1.5;
            font-weight:500;
        }

        .q-scale{
            margin-top:10px;
            display:flex;
            flex-direction:column;
            gap:4px;
        }
        .q-option{
            display:flex;
            align-items:center;
            gap:8px;
            font-size:.9rem;
            padding:3px 8px;
            border-radius:8px;
            border:1px solid transparent;
        }
        .q-option:hover{
            border-color:rgba(148,163,184,.6);
            background:rgba(15,23,42,0.85);
        }
        body.light-mode .q-option:hover{
            background:#eef2ff;
        }
        .q-option.disabled{
            opacity:.7;
            cursor:default;
        }
        .q-option input{
            accent-color:#facc15;
        }
        .q-option-score{
            font-weight:600;
            width:32px;
        }

        .bottom-actions{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:10px;
            margin-top:16px;
        }
        .btn-back{
            border-radius:999px;
            padding:.45rem 1.2rem;
            border:1px solid rgba(148,163,184,.7);
            background:transparent;
            color:var(--text);
            display:inline-flex;
            align-items:center;
            gap:6px;
            text-decoration:none;
            font-size:.88rem;
        }
        .btn-back:hover{
            background:rgba(148,163,184,0.16);
        }
        .btn-gold{
            border-radius:999px;
            padding:.5rem 1.6rem;
            border:0;
            background:linear-gradient(135deg,#facc6b,#eab308);
            color:#111827;
            font-weight:600;
            font-size:.9rem;
            display:inline-flex;
            align-items:center;
            gap:6px;
        }
        .btn-gold:hover{
            filter:brightness(1.05);
        }
        .btn-gold:disabled{
            opacity:.6;
            cursor:not-allowed;
        }
        .alert-mini{
            font-size:.8rem;
            border-radius:999px;
            padding:4px 10px;
        }

        /* Modal */
        .self-modal .modal-content{
            background:var(--card-bg);
            color:var(--text);
            border-radius:18px;
            border:1px solid rgba(148,163,184,.7);
        }
        .self-modal .modal-header,
        .self-modal .modal-footer{
            border-color:rgba(148,163,184,.4);
        }
        .self-modal .modal-body{
            color:#000000;
            font-size:0.95rem;
            line-height:1.5;
        }
        .self-modal .modal-title{
            color:#fde68a;
            font-weight:600;
        }

        @media(max-width:768px){
            .card-main{padding:16px 14px 14px;}
            .title-row{flex-direction:column;align-items:flex-start;}
            .q-list{max-height:none;}
            .bottom-actions{flex-direction:column-reverse;align-items:stretch;}
            .btn-back,.btn-gold{width:100%;justify-content:center;}
        }
        @media(max-width:576px){
            .emp-card{flex-direction:column;align-items:flex-start;}
        }
    </style>
</head>
<body>
@php
    /** @var \App\Models\Employee $employee */
    $avatarPath = optional($employee->user)->profile_picture ?? null;
    $avatarUrl  = $avatarPath ? asset('storage/'.ltrim($avatarPath,'/')) : asset('images/default-avatar.png');

    $hasSelf   = !empty($self);
    $readonly  = $readonly ?? false;
    $totalText = $self?->q_all;

    $deptQms = $employee->dept_abbr_qms
        ?? $employee->abbr
        ?? $employee->department
        ?? null;

    $scaleLabelsTh = [
        4 => 'จริงมาก',
        3 => 'ค่อนข้างจริง',
        2 => 'จริงบ้างเป็นบางครั้ง',
        1 => 'ค่อนข้างไม่จริง',
        0 => 'ไม่จริง',
    ];
    $scaleLabelsEn = [
        4 => 'Very true',
        3 => 'Quite true',
        2 => 'Sometimes true',
        1 => 'Rather untrue',
        0 => 'Not true',
    ];
    $scaleLabels = $locale === 'en' ? $scaleLabelsEn : $scaleLabelsTh;
@endphp

<div class="page-wrap">
    <div class="card-main">

        {{-- มุมขวาบน: เลือกภาษา + ธีม --}}
        <div class="top-right-stack">
            <div class="lang-switch">
                <form id="localeForm" action="{{ route('locale.switch') }}" method="POST">
                    @csrf
                    <input type="hidden" name="locale" id="localeInput">
                    <button type="button"
                            class="lang-btn"
                            data-locale="th"
                            data-active="{{ $locale==='th' ? 'true' : 'false' }}">
                        TH
                    </button>
                    <button type="button"
                            class="lang-btn"
                            data-locale="en"
                            data-active="{{ $locale==='en' ? 'true' : 'false' }}">
                        EN
                    </button>
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

        <div class="inner">
            {{-- ส่วนหัว --}}
            <div class="title-row">
                <div>
                    <div class="page-title">
                        <i class="bi bi-person-lines-fill"></i>
                        <span>
                            @if($locale==='en')
                                Self-assessment form
                            @else
                                แบบประเมินตนเองของฉัน
                            @endif
                        </span>
                    </div>
                </div>
                <div class="text-end"></div>
            </div>

            {{-- Flash message --}}
            @if(session('success'))
                <div class="alert alert-success alert-mini mt-2">
                    <i class="bi bi-check2-circle me-1"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ข้อมูลพนักงาน --}}
            <div class="emp-card mt-2">
                <div class="emp-avatar">
                    <img src="{{ $avatarUrl }}" alt="avatar">
                </div>
                <div class="emp-main">
                    <div class="emp-name">{{ $empName }}</div>

                    <div class="emp-grid">
                        <div>
                            <span class="emp-label">
                                <i class="bi bi-person-badge me-1"></i>
                                @if($locale==='en') Employee code @else รหัสพนักงาน @endif
                                :
                            </span>
                            {{ $employee->employee_code }}
                        </div>

                        @if($employee->position)
                            <div>
                                <span class="emp-label">
                                    <i class="bi bi-briefcase me-1"></i>
                                    @if($locale==='en') Position @else ตำแหน่ง @endif
                                    :
                                </span>
                                {{ $employee->position }}
                            </div>
                        @endif

                        @if($deptQms)
                            <div>
                                <span class="emp-label">
                                    <i class="bi bi-diagram-3 me-1"></i>
                                    @if($locale==='en')
                                        Dept
                                    @else
                                        แผนก
                                    @endif
                                    :
                                </span>
                                {{ $deptQms }}
                            </div>
                        @endif
                    </div>

                    <div class="chip-row">

                        @if($hasSelf && $totalText)
                            <span class="chip done">
                                <i class="bi bi-clipboard-check me-1"></i>
                                @if($locale==='en')
                                    Total score: {{ $totalText }}
                                @else
                                    คะแนนรวม: {{ $totalText }}
                                @endif
                            </span>
                        @endif


                        @if($hasSelf && $self?->updated_at)
                            <span class="chip">
                                <i class="bi bi-clock-history me-1"></i>
                                @if($locale==='en')
                                    Last update: {{ $self->updated_at->format('d/m/Y H:i') }}
                                @else
                                    แก้ไขล่าสุด: {{ $self->updated_at->format('d/m/Y H:i') }}
                                @endif
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ฟอร์มคำถาม --}}
            <form id="selfForm"
                  method="POST"
                  action="{{ $readonly ? '#' : route('assessment.self.store') }}"
                  class="mt-3">
                @csrf

                <div class="q-list">
                    @php $displayIndex = 1; @endphp
                    @foreach($questions as $no => $q)
                        @php
                            // ข้อความคำถาม: TH / EN
                            $questionText = $locale === 'en'
                                ? ($q['text_en'] ?? $q['text_th'] ?? '')
                                : ($q['text_th'] ?? $q['text_en'] ?? '');

                            $mainCat = $q['main_category'] ?? '-';
                            $subCat  = $q['sub_category'] ?? '-';
                            $skill   = $q['skill'] ?? null;
                            $current = $self ? ($self->{'q'.$no} ?? null) : null;
                        @endphp

                        <div class="q-item">
                            {{-- Main / Sub / Skill --}}
                            <div class="q-category">
                                @if($locale === 'en')
                                    <div class="q-cat-main">
                                        Main topic: {{ $mainCat }}
                                    </div>
                                    <div class="q-cat-sub">
                                        Area: {{ $subCat }}
                                    </div>
                                    @if($skill)
                                        <div class="q-cat-skill">
                                            Skill: {{ $skill }}
                                        </div>
                                    @endif
                                @else
                                    <div class="q-cat-main">
                                        หัวข้อ {{ $mainCat }}
                                    </div>
                                    <div class="q-cat-sub">
                                        เรื่อง {{ $subCat }}
                                    </div>
                                    @if($skill)
                                        <div class="q-cat-skill">
                                            ทักษะ : {{ $skill }}
                                        </div>
                                    @endif
                                @endif
                            </div>

                            {{-- คำถาม --}}
                            <div class="q-question">
                                <div class="q-number">
                                    @if($locale==='en')
                                        Question {{ $displayIndex }}
                                    @else
                                        คำถามที่ {{ $displayIndex }}
                                    @endif
                                </div>
                                <div class="q-text">
                                    {{ $questionText }}
                                </div>
                            </div>

                            <div class="q-scale">

                                @for($score = 4; $score >= 0; $score--)
                                    @php
                                        $id = "q{$no}_{$score}";
                                        $checked = ($current !== null && (int)$current === $score);
                                    @endphp
                                    <label class="q-option {{ ($readonly || $hasSelf) ? 'disabled' : '' }}" for="{{ $id }}">
                                        <input type="radio"
                                               id="{{ $id }}"
                                               name="q{{ $no }}"
                                               value="{{ $score }}"
                                               {{ $checked ? 'checked' : '' }}
                                               {{ ($readonly || $hasSelf) ? 'disabled' : '' }}>
                                        <span class="q-option-score">{{ $score }}</span>
                                        <span>{{ $scaleLabels[$score] }}</span>
                                    </label>
                                @endfor

                                {{-- ช้อย N/A (ไม่คิดคะแนน) --}}
                                @php
                                    $naId      = "q{$no}_na";
                                    $naChecked = $hasSelf && $current === null;
                                @endphp
                                <label class="q-option {{ ($readonly || $hasSelf) ? 'disabled' : '' }}" for="{{ $naId }}">
                                    <input type="radio"
                                           id="{{ $naId }}"
                                           name="q{{ $no }}"
                                           value="na"
                                           {{ $naChecked ? 'checked' : '' }}
                                           {{ ($readonly || $hasSelf) ? 'disabled' : '' }}>
                                    <span class="q-option-score">N/A</span>
                                    <span>
                                        @if($locale === 'en')
                                           Cannot evaluate
                                        @else
                                            ไม่สามารถประเมินข้อนี้ได้
                                        @endif
                                    </span>
                                </label>
                            </div>

                            @error('q'.$no)
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        @php $displayIndex++; @endphp
                    @endforeach
                </div>

                <div class="bottom-actions">
                    <a href="{{ route('profile') }}" class="btn-back">
                        <i class="bi bi-arrow-left-short"></i>
                        @if($locale==='en')
                            Back to profile
                        @else
                            กลับไปหน้าโปรไฟล์
                        @endif
                    </a>

                    @if(! $readonly && ! $hasSelf)
                        <button type="button" class="btn-gold" id="openConfirmBtn">
                            <i class="bi bi-send-check"></i>
                            @if($locale==='en')
                                Submit self-assessment
                            @else
                                ส่งแบบประเมินตนเอง
                            @endif
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal ยืนยันการส่ง --}}
<div class="modal fade" id="confirmSubmitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content self-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmSubmitLabel">
                    @if($locale==='en')
                        Confirm self-assessment
                    @else
                        ยืนยันการส่งแบบประเมินตนเอง
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($locale==='en')
                    Please confirm that your answers are correct.
                    After submitting, this form cannot be edited.
                @else
                    โปรดยืนยันว่าคุณตรวจสอบคำตอบเรียบร้อยแล้ว
                    เมื่อส่งแบบประเมินแล้วจะไม่สามารถแก้ไขได้
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    @if($locale==='en') Cancel @else ยกเลิก @endif
                </button>
                <button type="button" class="btn btn-warning" id="confirmSubmitBtn">
                    <i class="bi bi-check2-circle me-1"></i>
                    @if($locale==='en') Confirm &amp; submit @else ยืนยันการส่ง @endif
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ===== Theme toggle with localStorage =====
    const THEME_KEY = 'supavut_theme_mode';
    const toggle = document.getElementById('themeToggle');

    function applyTheme(mode) {
        if (mode === 'light') {
            document.body.classList.add('light-mode');
            if (toggle) toggle.checked = false;
        } else {
            document.body.classList.remove('light-mode');
            if (toggle) toggle.checked = true;
        }
        try { localStorage.setItem(THEME_KEY, mode); } catch (e) {}
    }

    function initTheme() {
        try {
            const saved = localStorage.getItem(THEME_KEY);
            if (saved === 'light' || saved === 'dark') {
                applyTheme(saved);
                return;
            }
        } catch (e) {}
        applyTheme('dark');
    }

    initTheme();

    if (toggle) {
        toggle.addEventListener('change', function(){
            const mode = this.checked ? 'dark' : 'light';
            applyTheme(mode);
        });
    }

    // ===== Language switcher =====
    const localeForm  = document.getElementById('localeForm');
    const localeInput = document.getElementById('localeInput');

    if (localeForm && localeInput) {
        localeForm.querySelectorAll('.lang-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                localeInput.value = btn.dataset.locale;
                localeForm.submit();
            });
        });
    }

    // ===== ข้อความเตือน (ตามภาษา) =====
    const MISSING_MSG = @json($locale === 'en'
        ? 'Please answer all questions before submitting. The system will take you to the first unanswered question.'
        : 'โปรดตอบทุกข้อก่อนส่ง ระบบจะเลื่อนไปที่คำถามข้อแรกที่ยังไม่ได้เลือกคะแนนให้'
    );
    const MISSING_HINT_MSG = @json($locale === 'en'
        ? 'Please select a score for this question.'
        : 'โปรดเลือกคะแนนในข้อนี้'
    );

    // ===== ฟังก์ชันหา "คำถามข้อแรกที่ยังไม่ได้เลือกคะแนน" =====
    function findFirstUnansweredQuestion() {
        const items = document.querySelectorAll('.q-item');
        for (const item of items) {
            const radios = item.querySelectorAll('input[type="radio"]:not(:disabled)');
            if (!radios.length) continue;

            const anyChecked = Array.from(radios).some(r => r.checked);
            if (!anyChecked) {
                return item;
            }
        }
        return null;
    }

    document.querySelectorAll('.q-item input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function () {
            const qItem = this.closest('.q-item');
            if (!qItem) return;
            qItem.classList.remove('error');
            const hint = qItem.querySelector('.q-error-hint');
            if (hint) hint.remove();
        });
    });

    const form             = document.getElementById('selfForm');
    const openConfirmBtn   = document.getElementById('openConfirmBtn');
    const confirmBtn       = document.getElementById('confirmSubmitBtn');
    const confirmModalEl   = document.getElementById('confirmSubmitModal');

    if (form && openConfirmBtn && confirmBtn && confirmModalEl) {
        const confirmModal = new bootstrap.Modal(confirmModalEl);

        openConfirmBtn.addEventListener('click', function () {
            confirmModal.show();
        });

        confirmBtn.addEventListener('click', function () {
            document.querySelectorAll('.q-item.error').forEach(el => el.classList.remove('error'));
            document.querySelectorAll('.q-error-hint').forEach(el => el.remove());

            const firstUnanswered = findFirstUnansweredQuestion();
            if (firstUnanswered) {
                confirmModal.hide();
                firstUnanswered.classList.add('error');

                let hint = firstUnanswered.querySelector('.q-error-hint');
                if (!hint) {
                    hint = document.createElement('div');
                    hint.className = 'q-error-hint text-danger small mt-1';
                    hint.textContent = MISSING_HINT_MSG;
                    firstUnanswered.appendChild(hint);
                }

                firstUnanswered.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                alert(MISSING_MSG);
                return;
            }

            confirmBtn.disabled = true;
            form.submit();
        });
    }

    // ===== Offline redirect =====
    (function(){
        const OFFLINE_MESSAGE = @json(__('app.offline_alert') ?? 'คุณออฟไลน์อยู่ กรุณาตรวจสอบการเชื่อมต่ออินเทอร์เน็ต');
        const OFFLINE_URL     = @json(route('offline'));

        function goOffline() {
            if (window.__supavutOfflineHandled) return;
            window.__supavutOfflineHandled = true;
            alert(OFFLINE_MESSAGE);
            window.location.href = OFFLINE_URL;
        }

        if (!navigator.onLine) {
            goOffline();
        }

        window.addEventListener('offline', goOffline);
    })();
});
</script>
</body>
</html>
