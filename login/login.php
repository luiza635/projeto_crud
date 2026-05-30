<?php
require_once '../config/database.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email === '' || $senha === '') {
        $error = 'Preencha email e senha.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];

            header('Location: ../index.php?status=sucesso');
            exit;
        }

        $error = 'Email ou senha incorretos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-body">

    <main class="desktop-login">

        <aside class="left-menu">
            <div class="folder-item">
                <span class="folder-icon"></span>
                <span>intro</span>
            </div>

            <div class="folder-item">
                <span class="folder-icon"></span>
                <span>outro</span>
            </div>
        </aside>

        <section class="browser-window">

            <div class="browser-tabs">
                <div class="tab tab-one"></div>
                <div class="tab tab-two"></div>
            </div>

            <div class="browser-topbar">

                <div class="browser-arrows">
                    <span>&lsaquo;</span>
                    <span>&rsaquo;</span>
                </div>

                <div class="address-bar">
                    www.youtube.com:
                </div>

                <div class="window-actions">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

            </div>

            <div class="browser-content">

                <div class="cute-side">

                    <div class="hearts">
                        <span></span>
                        <span></span>
                    </div>

                    <div class="pet-wrap">
                        <img
                            src="../assets/img/login/aberto.png"
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
                            <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="login.php" class="login-form">

                        <label for="email">user:</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="email@email.com"
                            value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                            autocomplete="email"
                            required
                        >

                        <label for="senhaInput">pass:</label>
                        <input
                            type="password"
                            id="senhaInput"
                            name="senha"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >

                        <div class="login-buttons">
                            <button type="reset" class="btn-small btn-cancel">
                                cancel
                            </button>

                            <button type="submit" class="btn-small btn-accept">
                                accept
                            </button>
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
                <span class="play-btn">▶</span>
                <span class="next-btn">▶▶</span>
                <span class="heart-btn">♥</span>
            </div>

            <div class="music-line">
                <span></span>
            </div>
        </div>

        <div class="bottom-bar">
            <span class="windows-icon"></span>
            <span class="folder-small"></span>

            <div class="search-bar">
                ⌕ <span></span> <b>×</b>
            </div>

            <div class="system-icons">
                <span>▱</span>
                <span>⌁</span>
                <span>⚙</span>
            </div>
        </div>

    </main>

    <script>
        const senhaInput = document.getElementById('senhaInput');
        const petImg = document.getElementById('petImg');

        const imagemAberta = '../assets/img/login/aberto.png';
        const imagemFechada = '../assets/img/login/fechado.jpg';

        if (senhaInput && petImg) {
            senhaInput.addEventListener('focus', () => {
                petImg.src = imagemFechada;
            });

            senhaInput.addEventListener('input', () => {
                petImg.src = imagemFechada;
            });

            senhaInput.addEventListener('blur', () => {
                petImg.src = imagemAberta;
            });
        }
    </script>

</body>
</html>