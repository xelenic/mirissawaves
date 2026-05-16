<?php

namespace App\Http\Controllers;

use App\Services\ContactMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request, ContactMailService $contactMail): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'tour_interest' => 'nullable|string|max:100',
            'travel_dates' => 'nullable|string|max:150',
            'group_size' => 'nullable|string|max:50',
            'message' => 'required|string|max:5000',
        ]);

        $inquiry = [
            'name' => trim($validated['first_name'].' '.$validated['last_name']),
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'tour_interest' => $validated['tour_interest'] ?? null,
            'travel_dates' => $validated['travel_dates'] ?? null,
            'group_size' => $validated['group_size'] ?? null,
            'message' => $validated['message'],
        ];

        try {
            $contactMail->send($inquiry);
        } catch (\Throwable $e) {
            Log::error('Contact form email failed', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'We could not send your message right now. Please email us directly at '.config('mail.from.address').'.');
        }

        return back()->with('success', 'Thank you! Your message has been sent. We will reply soon.');
    }
}
