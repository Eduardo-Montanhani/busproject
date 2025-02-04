<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Poltrona</title>
    <!-- Incluindo o Bootstrap 5 via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Criar Poltrona</h2>
                        <form action="{{ route('poltronas.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="numero" class="form-label">Número da Poltrona</label>
                                <input type="number" id="numero" name="numero" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="usuario_id" class="form-label">Associar Usuário</label>
                                <select class="form-select" id="usuario_id" name="usuario_id">
                                    <option value="">Selecione um Usuário (opcional)</option>
                                    @foreach($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}">{{ $usuario->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Adicionando o campo para selecionar o ônibus -->
                            <div class="mb-3">
                                <label for="onibus" class="form-label">Escolha o Ônibus</label>
                                <select class="form-select" id="onibus" name="onibus" required>
                                    <option value="Onibus 1">Onibus 1</option>
                                    <option value="Onibus 2">Onibus 2</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Cadastrar Poltrona</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluindo o script do Bootstrap 5 via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
