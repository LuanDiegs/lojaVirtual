<!DOCTYPE html>
<html>
    <!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do pedido</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Mascara JQUERY -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

</head>
    <body>
        <?php
            include_once './Funcoes/banco.php';
            include_once './Funcoes/carregaArquivo.php';

            $codigoCompra = $_GET['codCompra'];

            //Conectar o banco
            $bd = conexao();

            $sqlPedido = "SELECT c.numero_compra,
                c.data,
                c.valor_comissao,
                c.valor_transporte,
                t.nome_tras as transportadora,
                v.nome_vend as vendedor,
                cli.nome_cli as cliente
                FROM compra c 
                INNER JOIN transportadora t ON c.cpf_cnpj_transp  = t.cpf_cnpj_transp 
                INNER JOIN vendedor v ON c.cpf_cnpj_vend  = v.cpf_cnpj_vend  
                INNER JOIN cliente cli ON c.cpf_cnpj_cli   = cli.cpf_cnpj_cli   
                WHERE numero_compra=$codigoCompra";

            $resultadoPedido = $bd->query($sqlPedido);
            $dadoPedido = $resultadoPedido->fetch(PDO::FETCH_ASSOC);

            $sqlItensPedido = "SELECT 
                p.nome_pro,
                p.valor_unitario as valor_uni, 
                ic.quantidade
            FROM itemcompra ic
            INNER JOIN produto p ON ic.codigo_prod  = p.codigo_prod 
            WHERE numero_compra=$codigoCompra";

            $resultadoItemPedido = $bd->query($sqlItensPedido);

        ?>

        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: black; color: white;">
            <a class="navbar-brand" style="color: white;">Lojinham da FATEC</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav" >
                <ul class="navbar-nav">
                <li class="nav-item active">
                        <a class="nav-link" style="color: white;" href="index.php">Produtos </span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: white;" href="carrinho.php">Carrinho</a>
                    </li>
                </ul>
            </div>
        </nav>

        <h1 style="text-align: center; margin-top: 2%; margin-bottom: 2%;">Detalhes do pedido <?=$dadoPedido['numero_compra']?></h1>

        <div class="container" style="border: 1px solid black; border-radius: 5px">
            <p style="margin: 10px 0px 0px 0px;"> Pedido nro: <?=$dadoPedido['numero_compra']?></p>
            <hr style="margin-top: 1px;">
            <p style="margin: 10px 0px 0px 0px;"> Data de emissão: <?=databr($dadoPedido['data'])?></p>
            <hr style="margin-top: 1px;">
            <p style="margin: 10px 0px 0px 0px;"> Valor total: R$ <?=$dadoPedido['valor_comissao']?></p>
            <hr style="margin-top: 1px;">
            <p style="margin: 10px 0px 0px 0px;"> Valor do frete: R$ <?=$dadoPedido['valor_transporte']?></p>
            <hr style="margin-top: 1px;">
            <p style="margin: 10px 0px 0px 0px;"> Transportadora responsável: <?=$dadoPedido['transportadora']?></p>
            <hr style="margin-top: 1px;">
            <p style="margin: 10px 0px 0px 0px;"> Vendedor responsável: <?=$dadoPedido['vendedor']?></p>
            <hr style="margin-top: 1px;">
            <p style="margin: 10px 0px 0px 0px;"> Cliente: <?=$dadoPedido['cliente']?></p>
            <hr style="margin-top: 1px;">

            <h3 style="text-align: center"> Itens do pedido </h3>
            <?php
                while($dadoItemPedido = $resultadoItemPedido->fetch(PDO::FETCH_ASSOC)){
            ?>
                <div style="border: 1px solid black; border-radius: 10px; margin: 10px 10px 10px 10px; padding: 10px 10px 10px 10px">
                    <h4 style="text-align:center;"><?=$dadoItemPedido['nome_pro']?></h4>
                    <p style="margin: 10px 0px 0px 0px;"> Quantidade: <?=$dadoItemPedido['quantidade']?></p>
                    <hr style="margin-top: 1px;">
                    <p style="margin: 10px 0px 0px 0px;"> Valor unitário: R$ <?=$dadoItemPedido['valor_uni']?></p>
                    <hr style="margin-top: 1px;">
                    <p style="margin: 10px 0px 0px 0px;"> Valor total do produto: R$ <?=$dadoItemPedido['valor_uni'] * $dadoItemPedido['quantidade']?></p>
                    <hr style="margin-top: 1px;">
                </div>
            <?php
                };

            ?>

        <a href="index.php" style="width: 98%; margin: 10px 10px 10px 10px" class="btn btn-success">Avançar</a>

        </div>

    </body>
</html>
