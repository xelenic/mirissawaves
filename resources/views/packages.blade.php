@extends('layouts.app')

@section('title', 'Tour Packages - Mirissawaves')
@section('description', 'Discover our amazing tour packages in Sri Lanka. From cultural heritage tours to wildlife adventures, we offer unforgettable experiences for every traveler.')

@section('content')
<!-- Hero Section -->
<section class="relative page-hero py-10 sm:py-14 bg-gradient-to-r from-blue-600 via-purple-600 to-green-600 overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="relative z-10 h-full flex items-center justify-center text-center text-white">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold playfair mb-4 animate-fade-in">
                    Our Amazing
                    <span class="gradient-text">Tour Packages</span>
                </h1>
                <p class="text-lg md:text-xl mb-6 opacity-90 animate-fade-in-delay">
                    Discover the magic of Sri Lanka with our carefully crafted experiences
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center animate-fade-in-delay-2">
                    <a href="#packages-grid" class="bg-white text-blue-600 hover:bg-gray-100 font-semibold py-2 px-6 rounded-full transition-all duration-300 transform hover:scale-105 text-sm">
                        Explore Packages
                    </a>
                    <a href="{{ route('contact') }}" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 font-semibold py-2 px-6 rounded-full transition-all duration-300 text-sm">
                        Customize Tour
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute top-16 left-10 w-16 h-16 bg-white bg-opacity-10 rounded-full animate-float"></div>
    <div class="absolute bottom-16 right-10 w-12 h-12 bg-white bg-opacity-10 rounded-full animate-float" style="animation-delay: 1s;"></div>
    <div class="absolute top-1/2 left-1/4 w-10 h-10 bg-white bg-opacity-10 rounded-full animate-float" style="animation-delay: 2s;"></div>
</section>

<!-- Filter Section -->
<section class="py-8 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 playfair mb-2">Find Your Perfect Adventure</h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-sm">Filter our packages by category to find exactly what you're looking for</p>
        </div>
        
        <div class="flex flex-wrap justify-center gap-3 mb-6">
            <a href="{{ route('packages') }}" class="filter-btn {{ !request('category') || request('category') === 'all' ? 'active bg-gradient-to-r from-blue-600 to-green-600 text-white' : 'bg-white text-gray-700 hover:bg-blue-50 hover:text-blue-600 border border-gray-300' }} px-4 py-2 rounded-full font-medium transition-all duration-300 transform hover:scale-105 text-sm">
                All Packages
            </a>
            @foreach($categories as $category)
            <a href="{{ route('packages', ['category' => $category->slug]) }}" class="filter-btn {{ request('category') === $category->slug ? 'active bg-gradient-to-r from-blue-600 to-green-600 text-white' : 'bg-white text-gray-700 hover:bg-blue-50 hover:text-blue-600 border border-gray-300' }} px-4 py-2 rounded-full font-medium transition-all duration-300 transform hover:scale-105 text-sm">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Packages Grid -->
<section id="packages-grid" class="py-12 bg-white">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($packages as $package)
            <div class="package-card group bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden" data-category="{{ $package->category->name }}">
                <!-- Package Image -->
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $package->image_url }}" alt="{{ $package->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute top-4 left-4">
                        <span class="text-white px-3 py-1 rounded-full text-sm font-semibold" style="background-color: {{ $package->category->color }}">
                            {{ $package->category->name }}
                        </span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <div class="bg-white bg-opacity-90 backdrop-blur-sm rounded-full p-2">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="text-sm font-semibold text-gray-700">{{ $package->rating }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-4 right-4">
                        <div class="bg-white bg-opacity-90 backdrop-blur-sm rounded-full px-3 py-1">
                            <span class="text-sm font-semibold text-gray-700">{{ $package->reviews_count }} reviews</span>
                        </div>
                    </div>
                </div>
                
                <!-- Package Content -->
                <div class="p-4">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="text-lg font-bold text-gray-900 playfair group-hover:text-blue-600 transition-colors duration-300 leading-tight">
                            {{ $package->title }}
                        </h3>
                        <div class="text-right ml-2">
                            <div class="text-lg font-bold text-green-600">{{ $package->formatted_price }}</div>
                            @if($package->original_price)
                            <div class="text-xs text-gray-500 line-through">{{ $package->formatted_original_price }}</div>
                            @endif
                        </div>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $package->description }}</p>
                    
                    <!-- Package Details -->
                    <div class="flex items-center justify-between mb-3 text-xs text-gray-500">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $package->duration }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{ $package->group_size }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            {{ $package->difficulty }}
                        </div>
                    </div>
                    
                    <!-- Highlights -->
                    <div class="mb-4">
                        <div class="flex flex-wrap gap-1">
                            @foreach(array_slice($package->highlights ?? [], 0, 2) as $highlight)
                            <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded text-xs font-medium">
                                {{ $highlight }}
                            </span>
                            @endforeach
                            @if(count($package->highlights ?? []) > 2)
                            <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-medium">
                                +{{ count($package->highlights ?? []) - 2 }}
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <a href="{{ route('package.details', $package->slug) }}" class="flex-1 bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white py-2 px-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 text-center text-sm">
                            View Details
                        </a>
                        <a href="{{ route('package.details', $package->slug) }}" class="bg-orange-500 hover:bg-orange-600 text-white py-2 px-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Package Modal -->
<div id="packageModal" class="fixed inset-0 z-[10000] hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 id="modalTitle" class="text-3xl font-bold text-gray-900 playfair">Package Details</h2>
                    <button onclick="closePackageModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div id="modalContent" class="space-y-6">
                    <!-- Modal content will be populated by JavaScript -->
                </div>
                
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button onclick="bookPackageFromModal()" class="flex-1 bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        Book This Package
                    </button>
                    <button onclick="closePackageModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-6 rounded-xl font-semibold transition-all duration-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Why Choose Us Section -->
<section class="py-16 bg-gradient-to-r from-blue-50 to-green-50">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 playfair mb-4">Why Choose Mirissawaves?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">We're committed to providing you with the best possible experience in Sri Lanka</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Expert Guides</h3>
                <p class="text-gray-600">Professional local guides with deep knowledge of Sri Lankan culture and history</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Best Prices</h3>
                <p class="text-gray-600">Competitive pricing with no hidden fees and flexible payment options</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Memorable Experiences</h3>
                <p class="text-gray-600">Create unforgettable memories with our carefully curated tour experiences</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">24/7 Support</h3>
                <p class="text-gray-600">Round-the-clock customer support to ensure your trip goes smoothly</p>
            </div>
        </div>
    </div>
</section>

<script>
// Package data for JavaScript
const packages = @json($packages);

// Package modal functionality
function openPackageModal(packageId) {
    const package = packages.find(p => p.id === packageId);
    if (!package) return;
    
    document.getElementById('modalTitle').textContent = package.title;
    document.getElementById('modalContent').innerHTML = `
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <img src="${package.image}" alt="${package.title}" class="w-full h-64 object-cover rounded-xl">
            </div>
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="text-lg font-semibold text-gray-700">${package.rating}</span>
                        <span class="text-gray-500 ml-2">(${package.reviews_count} reviews)</span>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-green-600">$${package.price}</div>
                        ${package.original_price ? `<div class="text-sm text-gray-500 line-through">$${package.original_price}</div>` : ''}
                    </div>
                </div>
                
                <p class="text-gray-600 mb-6">${package.description}</p>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-sm text-gray-500">Duration</div>
                        <div class="font-semibold">${package.duration}</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-sm text-gray-500">Difficulty</div>
                        <div class="font-semibold">${package.difficulty}</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-sm text-gray-500">Group Size</div>
                        <div class="font-semibold">${package.group_size}</div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-sm text-gray-500">Category</div>
                        <div class="font-semibold">${package.category.name}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div>
            <h3 class="text-xl font-semibold text-gray-900 mb-4">What's Included:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                ${(package.highlights || []).map(highlight => `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700">${highlight}</span>
                    </div>
                `).join('')}
            </div>
        </div>
    `;
    
    document.getElementById('packageModal').classList.remove('hidden');
}

function closePackageModal() {
    document.getElementById('packageModal').classList.add('hidden');
}

function bookPackage(packageId) {
    const package = packages.find(p => p.id === packageId);
    if (package) {
        alert(`Booking ${package.title} for $${package.price}. This would redirect to booking page.`);
    }
}

function bookPackageFromModal() {
    const title = document.getElementById('modalTitle').textContent;
    alert(`Booking ${title}. This would redirect to booking page.`);
}

// Close modal when clicking outside
document.getElementById('packageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePackageModal();
    }
});
</script>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.filter-btn.active {
    background: linear-gradient(135deg, #3b82f6, #10b981);
    color: white;
    border: none;
}

.package-card {
    transition: all 0.3s ease;
}

.package-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
</style>
@endsection
