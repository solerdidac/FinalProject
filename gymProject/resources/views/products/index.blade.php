@extends('layouts.app')

@section('content')
@php $categoria = request('categoria', ''); @endphp

<div class="container mx-auto px-4">
    {{-- Título --}}
    <h1 class="text-5xl font-extrabold mt-6 mb-2 text-center text-gray-800">
        Nuestra Tienda
    </h1>
    <p class="text-center text-gray-600 mb-8 text-lg">
        Descubre todo lo que necesitas para tu entrenamiento: suplementos, complementos y más.
    </p>

    {{-- Filtro --}}
    <div class="mb-8 flex justify-center">
        <label for="categoria" class="block text-sm font-medium text-gray-700 mr-2">
            Filtrar por categoría:
        </label>
        <select id="categoria"
                onchange="window.location.href='?categoria='+this.value"
                class="rounded-md border-gray-300 shadow-sm focus:ring-lime-500 focus:border-lime-500">
            <option value="" {{ $categoria === '' ? 'selected' : '' }}>Todas</option>
            <option value="suplemento" {{ $categoria==='suplemento' ? 'selected':'' }}>
                Suplementos
            </option>
            <option value="complemento" {{ $categoria==='complemento' ? 'selected':'' }}>
                Complementos
            </option>
        </select>
    </div>

    {{-- Productos --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-12">
        @forelse($productos as $producto)
            <div class="bg-white rounded-lg shadow p-6 flex flex-col">
                <img src="{{ asset($producto->imagen) }}"
                     alt="{{ $producto->nombre }}"
                     class="w-40 h-40 object-contain mx-auto mb-4 rounded">
                <h2 class="text-xl font-semibold mb-2">{{ $producto->nombre }}</h2>
                <p class="text-gray-600 text-sm mb-2">{{ $producto->descripcion }}</p>
                <p class="font-bold text-green-600 mb-4">
                    {{ number_format($producto->precio,2) }} €
                </p>
                <p class="text-sm text-gray-500 mb-4">
                    Categoría: {{ ucfirst($producto->categoria) }}
                </p>

                {{-- Añadir al carrito --}}
                <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $producto->id }}">
                    <button type="submit"
                        class="w-full bg-lime-400 hover:bg-lime-500 text-black font-semibold py-2 px-4 rounded-full transition">
                        Añadir al carrito
                    </button>
                </form>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">
                No hay productos disponibles en esta categoría.
            </p>
        @endforelse
    </div>

    {{-- Mensajes post-checkout --}}
    @if(request('success'))
        <p class="text-green-600 text-center mb-8">
            ¡Pago exitoso! Gracias por tu compra.
        </p>
    @elseif(request('cancel'))
        <p class="text-red-600 text-center mb-8">
            Pago cancelado. Puedes intentarlo de nuevo.
        </p>
    @endif
</div>
@endsection
