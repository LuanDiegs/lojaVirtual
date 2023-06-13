<?php
include_once '../banco.php';


//Conectar o banco
$bd = conexao();

session_start();

if (isset($_GET['cod'])) {

  $cod = $_GET['cod'];

  //Pegar a quantidade do produto
  $sqlProduto = "SELECT quantidade FROM produto WHERE codigo_prod='$cod'";
  $resultado = $bd->query($sqlProduto);
  $dado = $resultado->fetch(PDO::FETCH_ASSOC);

  $quantidadeProd = $dado['quantidade'];

  $coluna = array_column($_SESSION['carrinho'], 'cod_prod');

  //Quantidade no carrinho
  $quantidadeNoCarrinho = $_SESSION['carrinho'][$cod]['qt'];

  if (in_array($cod, $coluna) && $_GET['operacao'] == "mais" && $quantidadeNoCarrinho < $quantidadeProd) {

    $_SESSION['carrinho'][$cod]['qt'] +=1;

  } else if (in_array($cod, $coluna) && $_GET['operacao'] == "menos"){

    $_SESSION['carrinho'][$cod]['qt'] -=1;

    if($_SESSION['carrinho'][$cod]['qt'] == 0){
      unset($_SESSION['carrinho'][$cod]);
    }

  }

  header("location: ../../carrinho.php");

}