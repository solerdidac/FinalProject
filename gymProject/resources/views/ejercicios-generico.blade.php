<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicios de {{ ucfirst($bodyPart) }}</title>
</head>
<body>
    <h1>Ejercicios de {{ ucfirst($bodyPart) }} (Top 10)</h1>

    @if (isset($ejercicios[0]['name']))
        @foreach ($ejercicios as $ej)
            <div style="border:1px solid #ccc;padding:15px;margin-bottom:15px;">
                <h2>{{ $ej['name'] }}</h2>
                <img src="{{ $ej['gifUrl'] }}" alt="{{ $ej['name'] }}" width="200">
                <p><strong>Equipo:</strong> {{ $ej['equipment'] }}</p>
                <p><strong>Target:</strong> {{ $ej['target'] }}</p>
                <p><strong>Secundarios:</strong> {{ implode(', ', $ej['secondaryMuscles']) }}</p>
                <h4>Instrucciones:</h4>
                <ol>
                    @foreach ($ej['instructions'] as $paso)
                        <li>{{ $paso }}</li>
                    @endforeach
                </ol>
            </div>
        @endforeach
    @else
        <p style="color: red;">⚠️ {{ $ejercicios['message'] ?? 'No se encontraron ejercicios.' }}</p>
    @endif
</body>
</html>
