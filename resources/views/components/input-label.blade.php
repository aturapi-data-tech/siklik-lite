@props(['value' => 'Label', 'required' => false])

@php
    $requiredProperty = $required ? 'after:content-["*"] after:ml-0.5 after:text-red-500' : '';
@endphp

<label {{ $attributes->merge(['class' => $requiredProperty . ' block font-medium text-sm text-gray-900']) }}>
    {{ $value ?? $slot }}
</label>
