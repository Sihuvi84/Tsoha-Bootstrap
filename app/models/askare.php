<?php

/**
 * Description of Askare
 *
 * @author suvialat
 */
class Askare extends BaseModel{

    public $a_tunnus, $a_nimi, $a_kuvaus, $a_prioriteetti, $a_toistuvuus, $a_tehty, $a_luotu,
            $a_deadline, $ak_kayttajatunnus;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {

        $query = DB::connection()->prepare('SELECT * FROM Askare');
        $query->execute();
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

}
