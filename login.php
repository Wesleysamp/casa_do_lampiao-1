<?php
session_start();
include("conexao/conexao.php");


 // Inicia a verificação do login
 if($_POST)
$email_admin_master = "admin@casadolampiao.com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $email = $conn->real_escape_string($_POST['email']);
    $senha_digitada = $_POST['senha'];

  
    $senha_hash = hash('sha256', $senha_digitada);

    // Se sessão não existir, inicia uma nova
    if(!isset($_SESSION)) {
        $sessaoAntiga = session_name('lampiao');
        session_start();
        $session_name_new = session_name();
    }

    if ($email === $email_admin_master) {

        // Verifica na tabela de ADMINS
        $sql = "SELECT * FROM usuarios_admin WHERE email = '$email' AND senha = '$senha_hash'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            
            $_SESSION['id'] = $row['id'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['tipo_usuario'] = 'admin';

            
            header("Location: html/index_adm.php");
            exit;
        } else {
            echo "<script>alert('Senha de administrador incorreta!'); window.location='login.php';</script>";
            exit;
        }

    } 

    else {

        // Verifica na tabela de CLIENTES
        $sql = "SELECT * FROM clientes WHERE email = '$email' AND senha = '$senha_hash'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Salva sessão
            $_SESSION['id'] = $row['id'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['tipo_usuario'] = 'cliente';

            // Manda para index_cli
            header("Location: cliente/index_cli.html");
            exit;
        } else {
            echo "<script>alert('E-mail ou senha inválidos!'); window.location='login.php';</script>";
            exit;
        }
    }
}
?>

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Casa do Lampião</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!-- Botão Voltar no topo -->
    <a class="voltar" href="index_inicio.html">Voltar</a>

    <!-- Título acima da caixa -->
    <h1 class="login-title">Adicione suas informações</h1>
    <a class="voltar" href="index_inicio.html">Voltar</a>
    <h1 class="login-title">Acesse sua conta</h1>

    <main>
        <section class="login-wrapper">
            <h2>Entrar</h2>

            <form action="login.php" method="post">

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>

                <div class="actions">
                    <button type="submit" class="primary">Entrar</button>
                </div>

            </form>

            <p style="text-align: center; margin-top: 15px;">
                Não tem conta? <a href="cadastro.php" style="color: #d2691e; font-weight: bold;">Cadastre-se</a>
            </p>
        </section>
    </main>

</body>
</html>