<?php 

require_once "config/database.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $email = trim($_POST['email'] ?? '');

    if ($nome && $senha && $email) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha_hash) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senha_hash]);

        header('Location: login.php');
        exit;
    } else {
        echo "Todos os campos são obrigatórios.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="cadastro.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome">

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Email">

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>