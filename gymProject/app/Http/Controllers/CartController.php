<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CartController extends Controller
{
    // 1) Mostrar carrito
    public function index(Request $request)
    {
        $cart = session('cart', []);
        $products = Producto::whereIn('id', array_keys($cart))->get();

        // Empaquetamos cada ítem con su cantidad
        $cartItems = $products->map(function($p) use($cart) {
            return [
                'producto' => $p,
                'quantity' => $cart[$p->id],
            ];
        });

        return view('cart.index', compact('cartItems'));
    }

    // 2) Añadir producto al carrito
    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:productos,id',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $cart = session('cart', []);
        $id   = $data['product_id'];
        $qty  = $data['quantity'] ?? 1;

        // Incrementamos si ya existía
        $cart[$id] = ($cart[$id] ?? 0) + $qty;
        session(['cart' => $cart]);

        return back()->with('success', 'Producto añadido al carrito');
    }

    // 3) Actualizar cantidad
    public function update(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:productos,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);
        $id   = $data['product_id'];

        if (! isset($cart[$id])) {
            return back()->with('error', 'El producto no está en el carrito');
        }

        $cart[$id] = $data['quantity'];
        session(['cart' => $cart]);

        return back()->with('success', 'Cantidad actualizada');
    }

    // 4) Eliminar producto
    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:productos,id',
        ]);

        $cart = session('cart', []);
        $id   = $data['product_id'];

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
            return back()->with('success', 'Producto eliminado');
        }

        return back()->with('error', 'El producto no está en el carrito');
    }

    // 5) Checkout vía Stripe de TODO el carrito
    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')
                             ->with('error', 'Tu carrito está vacío');
        }

        $products = Producto::whereIn('id', array_keys($cart))->get();

        Stripe::setApiKey(config('services.stripe.secret'));

        // Construimos línea por línea para Stripe
        $line_items = [];
        foreach ($products as $p) {
            $qty = $cart[$p->id];
            $line_items[] = [
                'price_data' => [
                    'currency'     => 'eur',
                    'product_data' => [
                        'name' => $p->nombre,
                    ],
                    'unit_amount'  => intval($p->precio * 100),
                ],
                'quantity' => $qty,
            ];

        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => $line_items,
            'mode'                 => 'payment',
            'success_url'          => route('products.index') . '?success=1',
            'cancel_url'           => route('cart.index')     . '?cancel=1',
        ]);

        return redirect()->away($session->url);
    }
    public function show()
    {
        $cart = session()->get('cart', []);

        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['precio'] * $item['cantidad']);
        }, 0);

        return view('cart.show', compact('cart', 'total'));
    }


}
