document.addEventListener("DOMContentLoaded", async () => {
    const buttons = document.querySelectorAll(".like-btn");

    try {
        const response = await fetch("/StudyBreak/StudyBreak/api/getFavouritesId.php");
        const favIds = await response.json(); // ID in Preferito

        document.querySelectorAll(".like-btn").forEach(button => {
            const article = button.closest("article");
            const articleId = parseInt(article.dataset.id, 10);
            const icon = button.querySelector("img");

            if (favIds.includes(articleId)) {
                icon.src = "../../img/icons/liked.svg";
                button.dataset.liked = "true";
            } else {
                icon.src = "../../img/icons/heart.svg";
                button.dataset.liked = "false";
            }
        });
    } catch (err) {
        console.error("Errore caricamento preferiti:", err);
    }
});

document.addEventListener("click", async (e) => {
    const button = e.target.closest(".like-btn");
    if (!button) return;
    e.preventDefault();
    e.stopPropagation();

    const article = button.closest("article");
    const articleId = article.dataset.id;
    const li = article.closest("li");
    const favouritesSection = document.querySelector("#favourites");

    const liked = button.dataset.liked === "true";
    const icon = button.querySelector("img");

    icon.src = liked ? "../../img/icons/heart.svg" : "../../img/icons/liked.svg";
    button.dataset.liked = (!liked).toString();

    try {
        const response = await fetch("/StudyBreak/StudyBreak/api/toggleFavourite.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id_bevanda: articleId, liked: !liked })
        });

        const data = await response.json();
        if (!data.success) throw new Error("Errore server");

        if (favouritesSection && liked) {
            li.remove();

            const ul = favouritesSection.querySelector("ul");
            if (ul.children.length === 0) {
                ul.innerHTML = "<li>No products available</li>";
            }
        }
    } catch (err) {
        console.error(err);
        // Ripristina lo stato precedente in caso di errore
        icon.src = liked ? "../../img/icons/liked.svg" : "../../img/icons/heart.svg";
        button.dataset.liked = liked.toString();
    }
});
