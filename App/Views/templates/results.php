<div>
<table>
        <thead>
            <tr>Bonne(s) réponse(s)</tr>
            <tr>
                <td>Question</td>
                <td>Réponse</td>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach (json_decode($message, true)['true'] as $key => $value) {
                    ?>
                        <tr>
                            <td><?= key($value) ?></td>
                            <td><?= $value[key($value)] ?></td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>mauvaise(s) réponse(s)</tr>
            <tr>
                <td>Question</td>
                <td>Réponse</td>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach (json_decode($message, true)['false'] as $value) {
                    ?>
                        <tr>
                            <td><?= key($value) ?></td>
                            <td><?= $value[key($value)] ?></td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
    <p>Score final: <?= json_decode($message, true)['result'] ?></p>
    <a href="/challenges">Retour</a>
</div>