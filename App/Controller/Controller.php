<?php
namespace App\Controller;

class Controller
{
    public static function home($method)
    {
        $method === 'store' ? Home::store() : Home::create();
    }

    public static function login($method)
    {
        $method === 'store' ? Login::store() : Login::create();
    }
}
