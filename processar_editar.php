<?php
include_once 'config/database.php';
include_once "includes/auth.php";

$id_grupo = $_POST['id_grupo'];
$nome = $_POST['nome'];
$tipo_grupo = $_POST['tipo'];
$debut = $_POST['debut'];
$empresa = $_POST['empresa'];
$membros = $_POST['membros'];

$stmt = $pdo->prepare("UPDATE grupos SET nome = ?, tipo_grupo = ?, debut = ?, numero_membros = ?, descricao = ? WHERE id = ?");
$stmt->execute([$nome, $tipo_grupo, $debut, $membros, $descricao, $id_grupo]);

header("Location: index.php");
exit();