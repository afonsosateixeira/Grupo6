//Global Scripts
const currentPage = window.location.pathname.split("/").pop();

document.querySelectorAll(".nav-link, .footer-link").forEach(link => {
	if(link.getAttribute("href") === currentPage){
		link.classList.add("active");
		link.setAttribute("aria-current", "page");
	}
});