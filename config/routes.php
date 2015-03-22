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


$routes->get('/tasks', function() {
    HelloWorldController::tasks();
});

$routes->get('/gategories', function() {
    HelloWorldController::gategories();
});

$routes->get('/users', function() {
    HelloWorldController::users();
});


