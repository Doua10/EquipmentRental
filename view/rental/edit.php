<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier une location</title>
    <link rel="stylesheet" href="view/backoffice.css">
</head>

<body>

<h1>Modifier une location</h1>

<?php if (isset($message)): ?>
    <p style="color:red;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<p>
    <strong>Client :</strong>
    <?= htmlspecialchars($rental["client_prenom"] . " " . $rental["client_nom"]) ?>
    <br>
    <strong>Équipement :</strong>
    <?= htmlspecialchars($rental["equipment_nom"]) ?>
    (<?= htmlspecialchars($rental["prix_jour"]) ?> DT/jour)
</p>

<form method="POST" action="index.php?action=rental_edit&id=<?= $rental["id"] ?>" id="rentalForm">

    <label>Date début :</label><br>
    <input
        type="date"
        name="date_debut"
        id="date_debut"
        value="<?= htmlspecialchars($rental["date_debut"]) ?>"
        required
    >
    <br><br>

    <label>Date fin :</label><br>
    <input
        type="date"
        name="date_fin"
        id="date_fin"
        value="<?= htmlspecialchars($rental["date_fin"]) ?>"
        required
    >
    <br><br>

    <label>Statut :</label><br>
    <select name="statut" required>
        <option value="en_attente" <?= $rental["statut"] == "en_attente" ? "selected" : "" ?>>En attente</option>
        <option value="confirmee" <?= $rental["statut"] == "confirmee" ? "selected" : "" ?>>Confirmée</option>
        <option value="en_cours" <?= $rental["statut"] == "en_cours" ? "selected" : "" ?>>En cours</option>
        <option value="terminee" <?= $rental["statut"] == "terminee" ? "selected" : "" ?>>Terminée (retour)</option>
        <option value="annulee" <?= $rental["statut"] == "annulee" ? "selected" : "" ?>>Annulée</option>
    </select>
    <br><br>

    <label>Frais additionnels (DT) :</label><br>
    <input
        type="number"
        name="frais_additionnels"
        step="0.01"
        min="0"
        value="<?= htmlspecialchars($rental["frais_additionnels"]) ?>"
    >
    <br><br>

    <label>Date de retour (si terminée) :</label><br>
    <input
        type="date"
        name="date_retour"
        value="<?= htmlspecialchars($rental["date_retour"] ?? "") ?>"
    >
    <br><br>

    <button type="submit">Enregistrer</button>

</form>

<br>

<a href="index.php?action=rental_list">
    Retour à la liste
</a>

<script>
const form = document.getElementById("rentalForm");

const dateDebut = document.getElementById("date_debut");
const dateFin = document.getElementById("date_fin");

const statut = document.querySelector('select[name="statut"]');

const frais = document.querySelector(
    'input[name="frais_additionnels"]'
);

const dateRetour = document.querySelector(
    'input[name="date_retour"]'
);

form.addEventListener("submit", function (e) {

    if (
        dateDebut.value === "" ||
        dateFin.value === ""
    ) {
        alert(
            "Veuillez saisir les dates de début et de fin."
        );

        e.preventDefault();
        return;
    }

    if (dateFin.value < dateDebut.value) {
        alert(
            "La date de fin doit être après ou égale à la date de début."
        );

        e.preventDefault();
        return;
    }

    const fraisValue = parseFloat(frais.value);

    if (
        frais.value !== "" &&
        (isNaN(fraisValue) || fraisValue < 0)
    ) {
        alert(
            "Les frais additionnels doivent être positifs ou égaux à 0."
        );

        e.preventDefault();
        return;
    }

    if (statut.value === "terminee") {

        if (dateRetour.value === "") {
            alert(
                "La date de retour est obligatoire pour une location terminée."
            );

            e.preventDefault();
            return;
        }

        if (dateRetour.value < dateDebut.value) {
            alert(
                "La date de retour ne peut pas être avant la date de début."
            );

            e.preventDefault();
            return;
        }
    }

});
</script>

</body>
</html>