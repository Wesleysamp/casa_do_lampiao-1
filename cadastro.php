<?php
include("conexao/conexao.php");

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];

    // 1. Pega a senha e Criptografa (SHA-256)
    $senha_digitada = $_POST['senha'];
    $senha_hash = hash('sha256', $senha_digitada);

    // Verifica se o e-mail já existe
    $emailCheck = $conn->query("SELECT * FROM clientes WHERE email = '$email'");
    if ($emailCheck->num_rows > 0) {
        echo "<script>alert('Este e-mail já está cadastrado.'); history.back();</script>";
        exit;
    }

    // Data atual
    $data_cadastro = date('Y-m-d');

    // 2. Insere no banco COM A SENHA E CPF
    $sql = "INSERT INTO clientes (nome, email, telefone, cpf, data_cadastro, senha)
            VALUES ('$nome', '$email', '$telefone', '$cpf', '$data_cadastro', '$senha_hash')";

    if ($conn->query($sql)) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar: " . $conn->error . "'); history.back();</script>";
    }
}
?>

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Casa do Lampião</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <a class="voltar" href="index.html">Voltar</a>
    <h1 class="login-title">Crie sua conta</h1>

    <main>
        <section class="login-wrapper">
            <h2>Cadastro</h2>
            <form action="cadastro.php" method="post">

                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" placeholder="Seu nome completo" required>
                </div>

                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" maxlength="14" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="Seu e-mail" required>
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" placeholder="(00) 00000-0000" maxlength="15" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Crie uma senha" required>
                </div>

                <div class="actions">
                    <button type="submit" class="primary">Cadastrar</button>
                </div>

            </form>
        </section>
    </main>

</body>
</html>