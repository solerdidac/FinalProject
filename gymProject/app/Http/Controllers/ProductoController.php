<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class ProductoController extends Controller
{
    /**
     * Muestra la tienda, filtrando por categoría si viene en query-string.
     */
    public function index(Request $request)
    {
        $categoria = $request->query('categoria');

        if ($request->query('success')) {
            session()->forget('cart');
        }

        $productos = $categoria
            ? Producto::where('categoria', $categoria)->get()
            : Producto::all();

        return view('products.index', compact('productos', 'categoria'));
    }


    /**
     * Crea una sesión de Stripe Checkout para el producto y redirige allí.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:productos,id',
        ]);

        $producto = Producto::findOrFail($request->product_id);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name'  => $producto->nombre,
                        'images'=> [ asset('productos/'.$producto->imagen) ],
                    ],
                    'unit_amount' => intval($producto->precio * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('products.index') . '?success=1',
            'cancel_url'  => route('products.index') . '?cancel=1',
        ]);

        return redirect()->away($session->url);
    }
}
