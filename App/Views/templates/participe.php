<?php
use App\Database;

$content = json_decode(
    Database::getRequest(
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
        foreach ($question as $key => $value):
            ?>
                <label for="<?= $key ?>"><?= $value ?></label>
                <input type="text" name="<?= $key ?>" id="<?= $key ?>" />
            <?php
        endforeach;
    ?>
    <button>Envoyer mes réponses</button>
</form>