<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Disable foreign key checks for current db driver
        //SET foreign_key_checks = 0   //MYSQL
        DB::statement('PRAGMA foreign_keys = ON;');

        Storage::deleteDirectory('public/posts');

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(CategorySeeder::class);

        Tag::factory(8)->create();

        Storage::makeDirectory('public/posts');

        $this->call(PostSeeder::class);

        //Enable foreign key checks for current db driver
        //SET foreign_key_checks = 1 //MYSQL
        DB::statement('PRAGMA foreign_keys = OFF;');
    }
}
