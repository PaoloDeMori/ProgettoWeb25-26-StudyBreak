function truncate(text, max) {
    return text.length > max ? text.slice(0, max - 3) + "..." : text;
}

function generaArticoloCarrello(articolo, isCustom = false) {
    const li = document.createElement("li");
    let prezzoTotale = 0;
    if(!isCustom){prezzoTotale = parseFloat(articolo.prezzo) * articolo.quantita;}
    else{
        for (const ing of articolo.ingredients) {
            prezzoTotale += (ing.prezzo*articolo.quantita);
        }
    }

    li.innerHTML = `

        <article
            data-idbevanda="${articolo.id}"
            data-custom="${isCustom ? "true" : "false"}"
        >
            <a href="product.html">
                <img src="../../img/${articolo.foto ? articolo.foto : 'default-bevanda.png'}" alt="${articolo.nome}" />
            </a>
            <h3>${truncate(articolo.nome, 20)}</h3>

            <dl>
                <dt>Price</dt>
                <dd>${prezzoTotale}€</dd>
                <dt>Quantity</dt>
                <dd>n. ${articolo.quantita}</dd>
            </dl>
            <aside>
                <button type="button" class="bin">
                    <img src="../../img/icons/bin_cart.svg" alt="bin's icon">
                </button>
            </aside>
        </article>
    `;

    return li;
}

function caricaCarrello() {
    const cartList = document.querySelector("#cart-list");
    const totalDd = document.querySelector("#cart-total");

    fetch("/StudyBreak/StudyBreak/api/getCart.php")
        .then(res => res.json())
        .then(cart => {
            cartList.innerHTML = "";

            if ((!cart.bevande || cart.bevande.length === 0) &&
                (!cart.bevandeCustom || cart.bevandeCustom.length === 0)) {
                return;
            }

            cart.bevande?.forEach(bevanda => {
                cartList.appendChild(generaArticoloCarrello(bevanda));
            });

            cart.bevandeCustom?.forEach(bevandaC => {
                cartList.appendChild(generaArticoloCarrello(bevandaC, true));
            });

            if (cart.totalPrice !== undefined) {
                totalDd.textContent = parseFloat(cart.totalPrice).toFixed(2) + "€";
            } else {
                totalDd.textContent = "0.00€";
            }
        })
        .catch(err => {
            console.error("Errore caricamento carrello:", err);
            cartList.innerHTML = "<li>Errore nel caricamento del carrello</li>";
            totalDd.textContent = "0.00€";

        });
}

document.addEventListener("DOMContentLoaded", () => {
    caricaCarrello();
});
