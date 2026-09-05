<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Traiter le retour</title>
    <link rel="stylesheet" href="view/backoffice.css">
</head>

<body>

<h1>Traiter le retour d'une location</h1>

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
    <br>
    <strong>Période louée :</strong>
    du <?= htmlspecialchars($rental["date_debut"]) ?> au <?= htmlspecialchars($rental["date_fin"]) ?>
    (<?= $rental["duree"] ?> jour(s))
    <br>
    <strong>Prix initial :</strong>
    <?= htmlspecialchars($rental["duree"] * $rental["prix_jour"]) ?> DT
</p>

<form method="POST" action="index.php?action=rental_return&id=<?= $rental["id"] ?>" id="returnForm">

    <label>Date de retour :</label><br>
    <input
        type="date"
        name="date_retour"
        id="date_retour"
        value="<?= date("Y-m-d") ?>"
        required
    >
    <br><br>

    <label>État de l'équipement au retour (contrôle Responsable Inventaire) :</label><br>
    <select name="etat_retour" required>
        <option value="">-- Choisir --</option>
        <option value="disponible">Bon état — remis en disponible</option>
        <option value="maintenance">À réviser — mis en maintenance</option>
        <option value="endommage">Endommagé</option>
    </select>
    <br><br>

    <label>Frais additionnels (DT) — retard, dommage, nettoyage... :</label><br>
    <input
        type="number"
        name="frais_additionnels"
        id="frais_additionnels"
        step="0.01"
        min="0"
        value="0"
    >
    <br><br>

    <p id="totalEstime" style="font-weight:bold;"></p>

    <button type="submit">Valider le retour</button>

</form>

<br>

<a href="index.php?action=rental_list">
    Retour à la liste
</a>

<script>
// Contrôle de saisie en JS : date de retour cohérente + estimation du total
const form = document.getElementById("returnForm");
const dateRetour = document.getElementById("date_retour");
const frais = document.getElementById("frais_additionnels");
const totalEstime = document.getElementById("totalEstime");

const prixInitial = <?= (float) ($rental["duree"] * $rental["prix_jour"]) ?>;
const dateDebutMin = "<?= htmlspecialchars($rental["date_debut"]) ?>";

function updateTotal() {
    const f = parseFloat(frais.value) || 0;
    totalEstime.textContent = "Total à facturer : " + (prixInitial + f).toFixed(2) + " DT";
}

frais.addEventListener("input", updateTotal);
updateTotal();

form.addEventListener("submit", function (e) {
    if (dateRetour.value < dateDebutMin) {
        alert("La date de retour ne peut pas être avant la date de début de location.");
        e.preventDefault();
    }
});
</script>

</body>
</html>