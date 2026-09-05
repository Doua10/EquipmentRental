<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter une location</title>
    <link rel="stylesheet" href="view/backoffice.css">
</head>

<body>

<h1>Ajouter une location</h1>

<?php if (isset($message)): ?>
    <p style="color:red;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form method="POST" action="index.php?action=rental_add" id="rentalForm">

    <label>Client :</label><br>
    <select name="user_id" required>

        <option value="">-- Choisir un client --</option>

        <?php foreach ($clients as $client): ?>

            <option value="<?= $client["id"] ?>">
                <?= htmlspecialchars($client["prenom"] . " " . $client["nom"] . " (" . $client["role"] . ")") ?>
            </option>

        <?php endforeach; ?>

    </select>
    <br><br>

    <label>Équipement :</label><br>
    <select name="equipment_id" id="equipment_id" required>

        <option value="">-- Choisir un équipement --</option>

        <?php foreach ($equipments as $equipment): ?>

            <option
                value="<?= $equipment["id"] ?>"
                data-prix="<?= htmlspecialchars($equipment["prix_jour"]) ?>"
                data-etat="<?= htmlspecialchars($equipment["etat"]) ?>"
            >
                <?= htmlspecialchars($equipment["nom"]) ?>
                (<?= htmlspecialchars($equipment["prix_jour"]) ?> DT/j — <?= htmlspecialchars($equipment["etat"]) ?>)
            </option>

        <?php endforeach; ?>

    </select>
    <br><br>

    <label>Date début :</label><br>
    <input type="date" name="date_debut" id="date_debut" required>
    <br><br>

    <label>Date fin :</label><br>
    <input type="date" name="date_fin" id="date_fin" required>
    <br><br>

    <p id="estimation" style="font-weight:bold;"></p>

    <button type="submit">Ajouter</button>

</form>

<br>

<a href="index.php?action=rental_list">
    Retour à la liste
</a>

<script>
// Contrôle de saisie en JS : dates cohérentes + estimation du prix
const form = document.getElementById("rentalForm");
const dateDebut = document.getElementById("date_debut");
const dateFin = document.getElementById("date_fin");
const equipmentSelect = document.getElementById("equipment_id");
const estimation = document.getElementById("estimation");

function updateEstimation() {
    const debut = new Date(dateDebut.value);
    const fin = new Date(dateFin.value);
    const option = equipmentSelect.options[equipmentSelect.selectedIndex];
    const prix = option ? parseFloat(option.getAttribute("data-prix")) : null;

    if (dateDebut.value && dateFin.value && prix && fin >= debut) {
        const duree = Math.round((fin - debut) / (1000 * 60 * 60 * 24)) + 1;
        const total = (duree * prix).toFixed(2);
        estimation.textContent = "Durée estimée : " + duree + " jour(s) — Prix estimé : " + total + " DT";
    } else {
        estimation.textContent = "";
    }
}

dateDebut.addEventListener("change", updateEstimation);
dateFin.addEventListener("change", updateEstimation);
equipmentSelect.addEventListener("change", updateEstimation);

form.addEventListener("submit", function (e) {
    const option = equipmentSelect.options[equipmentSelect.selectedIndex];

    if (option && option.getAttribute("data-etat") !== "disponible") {
        alert("Cet équipement n'est pas disponible actuellement.");
        e.preventDefault();
        return;
    }

    if (dateFin.value < dateDebut.value) {
        alert("La date de fin doit être après la date de début.");
        e.preventDefault();
    }
});
</script>

</body>
</html>