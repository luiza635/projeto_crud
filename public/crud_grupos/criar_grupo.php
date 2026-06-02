<?php
require_once '../../src/includes/auth.php';
require_once '../../src/config/database.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $tipo = trim($_POST['tipo'] ?? '');
    $debut = trim($_POST['debut'] ?? '');
    $empresa = trim($_POST['empresa'] ?? '');
    $membros = trim($_POST['membros'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    $fotoSalva = '';
    if (!empty($_FILES['imagem']['name'])) {
        $arquivo = $_FILES['imagem'];
        $nomeArquivo = time() . '_' . basename($arquivo['name']);
        $caminho = '../uploads/grupos/' . $nomeArquivo;

        if (!is_dir('../uploads/grupos/')) {
            mkdir('../uploads/grupos/', 0755, true);
        }

        if (move_uploaded_file($arquivo['tmp_name'], $caminho)) {
            $fotoSalva = 'uploads/grupos/' . $nomeArquivo;
        }
    }

    if ($nome && $tipo && $debut && $empresa && $membros) {
        $sql = "INSERT INTO grupos 
                (nome, debut, empresa, numero_membros, tipo_grupo, descricao, imagem) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $nome,
            $debut,
            $empresa,
            $membros,
            $tipo,
            $descricao, 
            $fotoSalva
        ]);

        header("Location: index.php");
        exit;
    } else {
        $erro = "Preencha todos os campos obrigatórios.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Grupo</title>
    <link rel="stylesheet" href="/PROJETO_CRUD/public/assets/css/pg_criar.css?v=5">
</head>

<body class="form-page">

<div class="form-container">
    <h1 class="form-title">Novo Grupo</h1>

    <?php if (!empty($erro)): ?>
        <div class="form-error"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form 
        action="criar_grupo.php" 
        method="POST" 
        class="grupo-form" 
        enctype="multipart/form-data"
    >

        <div class="form-group">
            <label for="nome">Nome do Grupo</label>
            <input 
                type="text" 
                id="nome" 
                name="nome" 
                placeholder="Ex.: Enhypen" 
                required
            >
        </div>

        <div class="form-group">
            <label for="tipo">Tipo</label>
            <select id="tipo" name="tipo" required>
                <option value="" disabled selected>Selecione</option>
                <option value="Boy Group">Boy Group</option>
                <option value="Girl Group">Girl Group</option>
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
            >
        </div>

        <div class="form-group">
            <label for="empresa">Empresa</label>
            <input 
                type="text" 
                id="empresa" 
                name="empresa" 
                placeholder="Ex.: Hybe" 
                required
            >
        </div>

        <div class="form-group">
            <label for="membros">Número de Membros</label>
            <input 
                type="number" 
                id="membros" 
                name="membros" 
                placeholder="Ex.: 7" 
                required
            >
        </div>

        <div class="form-group">
            <label for="imagem">Imagem do Grupo</label>

            <label for="imagem" class="upload-box">
                <span class="upload-icon">☁</span>
                <strong>Clique ou arraste para enviar</strong>
                <small>você pode enviar várias imagens</small>
            </label>

            <input 
                type="file" 
                id="imagem" 
                name="imagem" 
                class="input-file" 
                accept="image/*" 
            >
        </div>

        <div class="form-group descricao-group">
            <label for="descricao">Descrição</label>
            <textarea 
                id="descricao" 
                name="descricao" 
                placeholder="Fale sobre o grupo..."
            ></textarea>
        </div>

        <div class="form-actions">
            <a href="index.php" class="btn-cancel">Cancelar</a>

            <button type="submit" class="btn-save">
                Salvar Grupo
            </button>
        </div>

    </form>
</div>
</body>
</html>