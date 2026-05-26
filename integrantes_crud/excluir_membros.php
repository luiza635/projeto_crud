<?php 
require_once '../config/database.php';
require_once '../includes/auth.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM integrantes WHERE id = ?");
$stmt->execute([$id]);
header('Location: grupo.php?id_grupo=' . $_GET['id_grupo']);
exit;
