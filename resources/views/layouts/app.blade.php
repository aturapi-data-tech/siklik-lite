<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>



    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistem Informasi Rumah Sakit & E-Rekam Medis') }}</title>










    <!-- Scripts vite-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])










    @stack('styles')










    {{-- Livewire --}}
    @livewireStyles











    {{-- Dark Mode Toggle --}}
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    {{--  --}}

















</head>


<body class="bg-gray-50 dark:bg-gray-800">

    @include('layouts.navigation')

    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">

        @include('layouts.sidebar')

        <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 dark:bg-gray-900">


            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow dark:bg-gray-800">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif






            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>









        </div>
    </div>










    {{-- Livewire --}}
    @livewireScripts















    @stack('scripts')
















    <script src="assets/flowbite/dist/app.bundle.js"></script>
    <script src="assets/flowbite/dist/flowbite.min.js"></script>


</body>

</html>
