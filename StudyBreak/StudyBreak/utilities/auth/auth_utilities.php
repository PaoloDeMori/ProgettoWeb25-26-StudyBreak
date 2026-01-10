<?php

    function isVenditore($user){
                return $user->ruolo=='venditore';

    }

    function isCliente($user){
        return $user->ruolo=='cliente';
    }

    /*
     Funzione che restituisce true se 
     l'utente ha effettuato 
    */
    function checkbrute($user_id ,$user_role_value) {
        global $dbh;
        $now = time();
        $valid_attempts = date("Y-m-d H:i:s", $now - (TIME_TO_CHECK_BRUTE_FORCE));
            if($dbh->get_login_attempts_number_using_time($user_id,$valid_attempts, $user_role_value)>5) {
                return true;
            } else {
                return false;
            }
        }


    function login($username, $password){
        global $dbh;

        $username=clean_textual_input($username);

        $user = $dbh->get_user_info($username);
        if($user === null){
            return false;
        }
        $is_cliente = isCliente($user);
        $user_id = $user->id;
        $role_val = $user->ruolo ;
        if(checkbrute($user_id, $role_val)){
            die("Non puoi continuare a fare tentativi di login, aspetta del tempo prima di continuare.");
            return false;
        }
        if(password_verify($password,$user->password)){
            setLoginSessionVariabes($username,$user->password,$role_val,$user_id );
            return true;
        }
        else {
            $dbh->add_login_attempt($user_id, $role_val);
            return false;
        }
    }

    function setLoginSessionVariabes($username,$password,$role_val,$idUtenteLogged){
        $username=clean_textual_input($username);
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['username'] = $username;
        $_SESSION['password_and_browser'] = hash(HASH_ALGORITHM,$password.$user_browser);
        $_SESSION['role'] = $role_val;
        $_SESSION['idUtenteLogged'] = $idUtenteLogged;
    }

    function login_check_on_different_pages(){
    global $dbh;
    if(isset($_SESSION['username'], $_SESSION['password_and_browser'], $_SESSION['role'])) {
        $session_username = $_SESSION['username'];
        $session_password_and_browser = $_SESSION['password_and_browser'];
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        $session_role = $_SESSION['role'];

        $user = $dbh->get_user_info($session_username);
        
        if($user === null){
            return false;
        }

        if($user->ruolo == 'cliente' && $session_role != CLIENTE_ROLE_VALUE){
            return false;
        }
        if($user->ruolo == 'venditore' && $session_role != VENDITORE_ROLE_VALUE){
            return false;
        }

        $db_password = $user->password; 
        
        $hashed_dbpassword_and_browser = hash(HASH_ALGORITHM, $db_password . $user_browser);
        
        if($hashed_dbpassword_and_browser === $session_password_and_browser){
            return true;
        }
        }
    return false;
    }

    function check_role_access() {
    $current_uri = $_SERVER['REQUEST_URI'];
    
    $session_role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

    if ($session_role == VENDITORE_ROLE_VALUE && strpos($current_uri, '/public/user/') !== false) {
        die("non hai accesso a questa pagina");
    }

    if ($session_role == CLIENTE_ROLE_VALUE && strpos($current_uri, '/public/admin/') !== false) {
        header("Location: " . $GLOBALS['default_directory'] . "public/user/homepage.php");
        die("non hai accesso a questa pagina");
    }
    }

    function register($username, $password, $email, $confirm_password){
        global $dbh;
        if($password !== $confirm_password){
            $_SESSION['confirm_password_error'] = true;
            return false;
        }

        $_SESSION['confirm_password_error'] = false;

        $search_for_already_present = $dbh->get_user_info($username);
        if(($search_for_already_present!==null)){
            $_SESSION['register_status'] = 'failed'; 
            return false;
        }
        $password=password_hash($password,PASSWORD_BCRYPT);
         if($dbh->register_utente($password,$email,$username)){
            $usId=$dbh->getLastInsertedId();
            setLoginSessionVariabes($username,$password,CLIENTE_ROLE_VALUE,$usId);
            return true;
         }
         else{
            return false;
         }
    }

    function register_admin($username, $password, $confirm_password){
        global $dbh;
        if($password !== $confirm_password){
            $_SESSION['confirm_password_error'] = true;
            return false;
        }

        $_SESSION['confirm_password_error'] = false;

        $search_for_already_present = $dbh->get_user_info($username);
        if(($search_for_already_present!==null)){
            $_SESSION['register_status'] = 'failed'; 
            return false;
        }
        $password=password_hash($password,PASSWORD_BCRYPT);
         if($dbh->register_venditore($password,$username)){
            $usId=$dbh->getLastInsertedId();
            setLoginSessionVariabes($username,$password,VENDITORE_ROLE_VALUE,$usId);
            return true;
         }
         else{
            return false;
         }
    }
    ?>