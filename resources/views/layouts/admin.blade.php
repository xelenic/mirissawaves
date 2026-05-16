<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Mirissawaves</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/media-manager.css') }}" rel="stylesheet">
    <script src="{{ asset('js/media-manager-modal.js') }}"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'playfair': ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Admin Page Styles */
        .admin-page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }

        .admin-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .admin-card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .admin-card-body {
            padding: 1.5rem;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            background: #f9fafb;
            padding: 0.75rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .admin-table td {
            padding: 0.75rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .admin-table tr:hover {
            background: #f9fafb;
        }

        .admin-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .admin-badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .admin-badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .admin-badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .admin-badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .admin-form-group {
            margin-bottom: 1.5rem;
        }

        .admin-form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .admin-form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .admin-form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .admin-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s ease-in-out;
            border: none;
            cursor: pointer;
        }

        .admin-btn-primary {
            background: #3b82f6;
            color: white;
        }

        .admin-btn-primary:hover {
            background: #2563eb;
        }

        .admin-btn-secondary {
            background: #6b7280;
            color: white;
        }

        .admin-btn-secondary:hover {
            background: #4b5563;
        }

        .admin-btn-success {
            background: #10b981;
            color: white;
        }

        .admin-btn-success:hover {
            background: #059669;
        }

        .admin-btn-danger {
            background: #ef4444;
            color: white;
        }

        .admin-btn-danger:hover {
            background: #dc2626;
        }

        .admin-btn-warning {
            background: #f59e0b;
            color: white;
        }

        .admin-btn-warning:hover {
            background: #d97706;
        }

        .admin-stats-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .admin-stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
        }

        .admin-stats-label {
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .admin-filter-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .admin-empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            color: #6b7280;
        }

        .admin-empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .admin-pagination {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .admin-pagination .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .admin-pagination .page-item {
            margin: 0 0.25rem;
        }

        .admin-pagination .page-link {
            display: block;
            padding: 0.5rem 0.75rem;
            color: #3b82f6;
            text-decoration: none;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            transition: all 0.15s ease-in-out;
        }

        .admin-pagination .page-link:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }

        .admin-pagination .page-item.active .page-link {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        /* Additional Admin Styles */
        .admin-page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0.75rem;
        }

        .admin-page-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .admin-page-subtitle {
            font-size: 1.125rem;
            opacity: 0.9;
        }

        .admin-stats-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            text-align: center;
        }

        .admin-stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .admin-stats-label {
            color: #6b7280;
            font-size: 0.875rem;
            margin: 0;
        }

        .admin-stats-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            opacity: 0.7;
        }

        .admin-filter-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .admin-empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            color: #6b7280;
        }

        .admin-empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .admin-empty-state-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .admin-empty-state-text {
            margin-bottom: 1.5rem;
        }

        .admin-alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
        }

        .admin-alert-success {
            background: #dcfce7;
            color: #166534;
            border-color: #bbf7d0;
        }

        .admin-alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-color: #fecaca;
        }

        .admin-alert-warning {
            background: #fef3c7;
            color: #92400e;
            border-color: #fde68a;
        }

        .admin-alert-info {
            background: #dbeafe;
            color: #1e40af;
            border-color: #bfdbfe;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .admin-page-header {
                padding: 1.5rem 0;
                margin-bottom: 1rem;
            }

            .admin-page-title {
                font-size: 1.5rem;
            }

            .admin-card-header,
            .admin-card-body {
                padding: 1rem;
            }

            .admin-table {
                font-size: 0.75rem;
            }

            .admin-table th,
            .admin-table td {
                padding: 0.5rem;
            }

            .admin-btn {
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
            }

            .admin-stats-card {
                padding: 1rem;
            }

            .admin-stats-number {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="bg-white shadow-lg w-64 flex-shrink-0 sticky top-0 h-screen overflow-y-auto">
            <div class="p-6 sticky top-0 bg-white z-10">
                <x-site-logo href="{{ route('admin.dashboard') }}" height="3.25rem" />
                <p class="text-gray-600 text-sm mt-2">Admin Panel</p>
            </div>

            <nav class="mt-6 pb-6">
                <div class="px-6 mb-4">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Main</h3>
                </div>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>

                <a href="{{ route('admin.packages') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.packages*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="fas fa-box mr-3"></i>
                    Packages
                </a>

                <a href="{{ route('admin.categories') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.categories*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="fas fa-tags mr-3"></i>
                    Categories
                </a>

                <a href="{{ route('admin.media') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.media*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="fas fa-images mr-3"></i>
                    Media Manager
                </a>

                <a href="{{ route('admin.promo-popup.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.promo-popup*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="fas fa-bullhorn mr-3"></i>
                    Promo Popup
                </a>

                <a href="{{ route('admin.bookings') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.bookings*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="fas fa-calendar-check mr-3"></i>
                    Bookings
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.users*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="fas fa-users mr-3"></i>
                    Users
                </a>

                <a href="{{ route('admin.vehicles.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.vehicles*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="fas fa-car mr-3"></i>
                    Vehicles
                </a>

                <a href="{{ route('admin.locations.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.locations*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="fas fa-map-marker-alt mr-3"></i>
                    Locations
                </a>

                <a href="{{ route('admin.location-vehicle-prices.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.location-vehicle-prices*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="fas fa-route mr-3"></i>
                    Route Pricing
                </a>

                <!-- Blog Management Dropdown -->
                <div class="px-6 mt-6 mb-4">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Content</h3>
                </div>

                <div class="blog-menu">
                    <button class="flex items-center justify-between w-full px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.blog*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}" onclick="toggleBlogMenu()">
                        <div class="flex items-center">
                            <i class="fas fa-blog mr-3"></i>
                            Blog Management
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="blog-chevron"></i>
                    </button>

                    <div class="blog-submenu hidden bg-gray-50" id="blog-submenu">
                        <a href="{{ route('admin.blog.index') }}" class="flex items-center px-8 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.blog.index') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <i class="fas fa-list mr-2"></i>
                            All Posts
                        </a>
                        <a href="{{ route('admin.blog.create') }}" class="flex items-center px-8 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.blog.create') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <i class="fas fa-plus mr-2"></i>
                            New Post
                        </a>
                        <a href="{{ route('admin.blog.index') }}?status=published" class="flex items-center px-8 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                            <i class="fas fa-eye mr-2"></i>
                            Published
                        </a>
                        <a href="{{ route('admin.blog.index') }}?status=draft" class="flex items-center px-8 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i>
                            Drafts
                        </a>
                        <a href="{{ route('admin.blog.index') }}?featured=1" class="flex items-center px-8 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                            <i class="fas fa-star mr-2"></i>
                            Featured
                        </a>
                    </div>
                </div>

                <div class="blog-menu">
                    <button class="flex items-center justify-between w-full px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.reviews*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}" onclick="toggleReviewsMenu()">
                        <div class="flex items-center">
                            <i class="fas fa-star mr-3"></i>
                            Reviews
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="reviews-chevron"></i>
                    </button>

                    <div class="reviews-submenu hidden bg-gray-50" id="reviews-submenu">
                        <a href="{{ route('admin.reviews.index') }}" class="flex items-center px-8 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.reviews.index') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <i class="fas fa-list mr-2"></i>
                            All Reviews
                        </a>
                        <a href="{{ route('admin.reviews.create') }}" class="flex items-center px-8 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.reviews.create') ? 'bg-blue-50 text-blue-600' : '' }}">
                            <i class="fas fa-plus mr-2"></i>
                            Add Review
                        </a>
                        <a href="{{ route('admin.reviews.index') }}?status=approved" class="flex items-center px-8 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                            <i class="fas fa-check mr-2"></i>
                            Approved
                        </a>
                        <a href="{{ route('admin.reviews.index') }}?status=pending" class="flex items-center px-8 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                            <i class="fas fa-clock mr-2"></i>
                            Pending
                        </a>
                        <a href="{{ route('admin.reviews.index') }}?featured=1" class="flex items-center px-8 py-2 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                            <i class="fas fa-star mr-2"></i>
                            Featured
                        </a>
                    </div>
                </div>

                <div class="px-6 mt-6 mb-4">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Website</h3>
                </div>

                <a href="{{ route('admin.about.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.about*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="fas fa-info-circle mr-3"></i>
                    About Pages
                </a>

                <a href="{{ route('admin.social-media.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.social-media*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="fas fa-share-alt mr-3"></i>
                    Social Media
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 {{ request()->routeIs('admin.settings*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <i class="fas fa-cog mr-3"></i>
                    Settings
                </a>

                <a href="{{ route('home') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200" target="_blank">
                    <i class="fas fa-external-link-alt mr-3"></i>
                    View Website
                </a>

                <div class="px-6 mt-6 mb-4">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Account</h3>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="px-6">
                    @csrf
                    <button type="submit" class="flex items-center w-full py-3 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-sm text-gray-600">@yield('page-description', 'Manage your content')</p>
                    </div>

                    <div class="flex items-center space-x-4">
                        @yield('header-actions')
                        <div class="text-sm text-gray-600">
                            Welcome, <span class="font-semibold">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    <!-- Flash Messages -->
                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 animate-slide-in-right">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 animate-slide-in-right">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Menu Toggle -->
    <div class="lg:hidden fixed top-4 left-4 z-50">
        <button id="mobile-menu-toggle" class="bg-white p-2 rounded-md shadow-md">
            <i class="fas fa-bars text-gray-600"></i>
        </button>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-sidebar-overlay" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
            const sidebar = document.querySelector('.bg-white.shadow-lg');
            const overlay = document.getElementById('mobile-sidebar-overlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        // Blog menu toggle
        function toggleBlogMenu() {
            const submenu = document.getElementById('blog-submenu');
            const chevron = document.getElementById('blog-chevron');

            submenu.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }

        // Reviews menu toggle
        function toggleReviewsMenu() {
            const submenu = document.getElementById('reviews-submenu');
            const chevron = document.getElementById('reviews-chevron');

            submenu.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }

        // Auto-open blog menu if on blog pages
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.pathname.includes('/admin/blog')) {
                const submenu = document.getElementById('blog-submenu');
                const chevron = document.getElementById('blog-chevron');

                submenu.classList.remove('hidden');
                chevron.classList.add('rotate-180');
            }

            if (window.location.pathname.includes('/admin/reviews')) {
                const submenu = document.getElementById('reviews-submenu');
                const chevron = document.getElementById('reviews-chevron');

                submenu.classList.remove('hidden');
                chevron.classList.add('rotate-180');
            }
        });

        // Close mobile menu when clicking overlay
        document.getElementById('mobile-sidebar-overlay').addEventListener('click', function() {
            const sidebar = document.querySelector('.bg-white.shadow-lg');
            const overlay = document.getElementById('mobile-sidebar-overlay');

            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Auto-hide flash messages
        setTimeout(function() {
            const messages = document.querySelectorAll('.animate-slide-in-right');
            messages.forEach(function(message) {
                message.style.transition = 'transform 0.3s ease-out';
                message.style.transform = 'translateX(100%)';
                setTimeout(function() {
                    message.remove();
                }, 300);
            });
        }, 5000);

        // Confirm delete actions
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-btn')) {
                if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                    e.preventDefault();
                }
            }
        });
    </script>

    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in-right {
            animation: slideInRight 0.3s ease-out;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        @media (max-width: 1024px) {
            .bg-white.shadow-lg {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform 0.3s ease-out;
                overflow-y: auto;
            }
        }

        /* Custom scrollbar for sidebar */
        .bg-white.shadow-lg::-webkit-scrollbar {
            width: 6px;
        }

        .bg-white.shadow-lg::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .bg-white.shadow-lg::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .bg-white.shadow-lg::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>

    <!-- Media Manager Script -->
    <script src="{{ asset('js/media-manager.js') }}"></script>

    <!-- Include Media Manager Modal -->
    @include('components.media-manager-modal')

    @yield('scripts')
    @stack('scripts')
</body>
</html>
