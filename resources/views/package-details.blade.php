@extends('layouts.app')

@section('title', $package->title . ' - Mirissawaves')
@section('description', Str::limit($package->description, 160))

@push('head')
@if(auth()->check())
<meta name="user-authenticated" content="true">
@endif
@endpush

@section('content')
<!-- Hero Section with Image Slider -->
<section class="relative detail-hero overflow-hidden">
    <div class="swiper package-swiper h-full">
        <div class="swiper-wrapper">
            <!-- Main Package Image -->
            <div class="swiper-slide relative">
                <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ $package->image_url }}')"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-black/30"></div>
            </div>
            
            <!-- Additional Images from Package -->
            @if($package->images && count($package->images) > 0)
                @foreach($package->images as $image)
                <div class="swiper-slide relative">
                    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('storage/' . $image) }}')"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-black/30"></div>
                </div>
                @endforeach
            @endif
            
            <!-- Sample Travel Images -->
            @if($package->category->slug === 'cultural')
                <div class="swiper-slide relative">
                    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('slider/sigiriya_rock.jpg') }}')"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-black/30"></div>
                </div>
                <div class="swiper-slide relative">
                    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('slider/thooth_relic.jpg') }}')"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-black/30"></div>
                </div>
            @elseif($package->category->slug === 'wildlife')
                <div class="swiper-slide relative">
                    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('slider/whale_watiching.jpg') }}')"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-black/30"></div>
                </div>
                <div class="swiper-slide relative">
                    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('slider/yala_safari.jpg') }}')"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-black/30"></div>
                </div>
            @elseif($package->category->slug === 'adventure')
                <div class="swiper-slide relative">
                    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('slider/ella_city_tour.jpg') }}')"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-black/30"></div>
                </div>
                <div class="swiper-slide relative">
                    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('slider/arugam_bay.jpg') }}')"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-black/30"></div>
                </div>
            @endif
        </div>
        
        <!-- Navigation Buttons -->
        <div class="swiper-button-next package-swiper-next"></div>
        <div class="swiper-button-prev package-swiper-prev"></div>
        
        <!-- Pagination -->
        <div class="swiper-pagination package-swiper-pagination"></div>
    </div>
    
    <!-- Package Info Overlay -->
    <div class="detail-hero-card absolute bottom-0 left-0 right-0 z-10 p-4 sm:p-8">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white/95 backdrop-blur-lg rounded-2xl p-4 sm:p-6 shadow-2xl">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-white px-4 py-2 rounded-full text-sm font-semibold" style="background-color: {{ $package->category->color }}">
                                {{ $package->category->name }}
                            </span>
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="font-semibold">{{ $package->rating }}</span>
                                <span class="text-sm ml-1">({{ $package->reviews_count }} reviews)</span>
                            </div>
                        </div>
                        <h1 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-gray-900 playfair mb-4">
                            {{ $package->title }}
                        </h1>
                        <p class="text-lg text-gray-600 mb-4">
                            {{ $package->description }}
                        </p>
                        <div class="flex flex-wrap items-center gap-4 sm:gap-6 text-gray-600 detail-meta">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $package->duration }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                {{ $package->difficulty }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                {{ $package->group_size }}
                            </div>
                        </div>
                    </div>
                    <div class="text-center lg:text-right">
                        <div class="text-4xl font-bold mb-2" style="color: {{ $package->category->color }}">
                            {{ $package->formatted_price }}
                        </div>
                        @if($package->original_price)
                        <div class="text-lg text-gray-500 line-through mb-4">
                            {{ $package->formatted_original_price }}
                        </div>
                        @endif
                        <button onclick="openBookingModal()" class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full text-base sm:text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Book This Package
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Package Details Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Highlights -->
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 playfair mb-6">What's Included</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($package->highlights ?? [] as $highlight)
                            <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700 font-medium">{{ $highlight }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Detailed Description -->
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 playfair mb-6">About This Experience</h2>
                        <div class="prose prose-lg max-w-none">
                            <p class="text-gray-600 leading-relaxed mb-6">
                                {{ $package->description }}
                            </p>
                            @if($package->short_description)
                            <p class="text-gray-600 leading-relaxed">
                                {{ $package->short_description }}
                            </p>
                            @endif
                        </div>
                    </div>

                    <!-- Itinerary -->
                    @if($package->itinerary)
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 playfair mb-6">Itinerary</h2>
                        <div class="prose prose-lg max-w-none">
                            <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $package->itinerary }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Requirements -->
                    @if($package->requirements)
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 playfair mb-6">Requirements</h2>
                        <div class="prose prose-lg max-w-none">
                            <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $package->requirements }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Booking Card -->
                    <div class="bg-gray-50 rounded-2xl p-6 sticky top-8 mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 playfair mb-4">Book This Package</h3>
                        <div class="text-center mb-6">
                            <div class="text-4xl font-bold mb-2" style="color: {{ $package->category->color }}">
                                {{ $package->formatted_price }}
                            </div>
                            @if($package->original_price)
                            <div class="text-lg text-gray-500 line-through mb-2">
                                {{ $package->formatted_original_price }}
                            </div>
                            @endif
                            <div class="text-sm text-gray-600">per person</div>
                        </div>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration:</span>
                                <span class="font-semibold">{{ $package->duration }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Difficulty:</span>
                                <span class="font-semibold">{{ $package->difficulty }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Group Size:</span>
                                <span class="font-semibold">{{ $package->group_size }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Category:</span>
                                <span class="font-semibold">{{ $package->category->name }}</span>
                            </div>
                        </div>
                        
                        <button onclick="openBookingModal()" class="w-full bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white py-4 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Book Now
                        </button>
                        
                        <div class="text-center mt-4">
                            <p class="text-sm text-gray-500">Free cancellation up to 24 hours before</p>
                        </div>
                    </div>

                    <!-- What's Included/Not Included -->
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">What's Included</h3>
                        @if($package->included)
                        <div class="prose prose-sm max-w-none">
                            <p class="text-gray-600 whitespace-pre-line">{{ $package->included }}</p>
                        </div>
                        @else
                        <p class="text-gray-500 text-sm">Please contact us for details</p>
                        @endif
                    </div>

                    @if($package->not_included)
                    <div class="bg-white border border-gray-200 rounded-2xl p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Not Included</h3>
                        <div class="prose prose-sm max-w-none">
                            <p class="text-gray-600 whitespace-pre-line">{{ $package->not_included }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Packages -->
@if($relatedPackages->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 playfair mb-4">Related Packages</h2>
                <p class="text-xl text-gray-600">Discover more amazing experiences</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($relatedPackages as $relatedPackage)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative h-48">
                        <img src="{{ $relatedPackage->image_url }}" alt="{{ $relatedPackage->title }}" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4 text-white px-3 py-1 rounded-full text-sm font-semibold" style="background-color: {{ $relatedPackage->category->color }}">
                            {{ $relatedPackage->category->name }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 playfair mb-2">{{ $relatedPackage->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($relatedPackage->description, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold" style="color: {{ $relatedPackage->category->color }}">
                                {{ $relatedPackage->formatted_price }}
                            </div>
                            <a href="{{ route('package.details', $relatedPackage->slug) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-300">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-[10000] hidden p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto relative">
        <button onclick="closeBookingModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 transition-colors duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <div class="p-6">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 playfair mb-2">Book {{ $package->title }}</h2>
                @if(auth()->check())
                    <p class="text-gray-600">Complete your booking details below</p>
                    <div class="mt-2 flex items-center justify-center text-xs text-green-600 bg-green-50 px-3 py-1 rounded-full">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Your details have been auto-filled
                    </div>
                @else
                    <p class="text-gray-600">Complete your booking details and create your account</p>
                    <div class="mt-2 flex items-center justify-center text-xs text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        We'll create an account for you automatically
                    </div>
                @endif
            </div>
            
            <!-- Error Alert -->
            <div id="bookingErrorAlert" class="hidden bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                        <div id="bookingErrorList" class="mt-2 text-sm text-red-700">
                            <!-- Error messages will be inserted here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Alert -->
            <div id="bookingSuccessAlert" class="hidden bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Success!</h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p id="bookingSuccessMessage">Booking submitted successfully!</p>
                        </div>
                    </div>
                </div>
            </div>

            <form id="bookingForm" class="space-y-4" method="POST" action="{{ route('bookings.store') }}">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" id="full_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Enter your full name" value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                    <div id="full_name_error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Enter your email" value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                    <div id="email_error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Phone Number</label>
                    <input type="tel" name="phone" id="phone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Enter your phone number">
                    <div id="phone_error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Travel Date <span class="text-red-500">*</span></label>
                    <input type="date" name="travel_date" id="travel_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" required>
                    <div id="travel_date_error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Number of Travelers <span class="text-red-500">*</span></label>
                    <select name="travelers" id="travelers" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" required>
                        <option value="">Select travelers</option>
                        <option value="1">1 Person</option>
                        <option value="2">2 People</option>
                        <option value="3">3 People</option>
                        <option value="4">4 People</option>
                        <option value="5">5+ People</option>
                    </select>
                    <div id="travelers_error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Special Requirements</label>
                    <textarea name="special_requirements" id="special_requirements" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" rows="2" placeholder="Any special requirements or notes"></textarea>
                    <div id="special_requirements_error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>
            </div>
            
            @if(!auth()->check())
            <!-- Guest Account Creation Fields -->
            <div class="border-t border-gray-200 pt-4 mt-6">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900">Create Your Account</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">We'll create an account for you so you can manage your bookings and get updates.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Create a password (min 8 characters)" required>
                        <div id="password_error" class="text-red-500 text-xs mt-1 hidden"></div>
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Confirm your password" required>
                        <div id="password_confirmation_error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="bg-gray-50 rounded-lg p-3">
                <h3 class="text-base font-semibold text-gray-900 mb-2">Booking Summary</h3>
                <div class="space-y-1.5">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">{{ $package->title }}</span>
                        <span class="font-semibold">{{ $package->formatted_price }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Duration</span>
                        <span class="font-semibold">{{ $package->duration }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-1.5">
                        <div class="flex justify-between text-base font-bold">
                            <span>Total</span>
                            <span style="color: {{ $package->category->color }}">{{ $package->formatted_price }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-2 pt-1">
                <button type="button" onclick="closeBookingModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-3 rounded-lg font-medium transition-colors duration-300 text-sm">
                    Cancel
                </button>
                <button type="submit" id="submitBookingBtn" class="flex-1 bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white py-2 px-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 text-sm flex items-center justify-center">
                    <span id="submitBtnText">
                        @if(auth()->check())
                            Book & Pay Now
                        @else
                            Create Account & Pay
                        @endif
                    </span>
                    <svg id="submitBtnSpinner" class="hidden animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
// Initialize Swiper for package images
document.addEventListener('DOMContentLoaded', function() {
    const packageSwiper = new Swiper('.package-swiper', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.package-swiper-next',
            prevEl: '.package-swiper-prev',
        },
        pagination: {
            el: '.package-swiper-pagination',
            clickable: true,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        }
    });

    // Initialize booking form validation
    initializeBookingForm();
});

// Booking Modal Functions
function openBookingModal() {
    document.getElementById('bookingModal').classList.remove('hidden');
    resetFormValidation();
}

function closeBookingModal() {
    document.getElementById('bookingModal').classList.add('hidden');
    // Reset form state when closing modal
    resetFormValidation();
}

// Close modal when clicking outside
document.getElementById('bookingModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeBookingModal();
    }
});

// Form Validation Functions
function initializeBookingForm() {
    const form = document.getElementById('bookingForm');
    if (!form) return;

    // Set minimum date to tomorrow
    const travelDateInput = document.getElementById('travel_date');
    if (travelDateInput) {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        travelDateInput.min = tomorrow.toISOString().split('T')[0];
    }

    // Add real-time validation
    addRealTimeValidation();

    // Handle form submission
    form.addEventListener('submit', handleFormSubmission);
}

function addRealTimeValidation() {
    // Email validation
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            validateEmail(this.value, 'email_error');
        });
    }

    // Password validation
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            validatePassword(this.value, 'password_error');
        });
    }

    // Password confirmation validation
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    if (passwordConfirmationInput) {
        passwordConfirmationInput.addEventListener('blur', function() {
            const password = document.getElementById('password').value;
            validatePasswordConfirmation(password, this.value, 'password_confirmation_error');
        });
    }

    // Travel date validation
    const travelDateInput = document.getElementById('travel_date');
    if (travelDateInput) {
        travelDateInput.addEventListener('change', function() {
            validateTravelDate(this.value, 'travel_date_error');
        });
    }

    // Required field validation
    const requiredFields = ['full_name', 'travelers'];
    requiredFields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (field) {
            field.addEventListener('blur', function() {
                validateRequiredField(this.value, fieldName + '_error', this.getAttribute('placeholder') || 'This field');
            });
        }
    });
}

function validateEmail(email, errorElementId) {
    const errorElement = document.getElementById(errorElementId);
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (!email) {
        showFieldError(errorElement, 'Email is required');
        return false;
    } else if (!emailRegex.test(email)) {
        showFieldError(errorElement, 'Please enter a valid email address');
        return false;
    } else {
        hideFieldError(errorElement);
        return true;
    }
}

function validatePassword(password, errorElementId) {
    const errorElement = document.getElementById(errorElementId);
    
    if (!password) {
        showFieldError(errorElement, 'Password is required');
        return false;
    } else if (password.length < 8) {
        showFieldError(errorElement, 'Password must be at least 8 characters long');
        return false;
    } else {
        hideFieldError(errorElement);
        return true;
    }
}

function validatePasswordConfirmation(password, confirmation, errorElementId) {
    const errorElement = document.getElementById(errorElementId);
    
    if (!confirmation) {
        showFieldError(errorElement, 'Please confirm your password');
        return false;
    } else if (password !== confirmation) {
        showFieldError(errorElement, 'Passwords do not match');
        return false;
    } else {
        hideFieldError(errorElement);
        return true;
    }
}

function validateTravelDate(date, errorElementId) {
    const errorElement = document.getElementById(errorElementId);
    const today = new Date();
    const selectedDate = new Date(date);
    
    if (!date) {
        showFieldError(errorElement, 'Travel date is required');
        return false;
    } else if (selectedDate <= today) {
        showFieldError(errorElement, 'Travel date must be in the future');
        return false;
    } else {
        hideFieldError(errorElement);
        return true;
    }
}

function validateRequiredField(value, errorElementId, fieldName) {
    const errorElement = document.getElementById(errorElementId);
    
    if (!value || value.trim() === '') {
        showFieldError(errorElement, `${fieldName} is required`);
        return false;
    } else {
        hideFieldError(errorElement);
        return true;
    }
}

function showFieldError(errorElement, message) {
    console.log('showFieldError called:', errorElement, message); // Debug log
    
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
        
        // Find the associated input field
        const fieldId = errorElement.id.replace('_error', '');
        const inputField = document.getElementById(fieldId);
        console.log('Found input field:', fieldId, inputField); // Debug log
        
        if (inputField) {
            inputField.classList.add('border-red-500');
            inputField.classList.remove('border-gray-300');
        }
    }
}

function hideFieldError(errorElement) {
    if (errorElement) {
        errorElement.classList.add('hidden');
        
        // Find the associated input field
        const fieldId = errorElement.id.replace('_error', '');
        const inputField = document.getElementById(fieldId);
        
        if (inputField) {
            inputField.classList.remove('border-red-500');
            inputField.classList.add('border-gray-300');
        }
    }
}

function resetFormValidation() {
    // Hide all error messages
    const errorElements = document.querySelectorAll('[id$="_error"]');
    errorElements.forEach(element => {
        element.classList.add('hidden');
    });

    // Reset input field styling
    const inputs = document.querySelectorAll('#bookingForm input, #bookingForm select, #bookingForm textarea');
    inputs.forEach(input => {
        input.classList.remove('border-red-500');
        input.classList.add('border-gray-300');
    });

    // Hide alerts
    document.getElementById('bookingErrorAlert').classList.add('hidden');
    document.getElementById('bookingSuccessAlert').classList.add('hidden');
}

function showFormErrors(errors) {
    console.log('showFormErrors called with:', errors); // Debug log
    
    // Hide success alert first
    document.getElementById('bookingSuccessAlert').classList.add('hidden');
    
    const errorAlert = document.getElementById('bookingErrorAlert');
    const errorList = document.getElementById('bookingErrorList');
    
    if (Object.keys(errors).length > 0) {
        console.log('Showing error alert'); // Debug log
        errorAlert.classList.remove('hidden');
        
        let errorHtml = '<ul class="list-disc list-inside space-y-1">';
        Object.keys(errors).forEach(field => {
            errors[field].forEach(error => {
                errorHtml += `<li>${error}</li>`;
                // Show field-specific errors
                const fieldErrorElement = document.getElementById(field + '_error');
                console.log(`Looking for error element: ${field}_error`, fieldErrorElement); // Debug log
                if (fieldErrorElement) {
                    showFieldError(fieldErrorElement, error);
                }
            });
        });
        errorHtml += '</ul>';
        
        errorList.innerHTML = errorHtml;
    }
}

function showFormSuccess(message) {
    resetFormValidation();
    
    const successAlert = document.getElementById('bookingSuccessAlert');
    const successMessage = document.getElementById('bookingSuccessMessage');
    
    successAlert.classList.remove('hidden');
    successMessage.textContent = message;
}

function handleFormSubmission(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const submitButton = document.getElementById('submitBookingBtn');
    const submitBtnText = document.getElementById('submitBtnText');
    const submitBtnSpinner = document.getElementById('submitBtnSpinner');
    
    // Show loading state
    submitButton.disabled = true;
    submitBtnText.textContent = 'Processing...';
    submitBtnSpinner.classList.remove('hidden');
    
    // Reset any previous validation errors
    resetFormValidation();
    
    // Perform client-side validation
    if (!performClientSideValidation()) {
        resetSubmitButton();
        return;
    }
    
    // Submit form via AJAX
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('Response status:', response.status); // Debug log
        console.log('Response headers:', response.headers); // Debug log
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data); // Debug log
        if (data.success) {
            showFormSuccess(data.message);
            // Redirect after a short delay
            setTimeout(() => {
                window.location.href = data.redirect_url;
            }, 1500);
        } else {
            console.log('Validation failed:', data.errors); // Debug log
            if (data.errors) {
                showFormErrors(data.errors);
            } else {
                showFormErrors({ general: [data.message] });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showFormErrors({ general: ['An unexpected error occurred. Please try again.'] });
    })
    .finally(() => {
        resetSubmitButton();
    });
}

function resetSubmitButton() {
    const submitButton = document.getElementById('submitBookingBtn');
    const submitBtnText = document.getElementById('submitBtnText');
    const submitBtnSpinner = document.getElementById('submitBtnSpinner');
    
    submitButton.disabled = false;
    submitBtnSpinner.classList.add('hidden');
    
    // Restore original text based on authentication status
    if (document.querySelector('meta[name="user-authenticated"]')) {
        submitBtnText.textContent = 'Book & Pay Now';
    } else {
        submitBtnText.textContent = 'Create Account & Pay';
    }
}

function performClientSideValidation() {
    let isValid = true;
    
    // Validate required fields
    const requiredFields = [
        { id: 'full_name', name: 'Full Name' },
        { id: 'email', name: 'Email' },
        { id: 'travel_date', name: 'Travel Date' },
        { id: 'travelers', name: 'Number of Travelers' }
    ];
    
    requiredFields.forEach(field => {
        const element = document.getElementById(field.id);
        if (element && !validateRequiredField(element.value, field.id + '_error', field.name)) {
            isValid = false;
        }
    });
    
    // Validate email format
    const emailField = document.getElementById('email');
    if (emailField && !validateEmail(emailField.value, 'email_error')) {
        isValid = false;
    }
    
    // Validate travel date
    const travelDateField = document.getElementById('travel_date');
    if (travelDateField && !validateTravelDate(travelDateField.value, 'travel_date_error')) {
        isValid = false;
    }
    
    // Validate password fields for guest users
    if (!document.querySelector('meta[name="user-authenticated"]')) {
        const passwordField = document.getElementById('password');
        const passwordConfirmationField = document.getElementById('password_confirmation');
        
        if (passwordField && !validatePassword(passwordField.value, 'password_error')) {
            isValid = false;
        }
        
        if (passwordConfirmationField && !validatePasswordConfirmation(
            passwordField.value, 
            passwordConfirmationField.value, 
            'password_confirmation_error'
        )) {
            isValid = false;
        }
    }
    
    return isValid;
}

</script>
@endsection
