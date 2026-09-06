<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un équipement</title>
    <link rel="stylesheet" href="view/backoffice.css">
</head>

<body>

<h1>Ajouter un équipement</h1>

<?php if (isset($message)): ?>
    <p style="color:red;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form
    method="POST"
    action="index.php?action=equipment_add"
    id="equipmentForm"
>

    <label>Nom :</label><br>
    <input
        type="text"
        name="nom"
        id="nom"
        required
    >
    <br><br>

    <label>Description :</label><br>
    <textarea
        name="description"
        id="description"
    ></textarea>
    <br><br>

    <label>Prix par jour :</label><br>
    <input
        type="number"
        name="prix_jour"
        id="prix_jour"
        step="0.01"
        min="0.01"
        required
    >
    <br><br>

    <label>Stock :</label><br>
    <input
        type="number"
        name="stock"
        id="stock"
        min="0"
        required
    >
    <br><br>

    <label>Seuil d'alerte :</label><br>
    <input
        type="number"
        name="seuil_alerte"
        id="seuil_alerte"
        min="0"
        required
    >
    <br><br>

    <label>État :</label><br>
    <select
        name="etat"
        id="etat"
        required
    >
        <option value="">-- Choisir --</option>
        <option value="disponible">Disponible</option>
        <option value="en_location">En location</option>
        <option value="maintenance">Maintenance</option>
        <option value="endommage">Endommagé</option>
    </select>
    <br><br>

    <label>Catégorie :</label><br>

    <select
        name="categorie_id"
        id="categorie_id"
        required
    >

        <option value="">
            -- Choisir une catégorie --
        </option>

        <?php
        require_once "model/Category.php";

        $categoryModel = new Category($this->pdo);
        $categories = $categoryModel->getAll();

        foreach ($categories as $category):
        ?>

            <option value="<?= $category["id"] ?>">
                <?= htmlspecialchars($category["nom"]) ?>
            </option>

        <?php endforeach; ?>

    </select>

    <br><br>

    <button type="submit">
        Ajouter
    </button>

</form>

<br>

<a href="index.php?action=equipment_list">
    Retour à la liste
</a>

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
            "Le stock doit être un entier positif ou égal à 0."
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