<?php
include_once "../config/database.php";
include_once "../includes/auth.php";

$erro = "";

$id_grupo = filter_input(INPUT_GET, 'id_grupo', FILTER_VALIDATE_INT);

if (!$id_grupo) {
    $id_grupo = filter_input(INPUT_POST, 'id_grupo', FILTER_VALIDATE_INT);
}

if (!$id_grupo) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_real = trim($_POST['nome_real'] ?? '');
    $nome_artistico = trim($_POST['nome_artistico'] ?? '');
    $aniversario = trim($_POST['aniversario'] ?? '');
    $funcao = trim($_POST['funcao'] ?? '');
    $biografia = trim($_POST['biografia'] ?? '');

    if ($nome_real && $nome_artistico && $aniversario && $funcao) {
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

        header("Location: ../grupo.php?id_grupo=" . urlencode($id_grupo));
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
<title>Adicionar Membro</title>
<link rel="stylesheet" href="../assets/css/pg_criar.css?v=2">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous"/>
</head>
<body class="form-page">

<main class="form-container">

    <!-- Botão Voltar igual ao grupo -->
    <a href="../grupo.php?id_grupo=<?= htmlspecialchars($id_grupo) ?>" class="btn-voltar">
        <i class="fa-solid fa-arrow-left"></i> Voltar
    </a>

    <h1 class="form-title">Adicionar Membro</h1>

    <?php if (!empty($erro)): ?>
        <div class="form-error">
            <?= htmlspecialchars($erro) ?>
        </div>
    <?php endif; ?>

    <form 
        action="adicionar_membros.php?id_grupo=<?= htmlspecialchars($id_grupo) ?>" 
        method="POST" 
        enctype="multipart/form-data" 
        class="grupo-form"
    >

        <input 
            type="hidden" 
            name="id_grupo" 
            value="<?= htmlspecialchars($id_grupo) ?>"
        >

        <div class="form-group">
            <label for="nome_real">Nome real:</label>
            <input type="text" id="nome_real" name="nome_real" placeholder="Ex.: Kim Taehyung" required>
        </div>

        <div class="form-group">
            <label for="nome_artistico">Nome artístico:</label>
            <input type="text" id="nome_artistico" name="nome_artistico" placeholder="Ex.: V" required>
        </div>

        <div class="form-group">
            <label for="aniversario">Data de nascimento:</label>
            <input type="date" id="aniversario" name="aniversario" required>
        </div>

        <div class="form-group">
            <label for="funcao">Função:</label>
            <select id="funcao" name="funcao" required>
                <option value="" disabled selected>Selecione a função</option>
                <option value="Vocalista">Vocalista</option>
                <option value="Dançarino">Dançarino</option>
                <option value="Compositor">Compositor</option>
                <option value="Rapper">Rapper</option>
                <option value="Líder">Líder</option>
                <option value="Visual">Visual</option>
                <option value="Maknae">Maknae</option>
            </select>
        </div>

        <div class="form-group descricao-group">
            <label for="biografia">Biografia:</label>
            <textarea id="biografia" name="biografia" placeholder="Fale um pouco sobre o integrante..."></textarea>
        </div>

        <div class="form-group">
            <label for="foto">Foto do membro:</label>
            <label for="foto" class="upload-box">
                <span class="upload-icon">☁</span>
                <strong>Clique para enviar</strong>
                <small>uma imagem do integrante</small>
            </label>
            <input type="file" id="foto" name="foto" accept="image/*" class="input-file">
        </div>

        <div class="form-actions">
            <a href="../grupo.php?id_grupo=<?= htmlspecialchars($id_grupo) ?>" class="btn-cancelar">Cancelar</a>
            <button type="submit" class="btn-salvar">Salvar Integrante</button>
        </div>

    </form>

</main>

</body>
</html>