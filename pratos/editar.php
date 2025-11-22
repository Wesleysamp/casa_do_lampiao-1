<?php
include ("../conexao/conexao.php");

$id = $_GET['id'];

// Busca os dados atuais do prato
$sql_busca = "SELECT * FROM pratos WHERE id=$id";
$result_busca = $conn->query($sql_busca);
$prato = $result_busca->fetch_assoc();

// Busca categorias para o select
$categorias = $conn->query("SELECT * FROM categorias");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];
    
    // Lógica de Upload
    $nome_final_imagem = $_POST['imagem_atual'];

    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        $arquivo = $_FILES['arquivo'];
        $pasta_destino = "../img/";
        $nome_arquivo = $arquivo['name'];
        
        // Move o arquivo e atualiza a variável
        if (move_uploaded_file($arquivo['tmp_name'], $pasta_destino . $nome_arquivo)) {
            $nome_final_imagem = $nome_arquivo;
        }
    }

    // Update no Banco
    $sql = "UPDATE pratos SET 
            nome='$nome', 
            descricao='$descricao', 
            preco='$preco', 
            imagem='$nome_final_imagem', 
            categoria_id='$categoria_id' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Erro ao atualizar: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Prato | Casa do Lampião</title>
    <link rel="stylesheet" href="../css/editar.css">
    
</head>
<body>

<div class="form-container">
    <h2>✏️ Editar Prato</h2>
    
    <form method="POST" enctype="multipart/form-data">
        
        <label for="nome">Nome do Prato</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($prato['nome']) ?>" required>

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" required><?= htmlspecialchars($prato['descricao']) ?></textarea>

        <div style="display: flex; gap: 15px;">
            <div style="flex: 1;">
                <label for="preco">Preço (R$)</label>
                <input type="number" step="0.01" id="preco" name="preco" value="<?= $prato['preco'] ?>" required>
            </div>
            <div style="flex: 1;">
                <label for="categoria">Categoria</label>
                <select id="categoria" name="categoria_id">
                    <?php while ($cat = $categorias->fetch_assoc()) { ?>
                        <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $prato['categoria_id']) ? 'selected' : '' ?>>
                            <?= $cat['nome'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <label>Imagem do Prato</label>
        <div class="file-input-wrapper">
            <input type="file" name="arquivo" accept="image/*">
            <small style="color: #888; display: block; margin-top: 5px;">Clique para alterar a foto (opcional)</small>
        </div>
        
        <input type="hidden" name="imagem_atual" value="<?= $prato['imagem'] ?>">

        <?php if(!empty($prato['imagem'])): ?>
            <div class="preview-container">
                <small style="display:block; margin-bottom:5px; color:#666">Imagem Atual:</small>
                <?php 
                    // Verifica se é link externo ou arquivo local
                    $imgSrc = (strpos($prato['imagem'], 'http') === 0) ? $prato['imagem'] : "../img/" . $prato['imagem'];
                ?>
                <img src="<?= $imgSrc ?>" class="img-preview" alt="Imagem atual">
            </div>
        <?php endif; ?>

        <div class="btn-group">
            <a href="index.php" class="btn-form btn-cancel">
                 Cancelar
            </a>

            <button type="submit" class="btn-form btn-save">
                 Salvar Alterações
            </button>
        </div>

    </form>
</div>
    </form>
</div>

</body>
</html>