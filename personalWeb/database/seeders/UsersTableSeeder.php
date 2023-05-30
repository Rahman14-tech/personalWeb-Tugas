<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // User::create([
        //     'name'=>"Muhammad Akbar Rahman",
        //     'email'=> 'tapole13@gmail.com',
        //     'password'=> Hash::make('123qwerty')
        // ]);
        Category::create([
            'Category'=> 'Community Services'
        ]);
    }
}
