@php
    use App\Models\Setting;

    $resolveSocialUrl = function (string $settingKey, ?string $envKey = null): ?string {
        $url = trim((string) Setting::get($settingKey, ''));
        if ($url !== '') {
            return $url;
        }
        if ($envKey) {
            $url = trim((string) config("services.social.{$envKey}", ''));
            return $url !== '' ? $url : null;
        }

        return null;
    };

    $socialLinks = [
        [
            'url' => $resolveSocialUrl('facebook_url', 'facebook'),
            'label' => 'Facebook',
            'icon' => 'fab fa-facebook-f',
            'class' => 'home-social-sidebar__btn--facebook',
        ],
        [
            'url' => $resolveSocialUrl('instagram_url', 'instagram'),
            'label' => 'Instagram',
            'icon' => 'fab fa-instagram',
            'class' => 'home-social-sidebar__btn--instagram',
        ],
        [
            'url' => $resolveSocialUrl('tripadvisor_url', 'tripadvisor'),
            'label' => 'TripAdvisor',
            'icon' => 'fab fa-tripadvisor',
            'class' => 'home-social-sidebar__btn--tripadvisor',
        ],
    ];
@endphp

<aside class="home-social-sidebar" aria-label="Follow us on social media">
    @foreach($socialLinks as $link)
        @if($link['url'])
            <a href="{{ $link['url'] }}"
               target="_blank"
               rel="noopener noreferrer"
               class="home-social-sidebar__btn {{ $link['class'] }}"
               title="{{ $link['label'] }}"
               aria-label="{{ $link['label'] }} (opens in new tab)">
                <i class="{{ $link['icon'] }}" aria-hidden="true"></i>
            </a>
        @else
            <span class="home-social-sidebar__btn {{ $link['class'] }} home-social-sidebar__btn--disabled"
                  title="{{ $link['label'] }} — add URL in Admin → Settings → Social"
                  aria-hidden="true">
                <i class="{{ $link['icon'] }}"></i>
            </span>
        @endif
    @endforeach
</aside>
