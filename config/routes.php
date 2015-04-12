<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

//Users-linkit

$routes->get('/user', function() {
    HelloWorldController::user();
});
$routes->post('/users/add', function() {
    KayttajaController::store();
});
$routes->get('/users', function() {
    KayttajaController::index();
});
$routes->get('/users/edit/:id', function($id) {
    KayttajaController::edit($id);
});
$routes->post('/users/edit/:id', function($id) {
    KayttajaController::update($id);
});

$routes->post('/users/destroy/:id', function($id) {
    KayttajaController::destroy($id);
});

//Rekisteröinti ja login
$routes->get('/rekisteroidy', function() {
    HelloWorldController::rekisteroidy();
});
$routes->get('/login', function() {
    HelloWorldController::login();
});

//Tasks-linkit
$routes->get('/tasks', function() {
    AskareController::index();
});

//Gategories-linkit
$routes->post('/gategories/save', function() {
    LuokkaController::store();
});

$routes->get('/gategories/add', function() {
    LuokkaController::add();
});

$routes->get('/gategories', function() {
    LuokkaController::index();
});

$routes->get('/gategories/edit/:id', function($id) {
    LuokkaController::show($id);
});


//Etusivu

$routes->get('/index', function() {
    HelloWorldController::index();
});



