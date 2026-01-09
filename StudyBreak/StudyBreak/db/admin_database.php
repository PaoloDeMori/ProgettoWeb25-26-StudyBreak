<?php
require_once($default_directory . 'dtos.php');
class AdminDatabaseHelper
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
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

    public function get_orders_by_user($stato)
    {
        $query = "SELECT
                    ID_ordine,
                    stato,
                    data_effettuazione,
                    orario_effettuazione,
                    data_arrivo,
                    orario_arrivo,
                    prezzo,
                    ID_Utente
                  FROM ORDINE
                  WHERE stato = ?
                  ORDER BY data_effettuazione DESC, orario_effettuazione DESC;";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('s', $stato);
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
                $ord['ID_Utente']
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
                (bool) $item['latte'],
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

    public function get_bevande(): array
    {
        $query = "
        SELECT
            B.ID_bevanda,
            B.nome,
            B.prezzo,
            B.foto,
            B.disponibilita,
            IFNULL(SUM(O.quantita), 0) AS totale_vendite
        FROM
            BEVANDA B
        LEFT JOIN
            Ordinazione O ON B.ID_bevanda = O.ID_bevanda
        GROUP BY
            B.ID_bevanda
        ORDER BY
            B.nome ASC
    ";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return [];
        }

        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $bevande = [];

        foreach ($rows as $row) {
            $bevanda = new BevandaDTO(
                (int) $row['ID_bevanda'],
                $row['nome'],
                (float) $row['prezzo'],
                $row['foto'],
                (int) $row['totale_vendite'],
                (int) $row['disponibilita']
            );

            $bevande[] = $bevanda;
        }

        return $bevande;
    }

    public function get_orders_last_month()
    {
        $query = "SELECT COUNT(ID_ordine) AS totale
                  FROM ORDINE
                  WHERE data_effettuazione >= DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return 0;
        }

        $arrayResult = $result->fetch_all(MYSQLI_ASSOC);
        $riga = $arrayResult[0];

        return (int) $riga['totale'];
    }

    public function get_total_guadagno_last_month()
    {
        $query = "SELECT SUM(prezzo) AS totale_incassato
                  FROM ORDINE
                  WHERE data_effettuazione >= DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return 0.0;
        }

        $arrayResult = $result->fetch_all(MYSQLI_ASSOC);
        $riga = $arrayResult[0];

        return (float) ($riga['totale_incassato'] ?? 0.0);
    }

    public function get_bevande_poca_quantita()
    {
        $query = "SELECT COUNT(*) AS totale_scarse
                  FROM BEVANDA
                  WHERE disponibilita < 2";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return 0;
        }

        $arrayResult = $result->fetch_all(MYSQLI_ASSOC);
        $riga = $arrayResult[0];

        return (int) $riga['totale_scarse'];
    }

    public function complete_order($id_ordine)
    {
        $query = "UPDATE ORDINE 
                  SET stato = 'history' 
                  WHERE ID_ordine = ? AND stato = 'on_going'";

        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('i', $id_ordine);
            $result = $stmt->execute();
            return $result;
        } else {
            return false;
        }
    }


}
?>