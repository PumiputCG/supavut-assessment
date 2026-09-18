<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SUPAVUT ASSESSMENT</title>
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&family=Prompt:wght@200;300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #FFB800; 
            --primary-dark: #cc9300;
            --bg-dark: #0f0f0f; 
            --bg-card: #1a1a1a;
            --text-main: #ffffff;
            --text-muted: #a3a3a3;
            --border-dim: #333333;
            
            --font-heading: 'Montserrat', sans-serif;
            --font-body: 'Prompt', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
            font-family: var(--font-body);
            background-color: var(--bg-dark);
            color: var(--text-main);
        }

        body { overflow-x: hidden; line-height: 1.6; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }

        /* ----- NAVIGATION ----- */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(15, 15, 15, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-dim);
            z-index: 1000;
        }

        .nav-content { display: flex; align-items: center; justify-content: space-between; height: 80px; width: 100%; padding: 0 2.5rem; }
        .nav-left { display: flex; align-items: center; gap: 2.8rem; min-width: 0; }
        
        .logo { 
            font-family: var(--font-heading);
            font-size: 1.2rem; 
            font-weight: 700; /* ทำให้โลโก้ดูหนาขึ้น */
            letter-spacing: 0.15em; 
            color: var(--primary); 
        }
        .logo span { font-weight: 300; color: #fff; }

        .nav-menu { display: flex; align-items: center; gap: 1.6rem; }
        .nav-link {
            font-family: var(--font-heading);
            color: var(--primary);
            text-decoration: none;
            background: none;
            border: none;
            padding: 0;
            font-size: 0.95rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            cursor: pointer;
            transition: 0.3s;
            white-space: nowrap;
        }
        .nav-link:hover { color: #fff; }

        .nav-right { display: flex; align-items: center; margin-left: auto; }
        .insight-btn {
            font-family: var(--font-heading);
            background: none;
            border: none;
            color: var(--primary);
            font-size: 0.95rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            cursor: pointer;
            transition: 0.3s;
            white-space: nowrap;
            margin-right: 2.2rem;
            text-decoration: none;
        }
        .insight-btn:hover { color: #fff; }

        .lang-switch { display: flex; gap: 1rem; font-size: 1.15rem; }
        .lang-btn {
            font-family: var(--font-heading);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            transition: 0.3s;
            font-size: 1em;
            font-weight: 500;
        }
        .lang-btn.active { color: var(--primary); }

        /* ----- HERO SECTION ----- */
        .hero {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
        }

        .hero-video {
            position: absolute;
            top: 50%; left: 50%;
            min-width: 100%; min-height: 100%;
            transform: translate(-50%, -50%);
            z-index: -2;
            object-fit: cover;
            filter: brightness(0.4) grayscale(0.5);
        }

        .hero-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to bottom, rgba(15,15,15,0.4), rgba(15,15,15,1));
            z-index: -1;
        }

        .hero-content h1 {
            font-family: var(--font-heading);
            font-size: 6rem; /* ปรับให้ใหญ่ขึ้นนิดหน่อย */
            font-weight: 700; /* เปลี่ยนจาก 200 เป็น 700 ดูเป็นแบรนด์ทรงพลัง */
            letter-spacing: 0.1em; /* เพิ่มระยะห่างช่องไฟ */
            margin-bottom: 0.5rem;
            color: var(--primary);
        }
        
        .hero-content p {
            font-family: var(--font-heading);
            letter-spacing: 0.6em; /* เพิ่มระยะห่างให้ดูพรีเมียม */
            font-weight: 300; 
            color: var(--text-main);
            font-size: 1.1rem;
        }

        /* ----- SCROLL WORKFLOW SECTION ----- */
        .how-it-works { padding: 10rem 0; background: var(--bg-dark); }
        
        .section-intro { text-align: center; margin-bottom: 8rem; }
        .section-intro h2 { 
            font-family: var(--font-heading);
            font-size: 3rem; 
            font-weight: 300; 
            color: var(--primary); 
        }

        .scroll-step {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15rem;
            gap: 4rem;
        }

        .scroll-step:nth-child(even) { flex-direction: row-reverse; }

        .step-image {
            flex: 1;
            height: 450px;
            background-color: var(--bg-card);
            border: 1px solid var(--border-dim);
            overflow: hidden;
            position: relative;
        }

        .step-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.7;
            transition: 0.5s;
        }

        .scroll-step:hover img { opacity: 1; transform: scale(1.05); }

        .step-info { flex: 1; }
        .step-number { 
            font-family: var(--font-heading);
            color: var(--primary); 
            font-size: 0.95rem; 
            font-weight: 600; 
            margin-bottom: 1rem; 
            display: block; 
            letter-spacing: 0.3em;
        }
        .step-info h3 { 
            font-family: var(--font-heading);
            font-size: 2.5rem; 
            font-weight: 400; /* เพิ่มความหนาให้หัวข้ออ่านง่ายขึ้น */
            margin-bottom: 1.5rem; 
        }
        .step-info p { 
            color: var(--text-muted); 
            font-size: 1.1rem; 
            font-weight: 300; 
            max-width: 450px; 
            line-height: 1.8;
        }

        /* ----- CONTACT ----- */
        .contact { padding: 8rem 0; text-align: center; border-top: 1px solid var(--border-dim); }
        .email-link { 
            font-family: var(--font-heading);
            font-size: 2rem; 
            color: var(--primary); 
            font-weight: 300; 
            text-decoration: none;
        }

        footer { padding: 4rem 0; text-align: center; opacity: 0.5; font-size: 0.85rem; }

        @media (max-width: 900px) {
            .nav-content { height: auto; min-height: 80px; padding: 1rem; flex-wrap: wrap; gap: 0.8rem 1rem; }
            .nav-left { gap: 1rem; flex-wrap: wrap; }
            .logo { font-size: 1rem; }
            .nav-menu { gap: 1rem; flex-wrap: wrap; }
            .nav-link { font-size: 0.9rem; }
            .insight-btn { font-size: 0.9rem; margin-right: 1.2rem; }
            .lang-switch { font-size: 1rem; }
            .scroll-step, .scroll-step:nth-child(even) { flex-direction: column; text-align: center; margin-bottom: 10rem; }
            .hero-content h1 { font-size: 3rem; }
            .step-info p { margin: 0 auto; }
        }
    </style>
</head>
<body>

    <header>
        <div class="nav-content">
            <div class="nav-left">
                <div class="logo">SUPAVUT <span>ASSESSMENT</span></div>
                <nav class="nav-menu">
                    <a href="{{ route('login') }}" class="nav-link" data-i18n="navLogin">LOG IN</a>
                    <a href="#how-it-works" class="nav-link" data-i18n="navHowItWorks">HOW IT WORKS</a>
                    <a href="#contact" class="nav-link" data-i18n="navContact">CONTACT</a>
                </nav>
            </div>
            <div class="nav-right">
                <a href="http://192.168.7.12:8080/supavut_insight/index.html" class="insight-btn">SUPAVUT INSIGHT</a>
                <div class="lang-switch">
                    <button type="button" class="lang-btn {{ app()->getLocale() === 'th' ? 'active' : '' }}" data-locale="TH">TH</button>
                    <button type="button" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}" data-locale="EN">EN</button>
                </div>
            </div>
        </div>
    </header>

    <section class="hero">
        <video class="hero-video" autoplay loop muted playsinline>
            <source src="https://cdn.pixabay.com/video/2016/09/13/5159-183735515_tiny.mp4" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content" data-aos="zoom-out" data-aos-duration="2000">
            <h1 data-aos="fade-up" data-aos-duration="1500">SUPAVUT</h1>
            <p data-i18n="heroDesc" data-aos="fade-up" data-aos-delay="200">ASSESSMENT SYSTEM</p>
        </div>
    </section>

    <section id="how-it-works" class="how-it-works">
        <div class="container">
            <div class="section-intro" data-aos="fade-up">
                <h2 data-i18n="howTitle">Our Process</h2>
                <p data-i18n="howDesc" style="color: var(--text-muted); margin-top: 1rem;">Experience a professional and transparent evaluation journey.</p>
            </div>

            <div class="scroll-step">
                <div class="step-image" data-aos="fade-right" data-aos-duration="1000">
                    <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&q=80&w=1200" alt="Self-Assessment">
                </div>
                <div class="step-info" data-aos="fade-left" data-aos-duration="1000">
                    <span class="step-number" data-i18n="phase1Label">PHASE 01</span>
                    <h3 data-i18n="step1Title">Self-Assessment</h3>
                    <p data-i18n="step1Desc">Reflect on your achievements and areas for growth through our structured digital assessment form.</p>
                </div>
            </div>

            <div class="scroll-step">
                <div class="step-image" data-aos="fade-left" data-aos-duration="1000">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=800" alt="Evaluation">
                </div>
                <div class="step-info" data-aos="fade-right" data-aos-duration="1000">
                    <span class="step-number" data-i18n="phase2Label">PHASE 02</span>
                    <h3 data-i18n="step2Title">Manager Review</h3>
                    <p data-i18n="step2Desc">Supervisors provide constructive feedback based on performance metrics and organizational KPIs.</p>
                </div>
            </div>

            <div class="scroll-step">
                <div class="step-image" data-aos="fade-right" data-aos-duration="1000">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800" alt="Score">
                </div>
                <div class="step-info" data-aos="fade-left" data-aos-duration="1000">
                    <span class="step-number" data-i18n="phase3Label">PHASE 03</span>
                    <h3 data-i18n="step3Title">Result Analytics</h3>
                    <p data-i18n="step3Desc">View your comprehensive score results with detailed analytics and performance charts.</p>
                </div>
            </div>

            <div class="scroll-step">
                <div class="step-image" data-aos="fade-left" data-aos-duration="1000">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=800" alt="Consult">
                </div>
                <div class="step-info" data-aos="fade-right" data-aos-duration="1000">
                    <span class="step-number" data-i18n="phase4Label">PHASE 04</span>
                    <h3 data-i18n="step4Title">Development Plan</h3>
                    <p data-i18n="step4Desc">Utilize evaluation insights to create a roadmap for future professional success.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <p data-i18n="inquiries" style="margin-bottom: 1rem; color: var(--text-muted); font-family: var(--font-heading); font-size: 0.9rem; letter-spacing: 0.1em;">FOR ANY INQUIRIES</p>
            <a href="mailto:hr.manager@supavut.com" class="email-link">hr.manager@supavut.com</a>
        </div>
    </section>

    <footer>
        <div class="container">
            <p style="font-family: var(--font-heading);">&copy; 2024 SUPAVUT GROUP. <span style="color:var(--primary)"><span data-i18n="developedBy">DEVELOPED BY</span> PUMIPUT IT</span></p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 200,
            duration: 1000,
            easing: 'ease-in-out',
            once: false,
        });

        const translations = {
            EN: {
                navLogin: "LOG IN",
                navHowItWorks: "HOW IT WORKS",
                navContact: "CONTACT",
                heroDesc: "ASSESSMENT SYSTEM",
                howTitle: "Our Process",
                howDesc: "Experience a professional and transparent evaluation journey.",
                phase1Label: "PHASE 01",
                phase2Label: "PHASE 02",
                phase3Label: "PHASE 03",
                phase4Label: "PHASE 04",
                step1Title: "Self-Assessment",
                step1Desc: "Reflect on your achievements and areas for growth through our structured digital assessment form.",
                step2Title: "Manager Review",
                step2Desc: "Supervisors evaluate employee performance based on the organization’s key performance indicators.",
                step3Title: "Result Analytics",
                step3Desc: "Review employee evaluation scores within the organization under the supervisor’s responsibility.",
                step4Title: "Development Plan",
                step4Desc: "Evaluation results are used to plan employee development and career growth paths.",
                inquiries: "FOR ANY INQUIRIES",
                developedBy: "DEVELOPED BY"
            },
            TH: {
                navLogin: "เข้าสู่ระบบ",
                navHowItWorks: "ขั้นตอนการทำงาน",
                navContact: "ติดต่อ",
                heroDesc: "ระบบประเมินผลงาน",
                howTitle: "ขั้นตอนการทำงาน",
                howDesc: "สัมผัสประสบการณ์การประเมินผลที่เป็นมืออาชีพและโปร่งใส",
                phase1Label: "PHASE 01", // ปรับเป็นภาษาอังกฤษเพื่อความพรีเมียม
                phase2Label: "PHASE 02",
                phase3Label: "PHASE 03",
                phase4Label: "PHASE 04",
                step1Title: "ประเมินตนเอง",
                step1Desc: "สะท้อนผลงานและจุดที่ควรพัฒนาของคุณผ่านแบบฟอร์มประเมินดิจิทัลอย่างเป็นระบบ",
                step2Title: "หัวหน้างานประเมิน",
                step2Desc: "ผู้บังคับบัญชาประเมินผลงานของพนักงานตามตัวชี้วัดหลักขององค์กร",
                step3Title: "ดูผลคะแนน",
                step3Desc: "ตรวจสอบคะแนนการประเมินพนักงานในองค์กรภายใต้สังกัดของผู้บังคับบัญชา",
                step4Title: "แผนพัฒนา",
                step4Desc: "ผลการประเมินถูกนำไปใช้วางแผนพัฒนาศักยภาพและเส้นทางความก้าวหน้าของพนักงาน",
                inquiries: "หากมีข้อสงสัย",
                developedBy: "พัฒนาโดย"
            }
        };

        function setLang(lang) {
            document.querySelectorAll('.lang-btn').forEach(btn => {
                btn.classList.toggle('active', btn.textContent === lang);
            });
            const dict = translations[lang];
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (dict[key]) el.textContent = dict[key];
            });
        }

        function syncLocale(lang) {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrf) return;

            const payload = new URLSearchParams();
            payload.set('locale', lang.toLowerCase());

            fetch(@json(route('locale.switch')), {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'Accept': 'application/json'
                },
                body: payload.toString()
            }).catch(() => {});
        }

        document.querySelectorAll('.lang-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const lang = (btn.dataset.locale || 'TH').toUpperCase();
                setLang(lang);
                syncLocale(lang);
            });
        });

        const initialLang = @json(app()->getLocale());
        setLang((initialLang || 'th').toUpperCase());
    </script>
</body>
</html>