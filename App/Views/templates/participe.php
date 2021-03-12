<?php
use App\User;

$user = new User();
$content = json_decode(
        $user->getRequest(
        'SELECT `content`
        FROM `challenges`
        WHERE `name` = :name
        AND `deleted` IS NULL',
        [
            'name' => $message
        ],
        'fetch'
    )['content'],
    true
);
$question = $content['question'];
?>

<form action="/participe/<?= $message ?>" method="post">
    <?php
        foreach ($question as $key => $value) {
            ?>
                <label for="<?= $key ?>"><?= $value ?></label>
                <input type="text" name="<?= $key ?>" id="<?= $key ?>" />
            <?php
        }
    ?>
    <button>Envoyer mes réponses</button>
</form>