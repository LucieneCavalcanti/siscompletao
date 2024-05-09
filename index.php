<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIS Completão</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled">Disabled</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Login</button>
      </form>
    </div>
  </div>
</nav>
<main>
  <?php
  require_once "bd/conexao.php";
  $sql="select * from tbcategorias order by descricao";
  $resultado = $conn->query($sql);
  foreach($resultado as $registro) {
      echo "<a href='index.php?idCategoria=".$registro["id"]."'>".
      $registro["descricao"]."</a> | ";
  }
  if(isset($_GET['idCategoria'])){
    $idCategoria= $_GET['idCategoria'];
    $sql2 = "Select * from tbprodutos where quantidade>0 and 
    idstatus =1 and idCategoria = ".$idCategoria;
    $resultado2 = $conn->query($sql2);
    foreach($resultado2 as $registro2) {
        echo "<div class='produto'><p>".$registro2['descricao']."</p>";
        echo "<p>R$ ".$registro2['preco']."</p>";
        echo "<p>Desconto de ".$registro2['desconto']."</p><br></div>";
    }
  }else {
    $sql3 = "Select * from tbprodutos 
    where quantidade>0 and 
    idstatus =1 
    order by rand() limit 2";
    $resultado3 = $conn->query($sql3);
    echo "<h3>Destaques ___________________________________</h3>";
    foreach($resultado3 as $registro3) {
        echo "<div class='produto'><p>".$registro3['descricao']."</p>";
        echo "<p>R$ ".$registro3['preco']."</p>";
        echo "<p>Desconto de ".$registro3['desconto']."</p><br></div>";
    }
    $sql4 = "Select * from tbprodutos 
    where quantidade>0 and 
    idstatus =1 and desconto>0
    order by rand() limit 2";
    $resultado4 = $conn->query($sql4);
    echo "<h3>Promoção ___________________________________</h3>";
    foreach($resultado4 as $registro4) {
        echo "<div class='produto'><p>".$registro4['descricao']."</p>";
        echo "<p>R$ ".$registro4['preco']."</p>";
        echo "<p>Desconto de ".$registro4['desconto']."</p>";
        echo "<p>Preço com desconto ". 
        ($registro4['preco']-$registro4['desconto'])."</p><br></div>";
    }
  }
  ?>
</main>
</body>
</html>

<?php
require_once "rodape.php";
?>