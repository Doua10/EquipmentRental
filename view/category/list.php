<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Catégories</title>
</head>

<body>

<h1>Liste des catégories</h1>

<a href="index.php?action=category_add">
    Ajouter une catégorie
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($categories as $category): ?>

        <tr>

            <td>
                <?= $category['id'] ?>
            </td>

            <td>
                <?= htmlspecialchars($category['nom']) ?>
            </td>

            <td>
                <?= htmlspecialchars($category['description']) ?>
            </td>

            <td>

                <a href="index.php?action=category_edit&id=<?= $category['id'] ?>">
                    Modifier
                </a>

                |

                <a
                    href="index.php?action=category_delete&id=<?= $category['id'] ?>"
                    onclick="return confirm('Voulez-vous supprimer cette catégorie ?')"
                >
                    Supprimer
                </a>

            </td>

        </tr>

    <?php endforeach; ?>

</table>

</body>

</html>