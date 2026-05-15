<?php
require_once 'includes/auth.php';
require_once 'config/database.php';

// $sql = "SELECT * FROM grupos WHERE usuario_id = ?";
$sql = "SELECT * FROM grupos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>MIRROR HUB</title>
    <link rel="stylesheet" href="assets/css/pg_index.css">
</head>
<body class="page-kpop">
<header class="topbar">
    <div class="topbar-logo">
        <!-- <img src="assets/img/login/aberto.png" class="logo-icon" alt="MIRROR HUB"> -->
        <span class="logo-text">MIRROR HUB</span>
    </div>
    <div class="topbar-user">
        <span class="user-avatar">👤</span>
        <span class="user-name">
            <?= htmlspecialchars($_SESSION['usuario_nome'] ?? 'annyeong!') ?>
        </span>
        <a href="login/logout.php" class="btn-sair">Sair</a>
    </div>
</header>

<main class="main-container">
    <section class="page-header">
        <div>
            <h1 class="page-title">
                Grupos de K-pop
                <span class="title-icon">🦋</span>
            </h1>
        </div>
        <a href="criar_grupo.php" class="btn-adicionar">
            + Novo Grupo
        </a>
    </section>

    <section class="table-card">
        <table class="grupos-table">
            <thead>
                <tr>
                    <th>Nome do Grupo</th>
                    <th>Debut</th>
                    <th>Empresa</th>
                    <th>Membros</th>
                    <th class="acoes-title">Ações</th>
                </tr>
            </thead>

            <tbody>
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
                            <a href="editar.php?id_grupo=<?= $grupo['id'] ?>" class="btn-acao btn-editar" title="Editar grupo"> ✎ </a>
                            <a href="excluir_grupo.php?id_grupo=<?= $grupo['id'] ?>" class="btn-acao btn-excluir" title="Excluir grupo" onclick="return confirm('Tem certeza que deseja excluir este grupo?')"> 🗑 </a>
                            <a href="grupo.php?id_grupo=<?= $grupo['id'] ?>" class="btn-acao btn-detalhes" title="Detalhes do grupo"> 🕵️ </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

</main>

</body>
</html>