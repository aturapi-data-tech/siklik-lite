@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center p-2 m-2 text-sm text-white rounded-lg bg-primary  hover:bg-primary group dark:text-gray-200 hover:text-white'
            : 'flex items-center p-2 m-2 text-sm text-gray-900 rounded-lg hover:bg-primary group dark:text-gray-200 hover:text-white';

@endphp

<a {{ $attributes->merge(['class' => $classes]) }} class="">
    <span class="ml-3" sidebar-toggle-item="">{{ $slot }}</span>
</a>
