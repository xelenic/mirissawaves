<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display the about page
     */
    public function index()
    {
        $about = About::active()
            ->with('heroMedia')
            ->ordered()
            ->first();

        if (!$about) {
            // Return default content if no about page exists
            $about = (object) [
                'title' => 'About Mirissawaves',
                'subtitle' => 'Discover the Beauty of Sri Lanka with Us',
                'content' => 'Welcome to Mirissawaves, your gateway to experiencing the incredible beauty and rich culture of Sri Lanka. We are passionate about providing unforgettable travel experiences that showcase the best of this beautiful island nation.',
                'hero_image_url' => asset('slider/default-about.jpg'),
                'features' => [
                    ['title' => 'Expert Guides', 'description' => 'Our experienced local guides know every hidden gem'],
                    ['title' => 'Premium Service', 'description' => 'We provide top-quality service and attention to detail'],
                    ['title' => 'Sustainable Tourism', 'description' => 'We promote responsible and sustainable tourism practices']
                ],
                'statistics' => [
                    ['number' => '500+', 'label' => 'Happy Customers'],
                    ['number' => '50+', 'label' => 'Tour Packages'],
                    ['number' => '5', 'label' => 'Years Experience'],
                    ['number' => '98%', 'label' => 'Customer Satisfaction']
                ],
                'team_members' => [
                    ['name' => 'Our Team', 'position' => 'Professional Guides', 'description' => 'Meet our passionate team of local experts']
                ],
                'team_members_with_images' => [
                    [
                        'name' => 'Rajesh Perera',
                        'position' => 'Founder & CEO',
                        'description' => 'A native of Kandy with over 15 years of experience in tourism, Rajesh founded Mirissawaves to share his love for Sri Lanka\'s cultural heritage.',
                        'image_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'
                    ],
                    [
                        'name' => 'Priya Fernando',
                        'position' => 'Head of Operations',
                        'description' => 'Born in Mirissa, Priya ensures every detail of your journey is perfect. Her expertise in wildlife and marine conservation adds depth to our eco-tours.',
                        'image_url' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'
                    ],
                    [
                        'name' => 'Kumar Silva',
                        'position' => 'Lead Guide',
                        'description' => 'With extensive knowledge of Sri Lanka\'s ancient sites and hiking trails, Kumar brings history and adventure to life for our guests.',
                        'image_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'
                    ]
                ],
                'gallery_images_with_urls' => [
                    [
                        'url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'alt' => 'Sri Lankan landscape'
                    ]
                ],
                'vision' => 'To be the leading travel company that helps visitors discover the hidden gems of Sri Lanka while promoting sustainable tourism and supporting local communities.',
                'mission' => 'To showcase the authentic beauty of Sri Lanka through carefully curated experiences that connect travelers with the island\'s rich culture, stunning landscapes, and warm people.',
                'values' => [
                    [
                        'title' => 'Authenticity',
                        'description' => 'We believe in showcasing the real Sri Lanka, not just tourist attractions.'
                    ],
                    [
                        'title' => 'Sustainability',
                        'description' => 'We promote responsible tourism that benefits local communities and preserves the environment.'
                    ],
                    [
                        'title' => 'Excellence',
                        'description' => 'We strive to provide exceptional service and unforgettable experiences for every guest.'
                    ]
                ]
            ];
        }

        return view('about', compact('about'));
    }
}
