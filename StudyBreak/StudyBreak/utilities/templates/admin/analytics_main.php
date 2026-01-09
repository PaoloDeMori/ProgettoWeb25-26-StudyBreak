 <?php if(!isset($analyticsParams["orders-last-month"],
            $analyticsParams["guadagno_last_month"],
            $analyticsParams["bevande-poca-quantita"]))
            {die("Invalid access to analytics");}?>

  <section>
            <header>
                <a href="profile.php">
                    <img src="../../img/icons/back.svg" alt="go back" />
                </a>
                <h2>
                    Your Analytics
                </h2>
            </header>
            <dl>
                <dt>
                    Total order last month
                </dt>
                <dd>
                    <?php echo $analyticsParams["orders-last-month"];?>
                </dd>
                <dt>
                    Revenue last month
                </dt>
                <dd>
                    <?php echo $analyticsParams['guadagno_last_month']. "€";?>
                </dd>
                <dt>
                    Number of low stock product
                </dt>
                <dd>
                    <?php echo $analyticsParams['bevande-poca-quantita'];?>
                </dd>
            </dl>
        </section>