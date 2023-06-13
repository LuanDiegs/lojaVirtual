<?php
include_once '../../Funcoes/banco.php';

$codigoProduto = filter_input(INPUT_POST, "codProd");
$bd = conexao();
  
try{

    //Deletar as imagens
    $sqlImagem = "DELETE FROM imagem WHERE codigo_prod='$codigoProduto'";
    $bd->query($sqlImagem);

    //Deletar o itemCompra
    $sqlItemCompra = "DELETE FROM itemcompra WHERE codigo_prod='$codigoProduto'";
    $bd->query($sqlItemCompra);

    // Deletar o produto
    $sqlProduto = "DELETE FROM produto WHERE codigo_prod='$codigoProduto'";
    $bd->query($sqlProduto);

} catch (Exception $e){

   //header("location: ../../moeda.php");
   die();
}

header("location: ../../index.php");

?>