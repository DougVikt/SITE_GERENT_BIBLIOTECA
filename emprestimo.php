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
<?php
include 'conexao.php'; 

session_start();
// verifica o metodo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'];
  $titulo = $_POST['titulo'];
  $codigo = $_POST['codigo'];
  $retirada = $_POST['retirada'];
  $devolucao = $_POST['devolucao'];
  
  $controle_erro = true;

  // Obtém o ID correspondente ao nome e ao código
  $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nome = ?");
  $stmt->execute([$nome]);
  $idUsuario = $stmt->fetchColumn();
  // caso o usuario pasado não esteja cadastrado
  if (!$idUsuario) {
    echo "<script> alert('Usuário não cadastrado.');</script>";
    $controle_erro = false;
  }
  
  // caso o codigo não esteja cadastrado
  $stmt = $pdo->prepare("SELECT id FROM livros WHERE codigo = ?");
  $stmt->execute([$codigo]);
  $idcodigo = $stmt->fetchColumn();
  if (!$idcodigo) {
    echo "<script> alert('codigo não cadastrado.');</script>";
    $controle_erro = false;
  }

  // Verifica se o nome do livro se refere ao código passado 
  $stmt = $pdo->prepare("SELECT id FROM livros WHERE titulo = ? AND codigo = ?");
  $stmt->execute([$titulo, $codigo]);
  $registro = $stmt->fetch();
  // caso o nome do livro não bata com o codigo passado 
  if (!$registro) {
    echo "<script>alert('Este nome de livro não bate com o codigo passado');</script>";
    $controle_erro = false;
  } 
   
  // caso os testes acima derem falso , sera executado
  if($controle_erro){
    $sql = "INSERT INTO emprestimo (usuario, livro, codigo, retirada, devolucao , status ) VALUES (:nome, :titulo, :codigo, :retirada, :devolucao , 'pendente')";
  // enviando os dados para o banco 
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':nome', $idUsuario);
    $stmt->bindValue(':titulo', $titulo);
    $stmt->bindValue(':codigo', $idcodigo);
    $stmt->bindValue(':retirada', $retirada);
    $stmt->bindValue(':devolucao', $devolucao);

    if ($stmt->execute()) {
      //mensagem de sucesso e emcaminha para outra pagina , motivo de segurança
      echo "<script>alert('Empréstimo cadastrado com sucesso!'); window.location='historico_funcio.php';</script>";

     
    } else {
      echo "<script> alert('Erro ao cadastrar o empréstimo.');</script>";
    }
  }

}
if(isset($_POST['logout'])) {
  // Destrói a sessão
  session_destroy();
  header('Location: index.php');
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
                <ul class="dropdown-menu ">
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
  <!--------------------------------- formulario de emprestimo ------------------------------------------->
  <div class="container mt-3 w-75 d-flex flex-column ">
    <h2 class="mb-3 text-center">Emprestimo</h2>
    <form method="post" action="#" enctype="multipart/form-data" class="fs-5 fw-bold">
      <div class="mb-3">
        <label for="titulo">Nome:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="nome" name="nome">
      </div>
      <div class="mb-3">
        <label for="nome-livro">Tìtulo do livro:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="titulo" name="titulo">
      </div>
      <div class="mb-3">
        <label for="codigo-livro">Código:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="codigo" name="codigo" pattern="[A-Z0-9]+" maxlength="18" title="Coloque um codigo valido , com letras maiusculas e numeros ">
      </div>
      <div class="mb-3">
        <label for="data-emprestimo">Data da Retirada:</label>
        <input type="date" class="form-control rounded-4 border-info shadow-sm" id="retirada" name="retirada">
      </div>
      <div class="mb-3">
        <label for="data-entrega">Data de Devolução:</label>
        <input type="date" class="form-control rounded-4 border-info shadow-sm" id="devolucao" name="devolucao">
      </div>
      <button type="submit" class="btn btn-info">Cadastrar</button>
    </form>
  </div>
  
 <!----------------------------------- footer ------------------------------------->
 <div class="container position-absolute top-100 start-50 translate-middle mt-lg-5">
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
<!----------------------- scripts --------------------------->
  <script src="js/javascript.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="devolucaonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="devolucaonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="devolucaonymous"></script>

 
</body>


</php>
