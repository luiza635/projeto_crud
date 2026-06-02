<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

if (!isset($_POST['id']) || !isset($_POST['id_grupo'])) {
    header('Location: ../index.php');
    exit;
}

$id = (int) $_POST['id'];
$id_grupo = (int) $_POST['id_grupo'];
$titulo = trim($_POST['titulo'] ?? '');
$letra = trim($_POST['letra'] ?? '');
$link_ouvir = trim($_POST['link_ouvir'] ?? '');

// Upload da capa, se enviado
$capaSalva = null;
if (!empty($_FILES['capa']['name']) && $_FILES['capa']['error'] === 0) {
    $arquivo = $_FILES['capa'];
    $ext = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    $nomeArquivo = uniqid('capa_') . '.' . $ext;
    $pastaUploads = '../uploads/musicas/';
    
    if (!is_dir($pastaUploads)) {
        mkdir($pastaUploads, 0755, true);
    }

    if (move_uploaded_file($arquivo['tmp_name'], $pastaUploads . $nomeArquivo)) {
        $capaSalva = 'uploads/musicas/' . $nomeArquivo;
    }
}

// Atualiza música no banco
if ($capaSalva) {
    $stmt = $pdo->prepare("UPDATE musicas SET titulo = ?, letra = ?, link_ouvir = ?, capa = ? WHERE id = ?");
    $stmt->execute([$titulo, $letra, $link_ouvir, $capaSalva, $id]);
} else {
    $stmt = $pdo->prepare("UPDATE musicas SET titulo = ?, letra = ?, link_ouvir = ? WHERE id = ?");
    $stmt->execute([$titulo, $letra, $link_ouvir, $id]);
}

header('Location: ../grupo.php?id_grupo=' . $id_grupo);
exit;