<?php
include 'conexao.php';
// Iniciar a sessão
session_start();

ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  
// Verifica se o formulário foi submetido
 
  
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
      
     // Redirecionar para a página inicial
     echo "<script>alert('Login efetuado com sucesso!'); window.location='index.php';</script>";

      exit;
    } else {
      // Caso contrário, exibe uma mensagem de erro
       echo "<script> alert('Usuário ou senha inválidos');</script>";
    }
  }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Login</title>
  <link rel="icon" href="img/logo_aba.svg" type="image/x-icon">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-info  bg-opacity-25 ">

    <div class="bg-light rounded-4 container p-5 fs-4 d-flex justify-content-center shadow  position-absolute top-50 start-50 translate-middle " style="width: 40%;">
        
        <div class="text-center w-75">
        <h2 class="text-center">Faça Login</h2><br>
        <form action="#" method="post">
          <div class="mb-3 mt-3 fw-bold">
            <label for="email">Email:</label>
            <input type="email" class="form-control form-control-sm rounded-5" id="email" placeholder="Coloque o seu email" name="email" require>
          </div>
          <div class="mb-3 fw-bold">
            <label for="senha">Senha:</label>
            <input type="password" class="form-control form-control-sm rounded-5" id="senha" placeholder="Coloque sua senha " name="senha" require>
          </div>
          <br>
          <button type="submit" id="buttom" class="btn btn-success btn-outline-primary fs-5 rounded-4 text-light">Entrar</button>
        </form>
          <a href="cadastrar.php" class="link-primary fs-6">Cadastrar</a>
          <div class="position-absolute bottom-0 start-0 mb-2 mx-2" >
            <a href="index.php" class="btn btn-outline-primary rounded-5 ">Voltar</a>
          </div>
        
        </div>
        
       </div>
   
  <script src="js/javascript.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

          

</body>
</html>
