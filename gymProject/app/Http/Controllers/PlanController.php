<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $planes = [
            'basic' => ['nombre'=>'Basic','precio_mensual'=>20,'precio_anual'=>200],
            'pro'   => ['nombre'=>'Pro','precio_mensual'=>35,'precio_anual'=>350],
        ];

        $suscripcion = auth()->user()?->suscripcion;
        return view('planes.index', compact('planes','suscripcion'));
    }
}
