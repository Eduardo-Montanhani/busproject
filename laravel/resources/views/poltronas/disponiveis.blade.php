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

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

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
