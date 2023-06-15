<!DOCTYPE html>
<html>
    <!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de compras</title>

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
            //Session do carrinho
            session_start();

            if(!isset($_SESSION['carrinho'])){
                $_SESSION['carrinho'] = array();
            }

            include_once './Funcoes/banco.php';
            include_once './Funcoes/carregaArquivo.php';

            //Conectar o banco
            $bd = conexao();

            $sqlTrans = "SELECT * FROM transportadora";

            $resultadoTrans = $bd->query($sqlTrans);
            $dadoTrans = $resultadoTrans->fetchAll();
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

        <h1 style="text-align: center; margin-top: 2%; margin-bottom: 2%;">Carrinho</h1>

        <div class="container-md" style="border: 1px solid black; padding: 2%; border-radius: 10px;">  
            <div class="row">

                <!-- Mostrar os produtos -->
                <?php
                    $valor_total_carrinho = 0;

                    //Ve se o frete está cheio
                    //A gente tentou com a API dos correios mas não deu mt certo :(
                    if(empty($_SESSION['frete'])){
                        $valor_frete = 0.00;
                    } else {
                        $valor_frete = $_SESSION['frete'];
                    }

                    foreach ($_SESSION['carrinho'] as $carrinho) :
                        $codigo = $carrinho['cod_prod'];
                        $sql = "SELECT * FROM produto WHERE codigo_prod='$codigo'";

                        $resultado = $bd->query($sql);
                        $dado = $resultado->fetch(PDO::FETCH_ASSOC);
                        $valor_total = $dado['valor_unitario'] * $carrinho['qt'];

                        $valor_total_carrinho += $valor_total;

                        //Pegar a imagem
                        $sqlImagem = "SELECT *
                        FROM imagem
                        WHERE codigo_prod='$codigo'
                        ORDER BY codigo_prod DESC
                        LIMIT 1;";
                            
                        $resultadoImagem = $bd->query($sqlImagem);
                        $imagem = $resultadoImagem->fetch(PDO::FETCH_ASSOC);

                        if(is_array($imagem)){
                            $nomeArquivo = $imagem['nome_arquivo'];
                        } else {
                            $nomeArquivo = "padrao";
                        }
                ?>

                <div class="container">
                    
                    <div class="row" style="margin-bottom: 5%; padding: 1%; border: 1px solid black; border-radius: 10px"> 
                        <div class="col-4">

                            <img style="width: 50%;" src="<?=carregaImagem('res/img/'.$nomeArquivo.'.jpg');?>">

                        </div>

                        <div class="col-4" style="text-align: center; margin-top: 2%;">
                            <h2 class="card-title"><?=$dado['nome_pro']; ?></h2>
                            <p class="card-text">Quantidade: <?=$carrinho['qt']; ?></p>
                            <p style = "color: red; font-weight: bold; font-size: 20px;">R$ <?=$valor_total?></p>
           
                        </div>

                        <div class="col-4" style="text-align: right; margin-top: 2.5%;">
                            <a href="Funcoes/Carrinho/atualizar.php?cod=<?=$codigo?>&operacao=mais" class="btn btn-success">+</a>
                            <a href="Funcoes/Carrinho/atualizar.php?cod=<?=$codigo?>&operacao=menos" class="btn btn-warning">-</a>
                            <br>
                            <br>
                            <a href="Funcoes/Carrinho/deletar.php?cod=<?=$codigo?>" class="btn btn-danger">Deletar</a>
                        </div>

                    </div>
                </div>
                
                <?php
                    endforeach;
                ?>
            </div>
            <form id="formPedido" method="POST" action="Funcoes/PedidoCompra/inserirCliente.php?valorTotal=<?=$valor_total_carrinho?>&valorFrete=<?=$valor_frete?>">

                <h2 style="text-align: left;">Dados do cliente</h2>
                <hr style="text-align: right; background-color: black;">

                <label for="cpf">CPF ou CNP*</label>
                <input required size="15" maxlength="20" style="margin-bottom: 2%;" type="text" class="form-control" name="cpf" id="cpf" placeholder="Cpf/CNPJ">

                <label for="nome">Nome</label>
                <input style="margin-bottom: 2%;" type="text" class="form-control" name="nome" id="nome" placeholder="Nome">
                
                <label for="cep">CEP*</label>
                <input required style="margin-bottom: 2%;" onfocusout="pegarDadosCep()" type="text" class="form-control" name="cep" id="cep" placeholder="CEP">

                <label for="bairro">Bairro</label>
                <input style="margin-bottom: 2%;" type="text" class="form-control" name="bairro" id="bairro" placeholder="Bairro">

                <label for="cidade">Cidade</label>
                <input style="margin-bottom: 2%;" type="text" class="form-control" name="cidade" id="cidade" placeholder="Cidade">

                <label for="estado">Estado</label>
                <input style="margin-bottom: 2%;" type="text" class="form-control" name="estado" id="estado" placeholder="Estado">
                
                <label for="rua">Logradouro</label>
                <input style="margin-bottom: 2%;" type="text" class="form-control" name="rua" id="rua" placeholder="Logradouro">

                <label for="nro">Número</label>
                <input style="margin-bottom: 2%;" type="number" class="form-control" name="nro" id="nro" placeholder="Numero">

                <label for="trans">Transportadora</label>
                <select class="form-control" id="trans" name="trans">
                    <?php
                        foreach($dadoTrans as $registroTrans){
                            echo "<option value='" . $registroTrans["cpf_cnpj_transp"]."'>";
                            echo $registroTrans["nome_tras"];
                            echo "</option>";
                        }
                    ?>
                </select>

                <br>

                <button type="submit" style="width: 100%" href="#" class="btn btn-success">Finalizar pedido</button>
            </form>
            <br>
            <div class="container">
                <h2>Total do pedido: <h3 style="color: red">R$ <?=$valor_total_carrinho?></h3></h2>
                <br>
                <h2>Frete: <h3 style="color: red">R$ <?=$valor_frete?></h3></h2>
            </div>
        </div>
    </body>

    <script>
        function pegarDadosCep(){
            //Nova variável "cep" somente com dígitos.
            var cep = $("#cep").val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#rua").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#estado").val(dados.uf);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            console.log("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    console.log("Formato de CEP inválido.");
                }
            } //end if.
        }

        $(document).ready(function(){
            $("#cep").mask("99.999-999");
        });

        $("#cpf").keydown(function(){
            try {
                $("#cpf").unmask();
            } catch (e) {}

            var tamanho = $("#cpf").val().length;

            if(tamanho < 11){
                $("#cpf").mask("999.999.999-99");
            } else {
                $("#cpf").mask("99.999.999/9999-99");
            }

            var elem = this;
            setTimeout(function(){
                elem.selectionStart = elem.selectionEnd = 10000;
            }, 0);
            var currentValue = $(this).val();
            $(this).val('');
            $(this).val(currentValue);
        });
    </script>
</html>
