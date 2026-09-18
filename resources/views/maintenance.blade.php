<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ app()->getLocale()==='en' ? 'Closed for maintenance' : 'ปิดปรับปรุงระบบ' }}</title>
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
            } catch (e) {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>

    <style>
        :root{
            --bg: #0b1020;
            --text: rgba(255,255,255,.92);
            --muted: rgba(255,255,255,.65);
            --primary: #f5c451;
            --primary-soft: rgba(245,196,81,.18);
            --border: rgba(255,255,255,.12);
        }
        .dark-mode{
            --bg: #070a12;
            --text: rgba(255,255,255,.92);
            --muted: rgba(255,255,255,.65);
            --border: rgba(255,255,255,.12);
        }
        body{
            font-family: "Prompt", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            background:
                radial-gradient(1200px 600px at 20% -10%, rgba(245,196,81,.20), transparent 55%),
                radial-gradient(900px 500px at 90% 10%, rgba(120,180,255,.16), transparent 55%),
                radial-gradient(700px 500px at 40% 110%, rgba(170,120,255,.14), transparent 55%),
                var(--bg);
            color: var(--text);
            min-height: 100vh;
            margin: 0;
        }

        .center{
            min-height: 100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding: 24px 16px;
            text-align: center;
            position: relative;
        }

        .title{
            font-size: clamp(30px, 4vw, 56px);
            font-weight: 600;
            letter-spacing: .2px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap: 14px;
            line-height: 1.1;
            padding: 16px 18px;
            border-radius: 22px;
            background: linear-gradient(135deg, rgba(255,255,255,.08), rgba(255,255,255,.03));
            border: 1px solid var(--border);
            box-shadow: 0 18px 45px rgba(0,0,0,.28);
        }

        .cone{
            width: 62px;
            height: 62px;
            border-radius: 18px;
            display:flex;
            align-items:center;
            justify-content:center;
            background: var(--primary-soft);
            border: 1px solid rgba(245,196,81,.35);
            color: var(--primary);
            font-size: 34px;
            flex: 0 0 auto;
        }

        .logout-wrap{
            position: absolute;
            left: 50%;
            bottom: 26px;
            transform: translateX(-50%);
        }

        .logout-btn{
            display:inline-flex;
            align-items:center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: rgba(255,255,255,.06);
            color: var(--text);
            text-decoration: none;
            box-shadow: 0 14px 30px rgba(0,0,0,.25);
        }
        .logout-btn:hover{
            background: rgba(255,255,255,.10);
            color: var(--text);
        }
    </style>
</head>
<body>
@php
    $isAuth = \Illuminate\Support\Facades\Auth::check();
@endphp

<div class="center">
    <div class="title">
        <span class="cone"><i class="bi bi-cone-striped"></i></span>
        <span>ปิดปรับปรุงระบบชั่วคราว</span>
    </div>

    @if($isAuth)
        <div class="logout-wrap">
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i>
                    ออกจากระบบ
                </button>
            </form>
        </div>
    @endif
</div>
</body>
</html>
