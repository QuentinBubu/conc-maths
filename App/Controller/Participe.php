<?php
namespace App\Controller;

use App\User;
use App\Views\Base;

class Participe
{
    public static function create($challengeName)
    {
        if (!$_SESSION['authorize']['level2']) {
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

    public static function store($challengeName)
    {
        if (!$_SESSION['authorize']['level2']) {
            Base::show('error', 403, 'Vous n\'êtes pas autorisé à rentrer sur cette page.');
        } else {
            $user = new User();
            $content = json_decode(
                    $user->getRequest(
                    'SELECT `content`
                    FROM `challenges`
                    WHERE `name` = :name
                    AND `deleted` IS NULL',
                    [
                        'name' => $challengeName
                    ],
                    'fetch'
                )['content'],
                true
            );
            $question = $content['question'];
            $reply = $content['reply'];
            $result = [
                'true' => [],
                'false' => [],
                'result' => 0
            ];

            foreach ($_POST as $key => $value) {
                if (strtolower($value) === strtolower($reply[$key])) {
                    $result['result'] += 1;
                    array_push($result['true'], [$question[$key] => $reply[$key]]);
                } else {
                    array_push($result['false'], [$question[$key] => $reply[$key]]);
                }
            }

            $id = $user->getRequest(
               'SELECT `id`
                FROM `users`
                WHERE `username` = :username',
                [
                    'username' => $_SESSION['username']
                ],
                'fetch'
            )['id'];

            $user->getRequest(
                'UPDATE `challenges`
                SET `participant` = JSON_MERGE_PATCH(`participant`, :json)
                WHERE `name` = :name
                AND `deleted` IS NULL',
                [
                    'json' => json_encode([$id => $result['result']]),
                    'name' => $challengeName
                ]
            );
            Base::show('results', null, json_encode($result));
        }
    }
}
