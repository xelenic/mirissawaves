@if(isset($promoSlides) && $promoSlides->isNotEmpty())
<div id="startup-offers-popup" class="fixed inset-0 z-[100000] hidden items-center justify-center p-3 sm:p-6" role="dialog" aria-label="Promotional offer" aria-modal="true">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm startup-offers-backdrop opacity-0 transition-opacity duration-500" data-close-popup></div>

    <div class="startup-offers-panel relative w-full max-w-lg sm:max-w-2xl md:max-w-4xl opacity-0 scale-90 transition-all duration-500">
        <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl ring-1 ring-white/10 aspect-[3/4] sm:aspect-[4/5] md:aspect-[16/10] max-h-[90vh] w-full bg-black">
            <div class="swiper startup-offers-swiper absolute inset-0 h-full w-full">
                <div class="swiper-wrapper h-full">
                    @foreach($promoSlides as $slide)
                    <div class="swiper-slide h-full">
                        @if($slide->link)
                        <a href="{{ str_starts_with($slide->link, 'http') ? $slide->link : url($slide->link) }}" class="block w-full h-full startup-promo-slide-link" data-close-popup>
                            <img
                                src="{{ $slide->image_url }}"
                                alt="{{ $slide->title ?? 'Special offer' }}"
                                class="w-full h-full object-cover object-center select-none"
                                loading="eager"
                                draggable="false"
                            >
                        </a>
                        @else
                        <img
                            src="{{ $slide->image_url }}"
                            alt="{{ $slide->title ?? 'Special offer' }}"
                            class="w-full h-full object-cover object-center select-none"
                            loading="eager"
                            draggable="false"
                        >
                        @endif
                    </div>
                    @endforeach
                </div>

                @if($promoSlides->count() > 1)
                <div class="swiper-pagination startup-offers-pagination"></div>
                @endif
            </div>

            <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-black/50 to-transparent pointer-events-none z-10"></div>
            <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/40 to-transparent pointer-events-none z-10"></div>

            <button
                type="button"
                data-close-popup
                class="absolute top-3 right-3 sm:top-4 sm:right-4 z-20 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-black/40 hover:bg-black/60 backdrop-blur-md text-white flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-90 border border-white/20"
                aria-label="Close"
            >
                <i class="fas fa-times text-lg"></i>
            </button>

            @if($promoSlides->count() > 1)
            <button type="button" class="startup-promo-prev absolute left-2 sm:left-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-black/35 hover:bg-black/55 backdrop-blur-md text-white flex items-center justify-center border border-white/15 transition-all duration-300 hover:scale-105" aria-label="Previous">
                <i class="fas fa-chevron-left text-sm"></i>
            </button>
            <button type="button" class="startup-promo-next absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-black/35 hover:bg-black/55 backdrop-blur-md text-white flex items-center justify-center border border-white/15 transition-all duration-300 hover:scale-105" aria-label="Next">
                <i class="fas fa-chevron-right text-sm"></i>
            </button>
            @endif

            <button
                type="button"
                id="startup-offers-dismiss-permanent"
                class="absolute bottom-3 left-3 sm:bottom-4 sm:left-4 z-20 text-[11px] sm:text-xs text-white/80 hover:text-white underline-offset-2 hover:underline transition-colors"
            >
                Don't show again
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes startupPopupIn {
        from { opacity: 0; transform: scale(0.88); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes startupBackdropIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes startupKenBurns {
        from { transform: scale(1.05); }
        to { transform: scale(1.12); }
    }

    #startup-offers-popup.is-visible {
        display: flex;
    }
    #startup-offers-popup.is-visible .startup-offers-backdrop {
        opacity: 1;
        animation: startupBackdropIn 0.45s ease forwards;
    }
    #startup-offers-popup.is-visible .startup-offers-panel {
        animation: startupPopupIn 0.55s cubic-bezier(0.34, 1.4, 0.64, 1) forwards;
    }

    .startup-offers-swiper .swiper-slide-active img {
        animation: startupKenBurns 6s ease-out forwards;
    }

    .startup-offers-pagination {
        bottom: 14px !important;
    }
    .startup-offers-pagination .swiper-pagination-bullet {
        width: 8px;
        height: 8px;
        background: rgba(255, 255, 255, 0.45);
        opacity: 1;
        transition: all 0.35s ease;
    }
    .startup-offers-pagination .swiper-pagination-bullet-active {
        width: 24px;
        border-radius: 4px;
        background: #fff;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('startup-offers-popup');
    if (!popup) return;

    const STORAGE_KEY = 'mirissawaves_promo_popup_seen';
    const LEGACY_STORAGE_KEY = 'ceylon_mirissa_promo_popup_seen';

    if (localStorage.getItem(STORAGE_KEY) === '1') {
        return;
    }
    if (localStorage.getItem(LEGACY_STORAGE_KEY)) {
        try {
            localStorage.setItem(STORAGE_KEY, '1');
            localStorage.removeItem(LEGACY_STORAGE_KEY);
        } catch (e) {}
        return;
    }

    const slideCount = {{ $promoSlides->count() }};
    let offersSwiper = null;

    function markPromoPopupSeen() {
        try {
            localStorage.setItem(STORAGE_KEY, '1');
        } catch (e) {}
    }

    function closePopup() {
        markPromoPopupSeen();
        popup.classList.remove('is-visible');
        document.body.style.overflow = '';
        setTimeout(function() {
            popup.classList.add('hidden');
            if (offersSwiper) {
                offersSwiper.destroy(true, true);
                offersSwiper = null;
            }
        }, 400);
    }

    function openPopup() {
        popup.classList.remove('hidden');
        requestAnimationFrame(function() {
            popup.classList.add('is-visible');
            document.body.style.overflow = 'hidden';

            if (typeof Swiper !== 'undefined' && !offersSwiper && slideCount > 0) {
                offersSwiper = new Swiper('.startup-offers-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    loop: slideCount >= 2,
                    speed: 700,
                    effect: 'fade',
                    fadeEffect: { crossFade: true },
                    autoplay: slideCount > 1 ? {
                        delay: 5000,
                        disableOnInteraction: false,
                    } : false,
                    pagination: slideCount > 1 ? {
                        el: '.startup-offers-pagination',
                        clickable: true,
                    } : false,
                    navigation: slideCount > 1 ? {
                        nextEl: '.startup-promo-next',
                        prevEl: '.startup-promo-prev',
                    } : false,
                });
            }
        });
    }

    popup.querySelectorAll('[data-close-popup]').forEach(function(el) {
        el.addEventListener('click', function() {
            closePopup();
        });
    });

    const dismissBtn = document.getElementById('startup-offers-dismiss-permanent');
    if (dismissBtn) {
        dismissBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            closePopup();
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && popup.classList.contains('is-visible')) {
            closePopup();
        }
    });

    setTimeout(openPopup, 800);
});
</script>
@endif
