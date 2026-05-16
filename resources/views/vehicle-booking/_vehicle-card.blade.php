@php
    $details = [$vehicle['type_display']];
    if ($vehicle['brand'] || $vehicle['model']) {
        $details[] = trim(($vehicle['brand'] ?? '') . ' ' . ($vehicle['model'] ?? ''));
    }
@endphp
<article
    class="vehicle-card"
    data-vehicle-id="{{ $vehicle['id'] }}"
    data-type="{{ $vehicle['type'] }}"
    data-pax="{{ $vehicle['pax_count'] }}"
    data-seats="{{ $vehicle['passenger_count'] }}"
    data-price="{{ $vehicle['total_price'] }}"
    data-name="{{ strtolower($vehicle['name']) }}"
    data-type-label="{{ strtolower($vehicle['type_display']) }}"
    data-fuel="{{ strtolower($vehicle['fuel_type'] ?? '') }}"
    data-features="{{ implode('|', array_map('strtolower', $vehicle['features'] ?? [])) }}"
    data-amenities="{{ implode('|', array_map('strtolower', $vehicle['amenities'] ?? [])) }}"
>
    <div class="vehicle-card__media js-vehicle-image-preview" title="Hover to view full size">
        <img src="{{ $vehicle['image_url'] }}" alt="{{ $vehicle['name'] }}" class="vehicle-card__img" loading="lazy">
        <span class="vehicle-card__type-badge">{{ $vehicle['type_display'] }}</span>
    </div>
    <div class="vehicle-card__body">
        <div class="vehicle-card__main">
            <div class="vehicle-card__info">
                <h2 class="vehicle-card__title">{{ $vehicle['name'] }}</h2>
                <p class="vehicle-card__meta">{{ implode(' · ', $details) }}</p>
                <div class="vehicle-card__stats">
                    <span class="vehicle-card__stat"><i class="fas fa-users"></i> {{ $vehicle['pax_count'] }} pax</span>
                    @if(($vehicle['passenger_count'] ?? 0) !== ($vehicle['pax_count'] ?? 0))
                        <span class="vehicle-card__stat"><i class="fas fa-chair"></i> {{ $vehicle['passenger_count'] }} seats</span>
                    @endif
                    @if(!empty($vehicle['fuel_type']))
                        <span class="vehicle-card__stat"><i class="fas fa-gas-pump"></i> {{ $vehicle['fuel_type'] }}</span>
                    @endif
                </div>
                @if(!empty($vehicle['features']) || !empty($vehicle['amenities']))
                    <div class="vehicle-card__tags">
                        @foreach($vehicle['features'] ?? [] as $feature)
                            <span class="vehicle-card__tag vehicle-card__tag--feature">{{ $feature }}</span>
                        @endforeach
                        @foreach($vehicle['amenities'] ?? [] as $amenity)
                            <span class="vehicle-card__tag vehicle-card__tag--amenity">{{ $amenity }}</span>
                        @endforeach
                    </div>
                @endif
                @if($vehicle['description'])
                    <p class="vehicle-card__desc">{{ $vehicle['description'] }}</p>
                @endif
                @if(!empty($vehicle['price_breakdown']))
                    <div class="vehicle-card__breakdown">
                        @foreach($vehicle['price_breakdown'] as $line)
                            <span>{{ $line }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="vehicle-card__aside">
                <p class="vehicle-card__price vehicle-card-price">{{ $vehicle['formatted_price'] }}</p>
                <p class="vehicle-card__price-note">for this route</p>
                <button type="button"
                    class="book-vehicle-btn vehicle-card__cta"
                    data-vehicle-id="{{ $vehicle['id'] }}"
                    data-vehicle-name="{{ $vehicle['name'] }}"
                    data-vehicle-image="{{ $vehicle['image_url'] }}"
                    data-vehicle-type="{{ $vehicle['type_display'] }}"
                    data-vehicle-brand="{{ $vehicle['brand'] ?? '' }}"
                    data-vehicle-model="{{ $vehicle['model'] ?? '' }}"
                    data-vehicle-fuel="{{ $vehicle['fuel_type'] ?? '' }}"
                    data-vehicle-pax="{{ $vehicle['pax_count'] }}"
                    data-vehicle-seats="{{ $vehicle['passenger_count'] }}"
                    data-vehicle-description="{{ \Illuminate\Support\Str::limit($vehicle['description'] ?? '', 280) }}"
                    data-max-pax="{{ $vehicle['pax_count'] }}"
                    data-formatted-price="{{ $vehicle['formatted_price'] }}"
                    data-total-price="{{ $vehicle['total_price'] }}"
                    data-pricing-type="{{ $vehicle['pricing_type'] }}"
                    data-formatted-per-km="{{ $vehicle['formatted_per_km'] ?? '' }}"
                    data-formatted-first-km="{{ $vehicle['formatted_price_first_km'] ?? '' }}"
                    data-formatted-per-100m="{{ $vehicle['formatted_price_per_100m'] ?? '' }}"
                    data-vehicle-features='@json($vehicle['features'] ?? [])'
                    data-vehicle-amenities='@json($vehicle['amenities'] ?? [])'>
                    Book this vehicle
                </button>
            </div>
        </div>
    </div>
</article>
