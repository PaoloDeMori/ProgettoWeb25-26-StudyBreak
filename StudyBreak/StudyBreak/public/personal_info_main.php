<?php 
    if(!isset($profileParams["user"])){
        die("Invalid access to profile picture");
    }
?>
  <section>
            <header>
                <a href=<?php
                if($_SESSION['role']==VENDITORE_ROLE_VALUE){
                    echo("admin/profile.php");
                    }
                else{
                    echo("user/profile.php");
                } 
                    ?>>
                    <img src="../img/icons/back.svg" alt="go back" />
                </a>
                <h2>
                    Personal Info
                </h2>
            </header>
            <dl>
                <dt>
                    Username
                </dt>
                <dd>
                    <?php echo $profileParams["user"]->nome?>
                </dd>
                <?php
                if($_SESSION['role']==CLIENTE_ROLE_VALUE){
                    echo("
                <dt>
                    Email
                </dt>
                <dd>
                    Paolodemori23@gmail.com
                </dd>");
                }
                ?>
            </dl>
        </section>