<li>
    <article>
        <h5><?php echo $ingrediente->nome; ?></h5>
        <p>n.<data value="<?php echo $ingrediente->quantita; ?>"><?php echo $ingrediente->quantita; ?></data></p>
        <p><data value=<?php echo $ingrediente->prezzo; ?>><?php echo ("€".$ingrediente->prezzo); ?></data></p>
    </article>
</li>