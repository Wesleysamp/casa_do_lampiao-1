<?php
    include ("conexao/conexao.php");

<<<<<<< HEAD

=======
>>>>>>> 132f769e5da0ba0736ab7d50432edb4c7d8a96e3
 // Inicia a verificação do login
 if($_POST){

    // 🔹 Nova lógica: o campo "login" será tratado como "email",
    //    porque na tabela usuarios_admin não existe campo login.
    $email = $_POST['login'];

    // 🔹 Senha continua usando MD5 conforme solicitado.
    $senha = md5($_POST['senha']);

    // 🔹 Consulta adaptada: tabela correta = usuarios_admin
    //    Campos corretos = email e senha
    $loginRes = $conn->query("
        SELECT * FROM usuarios_admin 
        WHERE email = '$email' AND senha = '$senha'
    ");

    $rowLogin = $loginRes->fetch_assoc();
    $numRow = $loginRes->num_rows;

    // Se sessão não existir, inicia uma nova
    if(!isset($_SESSION)) {
        $sessaoAntiga = session_name('chulettaaa');
        session_start();
        $session_name_new = session_name();
    }

    if($numRow > 0){

        // 🔹 Agora salvamos no session os nomes corretos:
        $_SESSION['login_usuario'] = $email;
        $_SESSION['nome_usuario'] = $rowLogin['nome'];
        $_SESSION['nome_da_sessao'] = session_name();

        // 🔹 Antes existia "nivel", agora não existe mais.
        //    Como só existe admin, redireciona direto:
        echo "<script>window.open('index.php','_self')</script>";
    }
    else {
        // 🔹 Corrigido erro: "invasor .php" tinha um espaço.
        echo "<script>window.open('invasor.php','_self')</script>";
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
    <a class="voltar" href="index.html">Voltar</a>

    <!-- Título acima da caixa -->
    <h1 class="login-title">Adicione suas informações</h1>

    <main>
        <section class="login-wrapper">
            <h2>Entrar</h2>

            <form action="login.php" method="post">

                <div class="form-group">
                    <label for="login">E-mail</label>
                    <input type="email" id="login" name="login" placeholder="Digite seu e-mail" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>

                <div class="actions">
                    <button type="submit" class="primary">Entrar</button>
                </div>

            </form>
        </section>
    </main>

</body>
</html>

