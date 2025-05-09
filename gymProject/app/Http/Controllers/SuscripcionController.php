<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suscripcion;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class SuscripcionController extends Controller
{
    // 1) Formulario de pago recibe también "periodo"
    public function formularioPago(Request $request)
    {
        $plan    = $request->query('plan', 'basic');
        $precio  = $request->query('precio', 2000);
        $periodo = $request->query('periodo', 'mensual');

        return view('suscripciones.pago', compact('plan','precio','periodo'));
    }

    // 2) Procesar pago graba periodo y calcula fecha_fin segun mensual/anual
    public function procesarPago(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $request->validate([
            'plan'       => 'required|string',
            'periodo'    => 'required|in:mensual,anual',
            'precio'     => 'required|integer',
            'stripeToken'=> 'required|string',
        ]);

        try {
            $customer = Customer::create([
                'email'  => auth()->user()->correo,
                'source' => $request->stripeToken,
            ]);

            Charge::create([
                'customer'    => $customer->id,
                'amount'      => $request->precio,
                'currency'    => 'eur',
                'description' => 'Suscripción GYMTEAM - Plan '.ucfirst($request->plan),
            ]);

            // Inactivamos previas
            Suscripcion::where('usuario_id', auth()->id())
                ->where('estado', 'activo')
                ->update([
                    'estado'    => 'inactivo',
                    'fecha_fin' => now(),
                ]);

            // Calculamos fin de periodo
            $inicio = now();
            $fin    = $request->periodo === 'anual'
                      ? $inicio->copy()->addYear()
                      : $inicio->copy()->addMonth();

            // Creamos la nueva
            Suscripcion::create([
                'usuario_id'   => auth()->id(),
                'plan'         => $request->plan,
                'periodo'      => $request->periodo,
                'fecha_inicio' => $inicio,
                'fecha_fin'    => $fin,
                'estado'       => 'activo',
            ]);

            return redirect()->route('planes.index')
                             ->with('success','¡Pago exitoso! Tu suscripción está activa.');

        } catch (\Exception $e) {
            return back()->with('error','Error en el pago: '.$e->getMessage());
        }
    }

    public function cancelar()
    {
        $sus = auth()->user()->suscripcion;
        if ($sus) {
            $sus->estado    = 'inactivo';
            $sus->fecha_fin = now();
            $sus->save();
        }

        return redirect()->route('planes.index')
                         ->with('success','Suscripción cancelada correctamente.');
    }
}
