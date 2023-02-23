<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <title>Biblioteca Amanajé</title>
    <link rel="icon" href="img/logo.png" >
</head>
<body>
<?php
include 'conexao.php';
session_start();
    
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editora = $_POST['editora'];
    $ano = $_POST['ano'];
    $genero = $_POST['genero'];
    $codigo = $_POST['codigo'];

    $capa = file_get_contents($_FILES['capa']['tmp_name']);
    // Codifique a capa em base64
    $capa_base64 = base64_encode($capa);

    // Verificar se já existe um livro com o mesmo código
    $stmt = $pdo->prepare("SELECT codigo FROM livros WHERE codigo = :codigo");
    $stmt->bindParam(":codigo", $codigo);
    $stmt->execute();
    $result = $stmt->fetch();
    if ($stmt->rowCount() == 1) {
      echo "<script> alert('Já existe um livro cadastrado com esse código.');window.location.href = 'cadastro_l.php'</script>";
      
    }

    // colocando os dados no banco
    $stmt = $pdo->prepare("INSERT INTO livros (titulo, autor, editora, ano, genero, codigo, capa) VALUES (:titulo, :autor, :editora, :ano, :genero, :codigo, :capa)");
    $stmt->bindParam(":titulo", $titulo , PDO::PARAM_STR);
    $stmt->bindParam(":autor", $autor ,PDO::PARAM_STR);
    $stmt->bindParam(":editora", $editora ,PDO::PARAM_STR);
    $stmt->bindParam(":ano", $ano ,PDO::PARAM_STR);
    $stmt->bindParam(":genero", $genero ,PDO::PARAM_STR);
    $stmt->bindParam(":codigo", $codigo ,PDO::PARAM_STR);
    $stmt->bindParam(":capa", $capa_base64 ,PDO::PARAM_LOB);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        
        echo "<script> alert('Livro cadastrado com sucesso!')</script>";
    } else {
        echo "<script> alert('Erro ao cadastrar livro: " . $stmt->errorInfo()[2]."')</script>";
      }
    
    // Fechar a conexão com o banco de dados
    $stmt->fetch();
    $pdo = null;
  }

?>
 
<main>
  <!-------------------------------------- inicio do navbar ------------------------------>
  <nav class="navbar bg-info fixed-top" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold fs-4 " href="index.php">
        Biblioteca Amanajé
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-info" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label fs-2">MENU</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <div class="sticky-sm-bottom row-2" style="text-align-last: center;">
            <div id="usuarioLogado"></div>
           </div><br>
          <ul class="navbar-nav text-lg-center flex-grow-1 pe-4">
            <li class="nav-item">
              <a class="nav-link active fs-5" href="historico.php" id="historico">Historico</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active fs-5" href="acervo.php" id="acervo">Acervo</a>
            </li>
            <li class="nav-item dropdown">
                <a id="link-funcionario" class="nav-link nav-link active fs-5" href="cadastro_l.php">Cadastrar Livros</a>
            </li>
            <li class="nav-item dropdown">
              <a id="link-funcionario" class="nav-link nav-link active fs-5" href="emprestimo.php">Emprestimo</a>
          </li>
          </ul>
          <br>
         </div>
      </div>
    </div>
  </nav>
  <br>
  <br>
  <div class="container-fluid mt-3 w-75 posi">
    <h2 class="mb-3 text-center">Cadastrar Livro</h2>
    <form method="post" action="" enctype="multipart/form-data" class="fs-5 fw-bold">
      <div class="mb-3">
        <label for="titulo">Título:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="titulo" name="titulo">
      </div>
      <div class="mb-3">
        <label for="autor">Autor:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="autor" name="autor">
      </div>
      <div class="mb-3">
        <label for="editora">Editora:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="editora" name="editora">
      </div>
      <div class="mb-3">
        <label for="ano">Ano de Publicação:</label>
        <input type="txt" class="form-control rounded-4 border-info shadow-sm" id="ano" name="ano">
      </div>
      <div class="mb-3">
        <label for="genero">Gênero:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="genero" name="genero">
      </div>
      <div class="mb-3">
        <label for="codigo">Código:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="codigo" name="codigo">
      </div>
      <div class="mb-3">
        <label for="capa">Capa:</label>
        <input type="file" class="form-control rounded-4 border-info shadow-sm" id="capa" name="capa">
      </div>
      <button type="submit" class="btn btn-info">Cadastrar</button>
    </form>
  </div>
  <br>
  
   
 <!----------------------------------- footer ------------------------------------->
 <div class="container">
 <footer class="row  py-5 my-sm-4 border-top">
    <div class="col mb-3">
      <a href="/" class="d-flex align-items-center mb-3 link-dark text-decoration-none">
      
      </a>
      
    </div>

    <div class=" mb-5 mx-4">
      
      <h5><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Sobre</font></font></h5>
      <ul class="nav flex-column">
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Fone : 0000000000</font></font></a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Email : xxxxxx@xxxxx</font></font></a></li>

      </ul>
    </div>

    

  </footer>
 </div>
</main> 
  <script src="js/javascript.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

 
</body>


</html>
