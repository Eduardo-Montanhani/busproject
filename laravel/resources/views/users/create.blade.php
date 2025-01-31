<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <!-- Incluindo o Bootstrap 5 via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Formulário de Cadastro</h2>
                        <form id="cadastroForm" method="POST" action="{{ route('users.store') }}" onsubmit="return validarFormulario(event)">
                            @csrf

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" id="nome" name="nome" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" id="cpf" name="cpf" maxlength="11" class="form-control" oninput="validarCPF()" required>
                            </div>

                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" id="senha" name="senha" class="form-control" minlength="6" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluindo o script do Bootstrap 5 via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Função para validar o CPF (apenas 11 números)
        function validarCPF() {
            let cpf = document.getElementById('cpf').value;
            cpf = cpf.replace(/\D/g, ''); // Remove tudo que não for número

            if (cpf.length > 11) {
                cpf = cpf.substring(0, 11); // Limita para 11 números
            }
            document.getElementById('cpf').value = cpf;
        }

        // Função para validar o formulário antes de enviar
        function validarFormulario(event) {
            const cpf = document.getElementById('cpf').value;
            const senha = document.getElementById('senha').value;

            // Verifica se o CPF tem exatamente 11 caracteres numéricos
            if (cpf.length !== 11) {
                alert('O CPF deve ter exatamente 11 números.');
                event.preventDefault(); // Impede o envio do formulário
                return false;
            }

            // Verifica se a senha tem pelo menos 6 caracteres
            if (senha.length < 6) {
                alert('A senha deve ter pelo menos 6 caracteres.');
                event.preventDefault(); // Impede o envio do formulário
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
