function generaArticolo(articolo) {
    const li = document.createElement("li");

    li.innerHTML = `
        <article data-id="${articolo.id}">
                <header>
                    <img src="../../img/${articolo.foto ? articolo.foto : 'default-bevanda.png'}" alt="" />
                </header>
                <footer>
                    <h3>${truncate(articolo.nome, 15)}</h3>
                    <p>${articolo.prezzo}€</p>
                </footer>
        </article>
    `;

    return li;
}

function truncate(text, max) {
    return text.length > max ? text.slice(0, max - 3) + "..." : text;
}

function caricaBestProducts() {
    const productsList = document.querySelector("#all-products ul");

    fetch("/StudyBreak/StudyBreak/api/getAllProducts.php")
        .then(res => res.json())
        .then(data => {
            productsList.innerHTML = "";
            if (data.length === 0) {
                productsList.innerHTML = "<li>No products available</li>";
                return;
            }

            data.forEach(articolo => {
                productsList.appendChild(generaArticolo(articolo));
            });
        })
        .catch(err => {
            console.error("Errore caricamento prodotti:", err);
            productsList.innerHTML = "<li>Error loading products</li>";
        });
}

document.addEventListener("DOMContentLoaded", () => {
    caricaBestProducts();
});