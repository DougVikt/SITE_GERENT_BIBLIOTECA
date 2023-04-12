<?php
$host = 'localhost';
$dbname = 'biblioteca';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    // Define o modo de erro do PDO para exceção
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
}


function tipo_usuario($session){
    // verifica se e usuario ou funcionario
if (isset($session['user_type']) && $session['user_type'] == 'funcionario') {
    $funcionario = true;
 }
 else{ 
    $funcionario = false;
 }
 return $funcionario;
}






?>
