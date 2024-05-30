<?php
require_once "bd/conexao.php";
if(isset($_GET['cupom'])){
    $cupom = $_GET['cupom'];
    $sql = "select * from tbcupons where cupom='".$cupom."' and
    dataInicial<= now() and dataFinal>=now()";
    $resultado = $conn->query($sql);
    $registro = $resultado->fetch(PDO::FETCH_ASSOC);
    if($resultado->fetchColumn()>0){
        echo "<p>Cupom ok</p>";
    }else{
        echo "<p>Cupom inválido</p>";
    }
}
?>