<?php
session_start();
if (!isset($_SESSION['admin_esta_on'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/database.php';

$mensagem = '';

// ----------------- UPDATE: marcar como lida / não lida -----------------
if (isset($_GET['marcar_lida'])) {
    $stmt = $pdo->prepare("UPDATE mensagens_contacto SET lida = 1 WHERE id = ?");
    $stmt->execute([$_GET['marcar_lida']]);
    $mensagem = 'Mensagem marcada como lida.';
}

// ----------------- DELETE -----------------
if (isset($_GET['apagar'])) {
    $stmt = $pdo->prepare("DELETE FROM mensagens_contacto WHERE id = ?");
    $stmt->execute([$_GET['apagar']]);
    $mensagem = 'Mensagem apagada.';
}

// ----------------- READ com JOIN -----------------
// LEFT JOIN: traz a mensagem MESMO que não tenha serviço associado
$stmt = $pdo->query("
    SELECT m.*, s.titulo AS servico_titulo
    FROM mensagens_contacto m
    LEFT JOIN servicos s ON m.servico_id = s.id
    ORDER BY m.data_envio DESC
");
$mensagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Mensagens de Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Mensagens de Contacto</span>
        <a href="dashboard.php" class="btn btn-light btn-sm">Voltar ao painel</a>
    </div>
</nav>

<div class="container mt-4">

    <?php if ($mensagem): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Estado</th><th>Nome</th><th>Email</th><th>Serviço</th>
                <th>Mensagem</th><th>Data</th><th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mensagens as $m): ?>
            <tr class="<?php echo $m['lida'] ? '' : 'table-warning'; ?>">
                <td><?php echo $m['lida'] ? 'Lida' : 'Nova'; ?></td>
                <td><?php echo htmlspecialchars($m['nome']); ?></td>
                <td><?php echo htmlspecialchars($m['email']); ?></td>
                <td><?php echo htmlspecialchars($m['servico_titulo'] ?? '—'); ?></td>
                <td><?php echo htmlspecialchars($m['mensagem']); ?></td>
                <td><?php echo htmlspecialchars($m['data_envio']); ?></td>
                <td>
                    <?php if (!$m['lida']): ?>
                        <a href="mensagens.php?marcar_lida=<?php echo $m['id']; ?>" class="btn btn-sm btn-success">Marcar lida</a>
                    <?php endif; ?>
                    <a href="mensagens.php?apagar=<?php echo $m['id']; ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Apagar esta mensagem?');">Apagar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
</body>
</html>
