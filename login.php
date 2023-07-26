<?php
// INCIO PHP
include 'conexao.php';
// Iniciar a sessão
session_start();

ob_start();


  
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  
    // Obtenha os valores enviados pelo formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $senha_crip = password_hash($senha , PASSWORD_DEFAULT);
    
    // Preparar e executar a instrução SQL para buscar um usuário com o nome de usuário ou endereço de e-mail fornecido
    $stmt = $pdo->prepare('SELECT id, nome, email, senha, "usuario" AS tipo FROM usuarios WHERE email = ?
                          UNION
                          SELECT id, nome, email, senha, "funcionario" AS tipo FROM funcionarios WHERE email = ?');
    
    $stmt->execute([$email, $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  
    // Verificar se o usuário foi encontrado e se a senha fornecida está correta
    if ($usuario && password_verify($senha, $usuario['senha']))  {
     
      // Armazenar o ID do usuário na sessão
      $_SESSION['nome'] = $usuario['nome'];
      $_SESSION['id'] = $usuario['id'];
      
      // Verificar se o usuário é funcionário ou não
      if ($usuario['tipo'] == 'usuario' ) {
      
        $_SESSION['user_type'] = 'usuario';
      } else if ($usuario['tipo'] == 'funcionario') {
        $_SESSION['user_type'] = 'funcionario';
      }
      $_SESSION['logado'] = isset($_SESSION['user_type']);
      
     // Se tudo der certo o login e efetuado e a mensagem aparece 
     echo "<script>let resultado = 'login-correto'</script>";

      
    } else {
      // Caso contrário, exibe uma mensagem de login errado
       echo "<script>let resultado = 'login-incorreto';</script>";
    }
  }

?>
<!------------------------------------- INICIO HTML ------------------------------------------------>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Login</title>
  <link rel="icon" href="img/logo_aba.svg" type="image/x-icon">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function EfetuandoLogin(resultado){
          let modal = new bootstrap.Modal(document.getElementById(resultado));
        modal.show();
    }
  </script>
  <style>
    .link-senha{
      font-size: 13px;
      font-style: italic;
      text-decoration: none;
      color: #000;
    }
  </style>
</head>
<body class="container-fuid bg-info bg-opacity-25 row-8 align-items-center ">

    <div class=" col-md-4 col-sm-8 offset-auto mt-4 bg-light rounded-4 container-fluid fs-4 d-flex justify-content-center shadow " >
        
        <div class="text-center w-75">
        <h2 class="text-center mt-3">Faça Login</h2><br>
        <form action="#" method="post">
          <div class="mb-3 mt-3 fw-bold">
            <label for="email">Email:</label>
            <input type="email" class="form-control form-control-sm rounded-5" id="email" placeholder="Coloque o seu email" name="email" required>
          </div>
          <div class="mb-3 fw-bold">
            <label for="senha">Senha:</label>
            <input type="password" class="form-control form-control-sm rounded-5" id="senha" placeholder="Coloque sua senha " name="senha" required>
            <a href="cadastrar.php" class="link-senha"><em>Esqueceu a senha ?</em></a>
          </div>
          <br>
          <button type="submit" id="buttom" class="btn btn-success btn-outline-primary fs-5 rounded-4 text-light">Entrar</button>
          <br><a href="cadastrar.php" class="link-primary fs-6 text-decoration-none  "><em>Cadastrar</em></a> 
        </form>
          
          <div class="container-fluid mb-2 d-flex justify-content-start" >
            
            <a href="index.php" class="btn btn-outline-primary rounded-5 opacity-50 ">Voltar</a>
          </div>        
        </div>        
       </div>
<!----------------------------------- modal -------------------------------------->
<!----- modal de carregamento ------>
<div class="modal" tabindex="-1" id="carregamento" >
  <div class="modal-dialog modal-dialog-centered justify-content-center">
        <button class="btn btn-primary" type="button" disabled>
          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          Verificando...
        </button>
  </div>
</div>
<!---- modal login incorreto ---->
<div class="modal fade" id="login-incorreto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login mal sucedido !</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Dados de login incorretos. Por favor, tente novamente. </p>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
<!---- modal login correto ---->
<div class="modal fade" id="login-correto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title ">Login bem sucedido !</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Login efetuado com sucesso !</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="redirecionar()">Ok</button>
      </div>
    </div>
  </div>
</div>

<script src="js/javascript.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstra.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
EfetuandoLogin(resultado);  
</script>
          

</body>
</html>
