<?php
namespace App\Router;

$router = new Router($_GET['url']);

$router->get('/', 'Home#create');
$router->get('/connexion', 'Connexion#create');

$router->run();