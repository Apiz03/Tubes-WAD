<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;

class HomeController extends Controller
{
    public function index()
    {
        $foods = Food::latest()->get();
        return view('home', compact('foods'));
    }
}
