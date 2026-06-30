const meuFormulario = document.querySelector(".needs-validation");

if (meuFormulario) {
  meuFormulario.addEventListener("submit", function (event) {
    if (!this.checkValidity()) {
      event.preventDefault();
    }
    this.classList.add("was-validated");
  });
}
