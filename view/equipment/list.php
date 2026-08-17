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

<form method="GET" action="index.php">

    <input type="hidden" name="action" value="equipment_search">

    <input
        type="text"
        name="mot"
        placeholder="Rechercher un équipement..."
        value="<?= htmlspecialchars($_GET["mot"] ?? "") ?>"
    >

    <button type="submit">Rechercher</button>

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

    <?php foreach ($equipments as $equipment): ?>

        <tr>

            <td>
                <?= $equipment["id"] ?>
            </td>

            <td>
                <?= htmlspecialchars($equipment["nom"]) ?>
            </td>

            <td>
                <?= htmlspecialchars($equipment["description"]) ?>
            </td>

            <td>
                <?= htmlspecialchars($equipment["categorie_nom"]) ?>
            </td>

            <td>
                <?= htmlspecialchars($equipment["prix_jour"]) ?> DT
            </td>

            <td>
                <?= $equipment["stock"] ?>

                <?php if ($equipment["stock"] == 0): ?>

                    <br>
                    <strong style="color:red;">
                        Rupture de stock
                    </strong>

                <?php elseif ($equipment["stock"] <= $equipment["seuil_alerte"]): ?>

                    <br>
                    <strong style="color:orange;">
                        Stock faible
                    </strong>

                <?php endif; ?>

            </td>

            <td>
                <?= $equipment["seuil_alerte"] ?>
            </td>

            <td>
                <?= htmlspecialchars($equipment["etat"]) ?>
            </td>

            <td>

                <a href="index.php?action=equipment_edit&id=<?= $equipment["id"] ?>">
                    Modifier
                </a>

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

</table>

</body>
</html>