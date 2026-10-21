<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProductionClientDataSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // 1. Clear existing dummy/test tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        $tablesToTruncate = [
            'categories',
            'exams',
            'mcq_questions',
            'written_questions',
            'course_categories',
            'courses',
            'course_modules',
            'teachers',
            'blogs',
            'notice',
            'slider_banners',
            'slider_infos',
            'slider_images',
            'company_settings',
            'courses_order',
            'results',
            'mcq_results',
            'mcq_results_parents',
            'written_results',
            'orders',
            'about_infos',
            'abouts'
        ];

        foreach ($tablesToTruncate as $t) {
            DB::table($t)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Ensure Admin User (admin@admin.com / 12345678)
        $admin = DB::table('admins')->where('email', 'admin@admin.com')->first();
        if ($admin) {
            DB::table('admins')->where('email', 'admin@admin.com')->update([
                'name' => 'Super Administrator',
                'password' => Hash::make('12345678'),
                'active' => 1,
                'updated_at' => $now
            ]);
        } else {
            DB::table('admins')->insert([
                'name' => 'Super Administrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        // 3. Ensure Demo Student User (mesba@gmail.com / 12345678)
        $student = DB::table('users')->where('email', 'mesba@gmail.com')->first();
        $studentId = null;
        if ($student) {
            $studentId = $student->id;
            DB::table('users')->where('id', $studentId)->update([
                'name' => 'Ridoy Paul',
                'phone' => '01712345678',
                'password' => Hash::make('12345678'),
                'address' => 'House 42, Road 11, Dhanmondi, Dhaka',
                'active' => 1,
                'updated_at' => $now
            ]);
        } else {
            $studentId = DB::table('users')->insertGetId([
                'name' => 'Ridoy Paul',
                'email' => 'mesba@gmail.com',
                'phone' => '01712345678',
                'password' => Hash::make('12345678'),
                'address' => 'House 42, Road 11, Dhanmondi, Dhaka',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        // 4. Populate Company Settings
        DB::table('company_settings')->insert([
            'company_name' => 'পাঠজল্পনা - বিসিএস ও সরকারি চাকরি প্রস্তুতি',
            'logo' => 'frontend/assets/images/logo/logo.png',
            'address' => 'হাউস ৪২, রোড ১১, ধানমন্ডি, ঢাকা-১২০৯',
            'phone_1' => '+880 1712-345678',
            'phone_2' => '+880 1912-345678',
            'email' => 'support@pathjolpona.com',
            'count1' => 25000,
            'count2' => 450,
            'count3' => 85,
            'count4' => 98,
            'facebook' => 'https://facebook.com/pathjolpona',
            'youtube' => 'https://youtube.com/@pathjolpona',
            'instagram' => 'https://instagram.com/pathjolpona',
            'twitter' => 'https://twitter.com/pathjolpona',
            'linkden' => 'https://linkedin.com/company/pathjolpona',
            'privacy_policy' => '<p>পাঠজল্পনা শিক্ষার্থীদের ব্যক্তিগত তথ্যের সর্বোচ্চ সুরক্ষা ও গোপনীয়তা বজায় রাখতে প্রতিশ্রুতিবদ্ধ। শিক্ষার্থীদের প্রোফাইল, ফোন নম্বর এবং পরীক্ষার ফলাফল সম্পূর্ণ এনক্রিপ্টেড ডাটাবেজে সংরক্ষিত থাকে এবং কোনো তৃতীয় পক্ষের কাছে বিক্রি বা শেয়ার করা হয় না।</p>',
            'mission_and_vission' => '<p><strong>আমাদের লক্ষ্য:</strong> বাংলাদেশের প্রতিটি প্রান্তের চাকরিপ্রত্যাশী শিক্ষার্থীদের কাছে নামমাত্র মূল্যে সেরা বিসিএস ও সরকারি চাকরির প্রস্তুতি পৌঁছে দেওয়া।<br><br><strong>আমাদের ভিশন:</strong> আধুনিক প্রযুক্তিনির্ভর লাইভ মডেল টেস্ট, তাৎক্ষণিক র‍্যাংকিং ও বিষয়ভিত্তিক বিশ্লেষণের মাধ্যমে দেশের শীর্ষস্থানীয় এডটেক প্ল্যাটফর্মে রূপান্তরিত হওয়া।</p>',
            'trams_and_condition' => '<p>১. পাঠজল্পনা প্ল্যাটফর্মের সকল মডেল টেস্ট, প্রশ্নব্যাংক ও লেকচার নোটের কপিরাইট সংরক্ষিত।<br>২. একটি শিক্ষার্থী অ্যাকাউন্ট কেবল একজন শিক্ষার্থীই ব্যবহার করতে পারবেন।<br>৩. পরীক্ষায় অসদুপায় অবলম্বন বা সার্ভারে স্প্যামিং নিষিদ্ধ।</p>',
            'footer_des' => 'পাঠজল্পনা বাংলাদেশের শীর্ষস্থানীয় অনলাইন পরীক্ষা ও ক্যারিয়ার প্ল্যাটফর্ম। বিসিএস, ব্যাংক, প্রাথমিক শিক্ষক নিয়োগ ও সকল সরকারি চাকরির জন্য সম্পূর্ণ ডিজিটাল প্রস্তুতি।',
            'footer_credit' => '© ২০২৬ পাঠজল্পনা এডুকেশন লিমিটেড। সর্বস্বত্ব সংরক্ষিত।',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // 5. Populate Exam Categories (`categories`)
        $categoriesData = [
            [
                'id' => 1,
                'name' => '৪৬তম ও ৪৭তম বিসিএস প্রিলিমিনারি প্রস্তুতি',
                'url' => 'bcs-preliminary-preparation',
                'image' => 'images/bcs_prep.jpg',
                'free_paid' => 'free',
                'tk' => '0',
                'rank' => 1,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'name' => 'সমন্বিত ১০ ব্যাংক সিনিয়র অফিসার ও অফিসার',
                'url' => 'combined-bank-officer-preparation',
                'image' => 'images/bank_prep.jpg',
                'free_paid' => 'paid',
                'tk' => '500',
                'rank' => 2,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'name' => 'প্রাথমিক সহকারী শিক্ষক নিয়োগ পরীক্ষা',
                'url' => 'primary-assistant-teacher-recruitment',
                'image' => 'images/primary_prep.jpg',
                'free_paid' => 'free',
                'tk' => '0',
                'rank' => 3,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'name' => '১৮তম শিক্ষক নিবন্ধন (NTRCA) স্কুল ও কলেজ',
                'url' => 'ntrca-teacher-registration-exam',
                'image' => 'images/ntrca_prep.jpg',
                'free_paid' => 'paid',
                'tk' => '450',
                'rank' => 4,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 5,
                'name' => 'বাংলাদেশ রেলওয়ে ও সরকারি নন-ক্যাডার নিয়োগ',
                'url' => 'railway-and-govt-non-cadre-jobs',
                'image' => 'images/govt_job_prep.jpg',
                'free_paid' => 'free',
                'tk' => '0',
                'rank' => 5,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        DB::table('categories')->insert($categoriesData);

        // 6. Populate Exams (`exams`)
        $examsData = [
            // BCS Category (id 1)
            [
                'id' => 1,
                'catID' => 1,
                'mcq_written' => 'mcq',
                'free_paid' => 'free',
                'tk' => 0,
                'exam_name' => '৪৬তম বিসিএস পূর্ণাঙ্গ মডেল টেস্ট - ০১ (বাংলা ও সাধারণ জ্ঞান)',
                'type' => 'free',
                'startDate' => '2026-10-20',
                'examTime' => '20',
                'written_paragraph' => null,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'catID' => 1,
                'mcq_written' => 'mcq',
                'free_paid' => 'free',
                'tk' => 0,
                'exam_name' => 'বিসিএস ইংরেজি ভাষা ও সাহিত্য স্পেশাল মেগা কুইজ',
                'type' => 'free',
                'startDate' => '2026-10-20',
                'examTime' => '15',
                'written_paragraph' => null,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'catID' => 1,
                'mcq_written' => 'written',
                'free_paid' => 'free',
                'tk' => 0,
                'exam_name' => 'বিসিএস লিখিত বাংলা রচনা ও বঙ্গানুবাদ মূল্যায়ন পরীক্ষা',
                'type' => 'free',
                'startDate' => '2026-10-20',
                'examTime' => '60',
                'written_paragraph' => 'নিচের অনুচ্ছেদটি মনোযোগ দিয়ে পড়ুন এবং বঙ্গানুবাদ করুন।',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Bank Category (id 2)
            [
                'id' => 4,
                'catID' => 2,
                'mcq_written' => 'mcq',
                'free_paid' => 'paid',
                'tk' => 500,
                'exam_name' => 'সমন্বিত ১০ ব্যাংক সিনিয়র অফিসার ম্যাথ ও অ্যানালিটিক্যাল টেস্ট',
                'type' => 'paid',
                'startDate' => '2026-10-20',
                'examTime' => '30',
                'written_paragraph' => null,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 5,
                'catID' => 2,
                'mcq_written' => 'written',
                'free_paid' => 'paid',
                'tk' => 500,
                'exam_name' => 'বাংলাদেশ ব্যাংক ফোকাস রাইটিং ও আর্গুমেন্ট এসে টেস্ট',
                'type' => 'paid',
                'startDate' => '2026-10-20',
                'examTime' => '45',
                'written_paragraph' => 'Write a structured analytical essay on: Smart Bangladesh & FinTech Transformation.',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Primary Category (id 3)
            [
                'id' => 6,
                'catID' => 3,
                'mcq_written' => 'mcq',
                'free_paid' => 'free',
                'tk' => 0,
                'exam_name' => 'প্রাথমিক সহকারী শিক্ষক চূড়ান্ত মডেল টেস্ট - ০১ (৮০ নম্বর)',
                'type' => 'free',
                'startDate' => '2026-10-20',
                'examTime' => '25',
                'written_paragraph' => null,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // NTRCA Category (id 4)
            [
                'id' => 7,
                'catID' => 4,
                'mcq_written' => 'mcq',
                'free_paid' => 'paid',
                'tk' => 450,
                'exam_name' => '১৮তম শিক্ষক নিবন্ধন প্রিলিমিনারি সাধারণ জ্ঞান ও বিজ্ঞান টেস্ট',
                'type' => 'paid',
                'startDate' => '2026-10-20',
                'examTime' => '20',
                'written_paragraph' => null,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Govt Non-Cadre Category (id 5)
            [
                'id' => 8,
                'catID' => 5,
                'mcq_written' => 'mcq',
                'free_paid' => 'free',
                'tk' => 0,
                'exam_name' => 'মন্ত্রণালয় ও সরকারি নন-ক্যাডার সাধারণ প্রস্তুতি মডেল টেস্ট',
                'type' => 'free',
                'startDate' => '2026-10-20',
                'examTime' => '20',
                'written_paragraph' => null,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        DB::table('exams')->insert($examsData);

        // 7. Populate Authentic MCQ Questions (`mcq_questions`)
        $mcqQuestions = [
            // Exam 1 (BCS Model Test 1)
            [
                'examID' => 1,
                'questions' => 'চর্যাপদের সবচেয়ে বেশি সংখ্যক পদ কে রচনা করেছেন?',
                'optn1' => 'লুইপা',
                'optn2' => 'কাহ্নপা',
                'optn3' => 'শবরপা',
                'optn4' => 'ভুসুকুপা',
                'optn5' => null,
                'rightAns' => 2,
                'mark' => '1.00',
                'negativeMark' => '0.25',
                'writeAnsDes' => 'চর্যাপদের মোট পদসংখ্যা সাড়ে ছেচল্লিশটি। এর মধ্যে সর্বোচ্চ ১৩টি পদ রচনা করেছেন কাহ্নপা। লুইপা প্রথম পদ এবং ভুসুকুপা ৮টি পদ রচনা করেন।',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'examID' => 1,
                'questions' => 'কোনটি মুক্তিযুদ্ধভিত্তিক উপন্যাস?',
                'optn1' => 'আগুনের পরশমণি',
                'optn2' => 'পদ্মানদীর মাঝি',
                'optn3' => 'লালসালু',
                'optn4' => 'চিলেকোঠার সেপাই',
                'optn5' => null,
                'rightAns' => 1,
                'mark' => '1.00',
                'negativeMark' => '0.25',
                'writeAnsDes' => '"আগুনের পরশমণি" কথাশিল্পী হুমায়ূন আহমেদের বিখ্যাত মুক্তিযুদ্ধভিত্তিক উপন্যাস। এর ওপর ভিত্তি করে তিনি চলচ্চিত্রও নির্মাণ করেছিলেন যা জাতীয় চলচ্চিত্র পুরস্কার পায়।',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'examID' => 1,
                'questions' => 'বাংলাদেশের সংবিধানের কোন অনুচ্ছেদে ‘মৌলিক অধিকার নিশ্চিতকরণ’ সংক্রান্ত বিধান রয়েছে?',
                'optn1' => '২৭ নম্বর অনুচ্ছেদ',
                'optn2' => '৪৪ নম্বর অনুচ্ছেদ',
                'optn3' => '৩২ নম্বর অনুচ্ছেদ',
                'optn4' => '৪৮ নম্বর অনুচ্ছেদ',
                'optn5' => null,
                'rightAns' => 2,
                'mark' => '1.00',
                'negativeMark' => '0.25',
                'writeAnsDes' => 'সংবিধানের ৪৪ নম্বর অনুচ্ছেদে মৌলিক অধিকার বলবৎকরণের জন্য সুপ্রিম কোর্টের হাইকোর্ট বিভাগে রিট করার অধিকার নিশ্চিত করা হয়েছে।',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'examID' => 1,
                'questions' => 'মহাস্থানগড় কোন নদীর তীরে অবস্থিত?',
                'optn1' => 'করতোয়া',
                'optn2' => 'ব্রহ্মপুত্র',
                'optn3' => 'যমুনা',
                'optn4' => 'পদ্মা',
                'optn5' => null,
                'rightAns' => 1,
                'mark' => '1.00',
                'negativeMark' => '0.25',
                'writeAnsDes' => 'বগুড়া শহর থেকে প্রায় ১৩ কিমি উত্তরে করতোয়া নদীর পশ্চিম তীরে প্রাচীন বাংলার রাজধানী পুণ্ড্রনগর বা মহাস্থানগড় অবস্থিত।',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'examID' => 1,
                'questions' => 'একটি দ্রব্যের ক্রয়মূল্য ৫০০ টাকা। ১০% লাভে দ্রব্যটির বিক্রয়মূল্য কত হবে?',
                'optn1' => '৫৪০ টাকা',
                'optn2' => '৫৫০ টাকা',
                'optn3' => '৫৬০ টাকা',
                'optn4' => '৫৭৫ টাকা',
                'optn5' => null,
                'rightAns' => 2,
                'mark' => '1.00',
                'negativeMark' => '0.25',
                'writeAnsDes' => '১০% লাভে বিক্রয়মূল্য = ৫০০ + (৫০০ × ১০/১০০) = ৫০০ + ৫০ = ৫৫০ টাকা।',
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Exam 2 (English Literature Mega Quiz)
            [
                'examID' => 2,
                'questions' => 'Who is known as the "Poet of Nature" in English Literature?',
                'optn1' => 'John Keats',
                'optn2' => 'William Wordsworth',
                'optn3' => 'P. B. Shelley',
                'optn4' => 'Lord Byron',
                'optn5' => null,
                'rightAns' => 2,
                'mark' => '1.00',
                'negativeMark' => '0.25',
                'writeAnsDes' => 'William Wordsworth is called the "Poet of Nature" and "Worshipper of Nature". John Keats is the "Poet of Beauty".',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'examID' => 2,
                'questions' => 'The antonym of the word "Candor" is -',
                'optn1' => 'Frankness',
                'optn2' => 'Deceit',
                'optn3' => 'Honesty',
                'optn4' => 'Fairness',
                'optn5' => null,
                'rightAns' => 2,
                'mark' => '1.00',
                'negativeMark' => '0.25',
                'writeAnsDes' => 'Candor means frankness, openness, or honesty. Therefore, its antonym is Deceit (কপটতা / প্রতারণা).',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'examID' => 2,
                'questions' => '"To be or not to be, that is the question" is a famous soliloquy from -',
                'optn1' => 'Macbeth',
                'optn2' => 'Othello',
                'optn3' => 'Hamlet',
                'optn4' => 'King Lear',
                'optn5' => null,
                'rightAns' => 3,
                'mark' => '1.00',
                'negativeMark' => '0.25',
                'writeAnsDes' => 'This famous philosophical soliloquy is delivered by Prince Hamlet in William Shakespeare\'s tragedy "Hamlet" (Act III, Scene 1).',
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Exam 4 (Bank Math & Analytical)
            [
                'examID' => 4,
                'questions' => 'If a worker takes 6 hours to finish a job and another worker takes 12 hours, how long will they take working together?',
                'optn1' => '3 hours',
                'optn2' => '4 hours',
                'optn3' => '5 hours',
                'optn4' => '4.5 hours',
                'optn5' => null,
                'rightAns' => 2,
                'mark' => '1.00',
                'negativeMark' => '0.25',
                'writeAnsDes' => 'Together in 1 hour: 1/6 + 1/12 = 3/12 = 1/4 of the job. Hence, the total time required together is 4 hours.',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'examID' => 4,
                'questions' => 'What is the sum of the interior angles of a hexagon?',
                'optn1' => '540°',
                'optn2' => '720°',
                'optn3' => '360°',
                'optn4' => '900°',
                'optn5' => null,
                'rightAns' => 2,
                'mark' => '1.00',
                'negativeMark' => '0.25',
                'writeAnsDes' => 'Formula for sum of interior angles: (n - 2) × 180°. For a hexagon (n = 6): (6 - 2) × 180° = 4 × 180° = 720°.',
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Exam 6 (Primary Teacher Model Test)
            [
                'examID' => 6,
                'questions' => 'বাংলা বর্ণমালায় অর্ধমাত্রা বর্ণ কয়টি?',
                'optn1' => '১০টি',
                'optn2' => '৮টি',
                'optn3' => '৩২টি',
                'optn4' => '৬টি',
                'optn5' => null,
                'rightAns' => 2,
                'mark' => '1.00',
                'negativeMark' => '0.25',
                'writeAnsDes' => 'বাংলা বর্ণমালায় মোট অর্ধমাত্রা বর্ণ ৮টি (স্বরে ১টি: ঋ, ব্যঞ্জনে ৭টি: খ, গ, ণ, থ, ধ, প, শ)। পূর্ণমাত্রা বর্ণ ৩২টি এবং মাত্রাহীন বর্ণ ১০টি।',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'examID' => 6,
                'questions' => '‘সন্ধি’ ব্যাকরণের কোন অংশের আলোচ্য বিষয়?',
                'optn1' => 'রূপতত্ত্ব',
                'optn2' => 'ধ্বনিতত্ত্ব',
                'optn3' => 'বাক্যতত্ত্ব',
                'optn4' => 'অর্থতত্ত্ব',
                'optn5' => null,
                'rightAns' => 2,
                'mark' => '1.00',
                'negativeMark' => '0.25',
                'writeAnsDes' => 'সন্ধি হলো পাশাপাশি দুটি ধ্বনির মিলন। ধ্বনির মিলনের ফলে ধ্বনির পরিবর্তন ঘটে, তাই সন্ধি ব্যাকরণের ধ্বনিতত্ত্বে (Phonology) আলোচিত হয়।',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        DB::table('mcq_questions')->insert($mcqQuestions);

        // 8. Populate Written Questions (`written_questions`)
        $writtenQuestions = [
            [
                'examID' => 3,
                'questions' => 'বঙ্গবন্ধু শেখ মুজিবুর রহমান এবং মুক্তিযুদ্ধের ঐতিহাসিক চেতনা শীর্ষক ৩০০ শব্দের একটি সুসংগঠিত প্রবন্ধ রচনা করুন।',
                'mark' => '15.00',
                'ans' => 'ভূমিকা, ঐতিহাসিক প্রেক্ষাপট, ৭ই মার্চের ভাষণ, মুক্তিযুদ্ধের নেতৃত্ব, আন্তর্জাতিক প্রভাব এবং উপসংহার অন্তর্ভুক্ত করতে হবে।',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'examID' => 3,
                'questions' => 'Translate the following into Bengali: "Education is the most powerful weapon which you can use to change the world. It enlightens the human soul and eradicates darkness."',
                'mark' => '10.00',
                'ans' => 'বঙ্গানুবাদ: "শিক্ষা হলো সবচেয়ে শক্তিশালী হাতিয়ার যা দিয়ে আপনি বিশ্বকে বদলে দিতে পারেন। এটি মানব আত্মাকে আলোকিত করে এবং অজ্ঞতার অন্ধকার দূর করে।"',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'examID' => 5,
                'questions' => 'Write an analytical essay on "Challenges and Prospects of Cashless & Digital Banking in Bangladesh".',
                'mark' => '20.00',
                'ans' => 'Key focus points: FinTech adoption, cybersecurity challenges, financial inclusion, Bangla QR, and regulatory frameworks.',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        DB::table('written_questions')->insert($writtenQuestions);

        // 9. Populate Course Categories (`course_categories`)
        $courseCategories = [
            [
                'id' => 1,
                'name' => 'বিসিএস প্রিলিমিনারি ও লিখিত স্পেশাল ব্যাচ',
                'url' => 'bcs-comprehensive-master-course',
                'image' => 'images/bcs_prep.jpg',
                'rank' => 1,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'name' => 'সমন্বিত ব্যাংক অফিসার ক্যারিয়ার প্রোগ্রাম',
                'url' => 'combined-bank-recruitment-course',
                'image' => 'images/bank_prep.jpg',
                'rank' => 2,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'name' => 'প্রাথমিক সহকারী শিক্ষক চূড়ান্ত ক্র্যাশ কোর্স',
                'url' => 'primary-teacher-crash-course',
                'image' => 'images/primary_prep.jpg',
                'rank' => 3,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'name' => '১৮তম শিক্ষক নিবন্ধন (NTRCA) প্রস্তুতি ব্যাচ',
                'url' => 'ntrca-registration-prep-batch',
                'image' => 'images/ntrca_prep.jpg',
                'rank' => 4,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 5,
                'name' => 'মন্ত্রণালয় ও সরকারি নন-ক্যাডার ফাউন্ডেশন কোর্স',
                'url' => 'ministry-and-non-cadre-course',
                'image' => 'images/govt_job_prep.jpg',
                'rank' => 5,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        DB::table('course_categories')->insert($courseCategories);

        // 10. Populate Courses (`courses`)
        $coursesData = [
            [
                'id' => 1,
                'catID' => '1',
                'name' => '৪৬তম ও ৪৭তম বিসিএস কমপ্লিট প্রিলি ও রিটেন মাস্টারকোর্স',
                'price' => 2500,
                'image' => 'images/bcs_prep.jpg',
                'description' => '১০টি বিষয়ের সম্পূর্ণ সিলেবাস কাভারেজ, ১২০+ লাইভ ক্লাস, ৫০টি বিষয়ভিত্তিক ও পূর্ণাঙ্গ মডেল টেস্ট, লেকচার শিট এবং ক্যাডার মেন্টরদের নিয়মিত গাইডলাইন।',
                'rank' => 1,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'catID' => '2',
                'name' => 'ব্যাংক জবস ম্যাথ, অ্যানালিটিক্যাল ও ইংলিশ স্পেশাল প্রোগ্রাম',
                'price' => 1800,
                'image' => 'images/bank_prep.jpg',
                'description' => 'বাংলাদেশ ব্যাংক ও সমন্বিত সরকারি ব্যাংকের জন্য গণিত ও রিজনিংয়ের শর্টকাট টেকনিক, ফোকাস রাইটিং ও অনুবাদ মাস্টারক্লাস।',
                'rank' => 2,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'catID' => '3',
                'name' => 'প্রাথমিক শিক্ষক নিয়োগ শেষ মুহূর্তের চূড়ান্ত রিভিশন ব্যাচ',
                'price' => 1200,
                'image' => 'images/primary_prep.jpg',
                'description' => '৮০ নম্বরের টার্গেট প্রস্তুতি, বিগত ১০ বছরের প্রশ্নব্যাংক সমাধান, ২০টি ওএমআর লাইভ পরীক্ষা ও সাজেস্টিভ হ্যান্ডনোট।',
                'rank' => 3,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'catID' => '4',
                'name' => '১৮তম NTRCA শিক্ষক নিবন্ধন (স্কুল ও কলেজ) পূর্ণাঙ্গ কোর্স',
                'price' => 1500,
                'image' => 'images/ntrca_prep.jpg',
                'description' => '১০০ নম্বরের প্রিলিমিনারি সিলেবাস সম্পূর্ণ প্রস্তুতি, বিষয়ভিত্তিক স্পেশাল ক্লাস ও নিয়মিত সাপ্তাহিক মডেল টেস্ট।',
                'rank' => 4,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 5,
                'catID' => '5',
                'name' => 'সরকারি চাকরি ইংরেজি ও গণিত ফাউন্ডেশন বুটক্যাম্প',
                'price' => 1600,
                'image' => 'images/govt_job_prep.jpg',
                'description' => 'বেসিক থেকে অ্যাডভান্সড ইংরেজি গ্রামার, ভোকাবুলারি মনে রাখার বৈজ্ঞানিক উপায় এবং দ্রুত গণিত সমাধানের কৌশল।',
                'rank' => 5,
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        DB::table('courses')->insert($coursesData);

        // 11. Populate Course Modules (`course_modules`)
        $courseModules = [
            [
                'course_id' => 1,
                'title' => 'লেকচার ০১: বাংলা ভাষা ও সাহিত্যের প্রাচীন ও মধ্যযুগ (চর্যাপদ ও মঙ্গলকাব্য)',
                'link' => 'https://www.youtube.com/embed/ScMzIvxBSi4',
                'free_paid' => 'free',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'course_id' => 1,
                'title' => 'লেকচার ০২: বাংলা ব্যাকরণ - ধ্বনিতত্ত্ব, ন-ত্ব ও ষ-ত্ব বিধান এবং সন্ধি',
                'link' => 'https://www.youtube.com/embed/ScMzIvxBSi4',
                'free_paid' => 'free',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'course_id' => 1,
                'title' => 'লেকচার ০৩: English Literature - Elizabethan & Romantic Period Masterclass',
                'link' => 'https://www.youtube.com/embed/ScMzIvxBSi4',
                'free_paid' => 'paid',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'course_id' => 1,
                'title' => 'লেকচার ০৪: সাধারণ গণিত - শতকরা, অনুপাত ও লাভ-ক্ষতির স্পেশাল শর্টকাট',
                'link' => 'https://www.youtube.com/embed/ScMzIvxBSi4',
                'free_paid' => 'paid',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'course_id' => 2,
                'title' => 'Module 01: Banking Mathematics - Speed Math & Percentage Word Problems',
                'link' => 'https://www.youtube.com/embed/ScMzIvxBSi4',
                'free_paid' => 'free',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'course_id' => 2,
                'title' => 'Module 02: Analytical Reasoning & Critical Thinking Puzzle Mastery',
                'link' => 'https://www.youtube.com/embed/ScMzIvxBSi4',
                'free_paid' => 'paid',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'course_id' => 3,
                'title' => 'লেকচার ০১: প্রাথমিক শিক্ষক নিয়োগ - বিগত বছরের প্রশ্ন বিশ্লেষণ ও প্রস্তুতি গাইড',
                'link' => 'https://www.youtube.com/embed/ScMzIvxBSi4',
                'free_paid' => 'free',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        DB::table('course_modules')->insert($courseModules);

        // 12. Populate Teachers / Mentors (`teachers`)
        $teachersData = [
            [
                'id' => 1,
                'name' => 'মেহেদী হাসান',
                'subject' => 'বাংলা ভাষা ও সাহিত্য',
                'job_title' => '৪১তম বিসিএস (প্রশাসন ক্যাডার), ৫ম মেধা স্থান',
                'image' => 'frontend/assets/images/team/team-01.jpg',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'name' => 'নুসরাত জাহান',
                'subject' => 'ইংরেজি ভাষা ও সাহিত্য',
                'job_title' => 'সিনিয়র অফিসার, বাংলাদেশ ব্যাংক (১২তম মেধা স্থান)',
                'image' => 'frontend/assets/images/team/team-02.jpg',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 3,
                'name' => 'ড. তারিকুল ইসলাম',
                'subject' => 'আন্তর্জাতিক ও ভূরাজনীতি',
                'job_title' => 'সহযোগী অধ্যাপক, ঢাকা বিশ্ববিদ্যালয়',
                'image' => 'frontend/assets/images/team/team-03.jpg',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 4,
                'name' => 'তানভীর আহমেদ',
                'subject' => 'গণিত ও মানসিক দক্ষতা',
                'job_title' => 'বিসিএস ও ব্যাংক জবস স্পেশালিস্ট (১০ বছরের অভিজ্ঞতা)',
                'image' => 'frontend/assets/images/team/team-04.jpg',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        DB::table('teachers')->insert($teachersData);

        // 13. Populate Blogs (`blogs`)
        $blogsData = [
            [
                'language' => 'bangla',
                'title' => '৪৬তম বিসিএস প্রিলিমিনারি পরীক্ষায় ২০০ নম্বরের নিখুঁত টাইম ম্যানেজমেন্ট কৌশল',
                'url' => 'bcs-preliminary-time-management-strategy',
                'image' => 'images/bcs_prep.jpg',
                'alt' => 'BCS Preliminary Strategy',
                'description' => '<p>বিসিএস প্রিলিমিনারি পরীক্ষায় সফল হওয়ার মূল চাবিকাঠি হলো দুই ঘণ্টার ১২০ মিনিটের নিখুঁত সদ্ব্যবহার। প্রতিটি প্রশ্নের পেছনে সর্বোচ্চ ৩৬ সেকেন্ড সময় বরাদ্দ থাকে। শুরুতে বাংলা ও সাধারণ জ্ঞান অংশের নিশ্চিত উত্তরগুলো ওএমআরে পূরণ করে নিলে পরবর্তী সময়ে গণিত ও ইংরেজি অংশে আত্মবিশ্বাস বহুগুণ বেড়ে যায়।</p><p>নেগেটিভ মার্কিং এড়াতে দ্বিধাগ্রস্ত উত্তর এড়িয়ে চলা এবং নিয়মিত ওএমআর শিটে ফুল মডেল টেস্ট অনুশীলনের কোনো বিকল্প নেই।</p>',
                'meta_title' => '৪৬তম বিসিএস প্রিলিমিনারি টাইম ম্যানেজমেন্ট গাইড',
                'meta_description' => 'বিসিএস প্রিলিমিনারি পরীক্ষায় সর্বোচ্চ নম্বর নিশ্চিত করার পরীক্ষিত কৌশল ও সময় বণ্টন।',
                'author' => 'মেহেদী হাসান (বিসিএস প্রশাসন)',
                'date' => '2026-10-15',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'language' => 'bangla',
                'title' => 'ব্যাংক নিয়োগ পরীক্ষায় গণিত ও অ্যানালিটিক্যাল রিজনিংয়ে ফুল মার্কস পাওয়ার উপায়',
                'url' => 'bank-job-math-and-analytical-mastery',
                'image' => 'images/bank_prep.jpg',
                'alt' => 'Bank Job Math Preparation',
                'description' => '<p>সমন্বিত ব্যাংক এবং বাংলাদেশ ব্যাংকের নিয়োগ পরীক্ষায় গণিত এবং অ্যানালিটিক্যাল অংশই মেধা তালিকার মূল নির্ধারক। গতানুগতিক বড় সমাধান পদ্ধতির পরিবর্তে বৈজ্ঞানিক শর্টকাট সূত্র, অপশন টেস্ট মেথড এবং নিয়মিত মেন্টাল অ্যালগরিদম প্র্যাকটিস করতে হবে।</p><p>প্রতিদিন অন্তত ২৫টি করে ডিফারেন্ট টাইপের ওয়ার্ড প্রবলেম সমাধানের অভ্যাস গড়ে তুলুন।</p>',
                'meta_title' => 'ব্যাংক পরীক্ষা গণিত প্রস্তুতি গাইড',
                'meta_description' => 'ব্যাংকিং পরীক্ষায় গণিতে সর্বোচ্চ মার্ক পাওয়ার উপায়।',
                'author' => 'নুসরাত জাহান (বাংলাদেশ ব্যাংক)',
                'date' => '2026-10-12',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'language' => 'english',
                'title' => 'Mastering English Vocabulary and Idioms for Competitive BCS & Bank Exams',
                'url' => 'mastering-english-vocabulary-competitive-exams',
                'image' => 'images/ntrca_prep.jpg',
                'alt' => 'English Vocabulary Strategy',
                'description' => '<p>Vocabulary retention requires contextual learning rather than rote memorization. Candidates should focus on high-frequency GRE words, root words, prefixes, and suffixes. Reading quality English editorials daily and practicing previous ten-year question papers builds intuitive grammatical accuracy.</p>',
                'meta_title' => 'Mastering English Vocabulary for Competitive Exams',
                'meta_description' => 'High yield strategies for BCS and Bank job English literature and grammar.',
                'author' => 'Prof. Tariqul Islam',
                'date' => '2026-10-10',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        DB::table('blogs')->insert($blogsData);

        try {
            DB::statement('ALTER TABLE notice CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        } catch (\Exception $e) {
            // ignore if already converted
        }

        // 14. Populate Notice Board (`notice`)
        $notices = [
            [
                'title' => '[লাইভ মডেল টেস্ট] ৪৬তম বিসিএস স্পেশাল মেগা লাইভ মডেল টেস্ট আগামী শুক্রবার রাত ৮:০০ টায় অনুষ্ঠিত হবে।',
                'active' => 1,
                'date' => $now
            ],
            [
                'title' => '[লেকচার শিট] প্রাথমিক শিক্ষক নিয়োগ ব্যাচের ৩য় সপ্তাহের গণিত লেকচার শিট ও ওএমআর সমাধান আপলোড করা হয়েছে।',
                'active' => 1,
                'date' => $now
            ],
            [
                'title' => '[ফলাফল প্রকাশ] সমন্বিত ১০ ব্যাংক সিনিয়র অফিসার লিখিত পরীক্ষার অ্যানালিটিক্যাল রেজাল্ট ও মেধা তালিকা প্রকাশিত হয়েছে।',
                'active' => 1,
                'date' => $now
            ],
            [
                'title' => '[ফ্রি ক্যারিয়ার সেমিনার] ১৮তম শিক্ষক নিবন্ধন (NTRCA) স্পেশাল জুম সেমিনার আগামী রবিবার সন্ধ্যা ৭:০০ টায় অনুষ্ঠিত হবে।',
                'active' => 1,
                'date' => $now
            ]
        ];
        DB::table('notice')->insert($notices);

        // 15. Populate Sliders & Banners
        $sliderInfoId = DB::table('slider_infos')->insertGetId([
            'title' => 'বিসিএস ও সরকারি চাকরি নিশ্চিত প্রস্তুতি ২০২৬',
            'description' => 'অভিজ্ঞ ক্যাডার ও ব্যাংক কর্মকর্তাদের প্রত্যক্ষ দিকনির্দেশনায় লাইভ মডেল টেস্ট ও ভিডিও লেকচার।',
            'active' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('slider_images')->insert([
            [
                'slider_info_id' => $sliderInfoId,
                'image' => 'images/bcs_prep.jpg',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slider_info_id' => $sliderInfoId,
                'image' => 'images/bank_prep.jpg',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'slider_info_id' => $sliderInfoId,
                'image' => 'images/primary_prep.jpg',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        DB::table('slider_banners')->insert([
            [
                'title' => 'বিসিএস প্রিলিমিনারি ও লিখিত স্পেশাল প্রস্তুতি',
                'alt' => '৪৬তম ও ৪৭তম বিসিএস পরীক্ষার জন্য পূর্ণাঙ্গ সিলেবাসভিত্তিক লাইভ ক্লাস ও রিয়েল-টাইম মডেল টেস্ট।',
                'image' => 'images/bcs_prep.jpg',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => 'সমন্বিত ১০ ব্যাংক অফিসার ও সিনিয়র অফিসার',
                'alt' => 'বাংলাদেশ ব্যাংক ও রাষ্ট্রায়ত্ত ব্যাংকের সমন্বিত নিয়োগ পরীক্ষার স্পেশাল ম্যাথ, অ্যানালিটিক্যাল ও মডেল টেস্ট।',
                'image' => 'images/bank_prep.jpg',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => 'প্রাথমিক সহকারী শিক্ষক ও NTRCA নিবন্ধন প্রস্তুতি',
                'alt' => 'অধ্যায়ভিত্তিক প্র্যাকটিস, পূর্ণাঙ্গ প্রশ্নব্যাংক ও অভিজ্ঞ মেন্টরদের নিবিড় তত্ত্বাবধানে প্রস্তুতি।',
                'image' => 'images/primary_prep.jpg',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => 'মন্ত্রণালয় ও নন-ক্যাডার সরকারি চাকরি প্রস্তুতি',
                'alt' => '১০ম থেকে ২০তম গ্রেডের সকল সরকারি চাকরির বিগত বছরের প্রশ্ন সমাধান ও ধারাবাহিক লাইভ পরীক্ষা।',
                'image' => 'images/govt_job_prep.jpg',
                'active' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // 16. Populate Sample Student Orders & Exam Results
        // Course Enrollment for student (ID: $studentId, course: 1)
        DB::table('courses_order')->insert([
            [
                'pid' => 1,
                'price' => '2500',
                'orderNum' => 'ORD-BCS-' . rand(10000, 99999),
                'transaction_id' => 'TXN' . rand(10000000, 99999999),
                'name' => 'Ridoy Paul',
                'email' => 'mesba@gmail.com',
                'phone' => '01712345678',
                'address' => 'Dhanmondi, Dhaka',
                'currency' => 'BDT',
                'amount' => 2500.00,
                'date' => $now->format('Y-m-d H:i:s'),
                'status' => 'Complete',
                'course_id' => 1,
                'user_id' => $studentId,
                'payment_status' => 'paid'
            ],
            [
                'pid' => 2,
                'price' => '1800',
                'orderNum' => 'ORD-BNK-' . rand(10000, 99999),
                'transaction_id' => 'TXN' . rand(10000000, 99999999),
                'name' => 'Ridoy Paul',
                'email' => 'mesba@gmail.com',
                'phone' => '01712345678',
                'address' => 'Dhanmondi, Dhaka',
                'currency' => 'BDT',
                'amount' => 1800.00,
                'date' => $now->subDays(2)->format('Y-m-d H:i:s'),
                'status' => 'Complete',
                'course_id' => 2,
                'user_id' => $studentId,
                'payment_status' => 'paid'
            ]
        ]);

        // Sample Results for Student
        $resId1 = DB::table('results')->insertGetId([
            'examID' => 1,
            'userID' => $studentId,
            'mcq_written' => 'mcq',
            'written_status' => null,
            'created_at' => $now->subDays(1),
            'updated_at' => $now->subDays(1)
        ]);

        $parentId1 = DB::table('mcq_results_parents')->insertGetId([
            'examID' => '1',
            'userID' => (string)$studentId,
            'created_at' => $now->subDays(1),
            'updated_at' => $now->subDays(1)
        ]);

        // Seed 3 answered questions for Exam 1
        $questions = DB::table('mcq_questions')->where('examID', 1)->get();
        foreach ($questions as $q) {
            DB::table('mcq_results')->insert([
                'examID' => 1,
                'userID' => $studentId,
                'qid' => $q->id,
                'userAns' => $q->rightAns, // Answered correctly
                'rightAns' => $q->rightAns,
                'mark' => '1.00',
                'obtained_mark' => '1.00',
                'negativeMark' => '0.25',
                'mcq_results_parent_id' => (string)$parentId1,
                'created_at' => $now->subDays(1),
                'updated_at' => $now->subDays(1)
            ]);
        }

        // Written exam result
        DB::table('results')->insert([
            'examID' => 3,
            'userID' => $studentId,
            'mcq_written' => 'written',
            'written_status' => 'checked',
            'created_at' => $now->subDays(2),
            'updated_at' => $now->subDays(1)
        ]);

        $wq = DB::table('written_questions')->where('examID', 3)->first();
        if ($wq) {
            DB::table('written_results')->insert([
                'examID' => 3,
                'userID' => $studentId,
                'qid' => $wq->id,
                'userAns' => 'Student uploaded answer script: বঙ্গবন্ধুর ৭ই মার্চের ভাষণ এবং মহান মুক্তিযুদ্ধের পটভূমি...',
                'mark' => '15.00',
                'rightansMark' => '13.50',
                'note' => 'অসাধারণ গঠনমূলক লেখা ও ঐতিহাসিক তথ্য নির্ভুল উপস্থাপন। বঙ্গানুবাদ অংশটিও প্রশংসনীয়।',
                'created_at' => $now->subDays(2),
                'updated_at' => $now->subDays(1)
            ]);
        }

        // 17. Populate About Us Information
        $aboutHtml = '
<p class="lead mb-4" style="font-size: 17px; font-weight: 600; color: #0f172a; line-height: 1.8;">
পাঠজল্পনা (Pathjolpona Education) বাংলাদেশের একটি সর্বাধুনিক ও প্রযুক্তিভিত্তিক বিশেষায়িত ক্যারিয়ার প্রস্তুতি প্ল্যাটফর্ম। বিসিএস, ব্যাংক, প্রাথমিক শিক্ষক নিয়োগ ও সকল সরকারি চাকরির জন্য এটি দেশের প্রথমসারির পূর্ণাঙ্গ ডিজিটাল একাডেমি।
</p>

<p style="margin-bottom: 16px; color: #334155; line-height: 1.8;">
২০২১ সালে প্রতিষ্ঠিত পাঠজল্পনার মূল দর্শন হলো দেশের প্রত্যন্ত অঞ্চলের প্রতিটি শিক্ষার্থীর কাছে নামমাত্র মূল্যে সেরা বিসিএস ক্যাডার ও ব্যাংকারদের প্রত্যক্ষ গাইডলাইন পৌঁছে দেওয়া। গতানুগতিক কোচিং বা গাইড বইয়ের মুখস্থবিদ্যার বাইরে এসে আমরা শিক্ষার্থীদের প্রদান করি বাস্তবমুখী ওএমআর (OMR) সিমুলেশন, নির্ভুল নেগেটিভ মার্কিং এবং প্রতিটি পরীক্ষার পরই স্বয়ংক্রিয় মেধা তালিকা।
</p>

<div class="row g-3 my-4">
    <div class="col-sm-6 col-12">
        <div class="p-3 rounded-3" style="background: #f8fafc; border-left: 4px solid #03c6bb;">
            <h6 style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">লাইভ ওএমআর টেস্ট ইঞ্জিন</h6>
            <p style="font-size: 13px; color: #64748b; margin: 0;">প্রকৃত বিসিএস পরীক্ষার মতো ঘড়ি ধরে লাইভ পরীক্ষা ও নেগেটিভ মার্কিং গণনা।</p>
        </div>
    </div>
    <div class="col-sm-6 col-12">
        <div class="p-3 rounded-3" style="background: #f8fafc; border-left: 4px solid #4f46e5;">
            <h6 style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">ক্যাডার ও ব্যাংকারদের মেন্টরশিপ</h6>
            <p style="font-size: 13px; color: #64748b; margin: 0;">বিসিএস প্রশাসন, পুলিশ ক্যাডার ও বাংলাদেশ ব্যাংকের সিনিয়র কর্মকর্তাদের নিয়মিত ক্লাস।</p>
        </div>
    </div>
</div>

<p style="margin-bottom: 16px; color: #334155; line-height: 1.8;">
আমাদের বিশেষায়িত প্রশ্নব্যাংক প্রতিনিয়ত পিএসসি (BPSC) ও ব্যাংকার্স সিলেকশন কমিটির (BSCC) সর্বশেষ সিলেবাস ও প্রশ্নের প্যাটার্ন অনুযায়ী আপডেট করা হয়। লিখিত পরীক্ষার জন্য রয়েছে বিশেষ উত্তরপত্র মূল্যায়ন এবং ওয়ান-অন-ওয়ান ফিডব্যাক ব্যবস্থা।
</p>';

        DB::table('about_infos')->insert([
            'aboutDes' => $aboutHtml,
            'image' => 'images/about_pathjolpona.jpg',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('abouts')->insert([
            'title_english' => 'Pathjolpona Education',
            'title_bangla' => 'পাঠজল্পনা - ক্যারিয়ার ও বিসিএস প্রস্তুতি',
            'details_1_eng' => '<p>Pathjolpona is a premier EdTech platform providing comprehensive mock exams, video modules, and mentorship for BCS, Bank, Primary, and NTRCA examinations.</p>',
            'details_1_bng' => $aboutHtml,
            'main_image' => 'images/about_pathjolpona.jpg',
            'banner_image' => 'images/about_pathjolpona.jpg',
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
