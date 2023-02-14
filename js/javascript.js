// função para trocar a cor do texto dependendo do evento , que no caso e a passada do mouse 
function TrocaElemento(element) {
 
    if (element.classList.contains("bg-opacity-100")) {
      element.classList.remove("bg-opacity-100");
      element.classList.add("bg-secondary");
    } else {
      element.classList.remove("bg-secondary");
      element.classList.add("bg-opacity-100");
    }
  }
  
document.querySelector(".rounded-5").onmouseover = function() {
  TrocaElemento(this);
};

document.querySelector(".rounded-5").onmouseout = function() {
  TrocaElemento(this);
};



