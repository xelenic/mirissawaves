<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class ImagePlaceholder
{
    public static function url(string $type = 'blog'): string
    {
        return match ($type) {
            'package' => asset('images/placeholder-package.svg'),
            default => asset('images/placeholder-blog.svg'),
        };
    }

    public static function publicPathExists(string $relativePath): bool
    {
        if ($relativePath === '') {
            return false;
        }

        return is_file(public_path($relativePath));
    }

    public static function storagePathExists(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        return Storage::disk('public')->exists($path);
    }
}
