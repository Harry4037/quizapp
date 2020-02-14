<?php

use Illuminate\Database\Seeder;

class QuestionExamTableSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

        for ($i = 1; $i <= 11; $i++) {
            DB::table('question_exams')->insert([
                'exam_id' => 1,
                'question_id' => $i
            ]);
        }
        for ($i = 12; $i <= 22; $i++) {
            DB::table('question_exams')->insert([
                'exam_id' => 2,
                'question_id' => $i
            ]);
        }

        //testseries
        DB::table('question_exams')->insert([
            'exam_id' => 1,
            'question_id' => 25
        ]);
        DB::table('question_exams')->insert([
            'exam_id' => 1,
            'question_id' => 26
        ]);
    }

}
