<?php

class BevandaDTO {
    public $id;
    public $nome;
    public $prezzo;
    public $foto;
    public $totaleVendite;
    public $disponibilita;
    public $ingredients = [];

    public function __construct(
        $id,
        $nome,
        $prezzo,
        $foto,
        $totaleVendite,
        $disponibilita
    ){
        $this->disponibilita=$disponibilita;
        $this->id=$id;
        $this->nome=$nome;
        $this->prezzo=$prezzo;
        $this->foto = ($foto==null) ? 'default-bevanda.png' : $foto;
    }
}

class UserDto{

    public $id;
    public $nome;
    public $password;
    public $ruolo;
    public $email;

    public function __construct(
        $id,
        $nome,
        $password,
        $ruolo,
        $email
    ){
        $this->id=$id;
        $this->nome=$nome;
        $this->password=$password;
        $this->ruolo = ($ruolo!='venditore') ? CLIENTE_ROLE_VALUE : VENDITORE_ROLE_VALUE;
        $this->email=$email;
    }

}

class BevandaCarrelloDto extends BevandaDto{


    public $quantita;
    public $zucchero;
    public $latte;
    public $ml_bevanda;

    public function __construct(
     $id,
     $nome,
     $prezzo,
     $foto,
     $quantita,
     $zucchero,
     $latte,
     $ml_bevanda
    ){
        parent::__construct($id, $nome, $prezzo, $foto, $quantita,null);
        $this->quantita=$quantita;
        $this->zucchero=$zucchero;
        $this->latte=$latte;
        $this->ml_bevanda = $ml_bevanda;
    }
    public function getPrezzoTotale() {
        return $this->prezzo * $this->quantita;
    }

}

class BevandaCustomDto{

    public $id;
    public $nome;
    public $foto;
    public $ingredients = [];


    public function __construct(
        $id,
        $nome,
        $foto
    ){
        $this->id=$id;
        $this->nome=$nome;
        $this->foto = ($foto==null) ? 'default-bevanda.png' : $foto;
    }

}

class BevandaCustomDtoWithPrice extends BevandaCustomDto{

    public $prezzo = 0;

    public function __construct(
        $id,
        $nome,
        $foto,
        $prezzo
    ){
        parent::__construct($id, $nome, $foto);
        $this->prezzo = $prezzo;
    }
}


class BevandaCustomInCarrelloDto extends BevandaCustomDto{

    public $quantita;

    public function __construct(
     $id,
     $nome,
     $foto,
     $quantita
    ){
        parent::__construct($id, $nome, $foto);
        $this->quantita=$quantita;
    }

    public function getPrezzoSingoloIngrediente() {
        $totale=0;
        foreach ($this->ingredients as $ingrediente) {
            $totale += $ingrediente->prezzo;
        }
        return $totale;
    }

    public function getPrezzoTotale() {
        return $this->getPrezzoSingoloIngrediente() * $this->quantita;
    }
}

class IngredienteDto{

        public $id;
        public $nome;
        public $prezzo;

    public function __construct(
        $id,
        $nome,
        $prezzo
    ){
        $this->id=$id;
        $this->nome=$nome;
        $this->prezzo=$prezzo;
    }
}

    class Cart{
        public $bevande = [];
        public $bevandeCustom = [];
        public $totalPrice;

        public function __construct(
        $bevande,
        $bevandeCustom,
        $totalPrice
    ){
        $this->bevande=$bevande;
        $this->bevandeCustom=$bevandeCustom;
        $this->totalPrice=$totalPrice;
    }
}

class BevandaOrdinataDto extends BevandaDto {

    public $quantita;
    public $zucchero;
    public $latte;
    public $ml_bevanda;

    public function __construct(
        $id,
        $nome,
        $prezzo,
        $foto,
        $quantita,
        $zucchero,
        $latte,
        $ml_bevanda
    ) {
        parent::__construct($id, $nome, $prezzo, $foto, $quantita, null); 
        
        $this->quantita = $quantita;
        $this->zucchero = $zucchero;
        $this->latte = $latte;
        $this->ml_bevanda = $ml_bevanda;
    }

    public function getSubtotale() {
        return $this->prezzo * $this->quantita;
    }
}

class BevandaCustomOrdinataDto extends BevandaCustomDto {

    public $quantita;
    public $prezzoSingolo;

    public function __construct(
        $id,
        $nome,
        $foto,
        $quantita,
        $prezzoSingolo
    ) {
        parent::__construct($id, $nome, $foto);
        $this->quantita = $quantita;
        $this->prezzoSingolo = $prezzoSingolo;
    }

    public function getSubtotale() {
        return $this->prezzoSingolo * $this->quantita;
    }
}

class OrdineDto {

    public $id;
    public $stato;
    public $dataEffettuazione;
    public $orarioEffettuazione;
    public $dataArrivo;
    public $orarioArrivo;
    public $prezzoTotale;
    public $idUtente;

    public $bevande = []; 
    public $bevandeCustom = [];

    public function __construct(
        $id,
        $stato,
        $dataEffettuazione,
        $orarioEffettuazione,
        $dataArrivo,
        $orarioArrivo,
        $prezzoTotale,
        $idUtente
    ) {
        $this->id = $id;
        $this->stato = $stato;
        $this->dataEffettuazione = $dataEffettuazione;
        $this->orarioEffettuazione = $orarioEffettuazione;
        
        $this->dataArrivo = $dataArrivo;
        $this->orarioArrivo = $orarioArrivo;
        
        $this->prezzoTotale = $prezzoTotale;
        $this->idUtente = $idUtente;
    }
}
