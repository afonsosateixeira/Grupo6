document.addEventListener("DOMContentLoaded", function() { 
    let selectAnimal = document.getElementById("select-animal");
    if (selectAnimal) {
        new TomSelect("#select-animal", {
            create: false, 
            placeholder: "Pesquise um animal...",
        });
    }

    let selectUser = document.getElementById("select-user");
    if (selectUser) {
        new TomSelect("#select-user", {
            create: false, 
            placeholder: "Pesquise um utilizador...",
        });
    }

    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.has('add') || urlParams.has('editar')) {
        let modalElement = document.getElementById('formModaladopt');
        if (modalElement) {
            let meuModal = new bootstrap.Modal(modalElement);
            meuModal.show();
        }
    }


});


         