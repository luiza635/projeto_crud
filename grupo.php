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
    <link rel="stylesheet" href="assets/css/pg_grupo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <main>
        <div class="container-detalhes">

            <div class="topo">
                <a href="index.php" class="btn-voltar"> <i class="fa-solid fa-arrow-left"></i> Voltar</a>
                <h1 class="titulo">Detalhes do Grupo</h1>
            </div>

            <div class="card-grupo">

                <div class="imagem-grupo">
                    <img src="assets/img/foto_boynextdoor.jpg" alt="<?= $grupo->nome; ?>">
                </div>

                <div class="info-grupo">
                    <h2><?= $grupo->nome; ?> <span>♡</span></h2>

                    <p><strong>Tipo:</strong> <?= $grupo->tipo_grupo; ?></p>

                    <p><strong>Debut:</strong> <?= $grupo->debut; ?></p>

                    <p><strong>Empresa:</strong> <?= $grupo->empresa; ?></p>

                    <p><strong>Membros:</strong> <?= $grupo->numero_membros; ?></p>
                </div>

            </div>

            <div class="descricao">
                <h3>Descrição</h3>

                <div class="box-descricao">
                    <p><?= $grupo->descricao; ?></p>
                </div>
            </div>

        </div>
        <div class="container-detalhes">
            <div>
                <h2>Membros</h2>
                <a href="integrantes_crud/adicionar_membros.php?id_grupo=<?= $id_grupo; ?>">Adicionar Membro</a>
            </div>
            <div>
                <?php foreach ($membros as $membro): ?>
                    <div>
                        <div>
                            <img src="" alt="">
                        </div>
                        <div>
                            <img src="assets/img/teasan.jpg" alt="" srcset="">
                            <p><strong>Nome Artistico:</strong> <?= $membro->nome_artistico; ?></p>
                            <p><strong>Nome real:</strong> <?= $membro->nome_real; ?></p>
                            <p><strong>Função:</strong> <?= $membro->funcao; ?></p>
                            <a href="integrantes_crud/editar_membros.php?id=<?= $membro->id; ?>&id_grupo=<?= $id_grupo; ?>">Editar</a>
                            <a href="integrantes_crud/excluir_membros.php?id=<?= $membro->id; ?>&id_grupo=<?= $id_grupo; ?>">Excluir</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div>
                <h2>Discografia</h2>
                <p>Lista de álbuns e singles do grupo.</p>
                <a href="musicas_crud/adicionar_musica.php?id_grupo=<?= $id_grupo; ?>">Adicionar Música</a>
            </div>
            <div>
                <?php foreach ($musicas as $musica): ?>
                    <div>
                        <div>
                            <img src="assets/img/teasan.jpg" alt="" srcset="">
                        </div>
                        <div>
                            <p><strong>Nome:</strong> <?= $musica->titulo; ?></p>
                            <p><strong>Ouvir:</strong> <?= $musica->link_ouvir; ?></p>
                            <p><strong>Letra:</strong> <?= $musica->letra; ?></p>
                            <a href="musicas_crud/editar_musica.php?id=<?= $musica->id; ?>&id_grupo=<?= $id_grupo; ?>">Editar</a>
                            <a href="musicas_crud/excluir_musica.php?id=<?= $musica->id; ?>&id_grupo=<?= $id_grupo; ?>">Excluir</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>
</html>