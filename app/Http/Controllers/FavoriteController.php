<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $favorites = Auth::user()->favoriteProducts()->with(['categories', 'ingredients', 'ratings'])->get();
        return view('favorites.index', compact('favorites'));
    }

    public function add(Product $product)
    {
        Auth::user()->favoriteProducts()->attach($product->id);
        return redirect()->back()->with('success', 'Рецепт добавлен в избранное');
    }

    public function remove(Product $product)
    {
        Auth::user()->favoriteProducts()->detach($product->id);
        return redirect()->back()->with('success', 'Рецепт удален из избранного');
    }
}