@props(['title' => 'Judul', 'align' => 'start', 'bordercolor' => 'border-gray-300', 'bgcolor' => 'bg-white'])
@php
    if ($align == 'start') {
        $alignAttribute = 'text-start';
    } elseif ($align == 'center') {
        $alignAttribute = 'text-center';
    } else {
        $alignAttribute = 'text-end';
    }
@endphp
<div
    {{ $attributes->merge(['class' => 'my-4 border-t border-b border-l border-r ' . $bordercolor . ' ' . $bgcolor . ' dark:border-gray-600 rounded-md']) }}>
    <h2 class="w-full {{ $alignAttribute }}">
        <span class="px-3 text-base font-medium bg-transparent text-primary dark:text-gray-300">
            {{ $title }}
        </span>
    </h2>
    <div class='px-5 pt-4'>
        {{ $slot }}
    </div>
</div>
