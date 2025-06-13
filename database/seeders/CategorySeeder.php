<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Analysis'],
            ['name' => 'Software Development'],
            ['name' => 'Quality Assurance'],
            ['name' => 'Deployment & Release'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
