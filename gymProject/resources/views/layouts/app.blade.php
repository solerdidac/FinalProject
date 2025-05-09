<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <title>{{ config('app.name','GYMTEAM') }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="font-sans bg-white text-gray-900">

  <!-- Navbar sólida -->
  <nav class="bg-black fixed w-full z-50 top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="text-2xl font-bold uppercase tracking-wide text-white">
          GYMTEAM
        </a>

        <!-- Menú de navegación -->
        <div class="hidden md:flex space-x-6">
          <a href="{{ route('home') }}" class="text-white hover:text-lime-400 transition">Inicio</a>
          <a href="{{ route('products.index') }}" class="text-white hover:text-lime-400 transition">Tienda</a>
          <a href="{{ route('rutinas.index') }}" class="text-white hover:text-lime-400 transition">Rutinas</a>

          {{-- Mostrar carrito solo si estás en la tienda --}}
          @if(Route::currentRouteName() === 'products.index')
            <a href="{{ route('cart.index') }}" class="text-white hover:text-lime-400 transition">
              Carrito
            </a>
          @endif
        </div>

        <!-- Acciones de usuario -->
        <div class="hidden md:flex space-x-4">
          @guest
            <a href="{{ route('register') }}" class="text-white hover:text-lime-400 transition">Registrarse</a>
            <a href="{{ route('login') }}" class="text-white hover:text-lime-400 transition">Login</a>
          @else
          <a href="{{ route('perfil') }}" class="text-white hover:text-lime-400 transition">
            {{ auth()->user()->nombre }}
          </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="text-white hover:text-lime-400 transition">Cerrar Sesión</button>
            </form>
          @endguest
        </div>
      </div>
    </div>
  </nav>

  <main class="pt-16">
    @yield('content')
  </main>

  <footer class="bg-black text-white py-8">
    <div class="container mx-auto px-4 text-center">
      <p>&copy; {{ date('Y') }} GYMTEAM. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
