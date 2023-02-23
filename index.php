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
<?php
session_start(); 
$funcionario = false;
// verifica se e usuario ou funcionario
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'funcionario') {
   $funcionario = true;
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
                <a id="link-funcionario" class="nav-link nav-link active fs-5" href="cadastro_l.html">Cadastrar Livros</a>
              </li>
              <li class="nav-item dropdown">
                <a id="link-funcionario" class="nav-link nav-link active fs-5" href="emprestimo.html">Emprestimo</a>
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
    <h1 class="text-center fs-2 fw-bold">+ 700 livros</h1>
  </div>

  <!-------------------------------- cards carrossel ------------------------------------------------->
  <div id="meuCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="card-deck">  
          <div class="container-fluid mt-3 shadow divi-card">
            <h3 class="card-2 fw-bold fs-2"> NOVAS AQUISIÇÕES</h3>
          </div>
          <div class="row row-cols-1 row-cols-md-4 ">
            <div class="card mx-auto">
              <div class="col">
                <div class="card shadow-sm">
                  <svg class="bd-placeholder-img card-img-top" width="50%" height="425" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Espaço reservado: Miniatura" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                  <div class="card-body">
                    <p class="card-text"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Este é um cartão mais amplo com texto de apoio abaixo como uma entrada natural para conteúdo adicional. </font><font style="vertical-align: inherit;">Este conteúdo é um pouco mais longo.</font></font></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="card mx-auto">
              <div class="col">
                <div class="card shadow-sm">
                  <svg class="bd-placeholder-img card-img-top" width="50%" height="425" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Espaço reservado: Miniatura" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                    <div class="card-body">
                      <p class="card-text"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Este é um cartão mais amplo com texto de apoio abaixo como uma entrada natural para conteúdo adicional. </font><font style="vertical-align: inherit;">Este conteúdo é um pouco mais longo.</font></font></p>
                    </div>
                </div>
              </div>
            </div>
            <div class="card mx-auto">
              <div class="col">
                <div class="card shadow-sm">
                  <svg class="bd-placeholder-img card-img-top" width="50%" height="425" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Espaço reservado: Miniatura" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                  <div class="card-body">
                    <p class="card-text"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Este é um cartão mais amplo com texto de apoio abaixo como uma entrada natural para conteúdo adicional. </font><font style="vertical-align: inherit;">Este conteúdo é um pouco mais longo.</font></font></p>
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
            <h3 class="card-2 fw-bold fs-2"> NOVAS AQUISIÇÕES</h3>
          </div>
          <div class="row row-cols-1 row-cols-md-4 ">
            <div class="card mx-auto">
              <div class="col">
                <div class="card shadow-sm">
                  <svg class="bd-placeholder-img card-img-top" width="50%" height="425" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Espaço reservado: Miniatura" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                  <div class="card-body">
                    <p class="card-text"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Este é um cartão mais amplo com texto de apoio abaixo como uma entrada natural para conteúdo adicional. </font><font style="vertical-align: inherit;">Este conteúdo é um pouco mais longo.</font></font></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="card mx-auto">
              <div class="col">
                <div class="card shadow-sm">
                  <svg class="bd-placeholder-img card-img-top" width="50%" height="425" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Espaço reservado: Miniatura" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                  <div class="card-body">
                    <p class="card-text"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Este é um cartão mais amplo com texto de apoio abaixo como uma entrada natural para conteúdo adicional. </font><font style="vertical-align: inherit;">Este conteúdo é um pouco mais longo.</font></font></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="card mx-auto">
              <div class="col">
                <div class="card shadow-sm">
                  <svg class="bd-placeholder-img card-img-top" width="50%" height="425" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Espaço reservado: Miniatura" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                  <div class="card-body">
                    <p class="card-text"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Este é um cartão mais amplo com texto de apoio abaixo como uma entrada natural para conteúdo adicional. </font><font style="vertical-align: inherit;">Este conteúdo é um pouco mais longo.</font></font></p>
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
            <h3 class="card-2 fw-bold fs-2"> NOVAS AQUISIÇÕES</h3>
          </div>
          <div class="row row-cols-1 row-cols-md-4 ">
            <div class="card mx-auto">
              <div class="col">
                <div class="card shadow-sm">
                  <svg class="bd-placeholder-img card-img-top" width="50%" height="425" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Espaço reservado: Miniatura" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                  <div class="card-body">
                    <p class="card-text"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Este é um cartão mais amplo com texto de apoio abaixo como uma entrada natural para conteúdo adicional. </font><font style="vertical-align: inherit;">Este conteúdo é um pouco mais longo.</font></font></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="card mx-auto">
              <div class="col">
                <div class="card shadow-sm">
                  <svg class="bd-placeholder-img card-img-top" width="50%" height="425" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Espaço reservado: Miniatura" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                  <div class="card-body">
                    <p class="card-text"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Este é um cartão mais amplo com texto de apoio abaixo como uma entrada natural para conteúdo adicional. </font><font style="vertical-align: inherit;">Este conteúdo é um pouco mais longo.</font></font></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="card mx-auto">
              <div class="col">
                <div class="card shadow-sm">
                  <svg class="bd-placeholder-img card-img-top" width="50%" height="425" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Espaço reservado: Miniatura" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                  <div class="card-body">
                    <p class="card-text"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Este é um cartão mais amplo com texto de apoio abaixo como uma entrada natural para conteúdo adicional. </font><font style="vertical-align: inherit;">Este conteúdo é um pouco mais longo.</font></font></p>
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
