<?php
namespace App\Controller;

use App\User;
use App\Views\Base;

class Challenges
{
    public static function create()
    {
        if ($_SESSION['authorize']['level3']) {
            header('Location: /admin');
            exit;
        } elseif (!$_SESSION['authorize']['level2']) {
            Base::show('error', 403, 'Vous n\'êtes pas autorisé à rentrer sur cette page.');
        } else {
            Base::show('challenges');
        }
    }

    public static function store()
    {
        if (!$_SESSION['authorize']['level3']) {
            Base::show('error', 403, 'Vous n\'êtes pas autorisé à rentrer sur cette page.');
        } else {
            foreach ($_POST as $arrays) {
                if (is_array($arrays)) {
                    foreach ($arrays as $value) {
                        if (empty($value)) {
                            Base::show('error', 458, 'Veuillez saisir tout les champs!');
                        }
                    }
                } else {
                    if (empty($arrays)) {
                        Base::show('error', 458, 'Veuillez saisir tout les champs!');
                    }
                }
            }
            $user = new User();
            $user->getRequest(
                'INSERT INTO `challenges`
                VALUES (
                    NULL, :name, :content, "{}", :expiration, NULL
                )',
                [
                    'name' => $_POST['name'],
                    'content' => json_encode($_POST),
                    'expiration' => $_POST['date']
                ]
            );
            header('Location: /admin');
            exit;
        }
    }

    public function leadboard(string $name)
    {
        if (!$_SESSION['authorize']['level3']) {
            Base::show('error', 403, 'Vous n\'êtes pas autorisé à rentrer sur cette page.');
        } else {
            $user = new User();
            $leadboard = $user->getRequest(
                'SELECT `participant`
            FROM `challenges`
            WHERE `name` = :name',
                [
                'name' => $name
            ],
                'fetch'
            )['participant'];
            Base::show('leadboard', null, $leadboard);
        }
    }

    public function delete(string $name)
    {
        if (!$_SESSION['authorize']['level3']) {
            Base::show('error', 403, 'Vous n\'êtes pas autorisé à rentrer sur cette page.');
        } else {
            $user = new User();
            $user->getRequest(
                'UPDATE `challenges`
                SET `deleted` = 1
                WHERE `name` = :name',
                [
                    'name' => $name
                ]
            );
            header('Location: /admin');
            exit;
        }
    }
}
