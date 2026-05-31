<?php 
include_once "../config/database.php";
include_once "../includes/auth.php";

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $letra = trim($_POST['letra'] ?? '');
    $link_ouvir = trim($_POST['link_ouvir'] ?? '');
    $capa = $_FILES['capa'] ?? null;

    if ($titulo && $letra) {
        // Upload da capa (opcional)
        $capa_nome = null;
        if ($capa && $capa['error'] === 0) {
            $ext = pathinfo($capa['name'], PATHINFO_EXTENSION);
            $capa_nome = uniqid('capa_') . '.' . $ext;
            move_uploaded_file($capa['tmp_name'], "../uploads/$capa_nome");
        }

        $sql = "INSERT INTO musicas (titulo, letra, link_ouvir, capa) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titulo, $letra, $link_ouvir, $capa_nome]);

        header("Location: adicionar_musica.php");
        exit();
    } else {
        $erro = "Preencha todos os campos obrigatórios.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Música</title>
    <link rel="stylesheet" href="../assets/css/pg_criar.css?v=6">
</head>

<body class="form-page">

<div class="form-container">
    <h1 class="form-title">Adicionar Música</h1>

    <?php if (!empty($erro)): ?>
        <div class="form-error"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form action="adicionar_musica.php" method="POST" enctype="multipart/form-data" class="grupo-form">

        <div class="form-group">
            <label for="titulo">Título</label>
            <input 
                type="text" 
                id="titulo" 
                name="titulo" 
                placeholder="Ex.: Dynamite" 
                required
            >
        </div>

        <div class="form-group">
            <label for="letra">Letra</label>
            <textarea 
                id="letra" 
                name="letra" 
                placeholder="Cole a letra da música aqui..." 
                required
            ></textarea>
        </div>

        <div class="form-group">
            <label for="capa">Capa da Música</label>
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
            <input 
                type="text" 
                id="link_ouvir" 
                name="link_ouvir" 
                placeholder="Ex.: https://open.spotify.com/track/..."
            >
        </div>

        <div class="form-actions">
            <a href="../index.php" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-save">Adicionar Música</button>
        </div>

    </form>
</div>

</body>
</html>