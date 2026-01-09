<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    die("Item non valido");
}
$itemParam = $dbh->get_item_from_id($id);
if ($itemParam === null) {
    die("Item non valido");
}
?>
<header>
    <a href="homepage.php">
        <img src="../../img/icons/back.svg" alt="go back" />
    </a>
    <h2>
        <?php echo $itemParam->nome; ?>
    </h2>
</header>
<section>
    <img src="../../img/<?php echo $itemParam->foto; ?>" alt="Item Picture" />
    <form action="../../utilities/templates/alternativePagesTemplate/processes/customize_item_process.php"
        method="POST">
        <input type="hidden" name="idbevanda" value=<?php echo $id ?> required />

        <fieldset>
            <h3>Quantity</h3>
            <div>
                <button type="button" id="decrease">
                    <img src="../../img/icons/decrease.svg" alt="decrease icon" />
                </button>
                <output id="quantity" name="quantity" value="1">1</output>
                <input type="hidden" name="quantity" id="hidden-quantity" value='1' required />
                <button type="button" id="increase">
                    <img src="../../img/icons/increase.svg" alt="increase icon" />
                </button>
            </div>
        </fieldset>

        <fieldset>
            <h3>Size</h3>
            <div>
                <input id="250" type="radio" name="size" value="250" required />
                <label for="250"> <img src="../../img/icons/small_cup.svg" alt="250 ml" /> 250</label>

                <input id="350" type="radio" name="size" value="350" required />
                <label for="350"> <img src="../../img/icons/medium_cup.svg" alt="250 ml" />350</label>

                <input id="450" type="radio" name="size" value="450" required />
                <label for="450"> <img src="../../img/icons/big_cup.svg" alt="250 ml" />450</label>
            </div>
        </fieldset>

        <fieldset>
            <h3>Sugar</h3>
            <div>
                <button type="button" id="sugar-reset">
                    <img src="../../img/icons/cancel.svg" alt="Unselect all" />
                </button>
                <input type="radio" id="sugar1" name="sugar" value="1">
                <label for="sugar1" data-value="1"><span>Sugar Level 1</span></label>

                <input type="radio" id="sugar2" name="sugar" value="2">
                <label for="sugar2" data-value="2"><span>Sugar Level 2</span></label>

                <input type="radio" id="sugar3" name="sugar" value="3">
                <label for="sugar3" data-value="3"><span>Sugar Level 3</span></label>

                <input type="radio" id="sugar4" name="sugar" value="4">
                <label for="sugar4" data-value="4"><span>Sugar Level 4</span></label>

                <input type="radio" id="sugar5" name="sugar" value="5">
                <label for="sugar5" data-value="5"><span>Sugar Level 5</span></label>
            </div>
        </fieldset>


        <fieldset>
            <h3>Milk</h3>
            <input id="milk" type="checkbox" name="milk" value="1" />
            <label for="milk"><img src="../../img/icons/check.svg" alt="" /><span>Add Milk</span></label>
        </fieldset>

        <button type="submit">Add to cart</button>
    </form>
</section>