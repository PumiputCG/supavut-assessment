{{-- resources/views/offline.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ __('app.alert_title') }} • Supavut Assessment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Prompt', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .offline-card {
            max-width: 480px;
            width: 100%;
        }

        .lang-row {
            font-size: 0.85rem;
        }

        .lang-row form {
            display: inline-flex;
            gap: 6px;
            margin: 0;
        }

        .lang-btn {
            border-radius: 999px;
            padding: 2px 10px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
        }

        .lang-btn[data-active="true"] {
            background: #1f2937;
            color: #f9fafb;
            border-color: #1f2937;
        }
    </style>
</head>
<body>
<div class="offline-card">
    <div class="card shadow-sm">
        <div class="card-body">
            {{-- แถวเปลี่ยนภาษาแบบง่าย ๆ --}}
            <div class="d-flex justify-content-end mb-2 lang-row">
                <form id="localeForm" action="{{ route('locale.switch') }}" method="POST">
                    @csrf
                    <input type="hidden" name="locale" id="localeInput">
                    <button type="button"
                            class="lang-btn"
                            data-locale="th"
                            data-active="{{ app()->getLocale()==='th' ? 'true' : 'false' }}">
                        {{ __('app.lang_th') }}
                    </button>
                    <button type="button"
                            class="lang-btn"
                            data-locale="en"
                            data-active="{{ app()->getLocale()==='en' ? 'true' : 'false' }}">
                        {{ __('app.lang_en') }}
                    </button>
                </form>
            </div>

            <div class="text-center">
                <div class="mb-3">
                    <i class="bi bi-wifi-off" style="font-size: 2.5rem; color:#6b7280;"></i>
                </div>

                <h5 class="mb-2">
                    {{ __('app.alert_title') }}
                </h5>

                <p class="text-muted mb-4" style="font-size:0.9rem;">
                    {{ __('app.offline_alert') }}
                </p>

                <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                    {{-- ลองใหม่อีกครั้ง: ถ้าต่อเน็ตแล้วให้กลับไปหน้าก่อน / ไม่มีก็กลับหน้า welcome --}}
                    <button type="button" id="btnRetry" class="btn btn-primary">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        @if(app()->getLocale() === 'en')
                            Try again
                        @else
                            ลองใหม่อีกครั้ง
                        @endif
                    </button>
                </div>

                <p class="text-muted mt-3 mb-0" style="font-size:0.8rem;">
                    Supavut Assessment • Annual Evaluation
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ===== Language switcher =====
    const form  = document.getElementById('localeForm');
    const input = document.getElementById('localeInput');

    if (form && input) {
        form.querySelectorAll('.lang-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                input.value = btn.dataset.locale;
                form.submit();
            });
        });
    }

    // ===== ปุ่ม "ลองใหม่อีกครั้ง" =====
    const retryBtn = document.getElementById('btnRetry');
    if (retryBtn) {
        retryBtn.addEventListener('click', function () {
            // ยังออฟไลน์อยู่
            if (!navigator.onLine) {
                alert(
                    @json(
                        app()->getLocale() === 'en'
                        ? 'You are still offline. Please check your internet connection.'
                        : 'ยังออฟไลน์อยู่ กรุณาตรวจสอบการเชื่อมต่ออินเทอร์เน็ต'
                    )
                );
                return;
            }

            // ออนไลน์แล้ว: ถ้ามี history ให้ย้อนกลับไปหน้าก่อนเข้า offline
            if (window.history.length > 1) {
                window.history.back();
            } else {
                // ถ้าไม่มี history (เช่น เข้าหน้านี้ตรง ๆ) ให้กลับหน้า welcome
                window.location.href = @json(url('/'));
            }
        });
    }
});
</script>
</body>
</html>
