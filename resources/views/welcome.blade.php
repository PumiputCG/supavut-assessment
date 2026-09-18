<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('app.site_title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Noto+Sans+Thai:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #ffb800;
            --primary-dark: #cc9300;
            --bg-dark: #0f0f0f;
            --panel: rgba(16, 16, 16, 0.82);
            --card: #ffffff;
            --card-text: #111827;
            --card-muted: #6b7280;
            --field-bg: #f8fafc;
            --field-border: #d1d5db;
            --text-main: #ffffff;
            --text-muted: #a3a3a3;
            --border-dim: #333333;
            --font-family: 'Inter', 'Noto Sans Thai', sans-serif;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            min-height: 100%;
            font-family: var(--font-family);
            color: var(--text-main);
            background: var(--bg-dark);
        }

        body {
            position: relative;
            padding-top: 84px;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -2;
            background-image: url("{{ asset('images/pb-bg-02.jpg') }}");
            background-size: cover;
            background-position: center;
            filter: brightness(0.45) saturate(0.9);
            transform: scale(1.03);
        }

        body::after {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -1;
            background: linear-gradient(to bottom, rgba(15, 15, 15, 0.55), rgba(15, 15, 15, 0.92));
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background: var(--panel);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-dim);
        }

        .nav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 72px;
            width: 100%;
            padding: 0 2rem;
            gap: 1rem;
        }

        .nav-logo {
            color: var(--primary);
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            white-space: nowrap;
        }

        .nav-logo span {
            font-weight: 300;
            color: #fff;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            margin-left: auto;
        }

        .home-btn {
            color: var(--primary);
            text-decoration: none;
            font-size: 1.15rem;
            line-height: 1;
            transition: color 0.25s ease;
        }

        .home-btn:hover { color: #fff; }

        .lang-switch form {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            margin: 0;
            padding: 0;
        }

        .lang-btn {
            appearance: none;
            border: 0;
            background: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1rem;
            font-weight: 400;
            letter-spacing: 0.06em;
            padding: 0;
            transition: color 0.2s ease;
        }

        .lang-btn[data-active="true"] { color: var(--primary); }
        .lang-btn:hover { color: #fff; }

        .login-shell {
            min-height: calc(100vh - 84px);
            display: grid;
            place-items: center;
            padding: 0.5rem 1rem 3rem;
        }

        .login-card {
            width: 100%;
            max-width: 460px;
            background: var(--card);
            color: var(--card-text);
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 2rem 1.5rem 1.4rem;
            box-shadow: 0 24px 56px rgba(0, 0, 0, 0.35);
        }

        .logo-wrap {
            text-align: center;
            margin-bottom: 0.9rem;
        }

        .logo-img {
            width: 88px;
            height: 88px;
            object-fit: contain;
            border-radius: 0;
            background: transparent;
            padding: 0;
        }

        .brand-title {
            margin: 0.45rem 0 0.25rem;
            text-align: center;
            font-size: 1.45rem;
            font-weight: 500;
            color: var(--card-text);
        }

        .brand-subtitle {
            margin: 0 0 1.25rem;
            text-align: center;
            font-size: 0.92rem;
            color: var(--card-muted);
        }

        .alert-box {
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #991b1b;
            border-radius: 12px;
            padding: 0.8rem 0.9rem;
            margin-bottom: 1rem;
            font-size: 0.88rem;
        }

        .alert-box ul {
            margin: 0.45rem 0 0;
            padding-left: 1.1rem;
        }

        .field {
            margin: 0 auto 0.8rem;
            width: min(100%, 340px);
        }

        .field label {
            display: inline-block;
            font-size: 0.84rem;
            color: var(--card-text);
            margin-bottom: 0.35rem;
        }

        .field input {
            width: 100%;
            border-radius: 999px;
            border: 1px solid var(--field-border);
            background: var(--field-bg);
            color: #111827;
            padding: 0.58rem 0.9rem;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 184, 0, 0.2);
        }

        .forgot-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 0.15rem;
            margin-bottom: 0.65rem;
            width: min(100%, 340px);
            margin-left: auto;
            margin-right: auto;
        }

        .forgot-link {
            border: 0;
            background: none;
            color: var(--card-muted);
            font-size: 0.82rem;
            cursor: pointer;
            text-decoration: none;
            padding: 0;
        }

        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .btn-login {
            width: min(100%, 340px);
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-top: 0.3rem;
            border: 1px solid transparent;
            border-radius: 999px;
            background: var(--primary);
            color: #111827;
            padding: 0.6rem 0.95rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .btn-login:hover {
            background: #111827;
            color: var(--primary);
            border-color: var(--primary);
        }

        .footer-text {
            margin-top: 1.2rem;
            text-align: center;
            font-size: 0.78rem;
            color: var(--card-muted);
        }

        .fp-modal {
            position: fixed;
            inset: 0;
            z-index: 1200;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .fp-modal.is-open { display: flex; }

        .fp-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
        }

        .fp-dialog {
            position: relative;
            width: min(100%, 460px);
            background: #fff;
            color: #111827;
            border-radius: 18px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 24px 56px rgba(0, 0, 0, 0.35);
            padding: 1.1rem 1rem 1rem;
            z-index: 1;
        }

        .fp-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.6rem;
            margin-bottom: 0.65rem;
        }

        .fp-title {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 600;
        }

        .fp-close {
            border: 0;
            background: transparent;
            font-size: 1.1rem;
            color: #6b7280;
            cursor: pointer;
            line-height: 1;
            padding: 0.1rem;
        }

        .fp-close:hover { color: #111827; }

        .fp-step.hidden { display: none; }

        .fp-emp {
            margin: 0 0 0.75rem;
            padding: 0.65rem 0.7rem;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
        }

        .fp-emp-name {
            margin: 0;
            font-size: 0.92rem;
            font-weight: 600;
            color: #111827;
        }

        .fp-emp-meta {
            margin: 0.2rem 0 0;
            font-size: 0.8rem;
            color: #6b7280;
        }

        .fp-msg {
            display: none;
            margin-top: 0.55rem;
            border-radius: 10px;
            padding: 0.55rem 0.65rem;
            font-size: 0.82rem;
        }

        .fp-msg.show { display: block; }
        .fp-msg.error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .fp-msg.success { background: #ecfdf5; border: 1px solid #86efac; color: #166534; }

        .fp-actions {
            display: flex;
            gap: 0.55rem;
            margin-top: 0.65rem;
        }

        .fp-btn {
            border: 0;
            border-radius: 999px;
            padding: 0.58rem 0.95rem;
            font-size: 0.86rem;
            cursor: pointer;
        }

        .fp-btn.primary {
            background: var(--primary);
            color: #111827;
            font-weight: 600;
            flex: 1;
        }

        .fp-btn.secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .fp-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        @media (max-width: 900px) {
            body { padding-top: 92px; }

            .nav-content {
                min-height: 78px;
                padding: 0.8rem 1rem;
                flex-wrap: wrap;
            }

            .nav-logo { font-size: 1rem; }
            .home-btn { font-size: 1rem; }
            .lang-btn { font-size: 0.92rem; }

            .login-shell {
                min-height: calc(100vh - 92px);
                padding: 0.35rem 1rem 2.3rem;
            }

            .fp-dialog { width: min(100%, 420px); }
        }
    </style>
</head>
<body>

<header>
    <div class="nav-content" data-aos="fade-down" data-aos-duration="700">
        <a href="{{ route('landing') }}" class="nav-logo">SUPAVUT <span>ASSESSMENT</span></a>

        <div class="nav-right">
            <a href="{{ route('landing') }}" class="home-btn" title="{{ __('app.guide_back_to_welcome') }}" aria-label="{{ __('app.guide_back_to_welcome') }}">
                <i class="bi bi-house-door-fill"></i>
            </a>

            <div class="lang-switch" aria-label="{{ __('app.aria_language_switcher') }}">
                <form id="localeForm" action="{{ route('locale.switch') }}" method="POST">
                    @csrf
                    <input type="hidden" name="locale" id="localeInput">
                    <button type="button" class="lang-btn" data-locale="th" data-active="{{ app()->getLocale()==='th' ? 'true' : 'false' }}">TH</button>
                    <button type="button" class="lang-btn" data-locale="en" data-active="{{ app()->getLocale()==='en' ? 'true' : 'false' }}">EN</button>
                </form>
            </div>
        </div>
    </div>
</header>

<main class="login-shell">
    <section class="login-card" aria-label="login card" data-aos="zoom-in" data-aos-duration="750">
        <div class="logo-wrap" data-aos="fade-up" data-aos-delay="60">
            <img src="{{ asset('images/logo.jpg') }}" class="logo-img" alt="{{ __('app.logo_alt') }}">
        </div>

        <h1 class="brand-title" data-aos="fade-up" data-aos-delay="90">{{ __('app.brand') }}</h1>
        <p class="brand-subtitle" data-aos="fade-up" data-aos-delay="120">{{ __('app.login_subtitle') }}</p>

        @if ($errors->any() || session('error'))
            <div class="alert-box" role="alert" data-aos="fade-up" data-aos-delay="140">
                @if (session('error'))
                    <div>{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}" data-aos="fade-up" data-aos-delay="160">
            @csrf

            <div class="field">
                <label for="username">{{ __('app.employee_id') }}</label>
                <input
                    id="username"
                    name="username"
                    type="text"
                    value="{{ old('username') }}"
                    autocomplete="username"
                    required
                >
            </div>

            <div class="field">
                <label for="password">{{ __('app.password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <div class="forgot-row">
                <button type="button" class="forgot-link" id="btnForgotPwd">{{ __('app.forgot_password') }}</button>
            </div>

            <button type="submit" class="btn-login">{{ __('app.login_button') }}</button>
        </form>

        <div class="footer-text" data-aos="fade-up" data-aos-delay="180">
            {{ __('app.footer_copyright', ['year' => date('Y')]) }}
        </div>
    </section>
</main>

<div class="fp-modal" id="forgotModal" aria-hidden="true">
    <div class="fp-backdrop" id="fpBackdrop"></div>

    <div class="fp-dialog" role="dialog" aria-modal="true" aria-labelledby="fpTitle">
        <div class="fp-header">
            <h2 class="fp-title" id="fpTitle">{{ __('app.fp_modal_title') }}</h2>
            <button type="button" class="fp-close" id="fpCloseBtn" aria-label="{{ __('app.fp_close') }}">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="fp-step" id="fpStep1">
            <div class="field">
                <label for="fp_employee_code">{{ __('app.employee_id') }}</label>
                <input id="fp_employee_code" type="text">
            </div>

            <div class="field">
                <label for="fp_citizen_id">{{ __('app.fp_citizen_id_label') }}</label>
                <input id="fp_citizen_id" type="password">
            </div>

            <button type="button" class="fp-btn primary" id="btnFpVerify">{{ __('app.fp_verify') }}</button>
            <div class="fp-msg error" id="fpErr1"></div>
        </div>

        <div class="fp-step hidden" id="fpStep2">
            <div class="fp-emp" id="fpEmpBox">
                <p class="fp-emp-name" id="fpEmpName">-</p>
                <p class="fp-emp-meta" id="fpEmpMeta">-</p>
            </div>

            <div class="field">
                <label for="fp_new_password">{{ __('app.fp_new_password') }}</label>
                <input id="fp_new_password" type="password">
            </div>

            <div class="field">
                <label for="fp_new_password_confirmation">{{ __('app.fp_confirm_password') }}</label>
                <input id="fp_new_password_confirmation" type="password">
            </div>

            <div class="fp-actions">
                <button type="button" class="fp-btn secondary" id="btnFpBack">{{ __('app.fp_back') }}</button>
                <button type="button" class="fp-btn primary" id="btnFpReset">{{ __('app.fp_save_new_password') }}</button>
            </div>

            <div class="fp-msg error" id="fpErr2"></div>
            <div class="fp-msg success" id="fpSuccess"></div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.AOS) {
            AOS.init({
                duration: 700,
                easing: 'ease-out-cubic',
                once: true,
                offset: 40
            });
        }

        const form = document.getElementById('localeForm');
        const input = document.getElementById('localeInput');

        if (form && input) {
            form.querySelectorAll('.lang-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    input.value = btn.dataset.locale;
                    form.submit();
                });
            });
        }

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        const modal = document.getElementById('forgotModal');
        const openBtn = document.getElementById('btnForgotPwd');
        const closeBtn = document.getElementById('fpCloseBtn');
        const backdrop = document.getElementById('fpBackdrop');

        const step1 = document.getElementById('fpStep1');
        const step2 = document.getElementById('fpStep2');

        const empCode = document.getElementById('fp_employee_code');
        const citizenId = document.getElementById('fp_citizen_id');
        const newPwd = document.getElementById('fp_new_password');
        const newPwdConfirm = document.getElementById('fp_new_password_confirmation');

        const fpEmpName = document.getElementById('fpEmpName');
        const fpEmpMeta = document.getElementById('fpEmpMeta');

        const btnVerify = document.getElementById('btnFpVerify');
        const btnBack = document.getElementById('btnFpBack');
        const btnReset = document.getElementById('btnFpReset');

        const err1 = document.getElementById('fpErr1');
        const err2 = document.getElementById('fpErr2');
        const okBox = document.getElementById('fpSuccess');

        const usernameInput = document.getElementById('username');

        let resetState = null;

        const TXT = {
            verify: @json(__('app.fp_verify')),
            verifying: @json(__('app.fp_verifying')),
            save: @json(__('app.fp_save_new_password')),
            saving: @json(__('app.fp_saving')),
            errEmpRequired: @json(__('app.fp_err_employee_required')),
            errCidRequired: @json(__('app.fp_err_citizen_required')),
            errCidInvalid: @json(__('app.fp_err_citizen_invalid')),
            errVerifyFailed: @json(__('app.fp_err_verify_failed')),
            errGeneral: @json(__('app.fp_err_general')),
            errSessionInvalid: @json(__('app.fp_err_session_invalid')),
            errPwdMin: @json(__('app.fp_err_pwd_min')),
            errPwdMismatch: @json(__('app.fp_err_pwd_mismatch')),
            success: @json(__('app.fp_success'))
        };

        function openModal() {
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            setTimeout(() => { empCode.focus(); }, 10);
        }

        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            resetModal();
        }

        function resetModal() {
            resetState = null;
            step1.classList.remove('hidden');
            step2.classList.add('hidden');

            empCode.value = '';
            citizenId.value = '';
            newPwd.value = '';
            newPwdConfirm.value = '';

            fpEmpName.textContent = '-';
            fpEmpMeta.textContent = '-';

            hideMsg(err1);
            hideMsg(err2);
            hideMsg(okBox);

            btnVerify.disabled = false;
            btnVerify.textContent = TXT.verify;
            btnReset.disabled = false;
            btnReset.textContent = TXT.save;
        }

        function showMsg(el, msg, type) {
            el.textContent = msg;
            el.classList.remove('error', 'success', 'show');
            el.classList.add(type, 'show');
        }

        function hideMsg(el) {
            el.textContent = '';
            el.classList.remove('show');
        }

        if (openBtn) openBtn.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (backdrop) backdrop.addEventListener('click', closeModal);

        window.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) {
                closeModal();
            }
        });

        if (btnVerify) {
            btnVerify.addEventListener('click', async function () {
                hideMsg(err1);
                hideMsg(err2);
                hideMsg(okBox);

                const code = (empCode.value || '').trim();
                const cid = (citizenId.value || '').trim();

                if (!code) {
                    showMsg(err1, TXT.errEmpRequired, 'error');
                    return;
                }
                if (!cid) {
                    showMsg(err1, TXT.errCidRequired, 'error');
                    return;
                }
                if (!/^\d{13}$/.test(cid)) {
                    showMsg(err1, TXT.errCidInvalid, 'error');
                    return;
                }

                btnVerify.disabled = true;
                btnVerify.textContent = TXT.verifying;

                try {
                    const res = await fetch(@json(route('password.forgot.verify')), {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify({ employee_code: code, citizen_id: cid })
                    });

                    const data = await res.json().catch(() => ({}));
                    btnVerify.disabled = false;
                    btnVerify.textContent = TXT.verify;

                    if (!res.ok || !data.ok) {
                        showMsg(err1, data.message || TXT.errVerifyFailed, 'error');
                        return;
                    }

                    resetState = { code: code, key: data.reset_key || '' };

                    const emp = data.employee || {};
                    fpEmpName.textContent = emp.name || '-';
                    fpEmpMeta.textContent = [emp.position, emp.department].filter(Boolean).join(' | ') || '-';

                    step1.classList.add('hidden');
                    step2.classList.remove('hidden');
                    newPwd.focus();
                } catch (e) {
                    btnVerify.disabled = false;
                    btnVerify.textContent = TXT.verify;
                    showMsg(err1, TXT.errGeneral, 'error');
                }
            });
        }

        if (btnBack) {
            btnBack.addEventListener('click', function () {
                step2.classList.add('hidden');
                step1.classList.remove('hidden');
                hideMsg(err2);
                hideMsg(okBox);
                newPwd.value = '';
                newPwdConfirm.value = '';
                resetState = null;
                empCode.focus();
            });
        }

        if (btnReset) {
            btnReset.addEventListener('click', async function () {
                hideMsg(err2);
                hideMsg(okBox);

                if (!resetState || !resetState.code || !resetState.key) {
                    showMsg(err2, TXT.errSessionInvalid, 'error');
                    return;
                }

                const p1 = (newPwd.value || '').trim();
                const p2 = (newPwdConfirm.value || '').trim();

                if (!p1 || p1.length < 8) {
                    showMsg(err2, TXT.errPwdMin, 'error');
                    return;
                }
                if (p1 !== p2) {
                    showMsg(err2, TXT.errPwdMismatch, 'error');
                    return;
                }

                btnReset.disabled = true;
                btnReset.textContent = TXT.saving;

                try {
                    const res = await fetch(@json(route('password.forgot.reset')), {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify({
                            employee_code: resetState.code,
                            reset_key: resetState.key,
                            password: p1,
                            password_confirmation: p2
                        })
                    });

                    const data = await res.json().catch(() => ({}));
                    btnReset.disabled = false;
                    btnReset.textContent = TXT.save;

                    if (!res.ok || !data.ok) {
                        showMsg(err2, data.message || TXT.errGeneral, 'error');
                        return;
                    }

                    showMsg(okBox, data.message || TXT.success, 'success');
                    if (usernameInput) usernameInput.value = resetState.code;

                    setTimeout(() => {
                        closeModal();
                    }, 900);
                } catch (e) {
                    btnReset.disabled = false;
                    btnReset.textContent = TXT.save;
                    showMsg(err2, TXT.errGeneral, 'error');
                }
            });
        }

        (function () {
            const OFFLINE_MESSAGE = @json(__('app.offline_alert'));
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
