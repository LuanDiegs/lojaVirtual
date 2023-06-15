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
    $sql = "UPDATE produto 
        SET
        nome_pro='$nomeProd',
        descricao='$desc',
        valor_unitario=$vlUnit,
        quantidade=$qtde,
        peso=$peso,
        dimensoes='$dimens',
        unidade_Venda='$unidVenda'
        WHERE
        codigo_prod='$codigo'";
    $bd->query($sql);

} catch (Exception $ex) {
    echo $ex->getMessage();
    header("location: ../../adminProdutos.php");
    die();
}

header("location: ../../adminProdutos.php");

?>