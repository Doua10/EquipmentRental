<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier un équipement</title>
</head>

<body>

<h1>Modifier un équipement</h1>

<?php if (isset($message)): ?>
    <p style="color:red;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form method="POST" action="index.php?action=equipment_edit&id=<?= $equipment["id"] ?>">

    <label>Nom :</label><br>

    <input
        type="text"
        name="nom"
        value="<?= htmlspecialchars($equipment["nom"]) ?>"
        required
    >

    <br><br>

    <label>Description :</label><br>

    <textarea name="description"><?= htmlspecialchars($equipment["description"]) ?></textarea>

    <br><br>

    <label>Prix par jour :</label><br>

    <input
        type="number"
        name="prix_jour"
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
        min="0"
        value="<?= $equipment["stock"] ?>"
        required
    >

    <br><br>

    <label>Seuil d'alerte :</label><br>

    <input
        type="number"
        name="seuil_alerte"
        min="0"
        value="<?= $equipment["seuil_alerte"] ?>"
        required
    >

    <br><br>

    <label>État :</label><br>

    <select name="etat" required>

        <option value="disponible"
            <?= $equipment["etat"] == "disponible" ? "selected" : "" ?>>
            Disponible
        </option>

        <option value="en_location"
            <?= $equipment["etat"] == "en_location" ? "selected" : "" ?>>
            En location
        </option>

        <option value="maintenance"
            <?= $equipment["etat"] == "maintenance" ? "selected" : "" ?>>
            Maintenance
        </option>

        <option value="endommage"
            <?= $equipment["etat"] == "endommage" ? "selected" : "" ?>>
            Endommagé
        </option>

    </select>

    <br><br>

    <label>Catégorie :</label><br>

    <select name="categorie_id" required>

        <?php

        require_once "model/Category.php";

        $categoryModel = new Category($this->pdo);
        $categories = $categoryModel->getAll();

        foreach ($categories as $category):

        ?>

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

<a href="index.php?action=equipment_list">
    Retour à la liste
</a>

</body>
</html>