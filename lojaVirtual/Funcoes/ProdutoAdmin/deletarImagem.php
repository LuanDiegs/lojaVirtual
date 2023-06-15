<?php
include_once '../../Funcoes/banco.php';

$codigoImagem = $_GET['codImg'];
$codigoProduto = $_GET['codProd'];
$bd = conexao();
  
try{
    //Selecionar a imagem para deletar no diretório
    $sqlSelectImagem = "SELECT * FROM imagem WHERE codigo_img=$codigoImagem";
    $bd->query($sqlSelectImagem);

    $dado = $bd->query($sqlSelectImagem)->fetch(PDO::FETCH_ASSOC);

    $nomeArquivo = $dado['nome_arquivo'];

    if (file_exists("../../res/img/$nomeArquivo.jpg")) {
        unlink("../../res/img/$nomeArquivo.jpg");
    }

    //Deletar as imagens do banco
    $sqlImagem = "DELETE FROM imagem WHERE codigo_img=$codigoImagem";
    $bd->query($sqlImagem);

} catch (Exception $e){

    header("location: ../../adminImagemProduto.php?codProd=$codigoProduto");
    die();
}

header("location: ../../adminImagemProduto.php?codProd=$codigoProduto");

?>