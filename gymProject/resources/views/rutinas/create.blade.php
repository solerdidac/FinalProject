@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-100">
  <div class="container mx-auto px-4">
    <h1 class="text-4xl font-bold text-center mb-12">
      @if($tipo === 'fuerza')
        Crear nueva rutina de Fuerza
      @else
        Crear nueva receta de Alimentación
      @endif
    </h1>

    <form method="POST" action="{{ route('rutinas.store') }}" class="max-w-xl mx-auto space-y-6">
      @csrf
      <input type="hidden" name="tipo" value="{{ $tipo }}">

      {{-- Título --}}
      <div>
        <label for="nombre" class="block font-medium mb-1">
          Título {{ $tipo === 'fuerza' ? 'de la rutina' : 'de la receta' }}
        </label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
               class="w-full border-gray-300 rounded-md p-2">
        @if($errors->has('nombre'))
          <p class="text-red-500 mt-1">{{ $errors->first('nombre') }}</p>
        @endif
      </div>

      {{-- Para recetas: categoría --}}
      @if($tipo === 'alimentacion')
        <div>
          <label for="categoria" class="block font-medium mb-1">Categoría</label>
          <select name="categoria" id="categoria" class="w-full border-gray-300 rounded-md p-2">
            @foreach($categorias as $cat)
              <option value="{{ $cat }}" {{ old('categoria', $seleccionado ?? '') === $cat ? 'selected' : '' }}>
                {{ $cat }}
              </option>
            @endforeach
          </select>
        </div>

        {{-- Descripción opcional --}}
        <div>
          <label for="descripcion" class="block font-medium mb-1">Descripción</label>
          <textarea name="descripcion" id="descripcion"
                    class="w-full border-gray-300 rounded-md p-2"
                    rows="2">{{ old('descripcion') }}</textarea>
        </div>

        {{-- Imagen opcional --}}
        <div>
          <label for="gif_url" class="block font-medium mb-1">URL de imagen de la receta (opcional)</label>
          <input type="url" name="gif_url" id="gif_url" value="{{ old('gif_url') }}"
                 placeholder="https://..." class="w-full border-gray-300 rounded-md p-2">
        </div>
      @endif

      {{-- Solo fuerza: GIF obligatorio --}}
      @if($tipo === 'fuerza')
        <div>
          <label for="gif_url" class="block font-medium mb-1">URL del GIF o imagen del ejercicio</label>
          <input type="url" name="gif_url" id="gif_url" value="{{ old('gif_url') }}"
                 placeholder="https://..." class="w-full border-gray-300 rounded-md p-2">
          @if($errors->has('gif_url'))
            <p class="text-red-500 mt-1">{{ $errors->first('gif_url') }}</p>
          @endif
        </div>
      @endif

      {{-- Ingredientes / Músculos secundarios --}}
      <div>
        <label for="secondary" class="block font-medium mb-1">
          {{ $tipo === 'fuerza' ? 'Músculos secundarios (coma-separados)' : 'Ingredientes (coma-separados)' }}
        </label>
        <textarea name="secondary" id="secondary"
                  class="w-full border-gray-300 rounded-md p-2"
                  rows="2">{{ old('secondary') }}</textarea>
      </div>

      {{-- Instrucciones --}}
      <div>
        <label for="instructions" class="block font-medium mb-1">
          {{ $tipo === 'fuerza' ? 'Instrucciones (una línea por paso)' : 'Instrucciones' }}
        </label>
        <textarea name="instructions" id="instructions"
                  class="w-full border-gray-300 rounded-md p-2"
                  rows="5">{{ old('instructions') }}</textarea>
      </div>

      {{-- Botón --}}
      <div class="text-center">
        <button type="submit"
                class="bg-lime-400 hover:bg-lime-500 text-black font-semibold px-8 py-3 rounded-full transition">
          ➕ Guardar {{ $tipo === 'fuerza' ? 'rutina' : 'receta' }}
        </button>
      </div>
    </form>
  </div>
</section>
@endsection
