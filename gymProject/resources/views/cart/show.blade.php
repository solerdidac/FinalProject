@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Tu carrito</h1>

    @if (count($cart) > 0)
        <table class="w-full text-left border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">Producto</th>
                    <th class="p-2">Precio</th>
                    <th class="p-2">Cantidad</th>
                    <th class="p-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $item)
                    <tr class="border-t">
                        <td class="p-2">{{ $item['nombre'] }}</td>
                        <td class="p-2">€{{ number_format($item['precio'], 2) }}</td>
                        <td class="p-2">{{ $item['cantidad'] }}</td>
                        <td class="p-2">€{{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right mt-4 text-xl font-bold">
            Total: €{{ number_format($total, 2) }}
        </div>

        <div class="mt-6 text-right">
            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-lime-400 hover:bg-lime-500 text-black font-semibold py-2 px-6 rounded-full transition">
                    Finalizar compra
                </button>
            </form>
        </div>
    @else
        <p class="text-gray-600">Tu carrito está vacío.</p>
    @endif
</div>
@endsection
