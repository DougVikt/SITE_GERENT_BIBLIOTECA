<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-info  bg-opacity-25">
  <?php
  // Verifica se o formulário foi submetido
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenha os valores enviados pelo formulário
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Verifica se o usuário e a senha estão corretos (aqui, isso é simulado com um usuário e senha hardcoded)
    if ($username === 'user' && $password === 'pass') {
      // Inicie a sessão e armazene o ID do usuário nela
      session_start();
      $_SESSION['user_id'] = 1;
      
      // Redirecione para a página inicial
      header('Location: index.php');
      exit;
    } else {
      // Caso contrário, exibe uma mensagem de erro
      echo "Usuário ou senha inválidos";
    }
  }
?>

    <div class="bg-light rounded-4 container w-25 p-5 fs-4 d-flex justify-content-center shadow  position-absolute top-50 start-50 translate-middle">
        <div class="text-center">
        <h2 class="text-center">Faça Login</h2><br>
        <form action="/action_page.php">
          <div class="mb-3 mt-3 fw-bold">
            <label for="email">Email:</label>
            <input type="email" class="form-control form-control-sm rounded-5" id="email" placeholder="Coloque o seu email" name="email">
          </div>
          <div class="mb-3 fw-bold">
            <label for="pwd">Senha:</label>
            <input type="password" class="form-control form-control-sm rounded-5" id="pwd" placeholder="Coloque sua senha " name="pswd">
          </div>
          <div class="form-check mb-3 fs-6 ">
            <label class="form-check-label">
              <input class="form-check-input" type="checkbox" name="remember"> Lembrar
            </label>
          </div>
          <br>
          <button type="submit" class="btn btn-warning btn-outline-primary fs-5 rounded-4">Entrar</button>
        </form>
        <a href="cadastrar.html" class="link-primary fs-6">Cadastrar</a>
        </div>
    </div>
      

</body>
</html>
