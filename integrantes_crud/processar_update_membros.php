<?php 
require_once '../config/database.php';
require_once '../includes/auth.php';

// Verifica se o ID do membro foi enviado
if (!isset($_POST['id']) || !isset($_POST['id_grupo'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_POST['id'];
$id_grupo = (int) $_POST['id_grupo'];
$nome_real = trim($_POST['nome_real'] ?? '');
$nome_artistico = trim($_POST['nome_artistico'] ?? '');
$funcao = trim($_POST['funcao'] ?? '');
$aniversario = trim($_POST['aniversario'] ?? '');
$biografia = trim($_POST['biografia'] ?? '');

// UPLOAD DE FOTO (opcional)
$fotoSalva = null;
if (!empty($_FILES['foto']['name'])) {
    $arquivo = $_FILES['foto'];
    $nomeArquivo = time() . '_' . basename($arquivo['name']);
    $caminho = '../uploads/membros/' . $nomeArquivo;

    // Cria a pasta se não existir
    if (!is_dir('../uploads/membros/')) {
        mkdir('../uploads/membros/', 0755, true);
    }

    if (move_uploaded_file($arquivo['tmp_name'], $caminho)) {
        $fotoSalva = 'uploads/membros/' . $nomeArquivo;
    }
}

// Atualiza os dados do integrante
if ($fotoSalva) {
    $sql = "UPDATE integrantes 
            SET nome_real = ?, nome_artistico = ?, funcao = ?, aniversario = ?, biografia = ?, foto = ?
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome_real, $nome_artistico, $funcao, $aniversario, $biografia, $fotoSalva, $id]);
} else {
    $sql = "UPDATE integrantes 
            SET nome_real = ?, nome_artistico = ?, funcao = ?, aniversario = ?, biografia = ?
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome_real, $nome_artistico, $funcao, $aniversario, $biografia, $id]);
}

// Redireciona de volta para a página do grupo
header('Location: ../grupo.php?id_grupo=' . $id_grupo);
exit;
?>