document.querySelectorAll(".winnerCard").forEach(card => {
	const toggle = card.querySelector(".toggleWinner"),
			revert = card.querySelector(".return"),
			cardBack = card.querySelector(".winnerDescription"),
			description = cardBack.querySelector("p");

	if(description.textContent.trim() !== "") toggle.textContent = "Ver comentário";

	toggle.addEventListener("click", () => {
		Array.from(card.children).forEach(child => {
			child.style.display = "none";
		});

		cardBack.style.display = "initial";
	});

	revert.addEventListener("click", () => {
		Array.from(card.children).forEach(child => {
			child.style.display ="initial";
		});

		cardBack.style.display = "none";
		toggle.style.display = "block";
	});
});