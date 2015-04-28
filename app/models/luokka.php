<?php

/**
 * Description of luokka
 *
 * @author suvialat
 */
class Luokka extends BaseModel {

    public $l_tunnus, $l_nimi, $l_kuvaus, $lk_tunnus, $askareet;

    public function __construct($attributes) {
        parent::__construct($attributes);

        $this->validations = array(
            'required' => array(
                array('nimi'), array('kuvaus')),
            'lengthBetween' => array
                (array('nimi', 0, 100))
        );
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM luokka');
        $query->execute();
        $rows = $query->fetchAll();
        $luokat = array();

        foreach ($rows as $row) {
            $luokat[] = new Luokka(array(
                'l_tunnus' => $row['l_tunnus'],
                'l_nimi' => $row['l_nimi'],
                'l_kuvaus' => $row['l_kuvaus'],
                'lk_tunnus' => $row['lk_tunnus']
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
                'l_kuvaus' => $row['l_kuvaus'],
                'lk_tunnus' => $row['lk_tunnus'],
                'askareet' => Luokka::findAskareet($id, 
                        BaseController::get_user_logged_in()->k_tunnus)
            ));

            return $luokka;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO luokka (l_nimi, l_kuvaus, lk_tunnus)'
                . ' VALUES (:l_nimi, :l_kuvaus, :lk_tunnus) '
                . 'RETURNING l_tunnus');
        $query->execute(array(
            'l_nimi' => $this->l_nimi,
            'l_kuvaus' => $this->l_kuvaus,
            'lk_tunnus' => $this->lk_tunnus
                )
        );

        $row = $query->fetch();
        $this->l_tunnus = $row['l_tunnus'];
    }

    public function update($id) {
        $query = DB::connection()->prepare('UPDATE luokka '
                . 'SET l_nimi = :nimi, l_kuvaus = :kuvaus'
                . ' WHERE l_tunnus = :id');
        $query->execute(array('id' => $id,
            'nimi' => $this->l_nimi,
            'kuvaus' => $this->l_kuvaus));
        $this->id = $id;
    }

    public function destroy() {
        $query1 = DB::connection()->prepare('DELETE FROM askareluokka WHERE al_tunnus = :id');
        $query1->execute(array('id' => $this->l_tunnus));
        
        $query2 = DB::connection()->prepare('DELETE FROM luokka WHERE l_tunnus = :id');
        $query2->execute(array('id' => $this->l_tunnus));//$id
    }

    public static function findAskareet($id, $userid) {
        
        $query = DB::connection()->prepare('SELECT * FROM askare '
                . 'JOIN askareluokka ON askare.a_tunnus = askareluokka.aa_tunnus '
                . 'WHERE askareluokka.al_tunnus = :id AND '
                . 'askare.ak_kayttajatunnus = :k_tunnus');
        
        $query->execute(array('id' => $id, 'k_tunnus' => $userid));
        $rows = $query->fetchAll();
        $askareet = array();

        foreach ($rows as $row) {
            $askareet[] = new Askare(array(
                'a_tunnus' => $row['a_tunnus'],
                'a_nimi' => $row['a_nimi'],
                'a_kuvaus' => $row['a_kuvaus'],
                'a_prioriteetti' => $row['a_prioriteetti'],
                'a_toistuvuus' => $row['a_toistuvuus'],
                'a_tehty' => $row['a_tehty'],
                'a_luotu' => $row['a_luotu'],
                'a_deadline' => $row['a_deadline'],
                'ak_kayttajatunnus' => $row['ak_kayttajatunnus']
            ));
        }

        return $askareet;
    }

    public static function findAskareenLuokat($id) {
        
        $query = DB::connection()->prepare('SELECT * FROM luokka '
                . 'JOIN askareluokka ON luokka.l_tunnus = askareluokka.al_tunnus '
                . 'WHERE askareluokka.aa_tunnus = :id');
        $query->execute(array('id' => $id));
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

}
