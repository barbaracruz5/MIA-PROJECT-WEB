<?php
session_start();

if (!isset($_SESSION['admin_esta_on'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/database.php';

$mensagem = ''; // feedback para o utilizador

// ----------------- CREATE e UPDATE (formulário enviado) -----------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    // Recolher e limpar os dados do formulário
    $id            = $_POST['id'] ?? '';
    $titulo        = trim($_POST['titulo']);
    $subtitulo     = trim($_POST['subtitulo']);
    $preco         = trim($_POST['preco']);
    $descricao     = trim($_POST['descricao']);
    $caracteristicas = trim($_POST['caracteristicas']);
    $botao_texto   = trim($_POST['botao_texto']);
    $ativo         = isset($_POST['ativo']) ? 1 : 0;
    $ordem         = (int) $_POST['ordem'];

    // Validação simples
    if ($titulo === '') {
        $mensagem = 'O título é obrigatório.';
    } else {
        if ($id === '') {
            // CREATE: não há id, logo é um serviço novo -> INSERT
            $stmt = $pdo->prepare("INSERT INTO servicos 
                (titulo, subtitulo, preco, descricao, caracteristicas, botao_texto, ativo, ordem)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$titulo, $subtitulo, $preco, $descricao, $caracteristicas, $botao_texto, $ativo, $ordem]);
            $mensagem = 'Serviço criado com sucesso!';
        } else {
            // UPDATE: já existe id -> atualizar
            $stmt = $pdo->prepare("UPDATE servicos SET 
                titulo=?, subtitulo=?, preco=?, descricao=?, caracteristicas=?, botao_texto=?, ativo=?, ordem=?
                WHERE id=?");
            $stmt->execute([$titulo, $subtitulo, $preco, $descricao, $caracteristicas, $botao_texto, $ativo, $ordem, $id]);
            $mensagem = 'Serviço atualizado com sucesso!';
        }
    }
}

// ----------------- DELETE -----------------
if (isset($_GET['apagar'])) {
    $stmt = $pdo->prepare("DELETE FROM servicos WHERE id = ?");
    $stmt->execute([$_GET['apagar']]);
    $mensagem = 'Serviço apagado.';
}

// ----------------- Se for para EDITAR, buscar os dados desse serviço -----------------
$editar = null;
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare("SELECT * FROM servicos WHERE id = ?");
    $stmt->execute([$_GET['editar']]);
    $editar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// ----------------- READ: listar todos os serviços -----------------
$stmt = $pdo->query("SELECT * FROM servicos ORDER BY ordem ASC");
$servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerir Serviços</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Gerir Serviços</span>
        <a href="dashboard.php" class="btn btn-light btn-sm">Voltar ao painel</a>
    </div>
</nav>

<div class="container mt-4">

    <?php if ($mensagem): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>

    <!-- FORMULÁRIO (serve para criar OU editar) -->
    <div class="card mb-4">
        <div class="card-header">
            <?php echo $editar ? 'Editar serviço' : 'Novo serviço'; ?>
        </div>
        <div class="card-body">
            <form method="POST" action="gerir_servicos.php">
                <!-- campo escondido: se estamos a editar, leva o id -->
                <input type="hidden" name="id" value="<?php echo $editar['id'] ?? ''; ?>">

                <div class="mb-2">
                    <label>Título *</label>
                    <input type="text" name="titulo" class="form-control" required
                           value="<?php echo htmlspecialchars($editar['titulo'] ?? ''); ?>">
                </div>
                <div class="mb-2">
                    <label>Subtítulo</label>
                    <input type="text" name="subtitulo" class="form-control"
                           value="<?php echo htmlspecialchars($editar['subtitulo'] ?? ''); ?>">
                </div>
                <div class="mb-2">
                    <label>Preço</label>
                    <input type="text" name="preco" class="form-control"
                           value="<?php echo htmlspecialchars($editar['preco'] ?? ''); ?>">
                </div>
                <div class="mb-2">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control"><?php echo htmlspecialchars($editar['descricao'] ?? ''); ?></textarea>
                </div>
                <div class="mb-2">
                    <label>Características (separadas por | )</label>
                    <input type="text" name="caracteristicas" class="form-control"
                           value="<?php echo htmlspecialchars($editar['caracteristicas'] ?? ''); ?>"
                           placeholder="Item 1|Item 2|Item 3">
                </div>
                <div class="mb-2">
                    <label>Texto do botão</label>
                    <input type="text" name="botao_texto" class="form-control"
                           value="<?php echo htmlspecialchars($editar['botao_texto'] ?? 'Reservar'); ?>">
                </div>
                <div class="mb-2">
                    <label>Ordem</label>
                    <input type="number" name="ordem" class="form-control"
                           value="<?php echo htmlspecialchars($editar['ordem'] ?? 0); ?>">
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="ativo" class="form-check-input" id="ativo"
                           <?php echo (!$editar || $editar['ativo']) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="ativo">Ativo (visível no site)</label>
                </div>

                <button type="submit" name="guardar" class="btn btn-dark">
                    <?php echo $editar ? 'Guardar alterações' : 'Criar serviço'; ?>
                </button>
                <?php if ($editar): ?>
                    <a href="gerir_servicos.php" class="btn btn-secondary">Cancelar</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- TABELA com todos os serviços -->
    <table class="table table-striped">
        <thead>
            <tr><th>Título</th><th>Preço</th><th>Ativo</th><th>Ações</th></tr>
        </thead>
        <tbody>
            <?php foreach ($servicos as $s): ?>
            <tr>
                <td><?php echo htmlspecialchars($s['titulo']); ?></td>
                <td><?php echo htmlspecialchars($s['preco']); ?></td>
                <td><?php echo $s['ativo'] ? 'Sim' : 'Não'; ?></td>
                <td>
                    <a href="gerir_servicos.php?editar=<?php echo $s['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                    <a href="gerir_servicos.php?apagar=<?php echo $s['id']; ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Tens a certeza que queres apagar?');">Apagar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
</body>
</html>