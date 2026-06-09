<?php
require_once '../../src/config/database.php';
require_once '../../src/includes/auth.php';

if (!isset($_GET['id']) || !isset($_GET['id_grupo'])) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'];
$id_grupo = $_GET['id_grupo'];

$stmt = $pdo->prepare("SELECT * FROM musicas WHERE id = ?");
$stmt->execute([$id]);
$musica = $stmt->fetch(PDO::FETCH_OBJ);

if (!$musica) {
    header("Location: ../crud_grupos/grupo.php?id_grupo=" . urlencode($id_grupo));
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Música</title>
    <link rel="stylesheet" href="../assets/css/pg_criar.css?v=10">
</head>

<body class="form-page">

    <div class="form-container">

        <h1 class="form-title">Editar Música</h1>

        <form action="processar_update_musica.php" method="POST" enctype="multipart/form-data" class="grupo-form">

            <input type="hidden" name="id" value="<?= htmlspecialchars($musica->id) ?>">
            <input type="hidden" name="id_grupo" value="<?= htmlspecialchars($id_grupo) ?>">

            <div class="form-group">
                <label for="titulo">Título da música:</label>
                <input 
                    type="text" 
                    id="titulo" 
                    name="titulo" 
                    value="<?= htmlspecialchars($musica->titulo) ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="letra">Letra:</label>
                <textarea 
                    id="letra" 
                    name="letra" 
                    placeholder="Escreva a letra da música..."
                ><?= htmlspecialchars($musica->letra) ?></textarea>
            </div>

            <div class="form-group">
                <label for="capa">Capa da música:</label>

                <label for="capa" class="upload-box">
                    <span class="upload-icon">☁</span>
                    <span class="upload-title">Clique para enviar</span>
                    <span class="upload-subtitle">uma nova capa da música</span>
                </label>

                <input 
                    type="file" 
                    id="capa" 
                    name="capa" 
                    class="input-file" 
                    accept="image/*"
                >

                <?php if (!empty($musica->capa)): ?>
                    <small class="form-hint">Capa atual cadastrada. Envie outra apenas se quiser trocar.</small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="link_ouvir">Link para ouvir:</label>
                <input 
                    type="url" 
                    id="link_ouvir" 
                    name="link_ouvir" 
                    value="<?= htmlspecialchars($musica->link_ouvir) ?>" 
                    placeholder="https://..."
                >
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