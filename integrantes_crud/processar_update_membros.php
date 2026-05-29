<?php 
require_once '../config/database.php';
require_once '../includes/auth.php';

if (!isset($_POST['id'])) {
    header('Location: index.php');
    exit;
}

$id_grupo = $_POST['id_grupo'];

$id = $_POST['id'];
$nome = $_POST['nome_real'];
$nome_artistico = $_POST['nome_artistico'];
$funcao = $_POST['funcao'];
$aniversario = $_POST['aniversario'];
$biografia = $_POST['biografia'];

$stmt = $pdo->prepare("UPDATE integrantes SET nome_real = ?, nome_artistico = ?, funcao = ?, aniversario = ?, biografia = ? WHERE id = ?");
$stmt->execute([$nome, $nome_artistico, $funcao, $aniversario, $biografia, $id]);

header('Location: ../grupo.php?id_grupo=' . $id_grupo);
exit;