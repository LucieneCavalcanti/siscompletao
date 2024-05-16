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
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            session_start();
            
            // Verificando se existe carrinho na sessão
            if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
                require_once "bd/conexao.php";
                foreach ($_SESSION['carrinho'] as $produto_id => $quantidade) {
                    // Recuperando informações do produto do banco de dados
                    $sql = "SELECT * FROM tbprodutos WHERE id = $produto_id";
                    $resultado = $conn->query($sql);
                    $registro = $resultado->fetch(PDO::FETCH_ASSOC);

                    // Calculando o total para este produto
                    $total_produto = $registro['preco'] * $quantidade;

                    // Exibindo os detalhes do produto no carrinho
                    echo "<tr>";
                    echo "<td>{$registro['id']} --->>> {$registro['descricao']}</td>";
                    echo "<td><input type='number' value='{$quantidade}' id='quantidade-$produto_id' size='3'></td>";
                    echo "<td id='preco-unitario-$produto_id'>R$ {$registro['preco']}</td>";
                    echo "<td id='total-$produto_id'>R$ {$total_produto}</td>";
                    echo "<td>";
                    echo "<button onclick='atualizarQuantidade($produto_id)'>Atualizar</button>";
                    echo "<button onclick='excluirProduto($produto_id)'>Excluir</button>";
                    echo "</td>";
                    echo "</tr>";
                    
                }
                echo "<tr><td colspan='5'><output id='totalCompra'>Total da compra: R$ </output></td></tr>";
            } else {
                echo "<tr><td colspan='5'>Não há itens no carrinho</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function atualizarQuantidade(produto_id) {
            var novaQuantidade = parseInt(document.getElementById('quantidade-' + produto_id).value);

            // Verificar se a nova quantidade é um número válido
            if (!isNaN(novaQuantidade) && novaQuantidade > 0) {
                // Calcular o novo valor total para o produto
                var precoUnitario = parseFloat(document.getElementById('preco-unitario-' + produto_id).textContent.replace("R$ ", ""));
                var novoTotalProduto = novaQuantidade * precoUnitario;

                // Atualizar a exibição do valor total do produto
                document.getElementById('total-' + produto_id).textContent = "R$ " + novoTotalProduto.toFixed(2);

                // Recalcular o valor total da compra somando os novos totais de todos os produtos no carrinho
                var valorTotalCompra = 0;
                <?php
                foreach ($_SESSION['carrinho'] as $produto_id => $quantidade) {
                    $sql = "SELECT * FROM tbprodutos WHERE id = $produto_id";
                    $resultado = $conn->query($sql);
                    $registro = $resultado->fetch(PDO::FETCH_ASSOC);
                    echo "valorTotalCompra += " . $quantidade . " * " . $registro['preco'] . ";";
                }
                ?>

                // Atualizar a exibição do valor total da compra
                document.getElementById('totalCompra').textContent = "R$ " + valorTotalCompra.toFixed(2);
            } else {
                // Se a nova quantidade não for válida, exibir uma mensagem de erro
                alert("Por favor, insira uma quantidade válida.");
            }
        }

        function excluirProduto(produto_id) {
            // Aqui você pode enviar o produto_id para remover o produto do carrinho
            console.log("Excluir produto com ID: " + produto_id);
        }
    </script>
</body>
</html>
