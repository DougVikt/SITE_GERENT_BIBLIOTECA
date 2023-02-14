
document.querySelector("#btnOpenModalSignin").addEventListener("click", function() {
  document.querySelector("#modalSignin").style.display = "block";
});

document.querySelector(".btn-close").addEventListener("click", function() {
  document.querySelector("#modalSignin").style.display = "none";
});
