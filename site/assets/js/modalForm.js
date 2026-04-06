function abrirModalInteresse(idEscolhido) {
    document.getElementById('modal_animal_id').value = idEscolhido;

    let modalElement = document.getElementById('formModal');
    let myModal = new bootstrap.Modal(modalElement);
    myModal.show();
}

