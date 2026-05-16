@extends('layouts.app')

@section('title', 'Choose Your Vehicle - Mirissawaves')
@section('description', 'Compare available vehicles and prices for your Sri Lankan journey.')

@include('vehicle-booking._results-view-styles')
@include('vehicle-booking._booking-modal-styles')
@include('vehicle-booking._vehicle-image-preview')

@section('content')
<section class="vehicle-booking-page py-8 sm:py-12 md:py-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 customer-container max-w-7xl">
        <header class="mb-6 sm:mb-8">
            <a href="{{ url('/') }}#booking" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 mb-3 sm:mb-4">
                <i class="fas fa-arrow-left mr-2" aria-hidden="true"></i> Change route
            </a>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 playfair mb-2 sm:mb-3">Choose your vehicle</h1>
            <p class="text-sm sm:text-base text-gray-600 break-anywhere leading-relaxed">
                <span class="font-medium">{{ $pickupLocation->name }}</span>
                <span class="text-gray-400 mx-1 sm:mx-2" aria-hidden="true">→</span>
                <span class="font-medium">{{ $destinationLocation->name }}</span>
                <span class="text-gray-400 mx-1 sm:mx-2" aria-hidden="true">·</span>
                <span class="whitespace-nowrap">{{ number_format($distanceKm, 2) }} km</span>
            </p>
            <p class="text-xs sm:text-sm text-gray-500 mt-2">
                Pickup {{ \Carbon\Carbon::parse($pickupDate)->format('M j, Y') }} at {{ $pickupTime }}
            </p>
        </header>

        @if(count($vehicles) === 0)
            <div class="bg-white rounded-2xl shadow-md p-12 text-center text-gray-500">
                <i class="fas fa-car text-4xl text-gray-300 mb-4"></i>
                <p>No vehicles are available right now. Please try again later or <a href="{{ url('/') }}#booking" class="text-blue-600 hover:underline">adjust your route</a>.</p>
            </div>
        @else
            <div class="vehicle-booking-layout lg:grid lg:grid-cols-[minmax(0,280px)_1fr] lg:gap-8 items-start">
                <button type="button"
                        id="vehicleFiltersToggle"
                        class="vehicle-filters-toggle lg:hidden w-full flex items-center justify-between gap-3 bg-white border border-gray-200 rounded-xl shadow-sm px-4 py-3 mb-4 text-left font-semibold text-gray-900"
                        aria-expanded="false"
                        aria-controls="vehicleFiltersAside">
                    <span class="inline-flex items-center gap-2">
                        <i class="fas fa-sliders-h text-blue-600" aria-hidden="true"></i>
                        Filters &amp; sort options
                    </span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform vehicle-filters-toggle__icon" aria-hidden="true"></i>
                </button>

                {{-- Filters --}}
                <aside id="vehicleFiltersAside" class="vehicle-filters-panel bg-white rounded-2xl border border-gray-200 shadow-sm p-4 sm:p-5 mb-6 lg:mb-0 lg:sticky lg:top-[calc(var(--site-nav-height,4rem)+1rem)]">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Filters</h2>
                        <button type="button" id="clearVehicleFilters" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Clear all</button>
                    </div>

                    @if(!empty($filterOptions['types']))
                    <div class="mb-5 pb-5 border-b border-gray-100">
                        <label for="filterType" class="block text-sm font-semibold text-gray-700 mb-2">Vehicle type</label>
                        <select id="filterType" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All types</option>
                            @foreach($filterOptions['types'] as $typeValue => $typeLabel)
                                <option value="{{ $typeValue }}">{{ $typeLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="mb-5 pb-5 border-b border-gray-100">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Minimum passengers (pax)</label>
                        <select id="filterMinPax" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Any capacity</option>
                            @for($p = $filterOptions['pax_min']; $p <= $filterOptions['pax_max']; $p++)
                                <option value="{{ $p }}">{{ $p }}+ passengers</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-5 pb-5 border-b border-gray-100">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Minimum seat count</label>
                        <select id="filterMinSeats" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Any seats</option>
                            @for($s = $filterOptions['pax_min']; $s <= $filterOptions['pax_max']; $s++)
                                <option value="{{ $s }}">{{ $s }}+ seats</option>
                            @endfor
                        </select>
                    </div>

                    @if(!empty($filterOptions['fuel_types']))
                    <div class="mb-5 pb-5 border-b border-gray-100">
                        <label for="filterFuel" class="block text-sm font-semibold text-gray-700 mb-2">Fuel type</label>
                        <select id="filterFuel" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All fuel types</option>
                            @foreach($filterOptions['fuel_types'] as $fuel)
                                <option value="{{ strtolower($fuel) }}">{{ $fuel }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    @if(!empty($filterOptions['features']))
                    <div class="mb-5 pb-5 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Features</p>
                        <div class="space-y-2 max-h-40 overflow-y-auto">
                            @foreach($filterOptions['features'] as $feature)
                                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                                    <input type="checkbox" name="filter_features[]" value="{{ $feature }}" class="filter-feature rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span>{{ $feature }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(!empty($filterOptions['amenities']))
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">Amenities</p>
                        <div class="space-y-2 max-h-40 overflow-y-auto">
                            @foreach($filterOptions['amenities'] as $amenity)
                                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                                    <input type="checkbox" name="filter_amenities[]" value="{{ $amenity }}" class="filter-amenity rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span>{{ $amenity }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </aside>

                {{-- Results --}}
                <div class="vehicle-booking-results min-w-0">
                    <div class="vehicle-results-toolbar bg-white rounded-2xl border border-gray-200 shadow-sm px-3 sm:px-4 py-3 mb-4 sm:mb-6">
                        <p class="text-sm text-gray-600 mb-3">
                            Showing <span id="vehicleResultsCount" class="font-semibold text-gray-900">{{ count($vehicles) }}</span>
                            of <span class="font-semibold text-gray-900">{{ count($vehicles) }}</span> vehicles
                        </p>
                        <div class="vehicle-results-toolbar__controls flex flex-col gap-3">
                            <div class="vehicle-view-toggle flex items-center gap-1 p-1 bg-gray-100 rounded-lg w-full sm:w-auto" role="group" aria-label="Layout">
                                <button type="button" id="vehicleViewGrid" class="vehicle-view-btn flex-1 sm:flex-none px-3 py-2.5 rounded-md text-sm font-medium transition-colors min-h-[44px]" title="Grid view" aria-pressed="true">
                                    <i class="fas fa-th-large mr-1.5" aria-hidden="true"></i> Grid
                                </button>
                                <button type="button" id="vehicleViewList" class="vehicle-view-btn vehicle-view-btn--list flex-1 sm:flex-none px-3 py-2.5 rounded-md text-sm font-medium transition-colors min-h-[44px]" title="List view" aria-pressed="false">
                                    <i class="fas fa-list mr-1.5" aria-hidden="true"></i> List
                                </button>
                            </div>
                            <div class="vehicle-sort-row flex flex-col sm:flex-row sm:items-center gap-2 w-full">
                                <label for="vehicleSort" class="text-sm font-medium text-gray-700 shrink-0">Sort by</label>
                                <select id="vehicleSort" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 min-h-[44px]">
                                    <option value="price_asc">Price: low to high</option>
                                    <option value="price_desc">Price: high to low</option>
                                    <option value="name_asc">Name: A to Z</option>
                                    <option value="name_desc">Name: Z to A</option>
                                    <option value="pax_desc">Capacity: high to low</option>
                                    <option value="pax_asc">Capacity: low to high</option>
                                    <option value="type_asc">Type: A to Z</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="vehicleResultsEmpty" class="hidden bg-white rounded-2xl border border-gray-200 p-12 text-center text-gray-500 mb-6">
                        <i class="fas fa-filter text-4xl text-gray-300 mb-4"></i>
                        <p class="mb-3">No vehicles match your filters.</p>
                        <button type="button" id="clearVehicleFiltersEmpty" class="text-blue-600 hover:underline font-medium text-sm">Clear filters</button>
                    </div>

                    <div id="vehicleResultsGrid" class="vehicle-results view-grid">
                        @foreach($vehicles as $vehicle)
                            @include('vehicle-booking._vehicle-card', ['vehicle' => $vehicle])
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

@include('vehicle-booking._booking-modal')
@endsection

@push('scripts')
@php
    $tripContext = [
        'pickupLocation' => $pickupLocation->name,
        'destinationLocation' => $destinationLocation->name,
        'pickupDate' => $pickupDate,
        'pickupTime' => $pickupTime,
        'distanceKm' => $distanceKm,
        'locationIds' => [
            'pickup' => $pickupLocation->id,
            'destination' => $destinationLocation->id,
        ],
    ];
@endphp
<script>
    window.tripContext = @json($tripContext);
    window.currentBookingData = null;
    window.vehicleResultsTotal = {{ count($vehicles) }};
    let vehicleImagePreviewActive = null;

    function showToast(message, type) {
        const bg = type === 'error' ? 'bg-red-500' : type === 'success' ? 'bg-green-500' : 'bg-blue-500';
        const el = document.createElement('div');
        el.className = `fixed top-4 right-4 ${bg} text-white px-4 py-3 rounded-lg shadow-lg z-[10060] text-sm font-medium`;
        el.textContent = message;
        document.body.appendChild(el);
        setTimeout(() => el.remove(), 3500);
    }

    const BOOKING_WIZARD_TOTAL = 3;
    const BOOKING_WIZARD_SUBTITLES = {
        1: 'Review your trip details',
        2: 'Enter passenger and contact information',
        3: 'Review and confirm your booking'
    };

    function setBookingWizardStep(step) {
        const n = Math.max(1, Math.min(BOOKING_WIZARD_TOTAL, step));
        window.bookingWizardStep = n;

        document.querySelectorAll('.booking-wizard-step').forEach(el => {
            const stepNum = Number(el.dataset.wizardStep);
            const active = stepNum === n;
            el.classList.toggle('is-active', active);
            if (active) {
                el.removeAttribute('hidden');
            } else {
                el.setAttribute('hidden', '');
            }
        });

        document.querySelectorAll('.booking-wizard-steps__item[data-wizard-step]').forEach(el => {
            const stepNum = Number(el.dataset.wizardStep);
            el.classList.toggle('is-active', stepNum === n);
            el.classList.toggle('is-done', stepNum < n);
        });

        document.querySelectorAll('.booking-wizard-steps__connector').forEach((el, index) => {
            el.classList.toggle('is-done', index < n - 1);
        });

        const subtitle = document.getElementById('bookingWizardSubtitle');
        if (subtitle) {
            subtitle.textContent = BOOKING_WIZARD_SUBTITLES[n] || '';
        }

        document.getElementById('bookingWizardBack')?.classList.toggle('hidden', n === 1);
        document.getElementById('bookingWizardNext')?.classList.toggle('hidden', n === BOOKING_WIZARD_TOTAL);
        document.getElementById('confirmBookingSubmitBtn')?.classList.toggle('hidden', n !== BOOKING_WIZARD_TOTAL);

        document.querySelector('.booking-modal__dialog')?.classList.toggle('booking-modal--trip-step', n === 1);

        if (n === BOOKING_WIZARD_TOTAL) {
            populateBookingWizardReview();
        }

        const scroll = document.querySelector('.booking-modal__scroll');
        if (scroll) scroll.scrollTop = 0;
    }

    function validateBookingWizardStep(step) {
        if (step === 2) {
            const paxEl = document.getElementById('modalPassengerCount');
            const passengers = parseInt(paxEl?.value, 10);
            const maxPx = window.currentBookingData?.maxPax ? Number(window.currentBookingData.maxPax) : null;

            if (!passengers || passengers < 1) {
                showToast('Enter a valid number of passengers.', 'error');
                paxEl?.focus();
                return false;
            }
            if (maxPx && passengers > maxPx) {
                showToast(`This vehicle holds at most ${maxPx} passengers.`, 'error');
                paxEl?.focus();
                return false;
            }

            const form = document.getElementById('finalBookingForm');
            if (!form) return false;

            const fullName = document.getElementById('fullName');
            const email = document.getElementById('email');
            const phone = document.getElementById('phoneNumber');
            const password = document.getElementById('password');

            if (!fullName?.value.trim()) {
                showToast('Please enter your full name.', 'error');
                fullName?.focus();
                return false;
            }
            if (!email?.value.trim() || !email.value.includes('@')) {
                showToast('Please enter a valid email address.', 'error');
                email?.focus();
                return false;
            }
            if (!phone?.value.trim()) {
                showToast('Please enter your phone number.', 'error');
                phone?.focus();
                return false;
            }
            if (password && password.required && !password.value) {
                showToast('Please enter your password.', 'error');
                password.focus();
                return false;
            }
        }
        return true;
    }

    function populateBookingWizardReview() {
        const set = (id, text) => {
            const el = document.getElementById(id);
            if (el) el.textContent = text || '—';
        };

        const route = document.getElementById('bookingSummaryRoute')?.textContent;
        const datetime = document.getElementById('bookingSummaryDatetime')?.textContent;
        const vehicle = document.getElementById('bookingSummaryVehicle')?.textContent;
        const fare = document.getElementById('bookingSummaryFare')?.textContent;

        set('bookingReviewRoute', route);
        set('bookingReviewDatetime', datetime);
        set('bookingReviewVehicle', vehicle);

        const distKm = window.currentBookingData?.distanceKm;
        const distText = distKm != null ? `${Number(distKm).toFixed(2)} km` : null;
        const distRow = document.getElementById('bookingReviewDistanceRow');
        if (distRow && distText) {
            set('bookingReviewDistance', distText);
            distRow.classList.remove('hidden');
        } else if (distRow) {
            distRow.classList.add('hidden');
        }

        const fareRow = document.getElementById('bookingReviewFareRow');
        if (fareRow && fare && fare !== '—') {
            set('bookingReviewFare', fare);
            fareRow.classList.remove('hidden');
        } else if (fareRow) {
            fareRow.classList.add('hidden');
        }

        const pax = document.getElementById('modalPassengerCount')?.value;
        set('bookingReviewPassengers', pax ? `${pax} passenger(s)` : '—');
        set('bookingReviewName', document.getElementById('fullName')?.value);
        set('bookingReviewEmail', document.getElementById('email')?.value);
        set('bookingReviewPhone', document.getElementById('phoneNumber')?.value);

        const notes = document.getElementById('specialRequirements')?.value?.trim();
        const notesRow = document.getElementById('bookingReviewNotesRow');
        if (notesRow) {
            if (notes) {
                set('bookingReviewNotes', notes);
                notesRow.classList.remove('hidden');
            } else {
                notesRow.classList.add('hidden');
            }
        }
    }

    function goBookingWizardNext() {
        const step = window.bookingWizardStep || 1;
        if (!validateBookingWizardStep(step)) return;
        if (step < BOOKING_WIZARD_TOTAL) {
            setBookingWizardStep(step + 1);
        }
    }

    function goBookingWizardBack() {
        const step = window.bookingWizardStep || 1;
        if (step > 1) {
            setBookingWizardStep(step - 1);
        }
    }

    function parseVehicleJsonDataset(value) {
        if (!value) return [];
        try {
            const parsed = JSON.parse(value);
            return Array.isArray(parsed) ? parsed.filter(Boolean) : [];
        } catch (_) {
            return [];
        }
    }

    function populateBookingTripPanel(bookingData) {
        const set = (id, text) => {
            const el = document.getElementById(id);
            if (el) el.textContent = text || '—';
        };

        set('bookingSummaryRoute', `${bookingData.pickupLocation} → ${bookingData.destinationLocation}`);
        set('bookingSummaryDatetime', `${bookingData.pickupDate} at ${bookingData.pickupTime}`);
        set('bookingSummaryVehicle', bookingData.vehicle);

        const metaParts = [];
        if (bookingData.vehicleType) metaParts.push(bookingData.vehicleType);
        const brandModel = [bookingData.vehicleBrand, bookingData.vehicleModel].filter(Boolean).join(' ').trim();
        if (brandModel) metaParts.push(brandModel);
        const metaEl = document.getElementById('bookingTripVehicleMeta');
        if (metaEl) metaEl.textContent = metaParts.length ? metaParts.join(' · ') : '—';

        const specsEl = document.getElementById('bookingTripVehicleSpecs');
        if (specsEl) {
            specsEl.innerHTML = '';
            const specs = [];
            if (bookingData.vehiclePax) {
                specs.push({ icon: 'fa-users', text: `Up to ${bookingData.vehiclePax} pax` });
            }
            if (bookingData.vehicleSeats && String(bookingData.vehicleSeats) !== String(bookingData.vehiclePax)) {
                specs.push({ icon: 'fa-chair', text: `${bookingData.vehicleSeats} seats` });
            }
            if (bookingData.vehicleFuel) {
                specs.push({ icon: 'fa-gas-pump', text: bookingData.vehicleFuel });
            }
            specs.forEach(s => {
                const li = document.createElement('li');
                li.innerHTML = `<i class="fas ${s.icon}" aria-hidden="true"></i>${s.text}`;
                specsEl.appendChild(li);
            });
        }

        const descEl = document.getElementById('bookingTripVehicleDesc');
        if (descEl) {
            const desc = (bookingData.vehicleDescription || '').trim();
            if (desc) {
                descEl.textContent = desc;
                descEl.classList.remove('hidden');
            } else {
                descEl.textContent = '';
                descEl.classList.add('hidden');
            }
        }

        const distKm = bookingData.distanceKm != null ? Number(bookingData.distanceKm) : null;
        set('bookingTripDistance', distKm != null && !isNaN(distKm) ? `${distKm.toFixed(2)} km` : '—');

        const rateLabel = document.getElementById('bookingTripRateLabel');
        const rateVal = document.getElementById('bookingTripPerKm');
        if (rateLabel && rateVal) {
            if (bookingData.pricingType === 'standard' && bookingData.formattedPerKm) {
                rateLabel.textContent = 'Per km rate';
                rateVal.textContent = bookingData.formattedPerKm;
            } else if (bookingData.formattedFirstKm) {
                rateLabel.textContent = 'Pricing';
                let rateText = `First km: ${bookingData.formattedFirstKm}`;
                if (bookingData.formattedPer100m) {
                    rateText += ` · +${bookingData.formattedPer100m} per 100m`;
                }
                rateVal.textContent = rateText;
            } else {
                rateLabel.textContent = 'Rate';
                rateVal.textContent = '—';
            }
        }

        const fareEl = document.getElementById('bookingSummaryFare');
        if (fareEl) {
            fareEl.textContent = bookingData.formattedPrice || '—';
        }

        const img = document.getElementById('bookingTripVehicleImage');
        const placeholder = document.getElementById('bookingTripVehiclePlaceholder');
        if (img && placeholder) {
            if (bookingData.vehicleImage) {
                img.src = bookingData.vehicleImage;
                img.alt = bookingData.vehicle || 'Vehicle';
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                img.classList.add('hidden');
                img.removeAttribute('src');
                placeholder.classList.remove('hidden');
            }
        }

        const featuresList = document.getElementById('bookingTripFeaturesList');
        const featuresEmpty = document.getElementById('bookingTripFeaturesEmpty');
        const features = Array.isArray(bookingData.features) ? bookingData.features : [];
        const amenities = Array.isArray(bookingData.amenities) ? bookingData.amenities : [];
        const allTags = [
            ...features.map(f => ({ text: f, type: 'feature' })),
            ...amenities.map(a => ({ text: a, type: 'amenity' }))
        ];

        if (featuresList) {
            featuresList.innerHTML = '';
            if (allTags.length > 0) {
                allTags.forEach(item => {
                    const span = document.createElement('span');
                    span.className = `booking-trip-feature-tag booking-trip-feature-tag--${item.type}`;
                    const icon = document.createElement('i');
                    icon.className = `fas ${item.type === 'amenity' ? 'fa-check-circle' : 'fa-cog'}`;
                    icon.setAttribute('aria-hidden', 'true');
                    span.appendChild(icon);
                    span.appendChild(document.createTextNode(' ' + item.text));
                    featuresList.appendChild(span);
                });
                featuresList.classList.remove('hidden');
            } else {
                featuresList.classList.add('hidden');
            }
        }
        if (featuresEmpty) {
            featuresEmpty.classList.toggle('hidden', allTags.length > 0);
        }
    }

    function showBookingModal(bookingData) {
        window.currentBookingData = bookingData;
        const modal = document.getElementById('bookingModal');

        populateBookingTripPanel(bookingData);

        const paxEl = document.getElementById('modalPassengerCount');
        const paxHint = document.getElementById('modalPassengerHint');
        if (paxEl && bookingData.maxPax) {
            const cap = Number(bookingData.maxPax);
            paxEl.min = 1;
            paxEl.max = Math.max(1, cap);
            let v = parseInt(paxEl.value, 10) || 1;
            if (v > cap) v = cap;
            paxEl.value = String(v);
            if (paxHint) paxHint.textContent = `This vehicle accommodates up to ${cap} passenger(s).`;
        }

        const terms = document.getElementById('terms');
        if (terms) terms.checked = false;

        setBookingWizardStep(1);

        if (modal) {
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('booking-modal-open');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeBookingModal() {
        const modal = document.getElementById('bookingModal');
        if (modal) {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('booking-modal-open');
            document.body.style.overflow = '';
        }
        document.getElementById('vehicleImageHoverPreview')?.classList.remove('is-visible');
        vehicleImagePreviewActive = null;
        setBookingWizardStep(1);
        window.currentBookingData = null;
    }

    async function submitFinalBooking() {
        if (!window.currentBookingData) {
            showToast('Booking data missing. Please try again.', 'error');
            return;
        }
        if (!document.getElementById('terms').checked) {
            showToast('Please accept the terms and conditions.', 'error');
            return;
        }
        const bookingDetails = Object.fromEntries(new FormData(document.getElementById('finalBookingForm')));
        const modalPaxEl = document.getElementById('modalPassengerCount');
        const passengers = parseInt(modalPaxEl && modalPaxEl.value, 10);
        if (!passengers || passengers < 1) {
            showToast('Enter a valid number of passengers.', 'error');
            return;
        }
        const maxPx = window.currentBookingData.maxPax ? Number(window.currentBookingData.maxPax) : null;
        if (maxPx && passengers > maxPx) {
            showToast(`This vehicle holds at most ${maxPx} passengers.`, 'error');
            return;
        }
        const payload = {
            pickupLocation: window.currentBookingData.pickupLocation,
            destinationLocation: window.currentBookingData.destinationLocation,
            pickupDate: window.currentBookingData.pickupDate,
            pickupTime: window.currentBookingData.pickupTime,
            vehicle: window.currentBookingData.vehicle,
            vehicleId: window.currentBookingData.vehicleId,
            passengers,
            locationIds: window.currentBookingData.locationIds,
            customerDetails: {
                fullName: bookingDetails.fullName,
                email: bookingDetails.email,
                phone: bookingDetails.phoneNumber,
                password: bookingDetails.password,
                specialRequirements: bookingDetails.specialRequirements
            }
        };
        if (window.currentBookingData.distanceKm != null) {
            payload.distance_km = window.currentBookingData.distanceKm;
        }
        const btn = document.getElementById('confirmBookingSubmitBtn');
        const orig = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> Processing…';
        try {
            const res = await fetch('{{ route('vehicle.booking.submit') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            if (res.ok && data.success) {
                showToast('Redirecting to payment...', 'success');
                closeBookingModal();
                if (data.payment_url) {
                    setTimeout(() => { window.location.href = data.payment_url; }, 800);
                }
            } else {
                throw new Error(data.message || 'Failed to submit booking');
            }
        } catch (e) {
            showToast(e.message || 'Booking failed.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = orig;
        }
    }

    function getSelectedFilterFeatures() {
        return Array.from(document.querySelectorAll('.filter-feature:checked')).map(el => el.value.toLowerCase());
    }

    function getSelectedFilterAmenities() {
        return Array.from(document.querySelectorAll('.filter-amenity:checked')).map(el => el.value.toLowerCase());
    }

    function vehicleMatchesFilters(card) {
        const typeFilter = (document.getElementById('filterType')?.value || '').toLowerCase();
        if (typeFilter && card.dataset.type !== typeFilter) {
            return false;
        }

        const minPax = parseInt(document.getElementById('filterMinPax')?.value || '', 10);
        if (!isNaN(minPax) && parseInt(card.dataset.pax, 10) < minPax) {
            return false;
        }

        const minSeats = parseInt(document.getElementById('filterMinSeats')?.value || '', 10);
        if (!isNaN(minSeats) && parseInt(card.dataset.seats, 10) < minSeats) {
            return false;
        }

        const fuelFilter = (document.getElementById('filterFuel')?.value || '').toLowerCase();
        if (fuelFilter && card.dataset.fuel !== fuelFilter) {
            return false;
        }

        const selectedFeatures = getSelectedFilterFeatures();
        if (selectedFeatures.length > 0) {
            const cardFeatures = (card.dataset.features || '').split('|').filter(Boolean);
            const hasFeature = selectedFeatures.some(f => cardFeatures.includes(f));
            if (!hasFeature) {
                return false;
            }
        }

        const selectedAmenities = getSelectedFilterAmenities();
        if (selectedAmenities.length > 0) {
            const cardAmenities = (card.dataset.amenities || '').split('|').filter(Boolean);
            const hasAmenity = selectedAmenities.some(a => cardAmenities.includes(a));
            if (!hasAmenity) {
                return false;
            }
        }

        return true;
    }

    function sortVehicleCards(cards) {
        const sortBy = document.getElementById('vehicleSort')?.value || 'price_asc';
        return [...cards].sort((a, b) => {
            switch (sortBy) {
                case 'price_desc':
                    return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                case 'name_asc':
                    return (a.dataset.name || '').localeCompare(b.dataset.name || '');
                case 'name_desc':
                    return (b.dataset.name || '').localeCompare(a.dataset.name || '');
                case 'pax_desc':
                    return parseInt(b.dataset.pax, 10) - parseInt(a.dataset.pax, 10);
                case 'pax_asc':
                    return parseInt(a.dataset.pax, 10) - parseInt(b.dataset.pax, 10);
                case 'type_asc':
                    return (a.dataset.typeLabel || '').localeCompare(b.dataset.typeLabel || '');
                case 'price_asc':
                default:
                    return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
            }
        });
    }

    function applyVehicleFiltersAndSort() {
        const grid = document.getElementById('vehicleResultsGrid');
        const emptyState = document.getElementById('vehicleResultsEmpty');
        const countEl = document.getElementById('vehicleResultsCount');
        if (!grid) return;

        const allCards = Array.from(grid.querySelectorAll('.vehicle-card'));
        const visibleCards = allCards.filter(card => vehicleMatchesFilters(card));
        const sorted = sortVehicleCards(visibleCards);

        allCards.forEach(card => {
            card.classList.add('hidden');
            card.style.order = '';
        });

        sorted.forEach((card, index) => {
            card.classList.remove('hidden');
            card.style.order = String(index);
            grid.appendChild(card);
        });

        const visibleCount = sorted.length;
        if (countEl) {
            countEl.textContent = String(visibleCount);
        }

        if (emptyState) {
            emptyState.classList.toggle('hidden', visibleCount > 0);
            grid.classList.toggle('hidden', visibleCount === 0);
        }
    }

    function clearAllVehicleFilters() {
        const typeEl = document.getElementById('filterType');
        const minPaxEl = document.getElementById('filterMinPax');
        const minSeatsEl = document.getElementById('filterMinSeats');
        const fuelEl = document.getElementById('filterFuel');
        const sortEl = document.getElementById('vehicleSort');

        if (typeEl) typeEl.value = '';
        if (minPaxEl) minPaxEl.value = '';
        if (minSeatsEl) minSeatsEl.value = '';
        if (fuelEl) fuelEl.value = '';
        if (sortEl) sortEl.value = 'price_asc';

        document.querySelectorAll('.filter-feature, .filter-amenity').forEach(el => {
            el.checked = false;
        });

        applyVehicleFiltersAndSort();
    }

    const VEHICLE_VIEW_STORAGE_KEY = 'vehicleBookingResultsView';

    function setVehicleResultsView(mode) {
        const grid = document.getElementById('vehicleResultsGrid');
        const gridBtn = document.getElementById('vehicleViewGrid');
        const listBtn = document.getElementById('vehicleViewList');
        if (!grid) return;

        const isList = mode === 'list';
        grid.classList.remove('view-grid', 'view-list');
        grid.classList.add(isList ? 'view-list' : 'view-grid');

        if (gridBtn) gridBtn.setAttribute('aria-pressed', isList ? 'false' : 'true');
        if (listBtn) listBtn.setAttribute('aria-pressed', isList ? 'true' : 'false');

        try {
            localStorage.setItem(VEHICLE_VIEW_STORAGE_KEY, isList ? 'list' : 'grid');
        } catch (_) {}
    }

    function isVehicleBookingMobile() {
        return window.matchMedia('(max-width: 639px)').matches;
    }

    function initVehicleResultsView() {
        let saved = 'grid';
        try {
            saved = localStorage.getItem(VEHICLE_VIEW_STORAGE_KEY) || 'grid';
        } catch (_) {}
        const useList = saved === 'list' && !isVehicleBookingMobile();
        setVehicleResultsView(useList ? 'list' : 'grid');

        document.getElementById('vehicleViewGrid')?.addEventListener('click', () => setVehicleResultsView('grid'));
        document.getElementById('vehicleViewList')?.addEventListener('click', () => {
            if (isVehicleBookingMobile()) {
                setVehicleResultsView('grid');
                return;
            }
            setVehicleResultsView('list');
        });

        window.addEventListener('resize', function() {
            if (isVehicleBookingMobile() && document.getElementById('vehicleResultsGrid')?.classList.contains('view-list')) {
                setVehicleResultsView('grid');
            }
        });
    }

    function initVehicleFiltersToggle() {
        const toggle = document.getElementById('vehicleFiltersToggle');
        const panel = document.getElementById('vehicleFiltersAside');
        if (!toggle || !panel) return;

        toggle.addEventListener('click', function() {
            const open = panel.classList.toggle('is-open');
            toggle.classList.toggle('is-open', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    function initVehicleImageHoverPreview() {
        const preview = document.getElementById('vehicleImageHoverPreview');
        const previewImg = document.getElementById('vehicleImageHoverPreviewImg');
        if (!preview || !previewImg) return;

        if (preview.parentElement !== document.body) {
            document.body.appendChild(preview);
        }

        function getPreviewSrc(trigger) {
            const img = trigger.tagName === 'IMG' ? trigger : trigger.querySelector('img');
            if (img && img.src && !img.classList.contains('hidden')) {
                return { src: img.src, alt: img.alt || 'Vehicle' };
            }
            const dataSrc = trigger.dataset.previewSrc;
            if (dataSrc) return { src: dataSrc, alt: trigger.dataset.previewAlt || 'Vehicle' };
            return null;
        }

        function positionPreview(e) {
            const pad = 18;
            const rect = preview.getBoundingClientRect();
            const w = rect.width > 0 ? rect.width : 320;
            const h = rect.height > 0 ? rect.height : 240;
            let x = e.clientX + pad;
            let y = e.clientY + pad;
            if (x + w > window.innerWidth - 12) {
                x = e.clientX - w - pad;
            }
            if (y + h > window.innerHeight - 12) {
                y = e.clientY - h - pad;
            }
            x = Math.max(12, Math.min(x, window.innerWidth - w - 12));
            y = Math.max(12, Math.min(y, window.innerHeight - h - 12));
            preview.style.left = `${x}px`;
            preview.style.top = `${y}px`;
        }

        function showPreview(trigger, e) {
            const data = getPreviewSrc(trigger);
            if (!data) return;
            vehicleImagePreviewActive = trigger;
            previewImg.src = data.src;
            previewImg.alt = data.alt;
            preview.classList.add('is-visible');
            preview.removeAttribute('hidden');
            preview.setAttribute('aria-hidden', 'false');
            positionPreview(e);
        }

        function hidePreview() {
            vehicleImagePreviewActive = null;
            preview.classList.remove('is-visible');
            preview.setAttribute('hidden', '');
            preview.setAttribute('aria-hidden', 'true');
            previewImg.removeAttribute('src');
        }

        document.addEventListener('mouseover', function(e) {
            const trigger = e.target.closest('.js-vehicle-image-preview');
            if (!trigger) return;
            if (trigger === vehicleImagePreviewActive) return;
            showPreview(trigger, e);
        });

        document.addEventListener('mouseout', function(e) {
            if (!vehicleImagePreviewActive) return;
            const from = e.target.closest('.js-vehicle-image-preview');
            const to = e.relatedTarget && e.relatedTarget.closest
                ? e.relatedTarget.closest('.js-vehicle-image-preview')
                : null;
            if (from === vehicleImagePreviewActive && from !== to) {
                hidePreview();
            }
        });

        document.addEventListener('mousemove', function(e) {
            if (vehicleImagePreviewActive) {
                positionPreview(e);
            }
        });

        document.addEventListener('scroll', hidePreview, true);
        window.addEventListener('blur', hidePreview);
    }

    function bindBookVehicleButtons() {
        document.querySelectorAll('.book-vehicle-btn').forEach(btn => {
            if (btn.dataset.bound === '1') return;
            btn.dataset.bound = '1';
            btn.addEventListener('click', function() {
                const ctx = window.tripContext;
                showBookingModal({
                    pickupLocation: ctx.pickupLocation,
                    destinationLocation: ctx.destinationLocation,
                    pickupDate: ctx.pickupDate,
                    pickupTime: ctx.pickupTime,
                    vehicle: this.dataset.vehicleName,
                    vehicleId: this.dataset.vehicleId,
                    vehicleImage: this.dataset.vehicleImage || '',
                    vehicleType: this.dataset.vehicleType || '',
                    vehicleBrand: this.dataset.vehicleBrand || '',
                    vehicleModel: this.dataset.vehicleModel || '',
                    vehicleFuel: this.dataset.vehicleFuel || '',
                    vehiclePax: this.dataset.vehiclePax || '',
                    vehicleSeats: this.dataset.vehicleSeats || '',
                    vehicleDescription: this.dataset.vehicleDescription || '',
                    formattedPrice: this.dataset.formattedPrice,
                    totalPrice: this.dataset.totalPrice,
                    distanceKm: ctx.distanceKm,
                    maxPax: this.dataset.maxPax,
                    locationIds: ctx.locationIds,
                    pricingType: this.dataset.pricingType || 'standard',
                    formattedPerKm: this.dataset.formattedPerKm || '',
                    formattedFirstKm: this.dataset.formattedFirstKm || '',
                    formattedPer100m: this.dataset.formattedPer100m || '',
                    features: parseVehicleJsonDataset(this.dataset.vehicleFeatures),
                    amenities: parseVehicleJsonDataset(this.dataset.vehicleAmenities)
                });
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const bookingModalEl = document.getElementById('bookingModal');
        if (bookingModalEl && bookingModalEl.parentElement !== document.body) {
            document.body.appendChild(bookingModalEl);
        }

        initVehicleResultsView();
        initVehicleFiltersToggle();
        initVehicleImageHoverPreview();
        bindBookVehicleButtons();

        ['filterType', 'filterMinPax', 'filterMinSeats', 'filterFuel', 'vehicleSort'].forEach(id => {
            document.getElementById(id)?.addEventListener('change', applyVehicleFiltersAndSort);
        });

        document.querySelectorAll('.filter-feature, .filter-amenity').forEach(el => {
            el.addEventListener('change', applyVehicleFiltersAndSort);
        });

        document.getElementById('clearVehicleFilters')?.addEventListener('click', clearAllVehicleFilters);
        document.getElementById('clearVehicleFiltersEmpty')?.addEventListener('click', clearAllVehicleFilters);

        applyVehicleFiltersAndSort();

        document.getElementById('bookingWizardNext')?.addEventListener('click', goBookingWizardNext);
        document.getElementById('bookingWizardBack')?.addEventListener('click', goBookingWizardBack);
        document.getElementById('confirmBookingSubmitBtn')?.addEventListener('click', submitFinalBooking);
        document.getElementById('bookingModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeBookingModal();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeBookingModal();
        });

        const emailInput = document.getElementById('email');
        if (emailInput && !emailInput.readOnly) {
            emailInput.addEventListener('blur', async function() {
                const email = this.value.trim();
                if (!email.includes('@')) return;
                try {
                    const res = await fetch(`/api/check-user?email=${encodeURIComponent(email)}`);
                    const data = await res.json();
                    const statusDiv = document.getElementById('userStatus');
                    const statusText = document.getElementById('userStatusText');
                    if (statusDiv && statusText) {
                        statusDiv.classList.remove('hidden');
                        statusText.textContent = data.exists ? 'Existing user — enter your password' : 'New user — create a password';
                        statusText.className = 'text-sm font-medium text-blue-600';
                    }
                } catch (_) {}
            });
        }
    });
</script>
@endpush
