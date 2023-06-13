<?php
    session_start();
    
    if (isset($_GET['cod'])) {

        $codProd = $_GET['cod'];

        unset($_SESSION['carrinho'][$codProd]);

        header("location: ../../carrinho.php");
    }

    header("location: ../../carrinho.php");
;?>