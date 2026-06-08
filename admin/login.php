<?php
session_start();

if (isset($_SESSION['admin_esta_on'])) {
    header('Location: dashboard.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/database.php';

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM administradores WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_esta_on'] = true;
        $_SESSION['admin_nome'] = $admin['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $erro = 'Utilizador ou senha inválidos!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - MIA Social Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header admin_login_header">
                        <h4 class="mb-0 big_title">Bem-vinda, Mia</h4>
                    </div>
                    <div class="card-body">

                        <?php if($erro): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
                        <?php endif; ?>

                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <label>Utilizador</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Senha</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="mia_button w-100">Entrar</button>
                        </form>

                        <p class="mt-3 text-center">
                            <a href="registo.php">Criar nova conta</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>