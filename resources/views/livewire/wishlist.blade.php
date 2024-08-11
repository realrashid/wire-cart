<?php

use function Livewire\Volt\{title, computed, on, state, rules};
use RealRashid\Cart\Facades\Cart;
use App\Models\Coupon;

title('Wishlist');

state(['couponCode' => '']);

rules(['couponCode' => 'required']);

$items = computed(function () {
    return cart()->instance('wishlist')->all();
});

on([
    'wishlist-cleared-all' => function () {
        $this->items = cart()->instance('wishlist')->all();
    },
]);

$incrementQuantity = function ($itemId) {
    $cartItem = Cart::instance('wishlist')->get($itemId);
    if ($cartItem) {
        Cart::instance('wishlist')->updateQuantity($itemId, $cartItem->getQuantity() + 1);
        $this->dispatch('wishlist-updated');
        $this->dispatch('toast', message: "{$cartItem->getName()} quantity Successfully Updated");
    }
};

$decrementQuantity = function ($itemId) {
    // Get the cart item
    $cartItem = Cart::instance('wishlist')->get($itemId);

    // If the cart item exists and quantity is more than 1, decrement the quantity
    if ($cartItem && $cartItem->getQuantity() > 1) {
        Cart::instance('wishlist')->updateQuantity($itemId, $cartItem->getQuantity() - 1);

        $this->dispatch('wishlist-updated');
        $this->dispatch('toast', message: "{$cartItem->getName()} quantity Successfully Updated");
    } else {
        // If quantity is 1 or the item is not found, remove it from the cart
        $this->dispatch('wishlist-updated');
        Cart::instance('wishlist')->remove($itemId);
    }
};

$applyCoupon = function () {
    $this->validate();

    $coupon = Coupon::where('code', $this->couponCode)->first();

    if (!$coupon || !$coupon->isValid()) {
        $this->dispatch('toast', message: 'Invalid Coupon Code', data: ['type' => 'danger']);
        return;
    }

    try {
        // Create the appropriate coupon object
        $couponObject = $coupon->createCoupon();

        // Apply the coupon to the wishlist
        Cart::instance('wishlist')->applyCoupon($couponObject);

        // Notify success
        $this->dispatch('toast', message: 'Coupon Applied Successfully');
    } catch (\Exception $e) {
        // Handle any exceptions (unsupported coupon types, etc.)
        $this->dispatch('toast', message: 'Failed to apply coupon: ' . $e->getMessage(), data: ['type' => 'danger']);
    }
};

$clearCoupon = function () {
    $this->couponCode = '';
    Cart::instance('wishlist')->removeCoupon();
    $this->dispatch('toast', message: 'Coupon Remove Successfully');
};

$clearWishlist = function () {
    Cart::instance('wishlist')->clear();

    $this->dispatch('wishlist-cleared');
    $this->dispatch('toast', message: 'Wishlist is Successfully Cleared');
};

?>

<div class="bg-white p-8 rounded-lg shadow-lg w-4/5">
    <h2 class="text-3xl font-semibold mb-6 text-gray-800 text-center">Shopping Wishlist</h2>

    @if (Cart::instance('wishlist')->empty())
        <div class="text-center mt-8">
            <p class="text-gray-600">Your Wishlist is empty</p>
        </div>
    @else
        <!-- Wishlist Items -->
        <div class="space-y-4">
            @forelse (Cart::instance('wishlist')->all() as $item)
                <!-- Wishlist Item -->
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
            @empty
                <div class="text-center mt-8">
                    <p class="text-gray-600">Your Wishlist is empty</p>
                </div>
            @endforelse
        </div>

        <!-- Wishlist Tax -->
        <div class="flex items-center justify-between mt-4 pt-4">
            <span class="font-semibold text-gray-800">Tax:</span>
            <span class="text-xl font-semibold text-indigo-600">${{ Cart::instance('wishlist')->tax() }}</span>
        </div>

        <!-- Wishlist Sub Total -->
        <div class="flex items-center justify-between mt-2 pt-2">
            <span class="font-semibold text-gray-800">Sub Total:</span>
            <span class="text-xl font-semibold text-indigo-600">${{ Cart::instance('wishlist')->subtotal() }}</span>
        </div>

        <!-- Apply Coupon Section -->
        @if (!Cart::instance('wishlist')->getAppliedCouponDetails())
            <div class="flex items-center justify-between mt-2 pt-2">
                <label for="couponCode" class="font-semibold text-gray-800">Coupon Code:</label>
                <div class="flex ml-2">
                    <div class="flex flex-col">
                        <input type="text" id="couponCode" wire:model.defer="couponCode"
                            class="border border-gray-300 rounded-l-lg px-4 py-2 w-64 focus:outline-none focus:border-indigo-600 placeholder-gray-400"
                            placeholder="Enter coupon code...">
                        @error('couponCode')
                            <div class="mt-1 text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <button wire:click.prevent="applyCoupon"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-r-lg ml-2 hover:bg-indigo-700 transition"
                        style="height: 2.5rem;">Apply</button>
                </div>
            </div>
        @endif

        <!-- Wishlist Applied Coupon -->
        @if (Cart::instance('wishlist')->getAppliedCouponDetails())
            <div class="flex items-center justify-between mt-2 pt-2">
                <span class="font-semibold text-gray-800">Applied Coupon:</span>
                @php
                    $appliedCouponDetails = Cart::instance('wishlist')->getAppliedCouponDetails();
                @endphp
                <span class="text-xl font-semibold text-indigo-600">
                    {{ $appliedCouponDetails->code }} -
                    ${{ $appliedCouponDetails->discountAmount }} off
                </span>
            </div>
        @endif

        <!-- Wishlist Total -->
        <div class="flex items-center justify-between mt-2 pt-2">
            <span class="font-semibold text-gray-800">Total:</span>
            <span class="text-xl font-semibold text-indigo-600">${{ Cart::instance('wishlist')->total() }}</span>
        </div>

        <!-- Buttons -->
        <div class="flex justify-center mt-8 space-x-4">
            @if (Cart::instance('wishlist')->getAppliedCouponDetails())
                <a href="#" wire:click.prevent="clearCoupon()"
                    class="text-indigo-600 px-6 py-2 rounded-full border border-indigo-600 hover:bg-indigo-600 hover:text-white transition">Clear
                    Coupon</a>
            @endif
            <a href="#" wire:click.prevent="clearWishlist()"
                class="text-indigo-600 px-6 py-2 rounded-full border border-indigo-600 hover:bg-indigo-600 hover:text-white transition">Clear
                Wishlist</a>
            <a href="#"
                class="text-indigo-600 px-6 py-2 rounded-full border border-indigo-600 hover:bg-indigo-600 hover:text-white transition">Continue
                Shopping</a>
            <a href="#" class="text-white bg-indigo-600 hover:bg-indigo-700 px-6 py-2 rounded-full">Checkout</a>
        </div>
    @endif
</div>
