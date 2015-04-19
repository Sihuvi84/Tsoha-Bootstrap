<?php

require 'app/models/askare.php';

/**
 * Description of AskareController
 *
 * @author suvialat
 */
class AskareController extends BaseController {

    public static function index() {
        $askareet = Askare::all();
        View::make('askare/index.html', array('askareet' => $askareet));
    }

    public static function show($id) {
        $askare = Askare::find($id);
        View::make('askare/askare.html', array('askare' => $askare));
    }

    public static function edit($id) {
        $askare = Askare::find($id);
        View::make('askare/edit.html', array('askare' => $askare));
    }

    public static function add() {
        $luokat = Luokka::all();
        View::make('askare/add.html', array('luokat' => $luokat));
    }

    public function store() {
        $params = $_POST;
        if ($params['deadline'] != "") {
            $unixTime = date('Y-m-d H:i:s', strtotime($params['deadline']));
        } else {
            $unixTime = null;
        }
        if (BaseController::get_user_logged_in() !== null) {
            $askare = new Askare(array(
                'a_nimi' => $params['nimi'],
                'a_kuvaus' => $params['kuvaus'],
                'a_prioriteetti' => $params['prioriteetti'],
                'a_toistuvuus' => $params['toistuvuus'],
                'a_tehty' => null,
                'a_luotu' => date('Y-m-d H:i:s'),
                'a_deadline' => $unixTime,
                'ak_kayttajatunnus' => BaseController::get_user_logged_in()->k_tunnus)
            );
            if ($askare->validate($params)) {
                $askare->save();
                Redirect::to('/tasks', array('message' => $askare->a_nimi . " lisätty askareisiin"));
            } else {
                View::make('askare/add.html', array('errors' => $askare->errors(), 
                    'askare' => $askare, 'luokat' => Luokka::all()));
            }
        } else {
            View::make('kayttaja/login.html', array('error' => 'Askareen lisäys ei onnistunut. Kirjaudu uudelleen sisään.'));
        }
    }

}
