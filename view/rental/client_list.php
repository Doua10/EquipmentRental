<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$statutLabels = [
    "en_attente" => ["En attente", "#FCE7C7", "#8A6840"],
    "confirmee"  => ["Confirmée", "#D8C7F0", "#665375"],
    "en_cours"   => ["En cours", "#CDE8D5", "#4E7358"],
    "terminee"   => ["Terminée", "#E8E4EA", "#6B6270"],
    "annulee"    => ["Annulée", "#F4C7D9", "#8D5369"],
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
            font-family: "Segoe UI", Arial, sans-serif;
            background: #FFF9F3;
            color: #4B4654;
            min-height: 100vh;
        }

        header {
            background: #D8C7F0;
            color: #4B4654;
            padding: 20px 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            box-shadow: 0 4px 16px rgba(139, 111, 168, 0.12);
        }

        header h1 {
            margin: 0;
            font-size: 26px;
            color: #6F5C80;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .actions a {
            color: #5E4A6E;
            text-decoration: none;

            padding: 10px 15px;

            border-radius: 10px;

            background: #F4C7D9;

            font-weight: 600;

            transition: 0.2s;
        }

        .actions a:hover {
            background: #ECB4CB;
            transform: translateY(-1px);
        }

        .actions .logout {
            background: #F7C6C7;
            color: #7A4A4A;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        .title {
            margin-bottom: 30px;
        }

        .title h2 {
            margin-bottom: 8px;

            color: #8B6FA8;

            font-size: 30px;
        }

        .title p {
            color: #6F6378;
        }

        .rentals {
            display: grid;

            grid-template-columns:
                repeat(auto-fit, minmax(300px, 1fr));

            gap: 22px;
        }

        .rental-card {
            background: #FFFCFA;

            padding: 24px;

            border-radius: 18px;

            border: 1px solid #F0E3EC;

            box-shadow:
                0 8px 25px rgba(130, 100, 140, 0.08);

            transition: 0.2s;
        }

        .rental-card:hover {
            transform: translateY(-3px);

            box-shadow:
                0 12px 30px rgba(130, 100, 140, 0.12);
        }

        .rental-card h3 {
            margin-top: 0;
            margin-bottom: 15px;

            color: #715982;

            font-size: 22px;
        }

        .info {
            margin: 9px 0;

            color: #6F6378;
        }

        .info strong {
            color: #5E4A6E;
        }

        .price {
            font-size: 21px;
            font-weight: 700;

            margin-top: 15px;

            color: #A8657E;
        }

        .badge {
            display: inline-block;

            padding: 7px 11px;

            border-radius: 20px;

            font-size: 13px;
            font-weight: 700;

            margin-top: 12px;
        }

        .pdf-links {
            display: flex;
            flex-wrap: wrap;

            gap: 8px;

            margin-top: 16px;
        }

        .pdf-links a {
            font-size: 13px;
            font-weight: 600;

            color: #5E4A6E;

            text-decoration: none;

            background: #EDE4F8;

            padding: 7px 11px;

            border-radius: 9px;

            transition: 0.2s;
        }

        .pdf-links a:hover {
            background: #D8C7F0;
            transform: translateY(-1px);
        }

        .empty {
            background: #FFFCFA;

            padding: 28px;

            border-radius: 18px;

            text-align: center;

            border: 1px solid #F0E3EC;

            box-shadow:
                0 8px 25px rgba(130, 100, 140, 0.08);
        }

        .empty h3 {
            color: #715982;
        }

        @media (max-width: 700px) {

            header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
                padding: 18px;
            }

            .actions {
                width: 100%;
                flex-direction: column;
            }

            .actions a {
                width: 100%;
                text-align: center;
            }

            .container {
                margin: 20px auto;
                padding: 14px;
            }

            .title h2 {
                font-size: 24px;
            }

            .rentals {
                grid-template-columns: 1fr;
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
        <p>
            Historique et suivi de vos demandes de location.
        </p>
    </div>

    <?php if (!empty($rentals)): ?>

        <div class="rentals">

            <?php foreach ($rentals as $rental): ?>

                <?php
                    $label =
                        $statutLabels[$rental["statut"]][0]
                        ?? $rental["statut"];

                    $background =
                        $statutLabels[$rental["statut"]][1]
                        ?? "#E8E4EA";

                    $textColor =
                        $statutLabels[$rental["statut"]][2]
                        ?? "#6B6270";
                ?>

                <div class="rental-card">

                    <h3>
                        <?= htmlspecialchars($rental["equipment_nom"]) ?>
                    </h3>

                    <div class="info">
                        <strong>Période :</strong>

                        <?= htmlspecialchars($rental["date_debut"]) ?>
                        au
                        <?= htmlspecialchars($rental["date_fin"]) ?>

                        (
                        <?= htmlspecialchars($rental["duree"]) ?>
                        jour<?= $rental["duree"] > 1 ? "s" : "" ?>
                        )
                    </div>

                    <?php if (!empty($rental["date_retour"])): ?>

                        <div class="info">
                            <strong>Retour :</strong>

                            <?= htmlspecialchars($rental["date_retour"]) ?>
                        </div>

                    <?php endif; ?>

                    <?php if ($rental["frais_additionnels"] > 0): ?>

                        <div class="info">

                            <strong>
                                Frais additionnels :
                            </strong>

                            <?= htmlspecialchars(
                                $rental["frais_additionnels"]
                            ) ?> DT

                        </div>

                    <?php endif; ?>

                    <div class="price">

                        <?= htmlspecialchars(
                            $rental["prix_total"]
                        ) ?> DT

                    </div>

                    <span
                        class="badge"
                        style="
                            background: <?= $background ?>;
                            color: <?= $textColor ?>;
                        "
                    >
                        <?= htmlspecialchars($label) ?>
                    </span>

                    <?php if (
                        in_array(
                            $rental["statut"],
                            ["confirmee", "en_cours", "terminee"]
                        )
                    ): ?>

                        <div class="pdf-links">

                            <a
                                href="index.php?action=pdf_contrat&id=<?= $rental["id"] ?>"
                            >
                                📄 Contrat
                            </a>

                            <a
                                href="index.php?action=pdf_facture&id=<?= $rental["id"] ?>"
                            >
                                🧾 Facture
                            </a>

                            <a
                                href="index.php?action=pdf_recu&id=<?= $rental["id"] ?>"
                            >
                                🧾 Reçu
                            </a>

                        </div>

                    <?php endif; ?>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="empty">

            <h3>
                Aucune location pour le moment
            </h3>

            <p>
                Consultez le catalogue pour faire une demande de location.
            </p>

        </div>

    <?php endif; ?>

</div>

</body>
</html>