<?php
include_once '../../Funcoes/banco.php';
include_once '../../Funcoes/carregaArquivo.php';

$codigoProduto = $_GET["codProd"];
$arquivo = $_FILES["Img"];

//Guid para criar uma sequencia de caracteres que é muito dificil de se repetir
$guid = bin2hex(openssl_random_pseudo_bytes(16));
$nomeArquivo = $codigoProduto.$guid;

//Conexão
$bd = conexao();

try{
    if (carregaArquivo($arquivo)){

        moveArquivo($arquivo,"../../res/img/".$nomeArquivo.".jpg");

        $sqlImagem = "INSERT INTO imagem (
            codigo_prod,
            nome_arquivo)
        VALUES(
            '$codigoProduto',
            '$nomeArquivo')";

        $bd->query($sqlImagem);
    }

} catch (Exception $ex) {
    echo $ex->getMessage();
    header("location: ../../adminImagemProduto.php?codProd=$codigoProduto");
    die();
}

header("location: ../..//adminImagemProduto.php?codProd=$codigoProduto");

?>