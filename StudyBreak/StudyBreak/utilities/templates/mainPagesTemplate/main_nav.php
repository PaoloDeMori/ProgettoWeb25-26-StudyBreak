<?php $pagina = basename($_SERVER['PHP_SELF']);?>
<nav>
    <ul>
        <li>
            <a href="homepage.php" <?php echo ($pagina == 'homepage.php') ? 'aria-current="page"' : "" ; ?>>
                <img src="../../img/icons/home.svg" alt="go to homepage icon" />
            </a>
        </li>
        <li>
            <a href="cart.php" <?php echo ($pagina == 'cart.php') ? 'aria-current="page"' : "" ; ?>>
                <img src="../../img/icons/cart.svg" alt="go to cart icon" />
            </a>
        </li>
        <li>
            <a href="favourites.php" <?php echo ($pagina == 'favourites.php') ? 'aria-current="page"' : "" ; ?>>
                <img src="../../img/icons/heart.svg" alt="go to favourites icon" />
            </a>
        </li>
        <li>
            <a href="profile.php" <?php echo ($pagina == 'profile.php') ? 'aria-current="page"' : "" ; ?>>
                <img src="../../img/icons/user.svg" alt="go to user's page icon" />
            </a>
        </li>
    </ul>
</nav>