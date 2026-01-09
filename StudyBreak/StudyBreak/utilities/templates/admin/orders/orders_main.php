<section>
            <header>
                <a href="profile.php">
                    <img src="../../img/icons/back.svg" alt="back's icon">
                </a>
                <h2>
                    My Orders
                </h2>
            </header>

            <?php
            if($ordersParams["status"]=='ongoing'){
                echo(
                "<nav>
                    <a href='order_on_going.php' aria-current='page'>On Going</a>
                    <a href='order_history.php'>History</a>
                </nav>");
            }
            else{
                echo(
                "<nav>
                    <a href='order_on_going.php'>On Going</a>
                    <a href='order_history.php' aria-current='page'>History</a>
                </nav>");
            }
            ?>
            
            <ul>
                <?php $num=0; ?>
                <?php foreach($ordersParams["ordersList"] as $ordine): ?>
                    <?php $num+=1; ?>
                    <?php require 'order_summary_item.php' ?>
                <?php endforeach; ?>
            </ul>
        </section>