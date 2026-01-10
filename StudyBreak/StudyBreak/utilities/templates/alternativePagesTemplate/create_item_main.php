<?php
$totalPrice = 0;
?>
<section>
    <header>
        <a href="homepage.php">
            <img src="../../img/icons/back.svg" alt="go back" />
        </a>
        <h2>
            Your Infusion
        </h2>
    </header>
    <form action="../../utilities/templates/alternativePagesTemplate/processes/create_item_process.php" method="POST"
        id="customize-infusion">
        <label for="custom-item-name"> Your Infusion Name </label>
        <input type="text" id="custom-item-name" name="custom-item-name" placeholder="Your Infusion">
        <fieldset>

            <legend>Choose your ingredients</legend>

            <ul>
                <?php foreach ($createParams["all-ingredients"] as $ingrediente): ?>
                    <?php include("../../utilities/templates/ingredient-card.php"); ?>
                <?php endforeach; ?>
            </ul>
        </fieldset>

        <?php
        if (isset($_SESSION['error-creation-phrase'])) {
            echo "<p>" . clean_textual_input($_SESSION['error-creation-phrase']) . "</p>";
        }
        ?>
        <button type="submit">Create Item</button>
    </form>
</section>