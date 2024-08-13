@props(['badgecolor' => 'default'])
@php
    $class =
        $badgecolor == 'default'
            ? 'bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300'
            : ($badgecolor == 'dark'
                ? 'bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300'
                : ($badgecolor == 'green'
                    ? 'bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300'
                    : ($badgecolor == 'red'
                        ? 'bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300'
                        : ($badgecolor == 'yellow'
                            ? 'bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300'
                            : 'bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300'))));
@endphp


{{-- <span {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</span> --}}

<div class="flex items-center justify-center" x-data="{ toggle: '0' }">
    <div class="relative w-12 h-6 transition duration-200 ease-linear rounded-full"
        :class="[toggle === '1' ? 'bg-green-400' : 'bg-gray-400']">
        <label for="toggle"
            class="absolute left-0 w-6 h-6 mb-2 transition duration-100 ease-linear transform bg-white border-2 rounded-full cursor-pointer"
            :class="[toggle === '1' ? 'translate-x-full border-green-400' : 'translate-x-0 border-gray-400']"></label>
        <input type="checkbox" id="toggle" name="toggle"
            class="w-full h-full appearance-none active:outline-none focus:outline-none"
            @click="toggle === '0' ? toggle = '1' : toggle = '0'" />
    </div>
</div>
