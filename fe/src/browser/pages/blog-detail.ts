export {};

const btn = document.getElementById("copyLinkBtn");

btn?.addEventListener("click", () => {
	const url = btn.getAttribute("data-url") || "";
	const done = () => {
		const original = "Copy link";
		btn.textContent = btn.getAttribute("data-copied") || "Copied!";
		setTimeout(() => {
			btn.textContent = original;
		}, 2000);
	};
	if (navigator.clipboard?.writeText) {
		navigator.clipboard.writeText(url).then(done, done);
	} else {
		const ta = document.createElement("textarea");
		ta.value = url;
		document.body.appendChild(ta);
		ta.select();
		try {
			document.execCommand("copy");
		} catch {
			/* ignore */
		}
		document.body.removeChild(ta);
		done();
	}
});
