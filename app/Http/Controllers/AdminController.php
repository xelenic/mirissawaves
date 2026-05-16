<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\Media;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Booking;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_packages' => Package::count(),
            'active_packages' => Package::where('is_active', true)->count(),
            'featured_packages' => Package::where('is_featured', true)->count(),
            'total_categories' => PackageCategory::count(),
            'recent_packages' => Package::with(['category', 'media'])->latest()->limit(5)->get(),
            'total_blogs' => Blog::count(),
            'published_blogs' => Blog::where('is_published', true)->count(),
            'draft_blogs' => Blog::where('is_published', false)->count(),
            'featured_blogs' => Blog::where('is_featured', true)->count(),
            'total_blog_categories' => BlogCategory::count(),
            'recent_blogs' => Blog::with('category')->latest()->limit(5)->get(),
            'total_views' => Blog::sum('views_count'),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'cancelled_bookings' => Booking::where('status', 'cancelled')->count(),
            'pending_payments' => Booking::where('payment_status', 'pending')->count(),
            'paid_bookings' => Booking::where('payment_status', 'paid')->count(),
            'failed_payments' => Booking::where('payment_status', 'failed')->count(),
            'recent_bookings' => Booking::with(['package', 'package.media', 'package.category', 'vehicle', 'pickupLocation', 'destinationLocation', 'user'])->latest()->limit(5)->get(),
            'total_revenue' => Booking::where('payment_status', 'paid')->sum('total_amount'),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // Package Management
    public function packages()
    {
        $packages = Package::with(['category', 'media'])->latest()->paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    public function createPackage()
    {
        $categories = PackageCategory::active()->ordered()->get();
        return view('admin.packages.create', compact('categories'));
    }

    public function storePackage(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'duration' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'package_category_id' => 'required|exists:package_categories,id',
            'difficulty' => 'required|in:Easy,Moderate,Hard',
            'group_size' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'media_id' => 'nullable|exists:media,id',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'exists:media,id',
            'highlights' => 'nullable|array',
            'highlights.*' => 'string|max:255',
            'included' => 'nullable|string',
            'not_included' => 'nullable|string',
            'itinerary' => 'nullable|string',
            'requirements' => 'nullable|string',
            'cancellation_policy' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        // Generate slug
        $data['slug'] = Str::slug($request->title);
        
        // Handle image upload or media selection
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages', 'public');
        } elseif ($request->has('media_id')) {
            $media = Media::find($request->media_id);
            if ($media) {
                $data['image'] = $media->path;
            }
        }
        
        // Handle highlights array
        if ($request->has('highlights')) {
            $data['highlights'] = array_filter($request->highlights);
        }
        
        // Set default values
        $data['rating'] = 0;
        $data['reviews_count'] = 0;
        $data['sort_order'] = 0;

        Package::create($data);

        return redirect()->route('admin.packages')->with('success', 'Package created successfully!');
    }

    public function editPackage(Package $package)
    {
        $categories = PackageCategory::active()->ordered()->get();
        return view('admin.packages.edit', compact('package', 'categories'));
    }

    public function updatePackage(Request $request, Package $package)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'duration' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'package_category_id' => 'required|exists:package_categories,id',
            'difficulty' => 'required|in:Easy,Moderate,Hard',
            'group_size' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'highlights' => 'nullable|array',
            'highlights.*' => 'string|max:255',
            'included' => 'nullable|string',
            'not_included' => 'nullable|string',
            'itinerary' => 'nullable|string',
            'requirements' => 'nullable|string',
            'cancellation_policy' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        // Generate slug
        $data['slug'] = Str::slug($request->title);
        
        // Handle image upload or media selection
        if ($request->hasFile('image')) {
            // Delete old image
            if ($package->image) {
                Storage::disk('public')->delete($package->image);
            }
            $data['image'] = $request->file('image')->store('packages', 'public');
        } elseif ($request->has('media_id')) {
            $media = Media::find($request->media_id);
            if ($media) {
                $data['image'] = $media->path;
            }
        }
        
        // Handle highlights array
        if ($request->has('highlights')) {
            $data['highlights'] = array_filter($request->highlights);
        }

        $package->update($data);

        return redirect()->route('admin.packages')->with('success', 'Package updated successfully!');
    }

    public function deletePackage(Package $package)
    {
        // Delete image
        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }
        
        $package->delete();

        return redirect()->route('admin.packages')->with('success', 'Package deleted successfully!');
    }

    // Category Management
    public function categories()
    {
        $categories = PackageCategory::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|max:7',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['sort_order'] = 0;

        PackageCategory::create($data);

        return redirect()->route('admin.categories')->with('success', 'Category created successfully!');
    }

    public function editCategory(PackageCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, PackageCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|max:7',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $category->update($data);

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
    }

    public function deleteCategory(PackageCategory $category)
    {
        // Check if category has packages
        if ($category->packages()->count() > 0) {
            return redirect()->route('admin.categories')->with('error', 'Cannot delete category with existing packages!');
        }

        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
    }

    // Booking Management
    public function bookings()
    {
        $bookings = Booking::with([
            'package',
            'package.media',
            'package.category',
            'vehicle',
            'pickupLocation',
            'destinationLocation',
            'user',
        ])->latest()->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function showBooking(Booking $booking)
    {
        $booking->load([
            'package',
            'package.category',
            'vehicle',
            'pickupLocation',
            'destinationLocation',
            'user',
        ]);
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Booking status updated successfully!');
    }

    public function updateBooking(Request $request, Booking $booking)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'travel_date' => 'required|date',
            'travelers' => 'required|integer|min:1|max:20',
            'special_requirements' => 'nullable|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $booking->update($request->all());

        return redirect()->back()->with('success', 'Booking updated successfully!');
    }
}