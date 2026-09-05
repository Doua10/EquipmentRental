<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="view/backoffice.css">
</head>

<body>

<h1>Liste des utilisateurs</h1>

<a href="index.php?action=user_add">
    ➕ Ajouter un utilisateur
</a>

<br><br>

<form method="GET" action="index.php">

    <input type="hidden" name="action" value="user_search">

    <input
        type="text"
        name="mot"
        placeholder="Rechercher..."
        value="<?= htmlspecialchars($_GET["mot"] ?? "") ?>"
    >

    <button type="submit">
        Rechercher
    </button>

</form>

<br>
<div class="table-wrapper">
<table border="1" cellpadding="8">

    <tr>

        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Rôle</th>
        <th>Date création</th>
        <th>Actions</th>

    </tr>

    <?php foreach ($users as $user): ?>

        <tr>

            <td>
                <?= $user["id"] ?>
            </td>

            <td>
                <?= htmlspecialchars($user["nom"]) ?>
            </td>

            <td>
                <?= htmlspecialchars($user["prenom"]) ?>
            </td>

            <td>
                <?= htmlspecialchars($user["email"]) ?>
            </td>

            <td>
                <?= htmlspecialchars($user["telephone"]) ?>
            </td>

            <td>

                <?php

                if ($user["role"] == "responsable_inventaire") {

                    echo "Responsable Inventaire";

                } elseif ($user["role"] == "agent_location") {

                    echo "Agent Location";

                } else {

                    echo "Client";
                }

                ?>

            </td>

            <td>
                <?= htmlspecialchars($user["date_creation"]) ?>
            </td>

            <td>

                <a href="index.php?action=user_edit&id=<?= $user["id"] ?>">
                    Modifier
                </a>

                |

                <a
                    href="index.php?action=user_delete&id=<?= $user["id"] ?>"
                    onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');"
                >
                    Supprimer
                </a>

            </td>

        </tr>

    <?php endforeach; ?>

</table>
</div>
</body>

</html>