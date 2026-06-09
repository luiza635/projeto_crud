<?php
require_once '../../src/config/database.php';
require_once '../../src/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit;
}

$id = $_POST['id'] ?? '';
$id_grupo = $_POST['id_grupo'] ?? '';

$titulo = trim($_POST['titulo'] ?? '');
$letra = trim($_POST['letra'] ?? '');
$link_ouvir = trim($_POST['link_ouvir'] ?? '');

if (empty($id) || empty($id_grupo) || empty($titulo)) {
    header("Location: ../crud_grupos/grupo.php?id_grupo=" . urlencode($id_grupo));
    exit;
}

/* Busca a capa atual */
$stmt = $pdo->prepare("SELECT capa FROM musicas WHERE id = ?");
$stmt->execute([$id]);
$musica = $stmt->fetch(PDO::FETCH_OBJ);

$capa = $musica ? $musica->capa : '';

/* Se enviar uma nova capa, troca a antiga */
if (!empty($_FILES['capa']['name'])) {

    $pasta = '../uploads/musicas/';

    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $nomeArquivo = time() . '_' . basename($_FILES['capa']['name']);
    $caminhoCompleto = $pasta . $nomeArquivo;

    if (move_uploaded_file($_FILES['capa']['tmp_name'], $caminhoCompleto)) {
        $capa = 'uploads/musicas/' . $nomeArquivo;
    }
}

/* Atualiza a música */
$sql = "UPDATE musicas 
        SET titulo = ?, 
            letra = ?, 
            link_ouvir = ?, 
            capa = ? 
        WHERE id = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $titulo,
    $letra,
    $link_ouvir,
    $capa,
    $id
]);

header("Location: ../crud_grupos/grupo.php?id_grupo=" . urlencode($id_grupo));
exit;