<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier une location</title>
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
// Contrôle de saisie en JS : la date de fin doit être après la date de début
const form = document.getElementById("rentalForm");
const dateDebut = document.getElementById("date_debut");
const dateFin = document.getElementById("date_fin");

form.addEventListener("submit", function (e) {
    if (dateFin.value < dateDebut.value) {
        alert("La date de fin doit être après la date de début.");
        e.preventDefault();
    }
});
</script>

</body>
</html>