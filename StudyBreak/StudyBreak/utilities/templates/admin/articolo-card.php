<li>
    <article data-id="<?php echo $articolo->id; ?>">
            <a href=<?php echo "customize_item.php?id=".urlencode($articolo->id);?>>
            <header>
                <img src="../../img/<?php echo $articolo->foto; ?>" alt="" />
            </header>
            <footer>
                <h3><?php $nomeBev=  $articolo->nome;
                    if(strlen($nomeBev)>15){
                        $nomeBev = substr($nomeBev, 0, 12) . "...";
                    }
                    echo clean_textual_input($nomeBev);
                ?></h3>
                <p><?php echo $articolo->prezzo; ?>€</p>
            </footer>
        </a>
    </article>
</li>