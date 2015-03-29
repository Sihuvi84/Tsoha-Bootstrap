<?php


class HelloWorldController extends BaseController {

    public static function sandbox() {
        // Testaa koodiasi täällä
        View::make('helloworld.html');

        $kayttaja = Kayttaja::find(1);
        $kayttajat = Kayttaja::all();
        // Kint-luokan dump-metodi tulostaa muuttujan arvon
        Kint::dump($kayttajat);
        Kint::dump($kayttaja);
    }

    public static function index() {
        View::make('index.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function user() {
        View::make('suunnitelmat/user.html');
    }
    

    public static function rekisteroidy() {
        View::make('rekisteroityminen.html');
    }

}
