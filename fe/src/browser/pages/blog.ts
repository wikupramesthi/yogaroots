export {};

const loadMoreBtn = document.getElementById("loadMoreBtn");
const articles = document.querySelectorAll(".article-card");

let visibleCount = 9;
const loadAmount = 9;

loadMoreBtn?.addEventListener("click", () => {
	const nextCount = visibleCount + loadAmount;

	for (let i = visibleCount; i < nextCount && i < articles.length; i++) {
		articles[i].classList.remove("hidden");
	}

	visibleCount = nextCount;

	if (visibleCount >= articles.length) {
		loadMoreBtn.remove();
	}
});
