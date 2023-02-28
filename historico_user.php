<!DOCTYPE php>
<php lang="pt-br">
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
include('conexao.php');
session_start();


// Obtém o ID do usuário da sessão
$usuario_id = $_SESSION['id'];


// Faz a consulta SQL para obter o histórico do usuário
// consulta no banco de dados caso nada consultado
$sql = "SELECT livro , retirada ,devolucao FROM emprestimo WHERE usuario = :user_id ";

$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $usuario_id]);
$historicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['q']) && !empty($_GET['q'])) {
  $q = $_GET['q'];
  $sql = "SELECT livro , retirada , devolucao FROM emprestimo
  WHERE ( livro LIKE :q OR retirada LIKE '%".date_format(date_create($q),'Y-m-d')."%' OR devolucao LIKE '%" . date_format(date_create($q), 'Y-m-d') . "%' )
  AND usuario = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['q' => $q, 'id' => $_SESSION['id']]);
  $historicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
  // código para recuperar todos os livros da tabela
  $sql = "SELECT livro , retirada ,devolucao FROM emprestimo WHERE usuario = :user_id ";

  $stmt = $pdo->prepare($sql);
  $stmt->execute(['user_id' => $usuario_id]);
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
          <p class="col-sm-8 text-capitalize fs-3 border-bottom border-primary fw-bold"><?php echo $_SESSION['nome'] ?></p>
          <form class="col-sm-4" method="POST" action="" >
            <button class="btn btn-outline-danger" type="submit" name="logout">Logout</button>
          </form>
          </div> 
          <?php } ?>
          <ul class="navbar-nav text-lg-center flex-grow-1 pe-4">
            <li class="nav-item">
              <a class="nav-link active fs-5" href="historico_user.php" id="historico">Historico</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link active fs-5" href="acervo.php" id="acervo">Acervo</a>
            </li>
          </ul>
          <br>
         </div>
      </div>
    </div>
  </nav>
  <br>
  <!---------------------------------------- separador e busca ---------------------------------------------------->
<header class="p-3 mx-auto mt-4 bg-info bg-gradient">
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <img class="img-fluid img-thumbnail rounded-circle" width="100" height="20" src="img/logo.png" alt="logo biblioteca Amanajé">
        </a>

        <div class="col-1 col-lg-auto mb-3 mb-lg-0 ms-auto me-lg-3">
            <form class="d-flex" role="search">
            <input type="search" class="form-control form-control-dark text-bg-light" placeholder="Procuro o livro..." aria-label="Procurar">
            </form>
        </div>
        

</div>
</header>
<!---------------------------------------------- tabela de usuarios ----------------------------------->
<?php if (count($historicos) > 0){ ?>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Livro</th>
        <th>Data de Empréstimo</th>
        <th>Data de Devolução</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($historicos as $historico) { ?>
        <tr>
          <td><?php echo $historico['livro']; ?></td>
          <td><?php echo date('d/m/Y', strtotime($historico['retirada'])); ?></td>
          <td><?php echo date('d/m/Y', strtotime($historico['devolucao'])); ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php }else { ?>
    <p class="text-capitalize text-lg-center fs-3">Você esta sem historico no momento</p> 
  <?php }?>
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
    <script src="js/javascript.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  
   
</body>
  
  
</php>
  