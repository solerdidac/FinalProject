@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-100">
  <div class="container mx-auto px-4">
    <h1 class="text-4xl font-bold text-center mb-12">{{ $meal['strMeal'] }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
      {{-- Imagen y meta --}}
      <div class="col-span-1">
        <img src="{{ $meal['strMealThumb'] }}" alt="{{ $meal['strMeal'] }}"
             class="w-full rounded-lg shadow-lg mb-6">
        <p class="text-gray-600"><strong>Categoría:</strong> {{ $meal['strCategory'] }}</p>
        <p class="text-gray-600"><strong>Origen:</strong> {{ $meal['strArea'] }}</p>
      </div>

      {{-- Ingredientes & instrucciones --}}
      <div class="col-span-1 md:col-span-2">
        <h2 class="text-2xl font-semibold mb-4">Ingredientes</h2>
        @php
          $ingredients = [];
          for($i=1; $i<=20; $i++){
            $ing = trim($meal["strIngredient{$i}"] ?? '');
            $msr = trim($meal["strMeasure{$i}"] ?? '');
            if($ing) $ingredients[] = "$msr $ing";
          }
        @endphp
        <ul class="list-disc ml-6 text-gray-700 mb-8">
          @foreach($ingredients as $item)
            <li>{{ $item }}</li>
          @endforeach
        </ul>

        <h2 class="text-2xl font-semibold mb-4">Instrucciones</h2>
        <p class="text-gray-700 whitespace-pre-line mb-8">{{ $meal['strInstructions'] }}</p>
      </div>
    </div>

    {{-- Botón “Guardar receta” --}}
    <div class="text-center mb-8">
      @auth
        <form method="POST" action="{{ route('rutinas.store') }}" class="inline-block">
          @csrf
          <input type="hidden" name="tipo"        value="alimentacion">
          <input type="hidden" name="nombre"      value="{{ $meal['strMeal'] }}">
          <input type="hidden" name="descripcion" value="Receta de {{ $meal['strMeal'] }} ({{ $meal['strCategory'] }})">
          <input type="hidden" name="gif_url"     value="{{ $meal['strMealThumb'] }}">
          <input type="hidden" name="secondary"   value="{{ implode(',', $ingredients) }}">
          <input type="hidden" name="instructions" value="{{ $meal['strInstructions'] }}">

          <button type="submit"
                  class="bg-lime-400 hover:bg-lime-500 text-black font-semibold px-8 py-3 rounded-full transition">
            ➕ Guardar receta
          </button>
        </form>
      @else
        <a href="{{ route('login') }}"
           class="bg-lime-400 hover:bg-lime-500 text-black font-semibold px-8 py-3 rounded-full transition">
          ➕ Inicia sesión para guardar receta
        </a>
      @endauth
    </div>

    <div class="text-center">
      <a href="{{ route('rutinas.alimentacion', ['categoria' => $meal['strCategory']]) }}"
         class="text-gray-600 hover:underline">
        ← Volver a {{ $meal['strCategory'] }}
      </a>
    </div>
  </div>
</section>
@endsection
