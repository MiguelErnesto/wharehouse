<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PostSeeder extends Seeder
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
        DB::table('posts')->truncate();

        $posts = Post::factory(20)->create();

        foreach ($posts as $post) {
            Image::factory(1)->create([
                'imageable_id' => $post->id,
                'imageable_type' => Post::class,
            ]);
            $post->tags()->attach([rand(1, 4), rand(5, 8)]);
        }

        //Enable foreign key checks for current db driver
        //SET foreign_key_checks = 1 //MYSQL
        DB::statement('PRAGMA foreign_keys = OFF;');
    }
}
