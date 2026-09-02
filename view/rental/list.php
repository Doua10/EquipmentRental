<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des locations</title>
</head>

<body>

<h1>Liste des locations</h1>

<a href="index.php?action=rental_add">
    ➕ Ajouter une location
</a>

<br><br>

<table border="1" cellpadding="8">

    <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Équipement</th>
        <th>Début</th>
        <th>Fin</th>
        <th>Durée (j)</th>
        <th>Prix / jour</th>
        <th>Frais additionnels</th>
        <th>Prix total</th>
        <th>Statut</th>
        <th>Date retour</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($rentals as $rental): ?>

        <tr>

            <td>
                <?= $rental["id"] ?>
            </td>

            <td>
                <?= htmlspecialchars($rental["client_prenom"] . " " . $rental["client_nom"]) ?>
            </td>

            <td>
                <?= htmlspecialchars($rental["equipment_nom"]) ?>
            </td>

            <td>
                <?= htmlspecialchars($rental["date_debut"]) ?>
            </td>

            <td>
                <?= htmlspecialchars($rental["date_fin"]) ?>
            </td>

            <td>
                <?= $rental["duree"] ?>
            </td>

            <td>
                <?= htmlspecialchars($rental["prix_jour"]) ?> DT
            </td>

            <td>
                <?= htmlspecialchars($rental["frais_additionnels"]) ?> DT
            </td>

            <td>
                <strong><?= htmlspecialchars($rental["prix_total"]) ?> DT</strong>
            </td>

            <td>
                <?= htmlspecialchars($rental["statut"]) ?>
            </td>

            <td>
                <?= $rental["date_retour"] ? htmlspecialchars($rental["date_retour"]) : "-" ?>
            </td>

            <td>

                <?php if (in_array($rental["statut"], ["confirmee", "en_cours"])): ?>

                    <a href="index.php?action=rental_return&id=<?= $rental["id"] ?>">
                        <strong>Traiter le retour</strong>
                    </a>

                    |

                <?php endif; ?>

                <a href="index.php?action=rental_edit&id=<?= $rental["id"] ?>">
                    Modifier
                </a>

                |

                
                    href="index.php?action=rental_delete&id=<?= $rental["id"] ?>"
                    onclick="return confirm('Voulez-vous vraiment supprimer cette location ?');"
                >
                    Supprimer
                </a>

            </td>

        </tr>

    <?php endforeach; ?>

</table>

</body>
</html>