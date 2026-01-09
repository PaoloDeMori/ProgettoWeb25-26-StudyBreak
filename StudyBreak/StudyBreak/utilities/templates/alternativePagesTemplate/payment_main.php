<header>
    <a href="homepage.php">
        <img src="../../img/icons/back.svg" alt="go back" />
    </a>
    <h2>
        Insert your data
    </h2>
</header>
<form action="../../utilities/templates/alternativePagesTemplate/processes/payment_process.php" method="post">
    <fieldset>
        <legend>Card data</legend>
        <label for="card-number">Card number</label>
        <input type="text" id="card-number" name="card-number" placeholder="XXXX XXXX XXXX XXXX" maxlength="19"
            required />
        <label for="card-holder">Card holder</label>
        <input type="text" id="card-holder" name="card-holder" placeholder="Name Surname" maxlength="26" required />
        <label for="expiry-date">Expiry date</label>
        <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY" maxlength="5" required />
        <label for="code">Security code</label>
        <input type="text" id="code" name="security-code" placeholder="CVC" maxlength="4" required />

        <button type="submit">Pay now</button>
    </fieldset>
</form>