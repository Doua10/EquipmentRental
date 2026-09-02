<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des équipements</title>
</head>

<body>

<h1>Liste des équipements</h1>

<a href="index.php?action=equipment_add">
    ➕ Ajouter un équipement
</a>

<br><br>

<h2>Recherche multicritères</h2>

<?php if (!empty($error)): ?>
    <p style="color:red;">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<form method="GET" action="index.php">

    <input type="hidden" name="action" value="equipment_search">

    <label>Mot-clé :</label>
    <input
        type="text"
        name="mot"
        placeholder="Nom, description ou catégorie"
        value="<?= htmlspecialchars($_GET["mot"] ?? "") ?>"
    >

    <br><br>

    <label>Catégorie :</label>
    <select name="categorie_id">
        <option value="">Toutes les catégories</option>
        <?php foreach (($categories ?? []) as $category): ?>
            <option
                value="<?= $category["id"] ?>"
                <?= (($_GET["categorie_id"] ?? "") == $category["id"]) ? "selected" : "" ?>
            >
                <?= htmlspecialchars($category["nom"]) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <label>État :</label>
    <select name="etat">
        <option value="">Tous les états</option>
        <option value="disponible" <?= (($_GET["etat"] ?? "") === "disponible") ? "selected" : "" ?>>Disponible</option>
        <option value="en_location" <?= (($_GET["etat"] ?? "") === "en_location") ? "selected" : "" ?>>En location</option>
        <option value="maintenance" <?= (($_GET["etat"] ?? "") === "maintenance") ? "selected" : "" ?>>Maintenance</option>
        <option value="endommage" <?= (($_GET["etat"] ?? "") === "endommage") ? "selected" : "" ?>>Endommagé</option>
    </select>

    <br><br>

    <label>Prix min :</label>
    <input
        type="number"
        name="prix_min"
        min="0"
        step="0.01"
        value="<?= htmlspecialchars($_GET["prix_min"] ?? "") ?>"
    >

    <label>Prix max :</label>
    <input
        type="number"
        name="prix_max"
        min="0"
        step="0.01"
        value="<?= htmlspecialchars($_GET["prix_max"] ?? "") ?>"
    >

    <br><br>

    <label>Stock min :</label>
    <input
        type="number"
        name="stock_min"
        min="0"
        value="<?= htmlspecialchars($_GET["stock_min"] ?? "") ?>"
    >

    <label>Stock max :</label>
    <input
        type="number"
        name="stock_max"
        min="0"
        value="<?= htmlspecialchars($_GET["stock_max"] ?? "") ?>"
    >

    <br><br>

    <button type="submit">Rechercher</button>
    <a href="index.php?action=equipment_list">Réinitialiser</a>

</form>

<br>

<table border="1" cellpadding="8">

    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Catégorie</th>
        <th>Prix / jour</th>
        <th>Stock</th>
        <th>Seuil</th>
        <th>État</th>
        <th>Actions</th>
    </tr>

    <?php if (empty($equipments)): ?>
        <tr>
            <td colspan="9">Aucun équipement trouvé.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($equipments as $equipment): ?>
            <tr>
                <td><?= $equipment["id"] ?></td>
                <td><?= htmlspecialchars($equipment["nom"]) ?></td>
                <td><?= htmlspecialchars($equipment["description"]) ?></td>
                <td><?= htmlspecialchars($equipment["categorie_nom"]) ?></td>
                <td><?= htmlspecialchars($equipment["prix_jour"]) ?> DT</td>
                <td>
                    <?= $equipment["stock"] ?>

                    <?php if ($equipment["stock"] == 0): ?>
                        <br>
                        <strong style="color:red;">Rupture de stock</strong>
                    <?php elseif ($equipment["stock"] <= $equipment["seuil_alerte"]): ?>
                        <br>
                        <strong style="color:orange;">Stock faible</strong>
                    <?php endif; ?>
                </td>
                <td><?= $equipment["seuil_alerte"] ?></td>
                <td><?= htmlspecialchars($equipment["etat"]) ?></td>
                <td>
                    <a href="index.php?action=equipment_edit&id=<?= $equipment["id"] ?>">Modifier</a>
                    |
                    <a
                        href="index.php?action=equipment_delete&id=<?= $equipment["id"] ?>"
                        onclick="return confirm('Voulez-vous vraiment supprimer cet équipement ?');"
                    >
                        Supprimer
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

</table>

</body>
</html>
