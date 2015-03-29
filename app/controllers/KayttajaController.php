<?php

require 'app/models/kayttaja.php';

class KayttajaController extends BaseController {

    public static function index() {

        $kayttajat = Kayttaja::all();
        View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
    }

    public static function store() {
        $params = $_POST;
        $user = new Kayttaja(array(
            'k_tunnus' => $params['k_tunnus'],
            'k_nimi' => $params['k_nimi'],
            'kr_tunnus' => $params['kr_tunnus'],
            'k_salasana' => $params['k_salasana']
        ));

        $user->save();

        Redirect::to('/users/', array('message' => 'Käyttäjä lisätty!'));

        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
        // Redirect::to('/users/' . $user->id, array('message' => 'Peli on lisätty kirjastoosi!'));
    }

}
