<?php
session_start();
if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/database.php';

// Contar mensagens não lidas
$stmt = $pdo->query("SELECT COUNT(*) as total FROM mensagens_contacto WHERE lida = 0");
$msg_nao_lidas = $stmt->fetch()['total'];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - MIA Social Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand">Painel Administrativo</span>
            <div>
                <span class="text-white me-3">Olá, <?php echo $_SESSION['admin_nome']; ?></span>
                <a href="logout.php" class="btn btn-danger btn-sm">Sair</a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Mensagens</h5>
                        <h2><?php echo $msg_nao_lidas; ?></h2>
                        <p>não lidas</p>
                        <a href="mensagens.php" class="btn btn-light">Ver mensagens</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Serviços</h5>
                        <p>Gerir pacotes de serviços</p>
                        <a href="gerir_servicos.php" class="btn btn-light">Gerir serviços</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>