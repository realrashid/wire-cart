<?php

use function Livewire\Volt\{computed, on};

$count = computed(function () {
    return cart()->instance('cart')->count();
});

on([
    'added-to-cart' => function () {
        $this->count = cart()->instance('cart')->count();
    },
]);

on([
    'cart-updated' => function () {
        $this->count = cart()->instance('cart')->count();
    },
]);

on([
    'cart-cleared' => function () {
        $this->count = cart()->instance('cart')->count();
    },
]);

$clearCart = function () {
    cart()->instance('cart')->clear();

    $this->dispatch('cart-cleared-all');
    $this->dispatch('toast', message: 'Cart is Successfully Cleared', data: ['position' => 'top-center', 'type' => 'success']);
};

?>

<div class="relative group" x-data="{ showCart: false }">
    <a @click="showCart = !showCart" href="#" class="hover:text-gray-300 pr-4">Cart</a>
    <span class="absolute -top-2 -right-2 p-2 text-xs text-white bg-indigo-500 rounded-full">{{ $this->count }}</span>

    <!-- Dropdown for Cart Items -->
    <div x-show="showCart" @click.away="showCart = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="absolute z-10 mt-2 bg-white rounded-lg shadow-lg w-60 border border-gray-200 p-2
left-1/2 transform -translate-x-1/2">


        @if (Cart::instance('cart')->empty())
            <!-- Empty Cart Message -->
            <div class="text-gray-700 p-2">Cart is empty</div>
        @else
            @foreach (Cart::instance('cart')->all() as $item)
                <!-- Cart Item-->
                <div class="flex items-center justify-between p-2">
                    <span class="font-semibold text-gray-800">{{ $item->name }}</span>
                    <span class="text-gray-700">${{ $item->price }}</span>
                </div>
            @endforeach

            <!-- Total Price -->
            <div class="flex items-center justify-between p-2">
                <span class="font-semibold text-gray-800">Total:</span>
                <span class="text-gray-700">${{ Cart::instance('cart')->total() }}</span>
            </div>
            <!-- Buttons -->
            <div class="flex justify-between p-2 border-t mt-2">
                <button wire:click="clearCart()"
                    class="text-white bg-indigo-600 px-3 py-1 rounded hover:bg-indigo-700 transition">Clear</button>
                <a href="/cart" wire:navigate
                    class="text-indigo-600 border border-indigo-600 px-3 py-1 rounded hover:text-white hover:bg-indigo-600 transition">
                    View Cart
                </a>
            </div>
        @endif
    </div>
</div>
