<?php $pagina = basename($_SERVER['PHP_SELF']);?>
    <nav>
        <ul>
            <li>
                <a href="homepage.php" <?php echo ($pagina == 'homepage.php') ? 'aria-current="page"' : "" ; ?>>
                    <img src="../../img/icons/cup.svg" alt="go to homepage icon" />
                </a>
            </li>
            <li>
                <a href="order_on_going.php" <?php echo ($pagina == 'order_on_going.php') ? 'aria-current="page"' : "" ; ?>>
                    <img src="../../img/icons/cart.svg" alt="go to cart icon" />
                </a>
            </li>
            <li>
                <a href="profile.php" <?php echo ($pagina == 'profile.php') ? 'aria-current="page"' : "" ; ?>>
                    <img src="../../img/icons/user.svg" alt="go to user's page icon" />
                </a>
            </li>
        </ul>
    </nav>
?>