<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIS Completão</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body>
    <h1>Carrinho de Compras</h1>
            <?php
            session_start();
            try{
            // Verificando se existe carrinho na sessão
            if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
                if(!isset($_SESSION['idUsuario'] || empty($_SESSION['idUsuario'])))
                    header('location:login.php');
                else {
                    require_once "bd/conexao.php";
                    $totalCompra=0;
                    $totalDescontos=0;
                    $totalAPagar=0;
                    //Inicia o controle de transações
                    $conn->beginTransaction();
                    //criar um pedido no banco de dados
                    $sqlPedido="insert into tbpedidos (idUsuario,valorTotal,totalDescontos,valorAPagar,tipoPagamento,statusPedido) 
                    values(:id,0,0,0,' ',6)";
                    $statement1 = $conn->prepare($sqlPedido);
                    $statement1->bindValue(":id",$_SESSION['idUsuario']);
                    $statement1->execute();
                    $ultimoIdInserido = $conn->lastInsertId();
                    if ($ultimoIdInserido != 0) {
                        //salvou o pedido, agora vamos salvar os itens
                    
                    foreach ($_SESSION['carrinho'] as $produto_id => $quantidade) {
                        // Recuperando informações do produto do banco de dados
                        $sql = "SELECT * FROM tbprodutos WHERE id = $produto_id";
                        $resultado = $conn->query($sql);
                        $registro = $resultado->fetch(PDO::FETCH_ASSOC);

                        // Calculando o total para este produto
                        $total_produto = ($registro['preco']-$registro['desconto']) * $quantidade;
                        $totalCompra+=$total_produto;
                        // salvar os detalhes do produto no carrinho
                        //criar um pedido no banco de dados
                        $sqlItemPedido="insert into tbitenspedido 
                        (idPedido,idproduto,quantidade,valorProduto,
                        valorDesconto,valorAPagar) 
                        values(:idPedido,:idProduto,:qtde,:preco,:desconto,:total_produto)";
                        $statement2 = $conexao->prepare($sqlItemPedido);
                        $statement2->bindValue(":idPedido",$ultimoIdInserido,PDO::PARAM_INT);
                        $statement2->bindValue(":idProduto",$registro['id'],PDO::PARAM_INT);
                        $statement2->bindValue(":qtde",$quantidade,PDO::PARAM_INT);
                        $statement2->bindValue(":preco",$registro['preco'],PDO::PARAM_FLOAT);
                        $statement2->bindValue(":desconto",$registro['desconto'],PDO::PARAM_FLOAT);
                        $statement2->bindValue(":total_produto",$total_produto,PDO::PARAM_FLOAT);
                        $statement2->execute();
                    }
                    //atualizar o pedido
                    $tipoPagamento = 'Mudar';
                    $sqlPedido="update tbpedidos set valorTotal=:valorTotal,
                    totalDescontos=:totalDescontos,valorAPagar=:valorAPagar,
                    tipoPagamento=:tipoPagamento) where id=:id";
                    $statement3 = $conexao->prepare($sqlPedido);
                    $statement3->bindValue(":valorTotal",$totalCompra,PDO::PARAM_FLOAT);
                    $statement3->bindValue(":totalDescontos",$totalDescontos,PDO::PARAM_FLOAT);
                    $statement3->bindValue(":valorAPagar",$totalAPagar,PDO::PARAM_FLOAT);
                    $statement3->bindValue(":tipoPagamento",$tipoPagamento,PDO::PARAM_FLOAT);
                    $statement3->bindValue(":id",$ultimoIdInserido,PDO::PARAM_INT);
                    $statement3->execute();
                    //comita a transação
                    $conn->commit();
                    //limpar o carrinho
                    $idUsuario = $_SESSION['idUsuario'];
                    session_destroy();
                    session_start();
                    $_SESSION['idUsuario']=$idUsuario;
                    //REDIRECIONA A PÁGINA
                    }//if ultimoidinserido 
                    else {
                        echo "<p>Não foi possível inserir o pedido.</p>";
                        $conn->rollBack();
                    } 
                }//fim do if idusuario          
            } else {
                echo "<p>Não há itens no carrinho</p>";
            }
            
        }//FIM DO TRY
        catch (PDOExecption $e){
            echo "erro: ".$e;
            $conn->rollBack(); }
	$conn = null;
    ?>
</body>
</html>
