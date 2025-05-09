<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Producto;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            if ($p = Producto::find($id)) {
                $p->quantity = $quantity;
                $p->subtotal = $p->precio * $quantity;
                $items[] = $p;
                $total += $p->subtotal;
            }
        }

        // Stripe recibe el importe en céntimos
        $amount = intval($total * 100);

        return view('checkout', compact('items', 'total', 'amount'));
    }

    public function process(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Recalcular total por seguridad
        $cart = $request->session()->get('cart', []);
        $total = 0;
        foreach ($cart as $id => $q) {
            if ($p = Producto::find($id)) {
                $total += $p->precio * $q;
            }
        }
        $amount = intval($total * 100);

        try {
            Charge::create([
                'amount'      => $amount,
                'currency'    => 'eur',
                'description' => 'Pago tienda GYMTEAM',
                'source'      => $request->stripeToken,
            ]);

            // Vaciar carrito tras el pago
            $request->session()->forget('cart');

            return redirect()->route('products.index')
                             ->with('success', 'Pago realizado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error en el pago: ' . $e->getMessage());
        }
    }
}
