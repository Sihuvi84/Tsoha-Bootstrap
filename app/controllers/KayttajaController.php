<?php

class KayttajaController extends BaseController {

    public static function index() {
        
        $kayttajat = Kayttaja::all();
        View::make('kayttaja/index.html', array('kayttajat' => $kayttajat));
    }

    public static function find($id) {
        
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja '
                . 'WHERE k_tunnus = :id LIMIT 1');
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

    public static function store() {
        
        $params = $_POST;

        $user = new Kayttaja(array(
            'k_nimi' => $params['nimi'],
            'kr_tunnus' => $params['kr_tunnus'],
            'k_salasana' => crypt($params['salasana'], self::getSalt())
        ));

        if ($user->validate($params)) {
            if (self::nameExists($params['nimi'])) {
                View::make('/rekisteroityminen.html', array('errors' => $user->errors(), 
                    'attributes' => $params, 'onOlemassa' => "Tunnus on jo käytössä"));
            } else {
                $user->save();
                Redirect::to('/', array('message' => 'Tervetuloa käyttämään Arkimuistia ' . 
                    $user->k_nimi));
            }
        } else {
            View::make('/rekisteroityminen.html', array('errors' => $user->errors(), 
                'attributes' => $params));
        }
    }

    public static function edit($id) {
        
        $user = Kayttaja::find($id);
        View::make('kayttaja/edit.html', array('kayttaja' => $user));
    }

    public static function resetPass($id) {
        
        $params = $_POST;
        $user = Kayttaja::find($id);

        $attributes = array(
            'k_tunnus' => $id,
            'k_nimi' => $user->k_nimi,
            'k_salasana' => crypt($params['salasana'], self::getSalt()),
            'kr_tunnus' => $user->kr_tunnus
        );

        $user = new Kayttaja($attributes);

        if ($params['salasana'] != $params['uusi2']) {
            View::make('kayttaja/resetPass.html', array('kayttaja' => $user, 
                'attributes' => $params, 'salasanat' => "Salasanat eivät täsmää!"));
        }

        if ($user->validate($params)) {
            $user->update($id);
            Redirect::to('/users/resetPass/' . $user->k_tunnus, 
                    array('message' => 'Päivitys onnistui!'));
        } else {
            View::make('kayttaja/resetPass.html', 
                    array('errors' => $user->errors(), 'attributes' => $params, 'kayttaja' => $user));
        }
    }

    public static function showResetPass($id) {
        
        $user = Kayttaja::find($id);
        View::make('kayttaja/resetPass.html', array('kayttaja' => $user));
    }

    public static function update($id) {
        
        $params = $_POST;
        $user1 = Kayttaja::find($id);

        $attributes = array(
            'k_tunnus' => $id,
            'k_nimi' => $params['nimi'], //Valitron!!! Miten korjataan?
            'k_salasana' => crypt($params['salasana'], self::getSalt()),
            'kr_tunnus' => $user1->kr_tunnus
        );

        $user = new Kayttaja($attributes);

        if ($params['salasana'] != $params['uusi2']) {
            View::make('kayttaja/edit.html', array('kayttaja' => $user, 'attributes' => $params, 
                'salasanat' => "Salasanat eivät täsmää!"));
        }

        if (crypt($params['entisalasana'], self::getSalt()) != $user1->k_salasana) {
            View::make('kayttaja/edit.html', array('kayttaja' => $user, 'attributes' => $params, 
                'vanha' => "Vanha salasana ei ole oikein!"));
        }

        if ($user->validate($params)) {
            $user->update($id);
            Redirect::to('/users/edit/' . $user->k_tunnus, array('message' => 'Päivitys onnistui!'));
        } else {
            View::make('kayttaja/edit.html', array('errors' => $user->errors(), 
                'attributes' => $params, 'kayttaja' => $user));
        }
    }

    public static function destroy($id) {
        
        $user = new Kayttaja(array('id' => $id));
        $user->destroy($id);
        Redirect::to('/users', array('message' => 'Käyttäjä on poistettu!'));
    }

    public static function deactivate($id) {
        
        $user = new Kayttaja(array('id' => $id));
        $user->destroy($id);
        self::logout();
        Redirect::to('/');
    }

    public static function login() {
        View::make('kayttaja/login.html');
    }

    public static function handle_login() {
        
        $params = $_POST;
        $pass = crypt($params['password'], self::getSalt());
        $user = Kayttaja::authenticate($params['username'], $pass);

        if (!$user) {
            View::make('kayttaja/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 
                'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->k_tunnus;
            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->k_nimi . '!'));
        }
    }

    public static function logout() {
        
        $_SESSION['user'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

    private static function getSalt() {
        //Oh noes, kaikkea sitä sortuukin tekemään :P
        return "!1%2wåg7#4t6etkpoegk9=(Y%#()Hp9wHGWE)H()#y%qw#()%()w#%H#()W%H";
    }

    private static function nameExists($name) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja '
                . 'WHERE k_nimi = :name');
        $query->execute(array('name' => $name));
        return ($query->rowCount() > 0);
    }

}
