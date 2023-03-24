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
$funcionario = false;
// verifica se e usuario ou funcionario
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'funcionario') {
   $funcionario = true;
}


// Consulta no banco de dados
$sql = "SELECT livros.*, COALESCE(AVG(avaliacoes.avaliacao), 0) AS media
FROM livros LEFT JOIN avaliacoes ON livros.id = avaliacoes.id_livro GROUP BY livros.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$livros = $stmt->fetchAll(PDO::FETCH_ASSOC);



if (isset($_GET['q']) && !empty($_GET['q'])) {
  $q = $_GET['q'];
  $sql = "SELECT * FROM livros WHERE titulo LIKE '%$q%' OR autor LIKE '%$q%' OR editora LIKE '%$q%' OR ano LIKE '%$q%'";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  // código para recuperar todos os livros da tabela
  $sql = "SELECT livros.*, COALESCE(AVG(avaliacoes.avaliacao), 0) AS media
  FROM livros LEFT JOIN avaliacoes ON livros.id = avaliacoes.id_livro GROUP BY livros.id";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
          <p id="usuarioLogado" class="col-sm-8 text-capitalize fs-3 border-bottom border-primary fw-bold"></p>
          <form class="col-sm-4" method="POST" action="" >
            <button class="btn btn-outline-danger" type="submit" name="logout">Sair</button>
          </form>
          </div> 
          <?php } ?>
           <div id="usuarioLogado" class="text-capitalize text-lg-center fs-3"></div>
          <div class="sticky-sm-bottom row-2" style="text-align-last: center;" id="botoes-iniciais">
            <a class="btn btn-secondary btn-outline-light rounded-4 " href="login.php" role="button" id="login">Login</a>
            <div class="vr"></div>
            <a class="btn btn-danger btn-outline-light rounded-4 " href="cadastrar.php" role="button" id="cadastro">Cadastrar</a>
          </div><br>
          <ul class="navbar-nav text-lg-center flex-grow-1 pe-4">
            <li class="nav-item">
              <a class="nav-link active fs-5" href="login.php" id="historico">Historico</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active fs-5" href="acervo.php" id="acervo">Acervo</a>
            </li>
              <!------- variavel que vem do php -->
            <?php if ($funcionario): ?> 
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
            <?php endif; ?> 
          </ul>
          <br>
         </div>
      </div>
    </div>
  </nav>
  <br>
  <br>
  <!---------------------------------------- separador e busca ---------------------------------------------------->
  <header class="p-3 mx-auto bg-info bg-gradient">
    <div class="container-fluid">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <img class="img-fluid img-thumbnail rounded-circle" width="100" height="20" src="img/logo.png" alt="logo biblioteca Amanajé">
        </a>

        <div class="col-1 col-lg-auto mb-3 mb-lg-0 ms-auto me-lg-3">
          <form class="d-flex" role="search"  method="GET">
            <input type="search" name="q" class="form-control form-control-dark text-bg-light" placeholder="Estou procurando..." aria-label="Procurar">
          </form>
        </div>
      </div>
    </div>
  </header>
  <div class="container-fluid h-100 mt-3">
    <div class="row">
      <?php foreach($livros as $livro): ?>
        <div class="d-inline-flex col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4 ">
          <div class="card mt-4 p-4 shadow rounded-5 border border-3">
            <img class="img-fluid card-img-top border border-4 border-light rounded-4" style="width: 30rem; height: 25rem;" src="<?php echo $livro['capa']; ?>" alt="Capa do livro">
            <div class="card-body text-center">
              <a class="p-0" href="javascript:void(0)" >
                <img width="20rem" height="20rem" src="img/star-0.png" id="<?php echo 'e1' . $livro['id']; ?>">
              </a>
              <a class="p-0" href="javascript:void(0)" >
                <img width="20rem" height="20rem" src="img/star-0.png" id="<?php echo 'e2' . $livro['id']; ?>">
              </a>
              <a class="p-0" href="javascript:void(0)" >
                <img width="20rem" height="20rem" src="img/star-0.png" id="<?php echo 'e3' . $livro['id']; ?>">
              </a>
              <a class="p-0" href="javascript:void(0)" >
                <img width="20rem" height="20rem" src="img/star-0.png" id="<?php echo 'e4' . $livro['id']; ?>">
              </a>
              <a class="p-0" href="javascript:void(0)" >
                <img width="20rem" height="20rem" src="img/star-0.png" id="<?php echo 'e5' . $livro['id']; ?>">
              </a>
              <div class="dropdown">
                <h5 class="card-title text-capitalize fw-bold   fs-6" ><?php echo $livro['titulo']; ?></h5>
                <button class="dropdown-toggle bt-card rounded-4 btn btn-outline-secondary fs-6 fw-bold"type="button" data-bs-toggle="dropdown" aria-expanded="false" >MAIS</button>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                  <li class="mx-3 card-text fw-semibold">Autor:</li>
                    <p class="mx-4 fst-italic"> <?php echo $livro['autor']; ?></p>
                  <li class="mx-3 card-text fw-semibold">Genero: </li>
                    <p class="mx-4 fst-italic"><?php echo $livro['genero']; ?></p>
                  <li class="mx-3 card-text fw-semibold">Ano:</li>
                    <p class="mx-4 fst-italic"> <?php echo $livro['ano'];?></p>
                  <li class="mx-3 card-text fw-semibold">Editora: </li> 
                    <p class="mx-4 fst-italic"><?php echo $livro['editora']; ?></p>
                </ul> 
                <script>
                  
                    // aparece as estrelas no acervo
                    function EstrelasAcervo(avaliado , idlivro){
                                          
                      var estrelaId
                      for (var i = 1; i <= 5; i++) {
                        estrelaId = "e" + i + idlivro;
                        if (i <= avaliado) {
                          document.getElementById(estrelaId).src = "img/star-1.png";
                        } else {
                          document.getElementById(estrelaId).src = "img/star-0.png";
                        }
                      }
                    }


                    EstrelasAcervo(
                      <?php echo $livro['media'] ?>,
                      '<?php echo $livro['id'] ?>'
                    )
                </script>         
              </div>
            </div>
          </div>
        </div>
        <?php if ($livro === end($livros)): ?>
        <div class="w-100"></div> <!-- Adiciona uma linha horizontal após a última div do loop -->
      <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
  

 
 <!----------------------------------- footer ------------------------------------->
 <div class="container">

 <footer class=" w-100 row py-5 my-sm-4 border-top bottom-0">
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
  <script> verificarLogado( 
  <?php echo json_encode( $_SESSION['logado']); ?>,
  <?php echo json_encode($_SESSION['nome']) ;?> ,
  <?php echo json_encode($_SESSION['user_type']);?>
  )
   
  </script>
 
</body>


</html>