{{-- resources/views/auth/forgot_password.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>รีเซ็ตรหัสผ่าน • {{ config('app.name', 'Supavut Assessment') }}</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg:#f5f7fb;
      --card-bg:#ffffff;
      --glass-border:rgba(209,213,219,0.9);
      --primary:#e0b761;
      --primary-soft:rgba(224,183,97,0.12);
      --text:#111827;
      --muted:#6b7280;
      --danger:#ef4444;
      --danger-soft: rgba(239, 68, 68, .12);
    }
    body.dark-mode{
      --bg:#050816;
      --card-bg:rgba(15,23,42,0.94);
      --glass-border:rgba(148,163,184,0.45);
      --primary-soft:rgba(224,183,97,0.16);
      --text:#e5e7eb;
      --muted:#9ca3af;
      --danger:#f87171;
      --danger-soft: rgba(248, 113, 113, .12);
    }
    *{box-sizing:border-box}
    body{
      margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center;
      font-family:'Prompt',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
      background: radial-gradient(circle at top,#1e293b 0,#020617 55%,#000 100%);
      color:var(--text);
      transition: background .3s ease, color .3s ease;
    }
    body:not(.dark-mode){
      background: radial-gradient(circle at top,rgba(148,163,184,0.18) 0,transparent 50%), var(--bg);
      color:var(--text);
    }
    .card-glass{
      width:100%; max-width:460px; padding:28px 24px 22px; border-radius:22px;
      background:var(--card-bg); border:1px solid var(--glass-border);
      box-shadow: 0 24px 80px rgba(15,23,42,0.95), 0 0 0 1px rgba(15,23,42,0.7);
      backdrop-filter: blur(26px);
      position:relative;
    }
    body:not(.dark-mode) .card-glass{
      box-shadow: 0 18px 55px rgba(148,163,184,0.65), 0 0 0 1px rgba(209,213,219,0.85);
    }
    .brand{font-size:1.2rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--primary)}
    .subtitle{font-size:.9rem;color:var(--muted)}
    .helper-text{font-size:.8rem;color:var(--muted)}
    .form-label{font-size:.86rem;color:var(--muted);margin-bottom:4px}
    .form-control{
      background-color:#ffffff;
      border-radius:12px;
      border:1px solid rgba(148,163,184,0.8);
      color:#111827;
      font-size:.92rem;
      padding:9px 12px;
    }
    .form-control::placeholder{color:#9ca3af}
    .form-control:focus{
      border-color:var(--primary);
      box-shadow:0 0 0 1px rgba(224,183,97,0.5);
      background-color:#ffffff;
      color:#111827;
    }
    .btn-primary{
      border-radius:999px;
      background:linear-gradient(135deg,#facc6b,#e0b761);
      border:none;
      font-weight:600;
      font-size:.95rem;
      color:#1f2933;
      padding-block:9px;
    }
    .btn-primary:hover,.btn-primary:focus{
      background:linear-gradient(135deg,#fde68a,#facc6b);
      color:#111827;
    }
    .btn-link-back{
      border-radius:999px;
      border:1px solid rgba(148,163,184,0.55);
      background:transparent;
      color:var(--muted);
      font-size:.85rem;
      padding-block:7px;
    }
    .btn-link-back:hover{
      border-color:var(--primary);
      color:var(--primary);
      background:rgba(15,23,42,0.7);
    }
    .alert-status{
      border-radius:12px;
      background:var(--primary-soft);
      border:1px solid rgba(234,179,8,0.4);
      color:var(--text);
      font-size:.85rem;
    }
    .alert-danger-soft{
      border-radius:12px;
      background:var(--danger-soft);
      border:1px solid rgba(239,68,68,0.35);
      color:var(--text);
      font-size:.85rem;
    }
    .error-text{
      font-size:.78rem;
      color: var(--danger);
      margin-top:2px;
    }

    .theme-toggle-box{
      position:absolute; top:14px; right:16px;
      display:inline-flex; align-items:center; gap:6px;
      font-size:.78rem; color:var(--muted); z-index:3;
    }
    .theme-toggle-box .form-check-input{cursor:pointer}

    .lang-switch{
      position:fixed; top:16px; right:16px; z-index:50;
    }
    .lang-switch form{display:flex; gap:6px}
    .lang-btn{
      border-radius:999px;
      border:1px solid rgba(148,163,184,0.7);
      background:rgba(15,23,42,0.9);
      color:#e5e7eb;
      font-size:.75rem;
      padding:4px 10px;
      line-height:1.1;
    }
    .lang-btn:hover{border-color:var(--primary);color:var(--primary)}
    .lang-btn.active{background:var(--primary);border-color:var(--primary);color:#111827}
    body:not(.dark-mode) .lang-btn{background:rgba(255,255,255,0.95);color:#111827}
    body:not(.dark-mode) .lang-btn.active{background:var(--primary);color:#111827}
  </style>
</head>
<body>
  @php $currentLocale = app()->getLocale(); @endphp

  {{-- เปลี่ยนภาษา TH / EN --}}
  <div class="lang-switch">
    <form method="POST" action="{{ route('locale.switch') }}">
      @csrf
      <button type="submit" name="locale" value="th" class="lang-btn {{ $currentLocale === 'th' ? 'active' : '' }}">TH</button>
      <button type="submit" name="locale" value="en" class="lang-btn {{ $currentLocale === 'en' ? 'active' : '' }}">EN</button>
    </form>
  </div>

  <div class="card-glass">
    {{-- Toggle theme --}}
    <div class="theme-toggle-box">
      <i class="bi bi-moon-stars me-1"></i>
      <div class="form-check form-switch m-0">
        <input class="form-check-input" type="checkbox" id="themeToggle">
      </div>
      <span>{{ __('app.theme_dark') }}</span>
    </div>

    <div class="mb-3 text-center">
      <div class="brand">{{ config('app.name', 'Supavut Assessment') }}</div>
      <div class="subtitle mt-1">
        {{ $currentLocale === 'en' ? 'Reset Password' : 'รีเซ็ตรหัสผ่าน' }}
      </div>
      <div class="helper-text mt-1">
        {{ $currentLocale === 'en'
            ? 'Enter your employee code and national ID number to set a new password.'
            : 'กรอกรหัสพนักงานและรหัสบัตรประชาชน เพื่อกำหนดรหัสผ่านใหม่' }}
      </div>
    </div>

    {{-- success / error --}}
    @if (session('success'))
      <div class="alert alert-status py-2 px-3 mb-3">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('success') }}
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger-soft py-2 px-3 mb-3">
        <i class="bi bi-exclamation-triangle me-1"></i>
        {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.reset.citizen') }}" novalidate>
      @csrf

      {{-- Employee code --}}
      <div class="mb-3">
        <label class="form-label">
          {{ $currentLocale === 'en' ? 'Employee Code' : 'รหัสพนักงาน' }}
        </label>
        <input
          type="text"
          name="username"
          class="form-control @error('username') is-invalid @enderror"
          value="{{ old('username') }}"
          autocomplete="username"
          inputmode="numeric"
          placeholder="{{ $currentLocale === 'en' ? 'e.g. 61001' : 'เช่น 61001' }}"
          autofocus
        >
        @error('username')
          <div class="error-text"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
        @enderror
      </div>

      {{-- National ID --}}
      <div class="mb-3">
        <label class="form-label">
          {{ $currentLocale === 'en' ? 'National ID' : 'รหัสบัตรประชาชน' }}
        </label>
        <input
          type="text"
          name="citizen_id"
          class="form-control @error('citizen_id') is-invalid @enderror"
          value="{{ old('citizen_id') }}"
          inputmode="numeric"
          maxlength="13"
          placeholder="{{ $currentLocale === 'en' ? '13 digits' : '13 หลัก' }}"
        >
        @error('citizen_id')
          <div class="error-text"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
        @enderror
      </div>

      {{-- New password --}}
      <div class="mb-3">
        <label class="form-label">
          {{ $currentLocale === 'en' ? 'New Password' : 'รหัสผ่านใหม่' }}
        </label>
        <input
          type="password"
          name="password"
          class="form-control @error('password') is-invalid @enderror"
          autocomplete="new-password"
          placeholder="{{ $currentLocale === 'en' ? 'At least 8 characters' : 'อย่างน้อย 8 ตัวอักษร' }}"
        >
        @error('password')
          <div class="error-text"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
        @enderror
      </div>

      {{-- Confirm --}}
      <div class="mb-3">
        <label class="form-label">
          {{ $currentLocale === 'en' ? 'Confirm New Password' : 'ยืนยันรหัสผ่านใหม่' }}
        </label>
        <input
          type="password"
          name="password_confirmation"
          class="form-control"
          autocomplete="new-password"
          placeholder="{{ $currentLocale === 'en' ? 'Re-enter new password' : 'กรอกรหัสผ่านใหม่อีกครั้ง' }}"
        >
      </div>

      {{-- error รวม ถ้ารหัสพนักงาน + บัตรประชาชน ไม่ตรงกัน --}}
      @if ($errors->has('credentials'))
        <div class="error-text mb-2">
          <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first('credentials') }}
        </div>
      @endif

      <button type="submit" class="btn btn-primary w-100 mb-2">
        <i class="bi bi-shield-check me-1"></i>
        {{ $currentLocale === 'en' ? 'Reset Password' : 'รีเซ็ตรหัสผ่าน' }}
      </button>
    </form>

    <div class="d-flex justify-content-center mt-2">
      <a href="{{ url('/') }}" class="btn btn-link-back w-100 text-decoration-none text-center">
        <i class="bi bi-arrow-left me-1"></i>
        {{ $currentLocale === 'en' ? 'Back to login' : 'กลับไปหน้าเข้าสู่ระบบ' }}
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function () {
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

      document.addEventListener('DOMContentLoaded', function () {
        applyTheme(getInitialTheme());
        if (toggle) {
          toggle.addEventListener('change', function () {
            applyTheme(this.checked ? 'dark' : 'light');
          });
        }
      });
    })();
  </script>
</body>
</html>
