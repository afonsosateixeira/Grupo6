document.addEventListener("DOMContentLoaded", () => {
    const alertas = document.querySelectorAll('.alert');
    
    alertas.forEach(alerta => {
        if (alerta.classList.contains('alert-dismissible')) {
            setTimeout(() => new bootstrap.Alert(alerta).close(), 3500);
        }
    });
});