<section>
    <header>
        <h2>
            Ingredients
        </h2>
        <a href="homepage.php">
            <img src="../../img/icons/back.svg" alt="go back" />
        </a>
    </header>
    <form action="#" method="POST" id="select-ingredient">
        <fieldset>
            <legend>Add ingredients</legend>
            <ul>
                <li>
                    <?php foreach ($createParams["all-ingredients"] as $ingrediente): ?>
                        <?php include("../../utilities/templates/ingredient-admin.php"); ?>
                    <?php endforeach; ?>
                </li>
            </ul>
        </fieldset>
        <button type="submit">Confirm</button>
    </form>
</section>