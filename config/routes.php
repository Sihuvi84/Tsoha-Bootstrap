<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});


$routes->get('/user', function() {
    HelloWorldController::user();
});

$routes->get('/gategories/edit/:id', function($id) {
    LuokkaController::show($id);
});

/*$routes->post('/gategories/edit/:id', function($id) {
    LuokkaController::edit($id);
});*/


$routes->get('/gategories', function() {
    LuokkaController::index();
});

$routes->get('/users', function() {
    KayttajaController::index();
});

$routes->get('/tasks', function() {
    AskareController::index();
});

$routes->post('/users', function() {
    KayttajaController::store();
});

$routes->post('/gategories/save', function() {
    LuokkaController::store();
});

$routes->get('/gategories/add', function() {
    LuokkaController::add();
});

$routes->get('/index', function() {
    HelloWorldController::index();
});

$routes->get('/rekisteroidy', function() {
    HelloWorldController::rekisteroidy();
});


