
 <?php
include('conexao.php');
session_start();


// Obtém o ID do usuário da sessão
$usuario_id = $_SESSION['id'];
$data_hoje = date('Y-m-d');
$dataPreAtra = date('Y-m-d' , strtotime('-3 days'));

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

  $sql = "SELECT emprestimo.* , livros.titulo FROM emprestimo
  INNER JOIN livros on emprestimo.codigo = livros.id
  WHERE ( livros.titulo LIKE '$p' OR retirada LIKE '$data_final' OR devolucao LIKE '$data_final' )
  AND usuario = '$usuario_id'";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $historicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (!$historicos){
    $emprest = true;
  }else{
    $emprest = false;
  }

} else {
  $p = '';
  // código para recuperar todos os livros da tabela
  $sql = "SELECT emprestimo.* , livros.titulo FROM emprestimo 
  INNER JOIN livros ON emprestimo.codigo = livros.id
  WHERE emprestimo.usuario = :user_id " ;

  $stmt = $pdo->prepare($sql);
  $stmt->execute(['user_id' => $usuario_id]);
  $historicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
if(isset($_POST['logout'])) {
  // Destrói a sessão
  session_destroy();
  header('Location: index.php');
}



// entrada para a avaliação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){

  $avaliacao = $_POST['avaliacao'];
  $livro = $_POST['idlivro'];

  $sql = "SELECT * FROM avaliacoes WHERE id_usuario = :userid AND id_livro = :livro";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":userid", $usuario_id );
  $stmt->bindParam(":livro", $livro );
  $stmt->execute();
  $resposta = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if(count($resposta) > 0){
    $sql2 = "UPDATE avaliacoes SET avaliacao = :avalia WHERE id_usuario = :userid AND id_livro = :livro";
  }
  else{
    $sql2 = "INSERT INTO avaliacoes (id_usuario , id_livro , avaliacao) VALUES (:userid , :livro , :avalia )";
  }
    $stmt = $pdo->prepare($sql2);
    $stmt->bindParam(":userid", $usuario_id );
    $stmt->bindParam(":livro", $livro );
    $stmt->bindParam(":avalia", $avaliacao );
    $stmt->execute();
  
  header('Location:historico_user.php');
  
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
  <nav class="navbar bg-info sticky-top" aria-label="Offcanvas navbar large">
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
  <!---------------------------------------- separador e busca ---------------------------------------------------->
  <header class="p-3 bg-info bg-gradient navbar-expand-lg w-100">
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start">
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
<?php if (count($historicos) > 0){ ?>
  <div class="container-fluid mx-0 text-center" style="height: 30rem;">
  <table class="table table-striped table-sm text-center">
    <thead>
      <tr>
        <th>Livro</th>
        <th>Data de Empréstimo</th>
        <th>Data de Devolução</th>
        <th>Avaliação</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($historicos as $historico) { ?>
      <tr>
          <td><?php echo $historico['titulo']; ?></td>
         <td><?php echo date('d/m/Y', strtotime($historico['retirada'])); ?></td>
         <td><?php 
            if ($data_hoje > $historico['devolucao']){
              echo '<span style="color: red;">'.date('d/m/Y', strtotime($historico['devolucao'])).'-ATRASADA </span>';
            }
            else if ($dataPreAtra >= $historico['devolucao']){
              echo '<span style="color: yellow;">'.date('d/m/Y', strtotime($historico['devolucao'])).'-PERTO DO VENCIMENTO </span>';
            }
            else {
               echo '<span style="color: green;">'.date('d/m/Y', strtotime($historico['devolucao'])).'</span>'; 
            }
          ?></td>
        
          <td>
            <?php 
              $livro = $historico['codigo'];

              $sql = "SELECT avaliacao FROM avaliacoes WHERE id_livro = :livro and id_usuario = :usuario ";
            
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(":livro" , $livro);
              $stmt->bindParam(":usuario",$usuario_id);
              $stmt->execute();
              $avaliacao = $stmt->fetchAll(PDO::FETCH_ASSOC);   
            ?> 
            <script>
              function ExibirEstrelas(avaliado , idlivro){
                      var estrelaId
                      for (var i = 1; i <= 5; i++) {
                        estrelaId = "s" + i + idlivro;
                        if (i <= avaliado) {
                          document.getElementById(estrelaId).src = "img/star-1.png";
                        } else {
                          document.getElementById(estrelaId).src = "img/star-0.png";
                        }
                      }
                    }
            </script>
            <div class="container-fluid">
              <form method="post" action="">
                <a class="p-0" href="javascript:void(0)" onclick="Avaliar(1, '<?php echo $historico['codigo']; ?>' )">
                  <img width="20rem" height="20rem" src="img/star-0.png" id="<?php echo 's1' . $historico['codigo']; ?>"></a>
                <a class="p-0" href="javascript:void(0)" onclick="Avaliar(2, '<?php echo $historico['codigo']; ?>' )">
                  <img width="20rem" height="20rem" src="img/star-0.png" id="<?php echo 's2' . $historico['codigo']; ?>"></a>
                <a class="p-0" href="javascript:void(0)" onclick="Avaliar(3, '<?php echo $historico['codigo']; ?>' )">
                  <img width="20rem" height="20rem" src="img/star-0.png" id="<?php echo 's3' . $historico['codigo']; ?>"></a>
                <a class="p-0" href="javascript:void(0)" onclick="Avaliar(4, '<?php echo $historico['codigo']; ?>')">
                  <img width="20rem" height="20rem" src="img/star-0.png" id="<?php echo 's4' . $historico['codigo']; ?>"></a>
                <a class="p-0" href="javascript:void(0)" onclick="Avaliar(5, '<?php echo $historico['codigo']; ?>')">
                  <img width="20rem" height="20rem" src="img/star-0.png" id="<?php echo 's5' . $historico['codigo']; ?>"></a>
                <input type="hidden" name="idlivro" value="<?php echo $historico['codigo']; ?>">
                <input type="hidden" name="avaliacao" id="avaliacao<?php echo $historico['codigo']; ?>" value="">
                <button type="submit" name="submit" id="bt-submit" class= " ms-3 btn btn-outline-success fs-6">Avaliar</button>
              </form>
            </div>
           <script>
              ExibirEstrelas(
                <?php echo $avaliacao[0]['avaliacao'] ?>,
                '<?php echo $historico['codigo'] ?>'
              )
            </script>
        </tr>
      <?php } ?>
    </tbody>
  </table>
    <div>
      <?php } else if ($emprest){ ?>
        <p class="text-capitalize text-lg-center fs-4"style="height: 30rem;">Desculpe, não encontramos nenhum resultado correspondente à sua pesquisa. Por favor, tente novamente com termos diferentes.</p> 
      <?php } else {?>
        <p class="text-capitalize text-lg-center fs-4"style="height: 30rem;">Sem historicos no momento !</p> 
      <?php } ?>
    </div>
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
  
  
</php>
  