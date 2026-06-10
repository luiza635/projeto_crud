<?php

// $host = 'localhost';
// $dbname = 'projeto_crud';
// $user = 'root';
// $pass = '';

// try {
//     $pdo = new PDO(
//         "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
//         $user,
//         $pass
//     );

//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// } catch (PDOException $e) {
//     die("Erro ao conectar com o banco: " . $e->getMessage());
// }

require_once __DIR__ . "/env.php";

carregar_env(__DIR__ . "/../../.env");

$host = $_ENV["BD_HOST"] ?? "banco";
$porta = $_ENV["BD_PORTA"] ?? "3306";
$banco = $_ENV["BD_DATABASE"] ?? "projeto_crud";
$usuario = $_ENV["BD_USERNAME"] ?? "kpop";
$senha = $_ENV["BD_PASSWORD"] ?? "kpop123";

try {
    $pdo = new PDO(
        "mysql:host={$host};port={$porta};dbname={$banco};charset=utf8mb4",
        $usuario,
        $senha
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $erro) {
    die("Erro ao conectar com o banco: " . $erro->getMessage());
}