<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $foods = Food::when($request->category, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
                ->latest()
                ->get();
        return view('home', compact('foods', 'categories'));
    }
}
