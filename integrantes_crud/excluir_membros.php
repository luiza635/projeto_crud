<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

try {
    // Verifica se os parâmetros foram passados
    if (!isset($_GET['id']) || !isset($_GET['id_grupo'])) {
        throw new Exception("Parâmetros inválidos.");
    }

    $id_membro = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    $id_grupo  = filter_var($_GET['id_grupo'], FILTER_VALIDATE_INT);

    if (!$id_membro || !$id_grupo) {
        throw new Exception("ID inválido.");
    }

    // Verifica se o membro realmente existe
    $stmt = $pdo->prepare("SELECT id FROM integrantes WHERE id = ? AND grupo_id = ?");
    $stmt->execute([$id_membro, $id_grupo]);
    $membroExiste = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$membroExiste) {
        throw new Exception("Membro não encontrado neste grupo.");
    }

    // Deleta o membro
    $stmt = $pdo->prepare("DELETE FROM integrantes WHERE id = ? AND grupo_id = ?");
    $stmt->execute([$id_membro, $id_grupo]);

    // Mensagem opcional de sucesso via session ou GET
    $_SESSION['mensagem'] = "Membro deletado com sucesso.";

    header("Location: ../grupo.php?id_grupo=$id_grupo");
    exit;

} catch (Exception $e) {
    // Redireciona com erro na URL ou exibe mensagem
    $erro = urlencode($e->getMessage());
    header("Location: ../grupo.php?id_grupo=" . ($_GET['id_grupo'] ?? '') . "&erro=$erro");
    exit;
}
?>