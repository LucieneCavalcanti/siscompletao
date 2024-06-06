<?php
require_once "bd/conexao.php";
if(isset($_GET['cupom'])){
    $cupom = $_GET['cupom'];
    $sql = "select * from tbcupons where cupom='".$cupom."' and
    dataInicial<= now() and dataFinal>=now()";
    $resultado = $conn->query($sql);
    foreach($resultado as $cupom) {
        if ($cupom['id']>0){
            echo "<p> Cupom ok</p>";
            session_start();
            if(is_null($cupom['quantidadeUso'])){
                if(is_null($cupom['valorMinimoPedido'])){
                    $_SESSION['cupom']=$cupom['cupom'];
                    $_SESSION['idcupom']=$cupom['id'];
                    $_SESSION['valordesconto'] = $cupom['valor'];
                    //  
                }else{
                    if($cupom['valorMinimo']<=$valorPedido){
                        $_SESSION['cupom']=$cupom['cupom'];
                        $_SESSION['idcupom']=$cupom['id'];
                        $_SESSION['valordesconto'] = $cupom['valor']; 
                        //
                    }else{
                        header("location:carrinho.php?cupom=".$cupom['cupom']."&validacao=compremais");
                    }
                }
                
            }else if($cupom['quantidadeUso']<=$cupom['quantidadeUtilizada']){
                header("location:carrinho.php?cupom=".$cupom['cupom']."&validacao=limiteexcedido");
            }else{
                if($cupom['valorMinimo']<=$valorPedido){
                    $_SESSION['cupom']=$cupom['cupom'];
                    $_SESSION['idcupom']=$cupom['id'];
                    $_SESSION['valordesconto'] = $cupom['valor']; 
                    //atualizar a quantidade de cupons disponíveis
                    //
                }else{
                    header("location:carrinho.php?cupom=".$cupom['cupom']."&validacao=compremais");
                }
            } 
            header("location:carrinho.php?cupom=".$cupom['cupom']."&validacao=ok");
            exit;
        }else {
            echo "<p> Cupom inválido</p>";
            header("location:carrinho.php?cupom=".$cupom['cupom']."&validacao=negativo");

            exit;    
        }
    }
    echo "<p> Cupom inválido</p>";
    header("location:carrinho.php?cupom=".$cupom."&validacao=negativo");

    exit;
}else {
    echo "<p> Erro</p>";
}
?>