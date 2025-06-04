<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);

        return view('cart.index', compact('cart'));
    }

    public function add(Product $product)
    {
        $cart = Session::get('cart', []);

            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
            ];

        Session::put('cart', $cart);

        return redirect()->route('product.index')->with('success', 'Товар добавлен в корзину!');
    }

    public function createOrder(Request $request)
    {
        $cart = Session::get('cart', []);
    
        $order = new Order();
        $order->user_id = auth()->id(); 
        $order->items = json_encode($cart);
        $order->status = 'pending'; // Set the status here
        $order->save();
    
        Session::forget('cart');
    
        return redirect()->route('cart.index')->with('success', 'Заказ успешно оформлен!');
    }




    
}


