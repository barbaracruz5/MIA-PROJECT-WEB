<?php
$p = isset($_GET['p']) ? $_GET['p'] : 'inicio';

$paginas_validas = ['inicio', 'quemSou', 'comoTrabalho', 'servicos', 'portfolio', 'contacto'];
if (!in_array($p, $paginas_validas)) {
    $p = '404';
}

include 'pages/content/head.php';
include 'pages/content/header.php';

if ($p === '404') {
    include 'pages/404.php';
} else {
    include "pages/$p.php";
}

include 'pages/content/footer.php';
?>