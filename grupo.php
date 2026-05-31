<?php 
require_once 'includes/auth.php';
require_once 'config/database.php';

if (!isset($_GET['id_grupo'])) {
    header('Location: index.php');
    exit;
}

$id_grupo = $_GET['id_grupo'];

$stmt = $pdo->prepare("SELECT * FROM integrantes WHERE grupo_id = ?");
$stmt->execute([$id_grupo]);   
$membros = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $pdo->prepare("SELECT * FROM musicas WHERE grupo_id = ?");
$stmt->execute([$id_grupo]);   
$musicas = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $pdo->prepare("SELECT * FROM grupos WHERE id = ?");
$stmt->execute([$id_grupo]);   
$grupo = $stmt->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detalhes do Grupo - <?= $grupo->nome; ?></title>
<link rel="stylesheet" href="/PROJETO_CRUD/assets/css/pg_grupo.css?v=4">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous"/>
</head>
<body class="group-info">

<div class="details-container">

    <!-- Topo -->
    <div class="details-header">
        <a href="index.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
        <h2 class="details-title">Detalhes do Grupo</h2>
    </div>

    <!-- Card do Grupo -->
    <div class="group-card">
        <div class="imagem-grupo">
            <img src="assets/img/foto_boynextdoor.jpg" alt="<?= $grupo->nome; ?>">
        </div>
        <div class="info-grupo">
            <h2><?= $grupo->nome; ?></h2>
            <p><strong>Tipo:</strong> <?= $grupo->tipo_grupo; ?></p>
            <p><strong>Debut:</strong> <?= $grupo->debut; ?></p>
            <p><strong>Empresa:</strong> <?= $grupo->empresa; ?></p>
            <p><strong>Membros:</strong> <?= $grupo->numero_membros; ?></p>
        </div>
    </div>

    <!-- Descrição -->
    <div class="descricao">
        <h3>Descrição</h3>
        <div class="group-description">
            <p><?= $grupo->descricao; ?></p>
        </div>
    </div>

    <!-- Membros -->
<section class="members-panel">

    <div class="members-panel-header">
        <h3 class="members-panel-title">
            Membros
        </h3>

        <a 
            href="integrantes_crud/adicionar_membros.php?id_grupo=<?= htmlspecialchars($id_grupo) ?>" 
            class="btn-add-member"
        >
            + Adicionar Membro
        </a>
    </div>

    <div class="members-list">

        <?php if (empty($membros)): ?>

            <p class="members-empty">Nenhum membro cadastrado ainda.</p>

        <?php else: ?>

            <?php foreach ($membros as $membro): ?>

                <?php
                        $fotoMembro = 'assets/img/taesan.jpg';

                    if (!empty($membro->foto)) {
                        $foto = $membro->foto;

                        if (
                            strpos($foto, 'assets/') === 0 ||
                            strpos($foto, 'uploads/') === 0 ||
                            preg_match('/^https?:\/\//', $foto)
                        ) {
                            $fotoMembro = $foto;
                        } else {
                            $fotoMembro = 'assets/img/' . $foto;
                        }
                    }
                ?>

                <article class="member-card">

                    <img 
                        src="<?= htmlspecialchars($fotoMembro) ?>" 
                        alt="<?= htmlspecialchars($membro->nome_artistico) ?>" 
                        class="member-photo"
                    >

                    <div class="member-info">
                        <h4><?= htmlspecialchars($membro->nome_artistico) ?></h4>

                        <p>
                            <strong>Nome real:</strong> 
                            <?= htmlspecialchars($membro->nome_real) ?>
                        </p>

                        <p>
                            <strong>Função:</strong> 
                            <?= htmlspecialchars($membro->funcao) ?>
                        </p>
                    </div>

                    <div class="member-actions">

                        <a 
                            href="integrantes_crud/editar_membros.php?id=<?= htmlspecialchars($membro->id) ?>&id_grupo=<?= htmlspecialchars($id_grupo) ?>" 
                            class="member-icon edit-icon"
                            title="Editar membro"
                        >
                            ✎
                        </a>

                        <a 
                            href="integrantes_crud/excluir_membros.php?id=<?= htmlspecialchars($membro->id) ?>&id_grupo=<?= htmlspecialchars($id_grupo) ?>" 
                            class="member-icon delete-icon"
                            title="Excluir membro"
                            onclick="return confirm('Tem certeza que deseja excluir este membro?')"
                        >
                            🗑
                        </a>

                    </div>

                </article>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</section>

    <!-- Discografia -->
    <div class="descricao">
        <h3>Discografia</h3>
        <a href="musicas_crud/adicionar_musica.php?id_grupo=<?= $id_grupo; ?>" class="btn-save">Adicionar Música</a>

        <?php foreach ($musicas as $musica): ?>
        <div class="group-card">
            <div class="imagem-grupo">
                <img src="assets/img/teasan.jpg" alt="<?= $musica->titulo; ?>">
            </div>
            <div class="info-grupo">
                <p><strong>Nome:</strong> <?= $musica->titulo; ?></p>
                <p><strong>Ouvir:</strong> <?= $musica->link_ouvir; ?></p>
                <p><strong>Letra:</strong> <?= $musica->letra; ?></p>
                <a href="musicas_crud/editar_musica.php?id=<?= $musica->id; ?>&id_grupo=<?= $id_grupo; ?>" class="btn-save">Editar</a>
                <a href="musicas_crud/excluir_musica.php?id=<?= $musica->id; ?>&id_grupo=<?= $id_grupo; ?>" class="btn-cancel">Excluir</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>

</body>
</html>