<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            background-color: #2a2a2a;
            border-radius: 15px;
        }

        .form-label {
            font-size: 1.1rem;
        }

        .form-control {
            background-color: #333;
            border: 1px solid #444;
            color: #fff;
            border-radius: 10px;
            padding: 10px;
        }

        .form-control:focus {
            background-color: #444;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 10px;
            padding: 10px;
            font-size: 1.2rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-dark text-white shadow-lg">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Cadastro de Usuário</h2>

                        <form id="cadastroForm" method="POST" action="{{ route('users.store') }}" onsubmit="return validarFormulario(event)">
                            @csrf

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" id="nome" name="nome" class="form-control bg-dark text-white border-light" required>
                            </div>

                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" id="cpf" name="cpf" maxlength="14" class="form-control bg-dark text-white border-light" oninput="validarCPF()" required>
                            </div>

                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" id="senha" name="senha" class="form-control bg-dark text-white border-light" minlength="6" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function validarCPF() {
            let cpf = document.getElementById('cpf').value;
            cpf = cpf.replace(/\D/g, ''); // Remove qualquer caractere não numérico

            if (cpf.length > 11) {
                cpf = cpf.substring(0, 11);
            }

            // Adiciona a máscara no CPF
            document.getElementById('cpf').value = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
        }

        function validarFormulario(event) {
            // Remove apenas os pontos e o hífen do CPF
            let cpf = document.getElementById('cpf').value;
            cpf = cpf.replace(/[.-]/g, ''); // Remove os pontos e o hífen

            // Atualiza o campo de CPF para enviar sem máscara
            document.getElementById('cpf').value = cpf;

            const senha = document.getElementById('senha').value;

            // Verificação do CPF
            if (!validarCPFExistente(cpf)) {
                alert('CPF inválido. Verifique os números digitados.');
                event.preventDefault();
                return false;
            }

            // Verificação da senha
            if (senha.length < 6) {
                alert('A senha deve ter pelo menos 6 caracteres.');
                event.preventDefault();
                return false;
            }

            return true;
        }




        // Função para validar CPF com base no cálculo dos dígitos verificadores
        function validarCPFExistente(cpf) {
            if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
                // Verifica se o CPF tem 11 dígitos e não é uma sequência repetitiva (ex: 111.111.111.11)
                return false;
            }

            // Cálculo do primeiro dígito verificador
            let soma1 = 0;
            for (let i = 0; i < 9; i++) {
                soma1 += parseInt(cpf.charAt(i)) * (10 - i);
            }

            let digito1 = 11 - (soma1 % 11);
            if (digito1 === 10 || digito1 === 11) digito1 = 0;

            // Cálculo do segundo dígito verificador
            let soma2 = 0;
            for (let i = 0; i < 10; i++) {
                soma2 += parseInt(cpf.charAt(i)) * (11 - i);
            }

            let digito2 = 11 - (soma2 % 11);
            if (digito2 === 10 || digito2 === 11) digito2 = 0;

            // Verifica se os dígitos verificadores são válidos
            return cpf.charAt(9) == digito1 && cpf.charAt(10) == digito2;
        }
    </script>
</body>

</html>
