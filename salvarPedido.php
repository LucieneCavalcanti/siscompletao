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
            
            // Verificando se existe carrinho na sessão
            if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
                require_once "bd/conexao.php";
                $totalCompra=0;
                $totalDescontos=0;
                $totalAPagar=0;
                //criar um pedido no banco de dados
                $sqlPedido="insert into tbpedidos (idUsuario,valorTotal,totalDescontos,valorAPagar,tipoPagamento,statusPedido) values(2,0,0,0,' ',6)";
                $conn->exec($sqlPedido);
      
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
                    values(1,{$registro['id']},{$quantidade},{$registro['preco']},
                    {$registro['desconto']},{$total_produto})";
                    $conn->exec($sqlItemPedido);    
                }
                //atualizar o pedido
                //limpar o carrinho
            } else {
                echo "<p>Não há itens no carrinho</p>";
            }
            ?>
</body>
</html>
