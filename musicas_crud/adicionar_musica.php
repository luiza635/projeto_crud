<?php 
include_once "../config/database.php";
include_once "../includes/auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $letra = $_POST['letra'];
    $link_ouvir = $_POST['link_ouvir'];
    $capa = $_FILES['capa'];

    // Aqui você pode adicionar a lógica para lidar com o upload da imagem, se necessário.

    $sql = "INSERT INTO musicas (titulo, letra, link_ouvir, capa) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titulo, $letra, $link_ouvir, $capa]);

    header("Location: adicionar_musica.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Música</title>
    <link rel="stylesheet" href="../\assets/css/pg_criar.css">
</head>

<body class="form-page">

    <main class="form-card">

        <div class="form-top">
            <a href="../index.php" class="btn-voltar">←</a>

            <h1 class="form-title">Adicionar Música</h1>

            <span class="heart-icon">♡</span>
        </div>

        <form action="processar_update_musica.php" method="POST" enctype="multipart/form-data" class="grupo-form">

            <div class="form-group">
                <label for="titulo">Título</label>

                <input 
                    type="text" 
                    id="titulo" 
                    name="titulo" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="letra">Letra</label>

                <input 
                    type="text" 
                    id="letra" 
                    name="letra" 
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
                <input type="text" name="link_ouvir" id="link_ouvir">
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn-cancelar">Cancelar</a>

                <button type="submit" class="btn-salvar">
                    Adicionar Música
                </button>
            </div>

        </form>

        <span class="sparkle">✦</span>
    </main>
</body>
</html>