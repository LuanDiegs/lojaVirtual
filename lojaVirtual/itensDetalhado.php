<!DOCTYPE html>
<html>
    <!DOCTYPE html>
<html>

<head>
    <?php
        //Session do carrinho
        session_start();

        include_once './Funcoes/banco.php';
        include_once './Funcoes/carregaArquivo.php';

        $codigoProd = $_GET['produto'];

        $sql = "SELECT * FROM produto WHERE codigo_prod='$codigoProd'";
        $sqlImagem = "SELECT * FROM imagem WHERE codigo_prod='$codigoProd'";
        $sqlImagemCount = "SELECT count(*) as total FROM imagem WHERE codigo_prod='$codigoProd'";


        $bd = conexao();

        //Produto
        $resultado = $bd->query($sql);
        $produto = $resultado->fetch(PDO::FETCH_ASSOC);

        //Imagem
        $resultadoImagem = $bd->query($sqlImagem);   
        
        //ImagemCount
        $resultadoImagemCount = $bd->query($sqlImagemCount);   
        $imagemCount = $resultadoImagemCount->fetch(PDO::FETCH_ASSOC);

    ?>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$produto['nome_pro']?></title>

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

    <style>
        .d-block{
            border: 1px solid black;
            border-radius: 10px;
            padding: 10px;
            height: 500px;
        }

        .carousel-control-next,
        .carousel-control-prev {
            filter: invert(100%);
        }

        .carousel .carousel-indicators li {  
            background-color: black; 
            width: 100%;
        }

    </style>

</head>
    <body>
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

        <br>

        <div class="container-md">
            <div class="row">
                <div class="col-6">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">

                            <?php
                                $slide = 0;
                                
                                while($slide < $imagemCount['total'])
                                {
                                    if($slide == 0){
                            ?>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="<?=$slide?>" class="active"></li>
                            <?php
                                    } else {
                            ?>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="<?=$slide?>"></li>
                            <?php
                                    }

                                    $slide++;
                                }
                            ?>
                        </ol>

                        <div class="carousel-inner">
                            <?php        
                                $slide = 0; 
                                while($imagem = $resultadoImagem->fetch(PDO::FETCH_ASSOC))
                                {
                                    if($slide == 0){
                                ?>
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="<?=carregaImagem('res/img/'.$imagem['nome_arquivo'].'.jpg');?>">
                                    </div>

                                <?php
                                    } else {                                   
                                ?>

                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="<?=carregaImagem('res/img/'.$imagem['nome_arquivo'].'.jpg');?>">
                                    </div>

                                <?php
                                    }

                                    $slide++;
                                }
                            ?>
                        </div>

                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>

                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <h1 style="text-align:center"><?=$produto['nome_pro']?></h1>
                    <hr>

                    <h3> Preço: <?=$produto['valor_unitario']?> </h3>
                    <h3> Estoque disponível: <?=$produto['quantidade']?> </h3>

                    <form method="POST" action="Funcoes/Carrinho/insereCarrinho.php">
                        <input type="hidden" value="<?=$produto["codigo_prod"]; ?>" name="codProduto" id="codProduto">
                        <button type="submit" style = "width: 100%;" href="#" class="btn btn-outline-success">Comprar</button>
                    </form>

                </div>
            </div>
        </div>
    </body>
</html>
