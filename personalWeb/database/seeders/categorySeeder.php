<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryArray = array("Web", "Mobile", "Certificate");
        foreach ($categoryArray as $part) {
            DB::table('categories')->insert([
                'Category' => $part,
            ]);
        }
    }
}