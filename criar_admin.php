<?php
require_once 'config/database.php';

$username = 'mia';
$password = password_hash('admin123', PASSWORD_DEFAULT); // muda depois

$stmt = $pdo->prepare("INSERT INTO administradores (username, password) VALUES (?, ?)");
$stmt->execute([$username, $password]);

echo "Admin criado! Apaga este ficheiro agora.";
?>