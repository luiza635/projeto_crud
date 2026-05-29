<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id_grupo = $_GET['id_grupo'];

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM integrantes WHERE id = ?");
$stmt->execute([$id]);
$membro = $stmt->fetch(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Integrante</title>
    <link rel="stylesheet" href="../\assets/css/pg_criar.css">
</head>

<body class="form-page">

    <main class="form-card">

        <div class="form-top">
            <a href="index.php" class="btn-voltar">←</a>

            <h1 class="form-title">Atualizar informações do Integrante</h1>

            <span class="heart-icon">♡</span>
        </div>

        <form action="processar_update_membros.php" method="POST" enctype="multipart/form-data" class="grupo-form">
            <input type="hidden" name="id" value="<?= $membro->id; ?>">
            <input type="hidden" name="id_grupo" value="<?= $id_grupo; ?>">

            <div class="form-group">
                <label for="nome_real">Nome real do Integrante</label>

                <input 
                    type="text" 
                    id="nome_real" 
                    name="nome_real" 
                    value="<?= $membro->nome_real ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="nome_artistico">Nome artistico do Integrante</label>

                <input 
                    type="text" 
                    id="nome_artistico" 
                    name="nome_artistico" 
                    value="<?= $membro->nome_artistico; ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="funcao">Tipo</label>

                <select id="funcao" name="funcao" required>
                    <option value="" disabled selected>Selecione a função</option>
                    <option value="vocalista" <?= $membro->funcao === 'vocalista' ? 'selected' : '' ?>>Vocalista</option>
                    <option value="dançarino" <?= $membro->funcao === 'dançarino' ? 'selected' : '' ?>>Dançarino</option>
                    <option value="compositor" <?= $membro->funcao === 'compositor' ? 'selected' : '' ?>>Compositor</option>
                    <option value="rapper" <?= $membro->funcao === 'rapper' ? 'selected' : '' ?>>Rapper</option>
                    <option value="líder" <?= $membro->funcao === 'líder' ? 'selected' : '' ?>>Líder</option>
                </select>
            </div>

            <div class="form-group">
                <label for="aniversario">Aniversário</label>

                <input 
                    type="date" 
                    id="aniversario" 
                    name="aniversario" 
                    value="<?= $membro->aniversario; ?>"
                    placeholder="Ex.: 2020" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="foto">Foto</label>

                <label for="foto" class="upload-box">
                    <span class="upload-icon">☁</span>
                    <strong>Clique para enviar</strong>
                    <small>uma imagem</small>
                </label>

                <input 
                    type="file" 
                    id="foto" 
                    name="foto" 
                    accept="image/*" 
                    class="input-file"
                >
            </div>

            <div class="form-group descricao-group">
                <label for="biografia">Biografia</label>

                <textarea 
                    id="biografia" 
                    name="biografia" 
                    placeholder="Fale sobre o integrante..."
                    required
                ><?= $membro->biografia; ?></textarea>
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