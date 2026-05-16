<?php

namespace Database\Seeders;

use App\Models\PackageCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cultural',
                'slug' => 'cultural',
                'description' => 'Explore the rich cultural heritage of Sri Lanka with visits to ancient temples, historical sites, and traditional experiences.',
                'color' => '#8B5CF6',
                'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Wildlife',
                'slug' => 'wildlife',
                'description' => 'Discover Sri Lanka\'s incredible wildlife with safaris, whale watching, and encounters with exotic animals.',
                'color' => '#10B981',
                'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Adventure',
                'slug' => 'adventure',
                'description' => 'Get your adrenaline pumping with exciting adventure activities including hiking, surfing, and outdoor sports.',
                'color' => '#F59E0B',
                'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                'is_active' => true,
                'sort_order' => 3
            ]
        ];

        foreach ($categories as $category) {
            PackageCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
