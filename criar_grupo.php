<?php
require_once 'includes/auth.php';
require_once 'config/database.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $tipo = trim($_POST['tipo'] ?? '');
    $debut = trim($_POST['debut'] ?? '');
    $empresa = trim($_POST['empresa'] ?? '');
    $membros = trim($_POST['membros'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if ($nome && $tipo && $debut && $empresa && $membros) {
        $sql = "INSERT INTO grupos (nome, debut, empresa, numero_membros, tipo_grupo, descricao) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $debut, $empresa, $membros, $tipo, $descricao]);

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

    <link rel="stylesheet" href="assets/css/pg_criar.css?v=1">
</head>

<body class="form-page">

    <main class="desktop-form">

        <section class="form-window">

            <div class="form-topbar">

                <div class="form-arrows">
                    <span>‹</span>
                    <span>›</span>
                </div>

                <div class="form-address">
                    crud.com/groups/create
                </div>

                <div class="form-actions-icon">
                    <img
                        src="assets/img/login/mensagens.png"
                        alt="Ícone de mensagens"
                        class="mensagens-icon"
                    >
                </div>

            </div>

            <div class="form-content">

                <header class="form-header">
                    <div>
                        <span class="form-subtitle">CREATE</span>
                        <h1 class="form-title">Novo Grupo</h1>
                    </div>

                    <a href="index.php" class="btn-voltar">
                        voltar
                    </a>
                </header>

                <?php if (!empty($erro)): ?>
                    <div class="form-error">
                        <?= htmlspecialchars($erro) ?>
                    </div>
                <?php endif; ?>

                <form action="criar_grupo.php" method="POST" class="grupo-form">

                    <div class="form-grid">

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

                        <div class="form-group descricao-group">
                            <label for="descricao">Descrição</label>
                            <textarea
                                id="descricao"
                                name="descricao"
                                placeholder="Fale um pouco sobre o grupo..."
                            ></textarea>
                        </div>

                    </div>

                    <div class="form-buttons">
                        <a href="index.php" class="btn-cancelar">cancelar</a>
                        <button type="submit" class="btn-salvar">salvar grupo</button>
                    </div>

                </form>

            </div>

        </section>

        <div class="foto-direita">
            <img src="assets/img/login/ursinho.png" alt="Imagem do ursinho">
        </div>

        <div class="right-palette">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

    </main>

</body>
</html>