<?php
session_start();
if (!isset($_SESSION['admin_esta_on'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/database.php';

// Contar mensagens não lidas
$consulta = $pdo->query("SELECT COUNT(*) as total FROM mensagens_contacto WHERE lida = 0");
$msg_nao_lidas = $consulta->fetch()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - MIA Social Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar admin_navbar">
        <div class="container">
            <span class="navbar-brand big_title">Painel Administrativo</span>
            <div>
                <span class="text-white me-3">Olá, <?php echo htmlspecialchars($_SESSION['admin_nome']); ?></span>
                <a href="logout.php" class="mia_button">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row cards_column">
            <div class="col-md-4 mb-3">
                <div class="card admin_card_dark card_hover h-100">
                    <div class="card-body">
                        <h5 class="card-title">Mensagens</h5>
                        <h2><?php echo $msg_nao_lidas; ?></h2>
                        <p>não lidas</p>
                        <a href="mensagens.php" class="mia_button">Ver mensagens</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card admin_card card_hover h-100">
                    <div class="card-body">
                        <h5 class="card-title">Serviços</h5>
                        <p>Gerir pacotes de serviços</p>
                        <a href="gerir_servicos.php" class="mia_button">Gerir serviços</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>