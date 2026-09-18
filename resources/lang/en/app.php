<?php

return [

    // ===== Basic / Branding =====
    'site_title'            => 'Login • Supavut Assessment',
    'brand'                 => 'Supavut Assessment',
    'system_badge'          => 'Annual Evaluation',
    'login_subtitle'        => 'Sign in to start your review',

    // ===== Theme =====
    'theme_dark'            => 'Dark mode',           // ใช้กับหน้า login เดิม
    'theme_mode_dark'       => 'Dark mode',           // ใช้กับหน้า OTP (สวิตช์)
    'theme_mode_light'      => 'Light mode',

    // ===== Language switcher =====
    'lang_switcher_aria'    => 'Language switcher',
    'lang_th'               => 'TH',
    'lang_en'               => 'EN',

    // ===== Generic Dialog / Buttons =====
    'ok'                    => 'OK',
    'cancel'                => 'Cancel',
    'alert_title'           => 'Notification',

    // ===== Login =====
    'login_failed'              => 'Login failed',
    'auth_invalid_credentials'  => 'Employee ID or password is incorrect.',
    'employee_id'               => 'Employee ID',
    'employee_placeholder'      => 'e.g. 23001',
    'password'                  => 'Password',
    'password_placeholder'      => 'Enter your password',
    'password_short'            => 'At least 8 characters',
    'password_confirm'          => 'Confirm password',
    'password_confirm_short'    => 'Re-enter password',

    'forgot_password'       => 'Forgot password?',
    'login_button'          => 'Sign in',
    'no_account'            => 'No account?',
    'signup_button'         => 'Register',

    // ปุ่มกลับหน้าโปรไฟล์
    'back_to_profile'       => 'Back to profile',

    // ===== Register Modal =====
    'register_title'        => 'Register',
    'email'                 => 'Email',
    'email_placeholder'     => 'your.name@supavut.com',

    'profile_picture'       => 'Profile picture',
    'profile_hint'          => 'Image up to 10 MB',
    'profile_too_large'     => 'Image file is larger than 10 MB',

    'register_submit'       => 'Create account',

    // ===== Small alerts / helper text (Login + Register) =====
    'check'                     => 'Check',
    'alert_employee_required'   => 'Please enter employee ID',
    'alert_email_required'      => 'Please enter email before requesting OTP',
    'employee_demo_prefix'      => 'Demo employee info for ID',
    'otp_demo_prefix'           => 'Demo: OTP will be sent to',

    // ข้อความแจ้งเตือนลงทะเบียนซ้ำ
    'email_already_registered'     => 'This email has already been registered.',
    'employee_already_registered'  => 'This employee ID has already been registered.',

    // ===== OTP basic label (ใช้ใน login เมื่อต้องโชว์ modal error OTP) =====
    'otp'                   => 'OTP code',

    // ===== OTP Page (Email verification) =====
    'otp_title'               => 'Verify email with OTP',
    'otp_heading'             => 'Verify your email',
    'otp_description'         => 'We have sent an OTP code to your email.<br>Please enter the code correctly within 15 minutes.',

    'otp_confirm'             => 'Confirm OTP',
    'otp_resend'              => 'Resend OTP',
    'otp_resend_hint'         => 'You can request a new code again in :seconds seconds.',
    'resend_cooldown_seconds' => 60,
    'otp_inputs_aria'         => '6-character verification code input boxes',
    'otp_digit'               => 'Digit :n',
    'otp_footer_note'         => '© :year Supavut Assessment • Annual Evaluation System',
    'otp_context_assessment'  => 'Assessment Portal • Secure Access',

    // ===== Offline / Network =====
    'offline_alert'           => 'You are offline. Please check your internet connection.',

    // ===== Profile (Supavut Assessment) =====
    'profile_title'                   => 'Supavut Assessment • Profile',
    'profile_brand'                   => 'Supavut Assessment',
    'profile_subtitle'                => 'User profile overview for the annual assessment system',
    'profile_dark_mode'               => 'Dark mode',

    'profile_employee_info_title'     => 'Information',
    'profile_employee_info_hint'      => 'Detailed data will be loaded from Excel later',
    'profile_employee_code_label'     => 'Employee ID:',
    'profile_employee_code'           => 'Employee ID',
    'profile_first_name'              => 'First name',
    'profile_last_name'               => 'Last name',
    'profile_position'                => 'Position',
    'profile_department'              => 'Department',
    'profile_unknown'                 => 'N/A',
    'profile_fallback_name'           => 'User',

    'profile_role_admin'              => 'Administrator',
    'profile_role_user'               => 'Employee',

    'profile_button_assessment'       => 'Assessment',
    'profile_button_edit'             => 'Edit profile',
    'profile_button_upload_excel'     => 'Create Employee',
    'profile_button_logout'           => 'Logout',

    'profile_footer'                  => 'Annual assessment',

    'profile_view_employee_button'    => 'View details',
    'profile_view_employee_modal_title' => 'Employee information',

        // ===== Profile / Security (EN) =====
    'edit_profile_title' => 'Account security settings',
    'edit_profile_subtitle' => 'Update your email and password to keep your account safe and up to date.',
    'profile_dark_mode' => 'Dark mode',
    'security_section' => 'Security',

    'email_label' => 'Login email',
    'edit_email_hint' => 'You can change the email used to sign in and receive notifications here.',
    'email_change_note' => 'Please use a valid email address. The system may send notifications to this email.',

    'current_password_for_email' => 'Current password (to confirm email change)',
    'current_password_for_email_hint' => 'To protect your account, we require your current password before changing the email address.',

    'security_note_change_password_on_profile' => 'For security, please enter your current password before setting a new one.',
    'current_password' => 'Current password',
    'new_password' => 'New password',
    'new_password_confirmation' => 'Confirm new password',
    'password_hint' => 'Use a strong password with letters, numbers, and symbols, at least 8 characters long.',

    'save_email' => 'Save email',
    'save_password' => 'Save new password',

    // ===== Employee Import (Supavut Assessment) =====
'emp_import_title'          => 'Import Excel (Employees)',
'emp_import_subtitle'       => 'Upload or update employee data from an Excel file.',
'emp_import_admin_only'     => 'Admin only',
'emp_import_error_title'    => 'Please check the following issues',

'emp_import_file_label'     => 'Choose Excel file',
'emp_import_file_help'      => 'Supported files: <strong>.xlsx, .xls, .csv</strong>. Include headers like employee code, name, department, position.',

'emp_import_mode_title'     => 'Import mode',
'emp_import_mode_append'    => 'Append new rows from this file to existing data (Append).',
'emp_import_mode_replace'   => 'Clear existing data and replace with rows from this file (Replace).',

'emp_import_btn_append'     => 'Append import',
'emp_import_btn_replace'    => 'Replace all',
'emp_import_btn_back'       => 'Back to profile',
'emp_import_confirm_replace'=> 'Are you sure you want to replace all employee records with this file?',

'emp_import_footer'         => 'Supavut Assessment • Employee Excel Import',
    // ===== Employee Import – Success =====
    'emp_import_success_append'  => 'Employee data has been imported and appended to the existing records successfully.',
    'emp_import_success_replace' => 'Employee data has been imported and all previous records have been replaced successfully.',
// ===== Employee Lookup / Register =====
    'emp_lookup_hint'                 => 'Please enter your employee ID and click "Check" before filling in the fields below.',
    'emp_lookup_error_code_required'  => 'Please enter your employee ID first.',
    'emp_lookup_error_not_found'      => 'Employee ID not found in the system. Please check again or contact HR.',
    'emp_lookup_error_general'        => 'Unable to verify employee data at the moment. Please try again later.',
    'checking'                        => 'Checking...',
    'emp_register_email_hint'         => 'After registering and logging in, an OTP will be sent to this email for identity verification.',

    // ===== Forgot Password =====
    'forgot_password_helper' => 'Please enter your employee ID and email that match our records.',
    'employee_code_label' => 'Employee ID',
    'employee_code_placeholder' => 'e.g. 12345',
    'email_bound_label' => 'Email linked to your account',
    'email_placeholder_example' => 'e.g. employee@supavut.co.th',
    'forgot_password_send_link_button' => 'Send password reset link',
    'back_to_login' => 'Back to login',
// ===== Forgot Password =====
    'forgot_password'                   => 'Forgot password',
    'forgot_password_helper'            => 'Please enter your employee ID and email that match our records.',
    'employee_code_label'               => 'Employee ID',
    'employee_code_placeholder'         => 'e.g. 12345',
    'email_bound_label'                 => 'Email linked to your account',
    'email_placeholder_example'         => 'e.g. employee@supavut.co.th',
    'forgot_password_send_link_button'  => 'Send password reset link',

    // Back to login button (shared)
    'back_to_login'                     => 'Back to login',

    // ===== Reset Password =====
    'reset_password_title'              => 'Set a new password',
    'reset_password_subtitle'           => 'Please create a new password for your account.',
    'reset_password_new_label'          => 'New password',
    'reset_password_confirm_label'      => 'Confirm new password',
    'reset_password_submit_button'      => 'Save new password',

    // Email subject for reset link
    'reset_email_subject'               => 'Password reset link • Supavut Assessment',
    'reset_password_same_old_warning' => 'You cannot reuse your previous password. Please choose a different password.',
 // Profile buttons (assessment)
    'profile_button_assessment_self'       => 'Self-evaluation',
    'profile_button_assessment_employees'  => 'Evaluate employees',
    'profile_button_view_evaluations'      => 'View summary',

// ===== Assessment: Employees list =====
'assess_employees_page_title'        => 'Employees under your supervision',
'assess_employees_page_subtitle'     => 'List of employees where you are the supervisor',
'assess_employees_total_chip'        => 'Total :count employees',
'assess_employees_legend_pending'    => 'Pending',
'assess_employees_legend_done'       => 'Completed',
'assess_employees_back_profile'      => 'Back to profile',

'assess_employees_table_no'          => 'No.',
'assess_employees_table_code'        => 'ID',
'assess_employees_table_name'        => 'Full name',
'assess_employees_table_type'        => 'Type',
'assess_employees_table_position'    => 'Position',
'assess_employees_table_department'  => 'Department',
'assess_employees_table_status'      => 'Evaluation status',
'assess_employees_table_action'      => 'Evaluate',

'assess_employees_empty'             => 'There are no employees under your supervision yet.',

'assess_employees_status_done'       => 'Evaluation completed',
'assess_employees_status_pending'    => 'Waiting for evaluation',

'assess_employees_button_evaluate'   => 'Evaluate',

'assess_employees_hover_code'        => 'Employee ID: :code',
'assess_employees_hover_position'    => 'Position: :position',
'assess_employees_hover_department'  => 'Department: :department',

    // ===== Assessment – Employees list =====
    'assess_employees_page_title'        => 'Employees to be evaluated',
    'assess_employees_page_subtitle'     => 'Select employees you are responsible for and fill in their evaluations.',
    'assess_employees_total_chip'        => 'Total :count employees',
    'assess_employees_legend_pending'    => 'Pending',
    'assess_employees_legend_done'       => 'Completed',
    'assess_employees_empty'             => 'There are currently no employees assigned for your evaluation.',

    'assess_employees_table_no'          => 'No.',
    'assess_employees_table_code'        => 'Code',
    'assess_employees_table_name'        => 'Name',
    'assess_employees_table_type'        => 'Employee type',
    'assess_employees_table_position'    => 'Position',
    'assess_employees_table_department'  => 'Department',
    'assess_employees_table_status'      => 'Evaluation status',
    'assess_employees_table_action'      => 'Action',

    'assess_employees_status_done'       => 'Evaluated',
    'assess_employees_status_pending'    => 'Pending',

    'assess_employees_button_evaluate'   => 'Evaluate',
    'assess_employees_back_profile'      => 'Back to profile',

    'assess_employees_hover_code'        => 'Employee ID: :code',
    'assess_employees_hover_position'    => 'Position: :position',
    'assess_employees_hover_department'  => 'Department: :department',

    // ===== Assessment – Individual form (evaluate.blade.php) =====
    'assess_form_title'                  => 'Evaluation form for :name',
    'assess_form_title_short'            => 'Employee evaluation form',
    'assess_form_subtitle'               => 'This page is a skeleton for evaluating this employee. Real items and scoring logic will be added later.',

    'assess_form_role_placeholder'       => 'Evaluator role (SUP / DIV / DEPT / PLANT will be specified later)',
    'assess_form_status_draft'           => 'Status: Draft – evaluation not submitted yet',

    'assess_form_section_main'           => 'Main evaluation items',
    'assess_form_section_main_desc'      => 'This area will contain core items such as performance, responsibility, discipline, etc.',
    'assess_form_placeholder_fields'     => 'PLACEHOLDER: Input fields and scoring logic will be added later.',

    'assess_form_section_competency'     => 'Behaviour & competency',
    'assess_form_section_competency_desc'=> 'This area will be used for competency / soft-skill evaluation.',
    'assess_form_placeholder_competency' => 'PLACEHOLDER: Fields for behaviour, teamwork, communication, etc.',

    'assess_form_section_comment'        => 'Additional comments / summary',
    'assess_form_section_comment_desc'   => 'A real comment box will be added here to store feedback in the database.',
    'assess_form_placeholder_comment'    => 'PLACEHOLDER: Comment and development suggestion fields.',

    'assess_form_back_list'              => 'Back to employees list',
    'assess_form_save_draft'             => 'Save as draft (not active yet)',
    'assess_form_submit'                 => 'Submit evaluation (not connected yet)',

        // ===== Assessment Overview (Summary) =====
    'assess_overview_title' => 'Assessment overview for :name',
    'assess_overview_title_short' => 'Assessment overview (team structure)',
    'assess_overview_subtitle' => 'This page shows the employees in your reporting line (Dept / Plant) and will be used to attach evaluation results later.',

    'assess_overview_scope_plant' => 'Plant level (Plant Manager)',
    'assess_overview_scope_dept'  => 'Department level (Department Manager)',

    'assess_overview_stat_branch'      => 'Employees in your line',
    'assess_overview_stat_supervisors' => 'Number of Supervisors',
    'assess_overview_stat_divmgr'      => 'Number of Division Managers',
    'assess_overview_stat_staff'       => 'General staff (subordinates)',

    'assess_overview_section_leaders'      => 'Leaders in your reporting line',
    'assess_overview_section_leaders_desc' => 'Supervisors and Division Managers under your responsibility (same department / plant).',
    'assess_overview_no_leaders'           => 'No leader data found in your line.',

    'assess_overview_supervisors_title' => 'Supervisors in your line',
    'assess_overview_divmgr_title'      => 'Division Managers in your line',

    'assess_overview_col_name'     => 'Full name',
    'assess_overview_col_dept'     => 'Department',
    'assess_overview_col_empcode'  => 'Employee code',
    'assess_overview_col_position' => 'Position',
    'assess_overview_col_role'     => 'Role in line',

    'assess_overview_no_supervisors' => 'No supervisors in this line.',
    'assess_overview_no_divmgr'      => 'No division managers in this line.',

    'assess_overview_section_subordinates'      => 'Subordinates in your line (grouped by Supervisor)',
    'assess_overview_section_subordinates_desc' => 'General staff in your reporting line, grouped by each SUP (for viewing evaluation results later).',
    'assess_overview_no_subordinates'          => 'No subordinate data in your line.',

    'assess_overview_people' => 'people',
    'assess_overview_no_staff_under_sup' => 'No staff under this supervisor.',

    'assess_overview_section_all'      => 'All employees in your reporting line',
    'assess_overview_section_all_desc' => 'A combined list of employees in your line (SUP / DIV / STAFF) to be linked with evaluation scores later.',

    'assess_overview_back_profile' => 'Back to profile',

 // ===== Assessment: Employees list =====
    'assess_employees_supervisor_subtitle' =>
        'Employees you directly supervise (:count items)',

    'assess_employees_division_subtitle' =>
        'Employees where you are Division Manager (:count items)',

    //แปลประเมิน
        // ===== Assessment: Evaluate page =====
    'assess_eval_title' => 'Assessment • :code',
    'assess_eval_header_title' => 'Performance summary',
    'assess_eval_header_subtitle' => 'Employee :name (:code)',
    'assess_lang_switch_label' => 'Language',
    'assess_theme_toggle_label' => 'Toggle light / dark theme',

    'assess_avatar_tooltip' => 'Click to view large profile photo',
    'assess_emp_meta' => 'ID :code • Position :position • Dept :dept',

    'assess_level_operator'   => 'Level 1 • Operator group',
    'assess_level_staff'      => 'Level 2 • Staff group',
    'assess_level_supervisor' => 'Level 3 • Supervisor group',
    'assess_level_manager'    => 'Level 4 • Manager / Assist MGR',
    'assess_level_gm'         => 'Level 5 • GM / DGM',

    'assess_weight_title' => 'Weight structure',
    'assess_weight_attendance' => 'Attendance',
    'assess_weight_individual' => 'Individual performance',
    'assess_weight_dept_okr' => 'Department OKR',
    'assess_weight_company_okr' => 'Company OKR',
    'assess_weight_okr_reporting' => 'OKR reporting',
    'assess_weight_system' => 'System (SMBR)',
    'assess_weight_bonus' => 'Bonus',
    'assess_weight_not_defined' => 'Weight has not been defined yet.',
    // ใช้คะแนนเต็มรวม (รวมโบนัส) แสดงแบบสั้น ๆ
    'assess_weight_total_line' => 'Total :points pts',

    'assess_att_title' => 'Attendance score',
    'assess_att_sub' => 'Calculated from raw score :raw / :base × :weight (weight)<br>Result is :weighted points',

    'assess_btn_view_detail' => 'View details',

    'assess_ip_title' => 'Individual performance score',
    'assess_ip_missing_la_badge' => 'Please fill Leadership and Attitude / Discipline scores.',
    'assess_ip_summary_text' =>
        "Total of 7 topics = :sum / :full (:percent%)\n".
        "(:sum / :full) × :weight = :weighted",
    'assess_ip_empty_main' =>
        'No Individual Performance score has been recorded for this level yet.'."\n".
        '(Weight :weight% of total score)',
    'assess_ip_warning_missing_main' =>
        'Please fill Leadership and Attitude / Discipline before summarizing.',

    'assess_okr_dept_title' => 'Department level OKR score',
    'assess_okr_dept_sub' =>
        'Department OKR score: :score / 10'."\n".
        '(:score / 10) × :weight = :weighted',

    'assess_okr_company_title' => 'Company level OKR score',
    'assess_okr_company_sub' =>
        'Company level OKR score: :score / 10'."\n".
        '(:score / 10) × :weight = :weighted',

    'assess_okr_reporting_title' => 'OKR - Reporting score',
    'assess_okr_reporting_sub' =>
        'OKR - Reporting score: :score / 10'."\n".
        '(:score / 10) × :weight = :weighted',

    'assess_system_title' => 'System (SMBR)',
    'assess_system_sub' =>
        'System (SMBR) score: :score / 5'."\n".
        '(:score / 10) × :weight = :weighted',

    'assess_bonus_title' => 'Bonus score',
    'assess_bonus_sub' => 'Bonus score from special conditions (max :max points)',

    'assess_total_title' => 'Overall score (including bonus)',
    // ย่อข้อความรวมคะแนนให้สั้น: Base + Bonus = Total / Max
    // ===== Assessment: Total summary =====
'assess_total_sub_text' => 'Total score is :base / :max + Bonus :bonus, giving a final total of :total.',
'assess_total_sub_template' => 'Total score is {base} / {max} + Bonus {bonus}, giving a final total of {total}.',


    'assess_grade_prefix' => 'Grade',
    'assess_grade_a' => 'Outstanding',
    'assess_grade_b' => 'Exceeds expectation',
    'assess_grade_c' => 'Meets expectation',
    'assess_grade_d' => 'Below expectation',
    'assess_grade_f' => 'Needs improvement',
    'assess_grade_c_warning' => 'Meets expectation (Warning)',
    'assess_grade_d_suspension' => 'Below expectation (Suspension)',

    'assess_btn_back_to_list' => '← Back to employees list',
    'assess_btn_save_total' => 'Save total score',

    'assess_att_modal_title' => 'Attendance details',
    'assess_att_modal_intro' => 'Attendance score breakdown (absence, sick, personal, late, etc.).',

    'assess_att_col_type' => 'Type',
    'assess_att_col_count' => 'Count',
    'assess_att_col_each' => 'Deduct per event',
    'assess_att_col_total' => 'Total deduction',

    'assess_att_row_absent' => 'Absence',
    'assess_att_row_sick' => 'Sick leave',
    'assess_att_row_personal' => 'Personal leave',
    'assess_att_row_late' => 'Late',
    'assess_att_row_maternity' => 'Maternity leave (days)',
    'assess_att_row_ordain' => 'Ordination leave (days)',
    'assess_att_row_warning' => 'Warning letters (times)',
    'assess_att_row_suspension' => 'Suspension (times)',

    'assess_att_footer_deduct' => 'Total deduction (only absence / sick / personal / late)',
    'assess_att_footer_remaining' => 'Remaining attendance score',

    'assess_att_formula_text' =>
        'Formula: (score after deduction / full score) × attendance weight'."\n".
        '(:raw / :base) × :weight = :weighted',

    'assess_ip_modal_title' => 'Individual performance details',
    'assess_ip_modal_empty' => 'No Individual Performance score has been recorded yet.',
    'assess_ip_modal_warning' =>
        'Please fill Leadership and Attitude / Discipline and press "Calculate score".',
    // ย่อข้อความอธิบายปุ่มคำนวณให้สั้น
    'assess_ip_modal_calc_note' =>
        '*Press "Calculate score" to preview new score from Leadership + Attitude.',

    'assess_ip_section_heading' => 'Individual Performance topics',
    'assess_ip_section_sub' => 'Each topic full score = 10 • Tap ℹ to see criteria.',

    'assess_table_topic' => 'Topic',
    'assess_table_criteria' => 'Criteria',
    'assess_table_score' => 'Score (0–10)',

    'assess_ip_topic_teamwork' => 'Teamwork (Asakai Meeting)',
    'assess_ip_topic_comm' => 'Communication (Red Alert Meeting)',
    'assess_ip_topic_leader' => 'Leadership',
    'assess_ip_topic_attitude' => 'Attitude / Discipline',
    'assess_ip_topic_planning' => 'Planning / Proactivity (Kaizen)',
    'assess_ip_topic_owner' => 'Ownership / Responsibility',
    'assess_ip_topic_problem' => 'Problem Solving (QCC)',

    'assess_ip_asakai_line' =>
        'Asakai: :percent% • Current score :score/10',
    'assess_ip_redalert_line' =>
        'Red Alert: :percent%',

    'assess_criteria_btn_title' => 'Rating criteria',
    'assess_criteria_modal_title' => 'Rating criteria',

    'assess_ip_record_title' => 'Record scores (Supervisor / Division)',
    // ย่อขั้นตอนกรอกคะแนนให้สั้น
    'assess_ip_record_sub' =>
        'Assess the employee’s scores for each of the following items. *Note: After entering the scores, click “Calculate” for the system to compute the result.',

    'assess_ip_leadership_label' => 'Leadership',
    'assess_ip_attitude_label' => 'Attitude / Discipline',
    'assess_ip_selected_score' => 'Selected score:',
    'assess_ip_rating_overall_label' => 'Please specify your score:',

    'assess_ip_leadership_numeric_label' => 'Rate Leadership (0–10)',
    'assess_ip_attitude_numeric_label' => 'Rate Attitude / Discipline (0–10)',

    'assess_likert_always' => 'Almost always',
    'assess_likert_sometimes' => 'Sometimes',
    'assess_likert_seldom' => 'Seldom',
    'assess_likert_almost_never' => 'Almost never',
    'assess_likert_never' => 'Never',

    'assess_btn_calc' => 'Calculate score',
    'assess_btn_apply' => 'Apply score',

    'assess_criteria_teamwork_title' => 'Teamwork – Asakai',
    'assess_criteria_teamwork_intro' => 'The evaluation of scores from participation in Asakai meetings is as follows',
    'assess_criteria_teamwork_li1' => '10 pts ≥ 95%',
    'assess_criteria_teamwork_li2' => '7 pts 85–94%',
    'assess_criteria_teamwork_li3' => '4 pts 75–84%',
    'assess_criteria_teamwork_li4' => '1 pt ≤ 74%',
    'assess_criteria_teamwork_current' =>
        'Current score: :score / 10 (Asakai :percent%)',

    'assess_criteria_comm_title' => 'Communication – Red Alert',
    'assess_criteria_comm_intro' => 'The evaluation of scores from participation in Red Alert meetings is as follows',
    'assess_criteria_comm_li1' => '10 pts ≥ 95%',
    'assess_criteria_comm_li2' => '7 pts 85–94%',
    'assess_criteria_comm_li3' => '4 pts 75–84%',
    'assess_criteria_comm_li4' => '1 pt ≤ 74%',

    'assess_criteria_leader_title' => 'Leadership',
    'assess_criteria_leader_intro' => 'Score evaluation by the supervisor',
    'assess_criteria_leader_li1' => '10–8 = Almost always',
    'assess_criteria_leader_li2' => '7–5 = Often',
    'assess_criteria_leader_li3' => '4–2 = Sometimes',
    'assess_criteria_leader_li4' => '1 = Rarely',
    'assess_criteria_leader_li5' => '0 = Never',

    'assess_criteria_attitude_title' => 'Attitude / Discipline',
    'assess_criteria_attitude_intro' => 'Score evaluation by the supervisor',
    'assess_criteria_attitude_li1' => '10–8 = Almost always',
    'assess_criteria_attitude_li2' => '7–5 = Often',
    'assess_criteria_attitude_li3' => '4–2 = Sometimes',
    'assess_criteria_attitude_li4' => '1 = Rarely',
    'assess_criteria_attitude_li5' => '0 = Never',

    'assess_criteria_planning_title' => 'Planning / Proactivity Criteria',
'assess_criteria_planning_intro' => 'Score evaluation based on participation in Kaizen activities',
'assess_criteria_planning_li1'   => '10 points = Winning department',
'assess_criteria_planning_li2'   => '7 points = Department in top 10 teams',
'assess_criteria_planning_li3'   => '4 points = Department submitted entries on time.',
'assess_criteria_planning_li4'   => '1 point = Department that joined but submitted late',

    'assess_criteria_owner_title' => 'Ownership / Responsibility Criteria',
'assess_criteria_owner_intro' => 'Score evaluation based on participation in the company quality systems',
'assess_criteria_owner_li1'   => '10 points = CAR closed on due date, actions expanded to related processes and 100% implemented',
'assess_criteria_owner_li2'   => '7 points = CAR closed on due date, actions expanded to related processes but implementation is not 100%',
'assess_criteria_owner_li3'   => '4 points = CAR closed after due date, actions still expanded to related processes',
'assess_criteria_owner_li4'   => '1 point = CAR closed but actions are not expanded to related processes. <br>*Note: If a department has no CAR, 10 points can be given when data and evidence show 100% compliance in relevant system audits.',


   'assess_criteria_problem_title' => 'Problem Solving Criteria',
'assess_criteria_problem_intro' => 'Score evaluation based on participation in QCC activities',
'assess_criteria_problem_li1'   => '10 points = Department whose QCC team wins the championship',
'assess_criteria_problem_li2'   => '7 points = Department whose QCC team reaches the top 10 finalists',
'assess_criteria_problem_li3'   => '4 points = Department that submits QCC activities on time',
'assess_criteria_problem_li4'   => '1 point = Department that submits QCC activities late',

    'assess_btn_close' => 'Close',

    // Template สำหรับ JS (ย่อแล้วแต่ยังเข้าใจง่าย)
    'assess_ip_modal_template' =>
        'Total {sum} / {full} ({percent}%) • Weight {weight}% → {weighted}',
    'assess_ip_summary_template' =>
        'Total {sum} / {full} ({percent}%) → {weighted} / {weight}',

    'assess_ip_alert_missing_la' => 'Please set both Leadership and Attitude / Discipline scores first.',
    'assess_ip_alert_need_calc' => 'Please press "Calculate score" before applying.',

    // ปุ่ม + Modal เกณฑ์ Grade รวม
    'assess_grade_info_btn_title' => 'View grade rules',
    'assess_grade_modal_title' => 'Grade rules',
    'assess_grade_modal_intro' => 'Final grade is based on total score (before warning / suspension rules).',
    'assess_grade_modal_li_a' => 'A : ≥ 95 points',
    'assess_grade_modal_li_b' => 'B : 85–94 points',
    'assess_grade_modal_li_c' => 'C : 75–84 points',
    'assess_grade_modal_li_d' => 'D : 60–74 points',
    'assess_grade_modal_li_f' => 'F : < 60 points',
    'assess_grade_modal_special' => 'Special cases (override score):',
    'assess_grade_modal_special_c' => 'At least 1 warning letter → minimum grade = C.',
    'assess_grade_modal_special_d' => 'At least 1 suspension → minimum grade = D.',


    //ปุ่มเกณฑ์
    // ===== Assessment: Dept / Company OKR / System / Bonus criteria (EN) =====
'assess_criteria_dept_okr_title' => 'Department OKR',
'assess_criteria_dept_okr_intro' => 'Department OKR criteria',
'assess_criteria_dept_okr_li1'   => '10 points = Department OKR score ≥ 110',
'assess_criteria_dept_okr_li2'   => '9 points = Department OKR score ≥ 100 and < 110',
'assess_criteria_dept_okr_li3'   => '8 points = Department OKR score ≥ 90 and < 100',
'assess_criteria_dept_okr_li4'   => '7 points = Department OKR score ≥ 80 and < 90',
'assess_criteria_dept_okr_li5'   => '6 points = Department OKR score ≥ 70 and < 80',
'assess_criteria_dept_okr_li6'   => '5 points = Department OKR score < 70',

'assess_criteria_company_okr_title' => 'Company OKR',
'assess_criteria_company_okr_intro' => 'The Company-level OKR score is the sum of all Department-level OKR scores.',

'assess_criteria_okr_reporting_title' => 'OKR Reporting',
'assess_criteria_okr_reporting_intro' => 'The OKR-Reporting score is the average of the monthly OKR-Reporting scores.',

'assess_criteria_system_title' => 'System (SMBR)',
'assess_criteria_system_intro' => 'System (SMBR) scoring criteria',
'assess_criteria_system_li1'   => '5 = Excellent',
'assess_criteria_system_li2'   => '4 = Good',
'assess_criteria_system_li3'   => '3 = Fair',
'assess_criteria_system_li4'   => '2 = Acceptable',
'assess_criteria_system_li5'   => '≤ 1 = Needs improvement',

'assess_criteria_bonus_title' => 'Bonus score',
'assess_criteria_bonus_intro' => 'Bonus score is considered based on the following criteria:',
'assess_criteria_bonus_li1'   => 'Points from winning internal or external activities.',
'assess_criteria_bonus_li2'   => 'Points from cost reduction that exceeds expectations, including other initiatives that outperform targets.',
'assess_criteria_bonus_li3'   => 'Points from enhancing the reputation of the company.',
'assess_criteria_bonus_li4'   => 'Points from achieving all assigned OKR items.',
'assess_criteria_bonus_li5'   => 'Points from maintaining customer claim cases at zero.',
'assess_criteria_bonus_li6'   => 'Points from participating as a committee member in internal system audit teams.',
'assess_weight_total_line' => 'Total :points points',
    'assess_already_done_title' => 'You have already evaluated this employee.',
'assess_already_done_sub'   => 'Saved result for year :year, period :period is :score points (grade :grade).',
'assess_confirm_save_title' => 'Confirm saving total score',
'assess_confirm_save_body'  => 'Do you want to save the total evaluation score for this employee? After saving, you will not be able to submit it again.',
// ===== Assessment • Employees list =====
'assess_employees_table_score'  => 'Final score',
'assess_employees_table_grade'  => 'Grade',

'assess_employees_status_pending' => 'Pending evaluation',
'assess_employees_status_done'    => 'Evaluated',

         // ===== Theme toggle =====
    'theme_toggle_dark' => 'Dark mode',

    // ===== Employee Import page =====
    'emp_import_btn_download_export'   => 'Download Excel assessment summary',
    'emp_import_btn_preview_employee'  => 'Review imported data',
    'emp_import_file_multi_hint'       => 'You can select more than one file at a time (e.g. Attendance + Individual + OKR + Bonus).',
    'emp_import_file_selected_label'   => 'Selected files',

    // ===== Employee modal (employees table) =====
    'emp_modal_title_employees'      => 'Employees table data (all)',
    'emp_modal_summary_employees'    => 'Found :total employees in total',
    'emp_modal_empty_employees'      => 'There is no employee data in the employees table to display yet',
    'emp_modal_zoom_in'              => 'Zoom in',
    'emp_modal_zoom_out'             => 'Zoom out',

    // ===== ExportEmployee modal =====
    'export_emp_modal_summary'   => 'Found :total employees in total',
    'export_emp_modal_empty'     => 'There is no data in the export_employees table to display yet',
    'export_emp_modal_zoom_in'   => 'Zoom in',
    'export_emp_modal_zoom_out'  => 'Zoom out',

    // ===== Generic modal =====
    'modal_btn_close' => 'Close',

    // ===== Employee column headers (employees preview) =====
    'emp_modal_col_employee_code'       => 'Employee code',
    'emp_modal_col_full_name_th'        => 'Full name (TH)',
    'emp_modal_col_full_name_en'        => 'Full name (EN)',
    'emp_modal_col_employee_type'       => 'Employee type',
    'emp_modal_col_position'            => 'Position',
    'emp_modal_col_department'          => 'Department',
    'emp_modal_col_dept_abbr_qms'       => 'Dept. abbr (QMS)',
    'emp_modal_col_dept_abbr_hr'        => 'Dept. abbr (HR)',
    'emp_modal_col_sup_id'              => 'Supervisor code',
    'emp_modal_col_sup_name'            => 'Supervisor name',
    'emp_modal_col_div_id'              => 'Division code',
    'emp_modal_col_div_name'            => 'Division name',
    'emp_modal_col_dept_mgr_id'         => 'Dept. manager code',
    'emp_modal_col_dept_mgr_name'       => 'Dept. manager name',
    'emp_modal_col_plant_mgr_id'        => 'Plant manager code',
    'emp_modal_col_plant_mgr_name'      => 'Plant manager name',
    'emp_modal_col_calendar'            => 'Calendar',
    'emp_modal_col_birthday'            => 'Date of birth',
    'emp_modal_col_gender'              => 'Gender',
    'emp_modal_col_age'                 => 'Age',
    'emp_modal_col_seniority_years'     => 'Years of service (years)',
    'emp_modal_col_seniority_months'    => 'Years of service (months)',
    'emp_modal_col_foreign'             => 'Foreign national',

    'emp_modal_col_attendance_total'      => 'Attendance total score',
    'emp_modal_col_attendance_sick'       => 'Sick leave',
    'emp_modal_col_attendance_personal'   => 'Personal leave',
    'emp_modal_col_attendance_maternity'  => 'Maternity leave',
    'emp_modal_col_attendance_ordain'     => 'Ordination leave',
    'emp_modal_col_attendance_late'       => 'Late',
    'emp_modal_col_attendance_absent'     => 'Absent',
    'emp_modal_col_attendance_warning'    => 'Warning letter',
    'emp_modal_col_attendance_suspension' => 'Suspension',

    'emp_modal_col_score_teamwork'        => 'Teamwork',
    'emp_modal_col_score_communication'   => 'Communication',
    'emp_modal_col_score_leadership'      => 'Leadership',
    'emp_modal_col_score_attitude'        => 'Attitude / Discipline',
    'emp_modal_col_score_planning'        => 'Planning & Organization',
    'emp_modal_col_score_ownership'       => 'Ownership',
    'emp_modal_col_score_problem_solving' => 'Problem solving',
    'emp_modal_col_score_dept_okr'        => 'Dept. OKR',
    'emp_modal_col_score_company_okr'     => 'Company OKR',
    'emp_modal_col_score_okr_reporting'   => 'OKR reporting',
    'emp_modal_col_score_system_smbr'     => 'System / SMBR',
    'emp_modal_col_score_bonus'           => 'Bonus',

    'emp_modal_col_assessment_status' => 'Assessment status',
    'emp_modal_col_created_at'        => 'Created at',
    'emp_modal_col_updated_at'        => 'Last updated',

    // ===== ExportEmployee column headers =====
    'export_emp_col_employee_code'   => 'Employee code',
    'export_emp_col_full_name_th'    => 'Full name (TH)',
    'export_emp_col_full_name_en'    => 'Full name (EN)',
    'export_emp_col_position'        => 'Position',
    'export_emp_col_department'      => 'Department',
    'export_emp_col_position_level'  => 'Position level',
    'export_emp_col_email'           => 'Email',
    'export_emp_col_email_verified'  => 'Email verified',

    'export_emp_col_attendance_total'     => 'Attendance total score',
    'export_emp_col_individual_total'     => 'Individual total score',
    'export_emp_col_okr_dept_total'       => 'Dept. OKR total score',
    'export_emp_col_okr_company_total'    => 'Company OKR total score',
    'export_emp_col_system_total'         => 'System / SMBR total score',
    'export_emp_col_bonus_total'          => 'Bonus total score',

    'export_emp_col_attendance_sick'       => 'Sick leave',
    'export_emp_col_attendance_personal'   => 'Personal leave',
    'export_emp_col_attendance_maternity'  => 'Maternity leave',
    'export_emp_col_attendance_ordain'     => 'Ordination leave',
    'export_emp_col_attendance_late'       => 'Late',
    'export_emp_col_attendance_absent'     => 'Absent',
    'export_emp_col_attendance_warning'    => 'Warning letter',
    'export_emp_col_attendance_suspension' => 'Suspension',

    'export_emp_col_score_teamwork'        => 'Teamwork score',
    'export_emp_col_score_communication'   => 'Communication score',
    'export_emp_col_score_leadership'      => 'Leadership score',
    'export_emp_col_score_attitude'        => 'Attitude / Discipline score',
    'export_emp_col_score_planning'        => 'Planning & Organization score',
    'export_emp_col_score_ownership'       => 'Ownership score',
    'export_emp_col_score_problem_solving' => 'Problem solving score',
    'export_emp_col_score_dept_okr'        => 'Dept. OKR score',
    'export_emp_col_score_company_okr'     => 'Company OKR score',
    'export_emp_col_score_okr_reporting'   => 'OKR reporting score',
    'export_emp_col_score_system_smbr'     => 'System / SMBR score',
    'export_emp_col_score_bonus'           => 'Bonus score',

    'export_emp_col_supervisor_score_leadership' => 'Supervisor: Leadership score',
    'export_emp_col_supervisor_score_attitude'   => 'Supervisor: Attitude score',
    'export_emp_col_supervisor_final_score'      => 'Supervisor: Total score',
    'export_emp_col_supervisor_grade'           => 'Supervisor: Grade',
    'export_emp_col_supervisor_grade_text'      => 'Supervisor: Grade description',

    'export_emp_col_division_score_leadership' => 'Division: Leadership score',
    'export_emp_col_division_score_attitude'   => 'Division: Attitude score',
    'export_emp_col_division_final_score'      => 'Division: Total score',
    'export_emp_col_division_grade'           => 'Division: Grade',
    'export_emp_col_division_grade_text'      => 'Division: Grade description',

    'export_emp_col_sup_total'   => 'Supervisor overall score',
    'export_emp_col_sup_grade'   => 'Supervisor overall grade',
    'export_emp_col_div_total'   => 'Division overall score',
    'export_emp_col_div_grade'   => 'Division overall grade',
    'export_emp_col_final_score' => 'Final score',
    'export_emp_col_final_grade' => 'Final grade',

    'export_emp_col_assessment_status' => 'Assessment status',
    'export_emp_col_created_at'        => 'Created at',
    'export_emp_col_updated_at'        => 'Last updated',

    // ===== ExportEmployee modal title & button =====
    'export_emp_modal_title'          => 'Employee assessment summary (all)',
    'emp_import_btn_preview_export'   => 'View overall assessment summary',
'assess_employees_supervisor_title' => 'Evaluation by Supervisor',
'assess_employees_division_title'   => 'Evaluation by Division',
'assess_employees_empty_division'   => 'No employees to evaluate as Division yet.',
'assess_employees_empty_supervisor' => 'No employees to evaluate as Supervisor yet.',
'assess_saved_already' => 'You have already evaluated this employee.',

// Assessment Overview
'assess_overview_title' => 'Overview',
'assess_overview_header' => 'Employee Assessment Overview',
'assess_overview_path_dept' => 'Dept: Division → Supervisor → Employees',

'assess_overview_chip_all' => 'Total in line',
'assess_overview_chip_dept' => 'Dept Manager',
'assess_overview_chip_division' => 'Division Manager',
'assess_overview_chip_supervisor' => 'Supervisor',
'assess_overview_chip_employee' => 'Employees',

'assess_overview_section_plant' => 'Plant Manager',
'assess_overview_section_dept' => 'Dept Manager',
'assess_overview_section_division' => 'Division Manager',
'assess_overview_section_supervisor' => 'Supervisor',

'assess_overview_role_plant' => 'Plant Manager',
'assess_overview_role_dept' => 'Dept Manager',
'assess_overview_role_division' => 'Division Manager',
'assess_overview_role_supervisor' => 'Supervisor',

'assess_overview_you_here' => 'You are here',
'assess_overview_boss' => '(Supervisor)',

'assess_overview_no_team' => 'No team data found under you.',
'assess_overview_no_dept' => 'No Dept Manager found in your line.',
'assess_overview_no_division' => 'No Division under this Dept.',
'assess_overview_no_supervisor' => 'No Supervisor under this Division.',
'assess_overview_no_employee' => 'No employees under this Supervisor.',

'assess_overview_count_supervisor' => ':count Supervisor',
'assess_overview_count_people' => ':count people',
'assess_overview_count_division' => ':count Division',

'assess_overview_tt_profile' => 'Employee profile',
'assess_overview_tt_self' => 'Self assessment',
'assess_overview_tt_sup' => 'Assessed by Supervisor',
'assess_overview_tt_my_profile' => 'My profile',
'assess_overview_tt_my_self' => 'Self assessment',
'assess_overview_tt_row' => 'Code: :code | Position: :pos | Dept: :dept',

'assess_overview_theme_toggle' => 'Toggle dark/light theme',
'assess_overview_lang_toggle' => 'Change language',
'assess_overview_lang_th' => 'Thai',
'assess_overview_lang_en' => 'English',

'assess_overview_modal_title' => 'Employee details',
'assess_overview_modal_hint_photo' => '(Click photo to enlarge)',
'assess_overview_tab_profile' => 'Profile',
'assess_overview_tab_self' => 'Self assessment',
'assess_overview_tab_sup' => 'Supervisor assessment',

'assess_overview_k_name' => 'Name',
'assess_overview_k_code' => 'Code',
'assess_overview_k_position' => 'Position',
'assess_overview_k_department' => 'Department',

'assess_overview_k_self_total' => 'Total score',
'assess_overview_k_self_percent' => 'Total score (%)',
'assess_overview_self_full' => 'Full score 100%',
'assess_overview_self_none' => 'No self-assessment data for this employee yet.',
'assess_overview_self_has' => 'Self-assessment data available.',

'assess_overview_k_sup_lead' => 'Leadership score',
'assess_overview_k_sup_att' => 'Attitude score',
'assess_overview_k_sup_final' => 'Total score',
'assess_overview_k_sup_eval_code' => 'Evaluator code',
'assess_overview_k_sup_eval_name' => 'Evaluator name',
'assess_overview_k_sup_eval_time' => 'Evaluated at',
'assess_overview_sup_none' => 'No supervisor assessment data for this employee yet.',

'assess_overview_btn_close' => 'Close',
'assess_overview_photo_title' => 'Profile photo',
'assess_overview_alt_profile' => 'Profile photo',
'assess_overview_alt_profile_large' => 'Profile photo (large)',
'assess_back_profile' => 'Back to Profile',
'how_to_use_button' => 'How to use',



'guide_title' => 'How to use',
'guide_subtitle' => 'Choose a topic below to view screenshots and usage steps.',
'guide_hint' => "Note:\n- Each topic opens a modal to view related images\n- You can add images later for each topic",
'guide_back_to_welcome' => 'Back to Login',
'guide_swipe_hint' => 'Swipe left/right to view more images',
'guide_no_images_yet' => 'No images for this topic yet (you can add them later).',

'guide_btn_register_login' => 'Sign up & Login',
'guide_btn_forgot_password' => 'Forgot password',
'guide_btn_self_assessment' => 'Self assessment',
'guide_btn_employee_assessment' => 'Employee assessment',
'guide_btn_view_results' => 'View results',

'guide_modal_register_login_title' => 'Sign up & Login',
'guide_modal_register_login_desc' => 'Screenshots and steps for signing up and logging in',

'guide_modal_forgot_password_title' => 'Forgot password',
'guide_modal_forgot_password_desc' => 'Screenshots and steps for resetting your password',

'guide_modal_self_assessment_title' => 'Self assessment',
'guide_modal_self_assessment_desc' => 'Screenshots and steps for self assessment',

'guide_modal_employee_assessment_title' => 'Employee assessment',
'guide_modal_employee_assessment_desc' => 'Screenshots and steps for evaluating employees',

'guide_modal_results_title' => 'View results',
'guide_modal_results_desc' => 'Screenshots and steps for viewing results/overview',
'close' => 'Close',

//วิธีใช้ : สม้ครสมาชิก

'guide_title' => 'User Guide',
    'guide_subtitle' => 'Usage guide for employees',
    'guide_back_to_welcome' => 'Back to Home',
    'guide_image_alt' => 'Guide image',

    'guide_btn_register_login' => 'Register & Login',
    'guide_btn_forgot_password' => 'Forgot Password',
    'guide_btn_self_assessment' => 'Self Assessment',
    'guide_btn_employee_assessment' => 'Employee Assessment',
    'guide_btn_view_results' => 'View Results',

    'guide_modal_register_login_title' => 'Register & Login',
    'guide_modal_register_login_desc' => 'Employee registration steps',
    'guide_register_step1' => 'On the Supavut Assessment homepage, click “Register” to start creating your account.',
    'guide_register_step2' => 'Enter your employee ID and click “Verify” to confirm your employee status, then check that the displayed information is correct.',
    'guide_register_step3' => 'After verification, set your password, enter your email, and upload your profile photo. Then click “Confirm Registration”. (The profile photo must match the provided example only.)',
    'guide_register_step4' => 'Enter the OTP and click “Confirm OTP”. (The OTP will be sent to your registered email.)',
    'guide_register_step5' => 'Once verified successfully, your registration is complete.',

    'guide_modal_forgot_password_title' => 'Forgot Password',
    'guide_modal_forgot_password_desc' => 'Steps to request a password reset and set a new password',

    'guide_modal_self_assessment_title' => 'Self Assessment',
    'guide_modal_self_assessment_desc' => 'Steps to complete and save your self assessment',

    'guide_modal_employee_assessment_title' => 'Employee Assessment',
    'guide_modal_employee_assessment_desc' => 'Steps for evaluators to assess employees',

    'guide_modal_results_title' => 'View Results',
    'guide_modal_results_desc' => 'Steps to review assessment results and summaries',

     //วิธีใช้ : แก้ไขข้อมูลส่วนตัว
     'close' => 'Close',

'guide_btn_edit_profile' => 'Edit Personal Information',
'guide_modal_edit_profile_title' => 'Edit Personal Information',
'guide_modal_edit_profile_desc' => 'Instructions for updating your email address and password.',

'guide_edit_profile_step1' => 'Employees can update personal information by opening the “Profile” page and selecting “Edit Personal Information.”',
'guide_edit_profile_step2' => 'The system will navigate to the “Account Security Management” page, which is divided into two sections: “Change Email” and “Change Password.”',
'guide_edit_profile_step3' => 'Change Email: Enter the new email address in the “Email” field, then enter your password to confirm your identity, and select “Save Email” to confirm the change.',
'guide_edit_profile_step4' => 'Change Password: Enter your current password to confirm your identity, then enter a new password. When finished, select “Save New Password” to confirm the change.',


'guide_group_account' => 'Account',
'guide_group_account_desc' => 'Register • Sign in • Edit profile • Forgot password',

'guide_group_assessment' => 'Assessment',
'guide_group_assessment_desc' => 'Self assessment • Employee assessment • View results',

'guide_image_missing' => 'No image file found yet (you can add the image later).',

'guide_modal_self_assessment_title' => 'Self Assessment',
'guide_modal_self_assessment_desc' => 'Steps to complete the self assessment',

'guide_self_assessment_step1' => 'When the scheduled period starts, the system will enable the “Self Assessment” button for all employees.',
'guide_self_assessment_step2' => 'On the assessment page, read each question carefully and answer all questions completely.',
'guide_self_assessment_step3' => 'After finishing, click “Submit Self Assessment” and confirm to save your answers in the system.',
'guide_self_assessment_step4' => 'Once the system saves successfully, the self assessment process is completed.',

'guide_modal_employee_assessment_title' => 'Employee Assessment',
'guide_modal_employee_assessment_desc' => 'Steps to evaluate employees based on your permissions',

'guide_employee_assessment_step1' => 'Select an employee from the list and click “Evaluate” to open the evaluation form.',
'guide_employee_assessment_step2' => 'Fill in all required scores and evaluation details as specified by the system.',
'guide_employee_assessment_step3' => 'Click “Save Total Score” and confirm to submit the evaluation to the system.',
'guide_employee_assessment_step4' => 'After saving successfully, the status will be updated and you can review the results.',

'guide_modal_results_title' => 'View Results',
'guide_modal_results_desc' => 'Steps to view assessment results',

'guide_results_step1' => 'Click “View Results” to open the assessment results summary page.',
'guide_results_step2' => 'Search or choose the department/employee you want to review.',
'guide_results_step3' => 'The system will display summaries and details according to your access permissions.',
'guide_results_step4' => 'Review completed.',


'guide_employee_assessment_step1' => 'When the scheduled period begins, the system will enable the “Evaluate Employees” button so supervisors can evaluate employees in their reporting line.',
'guide_employee_assessment_step2' => 'On the employee list page, the system shows your evaluation role (Supervisor or Division) and lists only employees in your line. Click “Evaluate” to start.',
'guide_employee_assessment_step3' => 'On the evaluation form, you will see employee details and sections such as Attendance, Individual Performance, Department OKR, Company OKR, System (SMBR), and Bonus. You must enter scores in the Individual Performance section.',
'guide_employee_assessment_step4' => 'In the Individual Performance section, enter scores for Leadership and Attitude.',
'guide_employee_assessment_step5' => 'After entering scores, click “Calculate” to get the Individual result, then click “Apply” to confirm the score.',
'guide_employee_assessment_step6' => 'The system will automatically calculate the final total score using all sections.',
'guide_employee_assessment_step7' => 'Finally, click “Save Total Score” to complete the evaluation.',
'guide_employee_assessment_step8' => 'After saving successfully, the evaluated employee can view the evaluation results.',


'guide_modal_results_title' => 'View Assessment Results',
'guide_modal_results_desc'  => 'Steps for reviewing assessment results for authorized roles',

'guide_results_step1' => 'For users in the Dept Manager and Plant Manager roles, the system will display the “View Results” button to review employees’ assessment outcomes within the responsible reporting line.',
'guide_results_step2' => 'After clicking “View Results”, the system will display the results list page arranged by hierarchy: Plant Manager → Dept Manager → Division Manager → Supervisor → Employees.',
'guide_results_step3' => 'Users can select a name at each level to display the employees under that person’s reporting line for review.',
'guide_results_step4' => 'The system allows viewing an individual employee’s profile details.',
'guide_results_step5' => 'The system allows viewing an employee’s self-assessment details.',
'guide_results_step6' => 'The system allows viewing the assessment details submitted by the employee’s supervisor/manager.',


//Supavut Penalty&Bonus

//หน้าเว็บ
'pb_title' => 'Supavut Penalty & Bonus',
'pb_module_badge' => 'Supavut Module',
'pb_login_subtitle' => 'Sign in to use the Penalty & Bonus module.',
'pb_login_failed' => 'Login failed',
'pb_username' => 'Employee ID',
'pb_username_placeholder' => 'Enter employee ID',
'pb_password' => 'Password',
'pb_password_placeholder' => 'Enter password',
'pb_login_button' => 'Sign in',
'pb_back_assessment' => 'Back to Supavut Assessment',
'pb_theme_dark' => 'Dark',

//โปรไฟล์
// ===== Penalty & Bonus (PB) =====
'pb_title' => 'Supavut Penalty & Bonus',
'pb_module_badge' => 'Supavut Module',
'pb_login_subtitle' => 'Sign in to use the Penalty & Bonus module',
'pb_login_failed' => 'Login Failed',
'pb_username' => 'Employee ID',
'pb_username_placeholder' => 'Enter employee ID',
'pb_password' => 'Password',
'pb_password_placeholder' => 'Enter password',
'pb_login_button' => 'Sign In',
'pb_back_assessment' => 'Back to Supavut Assessment',
'pb_theme_dark' => 'Dark',
'pb_access_denied' => 'Access denied for Penalty & Bonus',
'pb_must_verify_otp' => 'Your account is not OTP-verified yet. Please verify OTP in Supavut Assessment before accessing Penalty & Bonus.',

'pb_username_required' => 'Please enter your username',
'pb_password_required' => 'Please enter your password',
'pb_invalid_credentials' => 'Invalid username or password',

'pb_profile_subtitle' => 'Penalty & Bonus profile page (in development)',
'pb_logged_in_as' => 'Logged in as',
'pb_inbox' => 'Inbox',
'pb_inbox_hint' => 'View related queue/items (in development)',
'pb_import' => 'Import',
'pb_import_hint' => 'Allowed users only (in development)',
'pb_open' => 'Open',
'pb_logout' => 'Logout',

'profile_picture' => 'Profile picture',
'profile_picture_hint' => 'Upload a new photo to replace the current one (jpg/png/webp), max 10MB.',
'choose_profile_picture' => 'Choose a profile picture',
'save_profile_picture' => 'Save profile picture',

'pb_import' => 'Import',
'pb_import_hint' => 'Choose import type',
'pb_import_choose_type' => 'Select import type',
'pb_import_individual' => 'Individual',
'pb_import_department' => 'Department',
'pb_import_department_note' => 'Department (Department files the report)',




'page_title' => 'PB • Individual',
  'header_title' => 'Individual',
  'formula_hint' => ':base + Add − Deduct',

  'back' => 'Back',

  'theme_dark' => 'Dark mode',
  'theme_light' => 'Light mode',

  'table_title' => 'Table',
  'recipient' => 'Recipient',
  'from' => 'From',
  'count' => 'Count',
  'save' => 'Save',

  'created_by' => 'Created by',
  'supervisor' => 'Supervisor',

  'status_draft' => 'Not sent',
  'status_waiting' => 'Waiting',
  'status_done' => 'Completed',
  'status_rejected' => 'Rejected',

  'col_type' => 'Type',
  'col_points' => 'Points',
  'col_heading' => 'Topic',
  'col_reason' => 'Reason',
  'col_evidence' => 'Evidence',

  'no_items' => '— No items —',

  'kpi_base' => 'Base',
  'kpi_add' => 'Add',
  'kpi_deduct' => 'Deduct',
  'kpi_net' => 'Net',

  'add_item_title' => 'Add item',
  'add_score' => 'Add score',
  'deduct_score' => 'Deduct score',

  'type' => 'Type',
  'points' => 'Points',
  'heading' => 'Topic',
  'reason' => 'Reason',
  'heading_placeholder' => 'Enter topic',
  'reason_placeholder' => 'Type a short reason…',

  'attach_images_optional' => 'Attach images (optional)',
  'images_hint' => 'Attached images will appear as thumbnails in the table; click to enlarge.',

  'add' => 'Add',
  'add_recipient' => 'Add recipient',
  'remove' => 'Remove',
  'remove_to_change' => 'Remove to change recipient',

  'recipient_search_placeholder' => '🔎 Search (name/supervisor/code)',
  'select_then_add_hint' => 'Select an employee and click “Add”.',
  'selected_recipient' => 'Selected recipient',
  'remove_to_change_hint' => 'To change recipient, click “Remove”.',
  'no_recipient' => '— No recipient selected —',

  'rejection_title' => 'Rejection details',
  'rejection_desc' => 'The recipient will fill this when rejecting add/deduct items (reserved for future use).',
  'rejection_none' => '— No rejection yet —',

  'image' => 'Image',
  'profile' => 'Profile',
  'view_profile_photo' => 'View profile photo',
  'close' => 'Close',

  'dash' => '-',
  'delete' => 'Delete',

  // JS messages
  'rec_err_select_one_before_add' => 'Select 1 recipient first.',
  'rec_err_at_least_one' => 'Select at least 1 recipient.',
  'alert_add_at_least_one_item' => 'Please add at least 1 item.',
  'item_err_heading_required' => 'Please enter a topic.',
  'item_err_reason_required' => 'Please enter a reason.',


'pb_emp_pick_title' => 'Select employee (Individual)',
'pb_emp_pick_hint' => 'Starting page for “Individual penalty/bonus” — loaded from employees ordered by employee code.',

'pb_search_placeholder_employee' => 'Search: employee code / Thai name / English name / QMS dept. / position',
'pb_search' => 'Search',
'pb_clear' => 'Clear',

'pb_showing' => 'Showing',
'pb_people' => 'people',
'pb_page' => 'Page',

'pb_employee_code' => 'Employee code',
'pb_name_th' => 'Full name (TH)',
'pb_name_en' => 'Full name (EN)',
'pb_position' => 'Position',
'pb_qms_dept' => 'Dept. (QMS)',
'pb_status' => 'Status',
'pb_manage' => 'Manage',
'pb_not_found_employees' => 'No employees found',

'pb_back' => 'Back',
'pb_back_profile' => 'Back to profile',




// ===== PB Department (Group) =====
'pb_dept_pick_title' => 'Select department (Group)',
'pb_dept_pick_hint' => 'Group by Dept (QMS) to add/deduct points in bulk.',
'pb_dept_manage_title' => 'Bulk score management (Department)',
'pb_dept_manage_hint' => 'Add/Deduct points for the whole department using Dept (QMS) code.',
'pb_search_placeholder_department' => 'Search: Dept (QMS) / Department name / Dept (HR)',
'pb_dept_abbr_qms' => 'Dept (QMS)',
'pb_department_name' => 'Department name',
'pb_people_count' => 'People count',
'pb_departments' => 'departments',

'pb_items' => 'Items',
'pb_add_item' => 'Add item',
'pb_item_type' => 'Type',
'pb_item_add' => 'Add points',
'pb_item_deduct' => 'Deduct points',
'pb_points' => 'Points',
'pb_reason' => 'Reason',
'pb_evidence' => 'Evidence',
'pb_attach_images' => 'Attach images',
'pb_remove' => 'Remove',
'pb_save' => 'Save',
'pb_saved_draft' => 'Draft saved successfully.',

'pb_not_found_departments' => 'No departments found',


// ===== PB: Department pick + employee modal =====
'pb_dept_pick_title' => 'PB • Select Department',
'pb_dept_pick_hint' => 'Pick a department (QMS abbr.) to add/deduct points as a group.',
'pb_search_placeholder_department' => 'Search department...',
'pb_search' => 'Search',
'pb_clear' => 'Clear',
'pb_showing' => 'Total',
'pb_departments' => 'departments',
'pb_page' => 'Page',

'pb_dept_abbr_qms' => 'Dept (QMS)',
'pb_department_name' => 'Department',
'pb_people_count' => 'People',
'pb_people' => 'people',

'pb_status' => 'Status',
'pb_status_draft' => 'Draft',
'pb_status_waiting' => 'Waiting',
'pb_status_done' => 'Done',
'pb_status_rejected' => 'Rejected',

'pb_manage' => 'Manage',
'pb_not_found_departments' => 'No departments found',
'pb_back' => 'Back',
'pb_back_profile' => 'Back to profile',

'pb_theme_dark' => 'Dark',
'pb_theme_light' => 'Light',

// ✅ Modal employee list
'pb_view_employees' => 'Employees',
'pb_employee_list_title' => 'Employees in department',
'pb_employee_search_placeholder' => 'Search code / name / position...',
'pb_employee_total' => 'Total',
'pb_employee_code' => 'Employee code',
'pb_employee_name' => 'Full name',
'pb_employee_position' => 'Position',
'pb_employee_supervisor' => 'Supervisor',
'pb_close' => 'Close',
'pb_loading' => 'Loading...',
'pb_no_employees' => 'No employees found',
'pb_fetch_failed' => 'Failed to load employees',


// PB - Department Manage
'pb_dept_manage_title' => 'Penalty/Bonus • Department',
'pb_dept_manage_hint'  => 'Add/Deduct points for all employees in the selected department.',
'pb_dept_employees_title' => 'Employees in this department',
'pb_apply_to_all_hint' => 'This will be applied to all employees in the department.',
'pb_summary' => 'Summary',
'pb_total_add' => 'Total add',
'pb_total_deduct' => 'Total deduct',
'pb_final_score' => 'Final',

'pb_type' => 'Type',
'pb_add' => 'Add',
'pb_deduct' => 'Deduct',
'pb_points' => 'Points',
'pb_reason' => 'Reason',
'pb_reason_placeholder' => 'Enter reason...',
'pb_evidence' => 'Evidence',
'pb_add_item' => 'Add item',
'pb_clear_all' => 'Clear all',
'pb_action' => 'Action',
'pb_no_items' => 'No items yet',
'pb_need_one_item' => 'Please add at least 1 item before saving.',

'pb_points_invalid' => 'Points must be greater than 0',
'pb_reason_required' => 'Reason is required',
'pb_confirm_clear_all' => 'Clear all items?',

'pb_preview' => 'Preview',
'pb_close' => 'Close',
'pb_save' => 'Save',
'pb_fix_errors' => 'Please fix these errors',
'pb_saved_success' => 'Saved successfully',

'pb_in_dept' => 'Dept',
'pb_heading' => 'Heading',
'pb_col_by' => 'Added/Deducted by',
'pb_reject_detail_title' => 'Rejection details',
'pb_reject_detail_hint' => 'If there is a rejection / disapproval later, you can write the details here (optional).',
'pb_base' => 'Base',
'pb_net'  => 'Net',
'pb_send_to' => 'Recipient',
'pb_recipient_hint' => 'Select only 1 recipient.',
'pb_heading_placeholder' => 'Enter heading...',
    'pb_reject_detail_placeholder' => 'Enter rejection details (optional)...',
    'pb_added_at' => 'Added at',















    // ===== PB (Penalty & Bonus) - Inbox =====
  'pb_title' => 'Penalty & Bonus',
  'pb_inbox' => 'Inbox',
  'pb_inbox_tabs' => 'Inbox Tabs',
  'pb_logged_in_as' => 'User',
  'pb_back' => 'Back',

  'pb_theme_dark' => 'Dark',
  'pb_theme_light' => 'Light',

  'pb_tab_department' => 'Department',
  'pb_tab_individual' => 'Individual',
  'pb_inbox_hint' => 'Pick from the left, then view documents on the right.',

  'pb_list_department' => 'Departments (QMS)',
  'pb_sort_qms' => 'Sort by QMS',
  'pb_search_department' => 'Search QMS/Department name...',
  'pb_no_department' => 'No departments found.',

  'pb_list_employee' => 'Employees',
  'pb_sort_code' => 'Sort by code',
  'pb_search_employee' => 'Search code/name...',
  'pb_no_employee' => 'No employees found.',

  'pb_left_pick' => 'Select',
  'pb_count_docs' => 'Documents',

  'pb_pick_left' => 'Please select from the left.',
  'pb_inbox_sub_dept' => 'Documents sent from departments (Department mode).',
  'pb_inbox_sub_emp' => 'Documents sent from departments (Individual mode).',
  'pb_no_docs' => 'No documents yet.',

  'pb_pending' => 'Pending',
  'pb_approved' => 'Approved',
  'pb_rejected' => 'Rejected',

  'pb_from' => 'From',

  'pb_kpi_base' => 'Base',
  'pb_kpi_add' => 'Add',
  'pb_kpi_deduct' => 'Deduct',
  'pb_kpi_net' => 'Net',

  'pb_detail' => 'Details',
  'pb_confirm_approve' => 'Confirm approval?',
  'pb_approve' => 'Approve',
  'pb_reject' => 'Reject',
  'pb_closed' => 'Closed',

  'pb_reject_note' => 'Rejection note',

  'pb_group' => 'Group',
  'pb_created_at' => 'Date/Time',
  'pb_items' => 'Items',

  'pb_type' => 'Type',
  'pb_points' => 'Points',
  'pb_heading' => 'Heading',
  'pb_reason' => 'Reason',
  'pb_evidence' => 'Evidence',

  'pb_reason_keep_format' => 'Reason text is displayed with original spacing/line breaks.',
  'pb_no_items' => 'No items',

  'pb_add_score' => 'Add score',
  'pb_deduct_score' => 'Deduct score',
  'pb_dash' => '-',

  'pb_document' => 'Document',
  'pb_reject_reason' => 'Type details to send back to the sender',
  'pb_reject_placeholder' => 'Type your reason... (line breaks allowed)',
  'pb_cancel' => 'Cancel',
  'pb_send_back' => 'Send back (Reject)',
  'pb_reject_tip' => 'When you reject, the system will save and notify the sender.',
  'pb_reject_need_note' => 'Please type details before rejecting.',

  'pb_prev' => 'Prev',
  'pb_next' => 'Next',
  'pb_page_x_of_y' => 'Page :current / :total',

  'pb_close' => 'Close',
  'pb_image' => 'Image',

  'pb_footer_copy' => '© :year Supavut Industry Co., Ltd.',

  // ===== Example (UI preview) =====
  'pb_example_doc_title' => 'Example score adjustment document (Preview)',
  'pb_example_from_dept' => 'Sender department (Example)',
  'pb_example_item_heading1' => 'Late arrival',
  'pb_example_item_reason1' => 'Late beyond the allowed threshold per policy.',
  'pb_example_item_heading2' => 'Special support',
  'pb_example_item_reason2' => 'Provided support for urgent tasks.',
  'pb_example_pdf_name' => 'example.pdf',
  'pb_example_only' => 'Example mode: UI preview only (not connected to database yet).',
    'pb_create_topic' => 'Create topic',


    'citizen_id_label' => 'National ID (13 digits)',
'citizen_id_placeholder' => 'Enter 13 digits',
'citizen_id_help' => 'Use for identity verification when changing your password',
'citizen_id_required' => 'Please enter your national ID',
'citizen_id_invalid' => 'Invalid national ID',

'save_email_success' => 'Email updated successfully',
'save_password_success' => 'Password updated successfully',
'profile_picture_saved' => 'Profile picture saved successfully',
'first_login_upload_title' => 'Upload profile photo (first time)',
    'first_login_upload_hint'  => 'Please upload your profile photo before signing in.',
    'required'                 => 'Required',
    'upload_and_login'         => 'Upload & Sign in',



    // === Login page (Assessment) ===
    'aria_switch_website' => 'Switch website',
    'aria_language_switcher' => 'Language switcher',

    'site_assessment' => 'Supavut Assessment',
    'site_pb' => 'Supavut Penalty & Bonus',

    'logo_alt' => 'Supavut Logo',
    'footer_copyright' => '© :year Supavut Industry Co., Ltd.',

    'password_placeholder' => 'Enter password',
    'forgot_password' => 'Forgot password',

    // Employee preview statuses
    'emp_status_ok' => 'OK',
    'emp_status_not_found' => 'NOT FOUND',
    'emp_status_ready' => 'READY',
    'emp_status_no_photo' => 'NO PHOTO',
    'emp_status_verified' => 'VERIFIED',
    'emp_preview_not_found' => 'Not found',

    // Common texts used in JS (ensure exist)
    'checking' => 'Checking...',
    'logging_in' => 'Signing in...',
    'uploading' => 'Uploading...',

    // Offline
    'offline_alert' => 'You are offline. Please check your internet connection.',

    // Errors / validations (ensure exist)
    'emp_lookup_error_code_required' => 'Please enter your username/employee ID.',
    'password_required' => 'Please enter your password.',
    'emp_lookup_error_general' => 'Something went wrong. Please try again.',
    'emp_lookup_error_not_found' => 'Employee not found.',
    'auth_invalid_credentials' => 'Invalid login credentials.',

    // First login upload (ensure exist)
    'first_login_upload_title' => 'Upload your profile picture before continuing',
    'first_login_upload_hint' => 'We found that you do not have a profile picture yet. Please upload one to continue to your profile.',
    'required' => 'Required',
    'profile_picture' => 'Profile picture',
    'profile_picture_hint' => 'A clear front-facing photo is recommended (JPG/PNG/WEBP up to 10MB).',
    'profile_picture_required' => 'Please choose a profile picture.',
    'profile_too_large' => 'File size exceeds 10MB.',
    'upload_and_login' => 'Upload and sign in',

    // Forgot password modal (FP)
    'fp_modal_title' => 'Forgot password',
    'fp_modal_hint' => 'Enter your employee ID and Thai national ID, then set a new password.',
    'fp_employee_code_placeholder' => 'e.g. 12345',
    'fp_citizen_id_label' => 'Thai national ID (13 digits)',
    'fp_citizen_id_placeholder' => 'xxxxxxxxxxxxx',

    'fp_verify' => 'Verify',
    'fp_verifying' => 'Verifying...',
    'fp_new_password' => 'New password',
    'fp_new_password_placeholder' => 'At least 8 characters',
    'fp_confirm_password' => 'Confirm new password',
    'fp_confirm_password_placeholder' => 'Type again',
    'fp_save_new_password' => 'Save new password',
    'fp_saving' => 'Saving...',
    'fp_back' => 'Back',
    'fp_close' => 'Close',
    

    // FP errors/success (JS defaults)
    'fp_err_employee_required' => 'Please enter your employee ID.',
    'fp_err_citizen_required' => 'Please enter your Thai national ID.',
    'fp_err_citizen_invalid' => 'Please enter a valid 13-digit Thai national ID.',
    'fp_err_verify_failed' => 'Verification failed.',
    'fp_err_general' => 'Something went wrong. Please try again.',
    'fp_err_session_invalid' => 'Invalid verification session. Please verify again.',
    'fp_err_pwd_min' => 'New password must be at least 8 characters.',
    'fp_err_pwd_mismatch' => 'Password confirmation does not match.',
    'fp_success' => 'Password changed successfully.',

    // Basic buttons (ensure exist)
    'cancel' => 'Cancel',
    'ok' => 'OK',
    'alert_title' => 'Notice',
    'assess_saved_success' => 'Score saved successfully',
];
