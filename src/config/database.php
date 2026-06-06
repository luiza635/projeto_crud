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

$host = getenv('BD_HOST') ?: 'banco';
$port = getenv('BD_PORTA') ?: '3306';
$dbname = getenv('BD_DATABASE') ?: 'projeto_crud';
$user = getenv('BD_USERNAME') ?: 'kpop';
$pass = getenv('BD_PASSWORD') ?: 'kpop123';

try {
    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4",
        $user,
        $pass
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erro na conexão com o banco: " . $e->getMessage());
}