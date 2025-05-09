@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-100">
  <div class="container mx-auto px-4">
    <h1 class="text-4xl font-bold text-center mb-12">Rutinas de Fuerza</h1>

    {{-- Selector de grupo muscular --}}
    <form method="GET" action="{{ route('rutinas.fuerza') }}" class="mb-8 text-center">
      <label for="grupo" class="font-medium">Selecciona un grupo muscular:</label>
      <select name="grupo" id="grupo"
              class="ml-2 border-gray-300 rounded-md p-2"
              onchange="this.form.submit()">
        @foreach ($grupos as $grupo)
          <option value="{{ $grupo }}" {{ $grupo === $seleccionado ? 'selected' : '' }}>
            {{ ucfirst($grupo) }}
          </option>
        @endforeach
      </select>
    </form>

    {{-- Ejercicios públicos --}}
    <h2 class="text-2xl font-semibold mb-6">
      Ejercicios Públicos: <span class="text-lime-400">{{ ucfirst($seleccionado) }}</span>
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-12">
      @forelse ($ejercicios as $ej)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
          <img src="{{ $ej['gifUrl'] }}" alt="{{ $ej['name'] }}"
               class="h-48 w-full object-cover">
          <div class="p-4 flex-1 flex flex-col">
            <h3 class="text-xl font-semibold mb-2">{{ $ej['name'] }}</h3>
            <p class="text-gray-600 flex-1">
              <strong>Equipo:</strong> {{ $ej['equipment'] }}<br>
              <strong>Músculo:</strong> {{ $ej['target'] }}
            </p>
          </div>
        </div>
      @empty
        <p class="col-span-3 text-center text-gray-600">No hay ejercicios públicos.</p>
      @endforelse
    </div>

    <hr class="my-8">

    {{-- Rutinas personales --}}
    <h2 class="text-2xl font-semibold mb-6">Tus Rutinas Personales</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-8">
      @forelse ($rutinasUsuario as $rutina)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
          @if($rutina->gif_url)
            <img src="{{ $rutina->gif_url }}" alt="{{ $rutina->nombre }}"
                 class="h-48 w-full object-cover">
          @else
            <div class="h-48 bg-gray-200 flex items-center justify-center">
              <span class="text-gray-500">Sin imagen</span>
            </div>
          @endif
          <div class="p-4 flex-1 flex flex-col">
            <h3 class="text-xl font-semibold mb-2">{{ $rutina->nombre }}</h3>
            <p class="text-gray-600 flex-1">{{ Str::limit($rutina->descripcion, 80) }}</p>
            <a href="{{ route('rutinas.show', $rutina->id) }}"
               class="mt-4 text-lime-400 hover:underline font-medium">
              Ver detalles →
            </a>
          </div>
        </div>
      @empty
        <p class="col-span-3 text-center text-gray-600">Aún no has creado rutinas.</p>
      @endforelse
    </div>
    <div class="text-center">
      <a href="{{ route('rutinas.create', ['tipo' => 'fuerza']) }}"
         class="inline-block bg-lime-400 hover:bg-lime-500 text-black font-semibold px-8 py-3 rounded-full transition">
        ➕ Crear nueva rutina
      </a>
    </div>
  </div>
</section>
@endsection
