<li>
    <article data-idbevanda="<?php echo $articolo->id_bevanda; ?>">
        <a href="product.php">
            <img src="../../img/<?php echo $articolo->foto; ?>" alt="" />
        </a>
        <h3>
            <?php echo clean_textual_input($articolo->nome);?>
        </h3>

        <dl>
            <dt>Price</dt>
            <dd><?php echo $articolo->getPrezzoTotale(); ?>€</dd>

            <dt>Quantity</dt>
            <dd>n. <?php echo $articolo->quantita; ?></dd></dd>
            </dl>
        <aside>
            <button type="button" class="bin">
                <img src="../../img/icons/bin_cart.svg" alt="bin's icon">
            </button>
        </aside>
    </article>
</li>