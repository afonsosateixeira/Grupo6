/* Not currently in use
const currentPage = window.location.pathname.split("/").pop();

document.querySelectorAll(".nav-link, .footer-link").forEach(link => {
	if(link.getAttribute("href") === currentPage){
		link.classList.add("active");
		link.setAttribute("aria-current", "page");
	}
});
*/

const meuFormulario = document.querySelector('.needs-validation');

meuFormulario.addEventListener('submit', function(event) {
	if (!this.checkValidity()) {
		event.preventDefault(); 
	}
	this.classList.add('was-validated'); 
});
