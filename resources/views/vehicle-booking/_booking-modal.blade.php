<div id="bookingModal" class="booking-modal" role="dialog" aria-modal="true" aria-labelledby="bookingModalTitle" aria-hidden="true">
    <div class="booking-modal__backdrop" onclick="closeBookingModal()" aria-hidden="true"></div>

    <div class="booking-modal__dialog booking-modal__dialog--wizard" onclick="event.stopPropagation()">
        <header class="booking-modal__header">
            <div class="booking-modal__header-inner">
                <div class="booking-modal__header-text">
                    <span class="booking-modal__badge">
                        <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        Secure checkout
                    </span>
                    <h2 id="bookingModalTitle" class="booking-modal__title playfair">Complete Your Booking</h2>
                    <p id="bookingWizardSubtitle" class="booking-modal__subtitle">Review your trip details</p>
                </div>
                <button type="button" onclick="closeBookingModal()" class="booking-modal__close" aria-label="Close booking dialog">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="booking-wizard-nav" aria-label="Booking steps">
                <ol class="booking-wizard-steps">
                    <li class="booking-wizard-steps__item is-active" data-wizard-step="1">
                        <span class="booking-wizard-steps__dot"><i class="fas fa-route"></i></span>
                        <span class="booking-wizard-steps__label">Trip</span>
                    </li>
                    <li class="booking-wizard-steps__connector" aria-hidden="true"></li>
                    <li class="booking-wizard-steps__item" data-wizard-step="2">
                        <span class="booking-wizard-steps__dot"><i class="fas fa-user-edit"></i></span>
                        <span class="booking-wizard-steps__label">Details</span>
                    </li>
                    <li class="booking-wizard-steps__connector" aria-hidden="true"></li>
                    <li class="booking-wizard-steps__item" data-wizard-step="3">
                        <span class="booking-wizard-steps__dot"><i class="fas fa-check-circle"></i></span>
                        <span class="booking-wizard-steps__label">Confirm</span>
                    </li>
                </ol>
            </nav>
        </header>

        <div class="booking-modal__scroll">
            <form id="finalBookingForm" class="booking-wizard" novalidate>
                {{-- Step 1: Trip --}}
                <div class="booking-wizard-step is-active" data-wizard-step="1">
                    <div class="booking-wizard-step1-layout">
                        <aside class="booking-trip-panel" aria-label="Trip and pricing summary">
                            <p class="booking-trip-panel__step">Step 1 of 3 · Trip</p>

                            <div class="booking-trip-panel__media js-vehicle-image-preview" title="Hover to view full size">
                                <img id="bookingTripVehicleImage" src="" alt="" class="booking-trip-panel__img hidden">
                                <div class="booking-trip-panel__img-placeholder" id="bookingTripVehiclePlaceholder" aria-hidden="true">
                                    <i class="fas fa-car"></i>
                                </div>
                            </div>

                            <dl class="booking-trip-panel__stats">
                                <div class="booking-trip-panel__row">
                                    <dt><i class="fas fa-route"></i> Route</dt>
                                    <dd id="bookingSummaryRoute">—</dd>
                                </div>
                                <div class="booking-trip-panel__row">
                                    <dt><i class="fas fa-calendar-alt"></i> Pickup</dt>
                                    <dd id="bookingSummaryDatetime">—</dd>
                                </div>
                                <div class="booking-trip-panel__row">
                                    <dt><i class="fas fa-ruler-horizontal"></i> Distance</dt>
                                    <dd id="bookingTripDistance">—</dd>
                                </div>
                                <div class="booking-trip-panel__row" id="bookingTripPerKmRow">
                                    <dt><i class="fas fa-tag"></i> <span id="bookingTripRateLabel">Per km rate</span></dt>
                                    <dd id="bookingTripPerKm">—</dd>
                                </div>
                            </dl>

                            <div class="booking-trip-panel__total" id="bookingSummaryFareWrap">
                                <p class="booking-trip-panel__total-label">Total cost</p>
                                <p class="booking-trip-panel__total-amount" id="bookingSummaryFare">—</p>
                                <p class="booking-trip-panel__total-note">Final price confirmed at payment</p>
                            </div>
                        </aside>

                        <div class="booking-trip-vehicle-panel" aria-label="Vehicle details">
                            <div class="booking-trip-vehicle-panel__details">
                                <h3 class="booking-trip-vehicle-panel__name" id="bookingSummaryVehicle">—</h3>
                                <p class="booking-trip-vehicle-panel__meta" id="bookingTripVehicleMeta">—</p>
                                <ul class="booking-trip-vehicle-panel__specs" id="bookingTripVehicleSpecs"></ul>
                                <p class="booking-trip-vehicle-panel__desc hidden" id="bookingTripVehicleDesc"></p>
                            </div>

                            <div class="booking-trip-vehicle-panel__features" id="bookingTripFeaturesSection">
                                <h4 class="booking-trip-vehicle-panel__features-title"><i class="fas fa-star" aria-hidden="true"></i> Features &amp; amenities</h4>
                                <div id="bookingTripFeaturesList" class="booking-trip-vehicle-panel__features-grid"></div>
                                <p id="bookingTripFeaturesEmpty" class="booking-trip-vehicle-panel__features-empty hidden">No features listed for this vehicle.</p>
                            </div>

                            <p class="booking-trip-vehicle-panel__hint">Review vehicle details and features, then continue to enter passenger information.</p>
                        </div>
                    </div>
                </div>

                {{-- Step 2: Details --}}
                <div class="booking-wizard-step" data-wizard-step="2" hidden>
                    <section class="booking-form-section" aria-labelledby="bookingSectionPassengers">
                        <h3 id="bookingSectionPassengers" class="booking-form-section__title">
                            <i class="fas fa-users" aria-hidden="true"></i> Passengers
                        </h3>
                        <div class="booking-pax-card">
                            <span class="booking-pax-card__icon" aria-hidden="true"><i class="fas fa-user-friends"></i></span>
                            <div class="booking-pax-card__control">
                                <label for="modalPassengerCount">Number of passengers <span class="required">*</span></label>
                                <input type="number" id="modalPassengerCount" name="modalPassengerCount" min="1" value="1" required class="booking-input">
                                <p id="modalPassengerHint" class="booking-pax-hint"></p>
                            </div>
                        </div>
                    </section>

                    <section class="booking-form-section" aria-labelledby="bookingSectionContact">
                        <h3 id="bookingSectionContact" class="booking-form-section__title">
                            <i class="fas fa-id-card" aria-hidden="true"></i> Contact details
                        </h3>
                        @auth
                        <div class="booking-auth-banner">
                            <i class="fas fa-circle-check" aria-hidden="true"></i>
                            <span>Signed in as <strong>{{ Auth::user()->email }}</strong></span>
                        </div>
                        <div class="booking-field-grid booking-field-grid--2">
                            <div class="booking-field">
                                <label for="fullName">Full name <span class="required">*</span></label>
                                <div class="booking-input-wrap">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                    <input type="text" id="fullName" name="fullName" value="{{ Auth::user()->name }}" required readonly class="booking-input">
                                </div>
                            </div>
                            <div class="booking-field">
                                <label for="email">Email <span class="required">*</span></label>
                                <div class="booking-input-wrap">
                                    <i class="fas fa-envelope" aria-hidden="true"></i>
                                    <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required readonly class="booking-input">
                                </div>
                            </div>
                        </div>
                        <div class="booking-field">
                            <label for="phoneNumber">Phone number <span class="required">*</span></label>
                            <div class="booking-input-wrap">
                                <i class="fas fa-phone" aria-hidden="true"></i>
                                <input type="tel" id="phoneNumber" name="phoneNumber" required placeholder="+94 7X XXX XXXX" class="booking-input">
                            </div>
                            <input type="hidden" name="password" value="">
                        </div>
                        @else
                        <div class="booking-field-grid booking-field-grid--2">
                            <div class="booking-field">
                                <label for="fullName">Full name <span class="required">*</span></label>
                                <div class="booking-input-wrap">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                    <input type="text" id="fullName" name="fullName" required placeholder="Your full name" class="booking-input">
                                </div>
                            </div>
                            <div class="booking-field">
                                <label for="email">Email <span class="required">*</span></label>
                                <div class="booking-input-wrap">
                                    <i class="fas fa-envelope" aria-hidden="true"></i>
                                    <input type="email" id="email" name="email" required placeholder="you@example.com" class="booking-input">
                                </div>
                            </div>
                        </div>
                        <div class="booking-field-grid booking-field-grid--2">
                            <div class="booking-field">
                                <label for="phoneNumber">Phone number <span class="required">*</span></label>
                                <div class="booking-input-wrap">
                                    <i class="fas fa-phone" aria-hidden="true"></i>
                                    <input type="tel" id="phoneNumber" name="phoneNumber" required placeholder="+94 7X XXX XXXX" class="booking-input">
                                </div>
                            </div>
                            <div class="booking-field" id="loginSection">
                                <label for="password">Password <span class="required">*</span></label>
                                <div class="booking-input-wrap">
                                    <i class="fas fa-lock" aria-hidden="true"></i>
                                    <input type="password" id="password" name="password" required placeholder="••••••••" class="booking-input">
                                </div>
                                <p id="passwordHint" class="booking-pax-hint">Use your account password, or choose one to register.</p>
                                <div id="userStatus" class="hidden"><span id="userStatusText"></span></div>
                            </div>
                        </div>
                        @endauth
                    </section>

                    <section class="booking-form-section" aria-labelledby="bookingSectionNotes">
                        <h3 id="bookingSectionNotes" class="booking-form-section__title">
                            <i class="fas fa-comment-dots" aria-hidden="true"></i> Additional notes
                        </h3>
                        <div class="booking-field">
                            <label for="specialRequirements">Special requirements <span class="optional">(optional)</span></label>
                            <textarea id="specialRequirements" name="specialRequirements" rows="2" class="booking-textarea"
                                placeholder="Child seat, luggage, pickup instructions…"></textarea>
                        </div>
                    </section>
                </div>

                {{-- Step 3: Confirm --}}
                <div class="booking-wizard-step" data-wizard-step="3" hidden>
                    <p class="booking-wizard-step__lead">Review everything below, then proceed to payment.</p>
                    <div class="booking-wizard-review">
                        <div class="booking-wizard-review__block">
                            <h4 class="booking-wizard-review__heading"><i class="fas fa-route"></i> Trip</h4>
                            <dl class="booking-wizard-review__list">
                                <div><dt>Route</dt><dd id="bookingReviewRoute">—</dd></div>
                                <div><dt>Pickup</dt><dd id="bookingReviewDatetime">—</dd></div>
                                <div><dt>Vehicle</dt><dd id="bookingReviewVehicle">—</dd></div>
                                <div id="bookingReviewDistanceRow"><dt>Distance</dt><dd id="bookingReviewDistance">—</dd></div>
                                <div id="bookingReviewFareRow" class="hidden"><dt>Fare</dt><dd id="bookingReviewFare" class="booking-wizard-review__fare">—</dd></div>
                            </dl>
                        </div>
                        <div class="booking-wizard-review__block">
                            <h4 class="booking-wizard-review__heading"><i class="fas fa-users"></i> Booking</h4>
                            <dl class="booking-wizard-review__list">
                                <div><dt>Passengers</dt><dd id="bookingReviewPassengers">—</dd></div>
                                <div><dt>Name</dt><dd id="bookingReviewName">—</dd></div>
                                <div><dt>Email</dt><dd id="bookingReviewEmail">—</dd></div>
                                <div><dt>Phone</dt><dd id="bookingReviewPhone">—</dd></div>
                                <div id="bookingReviewNotesRow" class="hidden"><dt>Notes</dt><dd id="bookingReviewNotes">—</dd></div>
                            </dl>
                        </div>
                    </div>
                    <div class="booking-terms">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            I agree to the <a href="/terms" target="_blank" rel="noopener">Terms of Service</a>
                            and <a href="/privacy" target="_blank" rel="noopener">Privacy Policy</a>.
                        </label>
                    </div>
                </div>
            </form>
        </div>

        <footer class="booking-modal__footer">
            <p class="booking-modal__footer-trust">
                <i class="fas fa-lock" aria-hidden="true"></i>
                Encrypted checkout · Powered by PayHere
            </p>
            <div class="booking-modal__footer-actions">
                <button type="button" onclick="closeBookingModal()" class="booking-btn booking-btn--ghost" id="bookingWizardCancel">Cancel</button>
                <button type="button" id="bookingWizardBack" class="booking-btn booking-btn--ghost hidden">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i> Back
                </button>
                <button type="button" id="bookingWizardNext" class="booking-btn booking-btn--primary">
                    Continue <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </button>
                <button type="button" id="confirmBookingSubmitBtn" class="booking-btn booking-btn--primary hidden">
                    <i class="fas fa-credit-card" aria-hidden="true"></i>
                    Confirm &amp; Pay
                </button>
            </div>
        </footer>
    </div>
</div>
