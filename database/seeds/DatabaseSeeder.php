<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(UserTypeTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ExamTableSeeder::class);
        $this->call(QuestionTableSeeder::class);
        $this->call(QuizTableSeeder::class);
        $this->call(TestseriesTableSeeder::class);
        $this->call(QuestionExamTableSeeder::class);
        $this->call(AnswerTableSeeder::class);
    }

}
