<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>SIS COmpletão - Login</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <?php
        //verificar a variavel ação
      $acao="";
      if(isset($_GET['acao'])){
          $acao=$_GET['acao'];
          if(isset($_GET['id']))
            $id=$_GET['id'];
          //echo "entrou no get";
      }else if(isset($_POST['acao'])){
          $acao=$_POST['acao'];
          $id=$_POST['id'];
          $descricao=$_POST['descricao'];
          //echo "entrou no post";
        } else {
          $acao="novo";
          $id=0;
          $descricao="";
        }
      
        //buscar o registro a ser exibido
        require_once "bd/conexao.php";
        if($acao=="editar"){
            $sql = "select * FROM tbstatus where id=".$id;
            $resultado = $conn->query($sql);
            foreach($resultado as $registro) {
                $descricao = $registro['descricao'];
                //echo $descricao;
            }
        }
        if($acao=="excluir"){
            echo "<script>window.alert('Excluído')</script>";
            $sql = "delete from tbstatus where id=".$id;
            $conn->exec($sql);
            $id=0;
            $descricao="";
            $acao="novo";
        }
        if($acao=="atualizar"){
            echo "<script>window.alert('Atualizado')</script>";
            $sql = "update tbstatus set descricao='".$descricao."' where id=".$id;
            //echo $sql;
            $conn->exec($sql);
            $id=0;
            $descricao="";
            $acao="novo";
        }
        
        if($acao=="novo" && $id==0 && $descricao!=""){
          echo "<script>window.alert('Salvo com sucesso')</script>";
          $sql = "insert into tbstatus (descricao) values('".$descricao."')";
          //echo $sql;
          $conn->exec($sql);
          $id=0;
          $acao="novo";
          $descricao="";
        }
        ?>
<main class="form-signin w-100 m-auto">
  <form action="status.php" method="post">
    <h1 class="h3 mb-3 fw-normal">Status</h1>

    <div class="form-floating">
      <?php
      if($id>0 && $descricao!="")
        $acao="atualizar"; ?>
      <input type="hidden" name="acao" value="<?php echo $acao;?>">
      <input type="text" name="id" class="form-control" 
      id="floatingInput" placeholder="ID" readonly
      value="<?php echo $id; ?>">
      <label for="floatingInput">Id</label>
    </div>
    <div class="form-floating">
      <input type="text" name="descricao" class="form-control" 
      id="floatingInput" placeholder="Descrição"
      value="<?php echo $descricao; ?>" required>
      <label for="floatingInput">Descrição</label>
    </div>
    <div class="form-floating"></div>
    <button class="w-100 btn btn-lg btn-primary" type="submit"><?php echo strtoupper($acao); ?></button>
    <p class="mt-5 mb-3 text-muted">&copy; 2024</p>
  </form> <br>
</main>

<div id="listagem">
      <h1>Listagem</h1>
      <?php
        $sql="Select * from tbstatus order by descricao";
        echo "<table><tr><th>ID</th><th>Descrição</th><th></th></tr>";
        $resultado = $conn->query($sql);
        foreach($resultado as $registro) {
            echo "<tr><td>".$registro["id"]."</td><td>".
            $registro["descricao"]."</td><td>
            <a href='status.php?id=".$registro["id"]."&acao=editar'><span class='material-symbols-outlined'>
            edit</span></a>
            <a href='status.php?id=".$registro["id"]."&acao=excluir'><span class='material-symbols-outlined'>
            delete</span></a>
            </td></tr>";
        }
        echo "</table>";
        ?>
</div>
    
  </body>
</html>
