function irParaFormulario() {
    let formulario;
    formulario = document.getElementById("tp");

    formulario.scrollIntoView({ 
        block: 'center' 
    });
}

let formulario;
formulario = document.getElementById('formulario');

let feedback;
feedback = document.getElementById('feedback');

formulario.addEventListener('submit', function(event) {
    event.preventDefault();

    let name = document.getElementById('name').value;

    feedback.innerText = "Obrigado " + name + ", o teu pedido para a consulta foi enviada";

    formulario.reset();
});