<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class adminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            "name" => "Furkan Genç",
            "email" => "1@g",
            "password" => bcrypt(102030),
        ]);
    }
}
