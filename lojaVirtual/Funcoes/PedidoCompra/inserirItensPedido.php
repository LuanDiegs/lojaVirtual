<?php
    session_start();
    include_once '../banco.php';

    //Conectar o banco
    $bd = conexao();
    
    if(isset($_SESSION['carrinho'])){
        try{
            foreach($_SESSION['carrinho'] as $carrinho){
                $codigo = $carrinho['cod_prod'];

                //Pega o item para pegar o valor
                $sqlItens = "SELECT * FROM produto WHERE codigo_prod='$codigo'";
                $resultadoItem = $bd->query($sqlItens);
                $dadoItem = $resultadoItem->fetch(PDO::FETCH_ASSOC);

                //Dados para inserção
                $quantidade = $carrinho['qt'];
                $valorUnitario = $dadoItem['valor_unitario'];
                $valorTotal = $quantidade * $valorUnitario;

                //Procura o último pedido de venda criado
                $sqlCompra = "SELECT * FROM compra ORDER BY numero_compra DESC LIMIT 1";

                $resultadoCompra = $bd->query($sqlCompra);
                $dado = $resultadoCompra->fetch(PDO::FETCH_ASSOC);
                $codigoCompra = $dado['numero_compra'];

                //Conectar o banco e fazer o update
                $sql = "INSERT INTO itemcompra 
                VALUES (
                    $codigoCompra,
                    '$codigo',
                    $valorTotal, 
                    $quantidade
                )";

                $bd->query($sql);

                //Atualiza a quantidade dos itens no carrinho
                $sqlItensUpdate = "UPDATE produto SET quantidade=quantidade-$quantidade WHERE codigo_prod='$codigo'";
                $bd->query($sqlItensUpdate);
            }
        }catch (Exception $ex) {

            header("location: ../../index.php");
            die();
        }

        unset($_SESSION['carrinho']);
        unset($_SESSION['frete']);

        header("location: ../../danfe.php?codCompra=$codigoCompra");
    }
;?>