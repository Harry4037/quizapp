<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(ExamTableSeeder::class);
         $this->call(QuestionTableSeeder::class);
         $this->call(AnswerTableSeeder::class);
    }
}