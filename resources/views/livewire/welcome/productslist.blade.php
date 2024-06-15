<?php

use App\Models\Product;
use RealRashid\Cart\Facades\Cart;
use function Livewire\Volt\{with, usesPagination};

usesPagination();

with(fn() => ['products' => Product::paginate(10)]);

$addToCart = function ($qty, Product $product) {
    $id = $product->id;
    $name = $product->name;
    $price = $product->price;
    $quantity = $qty;

    Cart::instance('cart')
        ->add([
            'id' => $id,
            'name' => $name,
            'quantity' => $quantity,
            'price' => $price,
            'options' => [
                'color' => 'Red',
                'size' => 'large',
            ],
        ])
        ->associate($id, $product);

    $this->dispatch('added-to-cart');

    $this->dispatch('toast', message: 'Successfully added to cart', data: ['position' => 'top-center', 'type' => 'success']);
};

$addToWishList = function ($qty, Product $product) {
    $id = $product->id;
    $name = $product->name;
    $price = $product->price;
    $quantity = $qty;

    Cart::instance('wishlist')
        ->add([
            'id' => $id,
            'name' => $name,
            'quantity' => $quantity,
            'price' => $price,
            'options' => [
                'color' => 'Red',
                'size' => 'large',
            ],
            'taxrate' => 10,
        ])
        ->associate($id, $product);

    $this->dispatch('added-to-wishlist');

    $this->dispatch('toast', message: 'Successfully added to wishlist', data: ['position' => 'top-center', 'type' => 'success']);
};

?>

<section class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-8 p-8">

    @foreach ($products as $product)
        <!-- Product Card -->
        <div x-data="{ showModal_{{ $product->id }}: false }" class="bg-white rounded-lg shadow-lg overflow-hidden mb-4 border border-gray-200">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover" />
            <div class="p-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                    <span class="text-indigo-600 font-semibold text-lg">${{ $product->price }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex space-x-4">
                        <button wire:click.prevent="addToCart('1',{{ $product->id }})"
                            class="text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md shadow-md transition duration-300 transform hover:scale-105 focus:outline-none">
                            Add to Cart
                        </button>
                        <button wire:click.prevent="addToWishList('1',{{ $product->id }})"
                            class="text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md shadow-md transition duration-300 transform hover:scale-105 focus:outline-none">
                            Add to Wishlist
                        </button>
                        <button @click="showModal_{{ $product->id }} = true"
                            class="text-indigo-600 hover:text-indigo-800 px-4 py-2 rounded-md border border-indigo-600 shadow-md transition duration-300 transform hover:scale-105 focus:outline-none">
                            Quick View
                        </button>
                    </div>
                </div>

            </div>

            <!-- Quick View Modal -->
            <div x-show="showModal_{{ $product->id }}" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90" x-on:click.away="showModal_{{ $product->id }} = false"
                x-on:close.stop="showModal_{{ $product->id }} = false"
                x-on:keydown.escape.window="showModal_{{ $product->id }} = false"
                class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="bg-white rounded-lg p-8 max-w-md">
                    <button @click="showModal_{{ $product->id }} = false"
                        class="absolute top-0 right-0 m-4 text-gray-700 text-4xl hover:text-white">
                        &times;
                    </button>
                    <!-- Product Name -->
                    <h2 class="text-2xl font-semibold mb-4">{{ $product->name }}</h2>
                    <!-- Product Image -->
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-64 object-cover mb-4" />

                    <!-- Product Description -->
                    <p class="text-gray-700 mb-4">{{ $product->description }}</p>
                    <!-- Product Price and Add to Cart -->
                    <div class="flex justify-between items-center">
                        <span class="text-indigo-600 font-semibold text-lg">${{ $product->price }}</span>
                        <button wire:click.prevent="addToCart('1',{{ $product->id }})"
                            class="text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-full transition duration-300 transform hover:scale-105">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="col-span-3 flex justify-center mt-8 space-x-4">
        <!-- Pagination Links -->
        {{ $products->links() }}
    </div>
</section>
