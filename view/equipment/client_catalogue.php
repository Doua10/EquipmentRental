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

        .title h2 {
            margin-bottom: 8px;
        }

        .equipments {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .equipment-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .equipment-card h3 {
            margin-top: 0;
        }

        .info {
            margin: 10px 0;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
        }

        .available {
            display: inline-block;
            margin-top: 15px;
            padding: 6px 10px;
            border-radius: 5px;
            background: #5cb85c;
            color: white;
        }

        .rent-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 14px;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
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
                        <a class="rent-btn" href="index.php?action=client_rental_add&equipment_id=<?= htmlspecialchars($equipment["id"]) ?>">
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