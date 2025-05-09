@extends('layouts.landing')

@section('content')
    <!-- Hero Section con video de fondo -->
    <section class="relative w-full h-screen overflow-hidden z-10">
        <video autoplay loop muted playsinline class="absolute w-full h-full object-cover">
            <source src="{{ asset('videos/videoGym.mp4') }}" type="video/mp4" />
            Tu navegador no soporta el video.
        </video>

        <div class="absolute inset-0 bg-black bg-opacity-60"></div>

        <div class="relative z-10 flex items-center justify-center h-full">
            <div class="text-center text-white px-4">
                <h1 class="text-5xl font-extrabold tracking-tight mb-4 uppercase">
                    TRANSFORMA TU CUERPO Y TU MENTE
                </h1>
                <p class="text-xl font-medium text-gray-200 mb-8 max-w-2xl mx-auto">
                    Con nuestros planes de fuerza, nutrición y seguimiento digital, conviértete en la mejor versión de ti. Entrena con propósito, avanza con inteligencia.
                </p>
                <div>
                    <a href="{{ route('planes.index') }}"
                    class="bg-lime-400 hover:bg-lime-500 text-black font-semibold px-6 py-3 rounded-md transition">
                        Start Now
                    </a>
                    <a href="#why-choose-us"
                    class="ml-4 border border-lime-400 hover:bg-lime-400 hover:text-black text-lime-400 font-semibold px-6 py-3 rounded-md transition">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

        <!-- Sección "Why Choose Us" -->
<section id="why-choose-us" class="py-16 bg-black text-white">
    <div class="max-w-6xl mx-auto px-4 text-center border-2 border-white rounded-lg p-6">
        <h2 class="text-3xl font-bold mb-10">WHY CHOOSE US</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Planes Personalizados -->
            <div class="bg-zinc-900 p-6 rounded-lg text-left text-sm h-full flex flex-col justify-between">
                <div>
                    <div class="min-h-[60px] flex items-start">
                        <img src="{{ asset('logos-home/logo1.png') }}" alt="Planes" class="w-12 mb-3">
                    </div>
                    <h3 class="text-xl font-extrabold mb-2">PLANES PERSONALIZADOS</h3>
                    <p class="text-gray-300 mb-4 line-clamp-3 overflow-hidden text-ellipsis">
                        Adaptamos rutinas de fuerza y nutrición a tus necesidades combinando objetivos de salud, entrenamiento funcional y asesoramiento constante para lograr un plan eficaz.
                    </p>
                </div>
                <div>
                    <div id="personalizados" class="hidden mb-2 text-gray-400">
                        Diseñamos planes completos con seguimiento constante, análisis de objetivos y progresión individualizada.
                    </div>
                    <button type="button" onclick="toggleContent('personalizados')" class="text-lime-400 hover:underline">
                        Leer Más →
                    </button>
                </div>
            </div>

            <!-- Seguimiento Digital -->
            <div class="bg-zinc-900 p-6 rounded-lg text-left text-sm h-full flex flex-col justify-between">
                <div>
                    <div class="min-h-[60px] flex items-start">
                        <img src="{{ asset('logos-home/logo3.png') }}" alt="Tracking" class="w-12 mb-3">
                    </div>
                    <h3 class="text-xl font-extrabold mb-2">SEGUIMIENTO DIGITAL</h3>
                    <p class="text-gray-300 mb-4 line-clamp-3 overflow-hidden text-ellipsis">
                        Controla tu progreso en tiempo real desde nuestra plataforma accesible en todos tus dispositivos. Obtén métricas detalladas de cada sesión, peso y rendimiento.
                    </p>
                </div>
                <div>
                    <div id="seguimiento" class="hidden mb-2 text-gray-400">
                        Registra cada ejercicio, caloría, peso levantado y descanso. Compatible con móviles y dispositivos inteligentes.
                    </div>
                    <button type="button" onclick="toggleContent('seguimiento')" class="text-lime-400 hover:underline">
                        Leer Más →
                    </button>
                </div>
            </div>

            <!-- Suscripciones -->
            <div class="bg-zinc-900 p-6 rounded-lg text-left text-sm h-full flex flex-col justify-between">
                <div>
                    <div class="min-h-[60px] flex items-start">
                        <img src="{{ asset('logos-home/logo2.png') }}" alt="Suscripciones" class="w-12 mb-3">
                    </div>
                    <h3 class="text-xl font-extrabold mb-2">SUSCRIPCIONES</h3>
                    <p class="text-gray-300 mb-4 line-clamp-3 overflow-hidden text-ellipsis">
                        Accede a planes exclusivos mensuales y anuales que incluyen rutinas avanzadas, seguimiento premium y acceso a contenido exclusivo...
                    </p>
                </div>
                <div>
                    <a href="{{ route('planes.index') }}" class="text-lime-400 hover:underline">
                        Leer Más →
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    function toggleContent(id) {
        const el = document.getElementById(id);
        el.classList.toggle('hidden');
    }
</script>
@endsection
