<?php 
include_once "../../src/config/database.php";
include_once "../../src/includes/auth.php";

$erro = '';
$id_grupo = filter_input(INPUT_GET, 'id_grupo', FILTER_VALIDATE_INT);

if (!$id_grupo) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $letra = trim($_POST['letra'] ?? '');
    $link_ouvir = trim($_POST['link_ouvir'] ?? '');
    $capa = $_FILES['capa'] ?? null;

    if ($titulo && $letra) {
        $capaSalva = null;
        if ($capa && $capa['error'] === 0) {
            $ext = pathinfo($capa['name'], PATHINFO_EXTENSION);
            $nomeArquivo = uniqid('capa_') . '.' . $ext;
            $pastaUploads = '../uploads/musicas/';
            
            if (!is_dir($pastaUploads)) {
                mkdir($pastaUploads, 0755, true);
            }

            if (move_uploaded_file($capa['tmp_name'], $pastaUploads . $nomeArquivo)) {
                $capaSalva = 'uploads/musicas/' . $nomeArquivo;
            }
        }

        $sql = "INSERT INTO musicas (titulo, letra, link_ouvir, capa, grupo_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titulo, $letra, $link_ouvir, $capaSalva, $id_grupo]);

        header("Location: ../crud_grupos/grupo.php?id_grupo=$id_grupo");
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

    <form action="adicionar_musica.php?id_grupo=<?= $id_grupo ?>" method="POST" enctype="multipart/form-data" class="grupo-form">

        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" placeholder="Ex.: Dynamite" required>
        </div>

        <div class="form-group">
            <label for="letra">Letra</label>
            <textarea id="letra" name="letra" placeholder="Cole a letra da música aqui..." required></textarea>
        </div>

        <div class="form-group">
            <label for="capa">Capa da Música</label>
            <label for="capa" class="upload-box">
                <span class="upload-icon">☁</span>
                <strong>Clique para enviar</strong>
                <small>uma imagem</small>
            </label>
            <input type="file" id="capa" name="capa" accept="image/*" class="input-file">
        </div>

        <div class="form-group descricao-group">
            <label for="link_ouvir">Link para ouvir</label>
            <input type="text" id="link_ouvir" name="link_ouvir" placeholder="Ex.: https://open.spotify.com/track/...">
        </div>

       <div class="form-actions">
    <a href="../crud_grupos/grupo.php?id_grupo=<?= htmlspecialchars($id_grupo) ?>" class="btn-cancel">
        Cancelar
    </a>

    <button type="submit" class="btn-save">
        Salvar Música
    </button>
</div>
                    

    </form>
</div>
</body>
</html>