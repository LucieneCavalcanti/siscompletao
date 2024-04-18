<?php
  require_once "topo.php";
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>SIS Completão - Cadastro</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">


  </head>
  <body class="text-center">
  <?php
        //verificar a variavel ação
      $acao="";
      $id=0;
      if(isset($_GET['acao'])){
          $acao=$_GET['acao'];
          if(isset($_GET['id']))
            $id=$_GET['id'];
          //echo "entrou no get";
      }else if(isset($_POST['acao'])){
          $acao=$_POST['acao'];
          $id=$_POST['id'];
          $nome=$_POST['nome'];
          $email=$_POST['email'];
          $senha=$_POST['senha'];
          //echo "entrou no post";
        } else {
          $acao="novo";
          $id=0;
          $nome="";
          $email="";
          $senha="";
        }
      
        //buscar o registro a ser exibido
        require_once "bd/conexao.php";
        if($acao=="editar"){
            $sql = "select * FROM tbusuarios where id=".$id;
            $resultado = $conn->query($sql);
            foreach($resultado as $registro) {
                $nome = $registro['nome'];
                $email = $registro['email'];
                $senha = $registro['senha'];
                //echo $descricao;
            }
        }
        if($acao=="excluir"){
            echo "<script>window.alert('Excluído')</script>";
            $sql = "delete from tbusuarios where id=".$id;
            $conn->exec($sql);
            $id=0;
            $nome="";
            $email="";
            $senha="";
            $acao="novo";
        }
        if($acao=="atualizar"){
            echo "<script>window.alert('Atualizado')</script>";
            $sql = "update tbusuarios set nome='".$nome."' where id=".$id;
            //echo $sql;
            $conn->exec($sql);
            $id=0;
            $nome="";
            $email="";
            $senha="";
            $acao="novo";
        }
        
        if($acao=="novo" && $id==0){
          echo "<script>window.alert('Salvo com sucesso')</script>";
          $sql = "INSERT INTO tbusuarios (nome, email, senha, idstatus) VALUES ('".$nome."','".$email."','".$senha."',3)";
          //echo $sql;
          $conn->exec($sql);
          $id=0;
          $acao="novo";
          $nome="";
          $email="";
          $senha="";
          
      }
        ?>
<main class="form-signin w-100 m-auto">
  <form action="cadastrousuario.php" method="post">
    <img class="mb-4" src="assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Faça seu cadastro</h1>

    <div class="for#m-floating">
    <?php
      if($id>0 && $nome!="")
        $acao="atualizar"; ?>
      <input type="hidden" name="acao" value="<?php echo $acao;?>">
      <input type="hidden" name="id" value="<?php echo $id;?>">

      

    <div class="form-floating">
      <input type="nome" name="nome" class="form-control" id="floatingInput" placeholder="Digite seu nome">
      <label for="floatingInput">Nome</label>
    </div>

    <div class="form-floating">
      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">E-mail</label>
    </div>
    <div class="form-floating">
      <input type="password" name="senha" class="form-control" id="floatingPassword" placeholder="Senha">
      <label for="floatingPassword">Senha</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Salvar</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2024</p>
  </form>
</main>

<div id="listagem">
      <h1>Listagem</h1>
      <?php
        $sql="Select * from tbusuarios order by id";
        echo "<table><tr><th>ID</th><th>Nome</th><th>Email</th><th>Senha</th><th>Acoes</th></tr>";
        $resultado = $conn->query($sql);
        foreach($resultado as $registro) {
            echo "<tr><td>".$registro["id"]."</td><td>".
            $registro["nome"]."</td><td>".
          $registro["email"]."</td><td>".
          $registro["senha"]."</td><td>

          <a href='cadastrousuario.php?id=".$registro["id"]."&acao=editar'><span class='material-symbols-outlined'>edit</span></a>
            <a href='cadastrousuario.php?id=".$registro["id"]."&acao=excluir'><span class='material-symbols-outlined'>delete</span></a>
            </td></tr>";
        }
        echo "</table>";
        ?>
</div>

    
  </body>
</html>

<?php
require_once "rodape.php";
?>
