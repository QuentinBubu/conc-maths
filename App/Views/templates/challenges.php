<?php
use App\Database;

$challenges = Database::getRequest(
    'SELECT *
    FROM `challenges`
    WHERE `expiration` > NOW()
    AND `deleted` IS NULL',
    [],
    'fetchAll'
);

$userId = Database::getRequest(
    'SELECT `id`
    FROM `users`
    WHERE `username` = :username',
    [
        'username' => $_SESSION['username']
    ],
    'fetch'
)['id'];

$challengesParticipe = [];
foreach ($challenges as $value) {
    $valueDecode = json_decode($value['participant'], true);
    if (array_key_exists($userId, $valueDecode)) {
        $challengesParticipe['yes'][] = $value['name'];
    } else {
        $challengesParticipe['no'][] = $value['name'];
    }
}

?>
<h1>Bonjour <?= $_SESSION['username'] ?>,</h1>
<h3>Voici la liste des challenges auxquelles vous n'avez pas participés:</h3>

<?php
    if (!empty($challengesParticipe['no'])) {
        foreach ($challengesParticipe['no'] as $value):
            ?>
            <a href="/participe/<?= htmlspecialchars($value) ?>">Participer au challenge <?= htmlspecialchars($value) ?></a>
            <?php
        endforeach;
    } else {
        echo 'Aucun challenge disponible! Revenez plus tard!';
    }
?>

<h3>Voici la liste des challenges auxquelles vous avez participés:</h3>

<?php
    if (!empty($challengesParticipe['yes'])) {
        foreach ($challengesParticipe['yes'] as $value) {
            echo htmlspecialchars($value);
        }
    } else {
        echo 'Vous n\'avez participé à aucun challenge!';
    }
?>
<a href="/logout">Se déconnecter</a>