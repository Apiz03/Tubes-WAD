@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    @if($carts->isEmpty())
        <div class="bg-white p-8 rounded-xl shadow text-center text-gray-500">
            Keranjang kamu masih kosong
        </div>
    @else
        <div class="space-y-4">
            @foreach($carts as $cart)
                <div class="bg-white rounded-xl shadow p-5 flex items-center justify-between">
                    
                    <!-- Info Produk -->
                    <div>
                        <h2 class="font-semibold text-lg">
                            {{ $cart->food->name }}
                        </h2>
                        <p class="text-gray-500 text-sm">
                            Rp {{ number_format($cart->food->price, 0, ',', '.') }} / item
                        </p>
                    </div>

                    <!-- Quantity Control -->
                    <div class="flex items-center gap-3">
                        <form method="POST" action="{{ route('cart.remove', $cart->id) }}">
                            @csrf
                            @method('DELETE')
                            <button
                                class="w-9 h-9 flex items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition">
                                −
                            </button>
                        </form>

                        <span class="font-semibold text-lg w-6 text-center">
                            {{ $cart->quantity }}
                        </span>

                        <form method="POST" action="{{ route('cart.add', $cart->food_id) }}">
                            @csrf
                            <button
                                class="w-9 h-9 flex items-center justify-center rounded-full bg-green-100 text-green-600 hover:bg-green-200 transition">
                                +
                            </button>
                        </form>
                    </div>

                    <!-- Subtotal -->
                    <div class="font-semibold text-right min-w-[140px]">
                        Rp {{ number_format($cart->food->price * $cart->quantity, 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
