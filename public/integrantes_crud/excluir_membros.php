<?php
require_once '../../src/includes/auth.php';
require_once '../../src/config/database.php';


if (!isset($_GET['id']) || !isset($_GET['id_grupo'])) {
    header("Location: ../index.php");
    exit;
}

$id_membro = (int) $_GET['id'];
$id_grupo = (int) $_GET['id_grupo'];


if ($id_membro <= 0 || $id_grupo <= 0) {
    header("Location: ../index.php");
    exit;
}

$sql = "DELETE FROM integrantes WHERE id = ? AND grupo_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_membro, $id_grupo]);

header("Location: ../crud_grupos/grupo.php?id_grupo=" . $id_grupo);
exit;
?>