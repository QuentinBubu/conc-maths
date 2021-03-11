<?php
use App\User;

$user = new User();
$challenges = $user->getRequest(
    'SELECT `name`
    FROM `challenges`
    WHERE `deleted` IS NULL',
    [],
    'fetchAll'
);
?>
<div>
    <h2>Créer un challenge</h2>
    <section>
        <form action="/challenges" method="POST" autocomplete="off">
            <label for="name">Nom:</label>
            <input type="text" name="name" id="name" placeholder="Le nom" />
            <label for="date">Date de fin:</label>
            <input type="date" name="date" id="date" />

            <h3>Ajouter une question</h3>
            <section>
                <label for="question">Question:</label>
                <input type="text" name="question[]" id="question" placeholder="Votre question" />
                <label for="reply">Réponse:</label>
                <input type="text" name="reply[]" id="reply" placeholder="La réponse" />

                <button type="button" id="more">Ajouter un champ</button>
                <button type="button" id="less">Retirer le dernier champs</button>
            </section>
            <button>Enregistrer</button>
        </form>
    </section>
    <h2>Challenges:</h2>
    <section>
        <?php
            foreach ($challenges as $value) {
                ?>
                <a
                    href="/challenges/delete/<?= htmlspecialchars($value['name']) ?>"
                >Supprimer <?= htmlspecialchars($value['name']) ?></a>
                 ou 
                <a
                    href="/challenges/leadboard/<?= htmlspecialchars($value['name']) ?>"
                >voir la leadboard de <?= htmlspecialchars($value['name']) ?></a>
                <?php
            }
        ?>
    </section>
    <a href="/logout">Se déconnecter</a>
</div>

<style>
    form > section {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }
</style>

<script defer>
    let numberCase = 2;
    document.querySelector("#more").addEventListener("click", function () {
        const fields = ['question', 'reply'];
        for (let i = 0; i < 2; i++) {
            let newLabel = document.createElement('label');
            if (fields[i] === 'question') {
                newLabel.textContent = 'Question:';
            } else {
                newLabel.textContent = 'Réponse:';
            }
            newLabel.setAttribute("for", `${fields[i]}${numberCase}`);
            newLabel.setAttribute("class", `inputClass${numberCase}`);
            document.querySelector("#more").before(newLabel);

            let newInput = document.createElement('input');
            newInput.setAttribute("type", "text");
            newInput.setAttribute("id", `${fields[i]}${numberCase}`);
            newInput.setAttribute("class", `inputClass${numberCase}`);
            newInput.setAttribute("name", `${fields[i]}[]`);
            document.querySelector("#more").before(newInput);

        }
        numberCase += 1;
    });

    document.querySelector("#less").addEventListener("click", function () {
        if (numberCase > 2) {
            numberCase -= 1;
            document.querySelectorAll(`.inputClass${numberCase}`).forEach((element) => {
                element.remove();
            });
        }
    });
</script>