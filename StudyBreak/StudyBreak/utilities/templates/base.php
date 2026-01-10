<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>
        <?php echo "Study Break" . $templateParams["head-title"] ?>
    </title>
    <link rel="stylesheet" type="text/css" href=<?php echo '"' . $templateParams["foglio-di-stile"] . '"' ?> />
    <link rel="icon" href="../../img/startPhoto.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <header>
        <h1>
            <?php echo $templateParams["title"] ?>
        </h1>
    </header>

    <!-- nav -->
    <?php
    if (isset($templateParams["nav"])) {
        require($templateParams["nav"]);
    }
    ?>

    <!-- main -->

    <main> <?php
    if (isset($templateParams["main-content"])) {
        require($templateParams["main-content"]);
    }
    ?>
    </main>

    <!-- footer -->
    <?php
    if (isset($templateParams["footer"])) {
        require($templateParams["footer"]);
    }
    ?>


    <!-- JS -->
    <?php
    if (isset($templateJs)) {
        foreach ($templateJs as $jsFileName) {
            echo '<script src="../../js/' . $jsFileName . '"></script>';
        }
    }
    ?>

    <?php
    if (isset($templateAuthJs)) {
        foreach ($templateAuthJs as $jsFileName) {
            echo '<script src="../js/' . $jsFileName . '"></script>';
        }
    }
    ?>

    

</body>

</html>