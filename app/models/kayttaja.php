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

        $this->validations = array(
            'required' => array(
                array('nimi'), array('salasana')),
            'lengthBetween' => array
                (array('nimi', 0, 100), array('salasana', 10, 100))
        );
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
                'kr_tunnus' => $row['kr_tunnus']
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
                'kr_tunnus' => $row['kr_tunnus']
            ));

            return $kayttaja;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (k_nimi, k_salasana, kr_tunnus) '
                . 'VALUES (:k_nimi, :k_salasana, :kr_tunnus) RETURNING k_tunnus');
        $query->execute(array('k_nimi' => $this->k_nimi,
            'k_salasana' => $this->k_salasana, 'kr_tunnus' => $this->kr_tunnus));
        $row = $query->fetch();
        $this->k_tunnus = $row['k_tunnus'];
    }

    public static function destroy($id) {
        $query = DB::connection()->prepare('DELETE FROM Kayttaja WHERE k_tunnus = :id');
        $query->execute(array('id' => $id));
    }

    public function update($id) {
        $query = DB::connection()->prepare('UPDATE Kayttaja SET k_salasana = :salasana WHERE k_tunnus=:id');
        $query->execute(array('salasana' => $this->k_salasana, 'id' => $this->k_tunnus));
        $this->id = $id;
    }

    public function authenticate($name, $password) {

        $query = DB::connection()->prepare('SELECT * FROM Kayttaja '
                . 'WHERE k_nimi = :name AND k_salasana = :password LIMIT 1');
        $query->execute(array('name' => $name, 'password' => $password));
        $row = $query->fetch();
        
        if ($row) {
            $kayttaja = new Kayttaja(array(
                'k_tunnus' => $row['k_tunnus'],
                'k_nimi' => $row['k_nimi'],
                'k_salasana' => $row['k_salasana'],
                'kr_tunnus' => $row['kr_tunnus']
            ));

            return $kayttaja;
        } else {
            return null;
        }
    }

}
