<?php
require_once 'includes/auth.php';
require_login();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Área Logada</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="area-logada">
    <h1>Bem-vindo, <?= e($_SESSION['usuario_nome']) ?>!</h1>
    <p>Login realizado com sucesso.</p>

    <a href="logout.php" class="btn-sair">Sair</a>
</div>

</body>
</html>