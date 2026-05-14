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
    <title>Área Logada</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <a href="logout.php" class="btn-sair">Sair</a>

</header>
<main>
    <h1>Bem-vindo, <?= $_SESSION['usuario_nome']?>!</h1>
    <p>Esta é a área restrita do site.</p>

    <h1>Grupos</h1>
    <table>
        <thead>
            <tr>
                <th>Nome do grupo</th>
                <th>Debut</th>
                <th>Empresa</th>
                <th>Membros</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grupos as $grupo): ?>
                <tr>
                    <td><?= $grupo['nome'] ?></td>
                    <td><?= $grupo['debut']?></td>
                    <td><?= $grupo['empresa']?></td>
                    <td><?= $grupo['numero_membros']?></td>
                    <td>
                        <a href="editar.php?id_grupo=<?= $grupo['id']?>" class="btn-editar">Editar</a>
                        <a href="excluir_grupo.php?id_grupo=<?= $grupo['id']?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este grupo?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="grupos.php" class="btn-adicionar">Adicionar grupo</a>
</main>

</body>
</html>