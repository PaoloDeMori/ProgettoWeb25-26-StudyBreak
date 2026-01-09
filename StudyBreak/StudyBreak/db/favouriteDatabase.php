<?php
class favouriteDatabaseHelper
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function get_favourites_articles($idUser): array
    {
        $query = "SELECT B.ID_bevanda, B.nome, B.prezzo, B.foto, B.disponibilita
                    FROM BEVANDA B
                    JOIN Preferito P ON B.ID_bevanda = P.ID_bevanda
                    WHERE P.ID_Utente = ?;";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('i', $idUser);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            return [];
        }

        $articles = $result->fetch_all(MYSQLI_ASSOC);

        $bevande = [];

        foreach ($articles as $articolo) {
            $bevanda = new BevandaDTO(
                $articolo['ID_bevanda'],
                $articolo['nome'],
                $articolo['prezzo'],
                $articolo['foto'],
                null,
                $articolo['disponibilita']
            );
            $bevande[] = $bevanda;
        }
        return $bevande;
    }

    public function put_favourites_articles($idUser, $id_bevanda)
    {
        $query = "INSERT INTO `Preferito` (`ID_bevanda`, `ID_Utente`) VALUES (?, ?)";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('ii', $id_bevanda, $idUser);
            return $stmt->execute();
        }
        return false;
    }
    public function remove_favourites_articles($idUser, $id_bevanda)
    {
        $query = "DELETE FROM `Preferito` WHERE `ID_bevanda` = ? AND `ID_Utente` = ?";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('ii', $id_bevanda, $idUser);
            return $stmt->execute();
        }
        return false;
    }

    public function get_my_custom_articles($idUser): array
    {
        $query = "SELECT
                    ID_BEV,
                    nome,
                    foto
                    FROM BEVANDA_CUSTOM
                    WHERE ID_Utente = ?;";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('i', $idUser);
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
}