<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function indexCart()
    {
        $carts = Cart::with('food')->where('user_id', Auth::id())->get();
        $totalPrice = $carts->sum(function ($cart) {
            return $cart->food->price * $cart->quantity;
        });
        return view('cart.index', compact('carts', 'totalPrice'));
    }

    public function addToCart(Request $request, $foodId)
    {
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('food_id', $foodId)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'food_id' => $foodId,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Makanan ditambahkan ke keranjang!');
    }
    
        public function removeFromCart(Request $request, $cartId)
    {
        $cartItem = Cart::where('id', $cartId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang.');
        }

        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->save();

            return redirect()->back()->with(
                'success',
                'Jumlah item berhasil dikurangi.'
            );
        }

        $cartItem->delete();

        return redirect()->back()->with(
            'success',
            'Item berhasil dihapus dari keranjang.'
        );
    }




}
