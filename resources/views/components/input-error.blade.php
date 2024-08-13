@props(['messages'])

@if ($messages)
    <ul
        {{ $attributes->merge(['class' => 'p-1 mb-1 text-xs text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400']) }}>
        @foreach ((array) $messages as $message)
            <li class="font-normal">{{ $message }}</li>
        @endforeach
    </ul>
@endif
