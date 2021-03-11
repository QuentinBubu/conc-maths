<?php
namespace App\Controller;

use App\User;
use App\Views\Base;

class Participe
{
    public static function create($challengeName)
    {
        if (!$_SESSION['authorize']['level1']) {
            Base::show('error', 403, 'Vous n\'êtes pas autorisé à rentrer sur cette page.');
        } else {
            $user = new User();
            if (
                array_key_exists(
                    $user->getRequest(
                        'SELECT `id`
                        FROM `users`
                        WHERE `username` = :username',
                        [
                            'username' => $_SESSION['username']
                        ],
                        'fetch'
                    )['id'],
                    json_decode(
                        $user->getRequest(
                            'SELECT `participant`
                            FROM `challenges`
                            WHERE `name` = :name',
                            [
                                'name' => $challengeName
                            ],
                            'fetch'
                        )['participant'],
                        true
                    )
                )
            ) {
                Base::show('error', 403, 'Vous avez déjà participé au challenge!');
            } else {
                Base::show('participe', null, $challengeName);
            }
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
}
