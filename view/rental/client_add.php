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
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .card h2 {
            margin-top: 0;
        }

        .equipment-summary {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .equipment-summary .price {
            font-weight: bold;
            margin-top: 5px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 20px;
            background: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 15px;
        }

        .cancel {
            margin-left: 10px;
            background: #999;
        }

        .message {
            background: #f2dede;
            color: #a94442;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
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
            <strong><?= htmlspecialchars($equipmentData["nom"]) ?></strong>
            <div class="price">
                <?= htmlspecialchars($equipmentData["prix_jour"]) ?> DT / jour
            </div>
        </div>

        <form method="POST" action="index.php?action=client_rental_add">

            <input type="hidden" name="equipment_id" value="<?= htmlspecialchars($equipment_id) ?>">

            <label for="date_debut">Date de début</label>
            <input type="date" id="date_debut" name="date_debut" required
                   value="<?= htmlspecialchars($_POST['date_debut'] ?? '') ?>">

            <label for="date_fin">Date de fin</label>
            <input type="date" id="date_fin" name="date_fin" required
                   value="<?= htmlspecialchars($_POST['date_fin'] ?? '') ?>">

            <button type="submit" class="btn">Envoyer la demande</button>
            <a href="index.php?action=client_catalogue" class="btn cancel">Annuler</a>

        </form>

    </div>

</div>

<script>
    // Contrôle JS côté client en plus du contrôle PHP côté serveur
    const form = document.querySelector("form");
    const debutInput = document.getElementById("date_debut");
    const finInput = document.getElementById("date_fin");

    form.addEventListener("submit", function (e) {
        const debut = new Date(debutInput.value);
        const fin = new Date(finInput.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        if (!debutInput.value || !finInput.value) {
            alert("Veuillez remplir les deux dates.");
            e.preventDefault();
            return;
        }

        if (debut < today) {
            alert("La date de début ne peut pas être dans le passé.");
            e.preventDefault();
            return;
        }

        if (fin < debut) {
            alert("La date de fin doit être après la date de début.");
            e.preventDefault();
        }
    });
</script>

</body>
</html>
