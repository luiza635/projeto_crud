<?php
include_once 'config/database.php';
include_once "includes/auth.php";

$id_grupo = $_POST['id_grupo'];
$nome = $_POST['nome'];
$tipo_grupo = $_POST['tipo'];
$debut = $_POST['debut'];
$empresa = $_POST['empresa'];
$membros = $_POST['membros'];
$descricao = $_POST["descricao"];

$imagemSalva = null;
if (!empty($_FILES['imagem']['name']) && $_FILES['imagem']['error'] === 0) {
    $arquivo = $_FILES['imagem'];
    $ext = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    $nomeArquivo = uniqid('capa_') . '.' . $ext;
    $pastaUploads = '../uploads/grupos/';
    
    if (!is_dir($pastaUploads)) {
        mkdir($pastaUploads, 0755, true);
    }

    if (move_uploaded_file($arquivo['tmp_name'], $pastaUploads . $nomeArquivo)) {
        $imagemSalva = 'uploads/grupos/' . $nomeArquivo;
    }
}

$stmt = $pdo->prepare("UPDATE grupos SET nome = ?, tipo_grupo = ?, debut = ?, numero_membros = ?, descricao = ?, imagem = ? WHERE id = ?");
$stmt->execute([$nome, $tipo_grupo, $debut, $membros, $descricao, $imagemSalva, $id_grupo]);

header("Location: index.php");
exit();