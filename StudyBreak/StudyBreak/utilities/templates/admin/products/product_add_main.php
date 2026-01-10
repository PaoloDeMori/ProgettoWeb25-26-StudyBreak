<header>
    <a href="homepage.php">
        <img src="../../img/icons/back.svg" alt="go back" />
    </a>
</header>
<section>
    <h2>
        Add Item
    </h2>

    <form action="../../utilities/templates/admin/products/processed/add_bevanda.php" method="POST"
        enctype="multipart/form-data" id="productAddForm">
        <div id="imageProductPicker">
            <label for="inputPicture">
                <img id="previewImage" src="../../img/empty_image.png" alt="product picture" />
            </label>
            <input type="file" id="inputPicture" name="productPicture" />
        </div>

        <section>
            <fieldset>
                <legend>General Values</legend>
                <label for="name">Name</label>
                <input id="name" type="text" name="productName" placeholder="Insert name" required />

                <label for="price">Price</label>
                <input id="price" type="number" name="productPrice" min="0.1" max="1000" step="0.1"
                    placeholder="Insert price" required />

                <label for="availability">Availability</label>
                <input id="availability" type="number" name="productAvailability" min="1" max="100000"
                    placeholder="Insert availability" required />
            </fieldset>
        </section>

        <section>
            <fieldset>
                <legend>Ingredients</legend>
                <ul id="ingredientsList">
                </ul>
                <button type="button" id="addIngredientBtn">
                    <img src="../../img/icons/plus.svg" alt="" />
                </button>
            </fieldset>
        </section>
        <button type="submit">Save</button>
    </form>
</section>