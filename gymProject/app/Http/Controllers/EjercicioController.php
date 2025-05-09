<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class EjercicioController extends Controller
{
    public function mostrarPorGrupo($bodyPart)
    {
        $gruposPermitidos = [
            'back', 'cardio', 'chest', 'lower arms', 'lower legs',
            'neck', 'shoulders', 'upper arms', 'upper legs', 'waist'
        ];

        if (!in_array($bodyPart, $gruposPermitidos)) {
            abort(404, 'Grupo muscular no válido');
        }

        $response = Http::withHeaders([
            'X-RapidAPI-Key' => env('RAPIDAPI_KEY'),
            'X-RapidAPI-Host' => 'exercisedb.p.rapidapi.com'
        ])->get("https://exercisedb.p.rapidapi.com/exercises/bodyPart/{$bodyPart}", [
            'limit' => 10,
            'offset' => 0
        ]);

        $ejercicios = $response->json();

        return view('ejercicios-generico', [
            'ejercicios' => $ejercicios,
            'bodyPart' => $bodyPart
        ]);
    }
}
