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
<?php
include 'conexao.php';
session_start(); 

$funcionario = false;
// verifica se e usuario ou funcionario
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'funcionario') {
   $funcionario = true;
}
// pega as capas dos livros
$sql = "SELECT * FROM livros ORDER BY id DESC LIMIT 3";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$livros = $stmt->fetchAll(PDO::FETCH_ASSOC);


// pega os livros com o ano mais recente e que foi recem adicionado
$sql2 = "SELECT * FROM livros ORDER BY ano desc , id DESC limit 3 ";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$livro_lan = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// pega os livros com a maior avaliação
$sql3 = "SELECT capa, livros.titulo, AVG(avaliacoes.avaliacao) as media FROM avaliacoes
          JOIN livros ON avaliacoes.id_livro = livros.id GROUP BY livros.titulo ORDER BY media DESC LIMIT 3";
$stmt3 = $pdo->prepare($sql3);
$stmt3->execute();
$livro_ava = $stmt3->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['logout'])) {
  // Destrói a sessão
  session_destroy();
  header('Location: index.php');
}
?>
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
          <?php if(isset($_SESSION['logado'])):?>
          <!---------------- aparece o nome do usuario e botão de logout pos logado  ------------>
         <div class="row" id="logout">
          <p id="usuarioLogado" class="col-sm-8 text-capitalize fs-3 border-bottom border-primary fw-bold"></p>
          <form class="col-sm-4" method="POST" action="" >
            <button class="btn btn-outline-danger" type="submit" name="logout">Sair</button>
          </form>
          </div> 
          <?php endif; ?>
          <div class="sticky-sm-bottom row-2" style="text-align-last: center;" id="botoes-iniciais">
            <a class="btn btn-secondary btn-outline-light rounded-4" href="login.php" role="button" id="login" >Login</a>
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
  <!---------------------------------- logo central --------------------------------------->

  <div class="shadow-lg p-3 mb-4 bg-body rounded-circle border border-5  mx-auto w-50" style="margin-top: 20px;">

    <img class="img-fluid rounded-circle" src="img/logo.png" alt="logo biblioteca Amanajé">

  </div>

  <!-------------------------------- cards carrossel ------------------------------------------------->
<div class="containeri-fluid">
  <div id="meuCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="card-deck">  
          <div class="container-fluid mt-3 shadow divi-card">
            <h3 class="card-2 fw-bold fs-2"> NOVAS AQUISIÇÕES</h3>
          </div>
          <div class="row row-cols-1 row-cols-md-4">
            <div class="mx-auto ">
              <div class="col h-100">
                <div class="card shadow h-100 rounded-5" >
                  <img class="img-fluid bd-placeholder-img card-img-top border border-4 border-light rounded-5" width="100%" height="100%" src="<?php echo $livros['0']['capa'] ?>" aria-label="Espaço reservado: Miniatura" ></img>
                  <div class="card-body">
                    <p class="card-text fs-3 fw-bold text-capitalize text-center" style="vertical-align: inherit;"> <?php echo $livros['0']['titulo'] ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="mx-auto" >
              <div class="col h-100">
                <div class="card shadow h-100 rounded-5">
                    <img class="img-fluid bd-placeholder-img card-img-top border border-4 border-light rounded-5" width="100%" height="100%" src="<?php echo $livros['1']['capa'] ?>" aria-label="Espaço reservado: Miniatura" ></img>
                    <div class="card-body">
                      <p class="card-text fs-3 fw-bold text-capitalize text-center" style="vertical-align: inherit;"> <?php echo $livros['1']['titulo'] ?></p>
                    </div>
                </div>
              </div>
            </div>
            <div class="mx-auto">
              <div class="col h-100">
                <div class="card shadow h-100 rounded-5">
                    <img class="img-fluid bd-placeholder-img card-img-top border border-4 border-light rounded-5" width="100%" height="100%" src="<?php echo $livros['2']['capa'] ?>" aria-label="Espaço reservado: Miniatura" ></img>
                    <div class="card-body">
                      <p class="card-text fs-3 fw-bold text-capitalize text-center" style="vertical-align: inherit;"> <?php echo $livros['2']['titulo'] ?></p>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="card-deck">
          <div class="container-fluid mt-3 shadow  divi-card">
            <h3 class="card-2 fw-bold fs-2"> LANÇAMENTOS </h3>
          </div>
          <div class="row row-cols-1 row-cols-md-4 ">
          <div class="mx-auto">
              <div class="col h-100">
                <div class="card shadow h-100 rounded-5">
                    <img class="img-fluid bd-placeholder-img card-img-top border border-4 border-light rounded-5" width="100%" height="100%" src="<?php echo $livro_lan['0']['capa'] ?>" aria-label="Espaço reservado: Miniatura" ></img>
                    <div class="card-body">
                      <p class="card-text fs-3 fw-bold text-capitalize text-center" style="vertical-align: inherit;"> <?php echo $livro_lan['0']['titulo'] ?></p>
                    </div>
                </div>
              </div>
            </div>
            <div class="mx-auto">
              <div class="col h-100">
                <div class="card shadow h-100 rounded-5">
                    <img class="img-fluid bd-placeholder-img card-img-top border border-4 border-light rounded-5" width="100%" height="100%" src="<?php echo $livro_lan['1']['capa'] ?>" aria-label="Espaço reservado: Miniatura" ></img>
                    <div class="card-body">
                      <p class="card-text fs-3 fw-bold text-capitalize text-center" style="vertical-align: inherit;"> <?php echo $livro_lan['1']['titulo'] ?></p>
                    </div>
                </div>
              </div>
            </div>
            <div class="mx-auto">
              <div class="col h-100">
                <div class="card shadow h-100 rounded-5">
                    <img class="img-fluid bd-placeholder-img card-img-top border border-4 border-light rounded-5" width="100%" height="100%" src="<?php echo $livro_lan['2']['capa'] ?>" aria-label="Espaço reservado: Miniatura" ></img>
                    <div class="card-body">
                      <p class="card-text fs-3 fw-bold text-capitalize text-center" style="vertical-align: inherit;"> <?php echo $livro_lan['2']['titulo'] ?></p>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="card-deck">
          <div class="container-fluid mt-3 shadow divi-card">
            <h3 class="card-2 fw-bold fs-2"> MELHOR AVALIADOS </h3>
          </div>
          <div class="row row-cols-1 row-cols-md-4 ">
          <div class="mx-auto">
              <div class="col h-100">
                <div class="card shadow h-100 rounded-5">
                    <img class="img-fluid bd-placeholder-img card-img-top border border-4 border-light rounded-5" width="100%" height="100%" src="<?php echo $livro_ava['0']['capa'] ?>" aria-label="Espaço reservado: Miniatura" ></img>
                    <div class="card-body">
                      <p class="card-text fs-3 fw-bold text-capitalize text-center" style="vertical-align: inherit;"> <?php echo $livro_ava['0']['titulo'] ?></p>
                    </div>
                </div>
              </div>
            </div>
            <div class="mx-auto">
              <div class="col h-100">
                <div class="card shadow h-100 rounded-5">
                    <img class="img-fluid bd-placeholder-img card-img-top border border-4 border-light rounded-5" width="100%" height="100%" src="<?php echo $livro_ava['1']['capa'] ?>" aria-label="Espaço reservado: Miniatura" ></img>
                    <div class="card-body">
                      <p class="card-text fs-3 fw-bold text-capitalize text-center" style="vertical-align: inherit;"> <?php echo $livro_ava['1']['titulo'] ?></p>
                    </div>
                </div>
              </div>
            </div>
            <div class="mx-auto">
              <div class="col h-100">
                <div class="card shadow h-100 rounded-5">
                    <img class="img-fluid bd-placeholder-img card-img-top border border-4 border-light rounded-5" width="100%" height="100%" src="<?php echo $livro_ava['2']['capa'] ?>" aria-label="Espaço reservado: Miniatura" ></img>
                    <div class="card-body">
                      <p class="card-text fs-3 fw-bold text-capitalize text-center" style="vertical-align: inherit;"> <?php echo $livro_ava['2']['titulo'] ?></p>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#meuCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only"></span>
    </a>
    <a class="carousel-control-next" href="#meuCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only"></span>
    </a>
  </div>
</div>
 <!----------------------------------- footer ------------------------------------->
 <div class="container-fluid divi-card">
  <footer class="row py-5 my-sm-4 border-top">
    <div class="col mb-3">
      <a href="#" class="d-flex align-items-center mb-3 link-dark text-decoration-none">
       <p class="text-center fs-4 mb-3 fw-bold w-100">+ 700 livros no nosso acervo</p>
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
  
 <!---------------------------------------------- scripts -------------------------------------------------->

  <script src="js/javascript.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
 <!--------- função pos logado ----------->
 <script> verificarLogado( 
  <?php echo json_encode( $_SESSION['logado']); ?>,
  <?php echo json_encode($_SESSION['nome']) ;?> ,
  <?php echo json_encode($_SESSION['user_type']);?>
  )
   
  </script>
 
</body>



