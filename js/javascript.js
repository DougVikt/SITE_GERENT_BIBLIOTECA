
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
