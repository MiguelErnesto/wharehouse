<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Disable foreign key checks for current db driver
        //SET foreign_key_checks = 0   //MYSQL
        DB::statement('PRAGMA foreign_keys = ON;');
        DB::table('categories')->truncate();

        $categories = ['frameworks', 'php', 'javascript', 'python'];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }

        //Enable foreign key checks for current db driver
        //SET foreign_key_checks = 1 //MYSQL
        DB::statement('PRAGMA foreign_keys = OFF;');
    }
}
