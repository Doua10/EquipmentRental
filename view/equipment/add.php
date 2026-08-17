<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un équipement</title>
</head>

<body>

<h1>Ajouter un équipement</h1>

<?php if (isset($message)): ?>
    <p style="color:red;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form method="POST" action="index.php?action=equipment_add">

    <label>Nom :</label><br>
    <input type="text" name="nom" required>
    <br><br>

    <label>Description :</label><br>
    <textarea name="description"></textarea>
    <br><br>

    <label>Prix par jour :</label><br>
    <input type="number" name="prix_jour" step="0.01" min="0.01" required>
    <br><br>

    <label>Stock :</label><br>
    <input type="number" name="stock" min="0" required>
    <br><br>

    <label>Seuil d'alerte :</label><br>
    <input type="number" name="seuil_alerte" min="0" required>
    <br><br>

    <label>État :</label><br>
    <select name="etat" required>
        <option value="">-- Choisir --</option>
        <option value="disponible">Disponible</option>
        <option value="en_location">En location</option>
        <option value="maintenance">Maintenance</option>
        <option value="endommage">Endommagé</option>
    </select>
    <br><br>

    <label>Catégorie :</label><br>
    <select name="categorie_id" required>

        <option value="">-- Choisir une catégorie --</option>

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

    <button type="submit">Ajouter</button>

</form>

<br>

<a href="index.php?action=equipment_list">
    Retour à la liste
</a>

</body>
</html>