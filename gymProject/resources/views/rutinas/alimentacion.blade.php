@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-100">
  <div class="container mx-auto px-4">

    {{-- Título de página --}}
    <h1 class="text-4xl font-bold text-center mb-12">Rutinas de Alimentación</h1>

    {{-- Selector de categoría --}}
    <form method="GET" action="{{ route('rutinas.alimentacion') }}" class="mb-8 text-center">
      <label for="categoria" class="font-medium">Elige categoría:</label>
      <select
        name="categoria"
        id="categoria"
        class="ml-2 border-gray-300 rounded-md p-2"
        onchange="this.form.submit()"
      >
        @foreach($categorias as $cat)
          <option
            value="{{ $cat }}"
            {{ $cat === $seleccionado ? 'selected' : '' }}
          >
            {{ ucfirst($cat) }}
          </option>
        @endforeach
      </select>
    </form>

    {{-- Recetas públicas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-12">
      @forelse($meals as $meal)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
          <img
            src="{{ $meal['strMealThumb'] }}"
            alt="{{ $meal['strMeal'] }}"
            class="h-48 w-full object-cover"
          >
          <div class="p-4 flex-1 flex flex-col">
            <h2 class="text-xl font-semibold mb-2">{{ $meal['strMeal'] }}</h2>
            <a
              href="{{ route('rutinas.alimentacion.detalle', $meal['idMeal']) }}"
              class="mt-auto text-lime-400 hover:underline font-medium"
            >
              Ver detalles →
            </a>
          </div>
        </div>
      @empty
        <p class="col-span-3 text-center text-gray-600">
          No se encontraron recetas.
        </p>
      @endforelse
    </div>

    {{-- Recetas privadas (sólo usuarios autenticados) --}}
    @auth
      <hr class="my-8">

      <h2 class="text-2xl font-semibold mb-6">Tus Recetas Privadas</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-12">
        @forelse($privadas as $rutina)
          <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
            @if($rutina->gif_url)
              <img
                src="{{ $rutina->gif_url }}"
                alt="{{ $rutina->nombre }}"
                class="h-48 w-full object-cover"
              >
            @else
              <div class="h-48 bg-gray-200 flex items-center justify-center">
                <span class="text-gray-500">Sin imagen</span>
              </div>
            @endif
            <div class="p-4 flex-1 flex flex-col">
              <h3 class="text-xl font-semibold mb-2">{{ $rutina->nombre }}</h3>
              <p class="text-gray-600 flex-1">
                {{ Str::limit($rutina->descripcion, 80) }}
              </p>
              <a
                href="{{ route('rutinas.show', $rutina->id) }}"
                class="mt-4 text-lime-400 hover:underline font-medium"
              >
                Ver detalles →
              </a>
            </div>
          </div>
        @empty
          <p class="col-span-3 text-center text-gray-600">
            Aún no has creado recetas.
          </p>
        @endforelse
      </div>

      {{-- Botón Crear nueva receta --}}
      <div class="text-center mb-12">
        <a
          href="{{ route('rutinas.create', ['tipo' => 'alimentacion']) }}"
          class="inline-block bg-lime-400 hover:bg-lime-500 text-black font-semibold px-8 py-3 rounded-full transition"
        >
          ➕ Crear nueva receta
        </a>
      </div>
    @endauth

  </div>
</section>
@endsection
