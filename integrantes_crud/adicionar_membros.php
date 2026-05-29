<?php 
include_once "../config/database.php";
include_once "../includes/auth.php";

$id_grupo = $_GET['id_grupo'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_real = $_POST['nome_real'];
    $nome_artistico = $_POST['nome_artistico'];
    $aniversario = $_POST['aniversario'];
    $funcao = $_POST['funcao'];
    $biografia = $_POST['biografia'];

    // Aqui você pode adicionar a lógica para lidar com o upload da imagem, se necessário.

    $sql = "INSERT INTO integrantes (nome_real, nome_artistico, aniversario, funcao, biografia, grupo_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome_real, $nome_artistico, $aniversario, $funcao, $biografia, $id_grupo]);

    header("Location: ../index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Integrante</title>
    <link rel="stylesheet" href="../\assets/css/pg_criar.css">
</head>

<body class="form-page">

    <main class="form-card">

        <div class="form-top">
            <a href="index.php" class="btn-voltar">←</a>

            <h1 class="form-title">Adicionar Novo Integrante</h1>

            <span class="heart-icon">♡</span>
        </div>

        <form action="adicionar_membros.php" method="POST" enctype="multipart/form-data" class="grupo-form">

            <div class="form-group">
                <label for="nome_real">Nome real do Integrante</label>

                <input 
                    type="text" 
                    id="nome_real" 
                    name="nome_real" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="nome_artistico">Nome artistico do Integrante</label>

                <input 
                    type="text" 
                    id="nome_artistico" 
                    name="nome_artistico" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="funcao">Tipo</label>

                <select id="funcao" name="funcao" required>
                    <option value="" disabled selected>Selecione a função</option>
                    <option value="vocalista">Vocalista</option>
                    <option value="dançarino">Dançarino</option>
                    <option value="compositor">Compositor</option>
                    <option value="rapper">Rapper</option>
                    <option value="líder">Líder</option>
                </select>
            </div>

            <div class="form-group">
                <label for="aniversario">Aniversário</label>

                <input 
                    type="date" 
                    id="aniversario" 
                    name="aniversario" 
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
                ></textarea>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn-cancelar">Cancelar</a>

                <button type="submit" class="btn-salvar">
                    Salvar Integrante
                </button>
            </div>

        </form>

        <span class="sparkle">✦</span>

    </main>

</body>
</html>