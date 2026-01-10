document.addEventListener("DOMContentLoaded", () => {
    const formData = JSON.parse(localStorage.getItem("productFormData") || "{}");

    if (formData.nome) document.getElementById("name").value = formData.nome;
    if (formData.prezzo) document.getElementById("price").value = formData.prezzo;
    if (formData.disponibilita) document.getElementById("availability").value = formData.disponibilita;

    // Ripristina anche gli ingredienti selezionati
    const ingredients = JSON.parse(localStorage.getItem("selectedIngredients") || "[]");
    const ul = document.getElementById("ingredientsList");
    ingredients.forEach(ing => {
        const li = document.createElement("li");
        li.textContent = ing.nome;

        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "ingredienti[]";
        input.value = ing.id;

        li.appendChild(input);
        ul.appendChild(li);
    });

    const addBtn = document.getElementById("addIngredientBtn");
    if (addBtn) {
        addBtn.addEventListener("click", () => {
            const formData = {
                nome: document.getElementById("name").value,
                prezzo: document.getElementById("price").value,
                disponibilita: document.getElementById("availability").value
            };
            localStorage.setItem("productFormData", JSON.stringify(formData));

            window.location.href = "add_ingredient.php";
        });
    }

    const productForm = document.getElementById("productAddForm");
    if (productForm) {
        productForm.addEventListener("submit", () => {
            localStorage.removeItem("productFormData");
            localStorage.removeItem("selectedIngredients");
        });
    }
});