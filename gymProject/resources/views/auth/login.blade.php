@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-black py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-gray-900 p-8 rounded-lg shadow-lg">
        <h2 class="text-center text-3xl font-extrabold text-white">Inicia sesión</h2>

        @if($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mt-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf

            <div class="rounded-md shadow-sm -space-y-px">
                <div class="mb-4">
                    <label for="correo" class="block text-sm font-medium text-gray-200">Correo electrónico</label>
                    <input id="correo" name="correo" type="email" required autofocus
                           class="appearance-none rounded w-full px-3 py-2 border border-gray-300 placeholder-gray-400 focus:outline-none focus:ring-lime-500 focus:border-lime-500 sm:text-sm">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-200">Contraseña</label>
                    <input id="password" name="password" type="password" required
                           class="appearance-none rounded w-full px-3 py-2 border border-gray-300 placeholder-gray-400 focus:outline-none focus:ring-lime-500 focus:border-lime-500 sm:text-sm">
                </div>
            </div>

            <div>
                <button type="submit"
                        class="w-full bg-lime-400 hover:bg-lime-500 text-black font-semibold py-2 px-6 rounded-full transition">
                    Iniciar sesión
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
