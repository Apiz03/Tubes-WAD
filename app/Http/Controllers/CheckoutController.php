<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Status;
use App\Models\StatusDetail;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        // Pastikan user login
        if (!auth()->check()) {
            abort(403);
        }

        // Ambil cart beserta relasi food
        $cartItems = Cart::with('food')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->withErrors(['cart' => 'Keranjang kosong']);
        }

        // Validasi input sesuai migration
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'Nomor' => 'required|string|max:20',
            'Alamat' => 'required|string|max:500',
            'Metode_Pembayaran' => 'required|in:cash,qris,ewallet',
        ]);

        DB::beginTransaction();

        // try {
            // 
            // Hitung total harga dari FOOD, bukan cart
            $totalHarga = $cartItems->sum(function ($item) {
                return $item->food->price * $item->quantity;
            });

            // Simpan ke tabel statuses
            $status = Status::create([
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'Nomor' => $validated['Nomor'],
                'Alamat' => $validated['Alamat'],
                'Metode_Pembayaran' => $validated['Metode_Pembayaran'],
                'total_harga' => $totalHarga,
            ]);

            // Simpan ke status_details
            foreach ($cartItems as $item) {
                StatusDetail::create([
                    'status_id' => $status->id,
                    'food_id' => $item->food_id,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->food->price * $item->quantity,
                ]);
            }

            // Hapus cart
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()
                ->route('cart.index')
                ->with('success', 'Checkout berhasil diproses');

        // } catch (\Throwable $e) {
            // DB::rollBack();

            // return back()->withErrors([
            //     'checkout' => 'Terjadi kesalahan saat memproses checkout'
            // ]);
        // }
    }
}
