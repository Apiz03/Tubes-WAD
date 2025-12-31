@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
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

    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <a href="{{ route('home') }}" class="text-green-600 hover:text-black text-sm font-medium flex items-center space-x-1">
                <span>← Kembali</span>
            </a>
        </div>

        <!-- Product Container -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 sm:p-10">
                <!-- Product Image -->
                <div class="flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 rounded-xl overflow-hidden min-h-96">
                    @if($food->image)
                        <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" class="w-fit h-fit object-cover">
                    @else
                        <div class="flex items-center justify-center w-full h-full">
                            <svg class="w-24 h-24 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="flex flex-col justify-between">
                    <div>
                        <!-- kategori -->
                        <span class="text-xs font-medium text-green-600 mb-1">
                            {{ $food->category->name }}
                        </span>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $food->name }}</h1>
                        
                        <!-- Price Badge -->
                        <div class="mb-6">
                            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($food->price, 0, ',', '.') }}</p>
                        </div>

                        <!-- Rating Summary -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <div class="flex items-center space-x-2 mb-2">
                                @php
                                    $avgRating = $food->reviews->avg('rating') ?? 0;
                                    $reviewCount = $food->reviews->count();
                                @endphp
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ number_format($avgRating, 1) }}</span>
                                <span class="text-sm text-gray-500">({{ $reviewCount }} ulasan)</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-2">Deskripsi</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $food->description }}</p>
                        </div>

                        <!-- addToCart -->
                        <div class="mt-8">
                            <form method="POST" action="{{ route('cart.add', $food->id) }}">
                                @csrf
                                <button type="submit" class="w-full bg-green-600 text-white hover:bg-white hover:text-green-600 text-white font-semibold py-3 rounded-lg transition duration-300 transform hover:scale-105">
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        </div>  
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-12">
            <!-- Review Form -->
            @if(auth()->check() && (auth()->user()->role == 'mahasiswa' || auth()->user()->role == 'admin'))
                <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-10 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Bagikan Ulasanmu</h2>
                    <form method="POST" action="{{ route('reviews.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="food_id" value="{{ $food->id }}" />
                        
                        <div>
                            <label for="rating" class="block text-sm font-semibold text-gray-900 mb-3">Rating Makanan</label>
                            <div class="flex items-center space-x-2">
                                <select name="rating" id="rating" class="hidden" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <div id="ratingStars" class="flex items-center space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" class="rating-star w-8 h-8 cursor-pointer" data-value="{{ $i }}">
                                            <svg class="w-full h-full text-gray-300 hover:text-yellow-400 transition" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                <span id="ratingValue" class="ml-2 text-sm font-medium text-gray-600">Pilih rating</span>
                            </div>
                        </div>

                        <div>
                            <label for="comment" class="block text-sm font-semibold text-gray-900 mb-2">Komentar (Opsional)</label>
                            <textarea name="comment" id="comment" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none" placeholder="Bagikan pengalamanmu dengan produk ini..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-green-600 text-white hover:bg-white hover:text-green-600 text-white font-semibold py-3 rounded-lg transition duration-300 transform hover:scale-105">
                            Kirim Ulasan
                        </button>
                    </form>

                    <script>
                        const ratingStars = document.querySelectorAll('.rating-star');
                        const ratingInput = document.querySelector('select[name="rating"]');
                        const ratingValue = document.getElementById('ratingValue');

                        ratingStars.forEach(star => {
                            star.addEventListener('click', function(e) {
                                e.preventDefault();
                                const value = this.dataset.value;
                                ratingInput.value = value;
                                ratingValue.textContent = value + ' dari 5';
                                
                                ratingStars.forEach(s => {
                                    if (s.dataset.value <= value) {
                                        s.querySelector('svg').classList.remove('text-gray-300');
                                        s.querySelector('svg').classList.add('text-yellow-400');
                                    } else {
                                        s.querySelector('svg').classList.add('text-gray-300');
                                        s.querySelector('svg').classList.remove('text-yellow-400');
                                    }
                                });
                            });
                        });
                    </script>
                </div>
            @endif

            <!-- Reviews List -->
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-10">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Pelanggan</h2>

                @forelse($food->reviews as $review)
                    <div class="mb-6 pb-6 border-b border-gray-200 last:border-b-0 last:mb-0 last:pb-0">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $review->user->name }}</p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($review->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- edit review -->
                            
                            @if(auth()->check() && auth()->id() == $review->user_id)
                                <div class="flex items-center gap-3">
                                    <button
                                        type="button"
                                        onclick='openEditReview({{ $review->id }}, {{ $review->rating }}, @json($review->comment))'
                                        class="text-blue-600 hover:text-blue-700 font-medium text-sm"
                                    >
                                        Edit
                                    </button>

                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                                        onsubmit="return confirm('Hapus ulasan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-700 font-medium text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif

                        </div>
                        @if($review->comment)
                            <p class="text-gray-700 leading-relaxed mt-3">{{ $review->comment }}</p>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        <p class="mt-4 text-gray-600 text-lg">Belum ada ulasan untuk makanan ini</p>
                        <p class="text-gray-500 text-sm mt-1">Jadilah yang pertama untuk memberikan ulasan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<div id="editReviewModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">
            Edit Ulasan
        </h3>

        <form method="POST" id="editReviewForm">
            @csrf
            @method('PUT')

            <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                Rating
            </label>

            <!-- nilai rating sebenarnya -->
            <input type="hidden" name="rating" id="editRating" required>

            <!-- UI bintang -->
            <div id="editRatingStars" class="flex items-center gap-1">
                @for($i = 1; $i <= 5; $i++)
                    <button
                        type="button"
                        class="edit-rating-star"
                        data-value="{{ $i }}"
                    >
                        <svg
                            class="w-8 h-8 text-gray-300 transition"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </button>
                @endfor

                <span id="editRatingText" class="ml-2 text-sm text-gray-600">
                    Pilih rating
                </span>
            </div>
        </div>


            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Komentar
                </label>
                <textarea name="comment"
                        id="editComment"
                        rows="4"
                        class="w-full px-4 py-2 border rounded-lg resize-none"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button"
                        onclick="closeEditReview()"
                        class="px-4 py-2 rounded-lg border">
                    Batal
                </button>
                <button type="submit"
                        class="px-6 py-2 rounded-lg bg-green-600 text-white font-semibold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    const editStars = document.querySelectorAll('.edit-rating-star');
    const editRatingInput = document.getElementById('editRating');
    const editRatingText = document.getElementById('editRatingText');

    function setEditRating(value) {
        editRatingInput.value = value;
        editRatingText.textContent = value + ' dari 5';

        editStars.forEach(star => {
            const starValue = star.dataset.value;
            const icon = star.querySelector('svg');

            if (starValue <= value) {
                icon.classList.remove('text-gray-300');
                icon.classList.add('text-yellow-400');
            } else {
                icon.classList.add('text-gray-300');
                icon.classList.remove('text-yellow-400');
            }
        });
    }

    editStars.forEach(star => {
        star.addEventListener('click', function () {
            setEditRating(this.dataset.value);
        });
    });

    // dipanggil saat modal edit dibuka
    function initEditRating(value) {
        setEditRating(value);
    }
</script>



<script>
    function openEditReview(id, rating, comment) {
        const modal = document.getElementById('editReviewModal');
        const form = document.getElementById('editReviewForm');

        form.action = `/reviews/${id}`;
        document.getElementById('editRating').value = rating;
        document.getElementById('editComment').value = comment ?? '';

        modal.classList.remove('hidden');
    }

    function closeEditReview() {
        document.getElementById('editReviewModal').classList.add('hidden');
    }
</script>

@endsection