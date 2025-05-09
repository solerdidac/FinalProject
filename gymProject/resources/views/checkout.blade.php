@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-black py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full bg-gray-900 p-8 rounded-lg shadow-lg">
    <h2 class="text-3xl font-bold text-lime-400 text-center uppercase mb-4">Pagar Carrito</h2>
    <p class="text-center text-gray-300 mb-6">
      Total a pagar: <strong>{{ number_format($total,2) }} €</strong>
    </p>

    @if(session('error'))
      <div class="bg-red-500 text-white p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST" id="payment-form">
      @csrf
      <input type="hidden" name="amount" value="{{ $amount }}">

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
  const stripe = Stripe('{{ config("services.stripe.key") }}');
  const elements = stripe.elements();
  const card = elements.create('card');
  card.mount('#card-element');

  card.on('change', e => {
    document.getElementById('card-errors').textContent = e.error ? e.error.message : '';
  });

  const form = document.getElementById('payment-form');
  form.addEventListener('submit', async e => {
    e.preventDefault();
    const { token, error } = await stripe.createToken(card);
    if (error) {
      document.getElementById('card-errors').textContent = error.message;
    } else {
      const input = document.createElement('input');
      input.setAttribute('type', 'hidden');
      input.setAttribute('name', 'stripeToken');
      input.setAttribute('value', token.id);
      form.appendChild(input);
      form.submit();
    }
  });
</script>
@endsection
