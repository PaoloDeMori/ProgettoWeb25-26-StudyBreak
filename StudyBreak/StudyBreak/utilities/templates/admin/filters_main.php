<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../bootstrap.php');
?>
<section>
            <header>
                <a href="homepage.php">
                    <img src="../../img/icons/back.svg" alt="go back" />
                </a>
                <h2>
                    Filters
                </h2>
            </header>
            <form id="filters-form" action="homepage.php" method="GET">
                <input id="caffe" type="checkbox" name="caffe" <?php echo ($_SESSION['caffe']==true) ? "checked" : "";?>/>
                <label for="caffe">
                    <span><img src="../../img/icons/check.svg" alt="" /></span>
                    Caffè
                </label>

                <input id="available" type="checkbox" name="available"  <?php echo ($_SESSION['only-not-available']==true) ? "checked" : "";?>/>
                <label for="available">
                    <span><img src="../../img/icons/check.svg" alt="" /></span>
                    Not available
                </label>

                <button type="submit">Apply</button>
            </form>

        </section>