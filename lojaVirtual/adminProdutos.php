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

        //Conectar o banco
        $bd = conexao();

        //Conexão lista itens
        $sqlProdutos = "SELECT * FROM produto";
        $resultadoProduto = $bd->query($sqlProdutos);
    ?>

    <span style="text-align: center;">
        <h1 style="margin: 25px 0px 25px 0px;"> Produtos </h1>
        <p>Para ver as imagens do produto, é necessário entrar na edição do produto</p>
    <span>

    <div class="container">
        <table class="table" style="text-align: center;">
            <thead>
                <tr>
                    <th scope="col">

                        <!-- Inserir o registro -->
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#Inserir">Inserir</button>

                        <div class="modal fade" id="Inserir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Inserir moeda</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form method="post" action="Funcoes/Moeda/inserir.php">

                                            <label for="CodProd">Codigo do produto</label>
                                            <input type="text" class="form-control" name="CodProd" id="CodProd">

                                            <label for="NmProd">Nome do produto</label>
                                            <input type="text" class="form-control" name="NmProd" id="NmProd">

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Fechar</button>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </th>

                    <th scope="col">Código</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Valor unitário</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Peso</th>
                    <th scope="col">Dimensões</th>
                    <th scope="col">Unidade de venda</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($registroProduto = $resultadoProduto->fetch(PDO::FETCH_ASSOC))
                    {  
                ?>
                <tr>
                    <td><?=$registroProduto["codigo_prod"]; ?></td>
                    <td><?=$registroProduto["nome_pro"]; ?></td>
                    <td><?=$registroProduto["descricao"]; ?></td>
                    <td><?=$registroProduto["valor_unitario"]; ?></td>
                    <td><?=$registroProduto["quantidade"]; ?></td>
                    <td><?=$registroProduto["peso"]; ?></td>
                    <td><?=$registroProduto["dimensoes"]; ?></td>
                    <td><?=$registroProduto["unidade_Venda"]; ?></td>

                    <td>
                        <!-- Botão editar -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" style="margin-bottom: 10px; width: 100%;"; 
                            data-target="#EditMoeda<?=$registroProduto["codigo_prod"]?>">
                            Editar
                        </button>

                        <!-- Deletar o registro -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" style="margin-bottom: 10px; width: 100%;"; data-target="#DeletarProduto<?=$registroProduto["codigo_prod"]?>">
                            Deletar
                        </button>

                        <!-- Modal de confirmação de deleção -->
                        <div class="modal fade" id="DeletarProduto<?=$registroProduto["codigo_prod"]?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel" style="text-align: center;">ATENÇÃO</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Certeza que deseja deletar o produto <?=$registroProduto["codigo_prod"]; ?>? <br>
                                        Com isso todas as imagens referentes ao produto serão apagadas, assim como os pedidos que contenham esse produto 
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                                        <!-- Deletar o produto -->
                                        <form action="Funcoes/ProdutoAdmin/deletar.php" method="POST">
                                            <input type="hidden" class="form-control" name="codProd" id="codProd"
                                                value="<?=$registroProduto["codigo_prod"]; ?>">
                                            <button type="submit" class="btn btn-danger" style="width: 100%;">Deletar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>