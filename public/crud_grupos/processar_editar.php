<?php
require_once '../../src/includes/auth.php';
require_once '../../src/config/database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../index.php");
    exit;
}

$id_grupo = $_POST['id_grupo'];
$nome = $_POST['nome'];
$tipo_grupo = $_POST['tipo_grupo'];
$debut = $_POST['debut'];
$empresa = $_POST['empresa'];
$numero_membros = $_POST['numero_membros'];
$descricao = $_POST['descricao'];

/* Buscar a imagem atual do grupo */
$sql = "SELECT imagem FROM grupos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_grupo]);

$grupo = $stmt->fetch(PDO::FETCH_OBJ);

$imagemSalva = $grupo->imagem;

/* Se o usuário mandar uma nova imagem, troca a imagem antiga */
if (!empty($_FILES['imagem']['name'])) {

    $pasta = "../uploads/grupos/";

    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $nomeImagem = time() . "_" . $_FILES['imagem']['name'];
    $caminhoImagem = $pasta . $nomeImagem;

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
        $imagemSalva = "uploads/grupos/" . $nomeImagem;
    }
}

/* Atualizar o grupo */
$sql = "UPDATE grupos 
        SET nome = ?, 
            tipo_grupo = ?, 
            debut = ?, 
            empresa = ?, 
            numero_membros = ?, 
            descricao = ?, 
            imagem = ?
        WHERE id = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $nome,
    $tipo_grupo,
    $debut,
    $empresa,
    $numero_membros,
    $descricao,
    $imagemSalva,
    $id_grupo
]);

header("Location: ../index.php");
exit;