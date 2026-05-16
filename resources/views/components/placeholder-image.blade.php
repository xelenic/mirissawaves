@props([
    'src',
    'alt' => '',
    'placeholder' => 'blog',
])

@php
    $fallback = \App\Support\ImagePlaceholder::url($placeholder);
@endphp

<img
    src="{{ $src ?: $fallback }}"
    alt="{{ $alt }}"
    {{ $attributes->merge(['class' => '']) }}
    onerror="this.onerror=null;this.src='{{ $fallback }}';"
>
