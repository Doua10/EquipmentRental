<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des locations</title>
    <link rel="stylesheet" href="view/backoffice.css">
</head>

<body>

<h1>Liste des locations</h1>

<div class="top-actions">

    <a href="index.php?action=dashboard">
        🏠 Tableau de bord
    </a>

    <?php if (
        isset($_SESSION["role"]) &&
        $_SESSION["role"] === "agent_location"
    ): ?>

        <a href="index.php?action=rental_add">
            ➕ Ajouter une location
        </a>

    <?php endif; ?>

</div>

<br><br>
<div class="table-wrapper">
<table border="1" cellpadding="8">

    <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Équipement</th>
        <th>Début</th>
        <th>Fin</th>
        <th>Durée</th>
        <th>Prix / jour</th>
        <th>Frais</th>
        <th>Prix total</th>
        <th>Statut</th>
        <th>Date retour</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($rentals as $rental): ?>

        <tr>

            <td>
                <?= htmlspecialchars($rental["id"]) ?>
            </td>

            <td>
                <?= htmlspecialchars(
                    $rental["client_prenom"] . " " . $rental["client_nom"]
                ) ?>
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
                <?= htmlspecialchars($rental["duree"]) ?> jour(s)
            </td>

            <td>
                <?= htmlspecialchars($rental["prix_jour"]) ?> DT
            </td>

            <td>
                <?= htmlspecialchars($rental["frais_additionnels"]) ?> DT
            </td>

            <td>
                <strong>
                    <?= htmlspecialchars($rental["prix_total"]) ?> DT
                </strong>
            </td>

            <td>
                <?= htmlspecialchars($rental["statut"]) ?>
            </td>

            <td>
                <?php if (!empty($rental["date_retour"])): ?>

                    <?= htmlspecialchars($rental["date_retour"]) ?>

                <?php else: ?>

                    -

                <?php endif; ?>
            </td>

            <td>

    <?php if (
        in_array($rental["statut"], ["confirmee", "en_cours"]) &&
        isset($_SESSION["role"]) &&
        in_array(
            $_SESSION["role"],
            ["responsable_inventaire", "agent_location"]
        )
    ): ?>

        <a href="index.php?action=rental_return&id=<?= $rental["id"] ?>">
            Traiter le retour
        </a>

        |

    <?php endif; ?>


    <?php if (
        isset($_SESSION["role"]) &&
        $_SESSION["role"] === "agent_location"
    ): ?>

        <a href="index.php?action=rental_edit&id=<?= $rental["id"] ?>">
            Modifier
        </a>

        |

        <a
            href="index.php?action=rental_delete&id=<?= $rental["id"] ?>"
            onclick="return confirm('Voulez-vous vraiment supprimer cette location ?');"
        >
            Supprimer
        </a>

        |

    <?php endif; ?>


    <a href="index.php?action=pdf_contrat&id=<?= $rental["id"] ?>">
        📄 Contrat PDF
    </a>

    |

    <a href="index.php?action=pdf_facture&id=<?= $rental["id"] ?>">
        🧾 Facture PDF
    </a>

    |

    <a href="index.php?action=pdf_recu&id=<?= $rental["id"] ?>">
        🧾 Reçu PDF
    </a>

</td>

        </tr>

    <?php endforeach; ?>

</table>
</div>
</body>

</html>