<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $culturalCategory = PackageCategory::where('slug', 'cultural')->first();
        $wildlifeCategory = PackageCategory::where('slug', 'wildlife')->first();
        $adventureCategory = PackageCategory::where('slug', 'adventure')->first();

        $packages = [
            [
                'package_category_id' => $culturalCategory->id,
                'title' => 'Sigiriya Heritage Tour',
                'slug' => 'sigiriya-heritage-tour',
                'description' => 'Climb the legendary Lion Rock and discover ancient frescoes dating back to the 5th century. This UNESCO World Heritage Site offers breathtaking views and fascinating history.',
                'short_description' => 'Climb the legendary Lion Rock and discover ancient frescoes',
                'duration' => '1 Day',
                'price' => 89.00,
                'original_price' => 120.00,
                'image' => 'slider/sigiriya_rock.jpg',
                'images' => ['slider/sigiriya_rock.jpg', 'slider/thooth_relic.jpg'],
                'highlights' => ['UNESCO World Heritage Site', 'Ancient frescoes', 'Panoramic views', 'Professional guide', 'Transport included'],
                'rating' => 4.9,
                'reviews_count' => 156,
                'difficulty' => 'Moderate',
                'group_size' => 'Max 12 people',
                'included' => 'Transport, Professional guide, Entrance fees, Lunch, Water',
                'not_included' => 'Personal expenses, Tips, Camera fees',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'package_category_id' => $wildlifeCategory->id,
                'title' => 'Whale Watching Adventure',
                'slug' => 'whale-watching-adventure',
                'description' => 'Experience the thrill of spotting blue whales and dolphins in their natural habitat. Our expert marine biologists will guide you through this unforgettable ocean adventure.',
                'short_description' => 'Experience the thrill of spotting blue whales and dolphins',
                'duration' => 'Half Day',
                'price' => 65.00,
                'original_price' => 85.00,
                'image' => 'slider/whale_watiching.jpg',
                'images' => ['slider/whale_watiching.jpg', 'slider/yala_safari.jpg'],
                'highlights' => ['Blue whale sightings', 'Dolphin encounters', 'Marine biologist guide', 'Safety equipment', 'Refreshments included'],
                'rating' => 4.8,
                'reviews_count' => 203,
                'difficulty' => 'Easy',
                'group_size' => 'Max 20 people',
                'included' => 'Boat trip, Life jackets, Marine biologist guide, Refreshments, Insurance',
                'not_included' => 'Personal items, Tips, Camera rental',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'package_category_id' => $adventureCategory->id,
                'title' => 'Ella Rock Trekking',
                'slug' => 'ella-rock-trekking',
                'description' => 'Hike through lush tea plantations and scenic mountain trails to reach Ella Rock. Enjoy spectacular views of the surrounding countryside and learn about local flora and fauna.',
                'short_description' => 'Hike through lush tea plantations and scenic mountain trails',
                'duration' => '1 Day',
                'price' => 45.00,
                'original_price' => 60.00,
                'image' => 'slider/ella_city_tour.jpg',
                'images' => ['slider/ella_city_tour.jpg', 'slider/arugam_bay.jpg'],
                'highlights' => ['Mountain hiking', 'Tea plantation views', 'Local flora & fauna', 'Professional guide', 'Lunch included'],
                'rating' => 4.7,
                'reviews_count' => 189,
                'difficulty' => 'Moderate',
                'group_size' => 'Max 15 people',
                'included' => 'Professional guide, Lunch, Water, First aid kit, Transport',
                'not_included' => 'Personal gear, Tips, Camera fees',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'package_category_id' => $culturalCategory->id,
                'title' => 'Kandy Cultural Tour',
                'slug' => 'kandy-cultural-tour',
                'description' => 'Explore the cultural heart of Sri Lanka with visits to the Temple of the Sacred Tooth Relic, traditional dance shows, and local markets.',
                'short_description' => 'Explore the cultural heart of Sri Lanka',
                'duration' => '1 Day',
                'price' => 75.00,
                'original_price' => 95.00,
                'image' => 'slider/thooth_relic.jpg',
                'images' => ['slider/thooth_relic.jpg', 'slider/sigiriya_rock.jpg'],
                'highlights' => ['Sacred Tooth Relic Temple', 'Cultural dance show', 'Local market tour', 'Traditional lunch', 'Professional guide'],
                'rating' => 4.8,
                'reviews_count' => 167,
                'difficulty' => 'Easy',
                'group_size' => 'Max 18 people',
                'included' => 'Transport, Guide, Temple entrance, Cultural show, Lunch',
                'not_included' => 'Personal shopping, Tips, Camera fees',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'package_category_id' => $adventureCategory->id,
                'title' => 'Surfing Adventure',
                'slug' => 'surfing-adventure',
                'description' => 'Ride the waves at Arugam Bay, one of the best surfing destinations in Asia. Learn from professional surf instructors and enjoy the perfect beach vibes.',
                'short_description' => 'Ride the waves at Arugam Bay',
                'duration' => '3 Days',
                'price' => 199.00,
                'original_price' => 250.00,
                'image' => 'slider/arugam_bay.jpg',
                'images' => ['slider/arugam_bay.jpg', 'slider/ella_city_tour.jpg'],
                'highlights' => ['Professional surf lessons', 'Equipment rental', 'Beach accommodation', 'Surfboard included', 'Beach activities'],
                'rating' => 4.9,
                'reviews_count' => 134,
                'difficulty' => 'Moderate',
                'group_size' => 'Max 10 people',
                'included' => 'Surf lessons, Equipment, Accommodation, Meals, Transport',
                'not_included' => 'Personal items, Tips, Additional activities',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'package_category_id' => $wildlifeCategory->id,
                'title' => 'Yala Safari Experience',
                'slug' => 'yala-safari-experience',
                'description' => 'Embark on an exciting wildlife safari in Yala National Park to spot leopards, elephants, and exotic birds in their natural habitat.',
                'short_description' => 'Embark on an exciting wildlife safari in Yala National Park',
                'duration' => '2 Days',
                'price' => 149.00,
                'original_price' => 180.00,
                'image' => 'slider/yala_safari.jpg',
                'images' => ['slider/yala_safari.jpg', 'slider/whale_watiching.jpg'],
                'highlights' => ['Leopard sightings', 'Elephant encounters', 'Bird watching', 'Safari vehicle', 'Park entrance fees'],
                'rating' => 4.8,
                'reviews_count' => 198,
                'difficulty' => 'Easy',
                'group_size' => 'Max 6 people',
                'included' => 'Safari vehicle, Guide, Park fees, Accommodation, Meals',
                'not_included' => 'Personal items, Tips, Camera rental',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 6
            ]
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate(
                ['slug' => $package['slug']],
                $package
            );
        }
    }
}
