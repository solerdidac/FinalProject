@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-100">
  <div class="container mx-auto px-4">
    <h1 class="text-4xl font-bold text-center mb-12">Perfil de {{ $usuario->nombre }}</h1>

    {{-- Suscripción --}}
    <div class="mb-12">
      <h2 class="text-2xl font-semibold mb-4">Suscripción</h2>
      @if($suscripcion)
        <div class="bg-white p-6 rounded shadow">
          <p><strong>Plan:</strong> {{ $suscripcion->plan }}</p>
          <p><strong>Inicio:</strong> {{ \Carbon\Carbon::parse($suscripcion->fecha_inicio)->format('d/m/Y') }}</p>
        </div>
      @else
        <p class="text-gray-600">No tienes ninguna suscripción activa.</p>
      @endif
    </div>

    {{-- Rutinas de Fuerza --}}
    <div class="mb-12">
      <h2 class="text-2xl font-semibold mb-4">Tus Rutinas de Fuerza</h2>
      @if($fuerza->isEmpty())
        <p class="text-gray-600">Aún no has creado rutinas de fuerza.</p>
      @else
        <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
          @foreach($fuerza as $rutina)
            <li class="bg-white p-4 rounded shadow">
              <h3 class="text-lg font-bold">{{ $rutina->nombre }}</h3>
              <a href="{{ route('rutinas.show', $rutina->id) }}" class="text-lime-500 hover:underline">
                Ver detalles →
              </a>
            </li>
          @endforeach
        </ul>
      @endif
    </div>

    {{-- Recetas de Alimentación --}}
    <div class="mb-12">
      <h2 class="text-2xl font-semibold mb-4">Tus Recetas de Alimentación</h2>
      @if($alimentacion->isEmpty())
        <p class="text-gray-600">Aún no has creado recetas.</p>
      @else
        <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
          @foreach($alimentacion as $rutina)
            <li class="bg-white p-4 rounded shadow">
              <h3 class="text-lg font-bold">{{ $rutina->nombre }}</h3>
              <a href="{{ route('rutinas.show', $rutina->id) }}" class="text-lime-500 hover:underline">
                Ver detalles →
              </a>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
</section>
@endsection
