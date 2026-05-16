<?php

namespace App\Models;

use App\Support\ImagePlaceholder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'blog_category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'images',
        'gallery_images',
        'media_id',
        'tags',
        'meta_title',
        'meta_description',
        'is_published',
        'is_featured',
        'published_at',
        'views_count',
        'sort_order'
    ];

    protected $casts = [
        'images' => 'array',
        'gallery_images' => 'array',
        'tags' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'sort_order' => 'integer'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            if ($blog->is_published && !$blog->published_at) {
                $blog->published_at = now();
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            if ($blog->isDirty('is_published') && $blog->is_published && !$blog->published_at) {
                $blog->published_at = now();
            }
        });
    }

    /**
     * Get the category that owns the blog.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /**
     * Get the media that owns the blog.
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    /**
     * Scope a query to only include published blogs.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include featured blogs.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to order by published date.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Scope a query to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('published_at', 'desc');
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('blog_category_id', $categoryId);
    }

    /**
     * Scope a query to search blogs.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('excerpt', 'like', '%' . $search . '%')
              ->orWhere('content', 'like', '%' . $search . '%')
              ->orWhereJsonContains('tags', $search);
        });
    }

    /**
     * Get the featured image URL.
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->media && ImagePlaceholder::storagePathExists($this->media->path)) {
            return $this->media->url;
        }

        if ($this->featured_image) {
            if (str_starts_with($this->featured_image, 'slider/')) {
                if (ImagePlaceholder::publicPathExists($this->featured_image)) {
                    return asset($this->featured_image);
                }
            } elseif (ImagePlaceholder::storagePathExists($this->featured_image)) {
                return asset('storage/' . $this->featured_image);
            }
        }

        return ImagePlaceholder::url('blog');
    }

    /**
     * Get the reading time in minutes.
     */
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, round($wordCount / 200)); // Assuming 200 words per minute
    }

    /**
     * Get formatted published date.
     */
    public function getFormattedPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('M d, Y') : null;
    }

    /**
     * Increment views count.
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Get related blogs from the same category.
     */
    public function getRelatedBlogs($limit = 3)
    {
        return static::published()
                    ->where('blog_category_id', $this->blog_category_id)
                    ->where('id', '!=', $this->id)
                    ->latest()
                    ->limit($limit)
                    ->get();
    }
}