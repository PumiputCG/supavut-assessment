<?php

return [

    // ===== Basic / Branding =====
    'site_title'            => 'เข้าสู่ระบบ • Supavut Assessment',
    'brand'                 => 'Supavut Assessment',
    'system_badge'          => 'ประเมินผลประจำปี',
    'login_subtitle'        => 'เข้าสู่ระบบเพื่อเริ่มประเมิน',

    // ===== Theme =====
    'theme_dark'            => 'โหมดมืด',        // ใช้กับหน้า login เดิม
    'theme_mode_dark'       => 'โหมดมืด',        // ใช้กับหน้า OTP (สวิตช์)
    'theme_mode_light'      => 'โหมดสว่าง',

    // ===== Language switcher =====
    'lang_switcher_aria'    => 'ตัวเลือกภาษา',
    'lang_th'               => 'TH',
    'lang_en'               => 'EN',

    // ===== Generic Dialog / Buttons =====
    'ok'                    => 'ตกลง',
    'cancel'                => 'ยกเลิก',
    'alert_title'           => 'แจ้งเตือน',

    // ===== Login =====
    'login_failed'              => 'เข้าสู่ระบบไม่สำเร็จ',
    'auth_invalid_credentials'  => 'รหัสพนักงาน หรือ รหัสผ่านไม่ถูกต้อง',
    'employee_id'               => 'รหัสพนักงาน',
    'employee_placeholder'      => 'เช่น 23001',
    'password'                  => 'รหัสผ่าน',
    'password_placeholder'      => 'กรอกรหัสผ่านของคุณ',
    'password_short'            => 'อย่างน้อย 8 ตัวอักษร',
    'password_confirm'          => 'ยืนยันรหัสผ่าน',
    'password_confirm_short'    => 'กรอกรหัสผ่านซ้ำ',

    'forgot_password'       => 'ลืมรหัสผ่าน?',
    'login_button'          => 'เข้าสู่ระบบ',
    'no_account'            => 'ยังไม่มีบัญชี?',
    'signup_button'         => 'สมัครสมาชิก',

    // ปุ่มกลับหน้าโปรไฟล์
    'back_to_profile'       => 'กลับหน้าโปรไฟล์',

    // ===== Register Modal =====
    'register_title'        => 'สมัครสมาชิก',
    'email'                 => 'อีเมล',
    'email_placeholder'     => 'your.name@supavut.com',

    'profile_picture'       => 'รูปโปรไฟล์',
    'profile_hint'          => 'รองรับรูปภาพไม่เกิน 10 MB',
    'profile_too_large'     => 'ไฟล์รูปใหญ่เกิน 10 MB',

    'register_submit'       => 'ยืนยันสมัคร',

    // ===== Small alerts / helper text (Login + Register) =====
    'check'                     => 'ตรวจสอบ',
    'alert_employee_required'   => 'กรุณากรอกรหัสพนักงาน',
    'alert_email_required'      => 'กรุณากรอกอีเมลก่อนขอ OTP',
    'employee_demo_prefix'      => 'ตัวอย่างข้อมูลพนักงานสำหรับรหัส',
    'otp_demo_prefix'           => 'ตัวอย่าง: ระบบจะส่งรหัสไปที่',

    // ข้อความแจ้งเตือนลงทะเบียนซ้ำ
    'email_already_registered'     => 'อีเมลนี้ถูกลงทะเบียนไปแล้ว',
    'employee_already_registered'  => 'รหัสพนักงานนี้ถูกลงทะเบียนไปแล้ว',

    // ===== OTP basic label (ใช้ใน login เมื่อต้องโชว์ modal error OTP) =====
    'otp'                   => 'รหัส OTP',

    // ===== OTP Page (Email verification) =====
    'otp_title'               => 'ยืนยันอีเมลด้วย OTP',
    'otp_heading'             => 'ยืนยันอีเมลของคุณ',
    'otp_description'         => 'เราได้ส่งรหัส OTP ไปที่อีเมลของคุณแล้ว<br>กรุณากรอกรหัสให้ถูกต้องภายใน 15 นาที',

    'otp_confirm'             => 'ยืนยัน OTP',
    'otp_resend'              => 'ส่ง OTP อีกครั้ง',
    'otp_resend_hint'         => 'คุณสามารถขอรหัสใหม่ได้อีกครั้งในอีก :seconds วินาที',
    'resend_cooldown_seconds' => 60,
    'otp_inputs_aria'         => 'ช่องกรอกรหัสยืนยัน 6 หลัก',
    'otp_digit'               => 'หลักที่ :n',
    'otp_footer_note'         => '© :year Supavut Assessment • ระบบประเมินผลประจำปี',
    'otp_context_assessment'  => 'Assessment Portal • การเข้าถึงที่ปลอดภัย',

    // ===== Offline / Network =====
    'offline_alert'           => 'คุณออฟไลน์อยู่ กรุณาตรวจสอบการเชื่อมต่ออินเทอร์เน็ต',

    // ===== Profile (Supavut Assessment) =====
    'profile_title'                   => 'Supavut Assessment • โปรไฟล์ผู้ใช้งาน',
    'profile_brand'                   => 'Supavut Assessment',
    'profile_subtitle'                => 'หน้าสรุปข้อมูลผู้ใช้งานสำหรับระบบประเมินประจำปี',
    'profile_dark_mode'               => 'โหมดมืด',

    'profile_employee_info_title'     => 'ข้อมูล',
    'profile_employee_info_hint'      => 'ข้อมูลละเอียดจะดึงจากไฟล์ Excel ภายหลัง',
    'profile_employee_code_label'     => 'รหัสพนักงาน:',
    'profile_employee_code'           => 'รหัสพนักงาน',
    'profile_first_name'              => 'ชื่อ',
    'profile_last_name'               => 'นามสกุล',
    'profile_position'                => 'ตำแหน่ง',
    'profile_department'              => 'แผนก',
    'profile_unknown'                 => 'ไม่ระบุ',
    'profile_fallback_name'           => 'ผู้ใช้งาน',

    'profile_role_admin'              => 'ผู้ดูแลระบบ',
    'profile_role_user'               => 'พนักงาน',

    'profile_button_assessment'       => 'ประเมิน',
    'profile_button_edit'             => 'แก้ไขข้อมูลส่วนตัว',
    'profile_button_upload_excel'     => 'เพิ่มพนักงาน',
    'profile_button_logout'           => 'ออกจากระบบ',

    'profile_footer'                  => 'แบบประเมินประจำปี',

    'profile_view_employee_button'    => 'ดูรายละเอียด',
    'profile_view_employee_modal_title' => 'ข้อมูลพนักงาน',

    // ===== Profile / Security (TH) =====
    'edit_profile_title' => 'จัดการความปลอดภัยของบัญชี',
    'edit_profile_subtitle' => 'อัปเดตอีเมลและรหัสผ่านของคุณให้ทันสมัยและปลอดภัยอยู่เสมอ',
    'profile_dark_mode' => 'โหมดมืด',
    'security_section' => 'ความปลอดภัย',

    'email_label' => 'อีเมลสำหรับเข้าสู่ระบบ',
    'edit_email_hint' => 'คุณสามารถเปลี่ยนอีเมลที่ใช้เข้าสู่ระบบและรับการแจ้งเตือนได้จากส่วนนี้',
    'email_change_note' => 'กรุณาใช้อีเมลที่ใช้งานได้จริง ระบบอาจส่งการแจ้งเตือนไปยังอีเมลนี้',

    'current_password_for_email' => 'รหัสผ่านปัจจุบัน (สำหรับยืนยันการเปลี่ยนอีเมล)',
    'current_password_for_email_hint' => 'เพื่อป้องกันผู้อื่นเปลี่ยนอีเมลของคุณ ระบบต้องการให้ยืนยันด้วยรหัสผ่านปัจจุบัน',

    'security_note_change_password_on_profile' => 'เพื่อความปลอดภัย กรุณากรอกรหัสผ่านปัจจุบันก่อนตั้งรหัสผ่านใหม่',
    'current_password' => 'รหัสผ่านปัจจุบัน',
    'new_password' => 'รหัสผ่านใหม่',
    'new_password_confirmation' => 'ยืนยันรหัสผ่านใหม่',
    'password_hint' => 'ควรใช้รหัสผ่านที่มีตัวอักษร ตัวเลข และอักขระพิเศษผสมกัน และมีความยาวอย่างน้อย 8 ตัวอักษร',

    'save_email' => 'บันทึกอีเมล',
    'save_password' => 'บันทึกรหัสผ่านใหม่',

    // ===== Employee Import (Supavut Assessment) =====
'emp_import_title'          => 'นำเข้า Excel (พนักงาน)',
'emp_import_subtitle'       => 'อัปโหลด / อัปเดตข้อมูลพนักงานจากไฟล์ Excel',
'emp_import_admin_only'     => 'เฉพาะผู้ดูแลระบบ',
'emp_import_error_title'    => 'กรุณาตรวจสอบข้อผิดพลาดต่อไปนี้',

'emp_import_file_label'     => 'เลือกไฟล์ Excel',
'emp_import_file_help'      => 'รองรับไฟล์ <strong>.xlsx, .xls, .csv</strong> และแนะนำให้มีหัวคอลัมน์ เช่น รหัสพนักงาน, ชื่อ-สกุล, แผนก, ตำแหน่ง',

'emp_import_mode_title'     => 'โหมดการอัปโหลด',
'emp_import_mode_append'    => 'เพิ่มข้อมูลจากไฟล์นี้ต่อท้ายข้อมูลเดิม (Append)',
'emp_import_mode_replace'   => 'ลบข้อมูลเดิม และใช้ข้อมูลจากไฟล์นี้แทนทั้งหมด (Replace)',

'emp_import_btn_append'     => 'อัปโหลดเพิ่ม',
'emp_import_btn_replace'    => 'อัปโหลดทั้งหมด',
'emp_import_btn_back'       => 'กลับหน้าโปรไฟล์',
'emp_import_confirm_replace'=> 'แน่ใจหรือไม่ว่าต้องการแทนที่ข้อมูลพนักงานทั้งหมดด้วยไฟล์ใหม่นี้?',

'emp_import_footer'         => 'Supavut Assessment • นำเข้าข้อมูลพนักงานจาก Excel',
// ===== Employee Import – Success =====
    'emp_import_success_append'  => 'นำเข้าข้อมูลพนักงานแบบเพิ่มต่อจากข้อมูลเดิมเรียบร้อยแล้ว',
    'emp_import_success_replace' => 'นำเข้าข้อมูลพนักงานใหม่และแทนที่ข้อมูลเดิมทั้งหมดเรียบร้อยแล้ว',

// ===== Employee Lookup / Register =====
    'emp_lookup_hint'                 => 'กรุณากรอกรหัสพนักงานแล้วกด "ตรวจสอบ" ก่อนกรอกข้อมูลด้านล่าง',
    'emp_lookup_error_code_required'  => 'กรุณากรอกรหัสพนักงานก่อน',
    'emp_lookup_error_not_found'      => 'ไม่พบรหัสพนักงานในระบบ กรุณาตรวจสอบอีกครั้ง หรือสอบถามฝ่ายทรัพยากรบุคคล',
    'emp_lookup_error_general'        => 'ไม่สามารถตรวจสอบข้อมูลพนักงานได้ในขณะนี้ กรุณาลองใหม่อีกครั้ง',
    'checking'                        => 'กำลังตรวจสอบ...',
    'emp_register_email_hint'         => 'หลังสมัครและล็อกอินสำเร็จ ระบบจะส่งรหัส OTP ไปยังอีเมลนี้เพื่อใช้ยืนยันตัวตน',

  // ===== Forgot Password (ลืมรหัสผ่าน) =====
    'forgot_password_helper' => 'กรุณากรอกรหัสพนักงานและอีเมลที่ตรงกับข้อมูลในระบบ',
    'employee_code_label' => 'รหัสพนักงาน',
    'employee_code_placeholder' => 'เช่น 12345',
    'email_bound_label' => 'อีเมลที่ผูกกับบัญชี',
    'email_placeholder_example' => 'เช่น employee@supavut.co.th',
    'forgot_password_send_link_button' => 'ส่งลิงก์ตั้งรหัสผ่านใหม่',
    'back_to_login' => 'กลับไปหน้าเข้าสู่ระบบ',

    // ===== Forgot Password (ลืมรหัสผ่าน) =====
    'forgot_password'                   => 'ลืมรหัสผ่าน',
    'forgot_password_helper'            => 'กรุณากรอกรหัสพนักงานและอีเมลที่ตรงกับข้อมูลในระบบ',
    'employee_code_label'               => 'รหัสพนักงาน',
    'employee_code_placeholder'         => 'เช่น 12345',
    'email_bound_label'                 => 'อีเมลที่ผูกกับบัญชี',
    'email_placeholder_example'         => 'เช่น employee@supavut.co.th',
    'forgot_password_send_link_button'  => 'ส่งลิงก์ตั้งรหัสผ่านใหม่',

    // ปุ่มกลับหน้าเข้าสู่ระบบ (ใช้ทั้ง forgot / reset)
    'back_to_login'                     => 'กลับไปหน้าเข้าสู่ระบบ',

    // ===== Reset Password (ตั้งรหัสผ่านใหม่) =====
    'reset_password_title'              => 'ตั้งรหัสผ่านใหม่',
    'reset_password_subtitle'           => 'กรุณากำหนดรหัสผ่านใหม่สำหรับบัญชีของคุณ',
    'reset_password_new_label'          => 'รหัสผ่านใหม่',
    'reset_password_confirm_label'      => 'ยืนยันรหัสผ่านใหม่',
    'reset_password_submit_button'      => 'บันทึกรหัสผ่านใหม่',

    // (ถ้ายังไม่ได้สร้างมาก่อน) Subject ของอีเมลรีเซ็ตรหัสผ่าน
    'reset_email_subject'               => 'ลิงก์ตั้งรหัสผ่านใหม่ • Supavut Assessment',
'reset_password_same_old_warning' => 'ไม่สามารถใช้รหัสผ่านเดิมได้ กรุณาตั้งรหัสผ่านใหม่ที่แตกต่างจากเดิม',

  // ปุ่มประเมิน (หน้าโปรไฟล์)
    'profile_button_assessment_self'       => 'ประเมินตัวเอง',
    'profile_button_assessment_employees'  => 'ประเมินพนักงาน',
    'profile_button_view_evaluations'      => 'ดูผลสรุป',

    // ===== Assessment: Employees list =====
'assess_employees_page_title'        => 'ประเมินพนักงานในความดูแล',
'assess_employees_page_subtitle'     => 'รายชื่อพนักงานที่คุณอยู่ในบทบาทหัวหน้างาน',
'assess_employees_total_chip'        => 'รวมทั้งหมด :count คน',
'assess_employees_legend_pending'    => 'รอการดำเนินการ',
'assess_employees_legend_done'       => 'ประเมินเสร็จแล้ว',
'assess_employees_back_profile'      => 'กลับโปรไฟล์',

'assess_employees_table_no'          => 'ลำดับ',
'assess_employees_table_code'        => 'รหัส',
'assess_employees_table_name'        => 'ชื่อ-สกุล',
'assess_employees_table_type'        => 'ประเภท',
'assess_employees_table_position'    => 'ตำแหน่ง',
'assess_employees_table_department'  => 'แผนก',
'assess_employees_table_status'      => 'สถานะการประเมิน',
'assess_employees_table_action'      => 'ประเมิน',

'assess_employees_empty'             => 'ยังไม่มีพนักงานในความดูแลสำหรับรหัสของคุณ',

'assess_employees_status_done'       => 'ประเมินเสร็จแล้ว',
'assess_employees_status_pending'    => 'รอการดำเนินการ',

'assess_employees_button_evaluate'   => 'ประเมิน',

'assess_employees_hover_code'        => 'รหัสพนักงาน: :code',
'assess_employees_hover_position'    => 'ตำแหน่ง: :position',
'assess_employees_hover_department'  => 'แผนก: :department',

    // ===== Assessment – รายชื่อพนักงานที่ต้องประเมิน =====
    'assess_employees_page_title'        => 'รายการพนักงานที่ต้องประเมิน',
    'assess_employees_page_subtitle'     => 'เลือกพนักงานที่คุณรับผิดชอบเพื่อลงประเมินผลการปฏิบัติงาน',
    'assess_employees_total_chip'        => 'ทั้งหมด :count คน',
    'assess_employees_legend_pending'    => 'ยังไม่ได้ประเมิน',
    'assess_employees_legend_done'       => 'ประเมินเสร็จแล้ว',
    'assess_employees_empty'             => 'ขณะนี้ยังไม่มีพนักงานที่คุณต้องประเมิน',

    'assess_employees_table_no'          => 'ลำดับ',
    'assess_employees_table_code'        => 'รหัส',
    'assess_employees_table_name'        => 'ชื่อ-สกุล',
    'assess_employees_table_type'        => 'ประเภทการจ้าง',
    'assess_employees_table_position'    => 'ตำแหน่ง',
    'assess_employees_table_department'  => 'แผนก',
    'assess_employees_table_status'      => 'สถานะการประเมิน',
    'assess_employees_table_action'      => 'การดำเนินการ',

    'assess_employees_status_done'       => 'ประเมินแล้ว',
    'assess_employees_status_pending'    => 'รอประเมิน',

    'assess_employees_button_evaluate'   => 'ประเมิน',
    'assess_employees_back_profile'      => 'กลับไปหน้าโปรไฟล์',

    'assess_employees_hover_code'        => 'รหัสพนักงาน: :code',
    'assess_employees_hover_position'    => 'ตำแหน่ง: :position',
    'assess_employees_hover_department'  => 'แผนก: :department',

    // ===== Assessment – แบบฟอร์มประเมินรายบุคคล (evaluate.blade.php) =====
    'assess_form_title'                  => 'แบบฟอร์มประเมิน :name',
    'assess_form_title_short'            => 'แบบฟอร์มประเมินพนักงาน',
    'assess_form_subtitle'               => 'หน้านี้เป็นโครงร่างสำหรับใช้ประเมินพนักงาน ระบบจะเพิ่มหัวข้อและการคำนวณคะแนนในขั้นตอนถัดไป',

    'assess_form_role_placeholder'       => 'บทบาทผู้ประเมิน (จะระบุ SUP / DIV / DEPT / PLANT ภายหลัง)',
    'assess_form_status_draft'           => 'สถานะ: ยังไม่ส่งการประเมิน',

    'assess_form_section_main'           => 'หัวข้อประเมินหลัก',
    'assess_form_section_main_desc'      => 'พื้นที่สำหรับหัวข้อหลัก เช่น ผลการปฏิบัติงาน ความรับผิดชอบ วินัย ฯลฯ จะถูกเพิ่มภายหลัง',
    'assess_form_placeholder_fields'     => 'PLACEHOLDER: จะเพิ่มช่องคะแนนและตัวเลือกการประเมินจริงในภายหลัง',

    'assess_form_section_competency'     => 'พฤติกรรมและ Competency',
    'assess_form_section_competency_desc'=> 'โซนนี้จะใช้เก็บคะแนนด้านพฤติกรรม การทำงานร่วมกับผู้อื่น การสื่อสาร ฯลฯ',
    'assess_form_placeholder_competency' => 'PLACEHOLDER: ช่องกรอกคะแนนด้านพฤติกรรม / soft skill',

    'assess_form_section_comment'        => 'ความเห็นเพิ่มเติม / สรุปผล',
    'assess_form_section_comment_desc'   => 'จะเพิ่มช่อง comment จริงสำหรับบันทึกข้อเสนอแนะและสรุปผลประเมินในภายหลัง',
    'assess_form_placeholder_comment'    => 'PLACEHOLDER: ช่อง comment และข้อเสนอแนะเพื่อการพัฒนา',

    'assess_form_back_list'              => 'กลับไปรายชื่อพนักงานที่ต้องประเมิน',
    'assess_form_save_draft'             => 'บันทึกแบบร่าง (ยังไม่เปิดใช้งาน)',
    'assess_form_submit'                 => 'ส่งการประเมิน (ยังไม่เปิดใช้งาน)',

        // ===== Assessment Overview (Summary) =====
    'assess_overview_title' => 'ดูผลสรุปการประเมินของ :name',
    'assess_overview_title_short' => 'ดูผลสรุปการประเมิน (โครงสร้างทีม)',
    'assess_overview_subtitle' => 'หน้านี้แสดงโครงสร้างพนักงานในสายงานของคุณ (Dept / Plant) เพื่อใช้เชื่อมกับผลการประเมินในภายหลัง',

    'assess_overview_scope_plant' => 'ระดับโรงงาน (Plant Manager)',
    'assess_overview_scope_dept'  => 'ระดับแผนก (Department Manager)',

    'assess_overview_stat_branch'      => 'พนักงานในสายงานทั้งหมด',
    'assess_overview_stat_supervisors' => 'จำนวน Supervisor',
    'assess_overview_stat_divmgr'      => 'จำนวน Division Manager',
    'assess_overview_stat_staff'       => 'พนักงานทั่วไป (ลูกน้อง)',

    'assess_overview_section_leaders'      => 'หัวหน้างานในสายงานของคุณ',
    'assess_overview_section_leaders_desc' => 'Supervisor และ Division Manager ที่อยู่ภายใต้สายงานของคุณ (ตามแผนก/โรงงานเดียวกัน)',
    'assess_overview_no_leaders'           => 'ยังไม่มีข้อมูลหัวหน้างานในสายงาน',

    'assess_overview_supervisors_title' => 'Supervisor ในสายงาน',
    'assess_overview_divmgr_title'      => 'Division Manager ในสายงาน',

    'assess_overview_col_name' => 'ชื่อ-สกุล',
    'assess_overview_col_dept' => 'แผนก',
    'assess_overview_col_empcode' => 'รหัสพนักงาน',
    'assess_overview_col_position' => 'ตำแหน่ง',
    'assess_overview_col_role' => 'บทบาทในสายงาน',

    'assess_overview_no_supervisors' => 'ไม่มี Supervisor ในสายงานนี้',
    'assess_overview_no_divmgr'      => 'ไม่มี Division Manager ในสายงานนี้',

    'assess_overview_section_subordinates'      => 'ลูกน้องในสายงาน (แยกตาม Supervisor)',
    'assess_overview_section_subordinates_desc' => 'พนักงานทั่วไปที่อยู่ในสายงานของคุณ แยกตามหัวหน้า SUP แต่ละคน (เพื่อใช้ดูผลประเมินต่อไป)',
    'assess_overview_no_subordinates'          => 'ยังไม่มีข้อมูลลูกน้องในสายงาน',

    'assess_overview_people' => 'คน',
    'assess_overview_no_staff_under_sup' => 'ไม่มีลูกน้องภายใต้ SUP คนนี้',

    'assess_overview_section_all'      => 'รายการพนักงานทั้งหมดในสายงานของคุณ',
    'assess_overview_section_all_desc' => 'ตารางรวมพนักงานในสายงาน (SUP / DIV / STAFF) เพื่อใช้เป็นฐานเชื่อมกับผลคะแนนประเมินในอนาคต',

    'assess_overview_back_profile' => 'กลับไปหน้าโปรไฟล์',

    
 // ===== Assessment: Employees list =====
    'assess_employees_supervisor_subtitle' =>
        'รายชื่อพนักงานที่คุณเป็น Supervisor โดยตรง (:count รายการ)',

    'assess_employees_division_subtitle' =>
        'รายชื่อพนักงานที่คุณเป็น Division Manager (:count รายการ)',

        //แปลภาษาประเมิน
            // ===== Assessment: Evaluate (TH) =====
    'assess_eval_title' => 'ประเมิน :code',
    'assess_eval_header_title' => 'แบบประเมินพนักงาน',
    'assess_lang_switch_label' => 'สลับภาษา',
    'assess_theme_toggle_label' => 'สลับโหมดแสง',
    'assess_avatar_tooltip' => 'ดูรูปโปรไฟล์',
    'assess_emp_meta' => 'รหัส :code • ตำแหน่ง :position • แผนก :dept',

    'assess_level_operator'   => 'ระดับ 1 • Operator',
    'assess_level_staff'      => 'ระดับ 2 • Staff',
    'assess_level_supervisor' => 'ระดับ 3 • Supervisor',
    'assess_level_manager'    => 'ระดับ 4 • Manager',
    'assess_level_gm'         => 'ระดับ 5 • GM',

    'assess_weight_title' => 'โครงสร้างสัดส่วนคะแนน',
    'assess_weight_attendance' => 'Attendance',
    'assess_weight_individual' => 'Individual',
    'assess_weight_dept_okr' => 'Dept OKR',
    'assess_weight_company_okr' => 'Company OKR',
    'assess_weight_okr_reporting' => 'OKR Reporting',
    'assess_weight_system' => 'System (SMBR)',
    'assess_weight_bonus' => 'Bonus',
    'assess_weight_not_defined' => 'ยังไม่ได้กำหนดสัดส่วน',
    'assess_weight_total_line' => 'คะแนนเต็มรวม :points คะแนน',

    // Attendance
    'assess_att_title' => 'Attendance (การมาทำงาน)',
    'assess_att_sub' => "คิดจากคะแนนดิบ :raw / :base × :weight (weight)<br>คิดเป็น :weighted %",
    'assess_btn_view_detail' => 'ดูรายละเอียด',

    'assess_att_modal_title' => 'รายละเอียด Attendance',
    'assess_att_modal_intro' => 'ตัดคะแนนจากการขาด ลาป่วย ลากิจ และมาสาย ตามตารางด้านล่าง',
    'assess_att_col_type' => 'ประเภท',
    'assess_att_col_count' => 'จำนวนครั้ง',
    'assess_att_col_each' => 'ต่อครั้ง',
    'assess_att_col_total' => 'รวมที่ตัด',

    'assess_att_row_absent' => 'ขาดงาน',
    'assess_att_row_sick' => 'ลาป่วย',
    'assess_att_row_personal' => 'ลากิจ',
    'assess_att_row_late' => 'มาสาย',
    'assess_att_row_maternity' => 'ลาคลอด',
    'assess_att_row_ordain' => 'ลาบวช',
    'assess_att_row_warning' => 'หนังสือเตือน',
    'assess_att_row_suspension' => 'พักงาน',

    'assess_att_footer_deduct' => 'รวมคะแนนที่ถูกตัด',
    'assess_att_footer_remaining' => 'คะแนนคงเหลือ',
    'assess_att_formula_text' => 'สูตร: :raw ÷ :base × :weight = :weighted คะแนน',

    // Individual Performance
    'assess_ip_title' => 'Individual Performance',
    'assess_ip_missing_la_badge' => 'ยังไม่กรอก Leadership / Attitude',
    'assess_ip_summary_text' => 'คะแนนที่ได้คือ :sum ( :sum/:full × :weight = :weighted ) ผลลัพธ์คือ :weighted %',
    'assess_ip_empty_main' => 'ยังไม่มีข้อมูล Individual Performance (น้ำหนัก :weight คะแนน)',
    'assess_ip_warning_missing_main' => 'กรุณากรอกคะแนน Leadership และ Attitude ให้ครบก่อนสรุปผล',

    'assess_ip_modal_title' => 'รายละเอียด Individual Performance',
    'assess_ip_modal_intro' => 'สรุปคะแนนรายหัวข้อและการคิดน้ำหนัก Individual Performance',
    'assess_ip_modal_empty' => 'ยังไม่มีคะแนนในหัวข้อนี้',
    'assess_ip_modal_warning' => 'ยังไม่ครบ Leadership / Attitude จึงยังไม่คิดคะแนนรวม',
    'assess_ip_modal_calc_note' => 'กดปุ่มคำนวณด้านล่างเพื่ออัปเดตคะแนนใหม่',

    'assess_ip_section_heading' => 'หัวข้อที่ใช้ประเมิน',
    'assess_ip_section_sub' => 'ดูสรุปคะแนนรายหัวข้อ และรายละเอียดเกณฑ์แต่ละหัวข้อ',

    'assess_table_topic' => 'หัวข้อประเมิน',
    'assess_table_criteria' => 'เกณฑ์',
    'assess_table_score' => 'คะแนน',

    'assess_ip_topic_teamwork' => 'Teamwork (Asakai)',
    'assess_ip_topic_comm' => 'Communication (Red Alert)',
    'assess_ip_topic_leader' => 'Leadership',
    'assess_ip_topic_attitude' => 'Attitude / Discipline',
    'assess_ip_topic_planning' => 'Planning / Proactivity (Kaizen)',
    'assess_ip_topic_owner' => 'Ownership ',
    'assess_ip_topic_problem' => 'Problem Solving (QCC)',

    'assess_ip_asakai_line' => 'เข้าร่วม Asakai :percent% → ให้คะแนน :score',
    'assess_ip_redalert_line' => 'เข้าร่วม Red Alert :percent%',

    'assess_criteria_btn_title' => 'ดูเกณฑ์ของหัวข้อนี้',

    'assess_ip_record_title' => 'บันทึกคะแนน Leadership และ Attitude',
    'assess_ip_record_sub' => 'ประเมินคะแนนของพนักงานตามหัวข้อดังนี้ *หมายเหตุ เมื่อระบุคะแนนแล้ว กดปุ่ม "คำนวณ" เพื่อให้ระบบคำนวณผลลัพธ์คะแนน',

    'assess_ip_leadership_label' => 'Leadership',
    'assess_ip_selected_score' => 'คะแนนที่เลือก',
    'assess_ip_rating_overall_label' => 'โปรดระบุคะแนน:',
    'assess_likert_always' => 'เสมอ',
    'assess_likert_sometimes' => 'บ่อย',
    'assess_likert_seldom' => 'นาน ๆ ครั้ง',
    'assess_likert_almost_never' => 'แทบไม่เคย',
    'assess_likert_never' => 'ไม่เคย',
    'assess_ip_leadership_numeric_label' => 'เลือกระดับคะแนน (0–10)',

    'assess_ip_attitude_label' => 'Attitude / วินัย',
    'assess_ip_attitude_numeric_label' => 'เลือกระดับคะแนน (0–10)',

    'assess_btn_calc' => 'คำนวณ',
    'assess_btn_apply' => 'นำไปใช้',

    // Criteria modal
    'assess_criteria_modal_title' => 'เกณฑ์การให้คะแนน',
    'assess_criteria_teamwork_title' => 'เกณฑ์ Teamwork',
    
    'assess_criteria_teamwork_intro' => 'การประเมินคะแนนจากการเข้าร่วมการประชุม Asakai ดังต่อไปนี้:',
    'assess_criteria_teamwork_li1' => '10 คะแนน ≥ 95%',
    'assess_criteria_teamwork_li2' => '7 คะแนน 85–94%',
    'assess_criteria_teamwork_li3' => '4 คะแนน 75–84%',
    'assess_criteria_teamwork_li4' => '1 คะแนน ≤ 74%',
    'assess_criteria_teamwork_current' => 'ปัจจุบันเข้าร่วม Asakai :percent% ⇒ ให้คะแนน :score',

    'assess_criteria_comm_title' => 'เกณฑ์ Communication',
    'assess_criteria_comm_intro' => 'การประเมินคะแนนจากการเข้าร่วมการประชุม Red Alert ดังต่อไปนี้:',
    'assess_criteria_comm_li1' => '10 คะแนน ≥ 95%',
    'assess_criteria_comm_li2' => '7 คะแนน 85–94%',
    'assess_criteria_comm_li3' => '4 คะแนน 75–84%',
    'assess_criteria_comm_li4' => '1 คะแนน ≤ 74%',

    'assess_criteria_leader_title' => 'เกณฑ์ Leadership',
    'assess_criteria_leader_intro' => 'การประเมินคะแนนจากหัวหน้างาน',
'assess_criteria_leader_li1'   => '10–8 = แทบทุกครั้ง',
'assess_criteria_leader_li2'   => '7–5 = บ่อยครั้ง',
'assess_criteria_leader_li3'   => '4–2 = บางครั้ง',
'assess_criteria_leader_li4'   => '1 = แทบไม่เคย',
'assess_criteria_leader_li5'   => '0 = ไม่เคย',

    'assess_criteria_attitude_title' => 'เกณฑ์ Attitude / Descipline',
    'assess_criteria_attitude_intro' => 'การประเมินคะแนนจากหัวหน้างาน',
    'assess_criteria_attitude_li1' => '10–8 = แทบทุกครั้ง',
    'assess_criteria_attitude_li2' => '7–5 = บ่อยครั้ง',
    'assess_criteria_attitude_li3' => '4–2 = บางครั้ง',
    'assess_criteria_attitude_li4' => '1 = แทบไม่เคย',
    'assess_criteria_attitude_li5' => '0 = ไม่เคย',

    'assess_criteria_planning_title' => 'เกณฑ์ Planning / Proactivity',
    'assess_criteria_planning_intro' => 'การประเมินคะแนนจากการเข้าร่วมกิจกรรม Kaizen',
    'assess_criteria_planning_li1' => '10 คะแนน =  หน่วยงานที่ชนะเลิศ',
    'assess_criteria_planning_li2' => '7 คะแนน = หน่วยงานที่เข้ารอบ 10 ทีม',
    'assess_criteria_planning_li3' => '4 คะแนน = หน่วยงานที่ส่งเข้าร่วมตามกำหนดเวลา',
    'assess_criteria_planning_li4' => '1 คะแนน = หน่วยงานที่ส่งเข้าร่วมแต่ส่งล่าช้า',

    'assess_criteria_owner_title' => 'เกณฑ์ Ownership / Responsibility',
    'assess_criteria_owner_intro' => 'การประเมินคะแนนจากการเข้าร่วมระบบคุณภาพต่างๆ ของบริษัทฯ',
    'assess_criteria_owner_li1' => '10 คะแนน = ปิดจบ CAR ตาม Due date นำ Action ไปขยายผลใน Precess ต่างๆ และ Implement ได้ 100%',
    'assess_criteria_owner_li2' => '7 คะแนน = ปิดจบ CAR ตาม Due date นำ Action ไปขยายผลใน Precess ต่างๆ และ Implement ไม่ได้ 100%',
    'assess_criteria_owner_li3' => '4 คะแนน = ปิดจบ CAR ไม่ตาม Due date นำ Action ไปขยายผลใน Process ต่างๆได้',
    'assess_criteria_owner_li4' => '1 คะแนน = ปิดจบ CAR แต่ไม่นำ Action ไปขยายผลใน Process ต่างๆได้<br>* หมายเหตุ หากแผนกไหนไม่มี CAR ต้องอ้างอิง Data พร้อม Evidence ที่ตอบในการรวจติดตามจากระบบต่าง 100% จึงจะได้ 10 คะแนน',


    'assess_criteria_problem_title' => 'เกณฑ์ Problem Solving',
    'assess_criteria_problem_intro' => 'การประเมินคะแนนจากเข้าร่วมกิจกรรม QCC',
    'assess_criteria_problem_li1' => '10 คะแนน = หน่วยงานที่ชนะเลิศ',
    'assess_criteria_problem_li2' => '7 คะแนน = หน่วยงานที่เข้ารอบ 10 ทีม',
    'assess_criteria_problem_li3' => '4 คะแนน = หน่วยงานที่ส่งเข้าร่วมตามกำหนดเวลา',
    'assess_criteria_problem_li4' => '1 คะแนน = หน่วยงานที่ส่งเข้าร่วมแต่ส่งล่าช้า',

    // OKR / System
    'assess_okr_dept_title' => 'Department level OKR score',
    'assess_okr_dept_sub' => 'คะแนนที่ได้คือ :score ( :score/10 × :weight = :weighted ) ผลลัพธ์คือ :weighted %',
    'assess_okr_company_title' => 'Company level OKR score',
    'assess_okr_company_sub' => 'คะแนนที่ได้คือ :score ( :score/10 × :weight = :weighted ) ผลลัพธ์คือ :weighted %',
    'assess_okr_reporting_title' => 'OKR-Reporting score',
    'assess_okr_reporting_sub' => 'คะแนนที่ได้คือ :score ( :score/10 × :weight = :weighted ) ผลลัพธ์คือ :weighted %',
    'assess_system_title' => 'System (SMBR)',
    'assess_system_sub' => 'คะแนนที่ได้คือ :score ( :score/5 × :weight = :weighted ) ผลลัพธ์คือ :weighted %',

    // Bonus
    'assess_bonus_title' => 'Bonus score',
 

    // Total / Grade
    'assess_total_title' => 'สรุปคะแนนรวมทั้งหมด',
   // ===== Assessment: Total summary =====
'assess_total_sub_text' => 'คะแนนรวมคือ :base / :max + Bonus :bonus จะได้คะแนนรวมทั้งสิ้น :total',
'assess_total_sub_template' => 'คะแนนรวมคือ {base} / {max} + Bonus {bonus} จะได้คะแนนรวมทั้งสิ้น {total}',

    'assess_grade_prefix' => 'เกรด',
    'assess_grade_a' => 'ผลงานยอดเยี่ยม',
    'assess_grade_b' => 'ผลงานดีมาก',
    'assess_grade_c' => 'ผลงานปานกลาง',
    'assess_grade_d' => 'ต้องเร่งพัฒนา',
    'assess_grade_f' => 'ไม่ผ่านเกณฑ์',
    'assess_grade_c_warning' => 'มีหนังสือเตือน • กำหนดเกรด C',
    'assess_grade_d_suspension' => 'มีโทษพักงาน • กำหนดเกรด D',

    'assess_grade_info_btn_title' => 'ดูเกณฑ์การให้เกรด',
    'assess_grade_modal_title' => 'เกณฑ์การให้เกรดรวม',
    'assess_grade_modal_intro' => 'ใช้คะแนนรวมสุดท้ายตัดเกรดตามช่วงด้านล่าง',
    'assess_grade_modal_li_a' => 'A : คะแนน ≥ 95',
    'assess_grade_modal_li_b' => 'B : คะแนน ≥ 85',
    'assess_grade_modal_li_c' => 'C : คะแนน ≥ 75',
    'assess_grade_modal_li_d' => 'D : คะแนน ≥ 60',
    'assess_grade_modal_li_f' => 'F : คะแนน < 60',
    'assess_grade_modal_special' => 'เกณฑ์บังคับพิเศษ',
    'assess_grade_modal_special_c' => 'มีหนังสือเตือน ⇒ อย่างน้อยเกรด C',
    'assess_grade_modal_special_d' => 'มีโทษพักงาน ⇒ อย่างน้อยเกรด D',

    // Template สำหรับ JS
   'assess_ip_modal_template'   => 'คะแนนที่ได้คือ {sum} ( {sum}/{full} × {weight} = {weighted} ) ผลลัพธ์คือ {weighted} %',
    'assess_ip_summary_template' => 'คะแนนที่ได้คือ {sum} ( {sum}/{full} × {weight} = {weighted} ) ผลลัพธ์คือ {weighted} %',
    'assess_ip_alert_missing_la' => 'กรุณาเลือกคะแนน Leadership และ Attitude ให้ครบก่อน',
    'assess_ip_alert_need_calc' => 'กรุณากดปุ่มคำนวณก่อนนำคะแนนไปใช้',

    // ปุ่ม / ทั่วไป
    'assess_btn_back_to_list' => 'กลับไปรายชื่อ',
    'assess_btn_save_total' => 'บันทึกคะแนนรวม',
    'assess_btn_close' => 'ปิด',

    
    //ปุ่มเกณฑ์ 
    // ===== Assessment: Dept / Company OKR / System / Bonus criteria (TH) =====
'assess_criteria_dept_okr_title' => 'Department OKR',
'assess_criteria_dept_okr_intro' => 'เกณฑ์ Department OKR',
'assess_criteria_dept_okr_li1'   => '10 คะแนน = คะแนน Department OKR ≥ 110',
'assess_criteria_dept_okr_li2'   => '9 คะแนน = คะแนน Department OKR ≥ 100 และ < 110',
'assess_criteria_dept_okr_li3'   => '8 คะแนน = คะแนน Department OKR ≥ 90 และ < 100',
'assess_criteria_dept_okr_li4'   => '7 คะแนน = คะแนน Department OKR ≥ 80 และ < 90',
'assess_criteria_dept_okr_li5'   => '6 คะแนน = คะแนน Department OKR ≥ 70 และ < 80',
'assess_criteria_dept_okr_li6'   => '5 คะแนน = คะแนน Department OKR < 70',

'assess_criteria_company_okr_title' => 'Company OKR',
'assess_criteria_company_okr_intro' => 'Company level OKR score คือคะแนนรวมของ Department level OKR score ทั้งหมด',

'assess_criteria_okr_reporting_title' => 'OKR Reporting',
'assess_criteria_okr_reporting_intro' => 'OKR - Reporting score คือคะแนนเฉลี่ยของ OKR - Reporting score ทุกเดือน',

'assess_criteria_system_title' => 'System (SMBR)',
'assess_criteria_system_intro' => 'System (SMBR) เกณฑ์คะแนน',
'assess_criteria_system_li1'   => '5 = ดีเยี่ยม',
'assess_criteria_system_li2'   => '4 = ดี',
'assess_criteria_system_li3'   => '3 = ปานกลาง',
'assess_criteria_system_li4'   => '2 = พอใช้',
'assess_criteria_system_li5'   => '≤ 1 = ปรับปรุง',

'assess_criteria_bonus_title' => 'Bonus score',
'assess_criteria_bonus_intro' => 'Bonus score พิจารณาตามเกณฑ์ต่อไปนี้',
'assess_criteria_bonus_li1'   => 'คะแนนจากการชนะเลิศในกิจกรรมต่างๆ',
'assess_criteria_bonus_li2'   => 'คะแนนจากการทำ Cost Reduction เกินความคาดหวัง รวมถึงกิจกรรมต่างๆ ที่เกินความคาดหมาย',
'assess_criteria_bonus_li3'   => 'คะแนนจากการทำชื่อเสียงให้แก่บริษัทฯ',
'assess_criteria_bonus_li4'   => 'คะแนนจากการทำ OKRs ผ่านทุกหัวข้อ',
'assess_criteria_bonus_li5'   => 'คะแนนจากการทำให้เกิดงาน Claim เป็น 0',
'assess_criteria_bonus_li6'   => 'คะแนนจากการร่วมเป็นคณะกรรมการในทีมตรวจระบบต่างๆ ของบริษัทฯ',
'assess_weight_total_line_th' => 'รวม :points คะแนน',
'assess_already_done_title' => 'ท่านได้ประเมินพนักงานคนนี้ไปแล้ว',
    'assess_already_done_sub'   => 'ผลการประเมินที่บันทึกปี :year ช่วง :period คือ :score คะแนน (เกรด :grade)',
'assess_confirm_save_title' => 'ยืนยันการบันทึกคะแนนรวม',
'assess_confirm_save_body'  => 'คุณต้องการบันทึกคะแนนรวมการประเมินสำหรับพนักงานคนนี้ใช่ไหม? เมื่อบันทึกแล้วจะไม่สามารถบันทึกซ้ำได้อีก.',
// ===== Assessment • Employees list =====
'assess_employees_table_score'  => 'คะแนนรวม',
'assess_employees_table_grade'  => 'เกรด',

// สถานะในคอลัมน์สถานะ
'assess_employees_status_pending' => 'รอการประเมิน',
'assess_employees_status_done'    => 'ประเมินแล้ว',

          // ===== Theme toggle =====
    'theme_toggle_dark' => 'โหมดมืด',

    // ===== Employee Import page =====
    'emp_import_btn_download_export' => 'ดาวน์โหลดสรุปผลการประเมิน',
    'emp_import_btn_preview_employee' => 'ตรวจสอบข้อมูลที่นำเข้า',
    'emp_import_file_multi_hint' => 'คุณสามารถเลือกไฟล์ได้มากกว่า 1 ไฟล์ในครั้งเดียว (เช่น Attendance + Individual + OKR + Bonus)',
    'emp_import_file_selected_label' => 'ไฟล์ที่เลือก',

    // ===== Employee modal (employees table) =====
    'emp_modal_title_employees' => 'ข้อมูลพนักงานในตาราง (ทั้งหมด)',
    'emp_modal_summary_employees' => 'พบพนักงานทั้งหมด :total คน',
    'emp_modal_empty_employees' => 'ยังไม่มีข้อมูลพนักงานในตาราง employees ให้แสดง',
    'emp_modal_zoom_in' => 'ซูมเข้า',
    'emp_modal_zoom_out' => 'ซูมออก',

    // ===== ExportEmployee modal =====
    'export_emp_modal_summary' => 'พบพนักงานทั้งหมด :total คน',
    'export_emp_modal_empty'   => 'ยังไม่มีข้อมูลในตาราง export_employees ให้แสดง',
    'export_emp_modal_zoom_in' => 'ซูมเข้า',
    'export_emp_modal_zoom_out'=> 'ซูมออก',

    // ===== Generic modal =====
    'modal_btn_close' => 'ปิด',

    // ===== Employee column headers (employees preview) =====
    'emp_modal_col_employee_code'       => 'รหัสพนักงาน',
    'emp_modal_col_full_name_th'        => 'ชื่อ-สกุล (TH)',
    'emp_modal_col_full_name_en'        => 'ชื่อ-สกุล (EN)',
    'emp_modal_col_employee_type'       => 'ประเภทพนักงาน',
    'emp_modal_col_position'            => 'ตำแหน่ง',
    'emp_modal_col_department'          => 'แผนก',
    'emp_modal_col_dept_abbr_qms'       => 'ย่อแผนก (QMS)',
    'emp_modal_col_dept_abbr_hr'        => 'ย่อแผนก (HR)',
    'emp_modal_col_sup_id'              => 'รหัสหัวหน้างาน',
    'emp_modal_col_sup_name'            => 'ชื่อหัวหน้างาน',
    'emp_modal_col_div_id'              => 'รหัส Division',
    'emp_modal_col_div_name'            => 'ชื่อ Division',
    'emp_modal_col_dept_mgr_id'         => 'รหัสผู้จัดการแผนก',
    'emp_modal_col_dept_mgr_name'       => 'ชื่อผู้จัดการแผนก',
    'emp_modal_col_plant_mgr_id'        => 'รหัส Plant Manager',
    'emp_modal_col_plant_mgr_name'      => 'ชื่อ Plant Manager',
    'emp_modal_col_calendar'            => 'ปฏิทิน',
    'emp_modal_col_birthday'            => 'วันเกิด',
    'emp_modal_col_gender'              => 'เพศ',
    'emp_modal_col_age'                 => 'อายุ',
    'emp_modal_col_seniority_years'     => 'อายุงาน (ปี)',
    'emp_modal_col_seniority_months'    => 'อายุงาน (เดือน)',
    'emp_modal_col_foreign'             => 'ต่างชาติ',

    'emp_modal_col_attendance_total'      => 'คะแนน Attendance รวม',
    'emp_modal_col_attendance_sick'       => 'ลาป่วย',
    'emp_modal_col_attendance_personal'   => 'ลากิจ',
    'emp_modal_col_attendance_maternity'  => 'ลาคลอด',
    'emp_modal_col_attendance_ordain'     => 'ลาบวช',
    'emp_modal_col_attendance_late'       => 'มาสาย',
    'emp_modal_col_attendance_absent'     => 'ขาดงาน',
    'emp_modal_col_attendance_warning'    => 'หนังสือเตือน',
    'emp_modal_col_attendance_suspension' => 'พักงาน',

    'emp_modal_col_score_teamwork'        => 'Teamwork',
    'emp_modal_col_score_communication'   => 'Communication',
    'emp_modal_col_score_leadership'      => 'Leadership',
    'emp_modal_col_score_attitude'        => 'Attitude / วินัย',
    'emp_modal_col_score_planning'        => 'Planning & Organization',
    'emp_modal_col_score_ownership'       => 'Ownership',
    'emp_modal_col_score_problem_solving' => 'Problem Solving',
    'emp_modal_col_score_dept_okr'        => 'Dept. OKR',
    'emp_modal_col_score_company_okr'     => 'Company OKR',
    'emp_modal_col_score_okr_reporting'   => 'OKR Reporting',
    'emp_modal_col_score_system_smbr'     => 'System / SMBR',
    'emp_modal_col_score_bonus'           => 'Bonus',

    'emp_modal_col_assessment_status' => 'สถานะการประเมิน',
    'emp_modal_col_created_at'        => 'สร้างเมื่อ',
    'emp_modal_col_updated_at'        => 'แก้ไขล่าสุด',

    // ===== ExportEmployee column headers =====
    'export_emp_col_employee_code'   => 'รหัสพนักงาน',
    'export_emp_col_full_name_th'    => 'ชื่อ-สกุล (TH)',
    'export_emp_col_full_name_en'    => 'ชื่อ-สกุล (EN)',
    'export_emp_col_position'        => 'ตำแหน่ง',
    'export_emp_col_department'      => 'แผนก',
    'export_emp_col_position_level'  => 'ระดับตำแหน่ง',
    'export_emp_col_email'           => 'อีเมล',
    'export_emp_col_email_verified'  => 'ยืนยันอีเมลแล้ว',

    'export_emp_col_attendance_total'     => 'คะแนน Attendance รวม',
    'export_emp_col_individual_total'     => 'คะแนน Individual รวม',
    'export_emp_col_okr_dept_total'       => 'คะแนน Dept. OKR รวม',
    'export_emp_col_okr_company_total'    => 'คะแนน Company OKR รวม',
    'export_emp_col_system_total'         => 'คะแนน System / SMBR รวม',
    'export_emp_col_bonus_total'          => 'คะแนน Bonus รวม',

    'export_emp_col_attendance_sick'       => 'ลาป่วย',
    'export_emp_col_attendance_personal'   => 'ลากิจ',
    'export_emp_col_attendance_maternity'  => 'ลาคลอด',
    'export_emp_col_attendance_ordain'     => 'ลาบวช',
    'export_emp_col_attendance_late'       => 'มาสาย',
    'export_emp_col_attendance_absent'     => 'ขาดงาน',
    'export_emp_col_attendance_warning'    => 'หนังสือเตือน',
    'export_emp_col_attendance_suspension' => 'พักงาน',

    'export_emp_col_score_teamwork'        => 'Teamwork',
    'export_emp_col_score_communication'   => 'Communication',
    'export_emp_col_score_leadership'      => 'Leadership',
    'export_emp_col_score_attitude'        => 'Attitude / วินัย',
    'export_emp_col_score_planning'        => 'Planning & Organization',
    'export_emp_col_score_ownership'       => 'Ownership',
    'export_emp_col_score_problem_solving' => 'Problem Solving',
    'export_emp_col_score_dept_okr'        => 'Dept. OKR',
    'export_emp_col_score_company_okr'     => 'Company OKR',
    'export_emp_col_score_okr_reporting'   => 'OKR Reporting',
    'export_emp_col_score_system_smbr'     => 'System / SMBR',
    'export_emp_col_score_bonus'           => 'Bonus',

    'export_emp_col_supervisor_score_leadership' => 'Supervisor: Leadership',
    'export_emp_col_supervisor_score_attitude'   => 'Supervisor: Attitude',
    'export_emp_col_supervisor_final_score'      => 'Supervisor: คะแนนรวม',
    'export_emp_col_supervisor_grade'           => 'Supervisor: เกรด',
    'export_emp_col_supervisor_grade_text'      => 'Supervisor: คำอธิบายเกรด',

    'export_emp_col_division_score_leadership' => 'Division: Leadership',
    'export_emp_col_division_score_attitude'   => 'Division: Attitude',
    'export_emp_col_division_final_score'      => 'Division: คะแนนรวม',
    'export_emp_col_division_grade'           => 'Division: เกรด',
    'export_emp_col_division_grade_text'      => 'Division: คำอธิบายเกรด',

    'export_emp_col_sup_total'   => 'คะแนนรวม Supervisor',
    'export_emp_col_sup_grade'   => 'เกรด Supervisor',
    'export_emp_col_div_total'   => 'คะแนนรวม Division',
    'export_emp_col_div_grade'   => 'เกรด Division',
    'export_emp_col_final_score' => 'คะแนนสุดท้าย',
    'export_emp_col_final_grade' => 'เกรดสุดท้าย',

    'export_emp_col_assessment_status' => 'สถานะการประเมิน',
    'export_emp_col_created_at'        => 'สร้างเมื่อ',
    'export_emp_col_updated_at'        => 'แก้ไขล่าสุด',
    'app.export_emp_modal_title ' => 'แก้ไขล่าสุด',
        'export_emp_modal_title'        => 'ผลสรุปการประเมินพนักงาน (ทั้งหมด)',
    'emp_import_btn_preview_export' => 'ดูสรุปผลการประเมินทั้งหมด',
'assess_employees_supervisor_title' => 'ประเมินจาก Supervisor',
'assess_employees_division_title'   => 'ประเมินจาก Division',
'assess_employees_empty_division'   => 'ยังไม่มีพนักงานที่ต้องประเมินในฐานะ Division',
'assess_employees_empty_supervisor' => 'ยังไม่มีพนักงานที่ต้องประเมินในฐานะ Supervisor',
'assess_saved_already' => 'คุณได้ประเมินพนักงานคนนี้ไปแล้ว',


// Assessment Overview
'assess_overview_title' => 'Overview',
'assess_overview_header' => 'ดูผลลัพธ์ประเมินพนักงาน',
'assess_overview_path_dept' => 'Dept: Division → Supervisor → พนักงาน',

'assess_overview_chip_all' => 'รวมทั้งหมดในสาย',
'assess_overview_chip_dept' => 'Dept Manager',
'assess_overview_chip_division' => 'Division Manager',
'assess_overview_chip_supervisor' => 'Supervisor',
'assess_overview_chip_employee' => 'พนักงาน',

'assess_overview_section_plant' => 'Plant Manager',
'assess_overview_section_dept' => 'Dept Manager',
'assess_overview_section_division' => 'Division Manager',
'assess_overview_section_supervisor' => 'Supervisor',

'assess_overview_role_plant' => 'Plant Manager',
'assess_overview_role_dept' => 'Dept Manager',
'assess_overview_role_division' => 'Division Manager',
'assess_overview_role_supervisor' => 'Supervisor',

'assess_overview_you_here' => 'คุณอยู่ตำแหน่งนี้',
'assess_overview_boss' => '(ผู้บังคับบัญชา)',

'assess_overview_no_team' => 'ไม่พบข้อมูลลูกทีมในสังกัดของคุณ',
'assess_overview_no_dept' => 'ไม่พบ Dept Manager ในสายของคุณ',
'assess_overview_no_division' => 'ไม่พบ Division ภายใต้ Dept นี้',
'assess_overview_no_supervisor' => 'ไม่พบ Supervisor ภายใต้ Division นี้',
'assess_overview_no_employee' => 'ไม่พบรายชื่อพนักงานภายใต้ Supervisor นี้',

'assess_overview_count_supervisor' => ':count Supervisor',
'assess_overview_count_people' => ':count คน',
'assess_overview_count_division' => ':count Division',

'assess_overview_tt_profile' => 'ข้อมูลพนักงาน',
'assess_overview_tt_self' => 'ประเมินตัวเอง',
'assess_overview_tt_sup' => 'ประเมินโดย Supervisor',
'assess_overview_tt_my_profile' => 'ข้อมูลของฉัน',
'assess_overview_tt_my_self' => 'ประเมินตัวเอง',
'assess_overview_tt_row' => 'รหัส: :code | ตำแหน่ง: :pos | แผนก: :dept',

'assess_overview_theme_toggle' => 'สลับธีมมืด/สว่าง',
'assess_overview_lang_toggle' => 'เปลี่ยนภาษา',
'assess_overview_lang_th' => 'ไทย',
'assess_overview_lang_en' => 'English',

'assess_overview_modal_title' => 'รายละเอียดพนักงาน',
'assess_overview_modal_hint_photo' => '(คลิกรูปเพื่อดูภาพใหญ่)',
'assess_overview_tab_profile' => 'ข้อมูลพนักงาน',
'assess_overview_tab_self' => 'ประเมินตัวเอง',
'assess_overview_tab_sup' => 'ประเมิน Supervisor',

'assess_overview_k_name' => 'ชื่อ',
'assess_overview_k_code' => 'รหัส',
'assess_overview_k_position' => 'ตำแหน่ง',
'assess_overview_k_department' => 'แผนก',

'assess_overview_k_self_total' => 'คะแนนรวม',
'assess_overview_k_self_percent' => 'สรุปคะแนนรวม',
'assess_overview_self_full' => 'คะแนนเต็ม 100%',
'assess_overview_self_none' => 'ยังไม่มีข้อมูลประเมินตัวเองของพนักงานคนนี้',
'assess_overview_self_has' => 'ข้อมูลประเมินของพนักงาน',

'assess_overview_k_sup_lead' => 'คะแนนประเมิน (Leadership)',
'assess_overview_k_sup_att' => 'คะแนนประเมิน (Attitude)',
'assess_overview_k_sup_final' => 'สรุปคะแนนรวม (คะแนน)',
'assess_overview_k_sup_eval_code' => 'รหัสผู้ประเมิน',
'assess_overview_k_sup_eval_name' => 'ชื่อ-สกุลผู้ประเมิน',
'assess_overview_k_sup_eval_time' => 'เวลาประเมิน',
'assess_overview_sup_none' => 'ยังไม่มีข้อมูล “ประเมินโดย Supervisor” ของพนักงานคนนี้',

'assess_overview_btn_close' => 'ปิด',
'assess_overview_photo_title' => 'รูปโปรไฟล์',
'assess_overview_alt_profile' => 'รูปโปรไฟล์',
'assess_overview_alt_profile_large' => 'รูปโปรไฟล์ (ขนาดใหญ่)',
 'assess_back_profile' => 'กลับหน้าโปรไฟล์',
 'how_to_use_button' => 'วิธีใช้งาน',



 'guide_title' => 'วิธีใช้งาน',
'guide_subtitle' => 'เลือกหัวข้อด้านล่างเพื่อดูตัวอย่างหน้าจอและขั้นตอนการใช้งาน',
'guide_hint' => "หมายเหตุ:\n- ปุ่มแต่ละหัวข้อจะเปิดหน้าต่างเพื่อดูรูปภาพประกอบ\n- คุณสามารถใส่รูปเพิ่มได้ภายหลังตามหัวข้อ",
'guide_back_to_welcome' => 'กลับหน้าเข้าสู่ระบบ',
'guide_swipe_hint' => 'เลื่อนซ้าย/ขวาเพื่อดูรูปถัดไป',
'guide_no_images_yet' => 'ยังไม่มีรูปภาพในหัวข้อนี้ (เดี๋ยวแนบไฟล์ภาพแล้วค่อยเติมได้)',

'guide_btn_register_login' => 'สมัครสมาชิก & เข้าสู่ระบบ',
'guide_btn_forgot_password' => 'ลืมรหัสผ่าน',
'guide_btn_self_assessment' => 'การประเมินตัวเอง',
'guide_btn_employee_assessment' => 'การประเมินพนักงาน',
'guide_btn_view_results' => 'การดูผลลัพธ์',

'guide_modal_register_login_title' => 'สมัครสมาชิก & เข้าสู่ระบบ',
'guide_modal_register_login_desc' => 'ตัวอย่างหน้าจอและขั้นตอนการสมัครสมาชิก/เข้าสู่ระบบ',

'guide_modal_forgot_password_title' => 'ลืมรหัสผ่าน',
'guide_modal_forgot_password_desc' => 'ตัวอย่างหน้าจอและขั้นตอนการขอรีเซ็ตรหัสผ่าน',

'guide_modal_self_assessment_title' => 'การประเมินตัวเอง',
'guide_modal_self_assessment_desc' => 'ตัวอย่างหน้าจอและขั้นตอนการประเมินตัวเอง',

'guide_modal_employee_assessment_title' => 'การประเมินพนักงาน',
'guide_modal_employee_assessment_desc' => 'ตัวอย่างหน้าจอและขั้นตอนการประเมินพนักงาน',

'guide_modal_results_title' => 'การดูผลลัพธ์',
'guide_modal_results_desc' => 'ตัวอย่างหน้าจอและขั้นตอนการดูผลลัพธ์/สรุป',
'close' => 'ปิด',



//วิธีใช้ : สม้ครสมาชิก
    'guide_title' => 'วิธีการใช้งาน',
    'guide_subtitle' => 'คู่มือการใช้งานสำหรับพนักงาน',
    'guide_back_to_welcome' => 'กลับไปหน้าหลัก',
    'guide_image_alt' => 'ภาพประกอบวิธีการใช้งาน',

    'guide_btn_register_login' => 'สมัครสมาชิกและเข้าสู่ระบบ',
    'guide_btn_forgot_password' => 'ลืมรหัสผ่าน',
    'guide_btn_self_assessment' => 'การประเมินตัวเอง',
    'guide_btn_employee_assessment' => 'การประเมินพนักงาน',
    'guide_btn_view_results' => 'การดูผลลัพธ์',

    'guide_modal_register_login_title' => 'สมัครสมาชิกและเข้าสู่ระบบ',
    'guide_modal_register_login_desc' => 'ขั้นตอนการสมัครสมาชิกสำหรับพนักงาน',
    'guide_register_step1' => 'ที่หน้าเว็บไซต์ Supavut Assessment ให้คลิกปุ่ม “สมัครสมาชิก” เพื่อเริ่มต้นการสร้างบัญชีผู้ใช้งาน',
    'guide_register_step2' => 'กรอกรหัสพนักงาน แล้วคลิกปุ่ม “ตรวจสอบ” เพื่อยืนยันสถานะการเป็นพนักงาน และตรวจสอบข้อมูลที่แสดงให้ถูกต้อง',
    'guide_register_step3' => 'เมื่อระบบตรวจสอบสำเร็จ ให้ตั้งรหัสผ่าน กรอกอีเมล และอัปโหลดรูปโปรไฟล์ จากนั้นคลิก “ยืนยันสมัคร” (รูปโปรไฟล์ต้องถ่ายให้เหมือนตัวอย่างตามที่กำหนดเท่านั้น)',
    'guide_register_step4' => 'กรอกรหัส OTP แล้วคลิก “ยืนยัน OTP” (ระบบจะส่งรหัส OTP ไปยังอีเมลที่ใช้สมัครสมาชิก)',
    'guide_register_step5' => 'เมื่อยืนยันสำเร็จ จะถือว่า สมัครสมาชิกเรียบร้อย',

    'guide_modal_forgot_password_title' => 'ลืมรหัสผ่าน',
    'guide_modal_forgot_password_desc' => 'ขั้นตอนการขอรีเซ็ตรหัสผ่านและตั้งค่ารหัสผ่านใหม่',

    'guide_modal_self_assessment_title' => 'การประเมินตัวเอง',
    'guide_modal_self_assessment_desc' => 'ขั้นตอนการทำแบบประเมินตนเองและการบันทึกผล',

    'guide_modal_employee_assessment_title' => 'การประเมินพนักงาน',
    'guide_modal_employee_assessment_desc' => 'ขั้นตอนการประเมินพนักงานสำหรับผู้มีสิทธิ์ประเมิน',

    'guide_modal_results_title' => 'การดูผลลัพธ์',
    'guide_modal_results_desc' => 'ขั้นตอนการตรวจสอบผลการประเมินและดูข้อมูลสรุป',

    //วิธีใช้ : แก้ไขข้อมูลส่วนตัว
    'close' => 'ปิด',

'guide_btn_edit_profile' => 'แก้ไขข้อมูลส่วนตัว',
'guide_modal_edit_profile_title' => 'แก้ไขข้อมูลส่วนตัว',
'guide_modal_edit_profile_desc' => 'ขั้นตอนการเปลี่ยนอีเมลและรหัสผ่านในบัญชีผู้ใช้งาน',

'guide_edit_profile_step1' => 'พนักงานสามารถแก้ไขข้อมูลส่วนตัวได้โดยเข้าสู่หน้า “โปรไฟล์” และกดปุ่ม “แก้ไขข้อมูลส่วนตัว”',
'guide_edit_profile_step2' => 'ระบบจะนำไปยังหน้า “จัดการความปลอดภัยของบัญชี” ซึ่งแบ่งออกเป็น 2 ส่วน ได้แก่ “เปลี่ยนอีเมล” และ “เปลี่ยนรหัสผ่าน”',
'guide_edit_profile_step3' => 'การเปลี่ยนอีเมล: พนักงานกรอกอีเมลใหม่ในช่อง “อีเมล” จากนั้นกรอกรหัสผ่านเพื่อยืนยันตัวตน และกด “บันทึกอีเมล” เพื่อยืนยันการเปลี่ยนอีเมล',
'guide_edit_profile_step4' => 'การเปลี่ยนรหัสผ่าน: พนักงานกรอกรหัสผ่านปัจจุบันเพื่อยืนยันตัวตน จากนั้นกรอกรหัสผ่านใหม่ เมื่อดำเนินการครบถ้วน ให้กด “บันทึกรหัสผ่านใหม่” เพื่อยืนยันการเปลี่ยนรหัสผ่าน',

    //วิธีใช้ : ลืมรหัสผ่าน
    'close' => 'ปิด',

    // ปุ่ม
    'guide_btn_forgot_password' => 'ลืมรหัสผ่าน',

    // Modal: Forgot password
    'guide_modal_forgot_password_title' => 'ลืมรหัสผ่าน',
    'guide_modal_forgot_password_desc'  => 'ขั้นตอนการขอตั้งรหัสผ่านใหม่และยืนยันการเปลี่ยนรหัสผ่าน',

    // Steps: Forgot password (4 ข้อ)
    'guide_forgot_password_step1' => 'เมื่อพนักงานลืมรหัสผ่าน ให้กดปุ่ม “ลืมรหัสผ่าน” บนหน้าล็อกอิน',
    'guide_forgot_password_step2' => 'พนักงานต้องกรอก “รหัสพนักงาน” และ “อีเมลที่ใช้สมัครสมาชิก” ให้ถูกต้อง จากนั้นกดปุ่ม “ส่งลิงก์ตั้งรหัสผ่านใหม่”',
    'guide_forgot_password_step3' => 'เมื่อกดส่งแล้ว ระบบจะจัดส่งลิงก์สำหรับตั้งรหัสผ่านใหม่ไปยังอีเมลของพนักงาน',
    'guide_forgot_password_step4' => 'พนักงานเปิดอีเมลและกดลิงก์เพื่อเข้าสู่หน้าตั้งรหัสผ่านใหม่ จากนั้นกำหนดรหัสผ่านใหม่ และกดปุ่ม “บันทึกรหัสผ่านใหม่” เพื่อยืนยันการเปลี่ยนรหัสผ่านให้เสร็จสิ้น',

    //วิธีใช้ : ลืมรหัสผ่าน
    'close' => 'ปิด',

    // ปุ่ม
    'guide_btn_forgot_password' => 'ลืมรหัสผ่าน',

    // Modal: Forgot password
    'guide_modal_forgot_password_title' => 'ลืมรหัสผ่าน',
    'guide_modal_forgot_password_desc'  => 'ขั้นตอนการขอตั้งรหัสผ่านใหม่และยืนยันการเปลี่ยนรหัสผ่าน',

    // Steps: Forgot password (4 ข้อ)
    'guide_forgot_password_step1' => 'เมื่อพนักงานลืมรหัสผ่าน ให้กดปุ่ม “ลืมรหัสผ่าน” บนหน้าล็อกอิน',
    'guide_forgot_password_step2' => 'พนักงานต้องกรอก “รหัสพนักงาน” และ “อีเมลที่ใช้สมัครสมาชิก” ให้ถูกต้อง จากนั้นกดปุ่ม “ส่งลิงก์ตั้งรหัสผ่านใหม่”',
    'guide_forgot_password_step3' => 'เมื่อกดส่งแล้ว ระบบจะจัดส่งลิงก์สำหรับตั้งรหัสผ่านใหม่ไปยังอีเมลของพนักงาน',
    'guide_forgot_password_step4' => 'พนักงานเปิดอีเมลและกดลิงก์เพื่อเข้าสู่หน้าตั้งรหัสผ่านใหม่ จากนั้นกำหนดรหัสผ่านใหม่ และกดปุ่ม “บันทึกรหัสผ่านใหม่” เพื่อยืนยันการเปลี่ยนรหัสผ่านให้เสร็จสิ้น',

    'guide_group_account' => 'บัญชี',
'guide_group_account_desc' => 'สมัครสมาชิก • เข้าสู่ระบบ • แก้ไขข้อมูล • ลืมรหัสผ่าน',

'guide_group_assessment' => 'การประเมิน',
'guide_group_assessment_desc' => 'ประเมินตัวเอง • ประเมินพนักงาน • ดูผลลัพธ์',

'guide_image_missing' => 'ยังไม่มีไฟล์ภาพประกอบในระบบ (สามารถเพิ่มไฟล์ภาพภายหลังได้)',

'guide_modal_self_assessment_title' => 'การประเมินตัวเอง',
'guide_modal_self_assessment_desc' => 'ขั้นตอนการทำแบบประเมินตัวเอง',

'guide_self_assessment_step1' => 'เมื่อถึงช่วงเวลาที่กำหนด ระบบจะเปิดใช้งานปุ่ม “ประเมินตัวเอง” เพื่อให้พนักงานทุกคนสามารถทำแบบประเมินตนเองได้',
'guide_self_assessment_step2' => 'เมื่อเข้าสู่หน้าประเมิน ให้พนักงานอ่านคำถามในแบบประเมินอย่างละเอียด และตอบคำถามให้ครบทุกข้อ',
'guide_self_assessment_step3' => 'เมื่อทำแบบประเมินเสร็จสิ้น ให้กดปุ่ม “ส่งแบบประเมินตัวเอง” และยืนยันการส่ง เพื่อบันทึกผลการประเมินเข้าสู่ระบบ',
'guide_self_assessment_step4' => 'เมื่อระบบบันทึกข้อมูลเรียบร้อย ถือว่าเสร็จสิ้นกระบวนการประเมินตนเอง',

'guide_modal_employee_assessment_title' => 'ประเมินพนักงาน',
'guide_modal_employee_assessment_desc' => 'ขั้นตอนการประเมินพนักงานตามสิทธิ์ผู้ประเมิน',

'guide_employee_assessment_step1' => 'ผู้ประเมินเลือกพนักงานจากรายชื่อ แล้วกดปุ่ม “ประเมิน” เพื่อเข้าสู่หน้าประเมิน',
'guide_employee_assessment_step2' => 'กรอกคะแนนและข้อมูลการประเมินให้ครบถ้วนตามแบบฟอร์มที่ระบบกำหนด',
'guide_employee_assessment_step3' => 'กดปุ่ม “บันทึกคะแนนรวม” และยืนยันการบันทึก เพื่อส่งผลการประเมินเข้าสู่ระบบ',
'guide_employee_assessment_step4' => 'เมื่อบันทึกสำเร็จ ระบบจะแสดงสถานะการประเมินว่าเสร็จสิ้น และสามารถกลับไปตรวจสอบผลได้',

'guide_modal_results_title' => 'ดูผลลัพธ์',
'guide_modal_results_desc' => 'ขั้นตอนการเข้าดูผลลัพธ์การประเมิน',

'guide_results_step1' => 'กดปุ่ม “ดูผลลัพธ์” เพื่อเข้าสู่หน้าสรุปผลการประเมิน',
'guide_results_step2' => 'เลือกค้นหาหรือเลือกหน่วยงาน/พนักงานที่ต้องการตรวจสอบผลลัพธ์',
'guide_results_step3' => 'ระบบจะแสดงผลสรุปและสามารถเปิดดูรายละเอียดได้ตามสิทธิ์ของผู้ใช้งาน',
'guide_results_step4' => 'ตรวจสอบผลลัพธ์เรียบร้อย ถือว่าเสร็จสิ้น',


'guide_employee_assessment_step1' => 'เมื่อถึงช่วงเวลาที่กำหนด ระบบจะเปิดใช้งานปุ่ม “ประเมินพนักงาน” เพื่อให้หัวหน้างานได้ประเมินพนักงานในสายงานของตน',
'guide_employee_assessment_step2' => 'ในหน้ารายการพนักงานที่ต้องประเมิน ระบบจะแสดงบทบาทของผู้ประเมินว่าเป็น Supervisor หรือ Division และจะแสดงเฉพาะพนักงานในสายงานของผู้ประเมิน จากนั้นกดปุ่ม “ประเมิน” เพื่อเริ่มการประเมิน',
'guide_employee_assessment_step3' => 'ในหน้าแบบประเมินพนักงาน จะมีข้อมูลพนักงานและหัวข้อประเมิน เช่น Attendance, Individual Performance, Department OKR, Company OKR, System (SMBR), Bonus โดยผู้ประเมินต้องกรอกคะแนนในหัวข้อ Individual Performance',
'guide_employee_assessment_step4' => 'ในหัวข้อ Individual Performance ผู้ประเมินต้องให้คะแนนในช่อง Leadership และ Attitude ให้ครบถ้วน',
'guide_employee_assessment_step5' => 'เมื่อกรอกคะแนนแล้ว กด “คำนวณ” เพื่อให้ระบบคำนวณผลลัพธ์ของหัวข้อ Individual จากนั้นกด “นำไปใช้” เพื่อยืนยันคะแนน',
'guide_employee_assessment_step6' => 'ระบบจะนำคะแนนจากทุกหัวข้อไปคำนวณเป็นคะแนนรวมของพนักงานคนนั้นโดยอัตโนมัติ',
'guide_employee_assessment_step7' => 'ขั้นตอนสุดท้าย กด “บันทึกคะแนนรวม” เพื่อยืนยันและเสร็จสิ้นการประเมิน',
'guide_employee_assessment_step8' => 'เมื่อบันทึกสำเร็จ ผลลัพธ์การประเมินจะแสดงให้พนักงานที่ได้รับการประเมินตรวจสอบได้',


'guide_modal_results_title' => 'ดูผลลัพธ์การประเมิน',
'guide_modal_results_desc'  => 'ขั้นตอนการตรวจสอบผลการประเมินสำหรับผู้มีสิทธิ์ดูผลลัพธ์',

'guide_results_step1' => 'สำหรับผู้ใช้งานในตำแหน่ง Dept Manager และ Plant Manager ระบบจะแสดงปุ่ม “ดูผลลัพธ์” เพื่อใช้ตรวจสอบผลการประเมินของพนักงานในสายงานที่รับผิดชอบ',
'guide_results_step2' => 'เมื่อกดปุ่ม “ดูผลลัพธ์” ระบบจะแสดงหน้ารายการผลการประเมินของพนักงาน โดยจัดลำดับโครงสร้างสายงานตั้งแต่ Plant Manager → Dept Manager → Division Manager → Supervisor → พนักงาน',
'guide_results_step3' => 'ผู้ใช้งานสามารถเลือกคลิกที่รายชื่อในแต่ละลำดับ เพื่อแสดงรายชื่อพนักงานภายใต้สายงานของบุคคลนั้นตามลำดับชั้นที่ต้องการตรวจสอบ',
'guide_results_step4' => 'ระบบรองรับการเปิดดูรายละเอียดข้อมูลของพนักงานรายบุคคลได้',
'guide_results_step5' => 'ระบบรองรับการเปิดดูรายละเอียดผลการประเมินตัวเองของพนักงานได้',
'guide_results_step6' => 'ระบบรองรับการเปิดดูรายละเอียดผลการประเมินจากหัวหน้างานได้',







//Supavut Penalty&Bonus

//หน้าเว็บ
'pb_title' => 'Supavut Penalty & Bonus',
'pb_module_badge' => 'Supavut Module',
'pb_login_subtitle' => 'เข้าสู่ระบบเพื่อใช้งานโมดูลหัก/บวกคะแนน',
'pb_login_failed' => 'เข้าสู่ระบบไม่สำเร็จ',
'pb_username' => 'รหัสพนักงาน',
'pb_username_placeholder' => 'กรอกรหัสพนักงาน',
'pb_password' => 'รหัสผ่าน',
'pb_password_placeholder' => 'กรอกรหัสผ่าน',
'pb_login_button' => 'เข้าสู่ระบบ',
'pb_back_assessment' => 'กลับไป Supavut Assessment',
'pb_theme_dark' => 'มืด',

//หน้าโปรไฟล์
// ===== Penalty & Bonus (PB) =====
'pb_title' => 'Supavut Penalty & Bonus',
'pb_module_badge' => 'Supavut Module',
'pb_login_subtitle' => 'เข้าสู่ระบบเพื่อใช้งานระบบหัก/บวกคะแนน',
'pb_login_failed' => 'เข้าสู่ระบบไม่สำเร็จ',
'pb_username' => 'รหัสพนักงาน',
'pb_username_placeholder' => 'กรอกรหัสพนักงาน',
'pb_password' => 'รหัสผ่าน',
'pb_password_placeholder' => 'กรอกรหัสผ่าน',
'pb_login_button' => 'เข้าสู่ระบบ',
'pb_back_assessment' => 'กลับไป Supavut Assessment',
'pb_theme_dark' => 'Dark',
'pb_access_denied' => 'ไม่สามารถเข้า Penalty & Bonus ได้',
'pb_must_verify_otp' => 'บัญชีนี้ยังไม่ยืนยัน OTP กรุณายืนยัน OTP ใน Supavut Assessment ก่อน จึงจะเข้า Penalty & Bonus ได้',

'pb_username_required' => 'กรุณากรอกรหัสผู้ใช้',
'pb_password_required' => 'กรุณากรอกรหัสผ่าน',
'pb_invalid_credentials' => 'รหัสผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง',

'pb_profile_subtitle' => 'โปรไฟล์ของโมดูล Penalty & Bonus (กำลังพัฒนา)',
'pb_logged_in_as' => 'เข้าสู่ระบบด้วย',
'pb_inbox' => 'กล่องขาเข้า',
'pb_inbox_hint' => 'ดูรายการ/คิวที่เกี่ยวข้อง (กำลังพัฒนา)',
'pb_import' => 'Import',
'pb_import_hint' => 'สำหรับผู้มีสิทธิ์เท่านั้น (กำลังพัฒนา)',
'pb_open' => 'เปิด',
'pb_logout' => 'ออกจากระบบ',

'profile_picture' => 'รูปโปรไฟล์',
'profile_picture_hint' => 'อัปโหลดรูปใหม่เพื่อทับรูปเดิม (jpg/png/webp) ขนาดไม่เกิน 10MB',
'choose_profile_picture' => 'เลือกไฟล์รูปโปรไฟล์',
'save_profile_picture' => 'บันทึกรูปโปรไฟล์',

'pb_import' => 'นำเข้าข้อมูล',
'pb_import_hint' => 'เลือกประเภทการนำเข้า',
'pb_import_choose_type' => 'เลือกประเภทการนำเข้า',
'pb_import_individual' => 'รายบุคคล',
'pb_import_department' => 'รายแผนก',
'pb_import_department_note' => 'รายแผนก (Department ฟ้อง)',


'page_title' => 'PB • รายบุคคล',
  'header_title' => 'รายบุคคล',
  'formula_hint' => ':base + เพิ่ม − หัก',

  'back' => 'กลับ',

  'theme_dark' => 'โหมดมืด',
  'theme_light' => 'โหมดสว่าง',

  'table_title' => 'ตาราง',
  'recipient' => 'ผู้รับ',
  'from' => 'จาก',
  'count' => 'จำนวน',
  'save' => 'บันทึก',

  'created_by' => 'ผู้ทำรายการ',
  'supervisor' => 'หัวหน้า',

  'status_draft' => 'ยังไม่ส่ง',
  'status_waiting' => 'รอการดำเนินการ',
  'status_done' => 'สำเร็จ',
  'status_rejected' => 'ปฏิเสธ',

  'col_type' => 'ประเภท',
  'col_points' => 'คะแนน',
  'col_heading' => 'หัวข้อ',
  'col_reason' => 'เหตุผล',
  'col_evidence' => 'หลักฐาน',

  'no_items' => '— ไม่มีรายการ —',

  'kpi_base' => 'ฐาน',
  'kpi_add' => 'เพิ่ม',
  'kpi_deduct' => 'หัก',
  'kpi_net' => 'สุทธิ',

  'add_item_title' => 'เพิ่มรายการ',
  'add_score' => 'เพิ่มคะแนน',
  'deduct_score' => 'ลดคะแนน',

  'type' => 'ประเภท',
  'points' => 'คะแนน',
  'heading' => 'หัวข้อ',
  'reason' => 'เหตุผล',
  'heading_placeholder' => 'กรุณากรอกหัวข้อ',
  'reason_placeholder' => 'พิมพ์สั้นๆ…',

  'attach_images_optional' => 'แนบรูป (ไม่บังคับ)',
  'images_hint' => 'รูปที่แนบจะโชว์เป็นภาพเล็กในตาราง และกดขยายได้',

  'add' => 'เพิ่ม',
  'add_recipient' => 'เพิ่มผู้รับ',
  'remove' => 'ลบ',
  'remove_to_change' => 'ลบเพื่อเปลี่ยนผู้รับ',

  'recipient_search_placeholder' => '🔎 ค้นหา (ชื่อ/หัวหน้า/รหัส)',
  'select_then_add_hint' => 'เลือกพนักงานแล้วกด “เพิ่ม”',
  'selected_recipient' => 'ผู้รับที่เลือก',
  'remove_to_change_hint' => 'ถ้าต้องการเปลี่ยนผู้รับ ให้กด “ลบ”',
  'no_recipient' => '— ยังไม่เลือกผู้รับ —',

  'rejection_title' => 'รายละเอียดการปฏิเสธ',
  'rejection_desc' => 'ส่วนนี้ผู้รับจะเป็นคนกรอกเมื่อ “ปฏิเสธ” รายการเพิ่ม/ลดคะแนน (ทำเผื่อไว้)',
  'rejection_none' => '— ยังไม่มีการปฏิเสธ —',

  'image' => 'รูปภาพ',
  'profile' => 'โปรไฟล์',
  'view_profile_photo' => 'ดูรูปโปรไฟล์',
  'close' => 'ปิด',

  'dash' => '-',
  'delete' => 'ลบ',

  // JS messages
  'rec_err_select_one_before_add' => 'เลือกผู้รับ 1 คนก่อน',
  'rec_err_at_least_one' => 'เลือกผู้รับอย่างน้อย 1 คน',
  'alert_add_at_least_one_item' => 'เพิ่มรายการอย่างน้อย 1 รายการ',
  'item_err_heading_required' => 'กรุณากรอกหัวข้อ',
  'item_err_reason_required' => 'กรอกเหตุผล',

  'pb_emp_pick_title' => 'เลือกพนักงาน (รายบุคคล)',
'pb_emp_pick_hint' => 'หน้าเริ่มต้นสำหรับ “เพิ่ม/หักคะแนนรายบุคคล” — ดึงรายชื่อจากตาราง employees ตามรหัสพนักงาน',

'pb_search_placeholder_employee' => 'ค้นหา: รหัสพนักงาน / ชื่อไทย / ชื่ออังกฤษ / ตัวย่อแผนก(QMS) / ตำแหน่ง',
'pb_search' => 'ค้นหา',
'pb_clear' => 'ล้าง',

'pb_showing' => 'แสดงผล',
'pb_people' => 'คน',
'pb_page' => 'หน้า',

'pb_employee_code' => 'รหัสพนักงาน',
'pb_name_th' => 'ชื่อ-สกุล (TH)',
'pb_name_en' => 'ชื่อ-สกุล (EN)',
'pb_position' => 'ตำแหน่ง',
'pb_qms_dept' => 'แผนก (QMS)',
'pb_status' => 'สถานะ',
'pb_manage' => 'จัดการ',
'pb_not_found_employees' => 'ไม่พบรายชื่อพนักงาน',

'pb_back' => 'กลับ',
'pb_back_profile' => 'กลับหน้าโปรไฟล์',



// ===== PB Department (Group) =====
'pb_dept_pick_title' => 'เลือกแผนก (รายแผนก)',
'pb_dept_pick_hint' => 'จัดกลุ่มตามตัวย่อแผนก (QMS) เพื่อเพิ่ม/หักคะแนนแบบกลุ่ม',
'pb_dept_manage_title' => 'จัดการคะแนนแบบกลุ่ม (รายแผนก)',
'pb_dept_manage_hint' => 'เพิ่ม/หักคะแนนให้พนักงานทั้งแผนก โดยอ้างอิงตัวย่อแผนก (QMS)',
'pb_search_placeholder_department' => 'ค้นหา: ตัวย่อแผนก(QMS) / ชื่อแผนก / ตัวย่อส่วนงาน(HR)',
'pb_dept_abbr_qms' => 'แผนก (QMS)',
'pb_department_name' => 'ชื่อแผนก',
'pb_people_count' => 'จำนวนพนักงาน',
'pb_departments' => 'แผนก',

'pb_items' => 'รายการ',
'pb_add_item' => 'เพิ่มรายการ',
'pb_item_type' => 'ประเภท',
'pb_item_add' => 'เพิ่มคะแนน',
'pb_item_deduct' => 'หักคะแนน',
'pb_points' => 'คะแนน',
'pb_reason' => 'เหตุผล',
'pb_evidence' => 'หลักฐาน',
'pb_attach_images' => 'แนบรูป',
'pb_remove' => 'ลบ',
'pb_save' => 'บันทึก',
'pb_saved_draft' => 'บันทึกแบบร่างเรียบร้อยแล้ว',

'pb_not_found_departments' => 'ไม่พบแผนก',


// ===== PB: Department pick + employee modal =====
'pb_dept_pick_title' => 'PB • เลือกแผนก',
'pb_dept_pick_hint' => 'เลือกแผนก (ตัวย่อ QMS) เพื่อเพิ่ม/หักคะแนนแบบกลุ่ม',
'pb_search_placeholder_department' => 'ค้นหาแผนก...',
'pb_search' => 'ค้นหา',
'pb_clear' => 'ล้าง',
'pb_showing' => 'จำนวน',
'pb_departments' => 'แผนก',
'pb_page' => 'หน้า',

'pb_dept_abbr_qms' => 'ตัวย่อแผนก (QMS)',
'pb_department_name' => 'ชื่อแผนก',
'pb_people_count' => 'จำนวนคน',
'pb_people' => 'คน',

'pb_status' => 'สถานะ',
'pb_status_draft' => 'ยังไม่ส่ง',
'pb_status_waiting' => 'รอการดำเนินการ',
'pb_status_done' => 'สำเร็จ',
'pb_status_rejected' => 'ปฏิเสธ',

'pb_manage' => 'จัดการ',
'pb_not_found_departments' => 'ไม่พบรายการแผนก',
'pb_back' => 'กลับ',
'pb_back_profile' => 'กลับหน้าโปรไฟล์',

'pb_theme_dark' => 'มืด',
'pb_theme_light' => 'สว่าง',

// ✅ Modal employee list
'pb_view_employees' => 'รายชื่อพนักงาน',
'pb_employee_list_title' => 'รายชื่อพนักงานในแผนก',
'pb_employee_search_placeholder' => 'ค้นหา รหัสพนักงาน / ชื่อ / ตำแหน่ง...',
'pb_employee_total' => 'ทั้งหมด',
'pb_employee_code' => 'รหัสพนักงาน',
'pb_employee_name' => 'ชื่อ-สกุล',
'pb_employee_position' => 'ตำแหน่ง',
'pb_employee_supervisor' => 'หัวหน้างาน',
'pb_close' => 'ปิด',
'pb_loading' => 'กำลังโหลด...',
'pb_no_employees' => 'ไม่พบรายชื่อพนักงาน',
'pb_fetch_failed' => 'โหลดรายชื่อไม่สำเร็จ',


// PB - Department Manage
'pb_dept_manage_title' => 'Penalty/Bonus • รายแผนก',
'pb_dept_manage_hint'  => 'เพิ่ม/หักคะแนนให้ “ทั้งแผนก” ตามรายการที่ระบุ',
'pb_dept_manage_title' => 'จัดการคะแนนรายแผนก',
'pb_dept_manage_hint'  => 'เพิ่ม/หักคะแนนให้พนักงานทั้งหมดในแผนกที่เลือก',
'pb_dept_employees_title' => 'รายชื่อพนักงานในแผนกนี้',
'pb_apply_to_all_hint' => 'รายการนี้จะถูกใช้กับพนักงานทั้งหมดในแผนก',
'pb_summary' => 'สรุป',
'pb_total_add' => 'รวมเพิ่ม',
'pb_total_deduct' => 'รวมหัก',
'pb_final_score' => 'คงเหลือสุทธิ',

'pb_type' => 'ประเภท',
'pb_add' => 'เพิ่ม',
'pb_deduct' => 'หัก',
'pb_points' => 'คะแนน',
'pb_reason' => 'เหตุผล',
'pb_reason_placeholder' => 'ระบุเหตุผล...',
'pb_evidence' => 'หลักฐาน',
'pb_add_item' => 'เพิ่มรายการ',
'pb_clear_all' => 'ล้างทั้งหมด',
'pb_action' => 'จัดการ',
'pb_no_items' => 'ยังไม่มีรายการ',
'pb_need_one_item' => 'กรุณาเพิ่มอย่างน้อย 1 รายการก่อนบันทึก',

'pb_points_invalid' => 'คะแนนต้องมากกว่า 0',
'pb_reason_required' => 'กรุณากรอกเหตุผล',
'pb_confirm_clear_all' => 'ต้องการล้างรายการทั้งหมดใช่ไหม?',

'pb_preview' => 'พรีวิว',
'pb_close' => 'ปิด',
'pb_save' => 'บันทึก',
'pb_fix_errors' => 'กรุณาแก้ไขข้อผิดพลาด',
'pb_saved_success' => 'บันทึกเรียบร้อยแล้ว',

'pb_in_dept' => 'แผนก',
'pb_heading' => 'หัวข้อ',
'pb_col_by' => 'เพิ่ม/หักคะแนนโดย',
'pb_reject_detail_title' => 'รายละเอียดการปฏิเสธ',
'pb_reject_detail_hint' => 'หากมีการปฏิเสธ/ไม่อนุมัติในภายหลัง สามารถใส่รายละเอียดไว้ที่นี่ (ถ้าไม่ใช้ ปล่อยว่างได้)',
'pb_base' => 'ฐาน',
'pb_net'  => 'รวมสุทธิ',
'pb_send_to' => 'ปลายทาง/ผู้รับ',
'pb_recipient_hint' => 'เลือกปลายทางได้เพียง 1 คน',
'pb_heading_placeholder' => 'กรอกหัวข้อ...',
    'pb_reject_detail_placeholder' => 'กรอกรายละเอียดการปฏิเสธ (ถ้ามี)...',
    'pb_added_at' => 'วันเวลาที่เพิ่ม',











    // ===== PB (Penalty & Bonus) - Inbox =====
  'pb_title' => 'Penalty & Bonus',
  'pb_inbox' => 'กล่องขาเข้า',
  'pb_inbox_tabs' => 'แท็บกล่องขาเข้า',
  'pb_logged_in_as' => 'ผู้ใช้',
  'pb_back' => 'กลับ',

  'pb_theme_dark' => 'มืด',
  'pb_theme_light' => 'สว่าง',

  'pb_tab_department' => 'รายแผนก',
  'pb_tab_individual' => 'รายบุคคล',
  'pb_inbox_hint' => 'เลือกจากซ้าย แล้วดูเอกสารทางขวา',

  'pb_list_department' => 'รายชื่อแผนก (QMS)',
  'pb_sort_qms' => 'เรียงตาม QMS',
  'pb_search_department' => 'ค้นหา QMS/ชื่อแผนก...',
  'pb_no_department' => 'ไม่พบแผนก',

  'pb_list_employee' => 'รายชื่อพนักงาน',
  'pb_sort_code' => 'เรียงตามรหัส',
  'pb_search_employee' => 'ค้นหารหัส/ชื่อ...',
  'pb_no_employee' => 'ไม่พบพนักงาน',

  'pb_left_pick' => 'เลือก',
  'pb_count_docs' => 'จำนวนเอกสาร',

  'pb_pick_left' => 'กรุณาเลือกจากด้านซ้าย',
  'pb_inbox_sub_dept' => 'เอกสารที่ส่งมาจาก Department ต่างๆ (โหมดรายแผนก)',
  'pb_inbox_sub_emp' => 'เอกสารที่ส่งมาจาก Department ต่างๆ (โหมดรายบุคคล)',
  'pb_no_docs' => 'ยังไม่มีเอกสาร',

  'pb_pending' => 'รอพิจารณา',
  'pb_approved' => 'อนุมัติแล้ว',
  'pb_rejected' => 'ปฏิเสธแล้ว',

  'pb_from' => 'จาก',

  'pb_kpi_base' => 'ฐาน',
  'pb_kpi_add' => 'บวก',
  'pb_kpi_deduct' => 'หัก',
  'pb_kpi_net' => 'รวมสุทธิ',

  'pb_detail' => 'รายละเอียด',
  'pb_confirm_approve' => 'ยืนยันการอนุมัติ?',
  'pb_approve' => 'อนุมัติ',
  'pb_reject' => 'ปฏิเสธ',
  'pb_closed' => 'ปิดแล้ว',

  'pb_reject_note' => 'เหตุผลที่ปฏิเสธ',

  'pb_group' => 'กลุ่ม',
  'pb_created_at' => 'วันเวลา',
  'pb_items' => 'รายการ',

  'pb_type' => 'ประเภท',
  'pb_points' => 'คะแนน',
  'pb_heading' => 'หัวข้อ',
  'pb_reason' => 'เหตุผล',
  'pb_evidence' => 'หลักฐาน',

  'pb_reason_keep_format' => 'เหตุผลจะแสดงตามเว้นวรรค/บรรทัดเดิมที่ผู้ส่งกรอก',
  'pb_no_items' => 'ไม่มีรายการ',

  'pb_add_score' => 'เพิ่มคะแนน',
  'pb_deduct_score' => 'หักคะแนน',
  'pb_dash' => '-',

  'pb_document' => 'เอกสาร',
  'pb_reject_reason' => 'พิมพ์รายละเอียดเพื่อส่งกลับไปยังผู้ส่ง',
  'pb_reject_placeholder' => 'พิมพ์เหตุผล... (ขึ้นบรรทัด/เว้นวรรคได้)',
  'pb_cancel' => 'ยกเลิก',
  'pb_send_back' => 'ส่งกลับ (ปฏิเสธ)',
  'pb_reject_tip' => 'เมื่อกดปฏิเสธ ระบบจะบันทึกและแจ้งกลับไปยังผู้ส่ง',
  'pb_reject_need_note' => 'กรุณาพิมพ์รายละเอียดก่อนส่งปฏิเสธ',

  'pb_prev' => 'ก่อนหน้า',
  'pb_next' => 'ถัดไป',
  'pb_page_x_of_y' => 'หน้า :current / :total',

  'pb_close' => 'ปิด',
  'pb_image' => 'รูปภาพ',

  'pb_footer_copy' => '© :year Supavut Industry Co., Ltd.',

  // ===== Example (UI preview) =====
  'pb_example_doc_title' => 'ตัวอย่างเอกสารปรับคะแนน (Preview)',
  'pb_example_from_dept' => 'ฝ่ายต้นทาง (ตัวอย่าง)',
  'pb_example_item_heading1' => 'มาสาย',
  'pb_example_item_reason1' => 'มาสายเกินกำหนดตามนโยบาย',
  'pb_example_item_heading2' => 'ช่วยงานพิเศษ',
  'pb_example_item_reason2' => 'ช่วยสนับสนุนงานเร่งด่วน',
  'pb_example_pdf_name' => 'ไฟล์ตัวอย่าง.pdf',
  'pb_example_only' => 'โหมดตัวอย่าง: ปุ่มนี้แสดง UI เท่านั้น (ยังไม่ผูกฐานข้อมูล)',
    'pb_create_topic' => 'สร้างหัวข้อ',


    'citizen_id_label' => 'รหัสบัตรประชาชน (13 หลัก)',
'citizen_id_placeholder' => 'กรอกเลข 13 หลัก',
'citizen_id_help' => 'ใช้ยืนยันตัวตนในการเปลี่ยนรหัสผ่าน',
'citizen_id_required' => 'กรุณากรอกรหัสบัตรประชาชน',
'citizen_id_invalid' => 'รหัสบัตรประชาชนไม่ถูกต้อง',

'save_email_success' => 'บันทึกอีเมลเรียบร้อยแล้ว',
'save_password_success' => 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',
'profile_picture_saved' => 'บันทึกรูปโปรไฟล์เรียบร้อยแล้ว',
 'first_login_upload_title' => 'อัปโหลดรูปโปรไฟล์ครั้งแรก',
    'first_login_upload_hint'  => 'กรุณาอัปโหลดรูปโปรไฟล์ก่อนเข้าสู่ระบบ',
    'required'                 => 'จำเป็น',
    'upload_and_login'         => 'อัปโหลดและเข้าสู่ระบบ',





    // === Login page (Assessment) ===
    'aria_switch_website' => 'สลับเว็บไซต์',
    'aria_language_switcher' => 'สลับภาษา',

    'site_assessment' => 'Supavut Assessment',
    'site_pb' => 'Supavut Penalty & Bonus',

    'logo_alt' => 'โลโก้ Supavut',
    'footer_copyright' => '© :year Supavut Industry Co., Ltd.',

    'password_placeholder' => 'กรอกรหัสผ่าน',
    'forgot_password' => 'ลืมรหัสผ่าน',

    // Employee preview statuses
    'emp_status_ok' => 'OK',
    'emp_status_not_found' => 'ไม่พบข้อมูล',
    'emp_status_ready' => 'พร้อมใช้งาน',
    'emp_status_no_photo' => 'ไม่มีรูป',
    'emp_status_verified' => 'ยืนยันแล้ว',
    'emp_preview_not_found' => 'ไม่พบข้อมูล',

    // Common texts used in JS (ensure exist)
    'checking' => 'กำลังตรวจสอบ...',
    'logging_in' => 'กำลังเข้าสู่ระบบ...',
    'uploading' => 'กำลังอัปโหลด...',

    // Offline
    'offline_alert' => 'คุณออฟไลน์อยู่ กรุณาตรวจสอบการเชื่อมต่ออินเทอร์เน็ต',

    // Errors / validations (ensure exist)
    'emp_lookup_error_code_required' => 'กรุณากรอกข้อมูลผู้ใช้',
    'password_required' => 'กรุณากรอกรหัสผ่าน',
    'emp_lookup_error_general' => 'เกิดข้อผิดพลาด กรุณาลองใหม่',
    'emp_lookup_error_not_found' => 'ไม่พบข้อมูลพนักงาน',
    'auth_invalid_credentials' => 'ข้อมูลล็อกอินไม่ถูกต้อง',

    // First login upload (ensure exist)
    'first_login_upload_title' => 'อัปโหลดรูปโปรไฟล์ก่อนเข้าใช้งาน',
    'first_login_upload_hint' => 'ระบบพบว่าคุณยังไม่มีรูปโปรไฟล์ กรุณาอัปโหลดรูปก่อนเข้าสู่หน้าโปรไฟล์',
    'required' => 'จำเป็น',
    'profile_picture' => 'รูปโปรไฟล์',
    'profile_picture_hint' => 'แนะนำรูปหน้าตรง ชัดเจน (รองรับ JPG/PNG/WEBP ขนาดไม่เกิน 10MB)',
    'profile_picture_required' => 'กรุณาเลือกรูปโปรไฟล์',
    'profile_too_large' => 'ไฟล์ใหญ่เกิน 10MB',
    'upload_and_login' => 'อัปโหลดและเข้าสู่ระบบ',

    // Forgot password modal (FP)
    'fp_modal_title' => 'ลืมรหัสผ่าน',
    'fp_modal_hint' => 'กรอกรหัสพนักงานและเลขบัตรประชาชนให้ถูกต้อง แล้วตั้งรหัสผ่านใหม่',
    'fp_employee_code_placeholder' => 'เช่น 12345',
    'fp_citizen_id_label' => 'เลขบัตรประชาชน (13 หลัก)',
    'fp_citizen_id_placeholder' => 'xxxxxxxxxxxxx',

    'fp_verify' => 'ตรวจสอบ',
    'fp_verifying' => 'กำลังตรวจสอบ...',
    'fp_new_password' => 'รหัสผ่านใหม่',
    'fp_new_password_placeholder' => 'อย่างน้อย 8 ตัวอักษร',
    'fp_confirm_password' => 'ยืนยันรหัสผ่านใหม่',
    'fp_confirm_password_placeholder' => 'พิมพ์ซ้ำอีกครั้ง',
    'fp_save_new_password' => 'บันทึกรหัสผ่านใหม่',
    'fp_saving' => 'กำลังบันทึก...',
    'fp_back' => 'ย้อนกลับ',
    'fp_close' => 'ปิด',
    

    // FP errors/success (JS defaults)
    'fp_err_employee_required' => 'กรุณากรอกรหัสพนักงาน',
    'fp_err_citizen_required' => 'กรุณากรอกเลขบัตรประชาชน',
    'fp_err_citizen_invalid' => 'กรุณากรอกเลขบัตรประชาชน 13 หลักให้ถูกต้อง',
    'fp_err_verify_failed' => 'ตรวจสอบไม่สำเร็จ',
    'fp_err_general' => 'เกิดข้อผิดพลาด กรุณาลองใหม่',
    'fp_err_session_invalid' => 'Session ตรวจสอบไม่ถูกต้อง กรุณากดตรวจสอบใหม่',
    'fp_err_pwd_min' => 'รหัสผ่านใหม่ต้องมีอย่างน้อย 8 ตัวอักษร',
    'fp_err_pwd_mismatch' => 'การยืนยันรหัสผ่านใหม่ไม่ตรงกัน',
    'fp_success' => 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',

    // Basic buttons (ensure exist)
    'cancel' => 'ยกเลิก',
    'ok' => 'ตกลง',
    'alert_title' => 'แจ้งเตือน',
'assess_saved_success' => 'บันทึกคะแนนสำเร็จ',
    
];


