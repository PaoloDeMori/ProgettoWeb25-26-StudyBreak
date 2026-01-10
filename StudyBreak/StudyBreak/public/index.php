<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once ("bootstrapNotAuthenticate.php"); ?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>
            Study Break - Welcome
        </title>
        <link rel="stylesheet" type="text/css" href="../public/css/pages/index.css">
        <link rel="icon" href="../../img/startPhoto.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <img src="../img/startPhoto.png" alt="">
        </header>
        <main>
            <section>
                <h1 class="large">
                    Study Break
                </h1>
                <p>What's better after a long day of studying?</p>
                <p>Hot drink, coffee and much more</p>
            </section>
        </main>
        <footer>
            <a href="login.php" class="btn">Start</a>
        </footer>
    </body>
</html>