
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

// Pega o elemento de link por id
const link = document.getElementById('historico');

// Verifica se o usuário está logado como funcionário
if (logado && user_type === 'funcionario') {
  link.href = 'historico.php'; // Substitui o link para funcionários
} else if  (logado && user_type === 'usuario'){
  link.href = 'historico_c.php'; // Substitui o link para usuários normais
} else {
  link.href = 'login.php';
}


