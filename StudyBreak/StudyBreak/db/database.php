<?php
class DatabaseHelper
{
    public $db;


    public function __construct($servername, $username, $password, $dbname, $port)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);

        if ($this->db->connect_error) {
            die("connessione fallita");
        }
    }

    public function get_user_info($username)
    {

        $query_utente = "SELECT ID_Utente, Password, Email, 'cliente'
            AS tipo_ruolo FROM UTENTE WHERE Username = ? LIMIT 1";

        $query_venditore = "SELECT ID_Venditore, Password, 'venditore' AS tipo_ruolo
                               FROM VENDITORE
                               WHERE Username = ? LIMIT 1";

        if ($stmt = $this->db->prepare($query_utente)) {
            $arrayAssocClient = $this->bind_and_fetchAll_user_info($stmt, $username);
            if (count($arrayAssocClient) === 0) {
                if ($stmt = $this->db->prepare($query_venditore)) {
                    $arrayAssocAdmin = $this->bind_and_fetchAll_user_info($stmt, $username);
                    $arrayAssocAdmin = (count($arrayAssocAdmin) <= 0) ? null : $arrayAssocAdmin;
                    if ($arrayAssocAdmin === null) {
                        return null;
                    }
                    foreach ($arrayAssocAdmin as $userI) {
                        $user = new UserDTO(
                            $userI['ID_Venditore'],
                            $username,
                            $userI['Password'],
                            $userI['tipo_ruolo'],
                            null
                        );
                        return $user;
                    }
                } else {
                    return null;
                }

            } else {
                foreach ($arrayAssocClient as $userI) {
                    $user = new UserDTO(
                        $userI['ID_Utente'],
                        $username,
                        $userI['Password'],
                        $userI['tipo_ruolo'],
                        $userI['Email'],
                    );
                    return $user;
                }
            }
        } else {
            return null;
        }
    }


    private function bind_and_fetchAll_user_info($stmt, $username)
    {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function get_login_attempts_number_using_time($user_id, $valid_time, $idValue)
    {
        $idName_in_db = ($idValue === VENDITORE_ROLE_VALUE) ? 'ID_Venditore' : 'ID_Utente';
        $query = "SELECT timestamp_tentativo FROM LOG_TENTATIVI WHERE $idName_in_db = ? AND timestamp_tentativo > ?";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('is', $user_id, $valid_time);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->num_rows;
        }
        die("Impossibile calcolare il numero di tentativi di login");
    }

    public function add_login_attempt($user_id, $user_role)
    {
        $query = ($user_role === CLIENTE_ROLE_VALUE) ? "INSERT INTO LOG_TENTATIVI (ID_Utente) VALUES(?)" :
            "INSERT INTO LOG_TENTATIVI (ID_Venditore) VALUES(?)";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
        } else {
            die('Impossibile continuare il login senza un corretto inserimento dell\'ultimo tentativo');
        }

    }

    public function register_utente($password, $email, $username)
    {
        $email = clean_textual_input($email);
        $username = clean_textual_input($username);

        $query = "INSERT INTO UTENTE (Username, Email, Password)
                    VALUES (?, ?, ?)";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('sss', $username, $email, $password);
            return $stmt->execute();
        }

    }

    public function register_venditore($password, $username)
    {
        $username = clean_textual_input($username);

        $query = "INSERT INTO VENDITORE (Username,  Password)
                    VALUES (?, ?)";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('ss', $username, $password);
            return $stmt->execute();
        }

    }


    public function get_most_ordered_articles($firstPrice, $secondPrice, $onlyWithCoffe, $onlyAvailable): array
    {
        $firstPrice = ($firstPrice == null) ? 0 : "$firstPrice";
        $secondPrice = ($secondPrice == null) ? 16 : "$secondPrice";
        if ($firstPrice > $secondPrice) {
            $temp = $firstPrice;
            $firstPrice = $secondPrice;
            $secondPrice = $temp;
        }

        $query = "SELECT
                    B.nome,
                    B.foto,
                    B.prezzo,
                    B.ID_Bevanda,
                    B.disponibilita,
                    IFNULL(SUM(O.quantita), 0) AS totale_vendite
                FROM
                    BEVANDA B
                LEFT JOIN
                    Ordinazione O ON B.ID_bevanda = O.ID_bevanda ";
        if ($onlyWithCoffe) {
            $query .= " INNER JOIN Composizione_admin CA ON B.ID_Bevanda = CA.ID_bevanda
                    INNER JOIN INGREDIENTE I ON CA.ID_ingrediente = I.ID_ingrediente ";
            ;
        }
        $query .= " WHERE
                B.prezzo BETWEEN ? AND ? AND B.disponibilita > ?";

        if ($onlyWithCoffe) {
            $query .= " AND I.nome LIKE '%caffe%' ";
            ;
        }

        $query .= " GROUP BY
                    B.ID_bevanda
                ORDER BY
                    totale_vendite DESC
                LIMIT 15;";
        $disponibilitaValue = ($onlyAvailable) ? -1 : 0;
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param("ddd", $firstPrice, $secondPrice, $disponibilitaValue);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return [];
        }

        $articles = $result->fetch_all(MYSQLI_ASSOC);

        $bevande = [];

        foreach ($articles as $articolo) {
            $bevanda = new BevandaDTO(
                $articolo['ID_Bevanda'],
                $articolo['nome'],
                $articolo['prezzo'],
                $articolo['foto'],
                $articolo['totale_vendite'],
                $articolo['disponibilita']
            );
            $bevande[] = $bevanda;
        }
        return $bevande;
    }

    public function searchByName(string $q): array
    {
        $q = trim($q);

        if (strlen($q) < 2) {
            return [];
        }

        $sql = "
            SELECT
                ID_Bevanda,
                nome,
                prezzo,
                foto
            FROM
                BEVANDA
            WHERE
                nome LIKE ?
            ORDER BY
                nome ASC
            LIMIT 20;
        ";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return [];
        }

        $like = "%$q%";
        $stmt->bind_param("s", $like);
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $bevande = [];

        foreach ($rows as $row) {
            $bevande[] = [
                "id" => (int) $row['ID_Bevanda'],
                "nome" => $row['nome'],
                "prezzo" => (float) $row['prezzo'],
                "foto" => $row['foto']
            ];
        }

        return $bevande;
    }


    public function get_item_from_id($id)
    {
        $query = "SELECT * FROM BEVANDA
                    WHERE ID_bevanda = ?;";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return false;
        }
        $arrayResult = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($arrayResult as $articolo) {
            $bevanda = new BevandaDTO(
                $articolo['ID_bevanda'],
                $articolo['nome'],
                $articolo['prezzo'],
                $articolo['foto'],
                null,
                $articolo['disponibilita']
            );
            return $bevanda;
        }
    }

    public function getLastInsertedId()
    {
        return $this->db->insert_id;
    }

    public function get_ingredients_from_bevanda($id_bevanda)
    {
        $query = "SELECT I.ID_ingrediente, I.nome, I.prezzo
              FROM Composizione C
              JOIN INGREDIENTE I ON C.ID_ingrediente = I.ID_ingrediente
              WHERE C.ID_BEV = ?;";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('i', $id_bevanda);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return null;
        }
        $arrayResult = $result->fetch_all(MYSQLI_ASSOC);
        $arrayIngredienti = [];
        foreach ($arrayResult as $ingrediente) {
            $bevanda = new IngredienteDto(
                $ingrediente['ID_ingrediente'],
                $ingrediente['nome'],
                $ingrediente['prezzo']
            );
            $arrayIngredienti[] = $bevanda;
        }
        return $arrayIngredienti;
    }

    public function get_ingredients()
    {
        $query = "SELECT I.ID_ingrediente, I.nome, I.prezzo
                  FROM INGREDIENTE I;";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return null;
        }
        $arrayResult = $result->fetch_all(MYSQLI_ASSOC);
        $arrayIngredienti = [];
        foreach ($arrayResult as $ingrediente) {
            $bevanda = new IngredienteDto(
                $ingrediente['ID_ingrediente'],
                $ingrediente['nome'],
                $ingrediente['prezzo']
            );
            $arrayIngredienti[] = $bevanda;
        }
        return $arrayIngredienti;
    }

        public function get_ingredient_from_id($id){
            $query="SELECT ID_ingrediente, nome, prezzo
                  FROM INGREDIENTE
                  WHERE ID_ingrediente = ?;";
                if($stmt = $this->db->prepare($query)){
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $result= $stmt->get_result();
                }
                else{
                    return null;
                }
                $arrayResult = $result->fetch_all(MYSQLI_ASSOC);
                $arrayIngredienti = [];
                foreach($arrayResult as $ingrediente){
                    $bevanda = new IngredienteDto(
                            $ingrediente['ID_ingrediente'],
                            $ingrediente['nome'],
                            $ingrediente['prezzo']
                        );
                   return $bevanda;
                }
                return null;
        }

        public function create_CustomBeverage($id_utente, $nome,$ingredientsIdArray){
            $query="SELECT ID_BEV FROM BEVANDA_CUSTOM WHERE nome = ? AND ID_Utente = ?;";
                if($stmt = $this->db->prepare($query)){
                $stmt->bind_param('si', $nome, $id_utente);
                $stmt->execute();
                $result= $stmt->get_result();
                if ($result->num_rows > 0) {
                        return false;
                    }
                }
                else{
                    return false;
                }
                    $query2 = "INSERT INTO BEVANDA_CUSTOM (nome, ID_Utente) VALUES (?, ?)";
                    if($stmt2 = $this->db->prepare($query2)){
                    $stmt2->bind_param('si', $nome, $id_utente);
                    $stmt2->execute();
                    $new_id_bev = $this->db->insert_id;
                    }
                    else{
                    return false;
                    }
                    $query3 = "INSERT INTO Composizione (ID_BEV, ID_ingrediente) VALUES (?, ?)";
                        if($stmt3 = $this->db->prepare($query3)){
                        $current=0;
                        $stmt3->bind_param('ii', $new_id_bev, $current);
                        foreach($ingredientsIdArray as $ingrediente){
                            $current=$ingrediente;
                        $stmt3->execute();
                        }
                        }
                        else{
                            return false;
                        }

                        $query4 = "INSERT INTO Bevanda_Custom_In_Carrello (ID_BEV, ID_Utente, Quantita) VALUES (?, ?, ?)";
                        if ($stmt4 = $this->db->prepare($query4)) {
                            $quantita = 1;
                            $stmt4->bind_param('iii', $new_id_bev, $id_utente, $quantita);
                            if (!$stmt4->execute()) {
                                return false;
                            }
                        } else {
                            return false;
                        }
                        return true;
        }


    public function get_ingredients_from_bevanda_custom($id_bevanda_custom){
        $query = "SELECT I.ID_ingrediente, I.nome, I.prezzo
                  FROM Composizione C
                  JOIN INGREDIENTE I ON C.ID_ingrediente = I.ID_ingrediente
                  WHERE C.ID_BEV = ?";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('i', $id_bevanda_custom);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return null;
        }
        $arrayResult = $result->fetch_all(MYSQLI_ASSOC);
        $arrayIngredienti = [];
        foreach ($arrayResult as $ingrediente) {
            $bevanda = new IngredienteDto(
                $ingrediente['ID_ingrediente'],
                $ingrediente['nome'],
                $ingrediente['prezzo']
            );
            $arrayIngredienti[] = $bevanda;
        }
        return $arrayIngredienti;
    }

    public function get_custom_from_name($name,$idUser): array{
        $query = "SELECT
                    ID_BEV,
                    nome,
                    foto
                    FROM BEVANDA_CUSTOM
                    WHERE ID_Utente = ? AND nome = ?;";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('is', $idUser,$name);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return null;
        }

        $articles = $result->fetch_all(MYSQLI_ASSOC);

        $bevande = [];

        foreach ($articles as $articolo) {
            $ingredienti = $this->get_ingredients_from_bevanda_custom($articolo['ID_BEV']);
            $price = 0;
            foreach ($ingredienti as $ingrediente) {
                $price += $ingrediente->prezzo;
            }
            $bevanda = new BevandaCustomDtoWithPrice(
                $articolo['ID_BEV'],
                $articolo['nome'],
                $articolo['foto'],
                $price,
            );
            $bevande[] = $bevanda;
        }
        return $bevande;
    }

    public function get_custom_from_id($id,$idUser): array{
        $query = "SELECT
                    ID_BEV,
                    nome,
                    foto
                    FROM BEVANDA_CUSTOM
                    WHERE ID_Utente = ? AND ID_BEV = ?;";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('ii', $idUser,$id);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return null;
        }

        $articles = $result->fetch_all(MYSQLI_ASSOC);

        $bevande = [];

        foreach ($articles as $articolo) {
            $ingredienti = $this->get_ingredients_from_bevanda_custom($articolo['ID_BEV']);
            $price = 0;
            foreach ($ingredienti as $ingrediente) {
                $price += $ingrediente->prezzo;
            }
            $bevanda = new BevandaCustomDtoWithPrice(
                $articolo['ID_BEV'],
                $articolo['nome'],
                $articolo['foto'],
                $price,
            );
            $bevande[] = $bevanda;
        }
        return $bevande;
    }

    public function delete_custom_from_id($id,$idUser){

        $query1 = "DELETE FROM Composizione WHERE ID_BEV = ?";
        if ($stmt = $this->db->prepare($query1)) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
        }

        $query2 = "DELETE FROM Bevanda_Custom_In_Carrello WHERE ID_BEV = ? AND ID_Utente = ?";
        if ($stmt = $this->db->prepare($query2)) {
            $stmt->bind_param('ii', $id, $idUser);
            $stmt->execute();
        }

        $query = "DELETE FROM BEVANDA_CUSTOM
                    WHERE ID_Utente = ? AND ID_BEV = ?;";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('ii', $idUser,$id);
            return $stmt->execute();
        } else {
            return false;
        }

    }

    public function get_orders_by_user($idUser,$stato)
    {
        $query = "SELECT
                    ID_ordine,
                    stato,
                    data_effettuazione,
                    orario_effettuazione,
                    data_arrivo,
                    orario_arrivo,
                    prezzo
                  FROM ORDINE
                  WHERE ID_Utente = ? AND stato = ?
                  ORDER BY data_effettuazione DESC, orario_effettuazione DESC;";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('is', $idUser, $stato);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return [];
        }

        $ordersData = $result->fetch_all(MYSQLI_ASSOC);
        $orderList = [];

        foreach ($ordersData as $ord) {
            $orderDto = new OrdineDto(
                $ord['ID_ordine'],
                $ord['stato'],
                $ord['data_effettuazione'],
                $ord['orario_effettuazione'],
                $ord['data_arrivo'],
                $ord['orario_arrivo'],
                $ord['prezzo'],
                $idUser
            );

            $orderDto->bevande = $this->get_standard_items_for_order($ord['ID_ordine']);

            $orderDto->bevandeCustom = $this->get_custom_items_for_order($ord['ID_ordine']);

            $orderList[] = $orderDto;
        }

        return $orderList;
    }

    private function get_standard_items_for_order($idOrdine)
    {
        $query = "SELECT
                    B.ID_bevanda,
                    B.nome,
                    B.prezzo,
                    B.foto,
                    O.quantita,
                    O.livello_zucchero,
                    O.latte,
                    O.ml_bevanda
                  FROM Ordinazione O
                  JOIN BEVANDA B ON O.ID_bevanda = B.ID_bevanda
                  WHERE O.ID_ordine = ?;";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('i', $idOrdine);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return [];
        }

        $items = $result->fetch_all(MYSQLI_ASSOC);
        $bevandeStandard = [];

        foreach ($items as $item) {
            $bevandeStandard[] = new BevandaOrdinataDto(
                $item['ID_bevanda'],
                $item['nome'],
                $item['prezzo'],
                $item['foto'],
                $item['quantita'],
                $item['livello_zucchero'],
                (bool)$item['latte'],
                $item['ml_bevanda']
            );
        }

        return $bevandeStandard;
    }

    private function get_custom_items_for_order($idOrdine)
    {
        $query = "SELECT
                    BC.ID_BEV,
                    BC.nome,
                    BC.foto,
                    OC.quantita
                  FROM Ordinazione_Custom OC
                  JOIN BEVANDA_CUSTOM BC ON OC.ID_BEV = BC.ID_BEV
                  WHERE OC.ID_ordine = ?;";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('i', $idOrdine);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return [];
        }

        $items = $result->fetch_all(MYSQLI_ASSOC);
        $bevandeCustom = [];

        foreach ($items as $item) {
            $ingredienti = $this->get_ingredients_from_bevanda_custom($item['ID_BEV']);
            $prezzoTotaleIng = 0;

            if ($ingredienti != null) {
                foreach ($ingredienti as $ing) {
                    $prezzoTotaleIng += $ing->prezzo;
                }
            }

            $bevandeCustom[] = new BevandaCustomOrdinataDto(
                $item['ID_BEV'],
                $item['nome'],
                $item['foto'],
                $item['quantita'],
                $prezzoTotaleIng
            );
        }

        return $bevandeCustom;
    }

    }
    ?>