<?php

use function Livewire\Volt\{title, computed, on};
use RealRashid\Cart\Facades\Cart;

title('Cart');

$items = computed(function () {
    return cart()->instance('cart')->all();
});

on([
    'cart-cleared-all' => function () {
        $this->items = cart()->instance('cart')->all();
    },
]);

$incrementQuantity = function ($itemId) {
    $cartItem = Cart::instance('cart')->get($itemId);
    if ($cartItem) {
        Cart::instance('cart')->updateQuantity($itemId, $cartItem->getQuantity() + 1);
        $this->dispatch('cart-updated');
        $this->dispatch('toast', message: "{$cartItem->getName()} quantity Successfully Updated", data: ['position' => 'top-center', 'type' => 'success']);
    }
};

$decrementQuantity = function ($itemId) {
    // Get the cart item
    $cartItem = Cart::instance('cart')->get($itemId);

    // If the cart item exists and quantity is more than 1, decrement the quantity
    if ($cartItem && $cartItem->getQuantity() > 1) {
        Cart::instance('cart')->updateQuantity($itemId, $cartItem->getQuantity() - 1);

        $this->dispatch('cart-updated');
        $this->dispatch('toast', message: "{$cartItem->getName()} quantity Successfully Updated", data: ['position' => 'top-center', 'type' => 'success']);
    } else {
        // If quantity is 1 or the item is not found, remove it from the cart
        $this->dispatch('cart-updated');
        Cart::instance('cart')->remove($itemId);
    }
};

$clearCart = function () {
    Cart::instance('cart')->clear();

    $this->dispatch('cart-cleared');
    $this->dispatch('toast', message: 'Cart is Successfully Cleared', data: ['position' => 'top-center', 'type' => 'success']);
};

?>

<div class="bg-white p-8 rounded-lg shadow-lg w-4/5">
    <h2 class="text-3xl font-semibold mb-6 text-gray-800 text-center">Shopping Cart</h2>

    @if (empty($this->items))
        <div class="text-center mt-8">
            <p class="text-gray-600">Your Cart is empty</p>
        </div>
    @else
        <!-- Cart Items -->
        <div class="space-y-4">
            @foreach ($this->items as $item)
                <!-- Cart Item -->
                <div class="flex items-center justify-between border-b pb-2">
                    <div class="flex items-center">
                        <span class="font-semibold text-gray-800">{{ $item->model->name ?? $item->name }} -
                            ({{ $item->options->color ?? 'N/A' }},{{ $item->options->size ?? 'N/A' }})
                        </span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-700">${{ $item->price }}</span>
                        <div class="flex items-center ml-4">
                            <!-- Minus Button -->
                            <button wire:click.prevent="decrementQuantity('{{ $item->id }}')"
                                class="text-indigo-600 hover:text-indigo-800 px-4 py-2">-</button>
                            <!-- Quantity -->
                            <span class="mx-2">{{ $item->quantity }}</span>
                            <!-- Plus Button -->
                            <button wire:click.prevent="incrementQuantity('{{ $item->id }}')"
                                class="text-indigo-600 hover:text-indigo-800 px-4 py-2">+</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Cart Tax -->
        <div class="flex items-center justify-between mt-4 pt-4">
            <span class="font-semibold text-gray-800">Tax:</span>
            <span class="text-xl font-semibold text-indigo-600">${{ Cart::instance('cart')->tax() }}</span>
        </div>

        <!-- Cart Sub Total -->
        <div class="flex items-center justify-between mt-2 pt-2">
            <span class="font-semibold text-gray-800">Sub Total:</span>
            <span class="text-xl font-semibold text-indigo-600">${{ Cart::instance('cart')->subtotal() }}</span>
        </div>

        <!-- Cart Total -->
        <div class="flex items-center justify-between mt-2 pt-2">
            <span class="font-semibold text-gray-800">Total:</span>
            <span class="text-xl font-semibold text-indigo-600">${{ Cart::instance('cart')->total() }}</span>
        </div>

        <!-- Buttons -->
        <div class="flex justify-center mt-8 space-x-4">
            <a href="#" wire:click.prevent="clearCart()"
                class="text-indigo-600 px-6 py-2 rounded-full border border-indigo-600 hover:bg-indigo-600 hover:text-white transition">Clear
                Cart</a>
            <a href="#"
                class="text-indigo-600 px-6 py-2 rounded-full border border-indigo-600 hover:bg-indigo-600 hover:text-white transition">Continue
                Shopping</a>
            <a href="#" class="text-white bg-indigo-600 hover:bg-indigo-700 px-6 py-2 rounded-full">Checkout</a>
        </div>
    @endif
</div>
