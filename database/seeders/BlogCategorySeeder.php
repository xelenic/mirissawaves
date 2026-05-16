<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Travel Tips',
                'slug' => 'travel-tips',
                'description' => 'Essential travel tips and advice for exploring Sri Lanka',
                'color' => '#3B82F6',
                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Cultural Heritage',
                'slug' => 'cultural-heritage',
                'description' => 'Discover Sri Lanka\'s rich cultural heritage and traditions',
                'color' => '#8B5CF6',
                'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Wildlife & Nature',
                'slug' => 'wildlife-nature',
                'description' => 'Explore Sri Lanka\'s incredible wildlife and natural beauty',
                'color' => '#10B981',
                'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Adventure & Activities',
                'slug' => 'adventure-activities',
                'description' => 'Thrilling adventures and exciting activities in Sri Lanka',
                'color' => '#F59E0B',
                'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Food & Cuisine',
                'slug' => 'food-cuisine',
                'description' => 'Taste the authentic flavors of Sri Lankan cuisine',
                'color' => '#EF4444',
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}