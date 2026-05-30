<?php
require_once '../config/database.php';
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

        header('Location: ../index.php?status=sucesso');
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
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="login-body">

    <main class="desktop-login">

        <div class="left-menu">

            <div class="folder-item">
                <span class="folder-icon"></span>
                Groups
            </div>

            <div class="folder-item">
                <span class="folder-icon"></span>
                Members
            </div>

            <div class="folder-item">
                <span class="folder-icon"></span>
                Songs
            </div>

        </div>

        <section class="browser-window">

            <div class="browser-tabs">
                <span class="tab tab-one"></span>
                <span class="tab tab-two"></span>
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
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div class="browser-content">

                <div class="cute-side">

                    <div class="speech-bubble">
                        <img
                            src="../assets/img/login/balao.png"
                            alt="Balão decorativo"
                            class="bubble-img"
                        >
                    </div>

                    <div class="pet-wrap">
                        <img
                            src="../assets/img/login/foto.png"
                            alt="Imagem do login"
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
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="login.php" class="login-form">

                        <label for="email">user:</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="email@email.com"
                            required
                        >

                        <label for="senhaInput">pass:</label>
                        <input
                            type="password"
                            name="senha"
                            id="senhaInput"
                            placeholder="••••••••"
                            required
                        >

                        <div class="login-buttons">
                            <button type="button" class="btn-small">cancel</button>
                            <button type="submit" class="btn-small">accept</button>
                        </div>

                    </form>

                </div>

            </div>

        </section>

        <div class="right-palette">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="music-card">
            <div class="music-icons">
                <div class="play-btn">▶</div>
                <span>▶</span>
                <span>▶▶</span>
                <span class="heart-btn">♥</span>
            </div>

            <div class="music-line">
                <span></span>
            </div>
        </div>

        <div class="bottom-bar">
            <div class="windows-icon"></div>
            <div class="folder-small"></div>

            <div class="search-bar">
                <b>⌕</b>
                <span></span>
                <b>×</b>
            </div>

            <div class="system-icons">
                <span>▱</span>
                <span>⌁</span>
                <span>⚙</span>
            </div>
        </div>

    </main>

</body>
</html>
