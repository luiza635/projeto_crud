<?php
require_once '../../src/includes/auth.php';
require_once '../../src/config/database.php';

/* Verifica se recebeu o id da música e o id do grupo */
if (!isset($_GET['id']) || !isset($_GET['id_grupo'])) {
    header("Location: ../index.php");
    exit;
}

$id_musica = (int) $_GET['id'];
$id_grupo = (int) $_GET['id_grupo'];

/* Se algum id estiver errado, volta para a página inicial */
if ($id_musica <= 0 || $id_grupo <= 0) {
    header("Location: ../index.php");
    exit;
}

/* Exclui a música somente se ela pertencer ao grupo correto */
$sql = "DELETE FROM musicas WHERE id = ? AND grupo_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_musica, $id_grupo]);

/* Volta para os detalhes do grupo */
header("Location: ../crud_grupos/grupo.php?id_grupo=" . $id_grupo);
exit;
?>