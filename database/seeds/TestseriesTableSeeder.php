<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TestseriesTableSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

        DB::table('test_series')->insert([
            'user_id' => 1,
            'exam_id' => 1,
            'subject_id' => 1,
            'name' => 'Testing Test Series',
            'total_question' => 2,
            'is_approve' => 2,
            'lang' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('questions')->insert([
            'user_id' => 1,
            'exam_id' => 1,
            'subject_id' => 1,
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
            'ques_image' => " ",
            'ques_time' => 60,
            'quiz_id' => 0,
            'test_series_id' => 1,
            'lang' => 1,
            'is_approve' => 2,
        ]);
        DB::table('questions')->insert([
            'user_id' => 1,
            'exam_id' => 1,
            'subject_id' => 1,
            'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
            'ques_image' => " ",
            'ques_time' => 60,
            'quiz_id' => 0,
            'test_series_id' => 1,
            'lang' => 1,
            'is_approve' => 2,
        ]);
    }

}
