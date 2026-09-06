<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier un équipement</title>
    <link rel="stylesheet" href="view/backoffice.css">
</head>

<body>

<h1>Modifier un équipement</h1>

<div class="top-actions">

    <a href="index.php?action=dashboard">
        🏠 Tableau de bord
    </a>

    <a href="index.php?action=equipment_list">
        ← Retour à la liste
    </a>

</div>

<?php if (isset($message)): ?>
    <p style="color:red;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form
    method="POST"
    action="index.php?action=equipment_edit&id=<?= $equipment["id"] ?>"
    id="equipmentForm"
>

    <label>Nom :</label><br>

    <input
        type="text"
        name="nom"
        id="nom"
        value="<?= htmlspecialchars($equipment["nom"]) ?>"
        required
    >

    <br><br>

    <label>Description :</label><br>

    <textarea
        name="description"
        id="description"
    ><?= htmlspecialchars($equipment["description"]) ?></textarea>

    <br><br>

    <label>Prix par jour :</label><br>

    <input
        type="number"
        name="prix_jour"
        id="prix_jour"
        step="0.01"
        min="0.01"
        value="<?= $equipment["prix_jour"] ?>"
        required
    >

    <br><br>

    <label>Stock :</label><br>

    <input
        type="number"
        name="stock"
        id="stock"
        min="0"
        value="<?= $equipment["stock"] ?>"
        required
    >

    <br><br>

    <label>Seuil d'alerte :</label><br>

    <input
        type="number"
        name="seuil_alerte"
        id="seuil_alerte"
        min="0"
        value="<?= $equipment["seuil_alerte"] ?>"
        required
    >

    <br><br>

    <label>État :</label><br>

    <select
        name="etat"
        id="etat"
        required
    >

        <option
            value="disponible"
            <?= $equipment["etat"] == "disponible" ? "selected" : "" ?>
        >
            Disponible
        </option>

        <option
            value="en_location"
            <?= $equipment["etat"] == "en_location" ? "selected" : "" ?>
        >
            En location
        </option>

        <option
            value="maintenance"
            <?= $equipment["etat"] == "maintenance" ? "selected" : "" ?>
        >
            Maintenance
        </option>

        <option
            value="endommage"
            <?= $equipment["etat"] == "endommage" ? "selected" : "" ?>
        >
            Endommagé
        </option>

    </select>

    <br><br>

    <label>Catégorie :</label><br>

    <select
        name="categorie_id"
        id="categorie_id"
        required
    >

        <?php foreach ($categories as $category): ?>

            <option
                value="<?= $category["id"] ?>"
                <?= $equipment["categorie_id"] == $category["id"] ? "selected" : "" ?>
            >
                <?= htmlspecialchars($category["nom"]) ?>
            </option>

        <?php endforeach; ?>

    </select>

    <br><br>

    <button type="submit">
        Modifier
    </button>

</form>

<br>

<script>
const form = document.getElementById("equipmentForm");

form.addEventListener("submit", function (e) {

    const nom = document.getElementById("nom").value.trim();

    const prix = parseFloat(
        document.getElementById("prix_jour").value
    );

    const stock = parseInt(
        document.getElementById("stock").value
    );

    const seuil = parseInt(
        document.getElementById("seuil_alerte").value
    );

    const etat =
        document.getElementById("etat").value;

    const categorie =
        document.getElementById("categorie_id").value;

    if (nom === "") {
        alert("Le nom de l'équipement est obligatoire.");
        e.preventDefault();
        return;
    }

    if (nom.length < 2) {
        alert(
            "Le nom doit contenir au moins 2 caractères."
        );
        e.preventDefault();
        return;
    }

    if (isNaN(prix) || prix <= 0) {
        alert(
            "Le prix par jour doit être supérieur à 0."
        );
        e.preventDefault();
        return;
    }

    if (isNaN(stock) || stock < 0) {
        alert(
            "Le stock doit être positif ou égal à 0."
        );
        e.preventDefault();
        return;
    }

    if (!Number.isInteger(stock)) {
        alert(
            "Le stock doit être un nombre entier."
        );
        e.preventDefault();
        return;
    }

    if (isNaN(seuil) || seuil < 0) {
        alert(
            "Le seuil d'alerte doit être positif ou égal à 0."
        );
        e.preventDefault();
        return;
    }

    if (!Number.isInteger(seuil)) {
        alert(
            "Le seuil d'alerte doit être un nombre entier."
        );
        e.preventDefault();
        return;
    }

    if (etat === "") {
        alert(
            "Veuillez choisir l'état de l'équipement."
        );
        e.preventDefault();
        return;
    }

    if (categorie === "") {
        alert(
            "Veuillez choisir une catégorie."
        );
        e.preventDefault();
        return;
    }

});
</script>

</body>
</html>