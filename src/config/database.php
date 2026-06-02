<?php

$host = 'localhost';
$dbname = 'projeto_crud';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erro ao conectar com o banco: " . $e->getMessage());
}

// try {
//     $pdo = new PDO(
//         "mysql:host=banco;port=3306;dbname=projeto_crud;charset=utf8mb4",
//         "kpop",
//         "kpop123"
//     );

//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// } catch (PDOException $e) {
//     die("Erro na conexão com o banco: " . $e->getMessage());
// }