<?php

if (isset($_GET['p'])) {
    $p = $_GET['p'];
    include("pages/$p.php");
} else {
    include("pages/inicio.php");
}

?>