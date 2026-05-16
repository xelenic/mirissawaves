<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoPopupSlide;
use App\Models\Setting;
use App\Services\GeminiBannerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class PromoPopupController extends Controller
{
    public function index()
    {
        $slides = PromoPopupSlide::with('media')->ordered()->get();
        $popupEnabled = Setting::get('promo_popup_enabled', '1') === '1';

        return view('admin.promo-popup.index', compact('slides', 'popupEnabled'));
    }

    public function create(GeminiBannerService $gemini)
    {
        return view('admin.promo-popup.create', [
            'geminiConfigured' => $gemini->isConfigured(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'media_id' => 'required|exists:media,id',
            'link' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? (PromoPopupSlide::max('sort_order') + 1);

        PromoPopupSlide::create($validated);

        return redirect()->route('admin.promo-popup.index')
            ->with('success', 'Promo slide added successfully.');
    }

    public function edit(PromoPopupSlide $slide, GeminiBannerService $gemini)
    {
        $slide->load('media');

        return view('admin.promo-popup.edit', [
            'slide' => $slide,
            'geminiConfigured' => $gemini->isConfigured(),
        ]);
    }

    public function generateBanner(Request $request, GeminiBannerService $gemini): JsonResponse
    {
        if (!$gemini->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'Gemini API key is not configured. Add GEMINI_API_KEY to your .env file.',
            ], 503);
        }

        $validated = $request->validate([
            'prompt' => 'required|string|min:10|max:480',
            'aspect_ratio' => 'nullable|in:1:1,3:4,4:3,9:16,16:9',
        ]);

        try {
            $result = $gemini->generate(
                $validated['prompt'],
                $validated['aspect_ratio'] ?? '9:16'
            );

            return response()->json([
                'success' => true,
                'message' => 'Banner generated successfully.',
                'media' => $result,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function update(Request $request, PromoPopupSlide $slide)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'media_id' => 'required|exists:media,id',
            'link' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $slide->update($validated);

        return redirect()->route('admin.promo-popup.index')
            ->with('success', 'Promo slide updated successfully.');
    }

    public function destroy(PromoPopupSlide $slide)
    {
        $slide->delete();

        return redirect()->route('admin.promo-popup.index')
            ->with('success', 'Promo slide deleted successfully.');
    }

    public function toggleStatus(PromoPopupSlide $slide)
    {
        $slide->update(['is_active' => !$slide->is_active]);

        $status = $slide->is_active ? 'activated' : 'deactivated';

        return redirect()->back()->with('success', "Slide {$status} successfully.");
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'promo_popup_enabled' => 'required|boolean',
        ]);

        Setting::set('promo_popup_enabled', $request->boolean('promo_popup_enabled') ? '1' : '0');

        return redirect()->route('admin.promo-popup.index')
            ->with('success', 'Popup settings saved successfully.');
    }
}
