@props(['disabled' => false, 'label' => 'Label'])

@php
    
    $disabled ? ($class = 'w-4 h-4 bg-gray-100 border-gray-300 text-primary focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500') : ($class = 'w-4 h-4 bg-gray-100 border-gray-300 text-primary focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500');
@endphp

<ul
    class="items-center w-auto pr-2 mr-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg h-11 focus-within:bg-gray-50 sm:flex">
    <li class="w-auto ">
        <div class="flex items-center pl-3 ">
            <input id="{{ $label }}" {{ $disabled ? 'disabled' : '' }} type="radio" {!! $attributes->merge([
                'class' => $class,
            ]) !!}>
            <label for="{{ $label }}" class="w-auto ml-2 text-sm text-gray-900 dark:text-gray-300 ">
                {{ $label }}
            </label>
        </div>
    </li>
</ul>
