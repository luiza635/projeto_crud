<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
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
    <title>Atualizar Música</title>
    <link rel="stylesheet" href="../\assets/css/pg_criar.css">
</head>

<body class="form-page">

    <main class="form-card">

        <div class="form-top">
            <a href="../index.php" class="btn-voltar">←</a>

            <h1 class="form-title">Atualizar informações da Música</h1>

            <span class="heart-icon">♡</span>
        </div>

        <form action="processar_update_musica.php" method="POST" enctype="multipart/form-data" class="grupo-form">
            <input type="hidden" name="id" value="<?= $musica->id; ?>">
            <input type="hidden" name="id_grupo" value="<?= $id_grupo; ?>">

            <div class="form-group">
                <label for="titulo">Título</label>

                <input 
                    type="text" 
                    id="titulo" 
                    name="titulo" 
                    value="<?= $musica->titulo ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="letra">Letra</label>

                <input 
                    type="text" 
                    id="letra" 
                    name="letra" 
                    value="<?= $musica->letra; ?>"
                    required
                >
            </div>


            <div class="form-group">
                <label for="capa">Capa</label>

                <label for="capa" class="upload-box">
                    <span class="upload-icon">☁</span>
                    <strong>Clique para enviar</strong>
                    <small>uma imagem</small>
                </label>

                <input 
                    type="file" 
                    id="capa" 
                    name="capa" 
                    accept="image/*" 
                    class="input-file"
                >
            </div>

            <div class="form-group descricao-group">
                <label for="link_ouvir">Link para ouvir</label>
                <input type="text" name="link_ouvir" id="link_ouvir" value="<?= $musica->link_ouvir; ?>">
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn-cancelar">Cancelar</a>

                <button type="submit" class="btn-salvar">
                    Fazer alterações
                </button>
            </div>

        </form>

        <span class="sparkle">✦</span>
    </main>
</body>
</html>