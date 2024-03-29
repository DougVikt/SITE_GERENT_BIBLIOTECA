
<?php
include 'conexao.php';
session_start();

  // pesquisando
if (isset($_GET['p']) && !empty($_GET['p'])) {

  $p = $_GET['p'];
  
  if (preg_match('/^\d{2}\/\d{2}$/', $p)) {
    $data_parts = explode('/', $p);
    $data_inicial = date_create_from_format('d/m', $p);
    if ($data_inicial !== false) {
      $data_inicial = $data_inicial->format('Y-m-d');
      $data_final = str_replace("/","-", $data_inicial);
      
    }
  } else {
    $data_final = '';
  }

  $sql = "SELECT emprestimo.*, usuarios.nome , livros.titulo as livro FROM emprestimo 
  INNER JOIN usuarios ON emprestimo.usuario = usuarios.id 
  INNER JOIN livros ON emprestimo.codigo = livros.id 
  WHERE nome LIKE '$p' OR livros.titulo LIKE '$p' OR status LIKE '$p' 
  OR retirada LIKE '$data_final' OR devolucao LIKE '$data_final'";

  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $emprestimos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  
} elseif(empty($_GET['p'])) {
   // consulta no banco de dados caso nada colsultado
  $sql = "SELECT emprestimo.*, usuarios.nome , livros.titulo as livro
  FROM emprestimo 
  INNER JOIN usuarios ON emprestimo.usuario = usuarios.id 
  INNER JOIN livros ON emprestimo.codigo = livros.id
  ORDER BY emprestimo.status desc";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $emprestimos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $p = null;
}

// trocando o status 
if (isset($_POST['confirme']) && $_POST['confirme'] == 1 && isset($_POST['id']) ) {
  
  $id = $_POST['id'];
  
  $sql = "UPDATE emprestimo SET status = 'entregue' WHERE id = ?";
  $exec = $pdo->prepare($sql);
  $exec->execute([$id]);
  
  header('Location: historico_funcio.php');
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
    <link rel="icon" href="img/logo_aba.svg">

</head>
<body>
<main  class="flex-grow-1">
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
              <a class="nav-link active fs-5" href="historico_funcio.php" >Historico</a>
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

<!---------------------------------------- separador e busca ---------------------------------------------------->
<header class="p-3 bg-info bg-gradient navbar-expand-lg w-100">
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <img class="img-fluid img-thumbnail rounded-circle" width="100" height="20" src="img/logo.png" alt="logo biblioteca Amanajé">
        </a>

        <div class="col-md-4 col-lg-3 col-sm-6  mb-3 mb-lg-0 ms-auto me-lg-3">
          <form class="d-flex" role="search" method="get" action="#">
            <input type="search" name="p" class="form-control form-control-dark text-bg-light" placeholder="Estou procurando..." aria-label="Procurar" value="<?php echo $p; ?>">
          </form>
        </div>
        </div>
    </div>
</header>

<!---------------------------------------------- tabela de usuarios ----------------------------------->
<div class="table-responsive">
<?php if (count($emprestimos) > 0){ ?>
<div class="container-fluid mx-0 text-center" style="height: 30rem;">
    <table class="table table-hover text-center">
      <thead>
        <tr class="table-primary">
          <th>Usuário</th>
          <th>Livro</th>
          <th>Data de Retirada</th>
          <th>Data de Devolução</th>
          <th>Status</th>
          <th>Entregue</th>
        </tr>
      </thead>
     
      <tbody >
        <?php foreach ($emprestimos as $emprestimo):?>
          <script>
            function Status(status, id) {
              let button = document.getElementById(`buttom-confirm-${id}`);
              let image = document.getElementById(`image-${id}`);
              let text = document.getElementById(`text-status-${id}`);

              if (status === 'entregue') {
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-outline-success');
                button.disabled = true;
                image.setAttribute('src', 'img/confirmar.png');
                image.setAttribute('data-state', 'cancelar');
                text.classList.remove('fw-bold');
              } else if (status === 'pendente') {
                button.classList.remove('btn-outline-success');
                button.classList.add('btn-outline-danger');
                button.disabled = false;
                image.setAttribute('src', 'img/cancelar.png');
                image.setAttribute('data-state', 'confirmar');
                
              }
            }
          </script>
          <tr <?php if ($emprestimo['status'] === 'entregue') {echo 'class="table-secondary"';} ?>>
            <td><?php echo $emprestimo['nome'];  ?></td>
            <td><?php echo $emprestimo['livro']; ?></td>
            <td><?php echo date("d/m/Y",strtotime($emprestimo['retirada']));  ?></td>
            <td><?php echo date("d/m/Y",strtotime($emprestimo['devolucao']));  ?></td>
            <td><p class="fw-bold text-capitalize" id="text-status-<?php echo $emprestimo['id'] ?>"><?php echo $emprestimo['status'] ?></p> </td>
            <td>
              <form method="post" action="#">
                <input type="hidden" name="id" value="<?php echo $emprestimo['id'] ?>">
                <input type="hidden" name="confirme" value="1">
                <button class="btn btn-outline-danger p-0" id="buttom-confirm-<?php echo $emprestimo['id'] ?>" onclick="Confirmando(this , '<?php echo $emprestimo['status'] ?>')" >
                  <img style="width: 3rem; height: 2rem;" class="btn" id="image-<?php echo $emprestimo['id'] ?>" src="img/cancelar.png" alt="icone de confirmação" data-state="confirmar"> 
                </button>
              </form>
              <script>
                Status('<?php echo $emprestimo['status'] ?>', 
                <?php echo $emprestimo['id'] ?>);
              </script>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php }else { ?>
      <div class="container-fluid"style="height: 20rem;">
        <p class="text-capitalize text-lg-center fs-3 " >Desculpe, não encontramos nenhum resultado correspondente à sua pesquisa. Por favor, tente novamente com termos diferentes.</p> 
      </div>
     <?php }?>
  </div>
</div>
 <!----------------------------------- footer ------------------------------------->
 <div class="container-fluid divi-card " style="height: 15rem;">
  <footer class=" flex-fill my-sm-4 border-top p-4">
    <div class="mb-5 mt-4">
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
  