@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Editar Perfil</h1>
    @if(session('status'))
        <div class="mb-4 p-2 bg-green-100 text-green-800">
            {{ session('status') }}
        </div>
    @endif

    @include('profile.partials.update-profile-information-form', ['user' => $user])
</div>
@endsection
