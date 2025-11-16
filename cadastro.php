<?php
<<<<<<< HEAD
include("conexao/conexao.php");

// Se o formulário foi enviado
if ($_POST) {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Verifica se o e-mail já existe
    $emailCheck = $conn->query("SELECT * FROM clientes WHERE email = '$email'");
    if ($emailCheck->num_rows > 0) {
        echo "<script>alert('Este e-mail já está cadastrado.'); history.back();</script>";
        exit;
    }

    // Data atual para o campo data_cadastro
    $data_cadastro = date('Y-m-d');

    // Inserção no banco
    $sql = "
        INSERT INTO clientes (nome, email, telefone, data_cadastro)
        VALUES ('$nome', '$email', '$telefone', '$data_cadastro')
    ";

    if ($conn->query($sql)) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar!'); history.back();</script>";
    }

}
?>

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Casa do Lampião</title>

    <!-- Usa o MESMO CSS do login -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!-- Botão Voltar -->
    <a class="voltar" href="../html/index_cli.html">Voltar</a>

    <!-- Título acima da caixa -->
    <h1 class="login-title">Crie sua conta</h1>

    <main>
        <section class="login-wrapper">

            <h2>Cadastro</h2>

            <form action="cadastro.php" method="post">

                <!-- Nome completo -->
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" placeholder="Seu nome completo" required>
                </div>

                <!-- CPF -->
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" maxlength="14" required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="Seu e-mail" required>
                </div>

                <!-- Telefone -->
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" placeholder="(00) 00000-0000" maxlength="15" required>
                </div>

                <!-- Senha -->
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
=======
 include ("../conexao/conexao.php");
 ?>
>>>>>>> 163b43a62927d2f0576948f0d1a299e2da8fde71
