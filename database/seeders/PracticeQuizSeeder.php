<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PracticeQuiz;
use App\Models\PracticeQuestion;

class PracticeQuizSeeder extends Seeder
{
    public function run()
    {
        $quiz = PracticeQuiz::firstOrCreate(
            ['slug' => 'bcs-bangladesh-affairs-mastery'],
            [
                'title' => 'বিসিএস প্রস্তুতি: বাংলাদেশ বিষয়াবলী (Mastery Practice)',
                'description' => 'এই কুইজে প্রতিটি প্রশ্ন আপনাকে ৪ বার সঠিকভাবে উত্তর দিতে হবে। ভুল উত্তর দিলে সাথে সাথে সঠিক উত্তর ও ব্যাখ্যা দেখতে পাবেন এবং প্রশ্নটি আবার আসবে।',
                'target_repetitions' => 4,
                'is_active' => true,
            ]
        );

        if ($quiz->questions()->count() === 0) {
            PracticeQuestion::create([
                'practice_quiz_id' => $quiz->id,
                'question' => 'মুজিবনগর সরকার কবে শপথ গ্রহণ করে?',
                'optn1' => '১০ এপ্রিল ১৯৭১',
                'optn2' => '১৭ এপ্রিল ১৯৭১',
                'optn3' => '২৫ মার্চ ১৯৭১',
                'optn4' => '১৬ ডিসেম্বর ১৯৭১',
                'right_ans' => 2,
                'explanation' => '১৯৭১ সালের ১০ এপ্রিল মুজিবনগর সরকার গঠিত হয় এবং ১৭ এপ্রিল মেহেরপুরের বৈদ্যনাথতলার আম্রকাননে আনুষ্ঠানিকভাবে শপথ গ্রহণ করে।',
            ]);

            PracticeQuestion::create([
                'practice_quiz_id' => $quiz->id,
                'question' => 'বাংলাদেশের সংবিধানের মূলনীতি কয়টি?',
                'optn1' => '৩টি',
                'optn2' => '৪টি',
                'optn3' => '৫টি',
                'optn4' => '৬টি',
                'right_ans' => 2,
                'explanation' => 'বাংলাদেশের সংবিধানের মূলনীতি ৪টি: জাতীয়তাবাদ, সমাজতন্ত্র, গণতন্ত্র ও ধর্মনিরপেক্ষতা।',
            ]);

            PracticeQuestion::create([
                'practice_quiz_id' => $quiz->id,
                'question' => 'বাংলাদেশের গণপরিষদের প্রথম স্পিকার কে ছিলেন?',
                'optn1' => 'মোহাম্মদ উল্লাহ',
                'optn2' => 'আব্দুল মালেক উকিল',
                'optn3' => 'শাহ আব্দুল হামিদ',
                'optn4' => 'হুমায়ূন রশীদ চৌধুরী',
                'right_ans' => 3,
                'explanation' => 'গণপরিষদের প্রথম স্পিকার ছিলেন শাহ আব্দুল হামিদ এবং প্রথম ডেপুটি স্পিকার ছিলেন মোহাম্মদ উল্লাহ।',
            ]);
        }
    }
}
