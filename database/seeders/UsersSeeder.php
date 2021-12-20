<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => '1',
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'email_verified_at' => null,
                'password' => bcrypt('admin123'),
                'remember_token' => null,
            ]
        ]);
    }
}
