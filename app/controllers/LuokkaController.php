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
        View::make('luokka/luokka.html', array('luokka' => $luokka));
    }

    public static function add() {
        View::make('luokka/add.html');
    }

    public function store() {
        $params = $_POST;

        $luokka = new Luokka(array(
            'l_nimi' => $params['nimi'],
            'l_kuvaus' => $params['kuvaus'],
            'lk_tunnus' => BaseController::get_user_logged_in()->k_tunnus
                )
        );

        if ($luokka->validate($params)) {
            $luokka->save();
            Redirect::to('/gategories', array('message' => 'Luokka lisätty'));
        } else {
            View::make('luokka/add.html', array('errors' => $luokka->errors(), 'luokka' => $luokka));
        }
    }

    public static function edit($id) {
        $luokka = Luokka::find($id);
        View::make('luokka/edit.html', array('luokka' => $luokka));
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'l_tunnus' => $id,
            'l_nimi' => $params['nimi'],
            'l_kuvaus' => $params['kuvaus']         
        );

        $luokka = new Luokka($attributes);

        if ($luokka->validate($params)) {
            $luokka->update($id);
            Redirect::to('/gategories', array('message' => 'Päivitys onnistui!'));
        } else {
            View::make('luokka/edit.html', array('errors' => $luokka->errors(), 'luokka' => $luokka));
        }
    }
    
    public static function destroy($id) {

        $luokka = new Luokka(array('id' => $id));
        $luokka->destroy($id);
       
        Redirect::to('/gategories', array('message' => 'Luokka on poistettu onnistuneesti!'));
    }
}
