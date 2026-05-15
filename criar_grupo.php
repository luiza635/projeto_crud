<?php 
include_once "config/database.php";
include_once "includes/auth.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $debut = $_POST['debut'];
    $empresa = $_POST['empresa'];
    $membros = $_POST['membros'];
    $tipo = $_POST['tipo'];
    $descricao = $_POST['descricao'];

    // Aqui você pode adicionar a lógica para lidar com o upload da imagem, se necessário.

    $sql = "INSERT INTO grupos (nome, debut, empresa, numero_membros, tipo_grupo, descricao) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $debut, $empresa, $membros, $tipo, $descricao]);

    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Grupo</title>
    <link rel="stylesheet" href="assets/css/pg_criar.css">
</head>

<body class="form-page">

    <main class="form-card">

        <div class="form-top">
            <a href="index.php" class="btn-voltar">←</a>

            <h1 class="form-title">Adicionar Novo Grupo</h1>

            <span class="heart-icon">♡</span>
        </div>

        <form action="criar_grupo.php" method="POST" enctype="multipart/form-data" class="grupo-form">

            <div class="form-group">
                <label for="nome">Nome do Grupo</label>

                <input 
                    type="text" 
                    id="nome" 
                    name="nome" 
                    placeholder="Ex.: ATEEZ" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="tipo">Tipo</label>

                <select id="tipo" name="tipo" required>
                    <option value="" disabled selected>Selecione o tipo</option>
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
                    placeholder="Ex.: KQ Entertainment" 
                    required
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
                ></textarea>
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