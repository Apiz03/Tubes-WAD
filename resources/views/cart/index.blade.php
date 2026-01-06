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
                        <!-- kategori -->
                        <span class="text-xs font-medium text-green-600 mb-1">
                            {{ $cart->food->category->name }}
                        </span>
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
        <div class="mt-10 flex justify-end">
                <div class="w-full max-w-md bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

                    <!-- Header -->
                    <div class="px-6 py-4 bg-gray-50 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Ringkasan Pembayaran
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Pastikan pesanan Anda sudah benar
                        </p>
                    </div>

                    <!-- Total -->
                    <div class="px-6 py-6">
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-gray-700 font-medium">
                                Total Pembayaran
                            </span>
                            <span class="text-3xl font-bold text-green-600">
                                Rp {{ number_format($totalPrice, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- CTA -->
                        <form method="POST" action="{{ route('checkout.process') }}">
                            @csrf
                            <button
                                type="button"
                                onclick="openPaymentModal()"
                                class="w-full flex items-center justify-center gap-2
                                    bg-green-600 hover:bg-green-700
                                    text-white font-semibold py-4 rounded-xl
                                    transition-all duration-300
                                    transform hover:scale-[1.02] active:scale-95"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a5 5 0 00-10 0v2M5 9h14l-1.5 12h-11L5 9z"/>
                                </svg>
                                <span>Lanjutkan ke Checkout</span>
                            </button>
                        </form>
                    </div>

                    <!-- Footer trust -->
                    <div class="px-6 py-4 bg-gray-50 border-t text-center">
                        <p class="text-xs text-gray-500">
                            Pembayaran aman dan diproses secara real-time
                        </p>
                    </div>

                </div>
        </div>
    @endif
</div>

<div id="paymentModal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center">

    <!-- overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-50"
         onclick="closePaymentModal()"></div>

    <!-- modal -->
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6">

        <h3 class="text-xl font-bold text-gray-900 mb-1">
            Data & Pembayaran
        </h3>
        <p class="text-sm text-gray-500 mb-4">
            Lengkapi data sebelum melanjutkan pembayaran
        </p>

        <!-- ERROR VALIDATION -->
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('checkout.process') }}">
            @csrf

            <!-- Nama -->
            <div class="mb-3">
                <label class="text-sm font-medium text-gray-700">Nama Penerima</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full mt-1 border rounded-xl px-4 py-2 focus:ring focus:ring-green-200"
                       required>
            </div>

            <!-- Nomor HP -->
            <div class="mb-3">
                <label class="text-sm font-medium text-gray-700">Nomor HP</label>
                <input type="text" name="Nomor" value="{{ old('Nomor') }}"
                       class="w-full mt-1 border rounded-xl px-4 py-2 focus:ring focus:ring-green-200"
                       required>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label class="text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                <textarea name="Alamat" rows="3"
                          class="w-full mt-1 border rounded-xl px-4 py-2 focus:ring focus:ring-green-200"
                          required>{{ old('Alamat') }}</textarea>
            </div>

            <!-- Metode Pembayaran -->
            <div class="space-y-2 mb-5">
                <label class="flex items-center gap-3 border rounded-xl p-3 cursor-pointer">
                    <input type="radio" name="Metode_Pembayaran" value="cash" required>
                    <span>Bayar di Tempat (Cash)</span>
                </label>

                <label class="flex items-center gap-3 border rounded-xl p-3 cursor-pointer">
                    <input type="radio" name="Metode_Pembayaran" value="qris">
                    <span>QRIS</span>
                </label>

                <label class="flex items-center gap-3 border rounded-xl p-3 cursor-pointer">
                    <input type="radio" name="Metode_Pembayaran" value="ewallet">
                    <span>E-Wallet</span>
                </label>
            </div>

            <!-- Aksi -->
            <div class="flex gap-3">
                <button type="button"
                        onclick="closePaymentModal()"
                        class="flex-1 border rounded-xl py-3">
                    Batal
                </button>

                <button type="submit"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white rounded-xl py-3 font-semibold">
                    Konfirmasi & Bayar
                </button>
            </div>
        </form>
    </div>
</div>



@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function () {
        openPaymentModal();
    });
</script>
@endif
<script>
    function openPaymentModal() {
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }
</script>


@endsection
