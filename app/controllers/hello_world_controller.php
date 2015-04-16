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
}
