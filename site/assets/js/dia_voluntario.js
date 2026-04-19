function mostrarTexto() {
  let mostrar
  mostrar = document.getElementById("mensagem");
  
  if (mostrar.style.display === "block") {
    mostrar.style.display = "none";
  } else {
    mostrar.style.display = "block";
  }
}