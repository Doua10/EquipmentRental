<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$statutLabels = [
    "en_attente" => ["En attente", "#f0ad4e"],
    "confirmee"  => ["Confirmée", "#5bc0de"],
    "en_cours"   => ["En cours", "#5cb85c"],
    "terminee"   => ["Terminée", "#777"],
    "annulee"    => ["Annulée", "#d9534f"],
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mes locations</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        header {
            background: #333;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .actions a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            background: #555;
        }

        .actions .logout {
            background: #d9534f;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        .title {
            margin-bottom: 30px;
        }

        .rentals {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .rental-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .rental-card h3 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .info {
            margin: 8px 0;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 5px;
            color: white;
            font-size: 13px;
            margin-top: 10px;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
            margin-top: 12px;
        }

        .empty {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
        }

        @media (max-width: 600px) {

            header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .container {
                margin: 20px auto;
            }
        }
    </style>
</head>

<body>

<header>

    <h1>EquipmentRental</h1>

    <div class="actions">

        <a href="index.php?action=client_catalogue">
            Catalogue
        </a>

        <a href="index.php?action=dashboard">
            Tableau de bord
        </a>

        <a class="logout" href="index.php?action=logout">
            Déconnexion
        </a>

    </div>

</header>


<div class="container">

    <div class="title">
        <h2>Mes locations</h2>
        <p>Historique et suivi de vos demandes de location.</p>
    </div>

    <?php if (!empty($rentals)): ?>

        <div class="rentals">

            <?php foreach ($rentals as $rental): ?>

                <?php
                    $label = $statutLabels[$rental["statut"]][0] ?? $rental["statut"];
                    $color = $statutLabels[$rental["statut"]][1] ?? "#777";
                ?>

                <div class="rental-card">

                    <h3><?= htmlspecialchars($rental["equipment_nom"]) ?></h3>

                    <div class="info">
                        <strong>Période :</strong>
                        <?= htmlspecialchars($rental["date_debut"]) ?> au <?= htmlspecialchars($rental["date_fin"]) ?>
                        (<?= htmlspecialchars($rental["duree"]) ?> jour<?= $rental["duree"] > 1 ? "s" : "" ?>)
                    </div>

                    <?php if (!empty($rental["date_retour"])): ?>
                        <div class="info">
                            <strong>Retour :</strong>
                            <?= htmlspecialchars($rental["date_retour"]) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($rental["frais_additionnels"] > 0): ?>
                        <div class="info">
                            <strong>Frais additionnels :</strong>
                            <?= htmlspecialchars($rental["frais_additionnels"]) ?> DT
                        </div>
                    <?php endif; ?>

                    <div class="price">
                        <?= htmlspecialchars($rental["prix_total"]) ?> DT
                    </div>

                    <span class="badge" style="background: <?= $color ?>;">
                        <?= htmlspecialchars($label) ?>
                    </span>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="empty">
            <h3>Aucune location pour le moment</h3>
            <p>Consultez le catalogue pour faire une demande de location.</p>
        </div>

    <?php endif; ?>

</div>

</body>
</html>
