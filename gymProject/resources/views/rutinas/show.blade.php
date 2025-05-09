@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-100">
  <div class="container mx-auto px-4 max-w-3xl">
    <h1 class="text-4xl font-bold mb-6">{{ $rutina->nombre }}</h1>

    {{-- Imagen de la rutina --}}
    @if($rutina->gif_url)
      <img src="{{ $rutina->gif_url }}" 
           alt="{{ $rutina->nombre }}"
           class="w-full rounded-lg mb-6 shadow">
    @endif

    {{-- Descripción --}}
    @if($rutina->descripcion)
      <p class="mb-6">{{ $rutina->descripcion }}</p>
    @endif

    {{-- Detalles técnicos --}}
    <h2 class="text-2xl font-semibold mb-3">Detalles</h2>
    <ul class="list-disc ml-6 mb-6 text-gray-700">
      @if($rutina->equipment)
        <li><strong>Equipo:</strong> {{ $rutina->equipment }}</li>
      @endif
      @if($rutina->target)
        <li><strong>Músculo principal:</strong> {{ $rutina->target }}</li>
      @endif
      @if($rutina->secondary)
        <li>
          <strong>{{ $rutina->tipo === 'fuerza' ? 'Músculos secundarios' : 'Ingredientes' }}:</strong>
          {{ implode(', ', json_decode($rutina->secondary, true) ?? []) }}
        </li>
      @endif
    </ul>

    {{-- Instrucciones --}}
    @if($rutina->instructions)
      <h2 class="text-2xl font-semibold mb-3">Instrucciones</h2>
      <ol class="list-decimal ml-6 space-y-1 mb-6 text-gray-700">
        @foreach(json_decode($rutina->instructions, true) ?? [] as $paso)
          <li>{{ $paso }}</li>
        @endforeach
      </ol>
    @endif

    {{-- Acciones --}}
    <div class="flex justify-between items-center mt-8">
      <a href="{{ route('rutinas.fuerza') }}"
         class="inline-block bg-lime-400 hover:bg-lime-500 text-black font-semibold px-6 py-3 rounded-full transition">
        ← Volver
      </a>

      @auth
        @if($rutina->usuario_id === auth()->id())
          <div class="space-x-2">
            <a href="{{ route('rutinas.edit', $rutina->id) }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
              Editar
            </a>

            <form action="{{ route('rutinas.destroy', $rutina->id) }}" method="POST"
                  class="inline-block"
                  onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta rutina?')">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                Eliminar
              </button>
            </form>
          </div>
        @endif
      @endauth
    </div>
  </div>
</section>
@endsection
