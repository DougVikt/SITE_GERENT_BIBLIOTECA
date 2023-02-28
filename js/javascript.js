
function verificarLogado(logado , nomeUsuario ,user_type) {
    const link = document.getElementById('historico');
    if (logado) {
      // usuário está logado, então esconder botões de login e cadastro
      document.getElementById('botoes-iniciais').classList.add('d-none');
      document.getElementById('logout').classList.remove('d-none');
      // mostrar nome do usuário logado
      document.getElementById('usuarioLogado').innerHTML = nomeUsuario;
      if (user_type === 'funcionario') {
      link.href = 'historico_funcio.php'; // Substitui o link para funcionários
      } else if  (user_type === 'usuario'){
      link.href = 'historico_user.php'; // Substitui o link para usuários normais
      }  
    } else {
      // usuário não está logado, então mostrar botões de login e cadastro
      document.getElementById('botoes-iniciais').classList.remove('d-none');
      document.getElementById('logout').classList.add('d-none');
      // esconder nome do usuário logado
      document.getElementById('usuarioLogado').innerHTML = '';
    }
    
    
}


