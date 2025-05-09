@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold">Bienvenido al panel de control</h1>
    <p class="mt-2">Desde aquí puedes acceder a tus rutinas y demás opciones.</p>
    <div class="mt-4 space-x-4">
        <a href="{{ route('rutinas.fuerza') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Rutinas de Fuerza</a>
        <a href="{{ route('rutinas.alimentacion') }}" class="px-4 py-2 bg-green-600 text-white rounded">Rutinas de Alimentación</a>
    </div>
</div>
@endsection
