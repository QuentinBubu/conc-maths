<?php
namespace App\Router;

$router = new Router($_GET['url']);

$router->get('/', 'Home#create');
$router->get('/logout', 'Home#logout');

$router->get('/login', 'Login#create');
$router->post('/login', 'Login#store');

$router->get('/signup', 'Signup#create');
$router->post('/signup', 'Signup#store');

$router->get('/challenges/delete/:id', 'Challenges#delete');
$router->get('/challenges/leadboard/:id', 'Challenges#leadboard');
$router->get('/challenges', 'Challenges#create');
$router->post('/challenges', 'Challenges#store');


$router->get('/participe/:id', 'Participe#create');
$router->post('/participe/:id', 'Participe#store');

$router->get('/admin', 'Admin#create');

$router->run();