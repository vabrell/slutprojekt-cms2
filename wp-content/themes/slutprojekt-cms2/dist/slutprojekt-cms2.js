addEventListener("load", () => {
	const toggleBtn = document.querySelector(".navbar-toggler")

	if (toggleBtn) {
		toggleBtn.addEventListener("click", () => {
			const menu = document.querySelector(toggleBtn.dataset.target)

			menu.classList.toggle("show")
		})
	}
})