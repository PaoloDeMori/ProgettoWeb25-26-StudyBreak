document.addEventListener("DOMContentLoaded", () => {
    const cartList = document.getElementById("cart-list");
    const totalDd = document.querySelector("#cart-total");


    cartList.addEventListener("click", (e) => {
        const button = e.target.closest("button.bin");
        if (!button) return;

        const article = button.closest("article");
        const li = button.closest("li");

        const id = parseInt(article.dataset.idbevanda, 10); // trasforma in numero
        const isCustom = article.dataset.custom === "true";
        console.log(id);

        fetch("/StudyBreak/StudyBreak/api/removeItemOnCart.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                id: id,
                custom: isCustom
            })
        })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    li.remove();
                    totalDd.textContent = parseFloat(result.totalPrice || 0).toFixed(2) + "€";

                } else {
                    alert("Errore durante la rimozione");
                }
            })
            .catch(err => {
                console.error("Errore rimozione:", err);
            });
    });
});
