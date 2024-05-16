<?php
require_once "topo.php";

session_start();

if(isset($_GET['id'])){
    $produto_id = $_GET['id'];
    
    // Verificando se a sessão do carrinho está definida
    if(!isset($_SESSION['carrinho'])){
        $_SESSION['carrinho'] = array();
    }
    
    // Verificando se o produto já está no carrinho
    if(isset($_SESSION['carrinho'][$produto_id])){
        // Se estiver, aumentamos a quantidade em 1
        $_SESSION['carrinho'][$produto_id]++;
    }else{
        // Se não estiver, adicionamos com a quantidade 1
        $_SESSION['carrinho'][$produto_id] = 1;
    }
}

// Redirecionando de volta para a página index.php
header("location:index.php");
?>
