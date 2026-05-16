<div class="bookings-cards-mobile space-y-4 mb-6">
    <h2 class="text-lg font-semibold text-gray-900 px-1">Your Bookings</h2>
    @foreach($bookings as $booking)
    <article class="bg-white rounded-xl shadow-md p-4 border border-gray-100">
        <div class="flex gap-3 mb-3">
            @if($booking->package)
                <img class="h-14 w-14 rounded-lg object-cover shrink-0" src="{{ $booking->package->image_url ?? 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=400' }}" alt="">
                <div class="min-w-0 flex-1">
                    <p class="text-xs text-gray-500">#{{ $booking->id }} · {{ $booking->created_at->format('M d, Y') }}</p>
                    <h3 class="font-semibold text-gray-900 break-anywhere">{{ $booking->package->title ?? 'Package' }}</h3>
                    <p class="text-sm text-gray-500">{{ $booking->package->category->name ?? '' }}</p>
                </div>
            @elseif($booking->vehicle)
                <img class="h-14 w-14 rounded-lg object-cover shrink-0" src="{{ $booking->vehicle->image_url ?? 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=400' }}" alt="">
                <div class="min-w-0 flex-1">
                    <p class="text-xs text-gray-500">#{{ $booking->id }} · {{ $booking->created_at->format('M d, Y') }}</p>
                    <h3 class="font-semibold text-gray-900 break-anywhere">{{ $booking->vehicle->name ?? 'Vehicle' }}</h3>
                    <p class="text-sm text-gray-500">Vehicle booking</p>
                </div>
            @else
                <div class="min-w-0 flex-1">
                    <p class="text-xs text-gray-500">#{{ $booking->id }} · {{ $booking->created_at->format('M d, Y') }}</p>
                    <h3 class="font-semibold text-gray-900">Booking #{{ $booking->id }}</h3>
                </div>
            @endif
        </div>
        <dl class="grid grid-cols-2 gap-2 text-sm mb-3">
            <div>
                <dt class="text-gray-500 text-xs">Travel date</dt>
                <dd class="font-medium text-gray-900">{{ $booking->travel_date->format('M d, Y') }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 text-xs">Travelers</dt>
                <dd class="font-medium text-gray-900">{{ $booking->travelers }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 text-xs">Amount</dt>
                <dd class="font-medium text-gray-900">{{ $booking->formatted_amount }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 text-xs">Status</dt>
                <dd><span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full {{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span></dd>
            </div>
        </dl>
        <div class="flex flex-wrap gap-2 pt-3 border-t border-gray-100">
            <a href="{{ route('my-bookings.show', $booking) }}" class="flex-1 min-w-[7rem] text-center inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg">View</a>
            @if($booking->status === 'pending')
            <a href="{{ route('my-bookings.edit', $booking) }}" class="flex-1 min-w-[7rem] text-center inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-lg">Edit</a>
            <form method="POST" action="{{ route('my-bookings.cancel', $booking) }}" class="flex-1 min-w-[7rem]" onsubmit="return confirm('Cancel this booking?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-3 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg">Cancel</button>
            </form>
            @endif
        </div>
    </article>
    @endforeach
</div>
