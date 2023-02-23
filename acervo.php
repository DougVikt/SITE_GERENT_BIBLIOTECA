<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <title>Biblioteca Amanajé</title>
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">

</head>
<body>
<?php
include 'conexao.php';

session_start(); 
$funcionario = false;
// verifica se e usuario ou funcionario
if (isset($_SESSION['funcionario']) && $_SESSION['funcionario'] == 1) {
   $funcionario = true;
}

// Consulta no banco de dados
$sql = "SELECT * FROM livros WHERE 1";
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
  $sql = "SELECT * FROM livros where 1";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <a class="btn btn-secondary btn-outline-dark rounded-4 " href="login.php" role="button" id="login">Login</a>
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
              <li class="nav-item dropdown">
                <a id="link-funcionario" class="nav-link nav-link active fs-5" href="cadastro_l.php">Cadastrar Livros</a>
              </li>
              <li class="nav-item dropdown">
                <a id="link-funcionario" class="nav-link nav-link active fs-5" href="cadastro_l.php">Emprestimo</a>
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
  <div class="container ">
	<div class="row d-flex flex-wrap">
		<?php foreach($livros as $livro): ?>
			<div class="col-md-2 col-sm-3 mb-3">
				<div class="card mt-3 shadow rounded-4 border border-3">
					<img class="card-img-top" src="data:image/jpeg;base64,<?php echo $livro['capa']; ?>" alt="Capa do livro">
					<div class="card-body">
						<h5 class="card-title"><?php echo $livro['titulo']; ?></h5>
            <ul>
              <li class="card-text">Autor: <?php echo $livro['autor']; ?></li>
              <li class="card-text">Genero: <?php echo $livro['genero']; ?></li>
              <li class="card-text">Ano: <?php echo $livro['ano'];?></li>
              <li class="card-text">Editora: <?php echo $livro['editora']; ?></li>
              <li class="card-text">Codigo: <?php echo $livro['codigo'];?></li>
            </ul>          
          </div>
        </div>
      </div>
  </div>
  </div>
  <?php endforeach; ?>

</main>   
 <!----------------------------------- footer ------------------------------------->
 
  <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-sm-4 border-top">
    <div class="col mb-3">
      <a href="/" class="d-flex align-items-center mb-3 link-dark text-decoration-none">
       
      </a>
      <p class="text-muted"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">© 2022</font></font></p>
    </div>

    <div class="col mb-3">

    </div>

    <div class="col mb-3">
      <h5><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Sobre</font></font></h5>
      <ul class="nav flex-column">
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Fone : 0000000000</font></font></a></li>
        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Email : xxxxxx@xxxxx</font></font></a></li>

      </ul>
    </div>

    

  </footer>
 
  <script src="js/javascript.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

 
</body>


</html>