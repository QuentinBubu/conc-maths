<?php
namespace App\Controller;

class Controller
{
    public static function home($method)
    {
        $method === 'store' ? Home::store() : Home::create();
    }

    public static function connexion($method)
    {
        $method === 'store' ? Connexion::store() : Connexion::create();
    }
}
