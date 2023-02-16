
fetch('verifica_login.php')//nome arquivo de verificação 
  .then(response => response.json())
  .then(logado => {
    if (logado) {
      // Esconder botões de login e cadastro
      document.getElementById('login').style.display = 'none';
      document.getElementById('cadastro').style.display = 'none';
    } else {
      // Mostrar botões de login e cadastro
      document.getElementById('login').style.display = 'block';
      document.getElementById('cadastro').style.display = 'block';
    }
  })
  .catch(error => console.error(error));


const meuLink = document.getElementById('acervo');

meuLink.addEventListener('click', function(event) {
  // cancela o comportamento padrão da tag a
  event.preventDefault();
  
  // verifica se o usuário está logado
  if (logado) {
    // redireciona o usuário para o arquivo2.html
    window.location.href = 'arquivo2.html';
  } else {
    // redireciona o usuário para o arquivo1.html
    window.location.href = 'arquivo1.html';
  }
});

const meuLink2 = document.getElementById('praso');

meuLink2.addEventListener('click', function(event) {
  // cancela o comportamento padrão da tag a
  event.preventDefault();
  
  // verifica se o usuário está logado
  if (logado) {
    // redireciona o usuário para o arquivo2.html
    window.location.href = 'arquivo2.html';
  } else {
    // redireciona o usuário para o arquivo1.html
    window.location.href = 'arquivo1.html';
  }
});

// obtém o elemento da página que irá mostrar o nome do usuário logado
const usuarioLogado = document.getElementById('usuarioLogado');

// faz uma requisição AJAX para o servidor para obter o nome do usuário logado
const request = new XMLHttpRequest();
request.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    // exibe o nome do usuário logado na página
    usuarioLogado.innerHTML = 'Bem-vindo, ' + this.responseText;
  }
}
request.open('GET', 'obter_nome_usuario.php');
request.send();


// JavaScript
// verifique se o usuário está logado e é um funcionário
let usuarioEstaLogado = true; // exemplo de variável para usuário logado
let usuarioEFuncionario = true; // exemplo de variável para usuário funcionário

// verifique se o usuário está logado e é um funcionário
if (usuarioEstaLogado && usuarioEFuncionario) {
  // mostra o link para a página do funcionário
  document.getElementById("link-funcionario").style.display = "block";
}
