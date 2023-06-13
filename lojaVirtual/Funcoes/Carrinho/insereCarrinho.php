<?php
    session_start();
    include_once '../banco.php';


    $codigo = filter_input(INPUT_POST, "codProduto");

    $_SESSION['a'] = $codigo;

    //Coloca na session
    if($codigo != null){
        if(!empty($_SESSION['carrinho'])){

            $prod = array_column($_SESSION['carrinho'], 'cod_prod');

            if (in_array($codigo, $prod)) {

                $_SESSION['carrinho'][$codigo]['qt'] += 1;

            } else {

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
        echo "|| Item: " . $carrinho['cod_prod'] . " " . $carrinho['qt'];
    endforeach;

    header("Location: ../../index.php")
?>