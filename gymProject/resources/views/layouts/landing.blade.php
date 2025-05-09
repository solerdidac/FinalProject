<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <title>{{ config('app.name','GYMTEAM') }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
@php
  $isHome = request()->routeIs('home');
@endphp
<body class="font-sans bg-white text-gray-900 {{ $isHome ? '' : 'pt-16' }}">
  {{-- Navbar --}}
  <nav id="navbar"
       class="fixed w-full top-0 z-50 bg-transparent transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      <a href="{{ route('home') }}" class="text-2xl font-bold uppercase tracking-wide text-white">
        GYMTEAM
      </a>
      <div class="hidden md:flex space-x-6">
        <a href="{{ route('home') }}"       class="text-white hover:text-lime-400">Inicio</a>
        <a href="{{ route('products.index') }}" class="text-white hover:text-lime-400">Tienda</a>
        <a href="{{ route('rutinas.index') }}"   class="text-white hover:text-lime-400">Rutinas</a>
      </div>
      <div class="hidden md:flex space-x-4">
        @guest
          <a href="{{ route('register') }}" class="text-white hover:text-lime-400">Registrarse</a>
          <a href="{{ route('login') }}"    class="text-white hover:text-lime-400">Login</a>
        @else
          <a href="{{ route('perfil') }}" class="text-white hover:text-lime-400">
            {{ auth()->user()->nombre }}
          </a>
          <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-white hover:text-lime-400">Cerrar Sesión</button>
          </form>
        @endguest
      </div>
    </div>
  </nav>

  <main>
    @yield('content')
  </main>

  <footer class="bg-black text-white py-8 pt-16">
    <div class="container mx-auto px-4 text-center">
      <p>&copy; {{ date('Y') }} GYMTEAM. All rights reserved.</p>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const nav = document.getElementById('navbar');
      window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
          nav.classList.replace('bg-transparent', 'bg-black');
        } else {
          nav.classList.replace('bg-black', 'bg-transparent');
        }
      });
    });
  </script>
</body>
</html>
