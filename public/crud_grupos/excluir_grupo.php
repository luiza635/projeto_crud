<?php 
require_once '../../src/config/database.php';

if (!isset($_GET['id_grupo'])) {
    header("Location: index.php");
    exit();
}

$id_grupo = $_GET['id_grupo'];

$sql = "DELETE FROM grupos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_grupo]);
header("Location: index.php");
exit();
