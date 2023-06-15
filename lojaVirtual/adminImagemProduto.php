<!DOCTYPE html>
<html lang="pt-br">

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

    <?php 
        include_once './Funcoes/banco.php';
        include_once './Funcoes/carregaArquivo.php';

        $codigoProduto = $_GET['codProd'];

        //Conectar o banco
        $bd = conexao();

        //Conexão lista itens
        $sqlImagens = "SELECT * FROM imagem WHERE codigo_prod='$codigoProduto'";
        $resultadoImagem = $bd->query($sqlImagens);
    ?>

    <span style="text-align: center;">
        <h1 style="margin: 25px 0px 25px 0px;"> Imagens do produto <?=$codigoProduto?></h1>
    <span>

    <div class="container-md">  
        <a style="text-align: center;" class="btn btn-outline-primary" href="adminProdutos.php"> <-- Voltar </a>

        <div class="row justify-content-center">
    
        <?php
            while($dado = $resultadoImagem->fetch(PDO::FETCH_ASSOC)){
        ?>

            <div class="col-5" style="margin: 5px 5px 5px 5px; padding: 1%; border: 1px solid black; border-radius: 10px">
                <div>
                    <img style="width: 50%; height: 250px;" src="<?=carregaImagem('res/img/'.$dado['nome_arquivo'].'.jpg');?>"><br>
                </div>
                <div>
                    <a style="margin: 5px 0px 5px 0px; width: 100%;" href="Funcoes/ProdutoAdmin/deletarImagem.php?codImg=<?=$dado['codigo_img']?>&codProd=<?=$codigoProduto?>" class="btn btn-danger">Deletar</a>
                </div>
            </div>

        <?php
            }
        ?>
        </div>

        <hr style="border-top: 1px solid #8c8b8b;">
        <h3> Inserir imagem </h3>
        <form method="POST" action="Funcoes/ProdutoAdmin/inserirImagem.php?codProd=<?=$codigoProduto?>" enctype="multipart/form-data">
            <img id="fotoProd" width="200px" src="<?=carregaImagem('res/img/'.'.jpg');?>"><br><br>
            <input required type="file" name="Img" id="Img"><br>
            <button  style="margin-top: 5px; width: 30%;" type="submit" class="btn btn-success">Inserir imagem</button>
        </form>
    </div>

    <script>
        let fotoProd = document.getElementById("fotoProd");
        let arquivo = document.getElementById("Img");

        arquivo.addEventListener("change",function(){
            exibir(arquivo,fotoProd);
        });

        function exibir(arquivo,foto){
            if (arquivo.files.length != 1 ){
                return;
            }
            var r = new FileReader();
            r.onload = function() {
            foto.src = r.result;
            }
            r.readAsDataURL(arquivo.files[0]);

        }
        
    </script>
</body>

</html>