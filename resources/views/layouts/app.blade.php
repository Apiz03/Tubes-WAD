<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tel-U Bite</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/bite.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* Navbar Shadow */
        .navbar-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Smooth transitions */
        a, button {
            transition: all 0.3s ease;
        }

        /* Active link indicator */
        .nav-link.active {
            color: #2563eb;
            border-bottom: 3px solid #2563eb;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Navigation Bar -->
    <nav class="navbar-shadow sticky top-0 z-50 bg-white backdrop-blur-lg bg-opacity-95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo Section -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <img src="/bite.png" alt="Logo" class="w-20 h-20 group-hover:scale-110 transition-transform duration-300">
                    </div>
                </a>

                <!-- Auth Section -->
                <div class="flex items-center space-x-6">
                    @auth
                        <!-- User Profile Dropdown -->
                        <div class="flex items-center space-x-4">
                        @if (Auth::user()->role === 'mahasiswa')
                            <!-- icon keranjang -->
                            <a href="{{ route('cart.index') }}" class="relative inline-flex items-center p-2 text-gray-700 hover:text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="currentColor" aria-hidden="true"> <circle cx="10" cy="28" r="2"></circle> #2563eb<circle cx="24" cy="28" r="2"></circle>
                                <path d="M28 7H5.82L5 2.8A1 1 0 0 0 4 2H0v2h3.18L7 23.2A1 1 0 0 0 8 24h18v-2H8.82L8 18h18a1 1 0 0 0 1-.78l2-9A1 1 0 0 0 28 7zm-2.8 9H7.62L6.22 9h20.53z"></path>
                                </svg>
                                @php
                                    $cartCount = Auth::user()->carts()->count();
                                @endphp
                                @if($cartCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold text-white bg-red-600 rounded-full translate-x-1/3 -translate-y-1/4">
                                    {{ $cartCount }}
                                </span>

                                @endif
                            </a>
                        @endif
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white font-semibold text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="text-left hidden md:block">
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ Auth::user()->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ Auth::user()->role }}
                                    </p>
                                </div>
                            </div>

                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center space-x-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span class="hidden sm:inline">Logout</span>
                                </button>
                            </form>
                        </div>
                        
                    @else
                        <!-- Non-Auth Links -->
                        <div class="flex items-center space-x-3">
                            @if (Request::is('login'))
                                <a href="/register" class="inline-flex items-center space-x-2 bg-green-600 hover:bg-green-100 hover:text-black text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    <span>Daftar</span>
                                </a>
                            @else
                                <a href="/login" class="inline-flex items-center space-x-2 bg-green-600 hover:bg-green-100 text-white hover:text-black px-6 py-2 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-1"/>
                                    </svg>
                                    <span>Masuk</span>
                                </a>
                            @endif
                        </div>
                    @endauth    
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-600 text-sm">© 2024 Retail-U. Semua hak dilindungi.</p>
                </div>
                
            </div>
        </div>
    </footer>
</body>
</html>