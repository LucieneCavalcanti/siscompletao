<?php
require_once "topo.php";
session_start();
if(isset($_GET['id'])){
    if(isset($_SESSION['Produto']['idProduto'])){
        array_push($_SESSION['Produto'],$_GET['id'],1);
    }else{
        $_SESSION['Produto']['idProduto'] = $_GET['id'];
        $_SESSION['Produto']['qtdeProduto'] = 1;
    }
}
header("location:index.php");
?>