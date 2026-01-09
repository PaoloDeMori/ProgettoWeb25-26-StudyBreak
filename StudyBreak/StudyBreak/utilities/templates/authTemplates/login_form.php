<form action="../utilities/auth/login_process.php" method="post">
            <fieldset>
                <legend>User's data</legend>
                <label for="username">Username</label>
                <input id="username" type="text" name="username" placeholder="Enter your username"
                    autocomplete="username" required />
                <br />
                <label for="password">Password</label>
                <div>
                    <input id="password" type="password" name="password" placeholder="Enter your password"
                        autocomplete="new-password" required />
                    <button type="button"><img src="../img/icons/hashed.svg" alt="show password" /></button>
                </div>
                <?php 
                    if(isset($_SESSION['login_status']) && $_SESSION['login_status'] === 'failed') {
                        echo "<p>Credenziali errate</p>";
                    }
                 ?>
                <br />
                <button type="submit">Log in</button>
            </fieldset>
        </form>