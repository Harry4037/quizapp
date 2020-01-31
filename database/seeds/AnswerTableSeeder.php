<?php

use Illuminate\Database\Seeder;

class AnswerTableSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

        for ($i = 1; $i <= 24; $i++) {
            DB::table('answers')->insert([
                'question_id' => $i,
                'is_answer' => 0,
                'description' => "Lorem Ipsum.",
            ]);
            DB::table('answers')->insert([
                'question_id' => $i,
                'is_answer' => 0,
                'description' => "Lorem Ipsum.",
            ]);
            DB::table('answers')->insert([
                'question_id' => $i,
                'is_answer' => 0,
                'description' => "Lorem Ipsum.",
            ]);
            DB::table('answers')->insert([
                'question_id' => $i,
                'is_answer' => 1,
                'description' => "Lorem Ipsum.",
            ]);
        }
    }

}
