function irParaFormulario() {
    let formulario;
    formulario = document.getElementById("form-inscricao");

    formulario.scrollIntoView({
        block: 'center'
    });
}

let formulario;
formulario = document.getElementById('form-inscricao');

let feedback;
feedback = document.getElementById('feedback');

formulario.addEventListener('submit', function (event) {

    event.preventDefault();

    let nome
    nome = document.getElementById('nome').value;

    feedback.innerText = "Obrigado, " + nome + " A tua inscrição foi enviada";

    formulario.reset();
});
