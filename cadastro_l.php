
<?php
include 'conexao.php';

session_start();
    
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editora = $_POST['editora'];
    $ano = $_POST['ano'];
    $genero = $_POST['genero'];
    
    $capa_nome = $_FILES['capa']['name'];
    $capa_tam = $_FILES['capa']['tmp_name'];
    $destino = 'banco/'.$capa_nome;

    move_uploaded_file($capa_tam ,$destino);

    $codigo = mt_rand(10000000 , 99999999); // Gera um código aleatório de 6 caracteres
   
    // Verificar se já existe um livro com o mesmo código
    $stmt = $pdo->prepare("SELECT codigo FROM livros WHERE codigo = :codigo");
    $stmt->bindParam(":codigo", $codigo);
    $stmt->execute();
    $result = $stmt->fetch();
    if ($stmt->rowCount() == 1) {
      $codigo = mt_rand(10000000 , 99999999);
      
    }

    // colocando os dados no banco
    $stmt = $pdo->prepare("INSERT INTO livros (titulo, autor, editora, ano, genero, codigo, capa) VALUES (:titulo, :autor, :editora, :ano, :genero, :codigo, :capa)");
    $stmt->bindParam(":titulo", $titulo , PDO::PARAM_STR);
    $stmt->bindParam(":autor", $autor ,PDO::PARAM_STR);
    $stmt->bindParam(":editora", $editora ,PDO::PARAM_STR);
    $stmt->bindParam(":ano", $ano ,PDO::PARAM_STR);
    $stmt->bindParam(":genero", $genero ,PDO::PARAM_STR);
    $stmt->bindParam(":codigo", $codigo ,PDO::PARAM_STR);
    $stmt->bindParam(":capa", $destino ,PDO::PARAM_STR);
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
  if(isset($_POST['logout'])) {
    // Destrói a sessão
    session_destroy();
    header('Location: index.php');
  }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <title>Biblioteca Amanajé</title>
    <link rel="shortcut icon" href="img/logo_aba.svg" type="image/x-icon">

</head>
<body> 
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
        <?php if(isset($_SESSION['logado'])){?>
          <!---------------- aparece o nome do usuario e botão de logout pos logado  ------------>
         <div class="row" id="logout">
          <p class="col-sm-8 text-capitalize fs-3 border-bottom border-primary fw-bold"><?php echo $_SESSION['nome'] ?></p>
          <form class="col-sm-4" method="POST" action="" >
            <button class="btn btn-outline-danger" type="submit" name="logout">Sair</button>
          </form>
          </div> 
          <?php } ?>
          <ul class="navbar-nav text-lg-center flex-grow-1 pe-4">
            <li class="nav-item">
              <a class="nav-link active fs-5" href="historico_funcio.php" id="historico">Historico</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active fs-5" href="acervo.php" id="acervo">Acervo</a>
            </li>
            <li class="nav-item dropdown fs-5 text-dark">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Gerenciamento
                </a> 
                <ul class="dropdown-menu " >
                  <li class=" dropdown-item">
                    <a id="link-funcionario" class="nav-link nav-link active fs-5" href="cadastrar.php">Cadastrar Usuário</a>
                  </li>
                  <li class=" dropdown-item">
                    <a id="link-funcionario" class="nav-link nav-link active fs-5" href="cadastro_l.php">Cadastrar Livros</a>
                  </li>
                  <li class="dropdown-item">
                    <a id="link-funcionario" class="nav-link nav-link active fs-5" href="editar.php">Editar livros</a>
                  </li>
                  <li class="dropdown-item">
                    <a id="link-funcionario" class="nav-link nav-link active fs-5" href="emprestimo.php">Empréstimo</a>
                  </li>
                </ul>
              </li>
          </ul>
          <br>
         </div>
      </div>
    </div>
  </nav>
  <br>
  <br>
  <div class="container-fluid mt-3 w-75">
    <h2 class="mb-3 text-center">Cadastrar Livro</h2>
    <form method="post" action="" enctype="multipart/form-data" class="fs-5 fw-bold">
      <div class="mb-3">
        <label for="titulo">Título:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="titulo" name="titulo" required>
      </div>
      <div class="mb-3">
        <label for="autor">Autor:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="autor" name="autor" required>
      </div>
      <div class="mb-3">
        <label for="editora">Editora:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="editora" name="editora" required>
      </div>
      <div class="mb-3">
        <label for="ano">Ano de Publicação:</label>
        <input type="txt" class="form-control rounded-4 border-info shadow-sm" id="ano" name="ano"pattern="[0-9]{4}" maxlength="4" required>
      </div>
      <div class="mb-3">
        <label for="genero">Gênero:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="genero" name="genero" required>
      </div>
      <div class="mb-3">
        <label for="capa">Capa:</label>
        <input type="file" class="form-control rounded-4 border-info shadow-sm" id="capa" name="capa" title="Formato recomendado : jpg ou jpeg " required>
      </div>
      <button type="submit" class="btn btn-info">Cadastrar</button>
    </form>
  </div>
  <br>
  
   
 <!----------------------------------- footer ------------------------------------->
 <div class="container-fluid divi-card ">
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
