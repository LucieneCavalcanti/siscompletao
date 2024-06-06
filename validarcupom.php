<?php
require_once "bd/conexao.php";
session_start();
$_SESSION['cupom']="";
$_SESSION['idcupom']="";
$_SESSION['statusCupom']="";
$_SESSION['valordesconto']="";
if(isset($_GET['cupom'])){
    $NumeroCupom = $_GET['cupom'];
    $sql = "select * from tbcupons where cupom='".$NumeroCupom."' and
    dataInicial<= CURRENT_DATE() and dataFinal>=CURRENT_DATE()";
    $resultado = $conn->query($sql);
    $status="";
    foreach($resultado as $cupom) {
        $status=1;
        if ($cupom['id']>0){
            //echo "<p> Cupom ok</p>";
            $_SESSION['cupom']=$cupom['cupom'];
            $_SESSION['idcupom']=$cupom['id'];
            $_SESSION['valordesconto'] = $cupom['valor'];
            if(is_null($cupom['quantidadeUso'])){
                if(is_null($cupom['valorMinimoPedido'])){
                    $_SESSION['statusCupom'] = "ok";
                    //
                }else{
                    if($cupom['valorMinimo']<=$valorPedido){
                        $_SESSION['statusCupom'] = "ok";
                        //
                    }else{
                        $_SESSION['statusCupom'] = "ok";
                        //header("location:carrinho.php?cupom=".$cupom['cupom']."&validacao=compremais");
                        //
                    }
                }
                
            }else if($cupom['quantidadeUso']<=$cupom['quantidadeUtilizada']){
                $_SESSION['statusCupom'] = "Limite Excedido";
                //header("location:carrinho.php?cupom=".$cupom['cupom']."&validacao=limiteexcedido");
                //
            }else{
                if($cupom['valorMinimo']<=$valorPedido){
                    $_SESSION['statusCupom'] = "ok";
                    //
                }else{
                    $_SESSION['statusCupom'] = "Você precisa comprar mais itens";
                    //header("location:carrinho.php?cupom=".$cupom['cupom']."&validacao=compremais");
                    //
                }
            } 
            $_SESSION['statusCupom'] = "ok";
            //header("location:carrinho.php?cupom=".$cupom['cupom']."&validacao=ok");
            //
        }else {
            $_SESSION['statusCupom'] = "Cupom inválido";
            echo "<p>bbbb Cupom inválido</p>";
        }
    }
    if($status!=1){
        $_SESSION['statusCupom']="Cupom não encontrado.";
        $_SESSION['valordesconto']="0";
    }
    // $_SESSION['statusCupom'] = "Cupom inválido";
    // echo "<p> aaaa Cupom inválido</p>";
    //header("location:carrinho.php?cupom=".$cupom."&validacao=negativo");

    ////
}else {
    $_SESSION['statusCupom'] = "Erro";
    echo "<p> Erro</p>";
}
header("location:carrinho.php?cupom=".$NumeroCupom);
?>