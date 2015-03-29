<?php

/**
 * Description of LuokkaController
 *
 * @author suvialat
 */
class LuokkaController extends BaseController {

    public static function index() {

        $luokat = Luokka::all();
        View::make('luokka/index.html', array('luokat' => $luokat));
    }

    public static function show($id) {
        $luokka = Luokka::find($id);
        View::make('luokka/edit.html', array('luokka' => $luokka));
    }

    public static function add() {
        View::make('luokka/add.html');
    }

    public function store() {
        $params = $_POST;

        $luokka = new Luokka(array(
            'l_nimi' => $params['l_nimi'],
            'l_kuvaus' => $params['l_kuvaus']
                )
        );

        $luokka->save();

        Redirect::to('/gategories', array('message' => 'Luokka lisätty'));
    }

}
