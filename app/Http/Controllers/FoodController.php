<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $foods = Food::latest()->get();
        $categories = Category::all();
        $restaurants = Restaurant::all();
        return view('admin.index', compact('foods', 'categories', 'restaurants'));
    }
    
    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $categories = Category::all();
        $restaurants = Restaurant::all();
        return view ('admin.create', compact('categories', 'restaurants'));
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'restaurant_id' => 'required|exists:restaurants,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $foodData = $request->only('name', 'description', 'price', 'category_id', 'user_id', 'restaurant_id');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $foodData['image'] = $imagePath;
        }

        $foods = new Food([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'restaurant_id' => $request->restaurant_id,
            'description' => $request->description,
            'image' => $foodData['image'] ?? null,
            'price' => $request->price,
            'user_id' => Auth::id()
        ]);
        $foods->save();

        session()->flash('success', 'makanan berhasil dibuat!');
        return redirect()->route('admin.index');

        
    }

    

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
    $food = Food::findOrFail($id);
        return view('foods.show', compact('food'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
    {
        $food = Food::findOrFail($id);
        $categories = Category::all();
        $restaurants = Restaurant::all();
        return view('admin.edit', compact('food', 'categories', 'restaurants'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        // dd(request()->all());
        $food = Food::findOrFail($id);
        $request->validate([
            'name'        => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $foodData = $request->only('name', 'description', 'price', 'category_id');
        if ($request->hasFile('image')) {
            if ($food->image) {
                Storage::delete('public/' . $food->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $foodData['image'] = $imagePath;
        }

        $food->update($foodData);

        session()->flash('success', 'Produk berhasil diperbarui!');
        return redirect()->route('admin.index');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $food = Food::findOrFail($id);
        if ($food->image) 
        {
            Storage::delete('public/' . $food->image);
        }

        $food->delete();

        session()->flash('success', 'Produk berhasil dihapus!');
        return redirect()->route('admin.index');
    }
}