@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16">
    <h1 class="text-4xl font-bold text-center mb-8">Tu Carrito</h1>

    @if($cartItems->isEmpty())
        <p class="text-center text-gray-600">Tu carrito está vacío.</p>
    @else
        <div class="space-y-4 mb-8">
            @foreach($cartItems as $item)
                <div class="flex items-center bg-white rounded-lg shadow p-4">
                    {{-- Imagen del producto --}}
                    <img src="{{ asset($item['producto']->imagen) }}"
                         alt="{{ $item['producto']->nombre }}"
                         class="w-24 h-24 object-contain rounded mr-4">

                    <div class="flex-1">
                        <h2 class="text-xl font-semibold">{{ $item['producto']->nombre }}</h2>
                        <p class="text-gray-600">
                            Precio unidad: {{ number_format($item['producto']->precio,2) }} €
                        </p>

                        {{-- Actualizar cantidad --}}
                        <form action="{{ route('cart.update') }}" method="POST" class="mt-2 inline-block">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['producto']->id }}">
                            <input type="number" name="quantity"
                                   value="{{ $item['quantity'] }}"
                                   min="1"
                                   class="w-16 border-gray-300 rounded-md p-1">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded ml-2">
                                Actualizar
                            </button>
                        </form>

                        {{-- Eliminar producto --}}
                        <form action="{{ route('cart.remove') }}" method="POST" class="inline-block ml-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['producto']->id }}">
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">
                                Eliminar
                            </button>
                        </form>
                    </div>

                    {{-- Subtotal --}}
                    <div class="font-bold text-lg">
                        {{ number_format($item['producto']->precio * $item['quantity'],2) }} €
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Botón de pagar --}}
        <div class="text-right">
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="bg-lime-400 hover:bg-lime-500 text-black font-semibold py-3 px-6 rounded-full">
                    Ir a pagar
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
