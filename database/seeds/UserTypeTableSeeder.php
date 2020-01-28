<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserTypeTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $userTypeArray = ["Admin", "Creator", "User"];
        foreach ($userTypeArray as $userType) {
            DB::table('user_types')->insert([
                'description' => $userType,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }

}
