<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poltronas Disponíveis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* 🌑 Tema Escuro Sofisticado */
        body {
            background: #121212;
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }

        .card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s;
            text-align: center;
            padding: 20px;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.2);
        }

        .btn-success {
            background: linear-gradient(90deg, #16a085, #27ae60);
            border: none;
            font-weight: bold;
            transition: background 0.3s ease-in-out;
        }

        .btn-success:hover {
            background: linear-gradient(90deg, #1abc9c, #2ecc71);
        }

        .fa-chair {
            font-size: 2.5rem;
            color: #f8c102;
            text-shadow: 0 0 15px rgba(248, 193, 2, 0.7);
        }

        .user-welcome {
            font-size: 1.3rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .form-select {
            background-color: #1e1e1e;
            color: white;
            border: 1px solid #555;
        }

        .form-select:focus {
            border-color: #f8c102;
            box-shadow: 0 0 10px rgba(248, 193, 2, 0.6);
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <!-- Exibe o nome do usuário logado -->
        <div class="user-welcome">
            Bem-vindo, <span class="text-warning">
                {{ auth()->check() ? explode(' ', auth()->user()->nome)[0] : 'Visitante' }}
            </span>!
        </div>

        <h1 class="text-center mb-4">Poltronas Disponíveis</h1>

        <form action="{{ route('poltronas.disponiveis') }}" method="GET" class="mb-4">
            <div class="d-flex justify-content-center align-items-center">
                <label for="onibus" class="me-2">🚌 Escolha o Ônibus:</label>
                <select name="onibus" id="onibus" class="form-select w-auto">
                    <option value="Onibus 1" {{ request('onibus') == 'Onibus 1' ? 'selected' : '' }}>GessiTur</option>
                    <option value="Onibus 2" {{ request('onibus') == 'Onibus 2' ? 'selected' : '' }}>AltoniaTur</option>
                </select>
                <button type="submit" class="btn btn-primary ms-2">Filtrar</button>
            </div>
        </form>

        <!-- Mensagens de Sucesso ou Erro -->
        @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <!-- Cards das Poltronas Disponíveis -->
        <div class="row g-4" id="poltronas-container">
            @forelse($poltronas as $poltrona)
            <div class="col-md-3">
                <div class="card">
                    <i class="fa-solid fa-chair mb-3"></i>
                    <h5 class="card-title">Poltrona #{{ $poltrona->numero }}</h5>
                    <form action="{{ route('poltronas.reservar', $poltrona->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">Reservar</button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-center mt-4">🚫 Nenhuma poltrona disponível no momento.</p>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
