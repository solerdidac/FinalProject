@extends('layouts.app')

@section('content')
<section class="bg-black text-white py-16">
    <div class="container mx-auto px-4">
        {{-- 1) Usuario con suscripción activa --}}
        @auth
            @if(optional(auth()->user()->suscripcion)->estado === 'activo')
                @php
                    $s = auth()->user()->suscripcion;
                @endphp
                <div class="max-w-xl mx-auto bg-zinc-900 p-6 rounded-xl shadow-md text-center mb-12">
                    <h2 class="text-3xl font-bold text-lime-400 mb-4 uppercase">Tu Plan Actual</h2>
                    <p class="text-lg mb-2">
                        <strong>Plan:</strong> {{ ucfirst($s->plan) }} ({{ ucfirst($s->periodo) }})
                    </p>
                    <p class="text-sm text-gray-400 mb-4">
                        <strong>Desde:</strong> {{ $s->fecha_inicio->format('d/m/Y') }}
                        &nbsp; <strong>Hasta:</strong> {{ $s->fecha_fin->format('d/m/Y') }}
                    </p>
                    <div class="flex justify-center space-x-4">
                        <form method="POST" action="{{ route('suscripcion.cancelar') }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-full">
                                Cancelar suscripción
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        @endauth

        {{-- 2) Invitados o usuarios sin suscripción activa --}}
        @if(! auth()->check() || optional(auth()->user()->suscripcion)->estado !== 'activo')
            <div class="text-center mb-10">
                <h2 class="text-4xl font-bold tracking-wider">NUESTROS PLANES</h2>
                <div class="mt-4 flex items-center justify-center">
                    <span class="text-gray-400 mr-2">Mensual</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="togglePrice" class="sr-only peer" onchange="togglePricing()">
                        <div class="w-11 h-6 bg-gray-600 rounded-full peer-checked:bg-lime-400 transition-all"></div>
                        <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition peer-checked:translate-x-full"></div>
                    </label>
                    <span class="text-gray-400 ml-2">Anual</span>
                </div>

                <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                    @foreach($planes as $key => $plan)
                        <div class="bg-zinc-900 rounded-xl p-6 text-center shadow-md flex flex-col justify-between">
                            <div>
                                <h3 class="text-2xl font-bold mb-2 uppercase">{{ $plan['nombre'] }}</h3>
                                <div class="text-4xl font-extrabold">
                                    <span class="price-month">{{ $plan['precio_mensual'] }}</span>
                                    <span class="price-year hidden">{{ $plan['precio_anual'] }}</span>€
                                    <span class="text-sm text-gray-400 ml-1 price-label">/mes</span>
                                </div>
                                <ul class="mt-6 space-y-2 text-gray-300 text-sm">
                                    @if($key==='basic')
                                        <li>✔️ Acceso total a máquinas</li>
                                        <li>✔️ 2 clases dirigidas por semana</li>
                                        <li>✔️ Rutina inicial personalizada</li>
                                        <li>✔️ Revisión mensual básica</li>
                                    @else
                                        <li>✔️ Todo lo del plan Basic</li>
                                        <li>✔️ Rutinas avanzadas actualizadas</li>
                                        <li>✔️ Acceso completo al seguimiento digital</li>
                                        <li>✔️ Asesoramiento nutricional premium</li>
                                    @endif
                                </ul>
                            </div>
                            <a href="javascript:void(0)"
                               onclick="elegirPlan('{{ $key }}')"
                               class="mt-6 inline-block bg-lime-400 hover:bg-lime-500 text-black font-semibold py-2 px-6 rounded-full">
                                Elegir Plan
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    
</section>

<script>
    function togglePricing() {
        const yearly = document.getElementById('togglePrice').checked;
        document.querySelectorAll('.price-month').forEach(el => el.classList.toggle('hidden', yearly));
        document.querySelectorAll('.price-year').forEach(el => el.classList.toggle('hidden', !yearly));
        document.querySelectorAll('.price-label').forEach(el => el.textContent = yearly ? "/año" : "/mes");
    }

    function elegirPlan(plan) {
        const yearly  = document.getElementById('togglePrice').checked;
        const periodo = yearly ? 'anual' : 'mensual';
        const cents   = plan === 'basic'
                        ? (yearly ? 20000 : 2000)
                        : (yearly ? 35000 : 3500);

        window.location = `{{ route('suscripcion.formulario') }}?plan=${plan}&periodo=${periodo}&precio=${cents}`;
    }
</script>
@endsection
