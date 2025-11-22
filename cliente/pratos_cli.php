<?php
include "../conexao/conexao.php";

// Sua tabela já tem a coluna imagem, então o SQL é simples:
$sql = "SELECT p.id, p.nome, p.descricao, p.preco, p.imagem, cat.nome AS categoria 
        FROM pratos p
        JOIN categorias cat ON p.categoria_id = cat.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa do Lampião - Pratos</title>
    <link rel="stylesheet" href="../css/styles.css">

    <style>
        /* CSS DO MODAL */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); }
        .modal-content { background-color: #fff; margin: 5% auto; padding: 0; border: 1px solid #888; width: 90%; max-width: 500px; position: relative; }
        .close-btn { color: #aaa; float: right; font-size: 28px; font-weight: bold; position: absolute; right: 10px; top: 5px; cursor: pointer; z-index: 10; background: rgba(255,255,255,0.8); padding: 0 5px; border-radius: 5px; }
        .modal-img { width: 100%; height: 300px; object-fit: cover; display: block; border-bottom: 1px solid #ccc; }
        .modal-text { padding: 20px; }
    </style>
</head>

<body>
    <h2>Pratos</h2>
    <a class="voltar" href="../html/index.html">Voltar</a> 

    <table border="1" cellpadding="10">
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Categoria</th>
            <th>Ações</th>
        </tr>

        <?php 
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()): 
                
                $nomeJS = addslashes($row['nome']);
                $descJS = addslashes(str_replace(["\r", "\n"], " ", $row['descricao']));
                $precoJS = number_format($row['preco'], 2, ',', '.');
                
                // AQUI ESTÁ A MÁGICA:
                // O banco traz 'baiao.jpg'. O código adiciona '../img/' na frente.
                // Se o campo estiver vazio, usa uma imagem cinza padrão.
                $nomeArquivo = $row['imagem'];
                if (!empty($nomeArquivo)) {
                    $caminhoImagem = "../img/" . $nomeArquivo;
                } else {
                    $caminhoImagem = "https://via.placeholder.com/500x300?text=Sem+Foto";
                }
        ?>
        <tr>
            <td><?= htmlspecialchars($row['nome']) ?></td>
            <td><?= htmlspecialchars($row['descricao']) ?></td>
            <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
            <td><?= htmlspecialchars($row['categoria']) ?></td>
            <td>
                <a href="javascript:void(0)" 
                   onclick="openModal('<?= $nomeJS ?>', '<?= $descJS ?>', 'R$ <?= $precoJS ?>', '<?= $caminhoImagem ?>')">
                   Ver mais
                </a>
            </td>
        </tr>
        <?php 
            endwhile; 
        } else {
            echo "<tr><td colspan='5' style='text-align: center;'>Nenhum prato encontrado.</td></tr>";
        }
        ?>
    </table>

    <div id="pratoModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <img id="modalImg" src="" alt="Imagem do Prato" class="modal-img">
            <div class="modal-text">
                <h2 id="modalTitle" style="margin-top: 0;">Nome</h2>
                <p id="modalPrice" style="color: green; font-weight: bold;">R$ 00,00</p>
                <p><strong>Descrição:</strong></p>
                <p id="modalDesc">Descrição aqui...</p>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById("pratoModal");
        function openModal(nome, descricao, preco, imagem) {
            document.getElementById("modalTitle").innerText = nome;
            document.getElementById("modalDesc").innerText = descricao;
            document.getElementById("modalPrice").innerText = preco;
            document.getElementById("modalImg").src = imagem; // Carrega o caminho ../img/foto.jpg
            modal.style.display = "block";
        }
        function closeModal() { modal.style.display = "none"; }
        window.onclick = function(event) { if (event.target == modal) closeModal(); }
    </script>
</body>
</html>