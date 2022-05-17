<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class pagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = ['Hakkımızda','Kariyer','Vizyon','Misyon'];
        $faker = Faker::create();
        $count = 0;
     foreach ($pages as $page) {
         $count++;
        DB::table('pages')->insert([
            'title' => $page,
            'image' => $faker->imageUrl(500,500,'cats'),
            'content' => $faker->text(),
            'slug' => Str::slug($page),
            'order' => $count,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()

           ]);
     }
    }
}
