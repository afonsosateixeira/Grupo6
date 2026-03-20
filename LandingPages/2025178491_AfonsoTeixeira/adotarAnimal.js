let botao2= document.getElementById('cta');
let nome= document.getElementById('campoNome');

botao2.addEventListener('click', function(){
    nome.focus();
});

document.querySelector('.forms_animal').addEventListener('submit', function(){
    nomeVal= nome.value.trim();
    let emailVal = document.getElementById('campoEmail').value.trim();
    let telemovelVal = document.getElementById('campoTele').value.trim();

    if(nomeVal === "" || emailVal === "" || telemovelVal === ""){
        alert("Preencher todos os campos");
        return;
    }

    alert("Candidatura enviada com sucesso! Entraremos em contacto em breve.");
    this.submit();
});




