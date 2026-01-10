<form action="../../utilities/auth/signup_admin_process.php" method="post">
            <fieldset>
                <legend>User's sign up data</legend>
                <label for="username">Username</label>
                <input id="username" type="text" name="username" placeholder="Enter your username"
                    autocomplete="username" required />
                <br />

                <label for="password">Password</label>
                <div>
                    <input id="password" type="password" name="password" placeholder="Enter your password"
                        autocomplete="new-password" required />
                    <button type="button" class="toggle-password"><img src="../../img/icons/hashed.svg" alt="show password" /></button>
                </div>
                <br />

                <label for="confirm">Confirm Password</label>
                <div>
                    <input id="confirm" type="password" name="confirm" placeholder="Confirm your password"
                        autocomplete="new-password" required />
                    <button type="button" class="toggle-password"><img src="../../img/icons/hashed.svg" alt="show password" /></button>
                </div>
                <?php 
                    if(isset($_SESSION['confirm_password_error']) && $_SESSION['confirm_password_error']==true){
                        echo "<p>La password di conferma non corrisponde</p>";
                    }
                    elseif(isset($_SESSION['register_status']) && $_SESSION['register_status'] === 'failed') {
                        echo "<p>Credenziali Non Valide</p>";
                    }
                ?>
                <br />
                <button type="submit">Register</button>
            </fieldset>
        </form>