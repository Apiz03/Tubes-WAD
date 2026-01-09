@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#ECFAE5]">
    <!-- Toast Notifications -->
    @if(session('error') || session('success'))
        @php
            $type = session('error') ? 'error' : 'success';
            $message = session($type);
            $bgColor = $type === 'error' ? 'bg-red-500' : 'bg-green-500';
            $id = $type . 'Message';
            $closeFunction = 'close' . ucfirst($type) . 'Message';
        @endphp

        <div id="{{ $id }}" class="fixed top-4 right-4 {{ $bgColor }} text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 z-50 animate-slide-in">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ $message }}</span>
            <button class="ml-4" onclick="{{ $closeFunction }}()">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>

        <script>
            function {{ $closeFunction }}() {
                document.getElementById('{{ $id }}').classList.add('opacity-0', 'translate-x-full');
            }
            setTimeout(function() {
                var el = document.getElementById('{{ $id }}');
                if (el) el.classList.add('opacity-0', 'translate-x-full');
            }, 5000);
        </script>

        <style>
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateX(400px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            .animate-slide-in {
                animation: slideIn 0.3s ease-out;
            }
        </style>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @auth
            <div class="mb-12">
                <div class="bg-green-600 rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-6 sm:px-10 py-8 sm:py-12 flex items-center justify-between">
                        <div class="flex-1">
                            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">
                                Selamat datang, {{ Auth::user()->name }}! 👋
                            </h1>
                            <p class="text-white text-lg mb-4">
                                Temukan Makanan kesukaanmu dan Nikmati Penawaran Spesial Hanya untuk Mahasiswa & Dosen Telkom University!
                            </p>
                            @if (session('status'))
                                <div class="inline-block bg-green-400 bg-opacity-20 text-green-50 px-4 py-2 rounded-lg text-sm font-medium">
                                    ✓ {{ session('status') }}
                                </div>
                            @endif
                        </div>
                        @if (Auth::user()->role === 'admin')
                            <div class="hidden sm:block">
                                <a href="{{ route('admin.index') }}" class="inline-flex items-center space-x-2 bg-white text-green-600 hover:bg-green-100 px-6 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                    </svg>
                                    <span>Kelola Produk</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @if (Auth::user()->role === 'admin')
                    <div class="mt-4 sm:hidden">
                        <a href="{{ route('admin.index') }}" class="block w-full bg-green-600 text-white hover:bg-slate-50 px-6 py-3 rounded-lg font-semibold text-center transition duration-300">
                            Kelola Produk
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="mb-12">
                <div class="bg-[#DDF6D2] rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-6 sm:px-10 py-12 sm:py-16 text-center">
                        <h1 class="text-4xl sm:text-5xl font-bold text-black mb-4">
                            Selamat Datang di Canteen Tel-U 🍚
                        </h1>
                        <p class="text-black text-lg sm:text-xl mb-8 max-w-2xl mx-auto">
                            Temukan Makanan kesukaanmu dan Nikmati Penawaran Spesial Hanya untuk Mahasiswa & Dosen Telkom University!
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center space-x-2 bg-green-600 text-white hover:bg-white hover:text-green-600 px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                                <span>Masuk Sekarang</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center space-x-2 bg-green-600 text-white hover:bg-green-100 hover:text-black px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                                <span>Daftar Akun</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endauth

        <div class="flex flex-col gap-10 mb-10">

    <!-- ================= HEADER + FILTER ================= -->
    <div class="flex flex-col gap-6">

        <!-- Title -->
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Produk Terbaru</h2>
            <p class="text-gray-600 mt-1">
                Koleksi produk pilihan terbaru dari kami
            </p>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap gap-4">

            <!-- Filter Restaurant -->
            <div class="relative">
                <button
                    type="button"
                    id="restaurantButton"
                    onclick="toggleRestaurantDropdown()"
                    class="flex items-center justify-between gap-3
                            min-w-[220px] px-4 py-3 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700
                            hover:bg-gray-50 focus:outline-none
                            focus:ring focus:ring-green-200">
                    <span>
                        {{ optional($restaurants->firstWhere('id', request('restaurant')))->name ?? 'Semua Resto' }}
                    </span>

                    <svg id="restaurantArrow"
                        class="w-4 h-4 text-gray-500 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    id="restaurantDropdown"
                    class="hidden absolute left-0 mt-2 w-full
                        bg-white border border-gray-200
                        rounded-xl shadow-lg z-20 overflow-hidden">
                    <a href="{{ route('home') }}"
                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                        Semua Resto
                    </a>

                    @foreach($restaurants as $restaurant)
                        <a
                            href="{{ route('home', ['restaurant' => $restaurant->id]) }}"
                            class="block px-4 py-3 text-sm hover:bg-gray-100
                                    {{ request('restaurant') == $restaurant->id
                                        ? 'bg-green-50 font-semibold text-green-700'
                                        : 'text-gray-700' }}">
                            {{ $restaurant->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Filter Category -->
            <div class="relative">
                <button
                    type="button"
                    id="categoryButton"
                    onclick="toggleCategoryDropdown()"
                    class="flex items-center justify-between gap-3
                           min-w-[220px] px-4 py-3
                           bg-white border border-gray-300 rounded-xl
                           text-sm font-medium text-gray-700
                           hover:bg-gray-50 focus:outline-none
                           focus:ring focus:ring-green-200">
                    <span>
                        {{ optional($categories->firstWhere('id', request('category')))->name ?? 'Semua Kategori' }}
                    </span>

                    <svg id="categoryArrow"
                         class="w-4 h-4 text-gray-500 transition-transform"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    id="categoryDropdown"
                    class="hidden absolute left-0 mt-2 w-full
                           bg-white border border-gray-200
                           rounded-xl shadow-lg z-20 overflow-hidden">
                    <a href="{{ route('home') }}"
                       class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                        Semua Kategori
                    </a>

                    @foreach($categories as $category)
                        <a
                            href="{{ route('home', ['category' => $category->id]) }}"
                            class="block px-4 py-3 text-sm hover:bg-gray-100
                                   {{ request('category') == $category->id
                                        ? 'bg-green-50 font-semibold text-green-700'
                                        : 'text-gray-700' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- ================= PRODUCT GRID ================= -->
    @if($foods->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($foods as $food)
                <a href="{{ route('foods.show', $food->id) }}" class="group">
                    <div class="bg-white rounded-xl shadow-md
                                hover:shadow-2xl transition-all duration-300
                                transform hover:scale-105
                                overflow-hidden h-full flex flex-col">

                        <!-- Image -->
                        <div class="relative w-full h-48 bg-slate-100 overflow-hidden">
                            @if($food->image)
                                <img src="{{ asset('storage/' . $food->image) }}"
                                     alt="{{ $food->name }}"
                                     class="w-full h-full object-cover
                                            group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="flex items-center justify-center w-full h-full">
                                    <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-5 flex flex-col flex-1">
                            <span class="text-xs font-medium text-green-600 mb-1">
                                {{ $food->category->name }}
                            </span>

                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                {{ $food->name }}
                            </h3>

                            <p class="text-sm text-gray-600 mb-4 line-clamp-2 flex-1">
                                {{ Str::limit($food->description, 80) }}
                            </p>

                            <div class="pt-4 border-t border-gray-100">
                                <p class="text-xl font-bold text-green-600">
                                    Rp {{ number_format($food->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <button
                                class="mt-4 w-full bg-green-600 text-white
                                       hover:bg-green-100 hover:text-black
                                       font-semibold py-2 rounded-lg transition">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl shadow-md">
            <p class="text-gray-600 text-lg font-medium">Belum Ada Makanan</p>
            <p class="text-gray-500 text-sm mt-1">Makanan akan segera ditambahkan</p>
        </div>
    @endif

</div>

</div>
<script>
    function toggleCategoryDropdown() {
        const dropdown = document.getElementById('categoryDropdown');
        const arrow = document.getElementById('categoryArrow');

        dropdown.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    document.addEventListener('click', function (event) {
        const button = document.getElementById('categoryButton');
        const dropdown = document.getElementById('categoryDropdown');
        const arrow = document.getElementById('categoryArrow');

        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }
    });
</script>

<script>
    function toggleRestaurantDropdown() {
        const dropdown = document.getElementById('restaurantDropdown');
        const arrow = document.getElementById('restaurantArrow');
        dropdown.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    document.addEventListener('click', function (event) {
        const button = document.getElementById('restaurantButton');
        const dropdown = document.getElementById('restaurantDropdown');
        const arrow = document.getElementById('restaurantArrow');
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }
    });
</script>

@endsection