<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Category;
use App\Models\Restaurant;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        $restaurants = Restaurant::orderBy('name')->get();

        $foods = Food::with(['category', 'restaurant'])
            ->when($request->category, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->restaurant, function ($query, $restaurantId) {
                $query->where('restaurant_id', $restaurantId);
            })
            ->latest()
            ->get();

        return view('home', compact('foods', 'categories', 'restaurants'));
    }
}
