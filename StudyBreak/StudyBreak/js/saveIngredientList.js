document.getElementById("select-ingredient").addEventListener("submit", function(e) {
    e.preventDefault();

    const selected = [];
    document.querySelectorAll("input[name='ingredienti[]']:checked").forEach(cb => {
        selected.push({
            id: cb.value,
            nome: cb.nextElementSibling.innerText.trim()
        });
    });
    console.log(selected);
    localStorage.setItem("selectedIngredients", JSON.stringify(selected));
    window.location.href = "product_add.php";
});