<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserTableSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

        DB::table('users')->insert([
            'name' => "Admin",
            'email' => "admin@mail.com",
            'password' => bcrypt("123456"),
            'user_type_id' => 1,
            'dob' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'name' => "Ankit_user",
            'email' => "ankit@mail.com",
            'password' => bcrypt("123456"),
            'otp' => 1234,
            'user_type_id' => 2,
            'dob' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('users')->insert([
            'name' => "Ankit_creator",
            'email' => "ankit_creator@mail.com",
            'password' => bcrypt("123456"),
            'otp' => 1234,
            'user_type_id' => 3,
            'dob' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

}
