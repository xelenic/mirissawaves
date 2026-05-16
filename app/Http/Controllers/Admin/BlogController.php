<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Media;
use App\Services\GeminiArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class BlogController extends Controller
{
    /**
     * Display a listing of blogs.
     */
    public function index(Request $request)
    {
        $query = Blog::with(['category', 'media'])->latest();

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured == '1') {
            $query->where('is_featured', true);
        }

        $blogs = $query->paginate(10);
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create(GeminiArticleService $gemini)
    {
        $categories = BlogCategory::active()->ordered()->get();

        return view('admin.blog.create', [
            'categories' => $categories,
            'geminiConfigured' => $gemini->isConfigured(),
        ]);
    }

    public function generateArticle(Request $request, GeminiArticleService $gemini): JsonResponse
    {
        if (!$gemini->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'Gemini API key is not configured. Add GEMINI_API_KEY to your .env file.',
            ], 503);
        }

        $validated = $request->validate([
            'topic' => 'required|string|min:5|max:500',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'tone' => 'nullable|in:informative,friendly,professional,adventurous',
        ]);

        $categoryName = null;
        if (!empty($validated['blog_category_id'])) {
            $categoryName = BlogCategory::find($validated['blog_category_id'])?->name;
        }

        try {
            $article = $gemini->generate(
                $validated['topic'],
                $categoryName,
                $validated['tone'] ?? 'informative'
            );

            return response()->json([
                'success' => true,
                'message' => 'Article generated successfully.',
                'article' => $article,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Store a newly created blog.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'media_id' => 'nullable|exists:media,id',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'exists:media,id',
            'tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        
        // Debug: Log the incoming data
        \Log::info('Blog creation data:', $data);
        
        // Generate slug
        $data['slug'] = Str::slug($request->title);
        
        // Handle featured image upload or media selection
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        } elseif ($request->has('media_id')) {
            $media = Media::find($request->media_id);
            if ($media) {
                $data['featured_image'] = $media->path;
            }
        }
        
        // Handle tags array
        if ($request->has('tags') && $request->tags) {
            // Convert comma-separated string to array
            $tags = is_array($request->tags) ? $request->tags : explode(',', $request->tags);
            $data['tags'] = array_filter(array_map('trim', $tags));
        }
        
        // Set default values
        $data['views_count'] = 0;
        $data['sort_order'] = 0;
        
        // Handle boolean fields
        $data['is_published'] = $request->has('is_published');
        $data['is_featured'] = $request->has('is_featured');

        try {
            $blog = Blog::create($data);
            \Log::info('Blog created successfully with ID:', ['id' => $blog->id]);
            return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully!');
        } catch (\Exception $e) {
            \Log::error('Blog creation failed:', ['error' => $e->getMessage(), 'data' => $data]);
            return back()->withInput()->with('error', 'Failed to create blog post: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified blog.
     */
    public function show(Blog $blog)
    {
        return view('admin.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the blog.
     */
    public function edit(Blog $blog, GeminiArticleService $gemini)
    {
        $categories = BlogCategory::active()->ordered()->get();

        return view('admin.blog.edit', [
            'blog' => $blog,
            'categories' => $categories,
            'geminiConfigured' => $gemini->isConfigured(),
        ]);
    }

    /**
     * Update the specified blog.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'media_id' => 'nullable|exists:media,id',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'exists:media,id',
            'tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        
        // Generate slug
        $data['slug'] = Str::slug($request->title);
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($blog->featured_image && !str_starts_with($blog->featured_image, 'slider/')) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        } elseif ($request->has('media_id')) {
            $media = Media::find($request->media_id);
            if ($media) {
                $data['featured_image'] = $media->path;
            }
        }
        
        // Handle tags array
        if ($request->has('tags') && $request->tags) {
            // Convert comma-separated string to array
            $tags = is_array($request->tags) ? $request->tags : explode(',', $request->tags);
            $data['tags'] = array_filter(array_map('trim', $tags));
        }
        
        // Handle boolean fields
        $data['is_published'] = $request->has('is_published');
        $data['is_featured'] = $request->has('is_featured');

        $blog->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog.
     */
    public function destroy(Blog $blog)
    {
        // Delete featured image
        if ($blog->featured_image && !str_starts_with($blog->featured_image, 'slider/')) {
            Storage::disk('public')->delete($blog->featured_image);
        }
        
        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully!');
    }
}