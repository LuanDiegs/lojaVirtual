<?php
    session_start();
    include_once '../banco.php';

    //Conectar o banco
    $bd = conexao();
    
    $cpf = filter_input(INPUT_POST, "cpf");
    $nome = filter_input(INPUT_POST, "nome");
    $numero = filter_input(INPUT_POST, "nro");
    $cep = filter_input(INPUT_POST, "cep");
    $bairro = filter_input(INPUT_POST, "bairro");
    $cidade = filter_input(INPUT_POST, "cidade");
    $estado = filter_input(INPUT_POST, "estado");
    $rua = filter_input(INPUT_POST, "rua");

    $valorTotal = $_GET["valorTotal"];
    $valorFrete = $_GET["valorFrete"];

    if($cpf != null){
        try{
            $sqlInsert = 
            "INSERT IGNORE INTO cliente 
                (cpf_cnpj_cli, nome_cli, numero_cli, bairro_cli, cidade_cli, cep_cli, estado_cli, endereco_cli)
            VALUES 
                ('$cpf', '$nome', '$numero', '$bairro', '$cidade', '$cep', '$estado', '$rua')";

            $resultado = $bd->query($sqlInsert);

        }catch (Exception $ex) {
            echo $ex->getMessage();
            header("location: ../../index.php");
        }

        header("location: ./inserirPedido.php?cliente=$cpf&valorTotal=$valorTotal&valorFrete=$valorFrete");
    } else {
        header("location: ../../index.php");
    }
?>