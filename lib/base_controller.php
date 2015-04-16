<?php

class BaseController {

    public static function get_user_logged_in() {
        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user'];
            $user = Kayttaja::find($user_id);

            return $user;
        }
        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/login', array('error' => 'Nähdäksesi sisällön kirjaudu sisään!'));
        }
    }

    public static function index() {
        View::make('index.html');
    }

    public static function rekisteroidy() {
        View::make('rekisteroityminen.html');
    }

}
