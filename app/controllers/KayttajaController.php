<?php

class KayttajaController extends BaseController {

    public static function index() {

        $kayttajat = Kayttaja::all();
        View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE k_tunnus = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $user = new Kayttaja(array(
                'k_tunnus' => $row['k_tunnus'],
                'k_salasana' => $row['k_salasana'],
                'k_nimi' => $row['k_nimi'],
                'kr_tunnus' => $row['kr_tunnus']
            ));

            return $user;
        }
        return null;
    }

    public static function nameExists($name) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE k_nimi = :name');
        $query->execute(array('name' => $name));
        return ($query->rowCount() > 0);
    }

    public static function store() {
        $params = $_POST;

        $user = new Kayttaja(array(
            'k_nimi' => $params['nimi'],
            'kr_tunnus' => $params['kr_tunnus'],
            'k_salasana' => $params['salasana']
        ));

        if ($user->validate($params)) {
            if (KayttajaController::nameExists($params['nimi'])) {
                View::make('/rekisteroityminen.html', array('errors' => $user->errors(), 'attributes' => $params, 'onOlemassa' => "Tunnus on jo käytössä"));
            } else {
                $user->save();
                Redirect::to('/', array('message' => 'Tervetuloa käyttämään Arkimuistia ' . $user->k_nimi));
            }
        } else {
            View::make('/rekisteroityminen.html', array('errors' => $user->errors(), 'attributes' => $params));
        }
    }

    public static function edit($id) {
        $user = Kayttaja::find($id);
        View::make('kayttaja/edit.html', array('kayttaja' => $user));
    }

    public static function update($id) {
        $params = $_POST;
        $user1 = Kayttaja::find($id);

        $attributes = array(
            'k_tunnus' => $id,
            'k_nimi' => $params['nimi'], //Argh, tyhmästi tehty, mutta jotain tökkii ja nyt purkkaratkaisu!
            'k_salasana' => $params['salasana'],
            'kr_tunnus' => $user1->kr_tunnus
        );

        $user = new Kayttaja($attributes);

        if ($params['salasana'] != $params['uusi2']) {
            View::make('kayttaja/edit.html', array('kayttaja' => $user, 'attributes' => $params, 'salasanat' => "Salasanat eivät täsmää!"));
        }
        if ($params['entisalasana'] != $user1->k_salasana) {
            View::make('kayttaja/edit.html', array('kayttaja' => $user, 'attributes' => $params, 'vanha' => "Vanha salasana ei ole oikein!"));
        } 
        
        if ($user->validate($params)) {
            $user->update($id);
            Redirect::to('/users/edit/' . $user->id, array('message' => 'Päivitys onnistui!'));
        } else {
            View::make('kayttaja/edit.html', array('errors' => $user->errors(), 'attributes' => $params, 'kayttaja' => $user));
        }
    }

    public static function destroy($id) {

        $user = new Kayttaja(array('id' => $id));
        $user->destroy($id);

        Redirect::to('/users', array('message' => 'Käyttäjä on poistettu onnistuneesti!'));
    }

}
