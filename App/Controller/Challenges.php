<?php
namespace App\Controller;

use App\Views\Base;

class Challenges
{
    public static function create()
    {
        if (!$_SESSION['authorize']['level2']) {
            Base::show('error', 403, 'Vous n\'êtes pas autorisé à rentrer sur cette page.');
        } else {
            Base::show('challenges');
        }
    }

    public static function store()
    {
        if (!$_SESSION['authorize']['level1']) {
            Base::show('error', 403, 'Vous n\'êtes pas autorisé à rentrer sur cette page.');
        }
    }
}
