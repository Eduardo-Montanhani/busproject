<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poltronas Disponíveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-5">Poltronas Disponíveis</h1>
        <form action="{{ route('poltronas.disponiveis') }}" method="GET" class="mb-4">
            <div class="d-flex justify-content-center align-items-center">
                <label for="onibus" class="me-2">Escolha o Ônibus:</label>
                <select name="onibus" id="onibus" class="form-select w-auto">
                    <option value="Onibus 1" {{ request('onibus') == 'Onibus 1' ? 'selected' : '' }}>GessiTur</option>
                    <option value="Onibus 2" {{ request('onibus') == 'Onibus 2' ? 'selected' : '' }}>AltoniaTur</option>
                </select>
                <button type="submit" class="btn btn-primary ms-2">Filtrar</button>
            </div>
        </form>



        <!-- Mensagens de Sucesso ou Erro -->
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Cards das Poltronas Disponíveis -->
        <div class="row g-4" id="poltronas-container">
            @forelse($poltronas as $poltrona)
            <div class="col-md-3">
                <div class="card shadow-sm border-light rounded">
                    <div class="card-body text-center">
                        <i class="bi bi-chair mb-3" style="font-size: 2rem;"></i>
                        <h5 class="card-title mb-3">Poltrona #{{ $poltrona->numero }}</h5>
                        <form action="{{ route('poltronas.reservar', $poltrona->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">Reservar</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center mt-4">Nenhuma poltrona disponível no momento.</p>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
