<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\User;
use App\Services\BookingNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Check if user is authenticated
            if (Auth::check()) {
                // Authenticated user booking
                $validator = Validator::make($request->all(), [
                    'package_id' => 'required|exists:packages,id',
                    'full_name' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'phone' => 'nullable|string|max:20',
                    'travel_date' => 'required|date|after:today',
                    'travelers' => 'required|integer|min:1|max:20',
                    'special_requirements' => 'nullable|string|max:1000',
                ]);

                if ($validator->fails()) {
                    // Debug: Log request details
                    \Log::info('Validation failed', [
                        'is_ajax' => $request->ajax(),
                        'wants_json' => $request->wantsJson(),
                        'headers' => $request->headers->all(),
                        'errors' => $validator->errors()->toArray()
                    ]);
                    
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Validation failed',
                            'errors' => $validator->errors()
                        ], 422);
                    }
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $package = Package::findOrFail($request->package_id);
                
                $booking = Booking::create([
                    'package_id' => $request->package_id,
                    'user_id' => Auth::id(),
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'travel_date' => $request->travel_date,
                    'travelers' => $request->travelers,
                    'special_requirements' => $request->special_requirements,
                    'total_amount' => $package->price * $request->travelers,
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'booking_type' => 'package',
                ]);

                app(BookingNotificationService::class)->afterBookingCreated($booking);

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Booking created successfully',
                        'redirect_url' => route('payhere.initialize', ['booking_id' => $booking->id])
                    ]);
                }

                // Redirect to payment
                return redirect()->route('payhere.initialize', ['booking_id' => $booking->id]);
            } else {
                // Guest booking with account creation
                $validator = Validator::make($request->all(), [
                    'package_id' => 'required|exists:packages,id',
                    'full_name' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:users,email',
                    'password' => 'required|string|min:8|confirmed',
                    'phone' => 'nullable|string|max:20',
                    'travel_date' => 'required|date|after:today',
                    'travelers' => 'required|integer|min:1|max:20',
                    'special_requirements' => 'nullable|string|max:1000',
                ]);

                if ($validator->fails()) {
                    // Debug: Log request details
                    \Log::info('Guest validation failed', [
                        'is_ajax' => $request->ajax(),
                        'wants_json' => $request->wantsJson(),
                        'headers' => $request->headers->all(),
                        'errors' => $validator->errors()->toArray()
                    ]);
                    
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Validation failed',
                            'errors' => $validator->errors()
                        ], 422);
                    }
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $package = Package::findOrFail($request->package_id);
                
                // Create user account
                $user = User::create([
                    'name' => $request->full_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                // Assign user role to the newly created user
                $user->assignRole('user');

                // Create booking
                $booking = Booking::create([
                    'package_id' => $request->package_id,
                    'user_id' => $user->id,
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'travel_date' => $request->travel_date,
                    'travelers' => $request->travelers,
                    'special_requirements' => $request->special_requirements,
                    'total_amount' => $package->price * $request->travelers,
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'booking_type' => 'package',
                ]);

                app(BookingNotificationService::class)->afterBookingCreated($booking);

                // Auto-login the newly created user
                Auth::login($user);

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Account created and booking confirmed successfully',
                        'redirect_url' => route('payhere.initialize', ['booking_id' => $booking->id])
                    ]);
                }

                // Redirect to payment
                return redirect()->route('payhere.initialize', ['booking_id' => $booking->id]);
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while processing your booking',
                    'error' => $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'An error occurred while processing your booking')->withInput();
        }
    }
}