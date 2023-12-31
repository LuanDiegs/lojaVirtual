<!DOCTYPE html>
<html>
    <!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>

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
                        $codigoProduto = $dado['codigo_prod'];
                        $qtdeProduto = $dado['quantidade'];

                        $sqlImagem = "SELECT *
                            FROM imagem
                            WHERE codigo_prod='$codigoProduto'
                            ORDER BY codigo_prod DESC
                            LIMIT 1;";
                            
                        $resultadoImagem = $bd->query($sqlImagem);
                        $imagem = $resultadoImagem->fetch(PDO::FETCH_ASSOC);

                        if(is_array($imagem)){
                            $nomeArquivo = $imagem['nome_arquivo'];
                        } else {
                            $nomeArquivo = "padrao";
                        }

                        if($qtdeProduto > 0){    
                ?>

                <div class="col-sm-4">
                    <div class="card" style="width: 20rem; height: 550px; margin: 5%;">
                        <img class="card-img-top" style = "height: 300px;" src="<?=carregaImagem('res/img/'.$nomeArquivo.'.jpg');?>">
                        <div class="card-body" style="d-flex flex-column">
                            <h5 class="card-title"><?=$dado["nome_pro"]; ?></h5>
                            <p class="card-text"><?=$dado["descricao"]; ?></p>
                            <p style = "color:red; font-weight: bold;">R$ <?=$dado["valor_unitario"]; ?></p>
                        </div>
                        
                        <div class="card-footer">
                            <a href="itensDetalhado.php?produto=<?=$codigoProduto?>" style = "width: 100%;" class="btn btn-success">Detalhes</a>
                        </div>
                    </div>
                </div>
                
                <?php
                        }
                    
                    }
                ?>
            </div>
        </div>
    </body>
</html>
