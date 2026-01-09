<li>
    <article>
        <header>
            <h3>Order's details</h3> </header>
        <details>
            <summary>
                <img src="../../img/icons/chevron.svg" alt="expand" aria-hidden="true">

                <time datetime= <?php echo "$ordine->orarioEffettuazione" ?>>
                <?php echo "$ordine->orarioEffettuazione" ?>
                </time>

                <data value=<?php echo "$num"?>> 
                    <?php echo "$num" ?>
                </data>

                <data value="<?php echo "$ordine->prezzoTotale" ?>">
                <?php echo "€ $ordine->prezzoTotale" ?>
                </data>
            </summary>

            <section>
                <h4>
                Ingredient List
                </h4>
                <ul>
                    <?php foreach($ordine->bevande as $ingrediente): ?>
                        <?php require 'order_ingredients_item.php' ?>
                    <?php endforeach; ?>
                </ul>
            </section>
            <div>
                <a href="/StudyBreak/utilities/templates/admin/orders/toHistoryProcess.php?idordine=<?php echo $ordine->id; ?>">
                    <span>to history</span>
                </a>
            </div>
        </details>
    </article>
</li>