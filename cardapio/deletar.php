<?php
include ("../conexao/conexao.php");
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);  // Converte para inteiro
    
    $sql = "DELETE FROM cardapio WHERE id = ?";  // Prepared statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $id);  // "i" para inteiro
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            header("Location: index.php");
            exit();
        } else {
            echo "Nenhum registro excluído.";
        }
        
        $stmt->close();
    } else {
        echo "Erro na query.";
    }
    
    $conn->close();
} else {
    echo "ID inválido ou não fornecido.";
}
?>