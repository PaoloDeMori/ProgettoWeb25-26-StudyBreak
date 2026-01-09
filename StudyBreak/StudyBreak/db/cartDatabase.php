<?php
require_once($default_directory . 'dtos.php');
class cartDatabaseHelper
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCart($id_utente)
    {
        $bevande = $this->get_bevande_in_cart($id_utente);
        $bevandeCustom = $this->get_bevande_custom_in_cart($id_utente);
        $cartPrice = 0;

        foreach ($bevande as $bevanda) {
            $cartPrice += $bevanda->getPrezzoTotale();
        }

        foreach ($bevandeCustom as $bevandaC) {
            $cartPrice += $bevandaC->getPrezzoTotale();
        }

        return new Cart($bevande, $bevandeCustom, $cartPrice);
    }

    public function get_bevande_in_cart($id_utente)
    {
        $query = "SELECT
                    B.ID_bevanda, B.nome, B.prezzo, B.foto,
                    BIC.quantita, BIC.livello_zucchero, BIC.latte, BIC.ml_bevanda
                    FROM Bevanda_In_Carrello BIC
                    JOIN BEVANDA B ON BIC.ID_bevanda = B.ID_bevanda
                    WHERE BIC.ID_Utente = ?";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('i', $id_utente);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return null;
        }
        $arrayResult = $result->fetch_all(MYSQLI_ASSOC);
        $arrayIngredienti = [];
        foreach ($arrayResult as $bevande) {
            $bevanda = new BevandaCarrelloDto(
                $bevande['ID_bevanda'],
                $bevande['nome'],
                $bevande['prezzo'],
                $bevande['foto'],
                $bevande['quantita'],
                $bevande['livello_zucchero'],
                $bevande['latte'],
                $bevande['ml_bevanda'],
            );
            $bevanda->ingredients = $this->get_ingredients_from_bevanda($bevande['ID_bevanda']);
            $arrayIngredienti[] = $bevanda;
        }
        return $arrayIngredienti;
    }

    public function get_bevande_custom_in_cart($id_utente)
    {
        $query = "SELECT
                    BC.ID_BEV, BC.nome, BC.foto, BCC.Quantita
                    FROM Bevanda_Custom_In_Carrello BCC
                    JOIN BEVANDA_CUSTOM BC ON BCC.ID_BEV = BC.ID_BEV
                    WHERE BCC.ID_Utente = ?";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('i', $id_utente);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return null;
        }
        $arrayResult = $result->fetch_all(MYSQLI_ASSOC);
        $arrayIngredienti = [];
        foreach ($arrayResult as $bevande) {
            $bevanda = new BevandaCustomInCarrelloDto(
                $bevande['ID_BEV'],
                $bevande['nome'],
                $bevande['foto'],
                $bevande['Quantita'],
            );
            $bevanda->ingredients = $this->get_ingredients_from_bevanda_custom($bevande['ID_BEV']);
            $arrayIngredienti[] = $bevanda;
        }
        return $arrayIngredienti;
    }

    public function get_ingredients_from_bevanda($id_bevanda)
    {
        $query = "SELECT I.ID_ingrediente, I.nome, I.prezzo
                  FROM Composizione_admin CA
                  JOIN INGREDIENTE I ON CA.ID_ingrediente = I.ID_ingrediente
                  WHERE CA.ID_bevanda = ?";
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

    public function get_ingredients_from_bevanda_custom($id_bevanda_custom)
    {
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


    public function move_bevanda_to_cart($id_bevanda, $id_utente, $quantita, $livello_zucchero, $ml_bevanda, $latte)
    {
        $query = "INSERT INTO Bevanda_In_Carrello (ID_bevanda, ID_Utente, quantita, livello_zucchero, ml_bevanda,latte)
                        VALUES (?, ?, ?, ?, ?,?)
                        ON DUPLICATE KEY UPDATE quantita = quantita + VALUES(quantita);";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('iiiiii', $id_bevanda, $id_utente, $quantita, $livello_zucchero, $ml_bevanda, $latte);
            return $stmt->execute();
        }
        return false;
    }

    public function remove_bevanda_by_bevanda_id($id_bevanda, $id_utente)
    {
        $query = "DELETE FROM `Bevanda_In_Carrello`
              WHERE ID_bevanda = ? AND ID_Utente = ?";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('ii', $id_bevanda, $id_utente);
            return $stmt->execute();
        }
        return false;
    }

    public function remove_bevanda_custom_by_id($id_bevanda_custom, $id_utente)
    {
        $query = "DELETE FROM `Bevanda_Custom_In_Carrello`
              WHERE ID_BEV = ?
              AND ID_Utente = ?";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('ii', $id_bevanda_custom, $id_utente);
            return $stmt->execute();
        }

        return false;
    }


        public function move_bevanda_custom_to_cart($id_bevanda,$id_utente){
            $query="INSERT INTO Bevanda_Custom_In_Carrello (ID_BEV, ID_Utente, Quantita) 
	                VALUES (?, ?, 1)
                    ON DUPLICATE KEY UPDATE Quantita = Quantita + 1";
                if($stmt = $this->db->prepare($query)){
                $stmt->bind_param('ii',$id_bevanda,$id_utente);
                return $stmt->execute();
                }
                return false;
        }

public function from_cart_to_order($id_utente, $card_number, $cardholder, $expiry, $cvc){

    $this->db->begin_transaction();

    $id_ordine = $this->create_order_record($id_utente);
    if (!$id_ordine) {
        $this->db->rollback();
        return false;
    }
    if (!$this->insert_payment_details($id_ordine, $card_number, $cardholder, $expiry, $cvc)) {
        $this->db->rollback();
        return false;
    }
    if (!$this->transfer_cart_to_order($id_ordine, $id_utente)) {
        $this->db->rollback();
        return false;
    }
    if (!$this->clear_user_cart($id_utente)) {
        $this->db->rollback();
        return false;
    }
    return $this->db->commit();
}

private function create_order_record($id_utente)
{
    $query = "INSERT INTO ORDINE (stato, data_effettuazione, prezzo, ID_Utente)
        SELECT 'on_going', CURDATE(), 
            (SELECT IFNULL(SUM(b.prezzo * bc.quantita), 0) FROM Bevanda_In_Carrello bc JOIN BEVANDA b ON bc.ID_bevanda = b.ID_bevanda WHERE bc.ID_Utente = ?) + 
            (SELECT IFNULL(SUM(i.prezzo * bcc.Quantita), 0) FROM Bevanda_Custom_In_Carrello bcc JOIN Composizione c ON bcc.ID_BEV = c.ID_BEV JOIN INGREDIENTE i ON c.ID_ingrediente = i.ID_ingrediente WHERE bcc.ID_Utente = ?), 
            ?";

    if ($stmt = $this->db->prepare($query)) {
        $stmt->bind_param('iii', $id_utente, $id_utente, $id_utente);
        $stmt->execute();
        return $this->db->insert_id;
    }
    return null;
}

private function insert_payment_details($id_ordine, $n, $h, $e, $c)
{
    $query = "INSERT INTO CARTA_DI_CREDITO (Card_Number, Cardholder_name, Expiry_Date, CVC, ID_ordine) 
    VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $this->db->prepare($query)) {
        $stmt->bind_param('ssssi', $n, $h, $e, $c, $id_ordine);
        return $stmt->execute();
    }
    return false;
}

private function transfer_cart_to_order($id_ordine, $id_utente)
{
    $query1 = "INSERT INTO Ordinazione (ID_bevanda, ID_ordine, livello_zucchero, ml_bevanda, quantita, latte)
        SELECT ID_bevanda, ?, livello_zucchero, ml_bevanda, quantita, latte FROM Bevanda_In_Carrello WHERE ID_Utente = ?";
    
    $query2 = "INSERT INTO Ordinazione_Custom (ID_BEV, ID_ordine, quantita)
        SELECT ID_BEV, ?, Quantita FROM Bevanda_Custom_In_Carrello WHERE ID_Utente = ?";

    if ($stmt1 = $this->db->prepare($query1)) {
        $stmt1->bind_param('ii', $id_ordine, $id_utente);
        if (!$stmt1->execute()){
             return false;
        }
    }

    if ($stmt2 = $this->db->prepare($query2)) {
        $stmt2->bind_param('ii', $id_ordine, $id_utente);
        return $stmt2->execute();
    }
    return false;
}

private function clear_user_cart($id_utente)
{
    $query11 = "DELETE FROM Bevanda_In_Carrello WHERE ID_Utente = ?";
    $query12 = "DELETE FROM Bevanda_Custom_In_Carrello WHERE ID_Utente = ?";

    if ($stmt1 = $this->db->prepare($query11)) {
        $stmt1->bind_param('i', $id_utente);
        $stmt1->execute();
    }
    if ($stmt2 = $this->db->prepare($query12)) {
        $stmt2->bind_param('i', $id_utente);
        return $stmt2->execute();
    }
    return false;
}

}