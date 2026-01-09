<?php
$data = $templateParams["showCustomParams"] ?? null;
$totalPrice = 0;

if (isset($data["ingredients-relative-to-item"]) && is_array($data["ingredients-relative-to-item"])) {
    foreach ($data["ingredients-relative-to-item"] as $ing) {
        $totalPrice += $ing->prezzo;

    }
} else {
    die("damn");
}
?>
<section>
    <header>
        <a href="favourites.php">
            <img src="../../img/icons/back.svg" alt="go back" />
        </a>
        <h2>
            <?php echo $showCustomParams["infusion-name"] ?>
        </h2>
        <button id='delete-item-btn'><img src="../../img/icons/bin.svg" alt="cancel custom" /></button>
    </header>

    <ul>
        <?php foreach ($showCustomParams["all-ingredients"] as $ingrediente): ?>
            <?php echo "<li>" . "$ingrediente->nome" . "</li>" ?>
        <?php endforeach; ?>
    </ul>

    <div>
        <dl>
            <dt>Total</dt>
            <dd><output><?php echo $totalPrice ?> €</output></dd>
        </dl>
    </div>
</section>
