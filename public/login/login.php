<?php
require_once '../../src/config/database.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

        header('Location: ../crud_grupos/index.php?status=sucesso');
        exit;
    } else {
        $error = 'Email ou senha incorretos.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="../assets/css/style.css?v=49">
</head>

<body class="login-body">

    <main class="desktop-login">

        <div class="left-menu">

            <div class="folder-item">
                <span class="folder-icon"></span>
                groups
            </div>

            <div class="folder-item">
                <span class="folder-icon"></span>
                members
            </div>

            <div class="folder-item">
                <span class="folder-icon"></span>
                songs
            </div>

        </div>

        <section class="browser-window">

            <div class="browser-tabs">
                <span class="tab tab-one"></span>
            </div>

            <div class="browser-topbar">

                <div class="browser-arrows">
                    <span>‹</span>
                    <span>›</span>
                </div>

                <div class="address-bar">
                    crud.com
                </div>

                <div class="window-actions">
                    <img
                        src="../assets/img/login/mensagens.png"
                        alt="Ícone de mensagens"
                        class="mensagens-icon"
                    >
                </div>

            </div>

            <div class="browser-content">

                <div class="cute-side">

                    <div class="speech-bubble">
                        <img
                            src="../assets/img/login/balao.png"
                            alt="Balão com coração"
                            class="bubble-img"
                        >
                    </div>

                    <div class="pet-wrap">
                        <img
                            src="../assets/img/login/coelho.png"
                            alt="Coelhinho do login"
                            id="petImg"
                            class="pet-img"
                        >
                    </div>

                </div>

                <div class="login-panel">

                    <div class="avatar-circle"></div>

                    <h1 class="login-title">Login</h1>

                    <?php if (!empty($error)): ?>
                        <div class="error">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="login.php" class="login-form">

                        <label for="email">user:</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="email@gmail.com"
                            required
                        >

                        <label for="senhaInput">pass:</label>
                        <input
                            type="password"
                            name="senha"
                            id="senhaInput"
                            placeholder="••••••"
                            required
                        >

                        <div class="login-buttons">
                            <button type="button" class="btn-small">cancel</button>
                            <button type="submit" class="btn-small">entrar</button>
                        </div>

                        <a href="cadastro.php" class="register-link">criar conta</a>

                    </form>

                </div>

            </div>

        </section>

        <!-- IMAGEM DO URSINHO -->
        <div class="foto-direita">
            <img src="../assets/img/login/ursinho.png" alt="Imagem do ursinho">
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