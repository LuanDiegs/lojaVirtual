<?php
    session_start();
    include_once '../banco.php';

    //Conectar o banco
    $bd = conexao();
    $dataAtual = date('Y-m-d');

    $cpf = $_GET["cliente"];
    $valorTotal = $_GET["valorTotal"];
    $valorFrete = $_GET["valorFrete"];
    $transportadora = $_GET["trans"];

    try{
        //Insere o pedido, temos apenas um vendedor, que vai ser nosso vendedor padrão
        $sqlInsert = 
        "insert into compra 
            (data, valor_comissao, valor_transporte, cpf_cnpj_vend, cpf_cnpj_transp, cpf_cnpj_cli)
        values 
            ('$dataAtual', $valorTotal, $valorFrete, '62.725.446/0001-30', '$transportadora', '$cpf')";

        $resultado = $bd->query($sqlInsert);
        echo $sqlInsert;

    }catch (Exception $ex) {
        echo $ex->getMessage();
        header("location: ../../index.php");
        die();
    }

    header("location: ./inserirItensPedido.php");
;?>