<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        // Valida los datos del formulario
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        // Actualiza la información del usuario autenticado
        $user = Auth::user();
        $user->update($data);

        return redirect()->back()->with('status', 'Profile updated!');
    }

    public function miPerfil()
    {
        $usuario = auth()->user();

        $fuerza = DB::table('rutinas')
                    ->where('usuario_id', $usuario->id)
                    ->where('tipo', 'fuerza')
                    ->get();

        $alimentacion = DB::table('rutinas')
                        ->where('usuario_id', $usuario->id)
                        ->where('tipo', 'alimentacion')
                        ->get();

        $suscripcion = DB::table('suscripciones')
                        ->where('usuario_id', $usuario->id)
                        ->whereNull('cancelada_en')
                        ->first();

        return view('perfil', compact('usuario', 'fuerza', 'alimentacion', 'suscripcion'));
    }

}

