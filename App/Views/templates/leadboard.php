<div>
    <table>
        <thead>
            <tr>
                <td>Identifiant</td>
                <td>Score</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $message = json_decode($message, true);
                uasort($message, function($a, $b) {if ($a === $b) {return 0;} return ($a > $b) ? -1 : 1;});
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