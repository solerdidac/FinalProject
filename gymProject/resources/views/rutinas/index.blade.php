@extends('layouts.app')

@section('content')
<section class="py-20 bg-gray-100">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-12">Elige el tipo de rutina</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Fuerza -->
            <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center">
                <h2 class="text-2xl font-semibold mb-4">Rutinas de Fuerza</h2>
                <p class="text-gray-600 mb-6">
                    Explora rutinas de fuerza, personaliza las tuyas y sigue tus progresos.
                </p>
                <a href="{{ route('rutinas.fuerza') }}"
                   class="bg-lime-400 hover:bg-lime-500 text-black font-semibold px-6 py-3 rounded-full transition">
                    Ver Fuerza
                </a>
            </div>
            <!-- Alimentación -->
            <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center">
            <h2 class="text-2xl font-semibold mb-4">Rutinas de Alimentación</h2>
                <p class="text-gray-600 mb-6">
                    Descubre planes de alimentación y crea tu propia rutina nutricional.
                </p>
                <a href="{{ route('rutinas.alimentacion') }}"
                   class="bg-lime-400 hover:bg-lime-500 text-black font-semibold px-6 py-3 rounded-full transition">
                    Ver Alimentación
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
