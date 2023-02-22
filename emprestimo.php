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
 
<main>
  <!-------------------------------------- inicio do navbar ------------------------------>
  <nav class="navbar bg-info fixed-top" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold fs-4 " href="index.html">
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
            <a class="btn btn-secondary btn-outline-dark rounded-4 " href="login.html" role="button" id="login">Login</a>
            <div class="vr"></div>
            <a class="btn btn-danger btn-outline-light rounded-4 " href="cadastrar.html" role="button" id="cadastro">Cadastrar</a>
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
  <div class="container mt-3 w-75 d-flex flex-column ">
    <h2 class="mb-3 text-center">Emprestimo</h2>
    <form method="post" action="#" enctype="multipart/form-data" class="fs-5 fw-bold">
      <div class="mb-3">
        <label for="titulo">Nome:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="titulo" name="titulo">
      </div>
      <div class="mb-3">
        <label for="nome-livro">Tìtulo do livro:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="autor" name="autor">
      </div>
      <div class="mb-3">
        <label for="codigo-livro">Código:</label>
        <input type="text" class="form-control rounded-4 border-info shadow-sm" id="codigo" name="codigo">
      </div>
      <div class="mb-3">
        <label for="data-emprestimo">Data da Retirada:</label>
        <input type="date" class="form-control rounded-4 border-info shadow-sm" id="editora" name="editora">
      </div>
      <div class="mb-3">
        <label for="data-entrega">Data de Devolução:</label>
        <input type="date" class="form-control rounded-4 border-info shadow-sm" id="ano" name="ano">
      </div>
      <button type="submit" class="btn btn-info">Cadastrar</button>
    </form>
  </div>
  
 <!----------------------------------- footer ------------------------------------->
 <div class="container position-absolute top-100 start-50 translate-middle mt-lg-5">
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
 </div>
</main> 
  <script src="js/javascript.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

 
</body>


</html>
