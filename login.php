<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Login</title>
  <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-info  bg-opacity-25">
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
    $stmt = $pdo->prepare('SELECT *, "usuario" AS tipo , id , email , senha FROM usuarios WHERE email = ? 
                          UNION
                          SELECT *, "funcionario" AS tipo , id ,email , senha FROM funcionarios WHERE email = ? ');
    
    $stmt->execute([$email, $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  
    // Verificar se o usuário foi encontrado e se a senha fornecida está correta
    if ($usuario && password_verify($senha, $usuario['senha']))  {
     
      // Armazenar o ID do usuário na sessão
      $_SESSION['nome'] = $usuario['id'];
      
      // Verificar se o usuário é funcionário ou não
      if (is_null($usuario['is_funcionario'])) {
      
        $_SESSION['user_type'] = 'usuario';
      } else {
        $_SESSION['user_type'] = 'funcionario';
      }
      $logado = isset($_SESSION['user_type']);
      echo json_encode($logado);
      echo "<script>alert('Login efetuado com sucesso !')</script>";
      // Redirecionar para a página inicial
      header('Location: index.php');
      exit;
    } else {
      // Caso contrário, exibe uma mensagem de erro
       echo "<script> alert('Usuário ou senha inválidos');</script>";
    }
  }
?>
    <div class="bg-light rounded-4 container w-25 p-5 fs-4 d-flex justify-content-center shadow  position-absolute top-50 start-50 translate-middle">
        
        <div class="text-center">
        <h2 class="text-center">Faça Login</h2><br>
        <form action="" method="post">
          <div class="mb-3 mt-3 fw-bold">
            <label for="email">Email:</label>
            <input type="email" class="form-control form-control-sm rounded-5" id="email" placeholder="Coloque o seu email" name="email">
          </div>
          <div class="mb-3 fw-bold">
            <label for="senha">Senha:</label>
            <input type="password" class="form-control form-control-sm rounded-5" id="senha" placeholder="Coloque sua senha " name="senha">
          </div>
          <div class="form-check mb-3 fs-6 ">
            <label class="form-check-label">
              <input class="form-check-input" type="checkbox" name="remember"> Lembrar
            </label>
          </div>
          <br>
          <button type="submit" class="btn btn-warning btn-outline-primary fs-5 rounded-4">Entrar</button>
        </form>
          <a href="cadastrar.php" class="link-primary fs-6">Cadastrar</a>
          <div class="position-absolute bottom-0 start-0 mb-2 mx-2" >
            <a href="index.php" class="btn btn-primary">< Voltar</a>
          </div>
        
        </div>
        
       </div>
      
          

</body>
</html>
