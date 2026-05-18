<?php 
include_once 'config/database.php';
include_once "includes/auth.php";

if (!isset($_GET['id_grupo'])) {
    header("Location: index.php");
    exit();
}

$id_grupo = $_GET['id_grupo'];

$sql = "SELECT * FROM grupos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_grupo]);
$grupo = $stmt->fetch(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/pg_criar.css">
    <title>Editar Grupo</title>
</head>
<body class="form-page">
    <main class="form-card">

        <div class="form-top">
            <a href="index.php" class="btn-voltar">←</a>

            <h1 class="form-title">Editar Grupo</h1>

            <span class="heart-icon">♡</span>
        </div>

        <form action="processar_editar.php" method="POST" enctype="multipart/form-data" class="grupo-form">
            <input type="hidden" name="id_grupo" value="<?= $grupo->id ?>">

            <div class="form-group">
                <label for="nome">Nome do Grupo</label>

                <input 
                    type="text" 
                    id="nome" 
                    name="nome" 
                    placeholder="Ex.: ATEEZ" 
                    required
                    value="<?= htmlspecialchars($grupo->nome) ?>"
                >
            </div>

            <div class="form-group">
                <label for="tipo">Tipo</label>

                <select id="tipo" name="tipo" required>
                    <option value="" disabled selected>Selecione o tipo</option>
                    <option value="Boy Group" <?= $grupo->tipo_grupo === 'Boy Group' ? 'selected' : '' ?>>Boy Group</option>
                    <option value="Girl Group" <?= $grupo->tipo_grupo === 'Girl Group' ? 'selected' : '' ?>>Girl Group</option>
                </select>
            </div>

            <div class="form-group">
                <label for="debut">Ano de Debut</label>

                <input 
                    type="number" 
                    id="debut" 
                    name="debut" 
                    placeholder="Ex.: 2020" 
                    required
                    value="<?= htmlspecialchars($grupo->debut) ?>"
                >
            </div>

            <div class="form-group">
                <label for="empresa">Empresa</label>

                <input 
                    type="text" 
                    id="empresa" 
                    name="empresa" 
                    placeholder="Ex.: KQ Entertainment" 
                    required
                    value="<?= htmlspecialchars($grupo->empresa) ?>"
                >
            </div>

            <div class="form-group">
                <label for="membros">Número de Membros</label>

                <input 
                    type="number" 
                    name="membros" 
                    id="membros" 
                    placeholder="Ex.: 8" 
                    required
                    value="<?= htmlspecialchars($grupo->numero_membros) ?>"
                >
            </div>

            <div class="form-group">
                <label for="imagem">Imagem do Grupo</label>

                <label for="imagem" class="upload-box">
                    <span class="upload-icon">☁</span>
                    <strong>Clique para enviar</strong>
                    <small>uma imagem</small>
                </label>

                <input 
                    type="file" 
                    id="imagem" 
                    name="imagem" 
                    accept="image/*" 
                    class="input-file"
                >
            </div>

            <div class="form-group descricao-group">
                <label for="descricao">Descrição</label>

                <textarea 
                    id="descricao" 
                    name="descricao" 
                    placeholder="Fale sobre o grupo..."
                ><?= htmlspecialchars($grupo->descricao) ?></textarea>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn-cancelar">Cancelar</a>

                <button type="submit" class="btn-salvar">
                    Salvar Grupo
                </button>
            </div>

        </form>

        <span class="sparkle">✦</span>

    </main>
    
</body>
</html>