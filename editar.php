<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>editar</title>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="shortcut icon" href="img/logo_aba.svg" type="image/x-icon">

</head>
<?php
include('conexao.php');
session_start();

// selecionado tudo da tabela livros
$sql = "SELECT * FROM livros where 1 ";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ao apertar 'excluir' , exclui os dados do livro em questão
if (isset($_POST['excluir'])){
  $id = $_POST['id'];
    
  $sql = "DELETE FROM avaliacoes WHERE id_livro = :id ; DELETE FROM livros WHERE id= :id ";
  $stmt= $pdo ->prepare($sql);
  $stmt->execute([':id'=>$id]);

  header('Location: editar.php');
}



?>
<body>
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
  <?php echo $id ?>
  <!----------------------------------- tabela ----------------------------------->
  <?php if (count($livros) > 0){ ?>
<div class="container-fluid mt-5 pb-3"  >
    <table class="table text-center  table-hover">
      <thead>
        <tr class="table-primary">
          <th>Titulo</th>
          <th>Autor</th>
          <th>Editora</th>
          <th>Ano</th>
          <th>Genero</th>
          <th></th>
        </tr>
      </thead>
     
      <tbody>
        <?php foreach ($livros as $livro):?>
          <tr>
            <td><?php echo $livro['titulo'];  ?></td>
            <td><?php echo $livro['autor']; ?></td>
            <td><?php echo $livro['editora'];  ?></td>
            <td><?php echo $livro['ano'];  ?></td>
            <td><?php echo $livro['genero'];  ?></td>
            <td>
              <button class="btn btn-warning border-dark  text-dark fs-6" type="button"  data-toggle="modal" data-target="#myModal">
                Editar 
                </button>
              <form method="post" action="#">
                <input type="hidden" name="id" value="<?php echo $livro['id'] ?>">
                <button class="btn btn-danger border-dark fs-6" type="submit" name="excluir" id="excluir">Excluir </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        
      </tbody>
    </table>
    <?php }else { ?>
    <p class="text-capitalize text-lg-center fs-3">Sem livros no acervo</p> 
  <?php }?>
  </div>

<!------------------ Modal --------------------------->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold fs-4" id="myModalLabel">Editar Livro</h5>
        <button type="button" class="btn-close" aria-label="Close" data-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="#" enctype="multipart/form-data" class="fs-5 fw-bold">
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
            <input type="file" class="form-control rounded-4 border-info shadow-sm" id="capa" name="capa" title="Formato recomendado : jpg ou jpeg " >
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary">Salvar mudanças</button>
      </div>
    </div>
  </div>
</div>

 <!----------------------------------- footer ------------------------------------->
 <div class="container-fluid divi-card" style="height: 20rem;">
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

</body>
</html>