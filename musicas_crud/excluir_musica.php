<?php 
require_once '../config/database.php';
require_once '../includes/auth.php';

if (!isset($_GET['id']) || !isset($_GET['id_grupo'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_GET['id'];
$id_grupo = $_GET['id_grupo'];

// Exclui música do banco
$stmt = $pdo->prepare("DELETE FROM musicas WHERE id = ?");
$stmt->execute([$id]);

header('Location: ../grupo.php?id_grupo=' . $id_grupo);
exit;
?>