
@extends('layouts.app')

@section('content')
<section class="bg-black text-white py-16">
    <div class="max-w-2xl mx-auto text-center">
        <h2 class="text-4xl font-bold uppercase tracking-wider mb-6">Tu plan actual</h2>

        <div class="bg-zinc-900 rounded-xl p-6 shadow-md text-left">
            <h3 class="text-2xl font-bold mb-2 uppercase">{{ ucfirst($suscripcion->plan) }}</h3>
            <p class="text-gray-300 mb-2">Estado: <span class="text-lime-400 font-semibold">{{ $suscripcion->estado }}</span></p>
            <p class="text-gray-300 mb-2">Fecha de inicio: {{ \Carbon\Carbon::parse($suscripcion->fecha_inicio)->format('d/m/Y') }}</p>

            <div class="flex justify-between items-center mt-6">
                <form method="POST" action="{{ route('suscripcion.cancelar') }}">
                    @csrf
                    <button class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-full transition">
                        Cancelar suscripción
                    </button>
                </form>

                <a href="{{ route('planes.index') }}" class="bg-lime-400 hover:bg-lime-500 text-black font-semibold px-4 py-2 rounded-full transition">
                    Cambiar de plan
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
