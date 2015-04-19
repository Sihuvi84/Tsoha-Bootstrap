<?php

/**
 * Description of Askare
 *
 * @author suvialat
 */
class Askare extends BaseModel {

    public $a_tunnus, $a_nimi, $a_kuvaus, $a_prioriteetti, $a_toistuvuus, $a_tehty, $a_luotu,
            $a_deadline, $ak_kayttajatunnus, $luokat;

    public function __construct($attributes) {
        parent::__construct($attributes);

        $this->validations = array(
            'required' => array(
                array('nimi'), array('kuvaus'), array('prioriteetti'), array('toistuvuus'),
                array('luokat')),
            'lengthBetween' => array
                (array('nimi', 0, 100)),
            'date' => array(
                (array('deadline'))),
            'integer' => array(
                array('prioriteetti'), array('toistuvuus'))
        );
    }

    public static function all() {
        $userId = BaseController::get_user_logged_in();
        $query = DB::connection()->prepare('SELECT * FROM Askare WHERE ak_kayttajatunnus=:id');
        $query->execute(array('id' => $userId->k_tunnus));
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
                'ak_kayttajatunnus' => $row['ak_kayttajatunnus'],
                'luokat' => Luokka::findAskareenLuokat($row['a_tunnus'])
            ));
        }

        return $askareet;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Askare WHERE a_tunnus = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $askare = new Askare(array(
                'a_nimi' => $row['a_nimi'],
                'a_kuvaus' => $row['a_kuvaus'],
                'a_prioriteetti' => $row['a_prioriteetti'],
                'a_toistuvuus' => $row['a_toistuvuus'],
                'a_tehty' => $row['a_tehty'],
                'a_luotu' => $row['a_luotu'],
                'a_deadline' => $row['a_deadline'],
                'ak_kayttajatunnus' => $row['ak_kayttajatunnus'],
                'luokat' => Luokka::findAskareenLuokat($id)
            ));

            return $askare;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare
                ('INSERT INTO askare (a_nimi, a_kuvaus, a_prioriteetti, a_toistuvuus, a_tehty, a_luotu, a_deadline, ak_kayttajatunnus)'
                . ' VALUES (:a_nimi, :a_kuvaus, :a_prioriteetti, :a_toistuvuus, :a_tehty, :a_luotu, :a_deadline, :ak_kayttajatunnus)'
                . 'RETURNING a_tunnus');
        $query->execute(array(
            'a_nimi' => $this->a_nimi,
            'a_kuvaus' => $this->a_kuvaus,
            'a_prioriteetti' => $this->a_prioriteetti,
            'a_toistuvuus' => $this->a_toistuvuus,
            'a_tehty' => $this->a_tehty,
            'a_luotu' => $this->a_luotu,
            'a_deadline' => $this->a_deadline,
            'ak_kayttajatunnus' => $this->ak_kayttajatunnus
                )
        );

        $row = $query->fetch();
        $this->a_tunnus = $row['a_tunnus'];

        foreach ($this->luokat as $luokka) {
            $this->saveAskareLuokka($luokka, $row['a_tunnus']);
        }
    }

    public function saveAskareLuokka($luokka, $a_tunnus) {
        $query = DB::connection()->prepare
                ('INSERT INTO Askareluokka (aa_tunnus, al_tunnus)'
                . ' VALUES (:aa_tunnus, :al_tunnus)');
        $query->execute(array(
            'aa_tunnus' => $a_tunnus,
            'al_tunnus' => $luokka
                )
        );
    }

}
