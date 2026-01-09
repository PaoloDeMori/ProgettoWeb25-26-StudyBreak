<?php 
    function sec_session_start() {
        $session_name = 'sec_session_id'; // Imposta un nome di sessione
        $secure = false; // Imposta il parametro a true se vuoi usare il protocollo 'https'.
        $httponly = true; // Questo impedirà ad un javascript di essere in grado di accedere all'id di sessione.
        ini_set('session.use_only_cookies', 1); // Forza la sessione ad utilizzare solo i cookie.
        $cookieParams = session_get_cookie_params(); // Legge i parametri correnti relativi ai cookie.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); // Imposta il nome di sessione con quello prescelto all'inizio della funzione.
        session_start(); // Avvia la sessione php.
        session_regenerate_id(); // Rigenera la sessione e cancella quella creata in precedenza.
    }

    function clean_textual_input($text){
        $modifiedText = trim($text); 
        $modifiedText = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        return $modifiedText;
    }

    function is_array_assoc($arr){
        if(!is_array($arr)){
            return false;
        }
        else{
            return array_keys($arr) !== range(0, (count($arr)-1));
        }
    }


    function formatExpiryDateForDB($expiryDate) {
    if (empty($expiryDate)) {
        return null;
    }

    $parts = explode('/', $expiryDate);

    if (count($parts) === 2) {
        $month = trim($parts[0]);
        $year = trim($parts[1]);

        if (strlen($year) === 2) {
            $year = "20" . $year;
        }

        if (strlen($month) === 1) {
            $month = "0" . $month;
        }

        if (checkdate((int)$month, 1, (int)$year)) {
            return $year . "-" . $month . "-01";
        }
    }

    return null;
    }

    ?>