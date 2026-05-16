<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mirissawaves - Discover Paradise')</title>
    <meta name="description" content="@yield('description', 'Experience the magic of Sri Lanka with Mirissawaves. Discover ancient temples, pristine beaches, and unforgettable adventures.')">
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    @stack('head')

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', 'ui-sans-serif', 'system-ui'],
                        'serif': ['Nunito', 'ui-sans-serif', 'system-ui'],
                        'rounded': ['Quicksand', 'ui-sans-serif', 'system-ui'],
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800;900&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/customer-mobile.css') }}" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Custom Styles -->
    <style>
        body, p, span, div, a, button, input, select, textarea {
            font-family: 'Poppins', sans-serif;
        }

        .playfair {
            font-family: 'Nunito', sans-serif;
            font-weight: 600;
        }

        .rounded-text {
            font-family: 'Poppins', sans-serif;
        }

        .font-quicksand {
            font-family: 'Quicksand', sans-serif;
        }

        .font-rounded {
            font-family: 'Poppins', sans-serif;
        }

        .font-rounded-bold {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #3b82f6, #10b981);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #2563eb, #059669);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDelay {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDelay2 {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes ripple {
            0% { transform: scale(0); opacity: 1; }
            100% { transform: scale(4); opacity: 0; }
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes chatPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        @keyframes chatModalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes chatWindowSlideIn {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-fade-in-delay {
            animation: fadeInDelay 0.8s ease-out 0.2s both;
        }

        .animate-fade-in-delay-2 {
            animation: fadeInDelay2 0.8s ease-out 0.4s both;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .gradient-text {
            background: linear-gradient(135deg, #3b82f6, #10b981, #f59e0b);
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .ripple {
            position: relative;
            overflow: hidden;
        }

        .ripple::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .ripple:active::before {
            width: 300px;
            height: 300px;
        }

        /* Navbar Styles */
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            z-index: 9999 !important;
        }

        .navbar-inner {
            flex-wrap: nowrap;
            align-items: center;
        }

        .navbar-desktop-nav {
            flex-shrink: 1;
        }

        .navbar.scrolled {
            background: #ffffff;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #3b82f6, #10b981);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .mobile-menu-btn {
            transition: all 0.3s ease;
        }

        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease;
            background: #ffffff;
            border-left: 1px solid #e5e7eb;
        }

        .mobile-menu.active {
            transform: translateX(0);
        }

        /* Mobile Menu Overlay */
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 35;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive Mobile Menu */
        @media (max-width: 640px) {
            .mobile-menu {
                width: 100vw;
                right: 0;
                top: 0;
                height: 100vh;
            }

            .navbar {
                height: 56px;
            }

            .navbar .container {
                height: 56px;
            }

            .navbar-inner {
                height: 56px;
            }

            .navbar .site-logo {
                height: 3.25rem !important;
            }
        }

        @media (min-width: 641px) and (max-width: 1023px) {
            .mobile-menu {
                width: 320px;
            }

            /* Hide desktop nav on tablet and show mobile menu button */
            .navbar-desktop-nav {
                display: none !important;
            }

            .mobile-menu-btn {
                display: block !important;
            }
        }

        /* Mobile Menu Scroll */
        .mobile-menu .overflow-y-auto {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        .mobile-menu .overflow-y-auto::-webkit-scrollbar {
            width: 4px;
        }

        .mobile-menu .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .mobile-menu .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 2px;
        }

        .mobile-menu .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .site-logo {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        a:hover .site-logo {
            transform: scale(1.03);
            opacity: 0.92;
        }

        /* Side Package Card */
        .side-package-card {
            animation: slideInRight 0.8s ease-out;
        }

        @media (max-width: 1024px) {
            .side-package-card {
                position: static !important;
                transform: none !important;
                margin-top: 2rem;
                max-width: 100% !important;
            }
        }

        /* Chat Button */
        .chat-btn {
            animation: chatPulse 2s infinite;
            z-index: 50;
        }

        .chat-modal {
            animation: chatModalFadeIn 0.3s ease-out;
        }

        .chat-window {
            animation: chatWindowSlideIn 0.3s ease-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.5s ease-out;
        }

        @media (max-width: 768px) {
            .chat-window {
                height: 100vh;
                border-radius: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="font-rounded">
    <!-- Navigation -->
    <nav class="navbar fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 customer-container">
            <div class="navbar-inner flex items-center justify-between w-full gap-3 lg:gap-4">
                <!-- Logo -->
                <x-site-logo href="{{ route('home') }}" height="2.5rem" class="logo-icon shrink-0" />

                <!-- Desktop Navigation -->
                <div class="navbar-desktop-nav hidden lg:flex items-center">
                    <a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-blue-600 font-medium text-sm transition-all duration-300 {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">Home</a>
                    <a href="{{ route('about') }}" class="nav-link text-gray-700 hover:text-blue-600 font-medium text-sm transition-all duration-300 {{ request()->routeIs('about') ? 'text-blue-600' : '' }}">About</a>
                    <a href="{{ route('packages') }}" class="nav-link text-gray-700 hover:text-blue-600 font-medium text-sm transition-all duration-300 {{ request()->routeIs('packages') ? 'text-blue-600' : '' }}">Packages</a>
                    <a href="{{ route('blog.index') }}" class="nav-link text-gray-700 hover:text-blue-600 font-medium text-sm transition-all duration-300 {{ request()->routeIs('blog.*') ? 'text-blue-600' : '' }}">Blog</a>
                    <a href="{{ route('contact') }}" class="nav-link text-gray-700 hover:text-blue-600 font-medium text-sm transition-all duration-300 {{ request()->routeIs('contact') ? 'text-blue-600' : '' }}">Contact</a>

                    <!-- Search Bar -->
                    <div class="relative search-container">
                        <div class="relative flex">
                            <input type="text" id="search-input" placeholder="Search..."
                                   class="navbar-search-input w-36 xl:w-48 px-3 py-1.5 pl-8 pr-10 text-sm border border-gray-300 rounded-l-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <button type="button" id="search-clear" class="absolute inset-y-0 right-10 pr-2 flex items-center hidden">
                                <svg class="h-4 w-4 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            <button type="button" id="search-button" class="bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white px-3 py-1.5 rounded-r-full transition-all duration-300 flex items-center">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Search Suggestions Dropdown -->
                        <div id="search-suggestions" class="absolute top-full left-0 right-0 mt-1 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50 max-h-96 overflow-y-auto">
                            <div id="search-results" class="py-2">
                                <!-- Search results will be populated here -->
                            </div>
                        </div>
                    </div>

                    @auth
                        <!-- User Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 font-medium transition-all duration-300">
                                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-green-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="navbar-user-name">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                <div class="py-2">
                                    @if(auth()->user()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Admin Panel
                                    </a>
                                    @endif
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        My Profile
                                    </a>
                                    <a href="{{ route('my-bookings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        My Bookings
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-300">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Settings
                                    </a>
                                    <hr class="my-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-300">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Guest Navigation -->
                        <a href="{{ route('login') }}" class="nav-link text-gray-700 hover:text-blue-600 font-medium text-sm transition-all duration-300 {{ request()->routeIs('login') ? 'text-blue-600' : '' }}">Login</a>
                        <a href="{{ route('register') }}" class="shrink-0 bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg ripple whitespace-nowrap">
                            Book your adventure
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="mobile-menu-btn lg:hidden p-3 rounded-lg hover:bg-gray-100 transition-all duration-300 min-w-[44px] min-h-[44px] flex items-center justify-center" onclick="toggleMobileMenu()" aria-label="Open menu">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Overlay -->
            <div class="mobile-menu-overlay lg:hidden"></div>

            <!-- Mobile Menu -->
            <div class="mobile-menu fixed right-0 w-full max-w-sm shadow-2xl z-40 lg:hidden">
                <!-- Mobile Menu Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Menu</h3>
                    <button onclick="toggleMobileMenu()" class="p-2 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-4 overflow-y-auto h-full pb-20">
                    <!-- Mobile Search Bar -->
                    <div class="mb-6">
                        <div class="relative flex">
                            <input type="text" id="mobile-search-input" placeholder="Search..."
                                   class="flex-1 px-4 py-2 pl-10 pr-12 text-sm border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <button type="button" id="mobile-search-button" class="bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white px-4 py-2 rounded-r-lg transition-all duration-300 flex items-center">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="mobile-nav-link block px-4 py-3 text-gray-700 hover:text-blue-600 rounded-xl text-base font-medium transition-all duration-300 hover:bg-blue-50 {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Home
                        </span>
                    </a>
                    <a href="{{ route('about') }}" class="mobile-nav-link block px-4 py-3 text-gray-700 hover:text-blue-600 rounded-xl text-base font-medium transition-all duration-300 hover:bg-blue-50 {{ request()->routeIs('about') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            About
                        </span>
                    </a>
                    <a href="{{ route('packages') }}" class="mobile-nav-link block px-4 py-3 text-gray-700 hover:text-blue-600 rounded-xl text-base font-medium transition-all duration-300 hover:bg-blue-50 {{ request()->routeIs('packages') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Packages
                        </span>
                    </a>
                    <a href="{{ route('blog.index') }}" class="mobile-nav-link block px-4 py-3 text-gray-700 hover:text-blue-600 rounded-xl text-base font-medium transition-all duration-300 hover:bg-blue-50 {{ request()->routeIs('blog.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Blog
                        </span>
                    </a>
                    <a href="{{ route('contact') }}" class="mobile-nav-link block px-4 py-3 text-gray-700 hover:text-blue-600 rounded-xl text-base font-medium transition-all duration-300 hover:bg-blue-50 {{ request()->routeIs('contact') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Contact
                        </span>
                    </a>

                    @auth
                        <!-- Mobile User Section -->
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex items-center space-x-3 mb-4 px-4 py-3 bg-gradient-to-r from-blue-50 to-green-50 rounded-xl">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-green-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                                </div>
                            </div>

                            @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link block px-4 py-3 text-gray-700 hover:text-blue-600 rounded-xl text-base font-medium transition-all duration-300 hover:bg-blue-50">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Admin Panel
                                </span>
                            </a>
                            @endif
                            <a href="#" class="mobile-nav-link block px-4 py-3 text-gray-700 hover:text-blue-600 rounded-xl text-base font-medium transition-all duration-300 hover:bg-blue-50">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    My Profile
                                </span>
                            </a>
                            <a href="{{ route('my-bookings.index') }}" class="mobile-nav-link block px-4 py-3 text-gray-700 hover:text-blue-600 rounded-xl text-base font-medium transition-all duration-300 hover:bg-blue-50">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    My Bookings
                                </span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left mobile-nav-link block px-4 py-3 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-xl text-base font-medium transition-all duration-300">
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </span>
                                </button>
                            </form>
                        </div>
                    @else

                    @endauth

                    @auth
                        <div class="pt-4 border-t border-gray-200">
                            <button class="w-full bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white px-6 py-3 rounded-xl font-semibold text-base transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Book Your Adventure
                            </button>
                        </div>
                    @else
                        <!-- Mobile Guest Section -->
                        <div class="pt-4 border-t border-gray-200 space-y-3">
                            <a href="{{ route('login') }}" class="mobile-nav-link block px-4 py-3 text-gray-700 hover:text-blue-600 rounded-xl text-base font-medium transition-all duration-300 hover:bg-blue-50 {{ request()->routeIs('login') ? 'text-blue-600 bg-blue-50' : '' }}">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    Login
                                </span>
                            </a>
                            <a href="{{ route('register') }}" class="mobile-nav-link block px-4 py-3 text-gray-700 hover:text-blue-600 rounded-xl text-base font-medium transition-all duration-300 hover:bg-blue-50 {{ request()->routeIs('register') ? 'text-blue-600 bg-blue-50' : '' }}">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                   Book your Adventure
                                </span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="site-main">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 animate-slide-in-right" id="success-message">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 animate-slide-in-right" id="error-message">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-10 sm:py-16">
        <div class="container mx-auto px-4 sm:px-6 customer-container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="space-y-4">
                    <x-site-logo href="{{ route('home') }}" height="3rem" />
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Experience the magic of Sri Lanka with our exclusive tour packages. From ancient temples to pristine beaches, we create unforgettable memories.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors duration-300">Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition-colors duration-300">About Us</a></li>
                        <li><a href="{{ route('packages') }}" class="text-gray-400 hover:text-white transition-colors duration-300">Tour Packages</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition-colors duration-300">Contact</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold">Our Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Cultural Tours</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Adventure Tours</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Beach Holidays</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Wildlife Safaris</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold">Contact Info</h4>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-400 text-sm">Mirissa, Sri Lanka</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-gray-400 text-sm">+94 77 552 3939</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-400 text-sm">info@mirissawaves.com</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    © {{ date('Y') }} Mirissawaves. All rights reserved. | Designed with ❤️ for Sri Lanka
                </p>
            </div>
        </div>
    </footer>

    @if($whatsappUrl ?? null)
    <!-- WhatsApp Button -->
    <div id="chatButton" class="fixed bottom-6 right-6 z-50 group">
        <a href="{{ $whatsappUrl }}"
           target="_blank"
           rel="noopener noreferrer"
           class="chat-btn flex items-center justify-center w-14 h-14 bg-[#25D366] hover:bg-[#20bd5a] text-white rounded-full shadow-2xl transition-all duration-300 transform hover:scale-110"
           aria-label="Chat on WhatsApp (opens in new tab)"
           title="Chat on WhatsApp">
            <i class="fab fa-whatsapp text-3xl" aria-hidden="true"></i>
        </a>
        <span class="pointer-events-none absolute bottom-16 right-0 bg-gray-900 text-white px-3 py-2 rounded-lg text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-lg">
            Chat on WhatsApp
        </span>
    </div>
    @endif

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.querySelector('.mobile-menu');
            const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');

            mobileMenu.classList.toggle('active');
            mobileMenuOverlay.classList.toggle('active');
        }

        // Close mobile menu when clicking overlay
        document.addEventListener('click', function(event) {
            const mobileMenu = document.querySelector('.mobile-menu');
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');

            if (event.target === mobileMenuOverlay) {
                mobileMenu.classList.remove('active');
                mobileMenuOverlay.classList.remove('active');
            }
        });

        // Close mobile menu on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const mobileMenu = document.querySelector('.mobile-menu');
                const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');

                mobileMenu.classList.remove('active');
                mobileMenuOverlay.classList.remove('active');
            }
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto-hide success/error messages
        setTimeout(function() {
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');

            if (successMessage) {
                successMessage.style.transform = 'translateX(100%)';
                setTimeout(() => successMessage.remove(), 300);
            }

            if (errorMessage) {
                errorMessage.style.transform = 'translateX(100%)';
                setTimeout(() => errorMessage.remove(), 300);
            }
        }, 5000);

        // Search functionality
        let searchTimeout;
        const searchInput = document.getElementById('search-input');
        const searchSuggestions = document.getElementById('search-suggestions');
        const searchResults = document.getElementById('search-results');
        const searchClear = document.getElementById('search-clear');
        const searchButton = document.getElementById('search-button');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                // Show/hide clear button
                if (query.length > 0) {
                    searchClear.classList.remove('hidden');
                } else {
                    searchClear.classList.add('hidden');
                    searchSuggestions.classList.add('hidden');
                }

                // Clear previous timeout
                clearTimeout(searchTimeout);

                // Set new timeout for search
                if (query.length >= 2) {
                    searchTimeout = setTimeout(() => {
                        performSearch(query);
                    }, 300);
                } else {
                    searchSuggestions.classList.add('hidden');
                }
            });

            // Clear search
            searchClear.addEventListener('click', function() {
                searchInput.value = '';
                searchSuggestions.classList.add('hidden');
                searchClear.classList.add('hidden');
                searchInput.focus();
            });

            // Handle form submission
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = this.value.trim();
                    if (query.length > 0) {
                        window.location.href = `/search?q=${encodeURIComponent(query)}`;
                    }
                }
            });

            // Handle search button click
            searchButton.addEventListener('click', function() {
                const query = searchInput.value.trim();
                if (query.length > 0) {
                    window.location.href = `/search?q=${encodeURIComponent(query)}`;
                }
            });

            // Mobile search functionality
            const mobileSearchInput = document.getElementById('mobile-search-input');
            const mobileSearchButton = document.getElementById('mobile-search-button');

            if (mobileSearchInput && mobileSearchButton) {
                mobileSearchButton.addEventListener('click', function() {
                    const query = mobileSearchInput.value.trim();
                    if (query.length > 0) {
                        window.location.href = `/search?q=${encodeURIComponent(query)}`;
                    }
                });

                mobileSearchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const query = this.value.trim();
                        if (query.length > 0) {
                            window.location.href = `/search?q=${encodeURIComponent(query)}`;
                        }
                    }
                });
            }

            // Hide suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.search-container')) {
                    searchSuggestions.classList.add('hidden');
                }
            });
        }

        function performSearch(query) {
            fetch(`/api/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    displaySearchResults(data);
                })
                .catch(error => {
                    console.error('Search error:', error);
                });
        }

        function displaySearchResults(data) {
            let html = '';
            let hasResults = false;

            // Packages
            if (data.packages && data.packages.length > 0) {
                html += '<div class="px-4 py-2"><h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Packages</h4></div>';
                data.packages.forEach(package => {
                    html += `
                        <a href="${package.url}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="${package.image}" alt="${package.title}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">${package.title}</p>
                                    <p class="text-xs text-gray-500 truncate">${package.description}</p>
                                    <p class="text-xs text-blue-600 font-medium">${package.price}</p>
                                </div>
                            </div>
                        </a>
                    `;
                });
                hasResults = true;
            }

            // Blogs
            if (data.blogs && data.blogs.length > 0) {
                html += '<div class="px-4 py-2"><h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Blog Posts</h4></div>';
                data.blogs.forEach(blog => {
                    html += `
                        <a href="${blog.url}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="${blog.image}" alt="${blog.title}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">${blog.title}</p>
                                    <p class="text-xs text-gray-500 truncate">${blog.description}</p>
                                    <p class="text-xs text-gray-400">${blog.published_at}</p>
                                </div>
                            </div>
                        </a>
                    `;
                });
                hasResults = true;
            }

            // Package Categories
            if (data.package_categories && data.package_categories.length > 0) {
                html += '<div class="px-4 py-2"><h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Package Categories</h4></div>';
                data.package_categories.forEach(category => {
                    html += `
                        <a href="${category.url}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: ${category.color}20">
                                    <i class="${category.icon} text-sm" style="color: ${category.color}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">${category.title}</p>
                                    <p class="text-xs text-gray-500 truncate">${category.description}</p>
                                </div>
                            </div>
                        </a>
                    `;
                });
                hasResults = true;
            }

            // Blog Categories
            if (data.blog_categories && data.blog_categories.length > 0) {
                html += '<div class="px-4 py-2"><h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Blog Categories</h4></div>';
                data.blog_categories.forEach(category => {
                    html += `
                        <a href="${category.url}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: ${category.color}20">
                                    <i class="${category.icon} text-sm" style="color: ${category.color}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">${category.title}</p>
                                    <p class="text-xs text-gray-500 truncate">${category.description}</p>
                                </div>
                            </div>
                        </a>
                    `;
                });
                hasResults = true;
            }

            // Show "View all results" link
            if (hasResults) {
                const query = searchInput.value.trim();
                html += `
                    <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                        <a href="/search?q=${encodeURIComponent(query)}" class="block text-center text-sm font-medium text-blue-600 hover:text-blue-800">
                            View all results for "${query}"
                        </a>
                    </div>
                `;
            } else {
                html = '<div class="px-4 py-8 text-center text-gray-500">No results found</div>';
            }

            searchResults.innerHTML = html;
            searchSuggestions.classList.remove('hidden');
        }
    </script>

    @include('components.startup-offers-popup')

    @stack('scripts')
</body>
</html>
