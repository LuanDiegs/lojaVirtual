<?php
session_start();
if (isset($_GET['cod'])) {

  $cod = $_GET['cod'];
  $coluna = array_column($_SESSION['carrinho'], 'cod_prod');

  if (in_array($_GET['cod'], $coluna) && $_GET['operacao'] == "mais") {

    $_SESSION['carrinho'][$cod]['qt'] +=1;

  } else {

    $_SESSION['carrinho'][$cod]['qt'] -=1;

    if($_SESSION['carrinho'][$cod]['qt'] == 0){
      unset($_SESSION['carrinho'][$cod]);
    }

  }

  header("location: ../../carrinho.php");

}