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

    public static function editForm($id) {
        $askare = Askare::find($id);
        $askareenluokat = array();
        foreach ($askare->luokat as $luokka) {
            $askareenluokat[] = $luokka->l_tunnus;
        }
        View::make('askare/edit.html', array('askare' => $askare,
            'luokat' => Luokka::all(),
            'askareenluokat' => $askareenluokat));
    }

    public static function add() {
        $luokat = Luokka::all();
        View::make('askare/add.html', array('luokat' => $luokat));
    }

    public static function edit($id) {
        $params = $_POST;
        $askare = Askare::find($id);

        if (isset($params['tehty']) && $askare->a_tehty == null) {
            $params['tehty'] = date('Y-m-d H:i');
        } else {
            $params['tehty'] = null;
        }

        if (isset($params['deadline']) && $params['deadline'] != null) {
            $unixTime = date('Y-m-d H:i', strtotime($params['deadline']));
        } else {
            $unixTime = null;
        }

        foreach ($params['luokat'] as $luokka) {
            $params['luokat'][] = $luokka;
        }


        $attributes = array(
            'a_tunnus' => $askare->a_tunnus,
            'a_nimi' => $params['nimi'],
            'a_kuvaus' => $params['kuvaus'],
            'a_prioriteetti' => $params['prioriteetti'],
            'a_toistuvuus' => $params['toistuvuus'],
            'a_tehty' => $params['tehty'],
            'a_luotu' => $askare->a_luotu,
            'a_deadline' => $unixTime,
            'ak_kayttajatunnus' => $askare->ak_kayttajatunnus,
            'luokat' => $params['luokat']
        );

        $askare = new Askare($attributes);

        if ($askare->validate($params)) {
            $askare->update($id);
            Redirect::to('/tasks/' . $askare->a_tunnus, array('message' => 'Askare päivitetty!'));
        } else {
            $askareenluokat = array();
            foreach ($askare->luokat as $luokka) {
                $askareenluokat[] = $luokka->l_tunnus;
            }
            View::make('askare/edit.html', array('errors' => $askare->errors(),
                'attributes' => $params, 'askare' => $askare,
                'luokat' => Luokka::all(),
                'askareenluokat' => $askareenluokat));
        }
    }

    public function store() {
        $params = $_POST;

        if ($params['deadline'] != "") {
            $unixTime = date('Y-m-d H:i', strtotime($params['deadline']));
        } else {
            $unixTime = NULL;
        }

        if (isset($params['luokat'])) {
            $luokat = $params['luokat'];
            foreach ($luokat as $luokka) {
                $params['luokat'][] = $luokka;
            }
        } else {
            $params['luokat'] = null;
        }

        if (BaseController::get_user_logged_in() !== null) {
            $askare = new Askare(array(
                'a_nimi' => $params['nimi'],
                'a_kuvaus' => $params['kuvaus'],
                'a_prioriteetti' => $params['prioriteetti'],
                'a_toistuvuus' => $params['toistuvuus'],
                'a_tehty' => null,
                'a_luotu' => date('Y-m-d H:i'),
                'a_deadline' => $unixTime,
                'ak_kayttajatunnus' => BaseController::get_user_logged_in()->k_tunnus,
                'luokat' => $params['luokat']
            ));

            if ($askare->validate($params)) {
                $askare->save();
                Redirect::to('/tasks', array('message' => $askare->a_nimi . " lisätty askareisiin"));
            } else {
                View::make('askare/add.html', array('errors' => $askare->errors(),
                    'askare' => $askare, 'luokat' => Luokka::all()));
            }
        } else {
            View::make('kayttaja/login.html', array('error' => 'Askareen lisäys ei onnistunut.'
                . ' Kirjaudu uudelleen sisään.'));
        }
    }

    public static function SortBy($field) {
        $askareet = Askare::all();
        switch ($field) {
            case "a_toistuvuus":
                usort($askareet, function($a, $b) {
                    return $a->a_toistuvuus - $b->a_toistuvuus;
                });
                break;
            case "a_prioriteetti":
                usort($askareet, function($a, $b) {
                    return $a->a_prioriteetti - $b->a_prioriteetti;
                });
                break;
            case "a_tehty":
                usort($askareet, function($a, $b) {
                    return strcmp($a->a_tehty, $b->a_tehty);
                });
                break;
            case "a_deadline":
                usort($askareet, function($a, $b) {
                    return strcmp($a->a_deadline, $b->a_deadline);
                });
                break;
            default:
                usort($askareet, function($a, $b) {
                    return strcmp($a->a_nimi, $b->a_nimi);
                });
                break;
        }
        View::make('askare/index.html', array('askareet' => $askareet));
    }

    public static function destroy($id) {

        $askare = new Askare(array('a_tunnus' => $id));
        $askare->destroy();
        Redirect::to('/tasks', array('message' => 'Askare poistettu!'));
    }

}
