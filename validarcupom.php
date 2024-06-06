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
            exit;
        }else {
            echo "<p> Cupom inválido</p>";
            exit;    
        }
    }
    echo "<p> Cupom inválido</p>";
    exit;
}else {
    echo "<p> Erro</p>";
}
?>