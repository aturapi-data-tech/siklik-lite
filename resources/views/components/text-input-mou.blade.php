@props(['disabled' => false, 'mou_label' => 'SetMou', 'errorshas' => false])

@php
    $errorHasProperty = $errorshas ? 'border border-red-500' : 'border border-gray-300';

    $disabled ? ($class = 'bg-gray-100 border rounded-none rounded-l-lg shadow-sm ' . $errorHasProperty . ' text-gray-900 sm:text-sm focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary') : ($class = 'bg-white border rounded-none rounded-l-lg shadow-sm ' . $errorHasProperty . ' text-gray-900 sm:text-sm focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-500 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary');
@endphp

<div class='flex'>
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' => $class,
    ]) !!}>
    <input disabled
        class='shadow-sm bg-gray-200 border border-gray-300 text-gray-700  sm:text-sm  focus:ring-primary focus:border-primary block w-20 p-2.5 dark:bg-gray-500 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary rounded-none rounded-r-lg font-medium text-sm'
        value={{ $mou_label }}>
</div>
