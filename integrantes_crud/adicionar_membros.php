<?php
include_once "../config/database.php";
include_once "../includes/auth.php";

$id_grupo = $_GET['id_grupo'] ?? $_POST['id_grupo'] ?? null;

if (!$id_grupo) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_real = $_POST['nome_real'];
    $nome_artistico = $_POST['nome_artistico'];
    $aniversario = $_POST['aniversario'];
    $funcao = $_POST['funcao'];
    $biografia = $_POST['biografia'];

    $foto = null;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $pastaUpload = "../uploads/membros/";

        if (!is_dir($pastaUpload)) {
            mkdir($pastaUpload, 0777, true);
        }

        $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($extensao, $extensoesPermitidas)) {
            $nomeArquivo = uniqid("membro_", true) . "." . $extensao;
            $caminhoCompleto = $pastaUpload . $nomeArquivo;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoCompleto)) {
                $foto = "uploads/membros/" . $nomeArquivo;
            }
        }
    }

    $sql = "INSERT INTO integrantes 
            (nome_real, nome_artistico, aniversario, funcao, biografia, foto, grupo_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $nome_real,
        $nome_artistico,
        $aniversario,
        $funcao,
        $biografia,
        $foto,
        $id_grupo
    ]);

    header("Location: ../grupo.php?id_grupo=" . $id_grupo);
    exit();
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
    <h1 class="form-title">Adicionar Membro</h1>

    <form action="adicionar_membros.php?id_grupo=<?= htmlspecialchars($id_grupo) ?>" method="POST" enctype="multipart/form-data" class="grupo-form">
        <input type="hidden" name="id_grupo" value="<?= htmlspecialchars($id_grupo) ?>">

        <label for="nome_real">Nome real:</label>
        <input type="text" id="nome_real" name="nome_real" required>

        <label for="nome_artistico">Nome artístico:</label>
        <input type="text" id="nome_artistico" name="nome_artistico" required>

        <label for="aniversario">Data de nascimento:</label>
        <input type="date" id="aniversario" name="aniversario" required>

        <label for="funcao">Função:</label>
        <input type="text" id="funcao" name="funcao" required>

        <label for="biografia">Biografia:</label>
        <textarea id="biografia" name="biografia" rows="4"></textarea>

        <label for="foto">Foto do membro:</label>
        <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png,.webp">

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Adicionar</button>
            <a href="../grupo.php?id_grupo=<?= htmlspecialchars($id_grupo) ?>" class="btn-cancelar">Cancelar</a>
        </div>
    </form>
</div>

<style>
body.form-page {
    background: #f8efe2;
    font-family: Arial, sans-serif;
}

.form-container {
    max-width: 480px;
    margin: 40px auto;
    padding: 24px;
    background: #fffaf3;
    border-radius: 18px;
    border: 2px solid #d9c2aa;
    box-shadow: 0 8px 22px rgba(126, 92, 66, 0.10);
}

.form-title {
    margin-bottom: 18px;
    color: #8b684d;
    font-size: 24px;
    font-weight: 900;
}

.grupo-form label {
    display: block;
    margin-top: 12px;
    margin-bottom: 4px;
    font-weight: 700;
    color: #8b684d;
}

.grupo-form input,
.grupo-form textarea {
    width: 100%;
    padding: 8px;
    border-radius: 8px;
    border: 1px solid #dcc6b0;
    background: #fffaf3;
    color: #5b3d2f;
}

.form-buttons {
    margin-top: 18px;
    display: flex;
    justify-content: space-between;
    gap: 12px;
}

.btn-submit {
    padding: 8px 18px;
    border-radius: 999px;
    border: none;
    background: #c69272;
    color: #fffaf3;
    font-weight: 900;
    cursor: pointer;
}

.btn-submit:hover {
    background: #b07d5a;
}

.btn-cancelar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px 18px;
    border-radius: 999px;
    background: #9b7659;
    color: #fffaf3;
    font-weight: 900;
    text-decoration: none;
}

.btn-cancelar:hover {
    background: #87614c;
}
</style>

</body>
</html>