<nav class="flex items-center justify-between p-4 bg-gray-800 text-white">
    <div class="flex items-center">
        <!-- Logo and site name -->
        <a href="/" wire:navigate>
            <span class="text-2xl font-bold ml-2">{{ config('app.name', 'WireCart') }}</span>
        </a>
    </div>
    <div class="flex items-center space-x-4">
        <!-- Home link -->
        <a href="/" wire:navigate class="hover:text-gray-300">Home</a>

        <!-- Cart icon component -->
        @livewire('welcome.carticon')

        <!-- Wishlist icon component -->
        @livewire('welcome.wishlisticon')

        <!-- Login link -->
        <a href="/" class="text-white hover:text-gray-300 text-sm font-medium px-3 py-2 rounded-md"
            wire:navigate>Log in</a>
    </div>
</nav>
