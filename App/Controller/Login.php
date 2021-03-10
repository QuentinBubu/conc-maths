<?php
namespace App\Controller;

use App\User;
use App\Views\Base;

class Login
{
    public static function create()
    {
        if (!$_SESSION['authorize']['level1']) {
            Base::show('error', 403, 'Vous n\'êtes pas autorisé à rentrer sur cette page.');
        } else {
            Base::show('login');
        }
    }

    public static function store()
    {
        if (!$_SESSION['authorize']['level1']) {
            Base::show('error', 403, 'Vous n\'êtes pas autorisé à rentrer sur cette page.');
        } else {
            $user = new User();
            $return = $user->getConnexion($_POST['username'], $_POST['password']);
            if ($return === true) {
                $_SESSION['authorize']['level2'] = true;
                $_SESSION['username'] = $_POST['username'];
                header('Location: /challenges');
                exit;
            } else {
                Base::show('error', 457, $return);
            }
        }
    }
}
