<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PDF</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Lista de Poltronas - {{ $onibus }}</h2> <!-- Mostra o nome do ônibus selecionado -->
    <table>
        <tr><th>Número</th><th>Ônibus</th><th>Usuário Associado</th></tr>
        @foreach($poltronas as $poltrona)
            <tr>
                <td>{{ $poltrona->numero }}</td>
                <td>{{ $poltrona->onibus }}</td>
                <td>{{ $poltrona->usuario ? $poltrona->usuario->nome : 'Nenhum' }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
