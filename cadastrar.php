<?php
include 'conexao.php';
// Inicie a sessão
session_start();

// simplificando a consulta 
function executar($pdo, $sql , $nome , $email, $tele ,$cpf , $senha){
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':nome', $nome);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':tele', $tele);
  $stmt->bindParam(':cpf', $cpf);
  $stmt->bindParam(':senha', $senha);
  return $stmt;
}


if (isset($_POST['submit'])){
  
  $stmt = null;
  // variavel do codigo dos funcionarios
  $funcio = "BIB378AMA479JE";

  // Defina as variáveis de erro  
  $senhaErro = $emailErro = $codigoErro = '';
  
    
  // Processar os dados do formulário
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $tele = $_POST['tele'];
  $cpf = $_POST['cpf'];
  $senha = $_POST['pswd'];
  $confsenha = $_POST['pswd2'];
  $codigo = $_POST['codigo'];

  // Validar os dados do formulário

  if (empty($email)) {
      $emailErro = 'Por favor, insira seu email.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErro = 'Por favor, insira um email válido.';
  }
  if ($senha !== $confsenha) {
    // verifica se a senha e a confirmação são iguais
    $senhaErro = 'A senha e a confirmação de senha não correspondem.';
  }elseif (strlen($senha) < 8) {
    // verifica se a senha tem no minimo 8 caracteres
    echo 'A senha deve ter pelo menos 8 caracteres';
  }else {
    // criptocravando as senhas para mais segurança
    $senhaCript = password_hash($senha , PASSWORD_DEFAULT);
  }
  if (!empty($codigo) && $codigo !== $funcio){
    $codigoErro = 'Codigo do funcionario incorreto. ';
  }

  // verifica se o CPF já existe no banco
  if ($codigo == $funcio){
    $sql = "SELECT * FROM funcionarios WHERE cpf = :cpf";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    $funcionario = $stmt->fetch();
    $usuario = false ;
  }else{
    $sql = "SELECT * FROM usuarios WHERE cpf = :cpf";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    $usuario = $stmt->fetch();
    $funcionario = false ;
  }
  
  // mensagem de erro para caso o cpf colocado ja tenha no banco
  if ($funcionario || $usuario) {
    echo "<script> alert('O CPF informado já está cadastrado. Por favor, tente novamente com outro CPF.');window.location.href = 'cadastrar.php';</script>";
    
  }

  // Se não houver erros, insira as informações no banco de dados
  if (empty($emailErro) && empty($senhaErro) && empty($codigoErro)) {
      // Verifica se o código inserido é igual ao código pré-definido para funcionários

    if ($codigo == $funcio) {
      // Insere os dados na tabela de funcionários
      $sql = "INSERT INTO funcionarios (nome, email, senha , telefone , cpf) VALUES (:nome, :email, :senha , :tele ,:cpf )";
      $stmt = executar($pdo , $sql , $nome ,$email ,$tele , $cpf , $senhaCript);

    } elseif(empty($codigo)) {
      // Insere os dados na tabela de usuários
      $sql = "INSERT INTO usuarios (nome, email, senha , telefone , cpf) VALUES (:nome, :email, :senha , :tele ,:cpf )";
      $stmt = executar($pdo , $sql , $nome ,$email ,$tele , $cpf , $senhaCript);

    if ($stmt !== null && $stmt->execute()) {
      // Se a inserção foi bem-sucedida, redirecione o usuário para a página principal
      echo '<script>alert("Cadastro realizado com sucesso!"); window.location.href = "index.php";</script>';
    }
    else{
      echo "<script> var erroBD = 'Erro ao inserir dados: " . $stmt->errorInfo()[2] . "'; </script>";
    }

    
  }
  if (!empty($senhaErro) || !empty($emailErro) || !empty($codigoErro)) {
    // Define a mensagem de erro
    echo "<script>var errorsenha = '$senhaErro'; var erroremail = '$emailErro'; var errorcodigo = '$codigoErro'; </script>";
  }
}
}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
  <title>Cadastro</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-info  bg-opacity-25">

    <div class="bg-light rounded-4 container w-50 p-5 fs-5 d-flex justify-content-center shadow  position-absolute top-50 start-50 translate-middle">
        <div class="text-center w-75">
        <h2 class="text-center">Cadastre-se</h2><br>
        <form action="" method="post">
          <div class="mb-1 fw-bold">
            <label for="text">Nome:</label>
            <input type="text" class="form-control form-control-sm rounded-5" id="nome" placeholder="Coloque o seu nome" name="nome" required>
          </div>
          <div class="mb-1 fw-bold">
            <label for="email">Email:</label>
            <input type="email" class="form-control form-control-sm rounded-5" id="email" placeholder="exemplo@hotmail.com" name="email" required title="Coloque um email valido">
          </div>
          <div class="mb-1 fw-bold">
            <label for="cpf">CPF:</label>
            <input type="text" class="form-control form-control-sm rounded-5" id="cpf" placeholder="Coloque seu CPF" name="cpf" pattern="[0-9]{11}" maxlength="11" required title="Coloque os 11 numeros do seu CPF ">       
          </div>
          <div class="mb-1 fw-bold">
            <label for="tel">Telefone:</label>
            <input type="tel" class="form-control form-control-sm rounded-5" id="tele" placeholder="Coloque seu Telefone" name="tele" pattern="[0-9]{11}" maxlength="11" required>
          </div>
          <div class="mb-1 fw-bold">
            <label for="pwd">Senha:</label>
            <input type="password" minlength="8" title="A senha deve ter no mínimo 8 caracteres" class="form-control form-control-sm rounded-5" id="pwd" placeholder="Crie sua senha " name="pswd" required>
          </div>
          <div class="mb-1 fw-bold">
            <label for="pwd">Confirme sua Senha:</label>
            <input type="password" class="form-control form-control-sm rounded-5" id="pwd2" placeholder="Repita sua senha " name="pswd2" required>
          </div>
          <div class="mb-1 fs-6 fst-italic">
            <label for="codigo">Código:</label>
            <input type="text" class="form-control form-control-sm rounded-5" id="codg" placeholder="Campo para funcionarios" name="codigo">
          </div>
         
          <br>
          <button type="submit" name="submit" class="btn btn-success text-light btn-outline-primary fs-5 rounded-4">Cadastrar</button>
        </form>
          <div class="position-absolute bottom-0 start-0 mb-2 mx-2" >
            <a href="index.php" class="btn btn-outline-primary rounded-5">Voltar</a>
          </div>
        </div>
    </div>
  
  <script src="js/javascript.js"></script>
<script>

// Verifica se há uma mensagem de erro definida
if (typeof errorsenha !== 'undefined' || typeof erroremail !== 'undefined' || typeof errorcodigo !== 'undefined') {
  // Exibe o alerta com a mensagem de erro
  alert(errorsenha || erroremail || errorcodigo);
}
if (typeof erroBD !== 'undefined' ) {
  // Exibe o alerta com a mensagem de erro
  alert(erroBD);
}


</script>

 
</body>
</html>