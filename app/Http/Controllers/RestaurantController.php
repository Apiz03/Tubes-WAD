<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::orderBy('name')->get();
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Restaurant::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Restoran berhasil ditambahkan');
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $restaurant->update([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Restoran berhasil diperbarui');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return back()->with('success', 'Restoran berhasil dihapus');
    }
}
