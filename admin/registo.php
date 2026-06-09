<?php
session_start();
if (!isset($_SESSION['admin_esta_on'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recolher e limpar dados
    $username  = trim($_POST['username'] ?? '');
    $password  = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    // VALIDAÇÃO
    if (strlen($username) < 3) {
        $erro = 'O nome de utilizador deve ter pelo menos 3 caracteres.';
    } elseif (strlen($password) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } elseif ($password !== $password2) {
        $erro = 'As senhas não coincidem.';
    } else {
        // Verificar se o username já existe
        $consulta = $pdo->prepare("SELECT id FROM administradores WHERE username = ?");
        $consulta->execute([$username]);

        if ($consulta->fetch()) {
            $erro = 'Esse nome de utilizador já está em uso.';
        } else {
            // CRIAR a conta com a senha encriptada
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $consulta = $pdo->prepare("INSERT INTO administradores (username, password) VALUES (?, ?)");
            $consulta->execute([$username, $hash]);

            $sucesso = 'Conta criada com sucesso! Já pode fazer login.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registo Admin - MIA Social Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Criar Conta Admin</h4>
                    </div>
                    <div class="card-body">

                        <?php if ($erro): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
                        <?php endif; ?>
                        <?php if ($sucesso): ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($sucesso); ?></div>
                        <?php endif; ?>

                        <form action="registo.php" method="POST">
                            <div class="mb-3">
                                <label>Utilizador</label>
                                <input type="text" name="username" class="form-control" required minlength="3">
                            </div>
                            <div class="mb-3">
                                <label>Senha</label>
                                <input type="password" name="password" class="form-control" required minlength="6">
                            </div>
                            <div class="mb-3">
                                <label>Confirmar Senha</label>
                                <input type="password" name="password2" class="form-control" required minlength="6">
                            </div>
                            <button type="submit" class="btn btn-dark w-100">Criar conta</button>
                        </form>

                        <p class="mt-3 text-center">
                            <a href="login.php">Já tem conta? Entrar</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>