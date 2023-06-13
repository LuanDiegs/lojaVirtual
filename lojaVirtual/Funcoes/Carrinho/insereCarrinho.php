<?php
    session_start();
    include_once '../banco.php';

    //Conectar o banco
    $bd = conexao();

    $codigo = filter_input(INPUT_POST, "codProduto");

    //Pegar a quantidade do produto
    $sqlProduto = "SELECT quantidade FROM produto WHERE codigo_prod='$codigo'";
    $resultado = $bd->query($sqlProduto);
    $dado = $resultado->fetch(PDO::FETCH_ASSOC);

    $quantidadeProd = $dado['quantidade'];

    //Coloca na session
    if($codigo != null){
        if(!empty($_SESSION['carrinho'])){

            $prod = array_column($_SESSION['carrinho'], 'cod_prod');

            $quantidadeNoCarrinho = $_SESSION['carrinho'][$codigo]['qt'];

            if (in_array($codigo, $prod) && $quantidadeNoCarrinho < $quantidadeProd) {

                $_SESSION['carrinho'][$codigo]['qt'] += 1;

            } else if(!in_array($codigo, $prod)) {

                $item = [
                    'cod_prod' => $codigo,
                    'qt' => 1
                ];

                $_SESSION['carrinho'][$codigo] = $item;
            }

        } else {

            $item = [
                'cod_prod' => $codigo,
                'qt' => 1
            ];

            $_SESSION['carrinho'][$codigo] = $item;
        }
    }

    foreach ($_SESSION['carrinho'] as $carrinho) :
    endforeach;

    header("Location: ../../carrinho.php")
?>