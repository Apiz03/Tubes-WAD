@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold mb-6">Edit Data Pesanan</h1>

    {{-- Error Validation --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow border overflow-hidden">

        <form method="POST" action="{{ route('status.update', $status->id) }}">
            @csrf
            @method('PUT')

            {{-- Data Penerima --}}
            <div class="px-6 py-6 space-y-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Penerima
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $status->name) }}"
                           class="w-full border rounded-xl px-4 py-2 focus:ring focus:ring-green-200"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nomor HP
                    </label>
                    <input type="text"
                           name="Nomor"
                           value="{{ old('Nomor', $status->Nomor) }}"
                           class="w-full border rounded-xl px-4 py-2 focus:ring focus:ring-green-200"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Alamat Pengiriman
                    </label>
                    <textarea name="Alamat"
                              rows="4"
                              class="w-full border rounded-xl px-4 py-2 focus:ring focus:ring-green-200"
                              required>{{ old('Alamat', $status->Alamat) }}</textarea>
                </div>

            </div>

            {{-- Informasi Tidak Bisa Diedit --}}
            <div class="px-6 py-4 bg-gray-50 border-t text-sm space-y-2">
                <p>
                    <strong>Metode Pembayaran:</strong>
                    {{ strtoupper($status->Metode_Pembayaran) }}
                </p>
                <p>
                    <strong>Total Pembayaran:</strong>
                    Rp {{ number_format($status->total_harga, 0, ',', '.') }}
                </p>
            </div>

            {{-- Aksi --}}
            <div class="px-6 py-4 border-t flex justify-end gap-3">
                <a href="{{ route('status.index') }}"
                class="px-6 py-3 border rounded-xl hover:bg-gray-100">
                    Batal
                </a>

                <button type="submit"
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
