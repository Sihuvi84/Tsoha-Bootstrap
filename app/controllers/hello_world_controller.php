<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        // View::make('home.html');
        //
         echo 'Tämä on etusivu!';
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        View::make('helloworld.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function tasks() {
        View::make('suunnitelmat/tasks.html');
    }

    public static function user() {
        View::make('suunnitelmat/user.html');
    }

    public static function users() {
        View::make('suunnitelmat/users.html');
    }

    public static function gategories() {
        View::make('suunnitelmat/gategories.html');
    }

}
