<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

if (!isset($_GET['id']) || !isset($_GET['id_grupo'])) {
    header('Location: ../index.php');
    exit;
}

$id_grupo = $_GET['id_grupo'];
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM musicas WHERE id = ?");
$stmt->execute([$id]);
$musica = $stmt->fetch(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Música</title>
<link rel="stylesheet" href="../assets/css/pg_criar.css">
</head>
<body class="form-page">

<main class="form-container">
    <h1 class="form-title">Editar Música</h1>

    <form action="processar_update_musica.php" method="POST" enctype="multipart/form-data" class="grupo-form">
        <input type="hidden" name="id" value="<?= $musica->id; ?>">
        <input type="hidden" name="id_grupo" value="<?= $id_grupo; ?>">

        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($musica->titulo) ?>" required>
        </div>

        <div class="form-group">
            <label for="letra">Letra</label>
            <textarea id="letra" name="letra" required><?= htmlspecialchars($musica->letra) ?></textarea>
        </div>

        <div class="form-group">
            <label for="capa">Capa</label>
            <label for="capa" class="upload-box">
                <span class="upload-icon">☁</span>
                <strong>Clique para enviar</strong>
                <small>uma imagem</small>
            </label>
            <input type="file" id="capa" name="capa" accept="image/*" class="input-file">
        </div>

        <div class="form-group descricao-group">
            <label for="link_ouvir">Link para ouvir</label>
            <input type="text" id="link_ouvir" name="link_ouvir" value="<?= htmlspecialchars($musica->link_ouvir) ?>">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-salvar">Salvar Alterações</button>
        </div>

    </form>
</main>
</body>
</html>