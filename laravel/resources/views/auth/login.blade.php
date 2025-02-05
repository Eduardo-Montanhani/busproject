<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuário</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #121212, #1e1e1e);
            color: white;
        }
        .card {
            background: #222;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body class="d-flex align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4">
                    <h2 class="text-center mb-4">Acesse sua conta</h2>

                    <!-- Mensagens de erro ou sucesso -->
                    @if(session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger text-center">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('usuario.login') }}" onsubmit="return validarFormulario(event)">
                        @csrf
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" id="cpf" name="cpf" class="form-control" maxlength="11" oninput="validarCPF()" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" id="senha" name="senha" class="form-control" minlength="6" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validarCPF() {
            let cpf = document.getElementById('cpf').value;
            cpf = cpf.replace(/\D/g, '');
            if (cpf.length > 11) {
                cpf = cpf.substring(0, 11);
            }
            document.getElementById('cpf').value = cpf;
        }
        function validarFormulario(event) {
            const cpf = document.getElementById('cpf').value;
            const senha = document.getElementById('senha').value;
            if (cpf.length !== 11) {
                alert('O CPF deve ter exatamente 11 números.');
                event.preventDefault();
                return false;
            }
            if (senha.length < 6) {
                alert('A senha deve ter pelo menos 6 caracteres.');
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
