<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $products = Product::where('category', 'pizza')->limit(4)->with('images')->get();

        return Inertia::render('Home/Index', compact('products'));
    }
}
