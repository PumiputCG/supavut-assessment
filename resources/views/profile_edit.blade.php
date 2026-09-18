<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ __('app.edit_profile_title') }} • Supavut Assessment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f5f7fb;
            --card-bg: #ffffff;
            --primary: #1e3a8a;
            --primary-soft: rgba(30,58,138,0.12);
            --border-soft: rgba(148,163,184,0.4);
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
            --primary-soft: rgba(224,183,97,0.18);
            --border-soft: rgba(148,163,184,0.7);
            --text-main: #e5e7eb;
            --text-muted: #9ca3af;
            --glass-bg: rgba(15,23,42,0.96);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Prompt', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at top, rgba(56,189,248,0.16) 0, transparent 55%),
                radial-gradient(circle at bottom, rgba(234,179,8,0.2) 0, transparent 60%),
                var(--bg);
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 20px 16px 28px;
            color: var(--text-main);
            transition: background-color .25s ease, color .25s ease;
        }

        .page-wrap { width: 100%; max-width: 720px; }

        .top-right-stack {
            position: fixed;
            top: 12px;
            right: 14px;
            display: flex;
            flex-direction: row;
            gap: 8px;
            align-items: center;
            justify-content: flex-end;
            z-index: 50;
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
            box-shadow: 0 10px 24px rgba(15,23,42,0.28);
            white-space: nowrap;
        }
        .theme-toggle-box .form-check-input { cursor: pointer; }

        .edit-card {
            background: var(--card-bg);
            border-radius: 22px;
            padding: 22px 22px 20px;
            border: 1px solid var(--border-soft);
            box-shadow:
                0 22px 50px rgba(15,23,42,0.45),
                0 0 0 1px rgba(255,255,255,0.04);
            position: relative;
            overflow: hidden;
        }

        body.dark-mode .edit-card {
            box-shadow:
                0 26px 60px rgba(15,23,42,0.9),
                0 0 0 1px rgba(148,163,184,0.35);
        }

        .edit-card::before {
            content: "";
            position: absolute;
            inset: -40%;
            background:
                radial-gradient(circle at 0 0, rgba(56,189,248,0.18), transparent 55%),
                radial-gradient(circle at 100% 100%, rgba(234,179,8,0.20), transparent 55%);
            opacity: 0.55;
            pointer-events: none;
        }

        .edit-inner { position: relative; z-index: 1; }

        .page-title {
            font-weight: 700;
            font-size: 1.22rem;
            margin: 8px 0 14px;
            letter-spacing: .02em;
        }

        .stack-gap { display: flex; flex-direction: column; gap: 14px; }

        .divider-soft {
            height: 1px;
            margin: 12px 0 16px;
            background: linear-gradient(90deg, transparent, rgba(148,163,184,0.55), transparent);
        }

        .card-title {
            font-weight: 700;
            font-size: 1.02rem;
            margin: 0;
            letter-spacing: .01em;
        }

        .form-label { font-size: 0.88rem; font-weight: 600; margin-bottom: 4px; }

        .form-control {
            border-radius: 11px;
            border: 1px solid var(--border-soft);
            background: #ffffff;
            color: var(--text-main);
            font-size: 0.94rem;
        }
        body.dark-mode .form-control { background: #ffffff; color: #111827; }

        .form-control:focus {
            border-color: #facc6b;
            box-shadow: 0 0 0 0.14rem rgba(250,204,21,0.3);
        }

        .password-toggle-group .form-control {
            border-right: 0;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .password-toggle-btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-color: var(--border-soft);
            background: #f9fafb;
        }
        body.dark-mode .password-toggle-btn { background: #0b1220; color: #e5e7eb; }
        .password-toggle-btn:hover { background: #e5e7eb; }
        body.dark-mode .password-toggle-btn:hover { background: #111827; }

        .btn-primary-assess {
            border-radius: 999px;
            padding: 0.55rem 1.4rem;
            font-size: 0.94rem;
            font-weight: 700;
            border: none;
            background: linear-gradient(135deg,#facc6b,#e0b761);
            color: #111827;
            box-shadow: 0 10px 24px rgba(250,204,21,0.4), inset 0 1px 0 rgba(255,255,255,0.8);
            transition: all .16s ease-out;
        }
        .btn-primary-assess:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
            box-shadow: 0 13px 28px rgba(250,204,21,0.55), inset 0 1px 0 rgba(255,255,255,0.9);
            color: #020617;
        }

        .btn-ghost {
            border-radius: 999px;
            padding: 0.55rem 1.4rem;
            font-size: 0.94rem;
            font-weight: 500;
            border: 1px solid var(--border-soft);
            background: transparent;
            color: var(--text-main);
            transition: all .16s ease-out;
        }
        body.dark-mode .btn-ghost { background: rgba(15,23,42,0.9); }
        .btn-ghost:hover { background: rgba(148,163,184,0.1); }

        .alert-custom { border-radius: 11px; font-size: 0.9rem; }

        .avatar-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }
        .avatar {
            width: 58px;
            height: 58px;
            border-radius: 999px;
            border: 2px solid rgba(250,204,21,0.65);
            box-shadow: 0 10px 26px rgba(15,23,42,0.35);
            overflow: hidden;
            flex-shrink: 0;
            background: rgba(148,163,184,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .avatar i { font-size: 1.6rem; color: rgba(148,163,184,0.85); }

        @media (max-width: 768px) {
            .edit-card { padding: 18px 16px 16px; }
            .top-right-stack { right: 10px; top: 10px; gap: 6px; }
            .theme-toggle-box span { display: none; }
        }
    </style>
</head>
<body>
@php
    $user = Auth::user();
    $profileUrl = null;
    if ($user && !empty($user->profile_picture)) {
        $profileUrl = asset('storage/'.$user->profile_picture);
    }
    $loc = app()->getLocale();
    $pwTitle = ($loc === 'en') ? 'Change Password' : 'เปลี่ยนรหัสผ่าน';
@endphp

<div class="top-right-stack">
    <div class="lang-switch" aria-label="{{ __('app.lang_switcher_aria') }}">
        <form id="localeForm" action="{{ route('locale.switch') }}" method="POST">
            @csrf
            <input type="hidden" name="locale" id="localeInput">
            <button type="button"
                    class="lang-btn-square"
                    data-locale="th"
                    data-active="{{ app()->getLocale()==='th' ? 'true' : 'false' }}">
                {{ __('app.lang_th') }}
            </button>
            <button type="button"
                    class="lang-btn-square"
                    data-locale="en"
                    data-active="{{ app()->getLocale()==='en' ? 'true' : 'false' }}">
                {{ __('app.lang_en') }}
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

<div class="page-wrap">
    <div class="page-title">{{ __('app.edit_profile_title') }}</div>

    @if ($errors->any())
        <div class="alert alert-danger alert-custom mb-3">
            <ul class="m-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-custom mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="stack-gap">
        <div class="edit-card">
            <div class="edit-inner">
                <div class="card-title">{{ __('app.profile_picture') }}</div>
                <div class="divider-soft"></div>

                <form action="{{ route('profile.update.picture') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      novalidate>
                    @csrf
                    @method('PUT')

                    <div class="avatar-row">
                        <div class="avatar" id="avatarBox">
                            @if ($profileUrl)
                                <img id="avatarImg" src="{{ $profileUrl }}" alt="profile">
                            @else
                                <i class="bi bi-person-circle" id="avatarIcon"></i>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">
                            {{ __('app.choose_profile_picture') }}
                        </label>
                        <input type="file"
                               id="profile_picture"
                               name="profile_picture"
                               accept="image/*"
                               class="form-control @error('profile_picture') is-invalid @enderror"
                               required>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary-assess">
                            {{ __('app.save_profile_picture') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="edit-card">
            <div class="edit-inner">
                <div class="card-title">{{ $pwTitle }}</div>
                <div class="divider-soft"></div>

                <form action="{{ route('profile.update.password') }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="citizen_id_password" class="form-label">{{ __('app.citizen_id_label') }}</label>
                        <input type="text"
                               id="citizen_id_password"
                               name="citizen_id_password"
                               class="form-control @error('citizen_id_password') is-invalid @enderror"
                               required
                               inputmode="numeric"
                               autocomplete="off"
                               maxlength="13"
                               placeholder="{{ __('app.citizen_id_placeholder') }}"
                               value="{{ old('citizen_id_password') }}">
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="password" class="form-label">
                                {{ __('app.new_password') }}
                            </label>
                            <div class="input-group password-toggle-group">
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       required
                                       autocomplete="new-password">
                                <button type="button"
                                        class="btn btn-outline-secondary password-toggle-btn"
                                        data-target="#password"
                                        aria-label="Toggle password visibility">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="password_confirmation" class="form-label">
                                {{ __('app.new_password_confirmation') }}
                            </label>
                            <div class="input-group password-toggle-group">
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       class="form-control"
                                       required
                                       autocomplete="new-password">
                                <button type="button"
                                        class="btn btn-outline-secondary password-toggle-btn"
                                        data-target="#password_confirmation"
                                        aria-label="Toggle password visibility">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mt-4">
                        <a href="{{ route('profile') }}" class="btn btn-ghost">
                            {{ __('app.back_to_profile') }}
                        </a>
                        <button type="submit" class="btn btn-primary-assess ms-auto">
                            {{ __('app.save_password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const THEME_STORAGE_KEY = 'supavut_theme_mode';
    const toggle = document.getElementById('themeToggle');

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

    document.querySelectorAll('.password-toggle-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetSelector = btn.getAttribute('data-target');
            const input = document.querySelector(targetSelector);
            if (!input) return;

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            const icon = btn.querySelector('i');
            if (icon) {
                if (isPassword) {
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                } else {
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                }
            }
        });
    });

    const picInput = document.getElementById('profile_picture');
    const avatarBox = document.getElementById('avatarBox');
    const existingImg = document.getElementById('avatarImg');
    const existingIcon = document.getElementById('avatarIcon');

    if (picInput) {
        picInput.addEventListener('change', () => {
            const file = picInput.files && picInput.files[0];
            if (!file) return;

            const url = URL.createObjectURL(file);
            if (existingIcon) existingIcon.remove();

            if (existingImg) {
                existingImg.src = url;
            } else {
                const img = document.createElement('img');
                img.id = 'avatarImg';
                img.src = url;
                img.alt = 'profile';
                avatarBox.innerHTML = '';
                avatarBox.appendChild(img);
            }
        });
    }

    (function bindCitizenInput(){
        const el = document.getElementById('citizen_id_password');
        if (!el) return;
        el.addEventListener('input', () => {
            el.value = (el.value || '').replace(/\D/g,'').slice(0,13);
        });
    })();

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
