<?php
include_once '../../Funcoes/banco.php';
include_once '../../Funcoes/carregaArquivo.php';

$codigo = filter_input(INPUT_POST, "CodProd");
$nomeProd = filter_input(INPUT_POST, "NmProd");
$desc = filter_input(INPUT_POST, "Desc");
$vlUnit = filter_input(INPUT_POST, "VlUnit");
$qtde = filter_input(INPUT_POST, "Qtde");
$peso = filter_input(INPUT_POST, "Peso");
$dimens = filter_input(INPUT_POST, "Dimens");
$unidVenda = filter_input(INPUT_POST, "UnidVend");
$arquivo = $_FILES["Img"];

//Guid para criar uma sequencia de caracteres que é muito dificil de se repetir
$guid = bin2hex(openssl_random_pseudo_bytes(16));
$nomeArquivo = $codigo.$guid;

//Conexão
$bd = conexao();

if($peso == null){
    $peso = "null";
}
if($dimens == null){
    $dimens = "null";
}
if($unidVenda == null){
    $unidVenda = "null";
}

try{
    //Conectar o banco e fazer o insert
    $sql = "INSERT INTO produto (
        codigo_prod,
        nome_pro,
        descricao,
        valor_unitario,
        quantidade,
        peso,
        dimensoes,
        unidade_venda)
        VALUES(
        '$codigo', 
        '$nomeProd',
        '$desc',
        $vlUnit,
        $qtde,
        $peso,
        $dimens,
        $unidVenda)";
    $bd->query($sql);

} catch (Exception $ex) {
    echo $ex->getMessage();
    header("location: ../../adminProdutos.php");
    die();
}

try{
    if (carregaArquivo($arquivo)){

        moveArquivo($arquivo,"../../res/img/".$nomeArquivo.".jpg");

        $sqlImagem = "INSERT INTO imagem (
            codigo_prod,
            nome_arquivo)
        VALUES(
            '$codigo',
            '$nomeArquivo')";

        $bd->query($sqlImagem);

    } else {
        throw new Exception('Não foi possível inserir uma imagem');
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
    header("location: ../../adminProdutos.php");
    die();
}

header("location: ../../adminProdutos.php");

?>