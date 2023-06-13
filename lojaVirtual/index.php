<!DOCTYPE html>
<html>
    <!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos de compra</title>

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

</head>
    <body>
        <?php
            //Session do carrinho
            session_start();

            if(!isset($_SESSION['carrinho'])){
                $_SESSION['carrinho'] = array();
            }

            include_once './Funcoes/banco.php';
            include_once './Funcoes/carregaArquivo.php';

            $sql = "SELECT * from produto";

            //Conectar o banco
            $bd = conexao();
            $resultado = $bd->query($sql);
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
                        <a class="nav-link" style="color: white;" href="#">Carrinho</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: white;" href="carrinho.php">Carrinho</a>
                    </li>
                </ul>
            </div>
        </nav>

        <h1 style="text-align: center; margin-top: 2%; margin-bottom: 2%;">Produtos</h1>

        <div class="container-md" style="border: 1px solid black; padding: 2%; border-radius: 10px;">  
            <div class="row">

                <!-- Mostrar os produtos -->
                <?php
                    while ($dado = $resultado->fetch(PDO::FETCH_ASSOC))
                    {
                ?>

                <div class="col-sm-4">
                    <div class="card" style="width: 20rem; margin: 5%;">
                        <img class="card-img-top" src="<?=carregaImagem('res/img/'.$dado['codigo_prod'].'.jpg');?>">
                        <div class="card-body">
                            <h5 class="card-title"><?=$dado["nome_pro"]; ?></h5>
                            <p class="card-text"><?=$dado["descricao"]; ?></p>
                            <p style = "color:red; font-weight: bold;">R$ <?=$dado["valor_unitario"]; ?></p>

                            <form method="POST" action="Funcoes/Carrinho/insereCarrinho.php">
                                <input type="hidden" value="<?=$dado["codigo_prod"]; ?>" name="codProduto" id="codProduto">
                                <button type="submit" style = "width: 100%;" href="#" class="btn btn-outline-success">Comprar</button>
                            </form>

                        </div>
                    </div>
                </div>
                
                <?php
                    
                    }
                ?>
            </div>
        </div>
    </body>
</html>
