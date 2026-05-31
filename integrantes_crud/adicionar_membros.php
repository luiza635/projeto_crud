<?php 
include_once "../config/database.php";
include_once "../includes/auth.php";

$id_grupo = $_GET['id_grupo'] ?? null;

if (!$id_grupo) {
    header("Location: ../index.php");
    exit();
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_real = trim($_POST['nome_real'] ?? '');
    $nome_artistico = trim($_POST['nome_artistico'] ?? '');
    $aniversario = trim($_POST['aniversario'] ?? '');
    $funcao = trim($_POST['funcao'] ?? '');
    $biografia = trim($_POST['biografia'] ?? '');

    if ($nome_real && $nome_artistico && $aniversario && $funcao && $biografia) {
        $sql = "INSERT INTO integrantes 
                (nome_real, nome_artistico, aniversario, funcao, biografia, grupo_id) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $nome_real,
            $nome_artistico,
            $aniversario,
            $funcao,
            $biografia,
            $id_grupo
        ]);

        header("Location: ../index.php");
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
    <title>Novo Integrante</title>
    <link rel="stylesheet" href="../assets/css/pg_criar.css?v=5">
</head>

<body class="form-page">

<div class="form-container">
    <h1 class="form-title">Novo Integrante</h1>

    <?php if (!empty($erro)): ?>
        <div class="form-error"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form 
        action="adicionar_membros.php?id_grupo=<?= htmlspecialchars($id_grupo) ?>" 
        method="POST" 
        enctype="multipart/form-data" 
        class="grupo-form"
    >

        <div class="form-group">
            <label for="nome_real">Nome Real do Integrante</label>
            <input 
                type="text" 
                id="nome_real" 
                name="nome_real" 
                placeholder="Ex.: Kim Namjoon"
                required
            >
        </div>

        <div class="form-group">
            <label for="nome_artistico">Nome Artístico do Integrante</label>
            <input 
                type="text" 
                id="nome_artistico" 
                name="nome_artistico" 
                placeholder="Ex.: RM"
                required
            >
        </div>

        <div class="form-group">
            <label for="funcao">Função</label>
            <select id="funcao" name="funcao" required>
                <option value="" disabled selected>Selecione a função</option>
                <option value="Vocalista">Vocalista</option>
                <option value="Dançarino">Dançarino</option>
                <option value="Compositor">Compositor</option>
                <option value="Rapper">Rapper</option>
                <option value="Líder">Líder</option>
            </select>
        </div>

        <div class="form-group">
            <label for="aniversario">Aniversário</label>
            <input 
                type="date" 
                id="aniversario" 
                name="aniversario" 
                required
            >
        </div>

        <div class="form-group">
            <label for="foto">Foto do Integrante</label>

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
            ></textarea>
        </div>

        <div class="form-actions">
            <a href="../index.php" class="btn-cancel">Cancelar</a>

            <button type="submit" class="btn-save">
                Salvar Integrante
            </button>
        </div>

    </form>
</div>

</body>
</html>