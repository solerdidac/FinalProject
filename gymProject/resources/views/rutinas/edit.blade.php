@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-100">
  <div class="container mx-auto px-4">
    <h1 class="text-4xl font-bold text-center mb-12">
      Editar rutina: {{ $rutina->nombre }}
    </h1>

    <form method="POST" action="{{ route('rutinas.update', $rutina->id) }}" class="max-w-xl mx-auto space-y-6">
      @csrf
      @method('PUT')

      {{-- Nombre --}}
      <div>
        <label for="nombre" class="block font-medium mb-1">Título de la rutina</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $rutina->nombre) }}" required
               class="w-full border-gray-300 rounded-md p-2">
        @error('nombre')
          <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Imagen (gif_url) --}}
      <div>
        <label for="gif_url" class="block font-medium mb-1">URL de imagen (GIF)</label>
        <input type="url" name="gif_url" id="gif_url" value="{{ old('gif_url', $rutina->gif_url) }}"
               class="w-full border-gray-300 rounded-md p-2">
        @error('gif_url')
          <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Músculos secundarios --}}
      <div>
        <label for="secondary" class="block font-medium mb-1">Músculos secundarios (coma-separados)</label>
        <textarea name="secondary" id="secondary"
                  class="w-full border-gray-300 rounded-md p-2"
                  rows="2">{{ old('secondary', is_string($rutina->secondary) ? implode(', ', json_decode($rutina->secondary, true)) : '') }}</textarea>
        @error('secondary')
          <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Instrucciones --}}
      <div>
        <label for="instructions" class="block font-medium mb-1">Instrucciones (una por línea)</label>
        <textarea name="instructions" id="instructions"
                  class="w-full border-gray-300 rounded-md p-2"
                  rows="5">{{ old('instructions', is_string($rutina->instructions) ? implode("\n", json_decode($rutina->instructions, true)) : '') }}</textarea>
        @error('instructions')
          <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Botón --}}
      <div class="text-center">
        <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-8 py-3 rounded-full transition">
          Guardar cambios
        </button>
      </div>
    </form>
  </div>
</section>
@endsection
