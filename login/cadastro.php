<?php
require_once "../config/database.php";

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $email = trim($_POST['email'] ?? '');

    if ($nome && $senha && $email) {

        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $usuarioExiste = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioExiste) {
            $erro = "Esse email já está cadastrado.";
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha_hash) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, $senha_hash]);

            header('Location: login.php');
            exit;
        }

    } else {
        $erro = "Todos os campos são obrigatórios.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>

    <link rel="stylesheet" href="../assets/css/style.css?v=52">
</head>

<body class="login-body">

    <main class="desktop-login">

        <section class="browser-window cadastro-window">

            <div class="browser-tabs">
                <span class="tab tab-one"></span>
            </div>

            <div class="browser-topbar">

                <div class="browser-arrows">
                    <span>‹</span>
                    <span>›</span>
                </div>

                <div class="address-bar">
                    crud.com/cadastro
                </div>

                <div class="window-actions">
                    <img
                        src="../assets/img/login/mensagens.png"
                        alt="Ícone de mensagens"
                        class="mensagens-icon"
                    >
                </div>

            </div>

            <div class="cadastro-content">

                <div class="login-panel cadastro-panel">

                    <div class="avatar-circle"></div>

                    <h1 class="cadastro-title">Cadastro</h1>

                    <?php if (!empty($erro)): ?>
                        <div class="error">
                            <?php echo htmlspecialchars($erro); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="cadastro.php" class="cadastro-form">

                        <div class="cadastro-field">
                            <label for="nome">nome:</label>
                            <input
                                type="text"
                                name="nome"
                                id="nome"
                                required
                            >
                        </div>

                        <div class="cadastro-field">
                            <label for="email">email:</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                required
                            >
                        </div>

                        <div class="cadastro-field">
                            <label for="senha">senha:</label>
                            <input
                                type="password"
                                name="senha"
                                id="senha"
                                required
                            >
                        </div>

                        <div class="login-buttons cadastro-buttons">
                            <a href="login.php" class="btn-small btn-link">voltar</a>
                            <button type="submit" class="btn-small">cadastrar</button>
                        </div>

                    </form>

                </div>

            </div>

        </section>

    </main>

</body>
</html>