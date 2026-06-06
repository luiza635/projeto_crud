<?php
require_once '../../src/includes/auth.php';
require_once '../../src/config/database.php';

if (!isset($_GET['id_grupo'])) {
    header('Location: index.php');
    exit;
}

$id_grupo = $_GET['id_grupo'];

$stmt = $pdo->prepare("SELECT * FROM grupos WHERE id = ?");
$stmt->execute([$id_grupo]);
$grupo = $stmt->fetch(PDO::FETCH_OBJ);

if (!$grupo) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM integrantes WHERE grupo_id = ?");
$stmt->execute([$id_grupo]);
$membros = $stmt->fetchAll(PDO::FETCH_OBJ);

$stmt = $pdo->prepare("SELECT * FROM musicas WHERE grupo_id = ?");
$stmt->execute([$id_grupo]);
$musicas = $stmt->fetchAll(PDO::FETCH_OBJ);

function e($valor) {
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function caminhoImagem($imagem, $fallback) {
    $imagem = trim((string) $imagem);

    if ($imagem === '' || strtolower($imagem) === 'array') {
        return $fallback;
    }

    if (
        strpos($imagem, 'assets/') === 0 ||
        strpos($imagem, 'uploads/') === 0 ||
        strpos($imagem, '../') === 0 ||
        preg_match('/^https?:\/\//', $imagem)
    ) {
        return $imagem;
    }

    return 'assets/img/' . ltrim($imagem, '/');
}

$imagemGrupo = caminhoImagem($grupo->imagem ?? ($grupo->foto ?? ''), 'assets/img/foto_boynextdoor.jpg');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Grupo - <?= e($grupo->nome ?? 'Grupo') ?></title>

    <link rel="stylesheet" href="../assets/css/pg_grupo.css?v=5">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous"/>
</head>

<body class="group-info">

<div class="details-container">

    <div class="details-header">
        <a href="../index.php" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            Voltar
        </a>

        <h2 class="details-title">Detalhes do Grupo</h2>
    </div>

    <div class="group-card main-group-card">
        <div class="imagem-grupo">
            <img src="../<?= $grupo->imagem ?? $imagemGrupo ?>" alt="<?= e($grupo->nome ?? 'Grupo') ?>">
        </div>

        <div class="info-grupo">
            <h2><?= e($grupo->nome ?? '') ?></h2>
            <p><strong>Tipo:</strong> <?= e($grupo->tipo_grupo ?? '-') ?></p>
            <p><strong>Debut:</strong> <?= e($grupo->debut ?? '-') ?></p>
            <p><strong>Empresa:</strong> <?= e($grupo->empresa ?? '-') ?></p>
            <p><strong>Membros:</strong> <?= e($grupo->numero_membros ?? '-') ?></p>
        </div>
    </div>

    <div class="descricao">
        <h3>Descrição</h3>

        <div class="group-description">
            <p><?= nl2br(e($grupo->descricao ?? '')) ?></p>
        </div>
    </div>

    <div class="details-two-columns">

        <section class="mini-panel members-panel">
            <div class="mini-panel-header">
                <h3 class="mini-panel-title">
                    Membros
                </h3>

                <a href="../integrantes_crud/adicionar_membros.php?id_grupo=<?= e($id_grupo) ?>" class="btn-add-mini">
                    + Adicionar Membro
                </a>
            </div>

            <div class="mini-list">
                <?php if (empty($membros)): ?>

                    <p class="mini-empty">Nenhum membro cadastrado ainda.</p>

                <?php else: ?>

                    <?php foreach ($membros as $membro): ?>
                        <?php
                            $fotoMembro = "../" . caminhoImagem($membro->foto ?? '', 'assets/img/login/gatinho.png');
                        ?>

                        <article class="member-card">
                            <img
                                src="<?= e($fotoMembro) ?>"
                                alt="<?= e($membro->nome_artistico ?? 'Membro') ?>"
                                class="member-photo"
                            >

                            <div class="member-info">
                                <h4><?= e($membro->nome_artistico ?? '') ?></h4>

                                <p>
                                    <strong>Nome real:</strong>
                                    <?= e($membro->nome_real ?? '') ?>
                                </p>

                                <p>
                                    <strong>Função:</strong>
                                    <?= e($membro->funcao ?? '') ?>
                                </p>
                            </div>

                            <div class="mini-actions">
                                <a
                                    href="../integrantes_crud/editar_membros.php?id=<?= e($membro->id) ?>&id_grupo=<?= e($id_grupo) ?>"
                                    class="item-icon edit-icon"
                                    title="Editar membro"
                                >
                                    <i class="fa-solid fa-pencil"></i>
                                </a>

                                <a
                                    href="../integrantes_crud/excluir_membros.php?id=<?= e($membro->id) ?>&id_grupo=<?= e($id_grupo) ?>"
                                    class="item-icon delete-icon"
                                    title="Excluir membro"
                                    onclick="return confirm('Tem certeza que deseja excluir este membro?')"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>

                <?php endif; ?>
            </div>
        </section>

        <section class="mini-panel discography-panel">
            <div class="mini-panel-header">
                <h3 class="mini-panel-title">
                    Discografia
                </h3>

                <a href="../musicas_crud/adicionar_musica.php?id_grupo=<?= e($id_grupo) ?>" class="btn-add-mini">
                    + Adicionar Música
                </a>
            </div>

            <div class="mini-list">
                <?php if (empty($musicas)): ?>

                    <p class="mini-empty">Nenhuma música cadastrada ainda.</p>

                <?php else: ?>

                    <?php foreach ($musicas as $musica): ?>
                        <?php
                            $capaMusica = "../" . caminhoImagem($musica->capa ?? '', '../assets/img/teasan.jpg');
                        ?>

                        <article class="music-card">
                            <img
                                src="<?= e($capaMusica) ?>"
                                alt="<?= e($musica->titulo ?? 'Música') ?>"
                                class="music-cover"
                            >

                            <div class="music-info">
                                <h4><?= e($musica->titulo ?? '') ?></h4>

                                <?php if (!empty($musica->link_ouvir)): ?>
                                    <p>
                                        <strong>Ouvir:</strong>
                                        <a href="<?= e($musica->link_ouvir) ?>" target="_blank" rel="noopener noreferrer">
                                            Abrir música
                                        </a>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($musica->letra)): ?>
                                    <p class="music-lyrics">
                                        <strong>Letra:</strong>
                                        <?= e($musica->letra) ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="mini-actions">
                                <a
                                    href="public/musicas_crud/editar_musica.php?id=<?= e($musica->id) ?>&id_grupo=<?= e($id_grupo) ?>"
                                    class="item-icon edit-icon"
                                    title="Editar música"
                                >
                                    <i class="fa-solid fa-pencil"></i>
                                </a>

                                <a
                                    href="../musicas_crud/excluir_musica.php?id=<?= e($musica->id) ?>&id_grupo=<?= e($id_grupo) ?>"
                                    class="item-icon delete-icon"
                                    title="Excluir música"
                                    onclick="return confirm('Tem certeza que deseja excluir esta música?')"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>

                <?php endif; ?>
            </div>
        </section>
    </div>
</div>
</body>
</html>