<?php 
require_once '../config/database.php';
require_once '../includes/auth.php';

if (!isset($_POST['id']) || !isset($_POST['id_grupo'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_POST['id'];
$id_grupo = $_POST['id_grupo'];
$titulo = trim($_POST['titulo']);
$letra = trim($_POST['letra']);
$link_ouvir = trim($_POST['link_ouvir']);

// Upload da capa, se enviado
$capa_nome = null;
if (isset($_FILES['capa']) && $_FILES['capa']['error'] === 0) {
    $ext = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);
    $capa_nome = uniqid('capa_') . '.' . $ext;
    move_uploaded_file($_FILES['capa']['tmp_name'], "../uploads/$capa_nome");
}

// Atualiza música no banco
if ($capa_nome) {
    $stmt = $pdo->prepare("UPDATE musicas SET titulo = ?, letra = ?, link_ouvir = ?, capa = ? WHERE id = ?");
    $stmt->execute([$titulo, $letra, $link_ouvir, $capa_nome, $id]);
} else {
    $stmt = $pdo->prepare("UPDATE musicas SET titulo = ?, letra = ?, link_ouvir = ? WHERE id = ?");
    $stmt->execute([$titulo, $letra, $link_ouvir, $id]);
}

header('Location: ../grupo.php?id_grupo=' . $id_grupo);
exit;
?>