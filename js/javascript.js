
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


// traca a imagem da estrela de acordo com o click 
function Avaliar(estrela, idlivro ) {
  var estrelaId
  var avaliacao = 0;
  ;

  for (var i = 1; i <= 5; i++) {
    estrelaId = "s" + i + idlivro;
    if (i <= estrela) {
      document.getElementById(estrelaId).src = "img/star-1.png";
      avaliacao = estrela;
    } else {
      document.getElementById(estrelaId).src = "img/star-0.png";
    }
}

document.getElementById('avaliacao' + idlivro).value = avaliacao;

}

// troca de imagem e estilo do botão ao click
function Confirmando(button , status) {

  let image = button.querySelector('img');
  if (status === 'pendente'){
    button.classList.remove('btn-outline-danger');
    button.classList.add('btn-outline-success');
    button.disabled = true;
    image.setAttribute('src', 'img/confirmar.png');
    image.setAttribute('data-state', 'cancelar');
  }else{
    button.classList.remove('btn-outline-success');
    button.classList.add('btn-outline-danger');
    button.disabled = false;
    image.setAttribute('src', 'img/cancelar.png');
    image.setAttribute('data-state', 'confirmar');
  }
  // Submete o formulário manualmente
  let form = button.closest('form');
  form.submit();
}


/*
function Confirmando(status){

  let button = document.getElementById("buttom-confirm");
  let image = document.getElementById("status");

  if (status === "entregue") {

    image.src = "img/cancelar.png";
    button.classList.toggle('btn-outline-danger');
  } else {

    image.src = "img/confirmar.png";
    button.classList.toggle('btn-outline-success');
    
  }

  }
  

  function Confirmando(button) {
    // Encontra a linha do empréstimo correspondente
    const linhaEmprestimo = button.closest('tr');

    // Encontra a imagem dentro do botão
    const imagemBotao = button.querySelector('img');

    // Alterna entre as imagens "confirmar" e "cancelar"
    if (imagemBotao.src.endsWith('confirmar.png')) {
      imagemBotao.src = 'img/cancelar.png';
    } else {
      imagemBotao.src = 'img/confirmar.png';
    }

    // Alterna a classe do botão entre "btn-success" e "btn-info"
    button.classList.toggle('btn-outline-success');
    button.classList.toggle('btn-outline-danger');

    // Desativa todos os elementos da linha do empréstimo
    const elementosLinha = linhaEmprestimo.querySelectorAll('td, button');
    elementosLinha.forEach(elemento => elemento.disabled = true);
  }
  */
 