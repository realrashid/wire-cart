<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'WireCart') .' - '. $title ?? 'Page Title' }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="font-sans bg-gray-100">

    <!-- Navigation Section -->
    <livewire:welcome.navigation />

    <div class="flex justify-center mt-8 mb-8">
        {{ $slot }}
    </div>

    <!-- Call to Action Section -->
    <section class="p-8 bg-gray-300 flex flex-col items-center justify-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Subscribe to Our Newsletter</h2>
        <div class="flex items-center bg-white rounded-full shadow-lg overflow-hidden">
            <input type="email" class="w-full py-2 px-4 border-none rounded-l-full focus:outline-none"
                placeholder="Enter your email">
            <button
                class="bg-indigo-600 text-white px-6 py-2 rounded-r-full hover:bg-indigo-700 transition duration-300">Subscribe</button>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white p-8">
        <div class="container mx-auto flex justify-between">
            <div class="w-1/4">
                <img src="{{ asset('path_to_your_logo.png') }}" alt="Logo" class="w-16 h-16 mb-4">
                <p class="text-gray-400">About {{ config('app.name', 'WireCart') }}</p>
            </div>
            <div class="w-1/4">
                <h3 class="text-lg font-bold mb-4">Policies</h3>
                <a href="#" class="block text-gray-400 hover:text-gray-200 mb-2">Privacy Policy</a>
                <a href="#" class="block text-gray-400 hover:text-gray-200 mb-2">Terms and Services</a>
                <a href="#" class="block text-gray-400 hover:text-gray-200">Refund Policy</a>
            </div>
            <div class="w-1/4">
                <h3 class="text-lg font-bold mb-4">Follow Us</h3>
                <a href="#" class="block text-gray-400 hover:text-gray-200 mb-2">Facebook</a>
                <a href="#" class="block text-gray-400 hover:text-gray-200 mb-2">Twitter</a>
                <a href="#" class="block text-gray-400 hover:text-gray-200">Instagram</a>
            </div>
        </div>
    </footer>

    <livewire:toast />
    @livewireScripts
</body>

</html>
