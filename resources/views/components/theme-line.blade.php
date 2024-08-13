@props(['themeline' => '1'])
{{-- themeline berisi angka 1 - 4 untuk setting panjang warna kanan dan kiri --}}
@php
    $themelineLeft = $themeline;
    $themelineRight = 4 - $themeline;

    $class = 'grid items-center grid-cols-4 gap-0';
@endphp

<div {{ $attributes->merge(['class' => $class]) }}>
    <div class ="h-1 col-span-{{ $themelineLeft }} bg-secondary"></div>
    <div class ="h-[1px] col-span-{{ $themelineRight }} bg-gray-500 "></div>
</div>
