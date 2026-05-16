<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public const PLATFORMS = [
        'facebook_url' => [
            'label' => 'Facebook',
            'description' => 'Your Facebook page URL (shown on the homepage sidebar).',
            'icon' => 'fab fa-facebook-f',
            'color' => 'bg-[#1877f2]',
            'placeholder' => 'https://www.facebook.com/your-page',
        ],
        'instagram_url' => [
            'label' => 'Instagram',
            'description' => 'Your Instagram profile URL.',
            'icon' => 'fab fa-instagram',
            'color' => 'bg-gradient-to-br from-[#f58529] via-[#dd2a7b] to-[#8134af]',
            'placeholder' => 'https://www.instagram.com/your-profile',
        ],
        'tripadvisor_url' => [
            'label' => 'TripAdvisor',
            'description' => 'Your TripAdvisor business listing URL.',
            'icon' => 'fab fa-tripadvisor',
            'color' => 'bg-[#34e0a1] text-gray-900',
            'placeholder' => 'https://www.tripadvisor.com/...',
        ],
    ];

    public function index()
    {
        $this->ensureSettingsExist();

        $links = [];
        foreach (self::PLATFORMS as $key => $meta) {
            $links[$key] = array_merge($meta, [
                'value' => Setting::get($key, ''),
            ]);
        }

        return view('admin.social-media.index', compact('links'));
    }

    public function update(Request $request)
    {
        $rules = [];
        foreach (array_keys(self::PLATFORMS) as $key) {
            $rules[$key] = ['nullable', 'string', 'max:500', 'url'];
        }

        $validated = $request->validate($rules);

        foreach (self::PLATFORMS as $key => $meta) {
            $value = trim((string) ($validated[$key] ?? ''));
            Setting::set($key, $value);
        }

        Setting::clearCache();

        return redirect()
            ->route('admin.social-media.index')
            ->with('success', 'Social media links updated successfully.');
    }

    protected function ensureSettingsExist(): void
    {
        foreach (self::PLATFORMS as $key => $meta) {
            Setting::firstOrCreate(
                ['key' => $key],
                [
                    'value' => '',
                    'type' => 'text',
                    'group' => 'social',
                    'label' => $meta['label'] . ' URL',
                    'description' => $meta['description'],
                    'sort_order' => match ($key) {
                        'facebook_url' => 1,
                        'instagram_url' => 2,
                        'tripadvisor_url' => 4,
                        default => 99,
                    },
                ]
            );
        }
    }
}
