<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'Teknologi',
            ],
            [
                'id' => 2,
                'name' => 'Bisnis',
            ],
            [
                'id' => 3,
                'name' => 'Hiburan',
            ],
            [
                'id' => 4,
                'name' => 'Kesehatan',
            ],
            [
                'id' => 5,
                'name' => 'Olahraga',
            ],
        ];
    }
}
