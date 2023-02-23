function verificarLogado() {
  fetch('login.php') // arquivo PHP que verifica se o usuário está logado
    .then(response => response.json())
    .then(logado => {
      if (logado) {
        // usuário está logado, então esconder botões de login e cadastro
        document.getElementById('login').style.display = 'none';
        document.getElementById('cadastro').style.display = 'none';

        // mostrar nome do usuário logado
        document.getElementById('usuario-logado').innerHTML = nomeUsuario;
      } else {
        // usuário não está logado, então mostrar botões de login e cadastro
        document.getElementById('login').style.display = 'block';
        document.getElementById('cadastro').style.display = 'block';

        // esconder nome do usuário logado
        document.getElementById('usuario-logado').innerHTML = '';
      }
    })
    .catch(error => console.error(error));
}


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




