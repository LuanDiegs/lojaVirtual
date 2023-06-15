<?php
include_once '../../Funcoes/banco.php';

$codigoProduto = filter_input(INPUT_POST, "codProd");
$bd = conexao();
  
try{
    //Selecionar a imagem para deletar no diretório
    $sqlSelectImagem = "SELECT * FROM imagem WHERE codigo_prod='$codigoProduto'";
    $resultadoImagem = $bd->query($sqlSelectImagem);

    if($resultadoImagem != null){
        while($dado = $resultadoImagem->fetch(PDO::FETCH_ASSOC)){;
            if($dado != null){
                $nomeArquivo = $dado['nome_arquivo'];
                if (file_exists("../../res/img/$nomeArquivo.jpg")) {
                    unlink("../../res/img/$nomeArquivo.jpg");
                }
            }
        }
    }

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
    echo $e->getMessage();
    header("location: ../../adminProdutos.php");
    die();
}

header("location: ../../adminProdutos.php");

?>