<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Self Assessment Questions
     |--------------------------------------------------------------------------
     |
     | การแม็ปลำดับชั้น:
     |   Class A = position_level 1  (cooking, driver, maid, operator, senior operator, support mat, tp man)
     |   Class B = position_level 2  (foreman, leader, senior staff, senior technician, staff, technician)
     |   Class C = position_level 3  (engineer, senior engineer, supervisor)
     |   Class D = position_level 4,5 (assist manager, assistant manager, manager,
     |                                deputy general manager, general manager)
     |
     | for_classes ใช้ A/B/C/D แบบเดิม
     | for_levels  ผูกเป็นเลข position_level ที่ต้องเห็นคำถามข้อนั้น
     |
     */

    // Q1
    1 => [
        'code'          => 'Q1',
        'text_th'       => 'ในการดำเนินงานทุกครั้งคุณมีความรับผิดชอบต่อผลลัพธ์ในการกระทำของตนเอง และของทีมเสมอ',
        'text_en'       => 'In every task you take responsibility for the outcomes of your own actions and those of your team.',
        'skill'         => 'Accountability',
        'main_category' => 'Individual Effectiveness',
        'sub_category'  => 'Collaboration',
        'pacrim_level'  => '>=D',
        'for_classes'   => ['D'],          // Class D
        'for_levels'    => [4, 5],         // position_level 4,5
    ],

    // Q2
    2 => [
        'code'          => 'Q2',
        'text_th'       => 'เมื่อมีภาระงานแทรกเข้ามา คุณสามารถปรับเปลี่ยนตารางการทำงานของตัวเองและดำเนินงานทุกอย่างต่อไปได้อย่างไม่ติดขัด',
        'text_en'       => 'When unexpected work arises, you can adjust your work schedule and continue all tasks smoothly.',
        'skill'         => 'Adaptability',
        'main_category' => 'Winning Culture',
        'sub_category'  => 'Change Management',
        'pacrim_level'  => '>=B',
        'for_classes'   => ['B','C','D'],
        'for_levels'    => [2, 3, 4, 5],
    ],

    // Q3
    3 => [
        'code'          => 'Q3',
        'text_th'       => 'คุณสามารถสร้างความเชื่อมั่นให้กับคนอื่นๆได้ และเป็นคนที่ทุกคนเชื่อใจ',
        'text_en'       => 'You are able to build confidence in others and are someone everyone can trust.',
        'skill'         => 'Belonging',
        'main_category' => 'Winning Culture',
        'sub_category'  => 'Inclusion',
        'pacrim_level'  => '>=D',
        'for_classes'   => ['D'],
        'for_levels'    => [4, 5],
    ],

    // Q4
    4 => [
        'code'          => 'Q4',
        'text_th'       => 'เมื่อต้องอบรบหรือสอนงานให้กับพนักงานในหน่วยงานของท่าน คุณจะระบุเกณฑ์การประเมินไว้อย่างชัดเจนทุกครั้ง',
        'text_en'       => 'When you train or coach staff in your unit, you always state the evaluation criteria clearly.',
        'skill'         => 'Coaching',
        'main_category' => 'Leadership',
        'sub_category'  => 'Team Management',
        'pacrim_level'  => '>=B',
        'for_classes'   => ['B','C','D'],
        'for_levels'    => [2, 3, 4, 5],
    ],

    // Q5
    5 => [
        'code'          => 'Q5',
        'text_th'       => 'คุณใช้ภาษาอังกฤษในการพูดนำเสนอ หรือ พูดแสดงความคิดเห็นเกี่ยวกับการทำงานเป็นประจำทุกวัน',
        'text_en'       => 'You regularly use English to present or express opinions about work.',
        'skill'         => 'Communicative English',
        'main_category' => 'Individual Effectiveness',
        'sub_category'  => 'Communication',
        'pacrim_level'  => '>=C',
        'for_classes'   => ['C','D'],
        'for_levels'    => [3, 4, 5],
    ],

    // Q6
    6 => [
        'code'          => 'Q6',
        'text_th'       => 'คุณมีการติดตามความก้าวหน้าในการทำงาน การแก้ไขปัญหา และให้คำแนะนำกับลูกน้องแบบเป็นการส่วนตัวอย่างเป็นประจำ',
        'text_en'       => 'You regularly follow up individually with subordinates on work progress, problem solving, and provide guidance.',
        'skill'         => 'Conducting 1:1s',
        'main_category' => 'Leadership',
        'sub_category'  => 'Team Management',
        'pacrim_level'  => '>=D',
        'for_classes'   => ['D'],
        'for_levels'    => [4, 5],
    ],

    // Q7
    7 => [
        'code'          => 'Q7',
        'text_th'       => 'คุณพยายามทำความเข้าใจผู้อื่น มีความเห็นใจ และคอยให้กำลังใจคนรอบข้างเสมอ',
        'text_en'       => 'You try to understand others, show empathy, and consistently encourage people around you.',
        'skill'         => 'Emotional Intelligence (EQ)',
        'main_category' => 'Winning Culture',
        'sub_category'  => 'Well-being',
        'pacrim_level'  => 'All',
        'for_classes'   => ['A','B','C','D'],
        'for_levels'    => [1, 2, 3, 4, 5],
    ],

    // Q8
    8 => [
        'code'          => 'Q8',
        'text_th'       => 'คุณไว้วางใจและเชื่อมั่นในความสามารถของผู้อื่นอย่างเสมอ โดยไม่ต้องมีการควบคุมหรือตรวจสอบอย่างใกล้ชิด',
        'text_en'       => 'You consistently trust and have confidence in others abilities without needing to control or check them closely.',
        'skill'         => 'Extending Trust',
        'main_category' => 'Winning Culture',
        'sub_category'  => 'Trust',
        'pacrim_level'  => '>=D',
        'for_classes'   => ['D'],
        'for_levels'    => [4, 5],
    ],

    // Q9
    9 => [
        'code'          => 'Q9',
        'text_th'       => 'เมื่อไม่เห็นด้วย คุณสามารถพูดความคิดเห็นของตัวเองกับคนอื่นได้อย่างตรงไปตรงมา ไม่เก็บไปพูดลับหลัง',
        'text_en'       => 'When you disagree, you can express your opinion directly to others instead of talking behind their backs.',
        'skill'         => 'Giving Feedback',
        'main_category' => 'Leadership',
        'sub_category'  => 'Team Management',
        'pacrim_level'  => 'All',
        'for_classes'   => ['A','B','C','D'],
        'for_levels'    => [1, 2, 3, 4, 5],
    ],

    // Q10
    10 => [
        'code'          => 'Q10',
        'text_th'       => 'คุณมองเห็นความล้มเหลวเป็นโอกาสในการเรียนรู้และปรับปรุงตนเองทุกครั้ง',
        'text_en'       => 'You see failures as opportunities to learn and improve yourself.',
        'skill'         => 'Growth Mindset',
        'main_category' => 'Individual Effectiveness',
        'sub_category'  => 'Self-Management',
        'pacrim_level'  => 'All',
        'for_classes'   => ['A','B','C','D'],
        'for_levels'    => [1, 2, 3, 4, 5],
    ],

    // Q11
    11 => [
        'code'          => 'Q11',
        'text_th'       => 'คุณมีการให้คะแนนหรือประเมินความเหมาะสมของผู้สมัครงานทุกครั้งหลังจากสัมภาษณ์งาน โดยอ้างอิงจากเกณฑ์หรือเงื่อนไขที่คุณกำหนดไว้อย่างชัดเจน',
        'text_en'       => 'After each job interview, you rate or assess the suitability of candidates based on clearly defined criteria or conditions.',
        'skill'         => 'Hiring',
        'main_category' => 'Leadership',
        'sub_category'  => 'Team Development',
        'pacrim_level'  => '>=D',
        'for_classes'   => ['D'],
        'for_levels'    => [4, 5],
    ],

    // Q12
    12 => [
        'code'          => 'Q12',
        'text_th'       => 'เมื่อเกิดปัญหาในการทำงาน คุณมักจะมีไอเดียรับมือและสามารถหาทางออกให้กับคนอื่นได้เสมอๆ',
        'text_en'       => 'When problems arise at work, you usually have ideas on how to respond and can help others find solutions.',
        'skill'         => 'Leading change',
        'main_category' => 'Winning Culture',
        'sub_category'  => 'Change Management',
        'pacrim_level'  => '>=D',
        'for_classes'   => ['D'],
        'for_levels'    => [4, 5],
    ],

    // Q13
    13 => [
        'code'          => 'Q13',
        'text_th'       => 'เมื่อมีพนักงานใหม่เข้ามาในหน่วยงานของท่าน ท่านสามารถสละเวลา และเต็มใจที่จะให้ข้อมูล คำแนะนำต่างๆ สำหรับการทำงานในหน่วยงานท่าน',
        'text_en'       => 'When new employees join your unit, you are willing to make time to provide information and guidance about working in your area.',
        'skill'         => 'Onboarding',
        'main_category' => 'Leadership',
        'sub_category'  => 'Team Development',
        'pacrim_level'  => '>=B',
        'for_classes'   => ['B','C','D'],
        'for_levels'    => [2, 3, 4, 5],
    ],

    // Q14
    14 => [
        'code'          => 'Q14',
        'text_th'       => 'คุณรู้สึกมั่นใจและไม่รู้สึกประหม่าเมื่อต้องพูดหรือสื่อสารต่อหน้าคนหรือกลุ่มคนจำนวนมาก',
        'text_en'       => 'You feel confident and not nervous when speaking or communicating in front of many people.',
        'skill'         => 'Presenting',
        'main_category' => 'Individual Effectiveness',
        'sub_category'  => 'Communication',
        'pacrim_level'  => '>=B',
        'for_classes'   => ['B','C','D'],
        'for_levels'    => [2, 3, 4, 5],
    ],

    // Q15
    15 => [
        'code'          => 'Q15',
        'text_th'       => 'คุณมีการเตรียมความพร้อม หรือวางแผนล่วงหน้าเพื่อที่จะรับมือกับสถานการณ์หรือปัญหาโดยไม่ต้องรอให้มีปัญหาเกิดขึ้นก่อน',
        'text_en'       => 'You prepare and plan in advance to handle situations or problems instead of waiting until problems occur.',
        'skill'         => 'Proactivity',
        'main_category' => 'Individual Effectiveness',
        'sub_category'  => 'Self-Management',
        'pacrim_level'  => '>=B',
        'for_classes'   => ['B','C','D'],
        'for_levels'    => [2, 3, 4, 5],
    ],

    // Q16
    16 => [
        'code'          => 'Q16',
        'text_th'       => 'เมื่อได้รับโจทย์ให้แก้ไขปัญหา คุณไม่เคยประสบปัญหากับการนึกอะไรไม่ออก และไม่เคยประสบปัญหากับการไม่รู้ว่าจะแก้ไขหรือลงมือทำอย่างไรดี',
        'text_en'       => 'When you are given a problem to solve, you do not have difficulty coming up with ideas or knowing how to take action.',
        'skill'         => 'Problem-solving',
        'main_category' => 'Individual Effectiveness',
        'sub_category'  => 'Communication',
        'pacrim_level'  => '>=B',
        'for_classes'   => ['B','C','D'],
        'for_levels'    => [2, 3, 4, 5],
    ],

    // Q17
    17 => [
        'code'          => 'Q17',
        'text_th'       => 'เมื่อต้องแก้ไขปัญหาคุณมักจะเอาขั้นตอนการดำเนินงานแบบ Problem Solving  มาใช้ ด้วยเทคนิค PDCA อย่างสม่ำเสมอ',
        'text_en'       => 'When you solve problems, you regularly apply a structured problem solving process using PDCA techniques.',
        'skill'         => 'Project Management',
        'main_category' => 'Individual Effectiveness',
        'sub_category'  => 'Project Management',
        'pacrim_level'  => '>=C',
        'for_classes'   => ['C','D'],
        'for_levels'    => [3, 4, 5],
    ],

    // Q18
    18 => [
        'code'          => 'Q18',
        'text_th'       => 'คุณรู้สึกไม่กังวลที่สมาชิกในทีมหรือหัวหน้าทีมชี้ให้เห็นถึงความผิดพลาดที่เกิดขึ้น',
        'text_en'       => 'You do not feel worried when team members or leaders point out mistakes that you have made.',
        'skill'         => 'Psychological Safety',
        'main_category' => 'Winning Culture',
        'sub_category'  => 'Well-being',
        'pacrim_level'  => '<D',
        'for_classes'   => ['A','B','C'],
        'for_levels'    => [1, 2, 3],
    ],

    // Q19
    19 => [
        'code'          => 'Q19',
        'text_th'       => 'คุณเปิดรับไอเดียและฟังข้อเสนอแนะจากคนอื่นอยู่เสมอ',
        'text_en'       => 'You are open to ideas and listen to feedback from others at all times.',
        'skill'         => 'Receiving Feedback',
        'main_category' => 'Individual Effectiveness',
        'sub_category'  => 'Self-Management',
        'pacrim_level'  => 'All',
        'for_classes'   => ['A','B','C','D'],
        'for_levels'    => [1, 2, 3, 4, 5],
    ],

    // Q20
    20 => [
        'code'          => 'Q20',
        'text_th'       => 'เมื่อถึงคราวต้องตัดสินใจ คุณสามารถตัดสินใจได้อย่างมีเหตุและมีผลทุกครั้ง โดยไม่ใช้อารมณ์เป็นที่ตั้งและไม่มีการละเว้นกลุ่มคนเป็นบางกลุ่ม',
        'text_en'       => 'When it is time to decide, you make logical decisions that are not driven by emotion and do not favour particular groups of people.',
        'skill'         => 'Reducing Bias',
        'main_category' => 'Winning Culture',
        'sub_category'  => 'Inclusion',
        'pacrim_level'  => 'All',
        'for_classes'   => ['A','B','C','D'],
        'for_levels'    => [1, 2, 3, 4, 5],
    ],

    // Q21
    21 => [
        'code'          => 'Q21',
        'text_th'       => 'หากคุณต้องเป็นผู้จัดการประชุม คุณจะกำหนดหัวข้อการประชุม ผู้เข้าร่วมประชุม และจัดการเวลาในการประชุมให้เหมาะสมอย่างเป็นประจำ',
        'text_en'       => 'When you are responsible for a meeting, you regularly set a clear agenda, select appropriate participants, and manage meeting time well.',
        'skill'         => 'Running Meeting',
        'main_category' => 'Individual Effectiveness',
        'sub_category'  => 'Communication',
        'pacrim_level'  => '>=C',
        'for_classes'   => ['C','D'],
        'for_levels'    => [3, 4, 5],
    ],

    // Q22
    22 => [
        'code'          => 'Q22',
        'text_th'       => 'คุณรับรู้อารมณ์ ความรู้สึก ของตนเอง และวิเคราะห์การกระทำของตนเองได้ทุกครั้งเมื่อเกิดปัญหา',
        'text_en'       => 'You are aware of your own emotions and feelings and can reflect on your behaviour whenever problems arise.',
        'skill'         => 'Self-awareness',
        'main_category' => 'Individual Effectiveness',
        'sub_category'  => 'Self-Management',
        'pacrim_level'  => 'All',
        'for_classes'   => ['A','B','C','D'],
        'for_levels'    => [1, 2, 3, 4, 5],
    ],

    // Q23
    23 => [
        'code'          => 'Q23',
        'text_th'       => 'เมื่อต้องทำงานร่วมกัน คุณสามารถวิเคราะห์งานที่ต้องทำและแจกแจงแบ่งงานให้กับลูกน้องได้ดีและเหมาะสมทุกครั้ง',
        'text_en'       => 'When you work with your team, you can analyse the work to be done and delegate tasks to subordinates appropriately.',
        'skill'         => 'Setting Team Goals',
        'main_category' => 'Business Results',
        'sub_category'  => 'Team Execution',
        'pacrim_level'  => '>=D',
        'for_classes'   => ['D'],
        'for_levels'    => [4, 5],
    ],

    // Q24
    24 => [
        'code'          => 'Q24',
        'text_th'       => 'คุณรับรู้ระดับความรุนแรงของปัญหาและสามารถวิเคราะห์ผลที่ตามมาได้',
        'text_en'       => 'You recognise how serious a problem is and can analyse the consequences that may follow.',
        'skill'         => 'Strategic Thinking',
        'main_category' => 'Leadership',
        'sub_category'  => 'Strategic Leadership',
        'pacrim_level'  => '>=C',
        'for_classes'   => ['C','D'],
        'for_levels'    => [3, 4, 5],
    ],

    // Q25
    25 => [
        'code'          => 'Q25',
        'text_th'       => 'คุณเป็นคนที่ชอบตั้งเป้าหมายการทำงานให้กับลูกน้อง และมอบหมายงานที่สูงกว่าความสามารถเพื่อพัฒนาศักยภาพของลูกน้องเป็นประจำ',
        'text_en'       => 'You like to set work goals for subordinates and regularly assign tasks that are higher than their current ability in order to develop their potential.',
        'skill'         => 'Subordinate Development',
        'main_category' => 'Leadership',
        'sub_category'  => 'Team Development',
        'pacrim_level'  => '>=D',
        'for_classes'   => ['D'],
        'for_levels'    => [4, 5],
    ],

    // Q26
    26 => [
        'code'          => 'Q26',
        'text_th'       => 'คุณวางแผนและจัดการกับเวลาให้เสร็จตามเป้าหมายและตามระยะเวลาที่กำหนดไว้',
        'text_en'       => 'You plan and manage your time so that work is finished according to goals and within the required time frame.',
        'skill'         => 'Time Management',
        'main_category' => 'Individual Effectiveness',
        'sub_category'  => 'Self-Management',
        'pacrim_level'  => '>=B',
        'for_classes'   => ['B','C','D'],
        'for_levels'    => [2, 3, 4, 5],
    ],

    // Q27
    27 => [
        'code'          => 'Q27',
        'text_th'       => 'หากองค์กรของคุณถึงเวลาต้องเปลี่ยนแปลง คุณสามารถบริหารจัดการการเปลี่ยนแปลงได้อย่างรวดเร็ว รวมถึงการวิเคราะห์ปัญหา และการวางแผนปฏิบัติร่วมด้วย ว่าคุณจะเปลี่ยนอะไรบ้าง เปลี่ยนด้วยวิธีไหนถึงจะดีที่สุด',
        'text_en'       => 'When your organisation needs to change, you can manage the change quickly, including analysing problems and planning what to change and how to change it in the best way.',
        'skill'         => 'Change Management',
        'main_category' => 'Leadership',
        'sub_category'  => 'Change Management',
        'pacrim_level'  => '>=D',
        'for_classes'   => ['D'],
        'for_levels'    => [4, 5],
    ],

];
