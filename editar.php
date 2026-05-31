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
    <title>Editar Grupo</title>
    <link rel="stylesheet" href="/PROJETO_CRUD/assets/css/pg_criar.css?v=4">
</head>
<body class="form-page">

<div class="form-container">
    <h1 class="form-title">Editar Grupo</h1>

    <form action="processar_editar.php" method="POST" enctype="multipart/form-data" class="grupo-form">
        <input type="hidden" name="id_grupo" value="<?= $grupo->id ?>">

        <div class="form-group">
            <label for="nome">Nome do Grupo</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($grupo->nome) ?>" required>
        </div>

        <div class="form-group">
            <label for="tipo">Tipo</label>
            <select id="tipo" name="tipo" required>
                <option value="Boy Group" <?= $grupo->tipo_grupo==='Boy Group'?'selected':'' ?>>Boy Group</option>
                <option value="Girl Group" <?= $grupo->tipo_grupo==='Girl Group'?'selected':'' ?>>Girl Group</option>
            </select>
        </div>

        <div class="form-group">
            <label for="debut">Ano de Debut</label>
            <input type="number" id="debut" name="debut" value="<?= htmlspecialchars($grupo->debut) ?>" required>
        </div>

        <div class="form-group">
            <label for="empresa">Empresa</label>
            <input type="text" id="empresa" name="empresa" value="<?= htmlspecialchars($grupo->empresa) ?>" required>
        </div>

        <div class="form-group">
            <label for="membros">Número de Membros</label>
            <input type="number" id="membros" name="membros" value="<?= htmlspecialchars($grupo->numero_membros) ?>" required>
        </div>

        <div class="form-group">
            <label for="imagens">Imagens do Grupo</label>
            <label class="upload-box">
                <span>☁ Clique ou arraste para enviar</span>
                <small>você pode enviar várias imagens</small>
                <input type="file" id="imagens" name="imagens[]" class="input-file" accept="image/*" multiple>
            </label>
        </div>

        <div class="form-group descricao-group">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao"><?= htmlspecialchars($grupo->descricao) ?></textarea>
        </div>

        <div class="form-actions">
            <a href="index.php" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-save">Salvar Grupo</button>
        </div>
    </form>
</div>

</body>
</html>