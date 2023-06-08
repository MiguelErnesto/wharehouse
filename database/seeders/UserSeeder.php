<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
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
        DB::table('users')->truncate();

        User::create([
            'name' => 'Javier Hernandez',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('admin');

        User::factory(9)->create();

        //Enable foreign key checks for current db driver
        //SET foreign_key_checks = 1 //MYSQL
        DB::statement('PRAGMA foreign_keys = OFF;');
    }
}
