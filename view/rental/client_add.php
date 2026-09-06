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

    <title>Demander une location</title>

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

        /* ===============================
           HEADER
        =============================== */

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


        /* ===============================
           CONTENU
        =============================== */

        .container {
            max-width: 700px;

            margin: 55px auto;

            padding: 20px;
        }

        .card {
            background: #FFFCFA;

            padding: 32px;

            border-radius: 18px;

            border: 1px solid #F0E3EC;

            box-shadow:
                0 10px 30px rgba(130, 100, 140, 0.10);
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 25px;

            color: #8B6FA8;

            font-size: 28px;
        }


        /* ===============================
           ÉQUIPEMENT
        =============================== */

        .equipment-summary {
            background: #F4EDF9;

            padding: 18px;

            border-radius: 12px;

            margin-bottom: 25px;

            border: 1px solid #E8DCF2;
        }

        .equipment-summary strong {
            display: block;

            color: #715982;

            font-size: 19px;

            margin-bottom: 6px;
        }

        .equipment-summary .price {
            color: #A8657E;

            font-weight: 700;

            font-size: 17px;
        }


        /* ===============================
           FORMULAIRE
        =============================== */

        label {
            display: block;

            margin-top: 18px;
            margin-bottom: 7px;

            font-weight: 700;

            color: #6F6378;
        }

        input[type="date"] {
            width: 100%;

            padding: 12px 14px;

            border: 1px solid #E3D5DF;

            border-radius: 10px;

            background: #FFFDFB;

            color: #4B4654;

            font-size: 15px;

            outline: none;

            transition: 0.2s;
        }

        input[type="date"]:focus {
            border-color: #CFAFDA;

            background: #FFFFFF;

            box-shadow:
                0 0 0 3px rgba(216, 199, 240, 0.35);
        }


        /* ===============================
           BOUTONS
        =============================== */

        .btn {
            display: inline-block;

            margin-top: 25px;

            padding: 12px 20px;

            border: none;

            border-radius: 10px;

            background: #D8C7F0;

            color: #5E4A6E;

            cursor: pointer;

            text-decoration: none;

            font-size: 15px;
            font-weight: 700;

            transition: 0.2s;
        }

        .btn:hover {
            background: #CBB6E8;

            transform: translateY(-1px);

            box-shadow:
                0 5px 14px rgba(139, 111, 168, 0.16);
        }

        .cancel {
            margin-left: 10px;

            background: #F4C7D9;

            color: #654B58;
        }

        .cancel:hover {
            background: #ECB4CB;
        }


        /* ===============================
           MESSAGE D'ERREUR
        =============================== */

        .message {
            background: #FCE8ED;

            color: #9A5B6E;

            padding: 13px 15px;

            border-radius: 10px;

            border: 1px solid #F4C7D9;

            margin-bottom: 20px;
        }


        /* ===============================
           RESPONSIVE
        =============================== */

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

            .card {
                padding: 22px;
            }

            .card h2 {
                font-size: 23px;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .cancel {
                margin-left: 0;
                margin-top: 10px;
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

    <div class="card">

        <h2>Demander une location</h2>

        <?php if (!empty($message)): ?>

            <div class="message">
                <?= htmlspecialchars($message) ?>
            </div>

        <?php endif; ?>


        <div class="equipment-summary">

            <strong>
                <?= htmlspecialchars($equipmentData["nom"]) ?>
            </strong>

            <div class="price">
                <?= htmlspecialchars($equipmentData["prix_jour"]) ?>
                DT / jour
            </div>

        </div>


        <form
            method="POST"
            action="index.php?action=client_rental_add"
        >

            <input
                type="hidden"
                name="equipment_id"
                value="<?= htmlspecialchars($equipment_id) ?>"
            >


            <label for="date_debut">
                Date de début
            </label>

            <input
                type="date"
                id="date_debut"
                name="date_debut"
                required
                value="<?= htmlspecialchars($_POST['date_debut'] ?? '') ?>"
            >


            <label for="date_fin">
                Date de fin
            </label>

            <input
                type="date"
                id="date_fin"
                name="date_fin"
                required
                value="<?= htmlspecialchars($_POST['date_fin'] ?? '') ?>"
            >


            <button
                type="submit"
                class="btn"
            >
                Envoyer la demande
            </button>

            <a
                href="index.php?action=client_catalogue"
                class="btn cancel"
            >
                Annuler
            </a>

        </form>

    </div>

</div>


<script>
    // Contrôle JS côté client
    // + contrôle PHP côté serveur

    const form = document.querySelector("form");

    const debutInput =
        document.getElementById("date_debut");

    const finInput =
        document.getElementById("date_fin");


    form.addEventListener("submit", function (e) {

        const debut =
            new Date(debutInput.value);

        const fin =
            new Date(finInput.value);

        const today =
            new Date();

        today.setHours(0, 0, 0, 0);


        if (
            !debutInput.value ||
            !finInput.value
        ) {

            alert(
                "Veuillez remplir les deux dates."
            );

            e.preventDefault();

            return;
        }


        if (debut < today) {

            alert(
                "La date de début ne peut pas être dans le passé."
            );

            e.preventDefault();

            return;
        }


        if (fin < debut) {

            alert(
                "La date de fin doit être après ou égale à la date de début."
            );

            e.preventDefault();

            return;
        }

    });
</script>

</body>
</html>