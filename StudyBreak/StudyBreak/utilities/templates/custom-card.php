<li>
    <a href=<?php echo "bevanda_custom_item.php?id=".urlencode($custom->id);?>>
        <article>
            <header>
                <img src="../../img/<?php echo $custom->foto; ?>" alt="" />
            </header>
            <footer>
                <h3><?php $nomeBev=  $custom->nome;
                    if(strlen($nomeBev)>15){
                        $nomeBev = substr($nomeBev, 0, 12) . "...";
                    }
                    echo clean_textual_input($nomeBev);
                ?></h3>
                <p><?php echo $custom->prezzo; ?>€</p>
            </footer>
        </article>
    </a>
</li>