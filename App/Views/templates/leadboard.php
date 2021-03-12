<?php
use App\User;

$message = json_decode($message, true);
uasort($message, function($a, $b) {if ($a === $b) {return 0;} return ($a > $b) ? -1 : 1;});

$user = new User();
$usersId = "'". implode("','", array_keys($message)) . "'";
$users = $user->getRequest(
    "SELECT `username`, `id`
    FROM `users`
    WHERE `id`
    IN ($usersId)",
    [],
    'fetchAll'
);
// $usersId has generated by db, is an number, no risk of sql injection

foreach ($users as $value) {
    $message[$value['username']] = $message[$value['id']];
    unset($message[$value['id']]);
}
?>
<div>
    <table>
        <thead>
            <tr>
                <td>Nom d'utilisateur</td>
                <td>Score</td>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($message as $key => $value) {
                    ?>
                        <tr>
                            <td><?= $key ?></td>
                            <td><?= $value ?></td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
    <a href="/challenges">Retour</a>
</div>