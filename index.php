<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geração de Email, Senha e Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            display: inline-block;
            padding: 8px 16px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php

function gerarSenha() {
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $senha = '';

    // Adiciona pelo menos uma letra maiúscula
    $senha .= $caracteres[rand(26, 51)];

    // Adiciona pelo menos uma letra minúscula
    $senha .= $caracteres[rand(0, 25)];

    // Adiciona pelo menos um número à senha
    $senha .= $caracteres[rand(52, 61)];

    // Gera o restante da senha
    for ($i = 0; $i < 5; $i++) {
        $senha .= $caracteres[rand(0, 61)];
    }

    // Embaralha os caracteres para tornar a senha mais aleatória
    $senha = str_shuffle($senha);

    return $senha;
}

// Verifica se o formulário foi enviado e obtém o nome do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];

    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    // Gera um login com base no primeiro nome e um número
    $primeiroNome = explode(' ', $nome)[0];
    $login = strtolower($primeiroNome) . $caracteres[rand(0, 61)].$caracteres[rand(0, 61)].$caracteres[rand(0, 61)] . rand(100, 999);

    // Gera um email com um número variável de caracteres (entre 5 e 12)
    $numCaracteresEmail = rand(10, 12);
    $email = substr(strtolower(str_replace(' ', '', $nome)), 0, $numCaracteresEmail) . rand(10, 99) . '@outlook.com';  

    // Gera uma senha aleatória com pelo menos 1 número, 1 letra maiúscula e 1 letra minúscula
    $senha = gerarSenha();
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" required>
    <br><br>
    <label for="email">Email:</label>
    <input type="text" name="email" value="<?php echo isset($email) ? $email : ''; ?>" readonly>
    <button type="button" onclick="copiarParaAreaDeTransferencia('<?php echo isset($email) ? $email : ''; ?>')">Copiar Email</button>
    <br><br>
    <label for="senha">Senha:</label>
    <input type="text" name="senha" value="<?php echo isset($senha) ? $senha : ''; ?>" readonly>
    <button type="button" onclick="copiarParaAreaDeTransferencia('<?php echo isset($senha) ? $senha : ''; ?>')">Copiar Senha</button>
    <br><br>
    <br><br>
    <label for="login">Login:</label>
    <input type="text" name="login" value="<?php echo isset($login) ? $login : ''; ?>" readonly>
    <button type="button" onclick="copiarParaAreaDeTransferencia('<?php echo isset($login) ? $login : ''; ?>')">Copiar Usuario</button>
    <br><br>
    <input type="submit" value="Gerar Email, Senha e Login">
</form>

<!-- Script JavaScript do Botão de copiar -->
<script>
    function copiarParaAreaDeTransferencia(texto) {
        var campoTemporario = document.createElement("textarea");
        document.body.appendChild(campoTemporario);
        campoTemporario.value = texto;
        campoTemporario.select();
        document.execCommand("copy");
        document.body.removeChild(campoTemporario);
    }
</script>

</body>
</html>
