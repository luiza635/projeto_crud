<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (is_logged()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

        header('Location: index.php');
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
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">

<div class="login-card">

    <div class="pet-wrap">
        <img 
            src="assets/img/login/aberto.png" 
            alt="Cachorrinho do login" 
            id="petImg" 
            class="pet-img"
        >
    </div>

    <h1 class="login-title">Login</h1>

    <?php if ($error): ?>
        <div class="error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Email</label>
        <input 
            type="email" 
            name="email" 
            placeholder="email@email.com" 
            required
        >

        <label>Password</label>
        <input 
            type="password" 
            name="senha" 
            id="senhaInput" 
            required
        >

        <button type="submit">Log in</button>
    </form>

</div>

<script>
const senhaInput = document.getElementById('senhaInput');
const petImg = document.getElementById('petImg');

const imagemAberta = 'assets/img/login/aberto.png';
const imagemFechada = 'assets/img/login/fechado.jpg';

senhaInput.addEventListener('focus', () => {
    petImg.src = imagemFechada;
});

senhaInput.addEventListener('input', () => {
    petImg.src = imagemFechada;
});

senhaInput.addEventListener('blur', () => {
    petImg.src = imagemAberta;
});
</script>

</body>
</html>