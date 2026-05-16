@extends('layouts.app')

@section('title', isset($about->meta_title) ? $about->meta_title : 'About Us - Mirissawaves')
@section('description', isset($about->meta_description) ? $about->meta_description : 'Learn about Mirissawaves, your trusted partner for authentic Sri Lankan travel experiences. Discover our story, mission, and commitment to showcasing the beauty of Sri Lanka.')

@section('content')
<!-- Hero Section -->
<section class="relative page-hero flex items-center justify-center overflow-hidden min-h-[38vh] sm:min-h-[45vh]">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ $about->hero_image_url ?? asset('slider/default-about.jpg') }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-green-900/70"></div>
    </div>
    
    <div class="relative z-10 text-center text-white px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold playfair mb-4 animate-fade-in">
                {{ $about->title ?? 'About Mirissawaves' }}
            </h1>
            <p class="text-lg md:text-xl mb-6 opacity-90 animate-fade-in-delay">
                {{ $about->subtitle ?? 'Your trusted partner in discovering the authentic beauty of Sri Lanka' }}
            </p>
            <div class="animate-fade-in-delay-2">
                <a href="#our-story" class="bg-gradient-to-r from-blue-600 to-green-500 hover:from-blue-700 hover:to-green-600 text-white px-6 py-3 rounded-full text-sm font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    Discover Our Story
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section id="our-story" class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 playfair mb-4">
                    Our Story
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    {{ $about->subtitle ?? 'Born from a deep love for Sri Lanka\'s rich heritage and natural beauty, Mirissawaves has been creating unforgettable travel experiences since our founding.' }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center mb-16">
                <div class="space-y-4">
                    <h3 class="text-2xl font-bold text-gray-900 playfair">A Journey of Discovery</h3>
                    <div class="text-gray-600 leading-relaxed text-sm">
                        {!! nl2br(e($about->content ?? 'Founded by passionate travelers who fell in love with Sri Lanka\'s diverse landscapes, ancient temples, and warm hospitality, Mirissawaves began as a dream to share this paradise with the world. From the misty mountains of Ella to the golden beaches of Mirissa, from the ancient frescoes of Sigiriya to the sacred temples of Kandy, we curate experiences that showcase the very best of this incredible island nation.')) !!}
                    </div>
                    @if(isset($about->features) && count($about->features) > 0)
                        <div class="flex items-center space-x-3">
                            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900">{{ $about->features[0]['title'] ?? 'Authentic Experiences' }}</h4>
                                <p class="text-gray-600">{{ $about->features[0]['description'] ?? 'Handpicked destinations and local insights' }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-3">
                            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900">Authentic Experiences</h4>
                                <p class="text-gray-600">Handpicked destinations and local insights</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="relative">
                    @if(isset($about->gallery_images_with_urls) && count($about->gallery_images_with_urls) > 0)
                        <img src="{{ $about->gallery_images_with_urls[0]['url'] }}" alt="{{ $about->gallery_images_with_urls[0]['alt'] }}" class="rounded-2xl shadow-2xl">
                    @else
                        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Sri Lankan landscape" class="rounded-2xl shadow-2xl">
                    @endif
                    <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-gradient-to-r from-blue-500 to-green-500 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Values Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 playfair mb-4">
                    Our Mission & Values
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    We are committed to providing exceptional travel experiences while preserving Sri Lanka's natural beauty and cultural heritage.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if(isset($about->features) && count($about->features) >= 3)
                    @foreach(array_slice($about->features, 0, 3) as $index => $feature)
                        <div class="text-center p-4 bg-gradient-to-br {{ $index === 0 ? 'from-blue-50 to-blue-100' : ($index === 1 ? 'from-green-50 to-green-100' : 'from-purple-50 to-purple-100') }} rounded-xl">
                            <div class="w-10 h-10 bg-gradient-to-r {{ $index === 0 ? 'from-blue-500 to-blue-600' : ($index === 1 ? 'from-green-500 to-green-600' : 'from-purple-500 to-purple-600') }} rounded-full flex items-center justify-center mx-auto mb-4">
                                @if($index === 0)
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                @elseif($index === 1)
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 playfair mb-3">{{ $feature['title'] }}</h3>
                            <p class="text-gray-600 leading-relaxed text-sm">
                                {{ $feature['description'] }}
                            </p>
                        </div>
                    @endforeach
                @else
                    <!-- Mission -->
                    <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 playfair mb-3">Our Mission</h3>
                        <p class="text-gray-600 leading-relaxed text-sm">
                            To showcase the authentic beauty of Sri Lanka through carefully curated experiences that connect travelers with the island's rich culture, stunning landscapes, and warm people.
                        </p>
                    </div>
                    
                    <!-- Vision -->
                    <div class="text-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 playfair mb-3">Our Vision</h3>
                        <p class="text-gray-600 leading-relaxed text-sm">
                            To be the leading travel company that helps visitors discover the hidden gems of Sri Lanka while promoting sustainable tourism and supporting local communities.
                        </p>
                    </div>
                    
                    <!-- Values -->
                    <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 playfair mb-3">Our Values</h3>
                        <p class="text-gray-600 leading-relaxed text-sm">
                            Authenticity, sustainability, and exceptional service guide everything we do. We believe in creating meaningful connections between travelers and the places they visit.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>


<!-- Vision & Mission Section -->
@if($about && ($about->vision || $about->mission || ($about->values && count($about->values) > 0)))
<section class="py-16 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 playfair mb-4">
                    Our Vision, Mission & Values
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    The principles that guide us in creating exceptional experiences for our guests
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Vision -->
                @if($about->vision)
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-all duration-300">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-eye text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 playfair mb-4">Our Vision</h3>
                    </div>
                    <p class="text-gray-700 text-lg leading-relaxed text-center">
                        {{ $about->vision }}
                    </p>
                </div>
                @endif
                
                <!-- Mission -->
                @if($about->mission)
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-all duration-300">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-bullseye text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 playfair mb-4">Our Mission</h3>
                    </div>
                    <p class="text-gray-700 text-lg leading-relaxed text-center">
                        {{ $about->mission }}
                    </p>
                </div>
                @endif
            </div>
            
            <!-- Core Values -->
            @if($about->values && count($about->values) > 0)
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 playfair mb-4">Our Core Values</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($about->values as $value)
                    <div class="text-center p-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl hover:shadow-md transition-all duration-300">
                        <h4 class="text-xl font-bold text-gray-900 mb-3">{{ $value['title'] ?? 'Value' }}</h4>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $value['description'] ?? '' }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Why Choose Us Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 playfair mb-4">
                    Why Choose Mirissawaves?
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    We go beyond typical tourism to create meaningful, authentic experiences that connect you with the heart of Sri Lanka.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Local Expertise</h3>
                            <p class="text-gray-600 text-sm">Our team consists of native Sri Lankans who know the hidden gems and best-kept secrets of the island.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Sustainable Tourism</h3>
                            <p class="text-gray-600">We're committed to eco-friendly practices and supporting local communities through responsible tourism.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">24/7 Support</h3>
                            <p class="text-gray-600">Round-the-clock assistance ensures your journey is smooth and worry-free from start to finish.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-6">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Customized Experiences</h3>
                            <p class="text-gray-600">Every tour is tailored to your interests, pace, and preferences for a truly personal adventure.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-teal-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Safety First</h3>
                            <p class="text-gray-600">Your safety is our top priority with certified guides and comprehensive insurance coverage.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Best Value</h3>
                            <p class="text-gray-600">Competitive pricing with no hidden fees, ensuring you get exceptional value for your investment.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-12 bg-gradient-to-r from-blue-600 to-green-600">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold playfair mb-4">
                Ready to Discover Sri Lanka?
            </h2>
            <p class="text-lg mb-6 opacity-90">
                Join thousands of satisfied travelers who have experienced the magic of Sri Lanka with Mirissawaves.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('contact') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-full text-sm font-semibold transition-all duration-300 transform hover:scale-105">
                    Get in Touch
                </a>
                <a href="{{ route('home') }}#packages" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 px-6 py-3 rounded-full text-sm font-semibold transition-all duration-300 transform hover:scale-105">
                    View Packages
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
