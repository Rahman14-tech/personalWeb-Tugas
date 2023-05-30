<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PortfoliosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        for ($i = 0; $i <= 10; $i++) {
            Portfolio::create([
                'image_file_route' => "post-images/V4a06xmQ8Pmo2S8T4y2CnepqNwORXHPabDJIjEvy.jpg",
                'title' => $faker->name,
                'description' => $faker->address,
                'category_id' => 1,
            ]);
        }
    }
}