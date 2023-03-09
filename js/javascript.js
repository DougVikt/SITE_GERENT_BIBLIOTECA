
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
/*
function ExibirEstrelas(avaliado , idlivro){

  var estrelaId
  for (var i = 1; i <= 5; i++) {
    estrelaId = "s" + i;
    if (i <= avaliado) {
      document.getElementById(estrelaId).src = "img/star-0.png";
    } else {
      document.getElementById(estrelaId).src = "img/star-1.png";
    }
  }



}

function ExibirEstrelas(estrela , idlivro) {
  var url = window.location;
  url = url.toString()
  url = url.split("index.php");
  url = url[0];
 
  var s1 = document.getElementById("s1" + idlivro).src;
  var s2 = document.getElementById("s2" + idlivro).src;
  var s3 = document.getElementById("s3" + idlivro).src;
  var s4 = document.getElementById("s4" + idlivro).src;
  var s5 = document.getElementById("s5" + idlivro).src;
  
 
 if (estrela == 5){ 
  if (s5 == url + "img/star-0.png") {
  document.getElementById("s1" + idlivro).src = "img/star-1.png";
  document.getElementById("s2" + idlivro).src = "img/star-1.png";
  document.getElementById("s3" + idlivro).src = "img/star-1.png";
  document.getElementById("s4" + idlivro).src = "img/star-1.png";
  document.getElementById("s5" + idlivro).src = "img/star-1.png";
 
  } else {
  document.getElementById("s1" + idlivro).src = "img/star-1.png";
  document.getElementById("s2" + idlivro).src = "img/star-1.png";
  document.getElementById("s3" + idlivro).src = "img/star-1.png";
  document.getElementById("s4" + idlivro).src = "img/star-1.png";
  document.getElementById("s5" + idlivro).src = "img/star-0.png";
 
 }}
  
  //ESTRELA 4
 if (estrela == 4){ 
  if (s4 == url + "img/star-0.png") {
  document.getElementById("s1" + idlivro).src = "img/star-1.png";
  document.getElementById("s2" + idlivro).src = "img/star-1.png";
  document.getElementById("s3" + idlivro).src = "img/star-1.png";
  document.getElementById("s4" + idlivro).src = "img/star-1.png";
  document.getElementById("s5" + idlivro).src = "img/star-0.png";
  
  } else {
  document.getElementById("s1" + idlivro).src = "img/star-1.png";
  document.getElementById("s2" + idlivro).src = "img/star-1.png";
  document.getElementById("s3" + idlivro).src = "img/star-1.png";
  document.getElementById("s4" + idlivro).src = "img/star-0.png";
  document.getElementById("s5" + idlivro).src = "img/star-0.png";
 
 }}
 
 //ESTRELA 3
 if (estrela == 3){ 
  if (s3 == url + "img/star-0.png") {
  document.getElementById("s1" + idlivro).src = "img/star-1.png";
  document.getElementById("s2" + idlivro).src = "img/star-1.png";
  document.getElementById("s3" + idlivro).src = "img/star-1.png";
  document.getElementById("s4" + idlivro).src = "img/star-0.png";
  document.getElementById("s5" + idlivro).src = "img/star-0.png";
  
  } else {
  document.getElementById("s1" + idlivro).src = "img/star-1.png";
  document.getElementById("s2" + idlivro).src = "img/star-1.png";
  document.getElementById("s3" + idlivro).src = "img/star-0.png";
  document.getElementById("s4" + idlivro).src = "img/star-0.png";
  document.getElementById("s5" + idlivro).src = "img/star-0.png";

 }}
  
 //ESTRELA 2
 if (estrela == 2){ 
  if (s2 == url + "img/star-0.png") {
  document.getElementById("s1" + idlivro).src = "img/star-1.png";
  document.getElementById("s2" + idlivro).src = "img/star-1.png";
  document.getElementById("s3" + idlivro).src = "img/star-0.png";
  document.getElementById("s4" + idlivro).src = "img/star-0.png";
  document.getElementById("s5" + idlivro).src = "img/star-0.png";

  } else {
  document.getElementById("s1" + idlivro).src = "img/star-1.png";
  document.getElementById("s2" + idlivro).src = "img/star-0.png";
  document.getElementById("s3" + idlivro).src = "img/star-0.png";
  document.getElementById("s4" + idlivro).src = "img/star-0.png";
  document.getElementById("s5" + idlivro).src = "img/star-0.png";

 }}
  
  //ESTRELA 1
 if (estrela == 1){ 
  if (s1 == url + "img/star-0.png") {
  document.getElementById("s1" + idlivro).src = "img/star-1.png";
  document.getElementById("s2" + idlivro).src = "img/star-0.png";
  document.getElementById("s3" + idlivro).src = "img/star-0.png";
  document.getElementById("s4" + idlivro).src = "img/star-0.png";
  document.getElementById("s5" + idlivro).src = "img/star-0.png";
 
  } else {
  document.getElementById("s1" + idlivro).src = "img/star-0.png";
  document.getElementById("s2" + idlivro).src = "img/star-0.png";
  document.getElementById("s3" + idlivro).src = "img/star-0.png";
  document.getElementById("s4" + idlivro).src = "img/star-0.png";
  document.getElementById("s5" + idlivro).src = "img/star-0.png";
 
 }}
}
*/