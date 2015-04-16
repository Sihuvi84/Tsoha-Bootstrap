<?php

require 'app/models/askare.php';

/**
 * Description of AskareController
 *
 * @author suvialat
 */
class AskareController extends BaseController {

    public static function index() {


        if (BaseController::get_user_logged_in() !== null) {
            $askareet = Askare::all();
            View::make('askare/index.html', array('askareet' => $askareet));
        } else {
            View::make('kayttaja/login.html', array('error' => 'Kirjaudu sisään tarkastellaksesi askareita.'));
        }
    }

    public static function show($id) {
        $askare = Askare::find($id);
        View::make('askare/edit.html', array('askare' => $askare));
    }

    public static function add() {
        View::make('askare/add.html');
    }

    public function store() {
        $params = $_POST;
        $unixTime = strtotime($params['deadline']);
        if (BaseController::get_user_logged_in() !== null) {
            $askare = new Askare(array(
                'a_nimi' => $params['nimi'],
                'a_kuvaus' => $params['kuvaus'],
                'a_prioriteetti' => $params['prioriteetti'],
                'a_toistuvuus' => $params['toistuvuus'],
                'a_tehty' => null,
                'a_luotu' => date('Y-m-d H:i:s'),
                'a_deadline' => date('Y-m-d H:i:s', $unixTime),
                'ak_kayttajatunnus' => BaseController::get_user_logged_in()->k_tunnus)
            );
            $askare->save();
//TODO: Askareen liittäminen luokkaaan
            Redirect::to('/tasks', array('message' => $askare->a_nimi . " lisätty askareisiin"));
        } else {
            View::make('kayttaja/login.html', array('error' => 'Askareen lisäys ei onnistunut. Kirjaudu uudelleen sisään.'));
        }
    }

}
