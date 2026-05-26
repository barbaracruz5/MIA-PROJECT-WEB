<?php
$host = 'localhost';
$dbname = 'mia_socialhub';
$username = 'root';  // muda para o teu user
$password = '';      // muda para a tua password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro na ligação à base de dados: " . $e->getMessage());
}
?>