<?php
require_once '../../src/config/database.php';
require_once '../../src/includes/auth.php';

if (!isset($_GET['id']) || !isset($_GET['id_grupo'])) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'];
$id_grupo = $_GET['id_grupo'];

$stmt = $pdo->prepare("SELECT * FROM integrantes WHERE id = ?");
$stmt->execute([$id]);
$membro = $stmt->fetch(PDO::FETCH_OBJ);

if (!$membro) {
    header("Location: ../crud_grupos/grupo.php?id_grupo=" . urlencode($id_grupo));
    exit;
}

$funcaoAtual = strtolower($membro->funcao ?? '');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Membro</title>
    <link rel="stylesheet" href="../assets/css/pg_criar.css?v=10">
</head>

<body class="form-page">

    <div class="form-container">

        <h1 class="form-title">Editar Membro</h1>

        <form action="processar_update_membros.php" method="POST" enctype="multipart/form-data" class="grupo-form">

            <input type="hidden" name="id" value="<?= htmlspecialchars($membro->id) ?>">
            <input type="hidden" name="id_grupo" value="<?= htmlspecialchars($id_grupo) ?>">

            <div class="form-group">
                <label for="nome_real">Nome real:</label>
                <input 
                    type="text" 
                    id="nome_real" 
                    name="nome_real" 
                    value="<?= htmlspecialchars($membro->nome_real) ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="nome_artistico">Nome artístico:</label>
                <input 
                    type="text" 
                    id="nome_artistico" 
                    name="nome_artistico" 
                    value="<?= htmlspecialchars($membro->nome_artistico) ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="aniversario">Data de nascimento:</label>
                <input 
                    type="date" 
                    id="aniversario" 
                    name="aniversario" 
                    value="<?= htmlspecialchars($membro->aniversario) ?>"
                >
            </div>

            <div class="form-group">
                <label for="funcao">Função:</label>
                <select id="funcao" name="funcao" required>
                    <option value="" disabled>Selecione a função</option>

                    <option value="Vocalista" <?= $funcaoAtual == 'vocalista' ? 'selected' : '' ?>>
                        Vocalista
                    </option>

                    <option value="Dançarino" <?= $funcaoAtual == 'dançarino' ? 'selected' : '' ?>>
                        Dançarino
                    </option>

                    <option value="Compositor" <?= $funcaoAtual == 'compositor' ? 'selected' : '' ?>>
                        Compositor
                    </option>

                    <option value="Rapper" <?= $funcaoAtual == 'rapper' ? 'selected' : '' ?>>
                        Rapper
                    </option>

                    <option value="Líder" <?= $funcaoAtual == 'líder' || $funcaoAtual == 'lider' ? 'selected' : '' ?>>
                        Líder
                    </option>

                    <option value="Visual" <?= $funcaoAtual == 'visual' ? 'selected' : '' ?>>
                        Visual
                    </option>

                    <option value="Maknae" <?= $funcaoAtual == 'maknae' ? 'selected' : '' ?>>
                        Maknae
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="biografia">Biografia:</label>
                <textarea 
                    id="biografia" 
                    name="biografia" 
                    placeholder="Fale um pouco sobre o integrante..."
                ><?= htmlspecialchars($membro->biografia) ?></textarea>
            </div>

            <div class="form-group">
                <label for="foto">Foto do membro:</label>

                <label for="foto" class="upload-box">
                    <span class="upload-icon">☁</span>
                    <span class="upload-title">Clique para enviar</span>
                    <span class="upload-subtitle">uma nova imagem do integrante</span>
                </label>

                <input 
                    type="file" 
                    id="foto" 
                    name="foto" 
                    class="input-file" 
                    accept="image/*"
                >

                <?php if (!empty($membro->foto)): ?>
                    <small class="form-hint">Foto atual cadastrada. Envie outra apenas se quiser trocar.</small>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <a href="../crud_grupos/grupo.php?id_grupo=<?= htmlspecialchars($id_grupo) ?>" class="btn-cancel">
                    Cancelar
                </a>

                <button type="submit" class="btn-save">
                    Salvar Integrante
                </button>
            </div>

        </form>

    </div>

</body>
</html>