# Supavut Assessment

**TH:** ระบบประเมินผลพนักงาน — จากไฟล์ Excel ที่ HR ต้องรวมเองทุกรอบ กลายเป็นระบบที่จบในตัว
**EN:** Employee performance reviews — turning a spreadsheet HR had to reassemble every cycle into a system that finishes the job itself.

`PHP 8.2` · `Laravel 12` · `MySQL` · `Tailwind CSS 4` · `Vite 7`

---

## 🇹🇭 ภาษาไทย

### ทำไมต้องมี

การประเมินพนักงานรอบหนึ่งคือ HR ต้องส่ง Excel ออกไป รอคนกรอกกลับมา แล้วมานั่งรวมเอง ใครยังไม่ส่งก็ต้องไล่ตาม พอรวมเสร็จจะดูย้อนหลังว่ารอบที่แล้วคนนี้ได้เท่าไหร่ ก็ต้องไปหาไฟล์เก่า

ระบบนี้ทำให้ทั้งวงจรจบในที่เดียว — เปิดรอบ ให้คะแนน ปิดรอบ ดูสรุป เทียบย้อนหลัง

### ทำอะไรได้บ้าง

- **จัดการรอบประเมิน (Cycle)** — เปิด/ปิดรอบ และล็อกรอบเป็นโหมดอ่านอย่างเดียวเมื่อจบ ไม่ให้ใครแก้ย้อนหลัง
- **ประเมินตัวเอง (Self Assessment)** — พนักงานกรอกส่วนของตัวเองก่อน
- **ให้คะแนนโดยหัวหน้า** — พร้อมโบนัส/หักคะแนนที่รองรับค่าติดลบได้
- **นำเข้าพนักงานจาก Excel** — มีไฟล์ template ให้ดาวน์โหลด ลดการกรอกมือ
- **ค้นหาพนักงาน** — ดึงข้อมูลจาก Employee Master
- **สรุปผลและส่งออก** — ออกรายงานพร้อมประวัติย้อนหลังต่อคน
- **ลืมรหัสผ่าน** — รีเซ็ตได้เอง ไม่ต้องรบกวน IT

### โมเดลข้อมูล

```
Cycle                  → รอบประเมิน (เปิด/ปิด/อ่านอย่างเดียว)
Employee               → พนักงานที่นำเข้ามา
SelfEmployee           → คะแนนที่พนักงานประเมินตัวเอง
ExportEmployee         → ผลประเมินที่สรุปแล้ว
ExportEmployeeHistory  → ประวัติย้อนหลังทุกรอบ
AppUser                → บัญชีผู้ใช้และบทบาท
```

### ติดตั้ง

```bash
composer install && npm install
cp .env.example .env && php artisan key:generate
php artisan migrate && npm run build && php artisan serve
```

---

## 🇬🇧 English

### Why it exists

One review cycle used to mean HR mailing out a spreadsheet, waiting for it to come back, chasing the people who hadn't sent it, and then merging everything by hand. Wanting to know what someone scored last cycle meant digging up an old file.

This closes the loop: open a cycle, score, close it, read the summary, compare against history.

### What it does

- **Cycle management** — open and close review periods, then lock a finished cycle to read-only so nobody edits the past
- **Self-assessment** — employees fill in their own section first
- **Manager scoring** — including bonus and penalty adjustments that correctly handle negative values
- **Excel import** with a downloadable template, so nobody retypes a roster
- **Employee lookup** against the Employee Master
- **Summaries and exports**, with per-person history across cycles
- **Self-service password reset** — no IT ticket required

### Data model

```
Cycle                  → review period (open / closed / read-only)
Employee               → imported roster
SelfEmployee           → self-assessment scores
ExportEmployee         → finalized results
ExportEmployeeHistory  → history across every cycle
AppUser                → accounts and roles
```

### Note

Code only. No database, no uploads, no real employee records.
