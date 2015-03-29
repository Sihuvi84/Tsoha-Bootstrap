<?php

/**
 * Description of Kayttaja
 *
 * @author suvialat
 */
class Kayttaja extends BaseModel {

    public $k_tunnus, $k_nimi, $k_salasana, $kr_tunnus;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $query->execute();
        $rows = $query->fetchAll();
        $users = array();

        foreach ($rows as $row) {
            $users[] = new Kayttaja(array(
                'k_tunnus' => $row['k_tunnus'],
                'k_nimi' => $row['k_nimi'],
                'k_salasana' => $row['k_salasana'],
                'kr_tunnus' => $row['kr_tunnus'] //obs!
            ));
        }

        return $users;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE k_tunnus = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = new Kayttaja(array(
                'k_tunnus' => $row['k_tunnus'],
                'k_nimi' => $row['k_nimi'],
                'k_salasana' => $row['k_salasana'],
                'kr_tunnus' => $row['kr_tunnus'] //obs!
            ));

            return $kayttaja;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (k_tunnus, k_nimi, k_salasana, kr_tunnus) '
                . 'VALUES (:k_tunnus, :k_nimi, :k_salasana, :kr_tunnus) RETURNING id');
        $query->execute(array('k_tunnus' => $this->k_tunnus, 'k_nimi' => $this->k_nimi, 
            'k_salasana' => $this->k_salasana, 'kr_tunnus' => $this->kr_tunnus));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

   
}
