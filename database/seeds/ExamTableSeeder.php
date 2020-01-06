<?php

use Illuminate\Database\Seeder;

class ExamTableSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $examArray = ["SSC", "RBI"];
        foreach ($examArray as $exam) {
            DB::table('exams')->insert([
                'name' => $exam,
            ]);
        }

        DB::table('subjects')->insert([
            'name' => "English",
        ]);
        DB::table('subjects')->insert([
            'name' => "Maths",
        ]);
        DB::table('subjects')->insert([
            'name' => "Hindi",
        ]);
        DB::table('subjects')->insert([
            'name' => "Gen. knowledge",
        ]);
    }

}
