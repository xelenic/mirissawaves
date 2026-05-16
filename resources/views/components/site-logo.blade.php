@props([
    'height' => '3.5rem',
    'href' => null,
    'alt' => 'Mirissawaves',
])

@php
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    {{ $attributes->merge(['class' => 'inline-flex items-center shrink-0']) }}
    @if($href) aria-label="{{ $alt }} home" @endif
>
    <img src="{{ asset('logo.png') }}"
         alt="{{ $alt }}"
         class="site-logo object-contain object-left w-auto max-h-10 sm:max-h-12"
         style="height: {{ $height }}; max-height: calc(var(--site-nav-height, 3.5rem) - 0.5rem);"
         width="auto">
</{{ $tag }}>
