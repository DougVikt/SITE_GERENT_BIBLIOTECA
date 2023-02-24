
function verificarLogado() {
  fetch('login.php') // arquivo PHP que verifica se o usuário está logado
    .then(response => response.json())
    .then(logado => {
      if (logado) {
        // usuário está logado, então esconder botões de login e cadastro
        document.getElementById('botoes-iniciais').classList.add('d-none');

        // mostrar nome do usuário logado
        document.getElementById('usuarioLogado').innerHTML = nomeUsuario;
      } else {
        // usuário não está logado, então mostrar botões de login e cadastro
        document.getElementById('botoes-iniciais').classList.remove('d-none');

        // esconder nome do usuário logado
        document.getElementById('usuarioLogado').innerHTML = '';
      }
    })
    .catch(error => console.error(error));
}



