<?php

/**
 * Description of luokka
 *
 * @author suvialat
 */
class Luokka extends BaseModel {

    public $l_tunnus, $l_nimi, $l_kuvaus;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM Luokka');
        $query->execute();
        $rows = $query->fetchAll();
        $luokat = array();

        foreach ($rows as $row) {
            $luokat[] = new Luokka(array(
                'l_tunnus' => $row['l_tunnus'],
                'l_nimi' => $row['l_nimi'],
                'l_kuvaus' => $row['l_kuvaus']
            ));
        }

        return $luokat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Luokka WHERE l_tunnus = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $luokka = new Luokka(array(
                'l_tunnus' => $row['l_tunnus'],
                'l_nimi' => $row['l_nimi'],
                'l_kuvaus' => $row['l_kuvaus']
            ));

            return $luokka;
        }
        return null;
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO luokka (l_nimi, l_kuvaus)'
                . ' VALUES (:l_nimi, :l_kuvaus) RETURNING l_tunnus');
        $query->execute(array(
                        'l_nimi' => $this->l_nimi,
                        'l_kuvaus' => $this->l_kuvaus,
                    )
                );
        
        $row = $query->fetch();
        $this->l_tunnus = $row['l_tunnus'];
    }

}
