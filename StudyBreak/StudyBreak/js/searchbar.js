function generaArticolo(articolo) {
    const li = document.createElement("li");

    li.innerHTML = `
        <article data-id="${articolo.id}">
                <header>
                    <img src="../../img/${articolo.foto}" alt="" />
                </header>
                <footer>
                    <h3>${truncate(articolo.nome, 15)}</h3>
                    <p>${articolo.prezzo}€</p>
                </footer>
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

document.addEventListener("DOMContentLoaded", () => {
    const searchBtn = document.getElementById("open-searchbar");
    const searchForm = document.getElementById("search");
    const filterBtn = document.getElementById("filter-btn");
    const resetBtn = searchForm.querySelector("#exit");

    const input = document.getElementById("search-bar");
    console.log(input);
    const resultsList = document.getElementById("results-list");
    const searchSection = document.getElementById("search-results");
    const bestSection = document.querySelector("#best-product");
    const productsSection = document.querySelector("#all-products");

    let openSearchBar = false;
    let timeout;

    function setLayout() {
        searchForm.style.display = openSearchBar ? "flex" : "none";
        searchBtn.style.display = !openSearchBar ? "flex" : "none";
        filterBtn.style.display = !openSearchBar ? "flex" : "none";

        if (!openSearchBar) {
            if (bestSection != null) {
                bestSection.style.display = "block";
            }

            if (productsSection != null) {
                productsSection.style.display = "block";
            }
            searchSection.style.display = "none";
            resultsList.innerHTML = "";
        }
    }

    searchBtn.addEventListener("click", () => {
        openSearchBar = true;
        setLayout();
        input.focus();
    });

    resetBtn.addEventListener("click", () => {
        openSearchBar = false;
        setLayout();
        input.value = "";
    });


    input.addEventListener("input", () => {
        console.log("User sta scrivendo:", input.value);
        const q = input.value.trim();
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            if (q.length < 2) {
                resultsList.innerHTML = "";
                searchSection.style.display = "none";
                bestSection.style.display = "block";
                return;
            }
            fetch(`/StudyBreak/StudyBreak/api/searchItem.php?q=${encodeURIComponent(q)}`)
                .then(res => res.json())
                .then(data => {
                    resultsList.innerHTML = "";
                    if (data.length === 0) {
                        resultsList.innerHTML = "<li>No results found</li>";
                    } else {
                        data.forEach(articolo => {
                            resultsList.appendChild(generaArticolo(articolo));
                        });
                    }
                    // Mostra search results e nascondi best products
                    searchSection.style.display = "block";
                    if (bestSection != null) {
                        bestSection.style.display = "none";
                    }

                    if (productsSection != null) {
                        productsSection.style.display = "none";
                    }
                });
        }, 300);
    });
});
