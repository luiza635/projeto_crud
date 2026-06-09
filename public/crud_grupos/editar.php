<?php
require_once '../../src/includes/auth.php';
require_once '../../src/config/database.php';

if (!isset($_GET['id_grupo'])) {
    header("Location: ../index.php");
    exit;
}

$id_grupo = $_GET['id_grupo'];

$sql = "SELECT * FROM grupos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_grupo]);

$grupo = $stmt->fetch(PDO::FETCH_OBJ);

if (!$grupo) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Grupo</title>
    <link rel="stylesheet" href="../assets/css/pg_criar.css?v=21">
</head>

<body class="form-page">

    <div class="form-container">

        <h1 class="form-title">Editar Grupo</h1>

        <form action="processar_editar.php" method="POST" enctype="multipart/form-data" class="grupo-form">

            <input type="hidden" name="id_grupo" value="<?= $grupo->id ?>">

            <div class="form-group">
                <label>Nome do Grupo</label>
                <input 
                    type="text" 
                    name="nome" 
                    value="<?= htmlspecialchars($grupo->nome) ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label>Tipo</label>

                <select name="tipo_grupo" required>
                    <option value="Boy Group" <?= $grupo->tipo_grupo == 'Boy Group' ? 'selected' : '' ?>>
                        Boy Group
                    </option>

                    <option value="Girl Group" <?= $grupo->tipo_grupo == 'Girl Group' ? 'selected' : '' ?>>
                        Girl Group
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Ano de Debut</label>
                <input 
                    type="number" 
                    name="debut" 
                    value="<?= htmlspecialchars($grupo->debut) ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label>Empresa</label>
                <input 
                    type="text" 
                    name="empresa" 
                    value="<?= htmlspecialchars($grupo->empresa) ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label>Número de Membros</label>
                <input 
                    type="number" 
                    name="numero_membros" 
                    value="<?= htmlspecialchars($grupo->numero_membros) ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label>Imagem do Grupo</label>

                <label for="imagem" class="upload-box">
                    <span class="upload-icon">☁</span>
                    <span class="upload-title">Clique ou arraste para enviar</span>
                    <span class="upload-subtitle">você pode enviar uma nova imagem</span>
                </label>

                <input 
                    type="file" 
                    id="imagem" 
                    name="imagem" 
                    class="input-file" 
                    accept="image/*"
                >
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea 
                    name="descricao" 
                    placeholder="Fale sobre o grupo..."
                ><?= htmlspecialchars($grupo->descricao) ?></textarea>
            </div>

            <div class="form-actions">
                <a href="../index.php" class="btn-cancel">Cancelar</a>

                <button type="submit" class="btn-save">
                    Salvar Grupo
                </button>
            </div>

        </form>

    </div>

</body>
</html>