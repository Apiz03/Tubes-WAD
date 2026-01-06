@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold mb-6">Riwayat Pesanan</h1>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if ($statuses->isEmpty())
        <div class="bg-white rounded-xl shadow p-6 text-center text-gray-500">
            Belum ada pesanan
        </div>
    @else
        <div class="space-y-6">
            @foreach ($statuses as $status)

                <div class="bg-white rounded-2xl shadow border overflow-hidden">

                    {{-- Header --}}
                    <div class="px-6 py-4 border-b flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">
                                Pesanan {{ $status->id }}
                            </p>
                            <p class="font-semibold">
                                {{ $status->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        {{-- Tombol Edit --}}
                        <a href="{{ route('status.edit', $status->id) }}"
                           class="text-sm px-4 py-2 rounded-lg border border-green-600
                                  text-green-600 hover:bg-green-600 hover:text-white transition">
                            Edit Data
                        </a>
                    </div>

                    {{-- Detail Item --}}
                    <div class="px-6 py-4 space-y-3 text-sm">
                        @foreach ($status->statusDetails as $detail)
                            <div class="flex justify-between">
                                <span>
                                    {{ $detail->food->name }} × {{ $detail->quantity }}
                                </span>
                                <span class="font-medium">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach

                        <div class="border-t pt-3 flex justify-between font-semibold text-base">
                            <span>Total Pembayaran</span>
                            <span class="text-green-600">
                                Rp {{ number_format($status->total_harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Informasi Penerima --}}
                    <div class="px-6 py-4 bg-gray-50 text-sm space-y-1">
                        <p><strong>Nama:</strong> {{ $status->name }}</p>
                        <p><strong>Nomor:</strong> {{ $status->Nomor }}</p>
                        <p><strong>Alamat:</strong> {{ $status->Alamat }}</p>
                        <p>
                            <strong>Metode Pembayaran:</strong>
                            {{ strtoupper($status->Metode_Pembayaran) }}
                        </p>
                    </div>

                </div>

            @endforeach
        </div>
    @endif

</div>
@endsection
