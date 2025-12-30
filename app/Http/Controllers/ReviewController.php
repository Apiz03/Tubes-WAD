<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'food_id' => 'required|exists:foods,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $food = Food::findOrFail($request->food_id);

        $review = new Review([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_id' => Auth::id(),
            'food_id' => $request->food_id,
        ]);

        $food->reviews()->save($review);

        session()->flash('success', 'Review berhasil ditambahkan!');
        return redirect()->route('foods.show', $food->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // not used
    }

    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $foodId = $review->food_id;
        $review->delete();


        session()->flash('success', 'Review berhasil dihapus!');
        return redirect()->route('foods.show', ['food' => $foodId]);
    }
}