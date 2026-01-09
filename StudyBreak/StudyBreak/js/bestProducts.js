function generaArticolo(articolo) {
    const li = document.createElement("li");

    li.innerHTML = `
        <article data-id="${articolo.id}">
            <a href="customize_item.php?id=${encodeURIComponent(articolo.id)}">
                <header>
                    <img src="../../img/${articolo.foto ? articolo.foto : 'default-bevanda.png'}" alt="" />
                </header>
                <footer>
                    <h3>${truncate(articolo.nome, 15)}</h3>
                    <p>${articolo.prezzo}€</p>
                </footer>
            </a>
            <aside>
                <button type="button" class="like-btn" data-liked="false">
                    <img src="../../img/icons/heart.svg" alt="add to favourites" />
                </button>
            </aside>
        </article>
    `;

    return li;
}

function truncate(text, max) {
    return text.length > max ? text.slice(0, max - 3) + "..." : text;
}

function caricaBestProducts() {
    const bestList = document.querySelector("#best-product ul");

    fetch("/StudyBreak/StudyBreak/api/getBestProducts.php")
        .then(res => res.json())
        .then(data => {
            bestList.innerHTML = "";
            if (data.length === 0) {
                bestList.innerHTML = "<li>No products available</li>";
                return;
            }

            data.forEach(articolo => {
                bestList.appendChild(generaArticolo(articolo));
            });
        })
        .catch(err => {
            console.error("Errore caricamento Best Products:", err);
            bestList.innerHTML = "<li>Error loading products</li>";
        });
}

document.addEventListener("DOMContentLoaded", () => {
    caricaBestProducts();
});
