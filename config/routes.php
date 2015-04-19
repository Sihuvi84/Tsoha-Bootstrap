<?php

function check_logged_in() {
    BaseController::check_logged_in();
}

//Users-linkit

$routes->post('/users/add', function() {
    KayttajaController::store();
});
$routes->get('/users', 'check_logged_in', function() {
    KayttajaController::index();
});
$routes->get('/users/edit/:id', 'check_logged_in', function($id) {
    KayttajaController::edit($id);
});
$routes->post('/users/edit/:id', 'check_logged_in', function($id) {
    KayttajaController::update($id);
});

$routes->post('/users/destroy/:id', 'check_logged_in', function($id) {
    KayttajaController::destroy($id);
});

//Rekisteröinti ja login
$routes->get('/rekisteroidy', function() {
    HelloWorldController::rekisteroidy();
});

$routes->get('/login', function() {
    KayttajaController::login();
});
$routes->post('/login', function() {
    KayttajaController::handle_login();
});
$routes->post('/logout', 'check_logged_in', function() {
    KayttajaController::logout();
});

//Tasks-linkit
$routes->get('/tasks', 'check_logged_in', function() {
    AskareController::index();
});

$routes->post('/tasks/save', 'check_logged_in', function() {
    AskareController::store();
});

$routes->get('/tasks/add', 'check_logged_in', function() {
    AskareController::add();
});

$routes->get('/tasks/edit/:id', 'check_logged_in', function($id) {
    AskareController::show($id);
});

$routes->get('/tasks/:id', 'check_logged_in', function($id) {
    AskareController::show($id);
});

//Gategories-linkit
$routes->post('/gategories/save', 'check_logged_in', function() {
    LuokkaController::store();
});

$routes->get('/gategories/add', 'check_logged_in', function() {
    LuokkaController::add();
});

$routes->get('/gategories', 'check_logged_in', function() {
    LuokkaController::index();
});

$routes->get('/gategories/edit/:id', 'check_logged_in', function($id) {
    LuokkaController::edit($id);
});

$routes->post('/gategories/edit/:id', 'check_logged_in', function($id) {
    LuokkaController::update($id);
});

$routes->get('/gategories/:id', 'check_logged_in', function($id) {
    LuokkaController::show($id);
});

$routes->post('/gategories/destroy/:id', 'check_logged_in', function($id) {
    LuokkaController::destroy($id);
});



//Etusivu

$routes->get('/index', function() {
    BaseController::index();
});

$routes->get('/', function() {
    BaseController::index();
});
