<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class QuizTableSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

        DB::table('quizzes')->insert([
            'user_id' => 1,
            'name' => 'SSC Quiz',
            'total_questions' => 2,
            'lang' => 1,
            'start_date_time' => Carbon::now(),
            'end_date_time' => Carbon::now()->add("1 hours"),
        ]);
        DB::table('questions')->insert([
            'user_id' => 1,
            'exam_id' => 0,
            'subject_id' => 0,
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
            'ques_image' => " ",
            'ques_time' => 20,
            'quiz_id' => 1,
            'test_series_id' => 0,
            'lang' => 1,
        ]);
        DB::table('questions')->insert([
            'user_id' => 1,
            'exam_id' => 0,
            'subject_id' => 0,
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
            'ques_image' => " ",
            'ques_time' => 20,
            'quiz_id' => 1,
            'test_series_id' => 0,
            'lang' => 1,
        ]);
    }

}
