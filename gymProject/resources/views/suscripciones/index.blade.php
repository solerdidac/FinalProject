@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    @guest
        <h1 class="text-2xl font-bold mb-4">Nuestros Planes</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($planes as $key => $plan)
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl font-bold">{{ $plan['nombre'] }}</h2>
                    <p>€{{ $plan['precio_mensual'] }} / mes</p>
                    <p>€{{ $plan['precio_anual'] }} / año</p>
                    <a href="{{ route('login') }}"
                       class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
                       Elegir Plan
                    </a>
                </div>
            @endforeach
        </div>

    @else
        @if(!$suscripcion || $suscripcion->estado !== 'activo')
            <h1 class="text-2xl font-bold mb-4">Elige tu Plan</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($planes as $key => $plan)
                    <div class="bg-white p-6 rounded shadow">
                        <h2 class="text-xl font-bold">{{ $plan['nombre'] }}</h2>
                        <p>€{{ $plan['precio_mensual'] }} / mes</p>
                        <p>€{{ $plan['precio_anual'] }} / año</p>
                        <a href="{{ route('suscripcion.formulario', ['plan' => $key, 'precio' => $plan['precio_mensual'] * 100]) }}"
                           class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded">
                           Suscribirme Mensual
                        </a>
                        <a href="{{ route('suscripcion.formulario', ['plan' => $key, 'precio' => $plan['precio_anual'] * 100]) }}"
                           class="mt-4 inline-block bg-green-800 text-white px-4 py-2 rounded">
                           Suscribirme Anual
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <h1 class="text-2xl font-bold mb-4">Tu Suscripción Actual</h1>
            <div class="bg-white p-6 rounded shadow mb-6">
                <p>Plan: <strong>{{ ucfirst($suscripcion->plan) }}</strong></p>
                <p>Inicio: <strong>{{ \Carbon\Carbon::parse($suscripcion->fecha_inicio)->format('d/m/Y') }}</strong></p>
            </div>

            <h2 class="text-xl font-bold mb-4">Cambiar Plan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($planes as $key => $plan)
                    @if($key !== $suscripcion->plan)
                        <div class="bg-white p-6 rounded shadow">
                            <h2 class="text-xl font-bold">{{ $plan['nombre'] }}</h2>
                            <p>€{{ $plan['precio_mensual'] }} / mes</p>
                            <p>€{{ $plan['precio_anual'] }} / año</p>
                            <a href="{{ route('suscripcion.formulario', ['plan' => $key, 'precio' => $plan['precio_mensual'] * 100]) }}"
                               class="mt-4 inline-block bg-yellow-600 text-white px-4 py-2 rounded">
                               Cambiar a Mensual
                            </a>
                            <a href="{{ route('suscripcion.formulario', ['plan' => $key, 'precio' => $plan['precio_anual'] * 100]) }}"
                               class="mt-4 inline-block bg-yellow-800 text-white px-4 py-2 rounded">
                               Cambiar a Anual
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    @endguest
</div>
@endsection
