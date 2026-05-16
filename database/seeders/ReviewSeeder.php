<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Package;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = Package::all();

        $reviews = [
            [
                'customer_name' => 'Sarah Johnson',
                'customer_email' => 'sarah.johnson@email.com',
                'customer_location' => 'New York, USA',
                'rating' => 5,
                'review_text' => 'Absolutely amazing experience! The Sigiriya tour was breathtaking. Our guide was knowledgeable and made the entire journey unforgettable. Highly recommend Mirissawaves for anyone visiting Sri Lanka.',
                'is_verified' => true,
                'is_featured' => true,
                'is_approved' => true,
            ],
            [
                'customer_name' => 'Michael Chen',
                'customer_email' => 'michael.chen@email.com',
                'customer_location' => 'Toronto, Canada',
                'rating' => 5,
                'review_text' => 'The whale watching tour in Mirissa was incredible! We saw multiple blue whales and dolphins. The crew was professional and safety-conscious. Worth every penny!',
                'is_verified' => true,
                'is_featured' => true,
                'is_approved' => true,
            ],
            [
                'customer_name' => 'Emma Williams',
                'customer_email' => 'emma.williams@email.com',
                'customer_location' => 'London, UK',
                'rating' => 4,
                'review_text' => 'Great cultural experience! The temple visits were enlightening and the local food was delicious. The tour was well-organized and our guide was fantastic.',
                'is_verified' => true,
                'is_featured' => false,
                'is_approved' => true,
            ],
            [
                'customer_name' => 'David Rodriguez',
                'customer_email' => 'david.rodriguez@email.com',
                'customer_location' => 'Madrid, Spain',
                'rating' => 5,
                'review_text' => 'Perfect adventure tour! The hiking was challenging but rewarding. The views from Ella Rock were spectacular. Excellent service and great value for money.',
                'is_verified' => true,
                'is_featured' => true,
                'is_approved' => true,
            ],
            [
                'customer_name' => 'Lisa Anderson',
                'customer_email' => 'lisa.anderson@email.com',
                'customer_location' => 'Melbourne, Australia',
                'rating' => 5,
                'review_text' => 'Outstanding wildlife safari! We saw elephants, leopards, and so many birds. The guide was incredibly knowledgeable about Sri Lankan wildlife. A must-do experience!',
                'is_verified' => true,
                'is_featured' => true,
                'is_approved' => true,
            ],
            [
                'customer_name' => 'James Thompson',
                'customer_email' => 'james.thompson@email.com',
                'customer_location' => 'Dublin, Ireland',
                'rating' => 4,
                'review_text' => 'Beautiful beaches and crystal clear waters! The beach hopping tour was relaxing and fun. Great for families and couples. Highly recommended!',
                'is_verified' => true,
                'is_featured' => false,
                'is_approved' => true,
            ],
            [
                'customer_name' => 'Maria Garcia',
                'customer_email' => 'maria.garcia@email.com',
                'customer_location' => 'Barcelona, Spain',
                'rating' => 5,
                'review_text' => 'Amazing cultural immersion! The cooking class was fantastic and we learned so much about Sri Lankan cuisine. The hosts were welcoming and patient teachers.',
                'is_verified' => true,
                'is_featured' => true,
                'is_approved' => true,
            ],
            [
                'customer_name' => 'Robert Kim',
                'customer_email' => 'robert.kim@email.com',
                'customer_location' => 'Seoul, South Korea',
                'rating' => 4,
                'review_text' => 'Great photography tour! The guide knew all the best spots for capturing Sri Lanka\'s beauty. Perfect for photography enthusiasts.',
                'is_verified' => true,
                'is_featured' => false,
                'is_approved' => true,
            ],
            [
                'customer_name' => 'Anna Mueller',
                'customer_email' => 'anna.mueller@email.com',
                'customer_location' => 'Berlin, Germany',
                'rating' => 5,
                'review_text' => 'Exceptional service from start to finish! The team was professional, punctual, and went above and beyond to ensure we had a memorable experience.',
                'is_verified' => true,
                'is_featured' => true,
                'is_approved' => true,
            ],
            [
                'customer_name' => 'Ahmed Hassan',
                'customer_email' => 'ahmed.hassan@email.com',
                'customer_location' => 'Dubai, UAE',
                'rating' => 5,
                'review_text' => 'Perfect family vacation! The kids loved every moment. The activities were age-appropriate and the guides were excellent with children. Thank you Mirissawaves!',
                'is_verified' => true,
                'is_featured' => true,
                'is_approved' => true,
            ],
        ];

        foreach ($reviews as $reviewData) {
            // Randomly assign to a package
            $package = $packages->random();
            
            Review::create(array_merge($reviewData, [
                'package_id' => $package->id,
                'review_date' => now()->subDays(rand(1, 90)),
            ]));
        }

        // Update package ratings and review counts
        foreach ($packages as $package) {
            $approvedReviews = $package->approvedReviews();
            $avgRating = $approvedReviews->avg('rating') ?? 0;
            $reviewCount = $approvedReviews->count();
            
            $package->update([
                'rating' => round($avgRating, 1),
                'reviews_count' => $reviewCount,
            ]);
        }
    }
}