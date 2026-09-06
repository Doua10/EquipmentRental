<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Catalogue des équipements</title>

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

        .equipments {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 22px;
        }

        .equipment-card {
            background: #FFFCFA;
            padding: 24px;
            border-radius: 18px;
            border: 1px solid #F0E3EC;
            box-shadow: 0 8px 25px rgba(130, 100, 140, 0.08);
            transition: 0.2s;
        }

        .equipment-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(130, 100, 140, 0.12);
        }

        .equipment-card h3 {
            margin-top: 0;
            color: #715982;
            font-size: 22px;
        }

        .info {
            margin: 10px 0;
            color: #6F6378;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
            color: #A8657E;
        }

        .available {
            display: inline-block;
            margin-top: 15px;
            padding: 7px 11px;
            border-radius: 20px;
            background: #CDE8D5;
            color: #4E7358;
            font-weight: 700;
        }

        .rent-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 16px;
            background: #D8C7F0;
            color: #5E4A6E;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 700;
            transition: 0.2s;
        }

        .rent-btn:hover {
            background: #CBB6E8;
            transform: translateY(-1px);
        }

        .empty {
            background: #FFFCFA;
            padding: 25px;
            border-radius: 16px;
            text-align: center;
            border: 1px solid #F0E3EC;
            box-shadow: 0 8px 25px rgba(130, 100, 140, 0.08);
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

            .equipments {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<header>

    <h1>EquipmentRental</h1>

    <div class="actions">

        <a href="index.php?action=dashboard">
            Tableau de bord
        </a>

        <a href="index.php?action=client_rental_list">
            Mes locations
        </a>

        <a class="logout" href="index.php?action=logout">
            Déconnexion
        </a>

    </div>

</header>

<div class="container">

    <div class="title">

        <h2>Catalogue des équipements</h2>

        <p>
            Découvrez les équipements actuellement disponibles à la location.
        </p>

    </div>

    <?php if (!empty($equipments)): ?>

        <div class="equipments">

            <?php foreach ($equipments as $equipment): ?>

                <div class="equipment-card">

                    <h3>
                        <?= htmlspecialchars($equipment["nom"]) ?>
                    </h3>

                    <div class="info">
                        <strong>Catégorie :</strong>
                        <?= htmlspecialchars($equipment["categorie_nom"]) ?>
                    </div>

                    <div class="info">
                        <strong>Description :</strong>
                        <?= htmlspecialchars($equipment["description"]) ?>
                    </div>

                    <div class="info">
                        <strong>Stock disponible :</strong>
                        <?= htmlspecialchars($equipment["stock"]) ?>
                    </div>

                    <div class="price">
                        <?= htmlspecialchars($equipment["prix_jour"]) ?> DT / jour
                    </div>

                    <span class="available">
                        Disponible
                    </span>

                    <div>
                        <a
                            class="rent-btn"
                            href="index.php?action=client_rental_add&equipment_id=<?= htmlspecialchars($equipment["id"]) ?>"
                        >
                            Demander une location
                        </a>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="empty">

            <h3>Aucun équipement disponible</h3>

            <p>
                Aucun équipement n'est actuellement disponible à la location.
            </p>

        </div>

    <?php endif; ?>

</div>

</body>
</html>