@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Registrarse</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-4">
            <label for="name" class="block">Nombre:</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full border p-2">
        </div>
        <div class="mb-4">
            <label for="email" class="block">Email:</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full border p-2">
        </div>
        <div class="mb-4">
            <label for="password" class="block">Contraseña:</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full border p-2">
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block">Confirmar Contraseña:</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full border p-2">
        </div>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Registrarse</button>
    </form>

    <p class="mt-4 text-center">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Inicia Sesión</a>
    </p>
</div>
@endsection
