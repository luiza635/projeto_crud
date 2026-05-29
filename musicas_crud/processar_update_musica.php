<?php 
require_once '../config/database.php';
require_once '../includes/auth.php';

if (!isset($_POST['id'])) {
    header('Location: index.php');
    exit;
}

$id_grupo = $_POST['id_grupo'];

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$letra = $_POST['letra'];
$link_ouvir = $_POST['link_ouvir'];
$capa = $_POST['capa'];

$stmt = $pdo->prepare("UPDATE musicas SET titulo = ?, letra = ?, link_ouvir = ?, capa = ? WHERE id = ?");
$stmt->execute([$titulo, $letra, $link_ouvir, $capa, $id]);

header('Location: grupo.php?id_grupo=' . $id_grupo);
exit;