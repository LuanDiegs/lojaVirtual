<?php
    session_start();
    include_once '../banco.php';

    //Conectar o banco
    $bd = conexao();
    $dataAtual = date('Y-m-d');

    $cpf = $_GET["cliente"];
    $valorTotal = $_GET["valorTotal"];
    $valorFrete = $_GET["valorFrete"];

    try{
        //Pega o item para pegar o valor
        $sqlInsert = 
        "insert into compra 
            (data, valor_comissao, valor_transporte, cpf_cnpj_vend, cpf_cnpj_transp, cpf_cnpj_cli)
        values 
            ('$dataAtual', $valorTotal, $valorFrete, '62.725.446/0001-30', '16.056.574/0001-11', '$cpf')";

        $resultado = $bd->query($sqlInsert);
        echo $sqlInsert;

    }catch (Exception $ex) {
        echo $ex->getMessage();
        header("location: ../../index.php");
        die();
    }

    header("location: ./inserirItensPedido.php");
;?>