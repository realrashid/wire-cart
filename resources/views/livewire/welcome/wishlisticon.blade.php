<?php

use function Livewire\Volt\{computed, on};

$count = computed(function () {
    return cart()->instance('wishlist')->count();
});

on([
    'added-to-wishlist' => function () {
        $this->count = cart()->instance('wishlist')->count();
    },
]);

on([
    'wishlist-updated' => function () {
        $this->count = cart()->instance('wishlist')->count();
    },
]);

on([
    'wishlist-cleared' => function () {
        $this->count = cart()->instance('wishlist')->count();
    },
]);

$clearWhishList = function () {
    cart()->instance('wishlist')->clear();

    $this->dispatch('wishlist-cleared-all');
    $this->dispatch('toast', message: 'Wishlist is Successfully Cleared', data: ['position' => 'top-center', 'type' => 'success']);
};

?>

<div class="relative group" x-data="{ showWishlist: false }">
    <a @click="showWishlist = !showWishlist" href="#" class="hover:text-gray-300 pr-4">Wishlist</a>
    <span class="absolute -top-2 -right-2 p-2 text-xs text-white bg-indigo-500 rounded-full">{{ $this->count }}</span>

    <!-- Dropdown for Wishlist Items -->
    <div x-show="showWishlist" @click.away="showWishlist = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="absolute z-10 mt-2 bg-white rounded-lg shadow-lg w-60 border border-gray-200 p-2
left-1/2 transform -translate-x-1/2">

        @if (Cart::instance('wishlist')->empty())
            <!-- Empty Wishlist Message -->
            <div class="text-gray-700 p-2">Wishlist is empty</div>
        @else
            @foreach (Cart::instance('wishlist')->all() as $item)
                <!-- Wishlist Item 1 -->
                <div class="flex items-center justify-between p-2">
                    <span class="font-semibold text-gray-800">{{ $item->name }}</span>
                    <span class="text-gray-700">${{ $item->price }}</span>
                </div>
            @endforeach

            <!-- Total Price -->
            <div class="flex items-center justify-between p-2">
                <span class="font-semibold text-gray-800">Total:</span>
                <span class="text-gray-700">${{ Cart::instance('wishlist')->total() }}</span>
            </div>
            <!-- Buttons -->
            <div class="flex justify-between p-2 border-t mt-2">
                <button wire:click="clearWhishList()"
                    class="text-white bg-indigo-600 px-3 py-1 rounded hover:bg-indigo-700 transition">Clear</button>
                <a href="/wishlist" wire:navigate
                    class="text-indigo-600 border border-indigo-600 px-3 py-1 rounded hover:text-white hover:bg-indigo-600 transition">
                    View Wishlist
                </a>
            </div>
        @endif
    </div>
</div>
