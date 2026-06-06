<?php
require_once '../src/includes/auth.php';
require_once '../src/config/database.php';

$sql = "SELECT * FROM grupos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Grupos de K-pop</title>

    <link rel="stylesheet" href="assets/css/pg_index.css?v=2">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    >
</head>

<body class="page-kpop">

    <main class="desktop-crud">

        <section class="browser-window">

            <div class="browser-topbar">

                <div class="browser-arrows">
                    <span>‹</span>
                    <span>›</span>
                </div>

                <div class="address-bar">
                    crud.com/groups
                </div>

                <div class="window-actions">
                    <img
                        src="assets/img/login/mensagens.png"
                        alt="Ícone de mensagens"
                        class="mensagens-icon"
                    >
                </div>

            </div>

            <div class="browser-content">

                <header class="crud-header">

                    <div class="title-area">
                        <h1 class="page-title">Grupos de K-pop</h1>
                    </div>

                    <div class="user-area">
                        <span class="user-name">
                            <?= htmlspecialchars($_SESSION['usuario_nome'] ?? 'usuário') ?>
                        </span>

                        <a href="login/logout.php" class="btn-sair">
                            sair
                        </a>
                    </div>

                </header>

                <section class="crud-actions">

                    <a href="crud_grupos/criar_grupo.php" class="btn-adicionar">
                        + novo grupo
                    </a>

                </section>

                <section class="table-card">

                    <table class="grupos-table">

                        <thead>
                            <tr>
                                <th>Grupo</th>
                                <th>Debut</th>
                                <th>Empresa</th>
                                <th>Membros</th>
                                <th class="acoes-title">Ações</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (count($grupos) > 0): ?>

                                <?php foreach ($grupos as $grupo): ?>
                                    <tr>
                                        <td class="grupo-nome">
                                            <?= htmlspecialchars($grupo['nome']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($grupo['debut']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($grupo['empresa']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($grupo['numero_membros']) ?>
                                        </td>

                                        <td class="acoes">

                                            <a
                                                href="crud_grupos/editar.php?id_grupo=<?= $grupo['id'] ?>"
                                                class="btn-acao btn-editar"
                                                title="Editar grupo"
                                            >
                                                ✎
                                            </a>

                                            <a
                                                href="crud_grupos/excluir_grupo.php?id_grupo=<?= $grupo['id'] ?>"
                                                class="btn-acao btn-excluir"
                                                title="Excluir grupo"
                                                onclick="return confirm('Tem certeza que deseja excluir este grupo?')"
                                            >
                                                🗑
                                            </a>

                                            <a
                                                href="crud_grupos/grupo.php?id_grupo=<?= $grupo['id'] ?>"
                                                class="btn-acao btn-detalhes"
                                                title="Detalhes do grupo"
                                            >
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="5" class="empty-message">
                                        Nenhum grupo cadastrado ainda.
                                    </td>
                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </section>

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