<?php
namespace App\Router;

$router = new Router($_GET['url']);

$router->get('/', 'Home#create');

$router->get('/login', 'Login#create');
$router->post('/login', 'Login#store');

$router->run();