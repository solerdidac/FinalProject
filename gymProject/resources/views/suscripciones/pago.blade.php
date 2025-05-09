@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-black py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-gray-900 p-8 rounded-lg shadow-lg">
            <h2 class="text-3xl font-extrabold text-lime-400 text-center uppercase mb-4">{{ strtoupper($plan) }} PLAN</h2>
            <p class="text-center text-gray-300 mb-6">
                Estás a punto de contratar el <strong>{{ ucfirst($plan) }}</strong>
                por <span class="text-lime-400 font-bold">{{ number_format($precio / 100, 2) }} €</span>.
            </p>

            @if(session('error'))
                <div class="bg-red-500 text-white p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('suscripciones.procesar') }}" method="POST" id="payment-form">
    @csrf

    {{-- Plan y periodo para el controlador --}}
    <input type="hidden" name="plan"    value="{{ $plan }}">
    <input type="hidden" name="periodo" value="{{ $periodo }}">
    <input type="hidden" name="precio"  value="{{ $precio }}">

    {{-- Tarjeta --}}
    <label for="card-element" class="text-white block mb-2">Tarjeta de crédito</label>
    <div id="card-element" class="bg-white p-3 rounded mb-4"></div>
    <div id="card-errors" class="text-red-400 text-sm mt-1"></div>

    <button
        class="w-full mt-4 bg-lime-400 hover:bg-lime-500 text-black font-semibold py-2 px-6 rounded-full transition">
        Confirmar y pagar
    </button>
</form>

        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ config('services.stripe.key') }}");
        const elements = stripe.elements();

        const style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#a0aec0'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        const card = elements.create('card', { style: style });
        card.mount('#card-element');

        const form = document.getElementById('payment-form');

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    document.getElementById('card-errors').textContent = result.error.message;
                } else {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            });
        });
    </script>
@endsection
