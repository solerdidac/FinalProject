<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class RutinaController extends Controller
{
    /**
     * Pantalla de selección: fuerza o alimentación.
     */
    public function index()
    {
        return view('rutinas.index');
    }

    /**
     * Muestra rutinas públicas y personales de Fuerza.
     */
    public function mostrarRutinasFuerza(Request $request)
    {
        $grupos = [
            'back','cardio','chest','lower arms','lower legs',
            'neck','shoulders','upper arms','upper legs','waist'
        ];
        $seleccionado = $request->input('grupo', 'chest');

        $ejercicios = Http::withHeaders([
            'X-RapidAPI-Key'  => env('RAPIDAPI_KEY'),
            'X-RapidAPI-Host' => 'exercisedb.p.rapidapi.com',
        ])->get("https://exercisedb.p.rapidapi.com/exercises/bodyPart/{$seleccionado}", [
            'limit'  => 5,
            'offset' => 0,
        ])->json();

        $rutinasUsuario = DB::table('rutinas')
            ->where('usuario_id', auth()->id())
            ->where('tipo', 'fuerza')
            ->get();

        return view('rutinas.fuerza', compact(
            'ejercicios',
            'grupos',
            'seleccionado',
            'rutinasUsuario'
        ));
    }

    /**
     * Muestra rutinas públicas y privadas de Alimentación,
     * junto con un listado limitado de 6 recetas de la API.
     */
    public function mostrarRutinasAlimentacion(Request $request)
    {
        // 1) Obtener categorías desde la API
        $catResp = Http::get('https://www.themealdb.com/api/json/v1/1/list.php?c=list');
        $categorias = collect($catResp->json('meals'))
                       ->pluck('strCategory')
                       ->toArray();

        // 2) Determinar categoría seleccionada
        $seleccionado = $request->query('categoria', $categorias[0] ?? null);

        // 3) Traer todas las recetas de esa categoría
        $mealResp = Http::get('https://www.themealdb.com/api/json/v1/1/filter.php', [
            'c' => $seleccionado,
        ]);
        $meals = $mealResp->json('meals') ?? [];

        // 4) Limitar a 6 recetas públicas
        $meals = array_slice($meals, 0, 6);

        // 5) Cargar recetas privadas (tipo=alimentacion)
        $privadas = auth()->check()
            ? DB::table('rutinas')
                ->where('tipo', 'alimentacion')
                ->where('usuario_id', auth()->id())
                ->get()
            : collect();

        return view('rutinas.alimentacion', compact(
            'categorias',
            'seleccionado',
            'meals',
            'privadas'
        ));
    }

    /**
     * Detalle de una receta de Alimentación (desde la API).
     */
    public function mostrarDetalleAlimentacion($id)
    {
        $resp = Http::get('https://www.themealdb.com/api/json/v1/1/lookup.php', [
            'i' => $id,
        ]);
        $meal = optional($resp->json('meals')[0]);

        return view('rutinas.alimentacion_detalle', compact('meal'));
    }

    /**
     * Formulario para crear nueva rutina o receta.
     */
    public function create(Request $request)
    {
        $tipo = $request->query('tipo', 'fuerza');
        $categorias = [];

        if ($tipo === 'alimentacion') {
            $catResp = Http::get('https://www.themealdb.com/api/json/v1/1/list.php?c=list');
            $categorias = collect($catResp->json('meals'))
                          ->pluck('strCategory')
                          ->toArray();
        }

        return view('rutinas.create', compact('tipo', 'categorias'));
    }

    /**
     * Guarda una nueva rutina personalizada o receta.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'descripcion'  => 'nullable|string',
            'gif_url'      => 'nullable|url',
            'equipment'    => 'nullable|string|max:100',
            'target'       => 'nullable|string|max:100',
            'secondary'    => 'nullable|string',
            'instructions' => 'nullable|string',
            'tipo'         => 'required|in:fuerza,alimentacion',
        ]);

        DB::table('rutinas')->insert([
            'usuario_id'    => auth()->id(),
            'nombre'        => $request->nombre,
            'descripcion'   => $request->descripcion,
            'gif_url'       => $request->gif_url,
            'equipment'     => $request->equipment,
            'target'        => $request->target,
            'secondary'     => $request->secondary
                                 ? json_encode(explode(',', $request->secondary))
                                 : null,
            'instructions'  => $request->instructions
                                 ? json_encode(preg_split('/\r\n|\r|\n/', $request->instructions))
                                 : null,
            'tipo'          => $request->tipo,
            'fecha_creacion'=> now(),
        ]);

        $ruta = $request->tipo === 'fuerza'
            ? 'rutinas.fuerza'
            : 'rutinas.alimentacion';

        $texto = $request->tipo === 'fuerza' ? 'Rutina' : 'Receta';

        return redirect()->route($ruta)
                         ->with('success',"¡{$texto} creada correctamente!");
    }

    /**
     * Muestra una rutina personalizada guardada.
     */
    public function show($id)
    {
        $rutina = DB::table('rutinas')
                    ->where('id', $id)
                    ->first();

        if (! $rutina || $rutina->usuario_id !== auth()->id()) {
            abort(403, 'No autorizado.');
        }

        return view('rutinas.show', compact('rutina'));
    }
    public function edit($id)
    {
        $rutina = DB::table('rutinas')->where('id', $id)->first();

        if (!$rutina || $rutina->usuario_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        return view('rutinas.edit', ['rutina' => $rutina]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'gif_url' => 'nullable|url',
            'secondary' => 'nullable|string',
            'instructions' => 'nullable|string',
        ]);

        $rutina = DB::table('rutinas')->where('id', $id)->first();

        if (!$rutina || $rutina->usuario_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        DB::table('rutinas')->where('id', $id)->update([
            'nombre' => $request->nombre,
            'gif_url' => $request->gif_url,
            'secondary' => $request->secondary
                ? json_encode(explode(',', $request->secondary))
                : null,
            'instructions' => $request->instructions
                ? json_encode(preg_split('/\r\n|\r|\n/', $request->instructions))
                : null,
        ]);

        return redirect()->route('rutinas.show', $id)->with('success', 'Rutina actualizada');
    }
    public function destroy($id)
    {
        $rutina = DB::table('rutinas')->where('id', $id)->first();

        if (!$rutina || $rutina->usuario_id !== auth()->id()) {
            abort(403, 'No autorizado');
        }

        DB::table('rutinas')->where('id', $id)->delete();

        return redirect()->route('rutinas.fuerza')->with('success', 'Rutina eliminada');
    }


}
